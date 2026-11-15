#!/usr/bin/env python3
"""
Exports the running WordPress test site (WordPress Playground on 127.0.0.1:9400)
to a static HTML preview for Vercel: crawls every internal page, strips the
admin bar, rewrites URLs to root-relative, copies theme assets, marks the preview
noindex, and makes the contact form show a preview notice.

Usage: python3 tools/export_static.py  ->  preview-static/
"""
import http.cookiejar
import os
import re
import shutil
import urllib.parse
import urllib.request

ORIGIN = "http://127.0.0.1:9400"
PROD = "https://southwesternsolutions.org"
HERE = os.path.dirname(os.path.abspath(__file__))
OUT = os.path.join(HERE, "..", "preview-static")
THEME = os.path.join(HERE, "..", "theme", "southwestern-solutions")

jar = http.cookiejar.CookieJar()
opener = urllib.request.build_opener(urllib.request.HTTPCookieProcessor(jar))


def get(url):
    with opener.open(url, timeout=120) as r:
        return r.status, r.geturl(), r.read()


SKIP = re.compile(r"/(wp-admin|wp-login|wp-json|feed|xmlrpc|comments|wp-content|wp-includes)|\?|#|\.(xml|php|jpg|png|webp|css|js)$")

FORM_JS = """<script>document.querySelectorAll('form.form').forEach(function(f){f.addEventListener('submit',function(e){e.preventDefault();var n=document.createElement('div');n.className='notice notice--ok';n.setAttribute('role','status');n.textContent='Preview mode: the seat-request form is fully functional once installed on WordPress. For now, email info@southwesternsolutions.org or call +1 (928) 614-0964.';f.parentNode.insertBefore(n,f);});});</script>"""


def clean(html):
    # Admin bar (rendered last in wp_footer) and its assets.
    # WP >= 5.4 prints the admin bar right after <body> (wp_body_open), before the theme's skip link.
    html = re.sub(r'<div id="wpadminbar".*?(?=<a class="skip-link)', "", html, flags=re.S)
    html = re.sub(r'<link[^>]+(admin-bar|dashicons)[^>]*>\s*', "", html)
    html = re.sub(r'<script[^>]+(admin-bar|hoverintent)[^>]*></script>\s*', "", html)
    html = re.sub(r'<style[^>]*id="admin-bar-inline-css"[^>]*>.*?</style>', "", html, flags=re.S)
    html = re.sub(r'<style media="screen">\s*html \{ margin-top: 32px !important; \}.*?</style>', "", html, flags=re.S)
    html = re.sub(r'<style[^>]*>\s*@media screen \{ html \{ margin-top: 32px !important; \} \}.*?</style>\s*', "", html, flags=re.S)
    html = re.sub(r"<script[^>]+comment-reply[^>]*></script>\s*", "", html)
    html = re.sub(r'(<body[^>]*class="[^"]*)\badmin-bar\b', r"\1", html)
    html = re.sub(r'(<body[^>]*class="[^"]*)\blogged-in\b', r"\1", html)
    # Core assets missing from the trimmed test build.
    html = re.sub(r'<link[^>]+(block-library|classic-themes)[^>]*>\s*', "", html)
    # Preview must never compete with the real domain in Google.
    html = re.sub(r'<meta name="robots"[^>]*>', '<meta name="robots" content="noindex, nofollow">', html)
    # Absolute SEO URLs -> production domain; everything else root-relative.
    html = re.sub(r'(<link rel="canonical" href=")' + re.escape(ORIGIN), r"\1" + PROD, html)
    html = re.sub(r'(<meta (?:property|name)="(?:og|twitter):[^"]+" content=")' + re.escape(ORIGIN), r"\1" + PROD, html)
    html = html.replace(ORIGIN.replace("/", "\\/"), PROD.replace("/", "\\/"))
    html = html.replace(ORIGIN, "")
    html = re.sub(r"<link rel='dns-prefetch' href='//127.0.0.1' />\s*", "", html)
    html = re.sub(r'<link rel="(EditURI|alternate|https://api.w.org/|wlwmanifest)"[^>]*>\s*', "", html)
    html = html.replace("</body>", FORM_JS + "\n</body>")
    return html


def out_path(path):
    path = path.split("?")[0]
    if not path.endswith("/"):
        path += "/"
    return os.path.join(OUT, path.lstrip("/"), "index.html")


def main():
    if os.path.isdir(OUT):
        shutil.rmtree(OUT)
    os.makedirs(OUT)
    get(ORIGIN + "/")  # pick up playground session cookie
    queue, seen, assets = ["/"], set(), set()
    while queue:
        path = queue.pop(0)
        if path in seen:
            continue
        seen.add(path)
        try:
            status, final, body = get(ORIGIN + path)
        except Exception as e:  # 404 etc.
            print("skip", path, e)
            continue
        html = body.decode("utf-8", "replace")
        for href in re.findall(r'href="(' + re.escape(ORIGIN) + r'[^"]*)"', html):
            p = urllib.parse.urlparse(href).path or "/"
            if not SKIP.search(href.replace(ORIGIN, "")) and p not in seen:
                queue.append(p)
        for a in re.findall(re.escape(ORIGIN) + r'(/wp-includes/[^"\'\s)?]+)', html):
            assets.add(a)
        dest = out_path(path)
        os.makedirs(os.path.dirname(dest), exist_ok=True)
        with open(dest, "w", encoding="utf-8") as f:
            f.write(clean(html))
        print("page", path)

    # 404 page
    try:
        get(ORIGIN + "/this-page-does-not-exist/")
    except urllib.error.HTTPError as e:
        with open(os.path.join(OUT, "404.html"), "w", encoding="utf-8") as f:
            f.write(clean(e.read().decode("utf-8", "replace")))

    # Theme assets (WebP + logo only; JPG fallbacks are not needed by modern browsers)
    tdest = os.path.join(OUT, "wp-content", "themes", "southwestern-solutions")
    for sub in ("assets/css", "assets/js"):
        shutil.copytree(os.path.join(THEME, sub), os.path.join(tdest, sub))
    os.makedirs(os.path.join(tdest, "assets/img"))
    for f in os.listdir(os.path.join(THEME, "assets/img")):
        shutil.copy(os.path.join(THEME, "assets/img", f), os.path.join(tdest, "assets/img", f))

    for a in sorted(assets):
        if "admin-bar" in a or "dashicons" in a or "hoverintent" in a:
            continue
        try:
            _, _, body = get(ORIGIN + a)
        except Exception:
            continue
        d = os.path.join(OUT, a.lstrip("/"))
        os.makedirs(os.path.dirname(d), exist_ok=True)
        with open(d, "wb") as f:
            f.write(body)
        print("asset", a)

    fix_ids()

    with open(os.path.join(OUT, "robots.txt"), "w") as f:
        f.write("User-agent: *\nDisallow: /\n")
    with open(os.path.join(OUT, "vercel.json"), "w") as f:
        f.write('{\n  "trailingSlash": true,\n  "headers": [{ "source": "/(.*)", "headers": [{ "key": "X-Robots-Tag", "value": "noindex, nofollow" }] }]\n}\n')
    print("done ->", os.path.abspath(OUT))


def fix_ids():
    """Rewrite /?page_id=N and /?p=N links (plain permalinks) to the crawled pretty paths."""
    idmap, files = {}, []
    for root, _, names in os.walk(OUT):
        for n in names:
            if n.endswith(".html"):
                fp = os.path.join(root, n)
                files.append(fp)
                rel = "/" + os.path.relpath(root, OUT).replace(os.sep, "/") + "/"
                rel = "/" if rel == "/./" else rel
                html = open(fp, encoding="utf-8").read()
                m = re.search(r'<body[^>]*class="[^"]*\b(?:page-id|postid)-(\d+)', html)
                if m and n == "index.html":
                    idmap[m.group(1)] = rel
    def sub(m):
        return idmap.get(m.group(2), m.group(0) if m.group(2) not in idmap else "")
    for fp in files:
        html = open(fp, encoding="utf-8").read()
        new = re.sub(r"/\?(page_id|p)=(\d+)", lambda m: idmap.get(m.group(2), m.group(0)), html)
        new = new.replace(PROD + "//", PROD + "/")
        if new != html:
            open(fp, "w", encoding="utf-8").write(new)
    print("id map:", idmap)


if __name__ == "__main__":
    main()
