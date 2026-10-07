#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""Build the WordPress eXtended RSS (WXR 1.2) import file for Agave Taco Shop.

Usage:  python3 content/build_wxr.py [output.xml] [--site https://www.agavetacoshop.com]

Produces pages, blog posts, categories, tags, media attachments (remote images
that the WordPress Importer downloads into the Media Library), navigation
menus and SEO meta for Yoast SEO and Rank Math.
"""
import html
import os
import re
import sys
from datetime import datetime
from xml.sax.saxutils import escape

sys.path.insert(0, os.path.dirname(os.path.abspath(__file__)))
from pages import PAGES  # noqa: E402
from posts import POSTS, CATEGORIES  # noqa: E402
from images import IMAGES  # noqa: E402

SITE = "https://www.agavetacoshop.com"
OUT = os.path.join(os.path.dirname(os.path.abspath(__file__)), "..", "dist", "agave-taco-shop-wordpress-import.xml")
args = sys.argv[1:]
if "--site" in args:
    i = args.index("--site")
    SITE = args[i + 1].rstrip("/")
    del args[i:i + 2]
if args:
    OUT = args[0]

AUTHOR = "agave"
NOW = datetime(2026, 10, 7, 9, 0, 0)


def cdata(text):
    return "<![CDATA[" + (text or "").replace("]]>", "]]]]><![CDATA[>") + "]]>"


def inline(text):
    """Allow light inline HTML; escape bare ampersands."""
    return re.sub(r"&(?![a-zA-Z#0-9]+;)", "&amp;", text)


def to_blocks(body):
    """Convert the mini-markup used in pages.py/posts.py into Gutenberg block HTML."""
    out = []
    chunks = [c.strip("\n") for c in re.split(r"\n\s*\n", body.strip())] if body.strip() else []
    for chunk in chunks:
        lines = [l for l in chunk.split("\n") if l.strip()]
        first = lines[0].strip()
        if first.startswith("### "):
            out.append('<!-- wp:heading {"level":3} -->\n<h3 class="wp-block-heading">%s</h3>\n<!-- /wp:heading -->' % inline(first[4:]))
        elif first.startswith("## "):
            out.append('<!-- wp:heading -->\n<h2 class="wp-block-heading">%s</h2>\n<!-- /wp:heading -->' % inline(first[3:]))
        elif first.startswith("- "):
            items = "\n".join('<!-- wp:list-item -->\n<li>%s</li>\n<!-- /wp:list-item -->' % inline(l.strip()[2:]) for l in lines)
            out.append('<!-- wp:list -->\n<ul class="wp-block-list">%s</ul>\n<!-- /wp:list -->' % items)
        elif re.match(r"^\d+\. ", first):
            items = "\n".join('<!-- wp:list-item -->\n<li>%s</li>\n<!-- /wp:list-item -->' % inline(re.sub(r"^\d+\. ", "", l.strip())) for l in lines)
            out.append('<!-- wp:list {"ordered":true} -->\n<ol class="wp-block-list">%s</ol>\n<!-- /wp:list -->' % items)
        elif first.startswith("> "):
            text = " ".join(l.strip()[2:] for l in lines)
            out.append('<!-- wp:quote -->\n<blockquote class="wp-block-quote"><!-- wp:paragraph -->\n<p>%s</p>\n<!-- /wp:paragraph --></blockquote>\n<!-- /wp:quote -->' % inline(text))
        elif first.startswith('<p class="agave-lead">'):
            inner = re.sub(r'^<p class="agave-lead">|</p>$', "", chunk.strip())
            out.append('<!-- wp:paragraph {"className":"agave-lead"} -->\n<p class="agave-lead">%s</p>\n<!-- /wp:paragraph -->' % inline(inner))
        elif first.startswith("<p>") and chunk.strip().endswith("</p>") and chunk.count("<p>") == 1:
            out.append('<!-- wp:paragraph -->\n%s\n<!-- /wp:paragraph -->' % inline(chunk.strip()))
        elif first.startswith("<"):
            out.append("<!-- wp:html -->\n%s\n<!-- /wp:html -->" % chunk.strip())
        else:
            text = " ".join(l.strip() for l in lines)
            out.append("<!-- wp:paragraph -->\n<p>%s</p>\n<!-- /wp:paragraph -->" % inline(text))
    return "\n\n".join(out)


def php_ser_list(values):
    parts = "".join('i:%d;s:%d:"%s";' % (i, len(v.encode("utf-8")), v) for i, v in enumerate(values))
    return "a:%d:{%s}" % (len(values), parts)


def meta(key, value):
    return "\t\t<wp:postmeta>\n\t\t\t<wp:meta_key>%s</wp:meta_key>\n\t\t\t<wp:meta_value>%s</wp:meta_value>\n\t\t</wp:postmeta>\n" % (cdata(key), cdata(str(value)))


def seo_meta(item):
    m = ""
    if item.get("seo_title"):
        m += meta("_yoast_wpseo_title", item["seo_title"])
        m += meta("rank_math_title", item["seo_title"])
    if item.get("seo_desc"):
        m += meta("_yoast_wpseo_metadesc", item["seo_desc"])
        m += meta("rank_math_description", item["seo_desc"])
        m += meta("_agave_meta_description", item["seo_desc"])
    if item.get("focus_kw"):
        m += meta("_yoast_wpseo_focuskw", item["focus_kw"])
        m += meta("rank_math_focus_keyword", item["focus_kw"])
    if item.get("noindex"):
        m += meta("_yoast_wpseo_meta-robots-noindex", "1")
        m += meta("rank_math_robots", php_ser_list(["noindex"]))
    return m


def item_xml(post_id, title, slug, ptype, content, excerpt="", date=None, status="publish",
             parent=0, order=0, extra_meta="", categories="", guid=None, link=None,
             attachment_url=None, comment_status="closed"):
    date = date or NOW.strftime("%Y-%m-%d %H:%M:%S")
    pub = datetime.strptime(date, "%Y-%m-%d %H:%M:%S").strftime("%a, %d %b %Y %H:%M:%S +0000")
    link = link or "%s/%s/" % (SITE, slug)
    guid = guid or "%s/?%s=%d" % (SITE, "page_id" if ptype == "page" else "p", post_id)
    x = "\t<item>\n"
    x += "\t\t<title>%s</title>\n" % cdata(title)
    x += "\t\t<link>%s</link>\n" % escape(link)
    x += "\t\t<pubDate>%s</pubDate>\n" % pub
    x += "\t\t<dc:creator>%s</dc:creator>\n" % cdata(AUTHOR)
    x += '\t\t<guid isPermaLink="false">%s</guid>\n' % escape(guid)
    x += "\t\t<description></description>\n"
    x += "\t\t<content:encoded>%s</content:encoded>\n" % cdata(content)
    x += "\t\t<excerpt:encoded>%s</excerpt:encoded>\n" % cdata(excerpt)
    x += "\t\t<wp:post_id>%d</wp:post_id>\n" % post_id
    x += "\t\t<wp:post_date>%s</wp:post_date>\n" % cdata(date)
    x += "\t\t<wp:post_date_gmt>%s</wp:post_date_gmt>\n" % cdata(date)
    x += "\t\t<wp:post_modified>%s</wp:post_modified>\n" % cdata(date)
    x += "\t\t<wp:post_modified_gmt>%s</wp:post_modified_gmt>\n" % cdata(date)
    x += "\t\t<wp:comment_status>%s</wp:comment_status>\n" % cdata(comment_status)
    x += "\t\t<wp:ping_status>%s</wp:ping_status>\n" % cdata("closed")
    x += "\t\t<wp:post_name>%s</wp:post_name>\n" % cdata(slug)
    x += "\t\t<wp:status>%s</wp:status>\n" % cdata(status)
    x += "\t\t<wp:post_parent>%d</wp:post_parent>\n" % parent
    x += "\t\t<wp:menu_order>%d</wp:menu_order>\n" % order
    x += "\t\t<wp:post_type>%s</wp:post_type>\n" % cdata(ptype)
    x += "\t\t<wp:post_password>%s</wp:post_password>\n" % cdata("")
    x += "\t\t<wp:is_sticky>0</wp:is_sticky>\n"
    if attachment_url:
        x += "\t\t<wp:attachment_url>%s</wp:attachment_url>\n" % cdata(attachment_url)
    x += categories
    x += extra_meta
    x += "\t</item>\n"
    return x


def build():
    parts = []
    # ---------------------------------------------------------------- media
    attach_ids = {}
    next_id = 100
    for key, img in IMAGES.items():
        attach_ids[key] = next_id
        m = meta("_wp_attachment_image_alt", img["alt"])
        m += meta("_agave_image_source", img["source"])
        parts.append(item_xml(
            next_id, img["title"], "agave-" + key, "attachment", img.get("caption", ""),
            excerpt=img.get("caption", ""), status="inherit", extra_meta=m,
            attachment_url=img["url"], guid=img["url"], link="%s/agave-%s/" % (SITE, key),
        ))
        next_id += 1

    # ---------------------------------------------------------------- pages
    page_ids = {}
    page_images = {
        "menu": "dish-quesabirria", "our-story": "story-grill", "catering": "catering-spread",
        "visit": "hero-drive-thru", "contact": "gallery-aguas", "blog": "gallery-board",
        "home": "hero-quesabirria",
    }
    pid = 10
    for page in PAGES:
        page_ids[page["slug"]] = pid
        m = seo_meta(page)
        if page.get("template"):
            m += meta("_wp_page_template", page["template"])
        if page.get("kicker"):
            m += meta("_agave_kicker", page["kicker"])
        if page["slug"] in page_images:
            m += meta("_thumbnail_id", attach_ids[page_images[page["slug"]]])
        parts.append(item_xml(pid, page["title"], page["slug"], "page", to_blocks(page["body"]),
                              excerpt=page.get("excerpt", ""), order=page["order"], extra_meta=m,
                              date="2026-08-01 09:00:00"))
        pid += 1

    # ---------------------------------------------------------------- posts
    post_id = 200
    for post in POSTS:
        cats = '\t\t<category domain="category" nicename="%s">%s</category>\n' % (post["category"], cdata(dict((c[0], c[1]) for c in CATEGORIES)[post["category"]]))
        for tag in post["tags"]:
            cats += '\t\t<category domain="post_tag" nicename="%s">%s</category>\n' % (slugify(tag), cdata(tag))
        m = seo_meta(post)
        m += meta("_thumbnail_id", attach_ids[post["image"]])
        parts.append(item_xml(post_id, post["title"], post["slug"], "post", to_blocks(post["body"]),
                              excerpt=post["excerpt"], date=post["date"], categories=cats, extra_meta=m,
                              comment_status="open"))
        post_id += 1

    # ---------------------------------------------------------------- menus
    nav_id = 400
    menus = {
        "main-menu": [
            ("page", "menu", "Menu", ""),
            ("page", "our-story", "Our Story", ""),
            ("page", "catering", "Catering", ""),
            ("page", "visit", "Visit", ""),
            ("page", "blog", "Blog", ""),
            ("page", "contact", "Contact", ""),
        ],
        "footer-menu": [
            ("page", "menu", "Menu", ""),
            ("page", "our-story", "Our Story", ""),
            ("page", "catering", "Taco Catering", ""),
            ("page", "visit", "Hours & Location", ""),
            ("page", "blog", "Blog", ""),
            ("page", "contact", "Contact", ""),
            ("custom", "https://order.toasttab.com/online/agave-taco-shop-4111-w-point-loma-blvd", "Order Online", ""),
            ("page", "privacy-policy", "Privacy Policy", ""),
        ],
    }
    menu_names = {"main-menu": "Main Menu", "footer-menu": "Footer Menu"}
    for menu_slug, entries in menus.items():
        for order, (kind, target, label, css) in enumerate(entries, start=1):
            m = meta("_menu_item_menu_item_parent", "0")
            m += meta("_menu_item_classes", php_ser_list([css]))
            m += meta("_menu_item_xfn", "")
            if kind == "page":
                m += meta("_menu_item_type", "post_type")
                m += meta("_menu_item_object", "page")
                m += meta("_menu_item_object_id", page_ids[target])
                m += meta("_menu_item_target", "")
                m += meta("_menu_item_url", "")
            else:
                m += meta("_menu_item_type", "custom")
                m += meta("_menu_item_object", "custom")
                m += meta("_menu_item_object_id", nav_id)
                m += meta("_menu_item_target", "_blank")
                m += meta("_menu_item_url", target)
            cats = '\t\t<category domain="nav_menu" nicename="%s">%s</category>\n' % (menu_slug, cdata(menu_names[menu_slug]))
            parts.append(item_xml(nav_id, label, "%s-%d" % (menu_slug, order), "nav_menu_item", "",
                                  order=order, categories=cats, extra_meta=m,
                                  guid="%s/?p=%d" % (SITE, nav_id)))
            nav_id += 1

    # ---------------------------------------------------------------- header
    terms = ""
    term_id = 2
    for slug, name, desc in CATEGORIES:
        terms += "\t<wp:category>\n\t\t<wp:term_id>%d</wp:term_id>\n\t\t<wp:category_nicename>%s</wp:category_nicename>\n\t\t<wp:category_parent>%s</wp:category_parent>\n\t\t<wp:cat_name>%s</wp:cat_name>\n\t\t<wp:category_description>%s</wp:category_description>\n\t</wp:category>\n" % (term_id, cdata(slug), cdata(""), cdata(name), cdata(desc))
        term_id += 1
    seen = set()
    for post in POSTS:
        for tag in post["tags"]:
            s = slugify(tag)
            if s in seen:
                continue
            seen.add(s)
            terms += "\t<wp:tag>\n\t\t<wp:term_id>%d</wp:term_id>\n\t\t<wp:tag_slug>%s</wp:tag_slug>\n\t\t<wp:tag_name>%s</wp:tag_name>\n\t</wp:tag>\n" % (term_id, cdata(s), cdata(tag))
            term_id += 1
    for slug, name in menu_names.items():
        terms += "\t<wp:term>\n\t\t<wp:term_id>%d</wp:term_id>\n\t\t<wp:term_taxonomy>%s</wp:term_taxonomy>\n\t\t<wp:term_slug>%s</wp:term_slug>\n\t\t<wp:term_parent>%s</wp:term_parent>\n\t\t<wp:term_name>%s</wp:term_name>\n\t</wp:term>\n" % (term_id, cdata("nav_menu"), cdata(slug), cdata(""), cdata(name))
        term_id += 1

    head = """<?xml version="1.0" encoding="UTF-8" ?>
<!-- Agave Taco Shop — WordPress import (WXR 1.2). Tools → Import → WordPress. -->
<!-- Generated by content/build_wxr.py — Webmaster Tijuana. -->
<rss version="2.0"
	xmlns:excerpt="http://wordpress.org/export/1.2/excerpt/"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:wp="http://wordpress.org/export/1.2/"
>
<channel>
	<title>Agave Taco Shop</title>
	<link>%(site)s</link>
	<description>Birria, quesabirria &amp; tacos in Point Loma, San Diego</description>
	<pubDate>%(now)s</pubDate>
	<language>en-US</language>
	<wp:wxr_version>1.2</wp:wxr_version>
	<wp:base_site_url>%(site)s</wp:base_site_url>
	<wp:base_blog_url>%(site)s</wp:base_blog_url>
	<wp:author><wp:author_id>1</wp:author_id><wp:author_login>%(author)s</wp:author_login><wp:author_email>hello@agavetacoshop.com</wp:author_email><wp:author_display_name>%(dn)s</wp:author_display_name><wp:author_first_name>%(fn)s</wp:author_first_name><wp:author_last_name>%(ln)s</wp:author_last_name></wp:author>
""" % {
        "site": SITE, "now": NOW.strftime("%a, %d %b %Y %H:%M:%S +0000"), "author": AUTHOR,
        "dn": cdata("Agave Taco Shop"), "fn": cdata("Agave"), "ln": cdata("Taco Shop"),
    }
    xml = head + terms + "".join(parts) + "</channel>\n</rss>\n"
    os.makedirs(os.path.dirname(os.path.abspath(OUT)), exist_ok=True)
    with open(OUT, "w", encoding="utf-8") as fh:
        fh.write(xml)
    print("Wrote %s (%d pages, %d posts, %d images, %d menu items)" % (
        os.path.relpath(OUT), len(PAGES), len(POSTS), len(IMAGES), nav_id - 400))


def slugify(text):
    import unicodedata
    text = unicodedata.normalize("NFKD", html.unescape(text)).encode("ascii", "ignore").decode("ascii").lower()
    text = re.sub(r"[^a-z0-9]+", "-", text)
    return text.strip("-")


if __name__ == "__main__":
    build()
