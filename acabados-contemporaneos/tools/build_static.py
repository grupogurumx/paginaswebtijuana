#!/usr/bin/env python3
"""Genera la versión estática del sitio (para Vercel u otro hosting estático).

Renderiza cada página y entrada de content/ con las plantillas reales del tema
(tools/static/render-page.php) y escribe el resultado en vercel/public/:

  /index.html, /nosotros/index.html, /en/index.html, /<entrada>/index.html,
  /404.html, /assets/{css,js}/, /sitemap.xml, /robots.txt

Las imágenes NO se versionan: Vercel las descarga al compilar
(vercel/fetch-images.mjs). Requiere PHP 7.4+.

Uso: python3 tools/build_static.py
"""

import json
import re
import shutil
import subprocess
import tempfile
from pathlib import Path

ROOT = Path(__file__).resolve().parent.parent
CONTENT = ROOT / "content"
THEME = ROOT / "theme" / "acabados-contemporaneos"
OUT = ROOT / "vercel" / "public"
RENDER = ROOT / "tools" / "static" / "render-page.php"
SITE = "https://acabadoscontemporaneos.com"
META_RE = re.compile(r"^\s*<!--(\{.*?\})-->\s*", re.S)


def load_index():
    items = []
    for lang in ("es", "en"):
        for kind in ("pages", "posts"):
            for f in sorted((CONTENT / lang / kind).glob("*.html")):
                raw = f.read_text(encoding="utf-8")
                m = META_RE.match(raw)
                meta = json.loads(m.group(1))
                parent = meta.get("parent", "")
                items.append({
                    "type": "page" if kind == "pages" else "post",
                    "lang": lang,
                    "slug": meta["slug"],
                    "parent": parent,
                    "path": f"{parent}/{meta['slug']}" if parent else meta["slug"],
                    "title": meta["title"],
                    "template": meta.get("template", ""),
                    "date": meta.get("date", "2026-10-27 09:00:00"),
                    "excerpt": meta.get("excerpt", ""),
                    "seo_title": meta.get("seo_title", ""),
                    "body": raw[m.end():].strip(),
                    "meta": {
                        "_ac_lang": lang,
                        "_ac_translation": meta.get("translation", ""),
                        "_ac_image": meta.get("image", ""),
                        "_ac_subtitle": meta.get("subtitle", ""),
                        "_ac_hide_cta": "1" if meta.get("hide_cta") else "",
                        "_ac_seo_title": meta.get("seo_title", ""),
                        "_ac_meta_description": meta.get("meta", ""),
                    },
                })
    by_path = {}
    for i, it in enumerate(items, start=1):
        it["id"] = i
        by_path[it["path"]] = it
    for it in items:
        it["parent_id"] = by_path[it["parent"]]["id"] if it["parent"] else 0
    return items


def main():
    items = load_index()
    if OUT.exists():
        shutil.rmtree(OUT)
    OUT.mkdir(parents=True)

    with tempfile.NamedTemporaryFile("w", suffix=".json", delete=False, encoding="utf-8") as tmp:
        json.dump(items, tmp, ensure_ascii=False)
        index = tmp.name

    def render(target):
        res = subprocess.run(["php", str(RENDER), index, target], capture_output=True, text=True)
        if res.returncode != 0 or res.stderr.strip():
            raise SystemExit(f"Error al renderizar {target}:\n{res.stderr}")
        return res.stdout

    for it in items:
        dest = OUT / "index.html" if it["path"] == "inicio" else OUT / it["path"] / "index.html"
        dest.parent.mkdir(parents=True, exist_ok=True)
        dest.write_text(render(it["path"]), encoding="utf-8")
    (OUT / "404.html").write_text(render("__404__"), encoding="utf-8")
    Path(index).unlink()

    shutil.copytree(THEME / "assets" / "css", OUT / "assets" / "css")
    shutil.copytree(THEME / "assets" / "js", OUT / "assets" / "js")
    (OUT / "img").mkdir()
    (OUT / "favicon.svg").write_text(
        '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40"><rect width="40" height="40" fill="#14120f"/>'
        '<rect x="5" y="5" width="13" height="13" fill="#fff"/><rect x="22" y="5" width="13" height="13" fill="none" stroke="#fff" stroke-width="1.5"/>'
        '<rect x="5" y="22" width="13" height="13" fill="none" stroke="#fff" stroke-width="1.5"/><rect x="22" y="22" width="13" height="13" fill="#b08d57"/></svg>',
        encoding="utf-8",
    )

    urls = ["/" if it["path"] == "inicio" else f"/{it['path']}/" for it in items]
    (OUT / "sitemap.xml").write_text(
        '<?xml version="1.0" encoding="UTF-8"?>\n<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">\n'
        + "".join(f"  <url><loc>{SITE}{u}</loc></url>\n" for u in urls) + "</urlset>\n",
        encoding="utf-8",
    )
    # Vista previa en Vercel: no indexar para no competir con el dominio real.
    (OUT / "robots.txt").write_text("User-agent: *\nDisallow: /\n", encoding="utf-8")
    print(f"{len(items)} páginas + 404 generadas en {OUT.relative_to(ROOT)}")


if __name__ == "__main__":
    main()
