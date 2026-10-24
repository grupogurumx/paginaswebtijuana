# -*- coding: utf-8 -*-
"""Export a running WordPress install of the theme to static HTML for a
Vercel preview.

Usage: python3 export_static.py <base_url> <urls_file> <out_dir>

Every page is saved as <path>/index.html, every asset it references on the
same host is downloaded, and absolute URLs become root-relative. The lead
form needs WordPress (admin-post.php), so in the static preview it shows a
notice instead of posting.
"""

import os
import re
import sys
import urllib.parse
import urllib.request

BASE, URLS_FILE, OUT = sys.argv[1].rstrip("/"), sys.argv[2], sys.argv[3]

ASSET_RE = re.compile(r"""(?:href|src)=["']([^"']+)["']|url\(\s*['"]?([^'")]+)['"]?\s*\)|srcset=["']([^"']+)["']""")

PREVIEW_JS = """<script>
document.querySelectorAll('form.lead-form').forEach(function (f) {
  f.addEventListener('submit', function (e) {
    e.preventDefault();
    var es = document.documentElement.lang.indexOf('es') === 0;
    alert(es ? 'Vista previa: el formulario envía y guarda los leads una vez instalado en WordPress.'
             : 'Preview: the form sends and stores leads once installed on WordPress.');
  });
});
</script>
"""

seen_assets = set()


def fetch(url):
    with urllib.request.urlopen(url, timeout=30) as r:
        return r.read(), r.headers.get("Content-Type", "")


def local_path(url_path):
    p = urllib.parse.urlparse(url_path).path
    p = urllib.parse.unquote(p)
    if p.endswith("/") or "." not in os.path.basename(p):
        p = p.rstrip("/") + "/index.html"
    return os.path.join(OUT, p.lstrip("/"))


def save(path, data):
    os.makedirs(os.path.dirname(path), exist_ok=True)
    with open(path, "wb") as fh:
        fh.write(data)


def collect(text, base):
    found = []
    for m in ASSET_RE.finditer(text):
        for raw in m.groups():
            if not raw:
                continue
            for part in raw.split(","):
                u = part.strip().split(" ")[0]
                if not u or u.startswith(("data:", "#", "mailto:", "tel:", "javascript:")):
                    continue
                full = urllib.parse.urljoin(base, u.replace("&#038;", "&").replace("&amp;", "&"))
                if full.startswith(BASE):
                    found.append(full)
    return found


def is_asset(url):
    ext = os.path.splitext(urllib.parse.urlparse(url).path)[1].lower()
    return ext in {".css", ".js", ".png", ".jpg", ".jpeg", ".webp", ".svg", ".gif", ".woff", ".woff2", ".ttf", ".ico"}


def grab_asset(url):
    clean = url.split("?")[0].split("#")[0]
    if clean in seen_assets:
        return
    seen_assets.add(clean)
    try:
        data, _ = fetch(clean)
    except Exception as exc:  # noqa: BLE001
        print("  skip", clean, exc)
        return
    save(local_path(clean.replace(BASE, "")), data)
    if clean.endswith(".css"):
        for sub in collect(data.decode("utf-8", "ignore"), clean):
            if is_asset(sub):
                grab_asset(sub)


def rewrite(html):
    html = html.replace(BASE + "/", "/").replace(BASE.replace("/", "\\/") + "\\/", "\\/")
    html = html.replace(BASE, "/")
    # Static preview: no WordPress API, oEmbed or RSD endpoints.
    html = re.sub(r'<link rel="(?:alternate|EditURI|https://api\.w\.org/)"[^>]*(?:wp-json|xmlrpc|feed|oembed)[^>]*>\n?', "", html)
    # Keep the preview out of search results; the real site is drmariocamelo.com.
    html = re.sub(r'<meta name="robots"[^>]*>', '<meta name="robots" content="noindex, nofollow">', html)
    return html.replace("</body>", PREVIEW_JS + "</body>")


def main():
    paths = [line.strip() for line in open(URLS_FILE) if line.strip()]
    for p in paths:
        url = BASE + p
        data, _ = fetch(url)
        html = data.decode("utf-8")
        for a in collect(html, url):
            if is_asset(a):
                grab_asset(a)
        save(local_path(p), rewrite(html).encode("utf-8"))
        print("page", p)
    # 404 page.
    try:
        urllib.request.urlopen(BASE + "/this-page-does-not-exist/", timeout=30)
    except urllib.error.HTTPError as err:
        html = err.read().decode("utf-8")
        for a in collect(html, BASE + "/"):
            if is_asset(a):
                grab_asset(a)
        save(os.path.join(OUT, "404.html"), rewrite(html).encode("utf-8"))
    print(len(paths), "pages,", len(seen_assets), "assets")


if __name__ == "__main__":
    main()
