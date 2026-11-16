#!/usr/bin/env python3
"""
Builds the WooCommerce course products (seat registrations) with the SAME slugs as the
legacy site, so existing Google rankings and links keep working:

  /product/chemical-agent-instructor-course/
  /product/less-lethal-instructor-course/
  (Legacy San Jose products were removed; their URLs 301-redirect to the current courses.)

Outputs:
  import/southwestern-solutions-products.WordPress.xml   (Tools → Import → WordPress)   ← recommended, keeps slugs
  import/southwestern-solutions-products.csv             (Products → Import, WooCommerce CSV importer)

Registration opens automatically only while _sws_end_date is in the future (see theme inc/woocommerce.php).
To open a new session: edit the product → Custom Fields → update _sws_dates and _sws_end_date.
"""
import csv
import json
import os
import sys

sys.path.insert(0, os.path.dirname(__file__))
from build_wxr import H, P, UL, HTML, cdata, meta, escape, faq_html, checklist  # noqa: E402

SITE = "https://southwesternsolutions.org"
HERE = os.path.dirname(os.path.abspath(__file__))
OUT_XML = os.path.join(HERE, "..", "import", "southwestern-solutions-products.WordPress.xml")
OUT_CSV = os.path.join(HERE, "..", "import", "southwestern-solutions-products.csv")


CHEM_TOPICS = [
    "Review of use of force and related agency policies",
    "Deployment techniques and munition selection",
    "APR use (fit, inspection, clearing, confidence exercises)",
    "Use of chemical agent munitions and delivery systems",
    "Decontamination, medical considerations and aftercare",
    "Instruction techniques and lesson-plan development",
    "Scenario exercises, including AB 48 / Penal Code 13652 requirements",
]
LL_TOPICS = [
    "Legal standards, use-of-force policy and AB 48 / Penal Code 13652",
    "Less-lethal platforms, munitions and their characteristics",
    "Target areas, distances and prohibited targeting (head, neck, vital organs)",
    "Marksmanship, malfunctions and safe range operations",
    "Medical considerations and post-deployment procedures",
    "Documentation, reporting and instructor methodology",
]
BRING = [
    "Department-issued ID and POST ID number",
    "Serviceable APR (air-purifying respirator)",
    "Duty or training gear and clothing suitable for outdoor practical exercises",
    "Eye and ear protection",
    "Notebook and pen",
]

PRODUCTS = [
    dict(
        slug="chemical-agent-instructor-course", kind="chem", sku="SWS-CAI-SD",
        title="Chemical Agent Instructor Course",
        dates="February 8 – 12, 2027", start="2027-02-08", end="2027-02-12",
        city="San Diego", location="San Diego, CA", address="",
        hours="40 Hours", price="1881", hero="chemical-agent.webp", menu_order=1,
        source_note="Next open session per client (Nov 2026). The December 14 – 18, 2026 San Diego session is sold out."
    ),
    dict(
        slug="less-lethal-instructor-course", kind="ll", sku="SWS-LLI-SD",
        title="Less Lethal Instructor Course",
        dates="December 9 – 11, 2026", start="2026-12-09", end="2026-12-11",
        city="San Diego", location="San Diego, CA", address="",
        hours="30 Hours", price="1200", hero="training-launcher.webp", menu_order=2,
        source_note="Session confirmed by client (Nov 2026): December 9 – 11, 2026, San Diego, registration open.",
    ),
]


def description(p):
    chem = p["kind"] == "chem"
    name = "Chemical Agent Instructor Course" if chem else "Less Lethal Instructor Course"
    hours = p["hours"].split()[0]
    where = p["location"] + (f" — {p['address']}" if p["address"] else "")
    blocks = [
        H("Course Overview"),
        P(
            f"The <strong>{name}</strong> is a {hours}-hour, POST-certified instructor course "
            + ("that prepares officers to teach, deploy and document chemical agents safely, lawfully and effectively."
               if chem else
               "that builds officers into instructors capable of running safe, defensible kinetic energy projectile programs.")
            + " Taught by former and current Law Enforcement Tactical Operators with over 50 years of experience."
        ),
        P("Southwestern Solutions Chemical Agent and Less Lethal Instructor Courses <strong>meet AB 48 requirements</strong> and are <strong>POST certified</strong>. "
          + ("AB 48 / PC 13652 will be taught in this course." if chem else "This course also covers AB 48 requirements and compliance.")),
        H("What You Will Learn"),
        HTML(checklist(CHEM_TOPICS if chem else LL_TOPICS)),
        H("Course Details"),
        HTML(
            '<div class="table-scroll"><table class="schedule"><tbody>'
            f"<tr><th>Dates</th><td>{p['dates']}</td></tr>"
            f"<tr><th>Location</th><td>{where}</td></tr>"
            f"<tr><th>Length</th><td>{p['hours']} (instructor level)</td></tr>"
            f"<tr><th>Tuition</th><td>${int(p['price']):,} per seat</td></tr>"
            "<tr><th>Certification</th><td>POST certified</td></tr>"
            "<tr><th>Reimbursement</th><td>POST Plan IV (tuition only — no travel or per diem)</td></tr>"
            "<tr><th>Compliance</th><td>AB 48 / Penal Code 13652</td></tr>"
            "</tbody></table></div>"
        ),
        H("What to Bring"),
        UL(BRING),
        P("A detailed equipment list and reporting instructions are emailed after registration."),
        H("Registration"),
        P("Select the number of seats and click <strong>Register Now</strong>. At checkout, enter your agency and each attendee’s name and POST ID. "
          "Agencies paying by purchase order or needing an invoice can <a href=\"/contact/\">contact us</a> or call +1 (928) 614-0964."),
        H("Frequently Asked Questions"),
        HTML(faq_html([
            ("Is this course POST Plan IV reimbursable?", "Yes. The course is POST certified and Plan IV reimbursable (tuition). Travel and per diem are not reimbursed under Plan IV."),
            ("Does the course cover AB 48?", "Yes. AB 48 / Penal Code 13652 requirements are covered so your instructors can carry compliant lesson plans and documentation back to the agency."),
            ("Can I register several officers?", "Yes. Increase the number of seats before adding the course to your cart, then list every attendee at checkout."),
        ])),
    ]
    return "\n\n".join(blocks)


def short(p):
    open_ = bool(p["end"])
    return (f"<p><strong>{p['dates']}</strong> · {p['location']} · {p['hours']} · POST certified · AB 48 compliant · Plan IV reimbursable.</p>"
            + ("" if open_ else ""))


def seo(p):
    chem = p["kind"] == "chem"
    base = "Chemical Agent Instructor Course" if chem else "Less Lethal Instructor Course"
    city = p["city"]
    title = f"{base} {city}, CA | {p['hours'].replace(' Hours', '-Hr')} POST Certified | Register"
    desc = (f"Register for the {p['hours'].lower()} POST-certified {base} in {city}, CA ({p['dates']}). "
            f"AB 48 compliant, Plan IV reimbursable. ${int(p['price']):,} per seat.")
    return title, desc[:160], f"{base.lower()} {city.lower()}"


def build():
    items, cats_xml = [], ""
    cat = ("product_cat", "instructor-courses", "Instructor Courses")
    pid = 700
    rows = []
    for p in PRODUCTS:
        pid += 1
        title, desc, kw = seo(p)
        course = {"name": p["title"], "description": f"{p['hours']} POST-certified instructor course. AB 48 compliant.",
                  "workload": "PT" + p["hours"].split()[0] + "H", "price": p["price"], "location": p["location"],
                  "city": p["city"], "address": p["address"], "start": p["start"], "end": p["end"],
                  "credential": ("Chemical Agent" if p["kind"] == "chem" else "Less Lethal") + " Instructor certificate (POST certified course)"}
        m = {
            "_sku": p["sku"], "_regular_price": p["price"], "_price": p["price"],
            "_virtual": "yes", "_downloadable": "no", "_tax_status": "none", "_manage_stock": "no",
            "_stock_status": "instock", "_sold_individually": "no", "_backorders": "no",
            "_visibility": "visible", "total_sales": "0",
            "_sws_dates": p["dates"], "_sws_end_date": p["end"], "_sws_location": p["location"],
            "_sws_address": p["address"], "_sws_hours": p["hours"], "_sws_hero": p["hero"],
            "_sws_course": json.dumps(course), "_sws_faq_schema": "1",
            "_sws_seo_title": title, "_sws_seo_desc": desc, "_sws_focus_kw": kw,
            "_yoast_wpseo_title": title, "_yoast_wpseo_metadesc": desc, "_yoast_wpseo_focuskw": kw,
            "rank_math_title": title, "rank_math_description": desc, "rank_math_focus_keyword": kw,
        }
        extra = "".join(meta(k, v) for k, v in m.items())
        terms = [cat, ("product_type", "simple", "simple"),
                 ("product_tag", "post-certified", "POST Certified"), ("product_tag", "ab-48", "AB 48"),
                 ("product_tag", p["city"].lower().replace(" ", "-"), p["city"])]
        cat_xml = "".join(f'\t\t<category domain="{d}" nicename="{n}">{cdata(l)}</category>\n' for d, n, l in terms)
        items.append(f"""	<item>
		<title>{cdata(p['title'])}</title>
		<link>{SITE}/product/{p['slug']}/</link>
		<pubDate>Sun, 15 Nov 2026 08:00:00 +0000</pubDate>
		<dc:creator>{cdata('admin')}</dc:creator>
		<guid isPermaLink="false">{SITE}/?post_type=product&amp;p={pid}</guid>
		<description></description>
		<content:encoded>{cdata(description(p))}</content:encoded>
		<excerpt:encoded>{cdata(short(p))}</excerpt:encoded>
		<wp:post_id>{pid}</wp:post_id>
		<wp:post_date>{cdata('2026-11-15 08:00:00')}</wp:post_date>
		<wp:post_date_gmt>{cdata('2026-11-15 08:00:00')}</wp:post_date_gmt>
		<wp:comment_status>{cdata('closed')}</wp:comment_status>
		<wp:ping_status>{cdata('closed')}</wp:ping_status>
		<wp:post_name>{cdata(p['slug'])}</wp:post_name>
		<wp:status>{cdata('publish')}</wp:status>
		<wp:post_parent>0</wp:post_parent>
		<wp:menu_order>{p['menu_order']}</wp:menu_order>
		<wp:post_type>{cdata('product')}</wp:post_type>
		<wp:post_password>{cdata('')}</wp:post_password>
		<wp:is_sticky>0</wp:is_sticky>
{cat_xml}{extra}	</item>
""")
        rows.append({
            "Type": "simple", "SKU": p["sku"], "Name": p["title"], "Published": 1, "Is featured?": 0,
            "Visibility in catalog": "visible", "Short description": short(p), "Description": description(p),
            "Tax status": "none", "In stock?": 1, "Backorders allowed?": 0, "Sold individually?": 0,
            "Allow customer reviews?": 0, "Regular price": p["price"], "Categories": "Instructor Courses",
            "Tags": f"POST Certified, AB 48, {p['city']}", "Position": p["menu_order"],
            "Meta: _sws_dates": p["dates"], "Meta: _sws_end_date": p["end"], "Meta: _sws_location": p["location"],
            "Meta: _sws_address": p["address"], "Meta: _sws_hours": p["hours"], "Meta: _sws_hero": p["hero"],
            "Meta: _sws_course": json.dumps(course), "Meta: _sws_faq_schema": "1",
            "Meta: _sws_seo_title": title, "Meta: _sws_seo_desc": desc, "Meta: _sws_focus_kw": kw,
            "Meta: _yoast_wpseo_title": title, "Meta: _yoast_wpseo_metadesc": desc,
            "Meta: rank_math_title": title, "Meta: rank_math_description": desc,
        })

    xml = f"""<?xml version="1.0" encoding="UTF-8" ?>
<!-- Southwestern Solutions — WooCommerce course products. Requires WooCommerce active before import. -->
<rss version="2.0" xmlns:excerpt="http://wordpress.org/export/1.2/excerpt/" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:wfw="http://wellformedweb.org/CommentAPI/" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:wp="http://wordpress.org/export/1.2/">
<channel>
	<title>Southwestern Solutions</title>
	<link>{SITE}</link>
	<description>Course products</description>
	<language>en-US</language>
	<wp:wxr_version>1.2</wp:wxr_version>
	<wp:base_site_url>{SITE}</wp:base_site_url>
	<wp:base_blog_url>{SITE}</wp:base_blog_url>
	<wp:author><wp:author_id>1</wp:author_id><wp:author_login>{cdata('admin')}</wp:author_login><wp:author_email>{cdata('info@southwesternsolutions.org')}</wp:author_email><wp:author_display_name>{cdata('Southwestern Solutions')}</wp:author_display_name><wp:author_first_name>{cdata('')}</wp:author_first_name><wp:author_last_name>{cdata('')}</wp:author_last_name></wp:author>
	<wp:term><wp:term_id>90</wp:term_id><wp:term_taxonomy>{cdata('product_cat')}</wp:term_taxonomy><wp:term_slug>{cdata('instructor-courses')}</wp:term_slug><wp:term_name>{cdata('Instructor Courses')}</wp:term_name></wp:term>
{''.join(items)}</channel>
</rss>
"""
    with open(OUT_XML, "w", encoding="utf-8") as f:
        f.write(xml)
    with open(OUT_CSV, "w", encoding="utf-8", newline="") as f:
        w = csv.DictWriter(f, fieldnames=list(rows[0].keys()))
        w.writeheader()
        w.writerows(rows)
    print(f"Wrote {len(PRODUCTS)} products -> {OUT_XML}\n                    -> {OUT_CSV}")


if __name__ == "__main__":
    build()
