#!/usr/bin/env python3
"""Genera los archivos WXR (WordPress eXtended RSS) de Acabados Contemporáneos.

Lee content/{es,en}/{pages,posts}/*.html. Cada archivo abre con un comentario
JSON de metadatos y sigue con HTML simple, que se convierte a bloques de
Gutenberg (párrafos, encabezados, listas, tablas, citas, shortcodes).

Salida en wordpress-import/:
  acabados-contemporaneos-wxr.xml   páginas + blog (todo)
  acabados-paginas.xml              solo páginas
  acabados-blog.xml                 solo entradas

Uso: python3 tools/build_wxr.py [--site https://acabadoscontemporaneos.com]
"""

import argparse
import json
import re
from email.utils import format_datetime
from datetime import datetime, timezone, timedelta
from pathlib import Path
from xml.sax.saxutils import escape

ROOT = Path(__file__).resolve().parent.parent
CONTENT = ROOT / "content"
OUT = ROOT / "wordpress-import"
TZ = timezone(timedelta(hours=-6))

META_RE = re.compile(r"^\s*<!--(\{.*?\})-->\s*", re.S)
TAG_RE = re.compile(r"<(/?)([a-zA-Z0-9]+)([^>]*)>")


# --------------------------------------------------------------------------
# HTML simple -> bloques de Gutenberg
# --------------------------------------------------------------------------
def top_level_chunks(html):
    """Separa el HTML en elementos de primer nivel y líneas de shortcode."""
    chunks, i, n = [], 0, len(html)
    while i < n:
        while i < n and html[i].isspace():
            i += 1
        if i >= n:
            break
        if html[i] == "[":
            end = html.find("]", i)
            chunks.append(("shortcode", html[i:end + 1]))
            i = end + 1
            continue
        m = TAG_RE.match(html, i)
        if not m:
            end = html.find("\n", i)
            end = n if end == -1 else end
            chunks.append(("text", html[i:end].strip()))
            i = end
            continue
        tag, depth, j = m.group(2).lower(), 0, i
        for t in TAG_RE.finditer(html, i):
            if t.group(2).lower() != tag:
                continue
            depth += -1 if t.group(1) else 1
            if depth == 0:
                j = t.end()
                break
        chunks.append((tag, html[i:j]))
        i = j
    return chunks


def class_of(chunk):
    m = re.match(r"<[a-z0-9]+[^>]*\sclass=\"([^\"]+)\"", chunk)
    return m.group(1) if m else ""


def attrs_json(d):
    return (" " + json.dumps(d, ensure_ascii=False, separators=(",", ":"))) if d else ""


def to_blocks(html):
    out = []
    for kind, chunk in top_level_chunks(html):
        cls = class_of(chunk)
        if kind == "shortcode":
            out.append(f"<!-- wp:shortcode -->\n{chunk}\n<!-- /wp:shortcode -->")
        elif kind == "p":
            out.append(f"<!-- wp:paragraph{attrs_json({'className': cls} if cls else {})} -->\n{chunk}\n<!-- /wp:paragraph -->")
        elif kind in ("h2", "h3", "h4"):
            level = int(kind[1])
            inner = re.sub(r"^<h\d[^>]*>|</h\d>$", "", chunk)
            attrs = {} if level == 2 else {"level": level}
            out.append(f"<!-- wp:heading{attrs_json(attrs)} -->\n<{kind} class=\"wp-block-heading\">{inner}</{kind}>\n<!-- /wp:heading -->")
        elif kind == "ul" or kind == "ol":
            items = re.findall(r"<li>(.*?)</li>", chunk, re.S)
            lis = "".join(f"<!-- wp:list-item -->\n<li>{li.strip()}</li>\n<!-- /wp:list-item -->" for li in items)
            attrs = {}
            if cls:
                attrs["className"] = cls
            if kind == "ol":
                attrs["ordered"] = True
            cls_attr = f"wp-block-list {cls}".strip()
            out.append(f"<!-- wp:list{attrs_json(attrs)} -->\n<{kind} class=\"{cls_attr}\">{lis}</{kind}>\n<!-- /wp:list -->")
        elif kind == "table":
            out.append(f"<!-- wp:table -->\n<figure class=\"wp-block-table\">{chunk}</figure>\n<!-- /wp:table -->")
        elif kind == "blockquote":
            inner = re.sub(r"^<blockquote[^>]*>|</blockquote>$", "", chunk).strip()
            out.append(
                "<!-- wp:quote -->\n<blockquote class=\"wp-block-quote\"><!-- wp:paragraph -->\n"
                f"<p>{inner}</p>\n<!-- /wp:paragraph --></blockquote>\n<!-- /wp:quote -->"
            )
        elif kind == "text" and chunk:
            out.append(f"<!-- wp:paragraph -->\n<p>{chunk}</p>\n<!-- /wp:paragraph -->")
        else:
            out.append(f"<!-- wp:html -->\n{chunk}\n<!-- /wp:html -->")
    return "\n\n".join(out)


# --------------------------------------------------------------------------
# Lectura de contenido
# --------------------------------------------------------------------------
def load(lang, kind):
    items = []
    for f in sorted((CONTENT / lang / kind).glob("*.html")):
        raw = f.read_text(encoding="utf-8")
        m = META_RE.match(raw)
        if not m:
            raise SystemExit(f"{f}: falta el bloque de metadatos JSON")
        meta = json.loads(m.group(1))
        meta["lang"] = lang
        meta["kind"] = kind
        meta["body"] = to_blocks(raw[m.end():].strip())
        meta["source"] = f.relative_to(ROOT).as_posix()
        items.append(meta)
    return items


def cdata(s):
    return "<![CDATA[" + s.replace("]]>", "]]]]><![CDATA[>") + "]]>"


def postmeta(key, value):
    return f"\t\t<wp:postmeta>\n\t\t\t<wp:meta_key>{cdata(key)}</wp:meta_key>\n\t\t\t<wp:meta_value>{cdata(str(value))}</wp:meta_value>\n\t\t</wp:postmeta>\n"


def assign_ids(items):
    """IDs, rutas jerárquicas y padres, comunes a todos los archivos de salida."""
    pages = [i for i in items if i["kind"] == "pages"]
    path_of = {}
    next_id = 1001
    for p in pages:
        p["id"] = next_id
        next_id += 1
        parent = p.get("parent", "")
        p["path"] = f"{parent}/{p['slug']}" if parent else p["slug"]
        path_of[p["path"]] = p
    for p in pages:
        parent = p.get("parent", "")
        p["parent_id"] = path_of[parent]["id"] if parent else 0
    for post in [i for i in items if i["kind"] == "posts"]:
        post["id"] = next_id
        next_id += 1
        post["path"] = post["slug"]


def build(site, items, title_suffix):
    now = datetime(2026, 10, 27, 9, 0, tzinfo=TZ)
    tags = sorted({(t, item["lang"]) for item in items if item["kind"] == "posts" for t in item.get("tags", [])})

    head = [
        '<?xml version="1.0" encoding="UTF-8" ?>',
        "<!-- Archivo de importación de WordPress (WXR 1.2) para Acabados Contemporáneos. -->",
        "<!-- Importar en: Herramientas > Importar > WordPress. Generado por tools/build_wxr.py -->",
        '<rss version="2.0" xmlns:excerpt="http://wordpress.org/export/1.2/excerpt/" '
        'xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:wfw="http://wellformedweb.org/CommentAPI/" '
        'xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:wp="http://wordpress.org/export/1.2/">',
        "<channel>",
        f"\t<title>Acabados Contemporáneos{title_suffix}</title>",
        f"\t<link>{site}</link>",
        "\t<description>Recubrimientos, cerámica y porcelanato en México</description>",
        f"\t<pubDate>{format_datetime(now)}</pubDate>",
        "\t<language>es-MX</language>",
        "\t<wp:wxr_version>1.2</wp:wxr_version>",
        f"\t<wp:base_site_url>{site}</wp:base_site_url>",
        f"\t<wp:base_blog_url>{site}</wp:base_blog_url>",
        "\t<wp:author><wp:author_id>1</wp:author_id><wp:author_login><![CDATA[acabados]]></wp:author_login>"
        "<wp:author_email><![CDATA[]]></wp:author_email><wp:author_display_name><![CDATA[Acabados Contemporáneos]]></wp:author_display_name>"
        "<wp:author_first_name><![CDATA[]]></wp:author_first_name><wp:author_last_name><![CDATA[]]></wp:author_last_name></wp:author>",
    ]
    if any(i["kind"] == "posts" for i in items):
        head += [
            "\t<wp:category><wp:term_id>2</wp:term_id><wp:category_nicename><![CDATA[blog]]></wp:category_nicename>"
            "<wp:category_parent><![CDATA[]]></wp:category_parent><wp:cat_name><![CDATA[Blog]]></wp:cat_name>"
            "<wp:category_description><![CDATA[Guías de experto, tendencias y consejos sobre recubrimientos, porcelanato y cerámica.]]></wp:category_description>"
            "<wp:termmeta><wp:meta_key><![CDATA[_ac_lang]]></wp:meta_key><wp:meta_value><![CDATA[es]]></wp:meta_value></wp:termmeta></wp:category>",
            "\t<wp:category><wp:term_id>3</wp:term_id><wp:category_nicename><![CDATA[blog-en]]></wp:category_nicename>"
            "<wp:category_parent><![CDATA[]]></wp:category_parent><wp:cat_name><![CDATA[Blog (EN)]]></wp:cat_name>"
            "<wp:category_description><![CDATA[Expert guides, trends and tips on tile, porcelain and ceramics.]]></wp:category_description>"
            "<wp:termmeta><wp:meta_key><![CDATA[_ac_lang]]></wp:meta_key><wp:meta_value><![CDATA[en]]></wp:meta_value></wp:termmeta></wp:category>",
        ]
        for k, (tag, _lang) in enumerate(tags):
            slug = re.sub(r"[^a-z0-9]+", "-", tag.lower()
                          .translate(str.maketrans("áéíóúñü", "aeiounu"))).strip("-")
            head.append(f"\t<wp:tag><wp:term_id>{100 + k}</wp:term_id><wp:tag_slug>{cdata(slug)}</wp:tag_slug><wp:tag_name>{cdata(tag)}</wp:tag_name></wp:tag>")

    body = []
    for item in items:
        is_post = item["kind"] == "posts"
        date = datetime.strptime(item.get("date", "2026-10-27 09:00:00"), "%Y-%m-%d %H:%M:%S").replace(tzinfo=TZ)
        date_gmt = date.astimezone(timezone.utc)
        link = f"{site}/{item['path'].strip('/')}/" if item["path"] != "inicio" else f"{site}/"
        lines = [
            "\t<item>",
            f"\t\t<title>{cdata(item['title'])}</title>",
            f"\t\t<link>{escape(link)}</link>",
            f"\t\t<pubDate>{format_datetime(date)}</pubDate>",
            "\t\t<dc:creator><![CDATA[acabados]]></dc:creator>",
            f"\t\t<guid isPermaLink=\"false\">{site}/?{'p' if is_post else 'page_id'}={item['id']}</guid>",
            "\t\t<description></description>",
            f"\t\t<content:encoded>{cdata(item['body'])}</content:encoded>",
            f"\t\t<excerpt:encoded>{cdata(item.get('excerpt', ''))}</excerpt:encoded>",
            f"\t\t<wp:post_id>{item['id']}</wp:post_id>",
            f"\t\t<wp:post_date>{cdata(date.strftime('%Y-%m-%d %H:%M:%S'))}</wp:post_date>",
            f"\t\t<wp:post_date_gmt>{cdata(date_gmt.strftime('%Y-%m-%d %H:%M:%S'))}</wp:post_date_gmt>",
            f"\t\t<wp:post_modified>{cdata(date.strftime('%Y-%m-%d %H:%M:%S'))}</wp:post_modified>",
            f"\t\t<wp:post_modified_gmt>{cdata(date_gmt.strftime('%Y-%m-%d %H:%M:%S'))}</wp:post_modified_gmt>",
            "\t\t<wp:comment_status><![CDATA[closed]]></wp:comment_status>",
            "\t\t<wp:ping_status><![CDATA[closed]]></wp:ping_status>",
            f"\t\t<wp:post_name>{cdata(item['slug'])}</wp:post_name>",
            "\t\t<wp:status><![CDATA[publish]]></wp:status>",
            f"\t\t<wp:post_parent>{item.get('parent_id', 0)}</wp:post_parent>",
            f"\t\t<wp:menu_order>{item.get('order', 0)}</wp:menu_order>",
            f"\t\t<wp:post_type>{cdata('post' if is_post else 'page')}</wp:post_type>",
            "\t\t<wp:post_password><![CDATA[]]></wp:post_password>",
            "\t\t<wp:is_sticky>0</wp:is_sticky>",
        ]
        if is_post:
            cat = "blog-en" if item["lang"] == "en" else "blog"
            name = "Blog (EN)" if item["lang"] == "en" else "Blog"
            lines.append(f"\t\t<category domain=\"category\" nicename=\"{cat}\">{cdata(name)}</category>")
            for tag in item.get("tags", []):
                slug = re.sub(r"[^a-z0-9]+", "-", tag.lower().translate(str.maketrans("áéíóúñü", "aeiounu"))).strip("-")
                lines.append(f"\t\t<category domain=\"post_tag\" nicename=\"{slug}\">{cdata(tag)}</category>")
        meta = ""
        if not is_post:
            meta += postmeta("_wp_page_template", item.get("template") or "default")
        meta += postmeta("_ac_lang", item["lang"])
        if item.get("translation"):
            meta += postmeta("_ac_translation", item["translation"])
        if item.get("image"):
            meta += postmeta("_ac_image", item["image"])
        if item.get("subtitle"):
            meta += postmeta("_ac_subtitle", item["subtitle"])
        if item.get("hide_cta"):
            meta += postmeta("_ac_hide_cta", "1")
        if item.get("seo_title"):
            meta += postmeta("_ac_seo_title", item["seo_title"])
            meta += postmeta("_yoast_wpseo_title", item["seo_title"])
            meta += postmeta("rank_math_title", item["seo_title"])
        if item.get("meta"):
            meta += postmeta("_ac_meta_description", item["meta"])
            meta += postmeta("_yoast_wpseo_metadesc", item["meta"])
            meta += postmeta("rank_math_description", item["meta"])
        if item.get("focus"):
            meta += postmeta("_yoast_wpseo_focuskw", item["focus"])
            meta += postmeta("rank_math_focus_keyword", item["focus"])
        body.append("\n".join(lines) + "\n" + meta + "\t</item>")

    return "\n".join(head) + "\n" + "\n".join(body) + "\n</channel>\n</rss>\n"


def main():
    ap = argparse.ArgumentParser()
    ap.add_argument("--site", default="https://acabadoscontemporaneos.com")
    args = ap.parse_args()
    site = args.site.rstrip("/")

    pages = load("es", "pages") + load("en", "pages")
    # Las páginas padre deben aparecer antes que sus hijas.
    pages.sort(key=lambda p: (p.get("parent", "").count("/") + (1 if p.get("parent") else 0)))
    posts = load("es", "posts") + load("en", "posts")
    assign_ids(pages + posts)

    OUT.mkdir(exist_ok=True)
    outputs = {
        "acabados-contemporaneos-wxr.xml": (pages + posts, ""),
        "acabados-paginas.xml": (pages, " — Páginas"),
        "acabados-blog.xml": (posts, " — Blog"),
    }
    for name, (items, suffix) in outputs.items():
        xml = build(site, items, suffix)
        (OUT / name).write_text(xml, encoding="utf-8")
        print(f"{name}: {len([i for i in items if i['kind'] == 'pages'])} páginas, "
              f"{len([i for i in items if i['kind'] == 'posts'])} entradas")


if __name__ == "__main__":
    main()
