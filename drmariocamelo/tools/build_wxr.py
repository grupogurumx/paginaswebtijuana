# -*- coding: utf-8 -*-
"""Build the WordPress WXR import file for drmariocamelo.com.

Usage:  python3 drmariocamelo/tools/build_wxr.py [site_url]
Output: drmariocamelo/import/drmariocamelo-wordpress-import.xml
"""

import os
import sys
from xml.sax.saxutils import escape

HERE = os.path.dirname(os.path.abspath(__file__))
sys.path.insert(0, HERE)

from content_pages import PAGES  # noqa: E402
from content_posts import POSTS, CATEGORIES  # noqa: E402

SITE = (sys.argv[1] if len(sys.argv) > 1 else "https://drmariocamelo.com").rstrip("/")
THEME_IMG = SITE + "/wp-content/themes/drmariocamelo/assets/img/"
IMG_DIR = os.path.join(HERE, "..", "wp-theme", "drmariocamelo", "assets", "img")
OUT = os.path.join(HERE, "..", "import", "drmariocamelo-wordpress-import.xml")
AUTHOR = "drmariocamelo"
PUB = "Fri, 24 Oct 2026 09:00:00 +0000"

IMG_ALT = {
    "dr-camelo-quirofano-1.jpg": ("Dr. Mario Camelo in the operating room in Tijuana", "Dr. Mario Camelo en quirófano en Tijuana"),
    "dr-camelo-laparoscopia-2.jpg": ("Dr. Mario Camelo performing laparoscopic bariatric surgery", "Dr. Mario Camelo realizando cirugía bariátrica laparoscópica"),
    "blog-riesgos-automedicacion.jpg": ("Risks of self-medicating for weight loss — Dr. Mario Camelo", "Riesgos de la automedicación para bajar de peso — Dr. Mario Camelo"),
    "blog-complicaciones-vesicula.jpg": ("Complications of untreated gallstones", "Complicaciones de piedras en la vesícula"),
    "blog-bariatrica-vesicula.jpg": ("Bariatric surgery and gallstones", "Cirugía bariátrica y piedras en la vesícula"),
}


def cdata(text):
    return "<![CDATA[" + text.replace("]]>", "]]]]><![CDATA[>") + "]]>"


def meta(key, value):
    return "\t\t<wp:postmeta>\n\t\t\t<wp:meta_key>{}</wp:meta_key>\n\t\t\t<wp:meta_value>{}</wp:meta_value>\n\t\t</wp:postmeta>\n".format(
        cdata(key), cdata(str(value))
    )


class Ids:
    def __init__(self):
        self.n = 100

    def next(self):
        self.n += 1
        return self.n


ids = Ids()
items = []
attachments = {}


def add_attachment(filename):
    if filename in attachments:
        return attachments[filename]
    if not os.path.exists(os.path.join(IMG_DIR, filename)):
        return None
    pid = ids.next()
    alt = IMG_ALT.get(filename, (filename, filename))[0]
    slug = os.path.splitext(filename)[0]
    url = THEME_IMG + filename
    mime = "image/png" if filename.endswith(".png") else "image/jpeg"
    xml = f"""\t<item>
\t\t<title>{cdata(alt)}</title>
\t\t<link>{escape(url)}</link>
\t\t<pubDate>{PUB}</pubDate>
\t\t<dc:creator>{cdata(AUTHOR)}</dc:creator>
\t\t<guid isPermaLink="false">{escape(url)}</guid>
\t\t<description></description>
\t\t<content:encoded>{cdata('')}</content:encoded>
\t\t<excerpt:encoded>{cdata(alt)}</excerpt:encoded>
\t\t<wp:post_id>{pid}</wp:post_id>
\t\t<wp:post_date>{cdata('2026-10-01 08:00:00')}</wp:post_date>
\t\t<wp:post_date_gmt>{cdata('2026-10-01 08:00:00')}</wp:post_date_gmt>
\t\t<wp:comment_status>{cdata('closed')}</wp:comment_status>
\t\t<wp:ping_status>{cdata('closed')}</wp:ping_status>
\t\t<wp:post_name>{cdata(slug)}</wp:post_name>
\t\t<wp:status>{cdata('inherit')}</wp:status>
\t\t<wp:post_parent>0</wp:post_parent>
\t\t<wp:menu_order>0</wp:menu_order>
\t\t<wp:post_type>{cdata('attachment')}</wp:post_type>
\t\t<wp:post_password>{cdata('')}</wp:post_password>
\t\t<wp:is_sticky>0</wp:is_sticky>
\t\t<wp:post_mime_type>{cdata(mime)}</wp:post_mime_type>
\t\t<wp:attachment_url>{cdata(url)}</wp:attachment_url>
{meta('_wp_attachment_image_alt', alt)}\t</item>
"""
    items.append(xml)
    attachments[filename] = pid
    return pid


def item(post_type, pid, d, lang, translation, parent=0, date=None, thumb=None, extra_meta=None, cats=(), tags=()):
    if date is None:
        # Unique timestamps: the importer treats same title + date as a duplicate.
        date = "2026-10-01 08:%02d:00" % (pid % 60)
    path = d["slug"] if not parent else "es/" + d["slug"]
    link = SITE + "/" + ("" if d["slug"] == "home" else path + "/")
    if post_type == "post":
        link = SITE + "/" + d["slug"] + "/"
    m = ""
    m += meta("_dmc_lang", lang)
    if translation:
        m += meta("_dmc_translation", translation)
    if d.get("subtitle"):
        m += meta("_dmc_subtitle", d["subtitle"])
    if d.get("template"):
        m += meta("_wp_page_template", d["template"])
    m += meta("_yoast_wpseo_title", d["seo_title"])
    m += meta("_yoast_wpseo_metadesc", d["seo_desc"])
    m += meta("_yoast_wpseo_focuskw", d["focus"])
    m += meta("rank_math_title", d["seo_title"])
    m += meta("rank_math_description", d["seo_desc"])
    m += meta("rank_math_focus_keyword", d["focus"])
    if d.get("noindex"):
        m += meta("_yoast_wpseo_meta-robots-noindex", "1")
        m += meta("rank_math_robots", 'a:1:{i:0;s:7:"noindex";}')
    if thumb:
        m += meta("_thumbnail_id", thumb)
    for k, v in (extra_meta or {}).items():
        m += meta(k, v)
    terms = ""
    for c in cats:
        terms += f'\t\t<category domain="category" nicename="{escape(c[0])}">{cdata(c[1])}</category>\n'
    for t in tags:
        slug = t.lower().replace(" ", "-")
        terms += f'\t\t<category domain="post_tag" nicename="{escape(slug)}">{cdata(t)}</category>\n'
    gmt = date
    items.append(
        f"""\t<item>
\t\t<title>{cdata(d['title'])}</title>
\t\t<link>{escape(link)}</link>
\t\t<pubDate>{PUB}</pubDate>
\t\t<dc:creator>{cdata(AUTHOR)}</dc:creator>
\t\t<guid isPermaLink="false">{escape(SITE)}/?p={pid}</guid>
\t\t<description></description>
\t\t<content:encoded>{cdata(d['content'].strip())}</content:encoded>
\t\t<excerpt:encoded>{cdata(d.get('excerpt', ''))}</excerpt:encoded>
\t\t<wp:post_id>{pid}</wp:post_id>
\t\t<wp:post_date>{cdata(date)}</wp:post_date>
\t\t<wp:post_date_gmt>{cdata(gmt)}</wp:post_date_gmt>
\t\t<wp:comment_status>{cdata('closed')}</wp:comment_status>
\t\t<wp:ping_status>{cdata('closed')}</wp:ping_status>
\t\t<wp:post_name>{cdata(d['slug'])}</wp:post_name>
\t\t<wp:status>{cdata('publish')}</wp:status>
\t\t<wp:post_parent>{parent}</wp:post_parent>
\t\t<wp:menu_order>{d.get('order', 0)}</wp:menu_order>
\t\t<wp:post_type>{cdata(post_type)}</wp:post_type>
\t\t<wp:post_password>{cdata('')}</wp:post_password>
\t\t<wp:is_sticky>0</wp:is_sticky>
{terms}{m}\t</item>
"""
    )


def build():
    # Attachments first so thumbnails resolve.
    for f in sorted(os.listdir(IMG_DIR)):
        if f.lower().endswith((".jpg", ".jpeg", ".png", ".webp")):
            add_attachment(f)

    # Pages. The Spanish home ("es") is the parent of every Spanish page.
    es_home_id = None
    page_ids = {}
    for p in PAGES:
        page_ids[p["key"]] = (ids.next(), ids.next())
    es_home_id = page_ids["home"][1]

    for p in PAGES:
        en, es = p["en"], p["es"]
        en_id, es_id = page_ids[p["key"]]
        thumb = attachments.get(p.get("thumb")) if p.get("thumb") else None
        extra = {"_dmc_schema": p["schema"]} if p.get("schema") else {}
        es_path = "es" if p["key"] == "home" else "es/" + es["slug"]
        item("page", en_id, en, "en", es_path, thumb=thumb, extra_meta=extra)
        item("page", es_id, es, "es", en["slug"], parent=0 if p["key"] == "home" else es_home_id, thumb=thumb, extra_meta=extra)

    # Posts.
    for post in POSTS:
        thumb = attachments.get(post["thumb"])
        en, es = post["en"], post["es"]
        en_cats = [(c, CATEGORIES[c][0]) for c in post["cats"]]
        es_cats = [("es-" + c, CATEGORIES[c][1]) for c in post["cats"]]
        item("post", ids.next(), en, "en", es["slug"], date=post["date"], thumb=thumb, cats=en_cats, tags=en["tags"])
        item("post", ids.next(), es, "es", en["slug"], date=post["date"], thumb=thumb, cats=es_cats, tags=es["tags"])

    cats_xml = ""
    tid = 10
    for slug, (en_name, es_name) in CATEGORIES.items():
        for s, n in ((slug, en_name), ("es-" + slug, es_name)):
            tid += 1
            cats_xml += f"\t<wp:category>\n\t\t<wp:term_id>{tid}</wp:term_id>\n\t\t<wp:category_nicename>{cdata(s)}</wp:category_nicename>\n\t\t<wp:category_parent>{cdata('')}</wp:category_parent>\n\t\t<wp:cat_name>{cdata(n)}</wp:cat_name>\n\t</wp:category>\n"

    head = f"""<?xml version="1.0" encoding="UTF-8" ?>
<!-- WordPress eXtended RSS (WXR) import for drmariocamelo.com -->
<!-- Tools > Import > WordPress. Activate the "Dr. Mario Camelo" theme BEFORE importing. -->
<rss version="2.0"
\txmlns:excerpt="http://wordpress.org/export/1.2/excerpt/"
\txmlns:content="http://purl.org/rss/1.0/modules/content/"
\txmlns:wfw="http://wellformedweb.org/CommentAPI/"
\txmlns:dc="http://purl.org/dc/elements/1.1/"
\txmlns:wp="http://wordpress.org/export/1.2/"
>
<channel>
\t<title>Dr. Mario Camelo | Bariatric Surgery Tijuana</title>
\t<link>{SITE}</link>
\t<description>Bariatric Surgery &amp; Metabolic Medicine in Tijuana</description>
\t<pubDate>{PUB}</pubDate>
\t<language>en-US</language>
\t<wp:wxr_version>1.2</wp:wxr_version>
\t<wp:base_site_url>{SITE}</wp:base_site_url>
\t<wp:base_blog_url>{SITE}</wp:base_blog_url>
\t<wp:author>
\t\t<wp:author_id>1</wp:author_id>
\t\t<wp:author_login>{cdata(AUTHOR)}</wp:author_login>
\t\t<wp:author_email>{cdata('')}</wp:author_email>
\t\t<wp:author_display_name>{cdata('Dr. Mario Camelo')}</wp:author_display_name>
\t\t<wp:author_first_name>{cdata('Mario')}</wp:author_first_name>
\t\t<wp:author_last_name>{cdata('Camelo')}</wp:author_last_name>
\t</wp:author>
{cats_xml}\t<generator>https://wordpress.org/?v=6.6</generator>
"""
    os.makedirs(os.path.dirname(OUT), exist_ok=True)
    with open(OUT, "w", encoding="utf-8") as fh:
        fh.write(head + "".join(items) + "</channel>\n</rss>\n")
    print("Wrote", os.path.relpath(OUT), "-", len(items), "items")


if __name__ == "__main__":
    build()
