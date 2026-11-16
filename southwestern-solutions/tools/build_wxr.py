#!/usr/bin/env python3
"""
Builds the WordPress import file (WXR 1.2) for the Southwestern Solutions redesign:
pages, blog posts, categories, tags, primary menu and full SEO meta
(theme-native _sws_*, Yoast _yoast_wpseo_* and Rank Math rank_math_* keys).

Usage:  python3 tools/build_wxr.py  ->  import/southwestern-solutions.WordPress.xml
"""
import json
import os
from xml.sax.saxutils import escape

SITE = "https://southwesternsolutions.org"
OUT = os.path.join(os.path.dirname(__file__), "..", "import", "southwestern-solutions.WordPress.xml")

# ---------------------------------------------------------------------------
# Gutenberg block helpers
# ---------------------------------------------------------------------------

def H(text, level=2):
    attr = "" if level == 2 else ' {"level":%d}' % level
    return f'<!-- wp:heading{attr} -->\n<h{level} class="wp-block-heading">{text}</h{level}>\n<!-- /wp:heading -->'

def P(text):
    return f"<!-- wp:paragraph -->\n<p>{text}</p>\n<!-- /wp:paragraph -->"

def UL(items):
    lis = "".join(f"<!-- wp:list-item -->\n<li>{i}</li>\n<!-- /wp:list-item -->" for i in items)
    return f'<!-- wp:list -->\n<ul class="wp-block-list">{lis}</ul>\n<!-- /wp:list -->'

def QUOTE(text):
    return f'<!-- wp:quote -->\n<blockquote class="wp-block-quote"><!-- wp:paragraph -->\n<p>{text}</p>\n<!-- /wp:paragraph --></blockquote>\n<!-- /wp:quote -->'

def HTML(raw):
    return f"<!-- wp:html -->\n{raw.strip()}\n<!-- /wp:html -->"

import re as _re

def inline(t):
    t = _re.sub(r"\*\*(.+?)\*\*", r"<strong>\1</strong>", t)
    return _re.sub(r"\[([^\]]+)\]\(([^)]+)\)", r'<a href="\2">\1</a>', t)

def prose(md):
    """Tiny markdown -> blocks: '## ', '### ', '- ' lists, '> ' quote, '[' / '<' raw html/shortcode lines."""
    out, para, lst = [], [], []

    def flush():
        nonlocal para, lst
        if para:
            out.append(P(inline(" ".join(para))))
            para = []
        if lst:
            out.append(UL([inline(i) for i in lst]))
            lst = []

    for line in md.strip().splitlines():
        s = line.strip()
        if not s:
            flush()
        elif s.startswith("### "):
            flush(); out.append(H(s[4:], 3))
        elif s.startswith("## "):
            flush(); out.append(H(s[3:], 2))
        elif s.startswith("- "):
            if para:
                out.append(P(inline(" ".join(para)))); para = []
            lst.append(s[2:])
        elif s.startswith("> "):
            flush(); out.append(QUOTE(inline(s[2:])))
        elif s.startswith("[") or s.startswith("<"):
            flush(); out.append(HTML(s))
        else:
            if lst:
                out.append(UL([inline(i) for i in lst])); lst = []
            para.append(s)
    flush()
    return "\n\n".join(out)

def faq_html(pairs):
    return '<div class="faq">' + "".join(f"<details><summary>{q}</summary><p>{a}</p></details>" for q, a in pairs) + "</div>"

def checklist(items):
    return '<ul class="checklist">' + "".join(f"<li>{i}</li>" for i in items) + "</ul>"

def cta(title=None, text=None, button=None, url=None):
    attrs = []
    for k, v in (("title", title), ("text", text), ("button", button), ("url", url)):
        if v:
            attrs.append(f'{k}="{v}"')
    return f'[sws_section][sws_cta {" ".join(attrs)}][/sws_section]'

# ---------------------------------------------------------------------------
# Shared copy
# ---------------------------------------------------------------------------
PHONE = "+1 (928) 614-0964"
EMAIL = "info@southwesternsolutions.org"

CHEM_FAQ = [
    ("How long is the Chemical Agent Instructor Course?", "It is a 40-hour, instructor-level course combining classroom instruction, practical deployment work and scenario exercises."),
    ("Is the course POST certified and reimbursable?", "Yes. The course is POST certified and listed as Plan IV reimbursable, which covers tuition. Travel and per diem are not reimbursed under Plan IV — confirm eligibility with your agency training manager."),
    ("Does the course cover AB 48 and Penal Code 13652?", "Yes. AB 48 / PC 13652 requirements are taught inside the course so your instructors can carry compliant lesson plans and documentation back to the agency."),
    ("What should students bring?", "Students receive a detailed equipment list after registration. Plan for a serviceable APR, duty or training gear and clothing suitable for outdoor practical exercises."),
]
LL_FAQ = [
    ("How long is the Less Lethal Instructor Course?", "It is a 30-hour, instructor-level course that blends legal standards, platform operation, practical drills and teaching methodology."),
    ("Is it AB 48 compliant?", "Yes. The course covers AB 48 requirements and compliance for kinetic energy projectiles used in crowd-control situations, including targeting restrictions and documentation."),
    ("Is the course POST certified?", "Yes. It is POST certified and listed as Plan IV reimbursable (tuition). Confirm specific session eligibility in the POST catalog or with our team."),
    ("Who should attend?", "Sworn officers and deputies who will instruct, certify or maintain less-lethal proficiency within their agency — typically range staff, SWAT/SRT operators and training-unit personnel."),
]

# ---------------------------------------------------------------------------
# PAGES
# ---------------------------------------------------------------------------
PAGES = []

def page(**kw):
    PAGES.append(kw)

# 1. HOME ------------------------------------------------------------------
home_content = "\n\n".join([
    HTML("[sws_slider interval=\"7000\"]"),
    HTML("[sws_trustbar]"),
    HTML("""[sws_section][sws_split img="instructor-scope" alt="Southwestern Solutions instructor observing a tactical operator on the range" badge="Years of Experience" badge_num="50+"]
<span class="eyebrow">Who We Are</span>
<h2>Instructor Training Forged in the <span class="text-amber">Field</span></h2>
<p class="lead">Southwestern Solutions delivers POST-certified law enforcement instructor training from San Diego. Our instructors are former and current Law Enforcement Tactical Operators with over 50 years of experience, and we bring that experience to every class — so each lesson reflects what actually happens on the line.</p>
""" + checklist([
        "Chemical Agent Instructor and Less Lethal Instructor certification",
        "Curriculum aligned with AB 48 and Penal Code 13652",
        "POST Plan IV reimbursable tuition for eligible agencies",
        "Classroom, range and scenario-based evaluation",
    ]) + """
<div class="btn-row"><a class="btn" href="/about-us/">Meet Southwestern <span class="arrow">→</span></a></div>
[/sws_split][/sws_section]"""),
    HTML('[sws_section class="section--steel" eyebrow="Instructor Courses" title="Certify the Instructors Your Agency Depends On" lead="Two focused, POST-certified programs that turn experienced officers into confident, compliant instructors." center="1"][sws_courses][/sws_section]'),
    HTML('[sws_section class="section--tight"][sws_stats][/sws_section]'),
    HTML('[sws_section eyebrow="Why Southwestern" title="Built by Operators.<br>Proven in the Field."][sws_features][/sws_section]'),
    HTML("""[sws_section class="section--steel"][sws_split img="compliance" alt="Instructor leading an AB 48 briefing with tactical helmet and night vision gear on the table" reverse="1"]
<span class="eyebrow">AB 48 · PC 13652</span>
<h2>Compliance Isn’t a Module. <span class="text-amber">It’s the Foundation.</span></h2>
<p class="lead">AB 48 changed how agencies may use kinetic energy projectiles and chemical agents during assemblies, protests and demonstrations. Our courses integrate those standards into every lesson plan, drill and report — so compliance becomes muscle memory.</p>
[sws_notice title="AB 48 — Certifications Prior to January 2022"]Assembly Bill 48 states that any kinetic energy projectiles and chemical agents shall only be deployed by a peace officer that has received training on their proper use by the Commission on Peace Officer Standards and Training (POST), starting January 2022. <strong>All previous certifications prior to January 2022 have been de-certified.</strong> Southwestern Solutions Chemical Agent and Less Lethal Instructor Courses meet AB 48 requirements and are POST certified.[/sws_notice]
<div class="btn-row"><a class="btn" href="/ab-48-compliance/">Understand AB 48 <span class="arrow">→</span></a><a class="btn btn--ghost" href="/training-schedule/">See Upcoming Classes</a></div>
[/sws_split][/sws_section]"""),
    HTML('[sws_section eyebrow="How It Works" title="From Registration to Certified Instructor" center="1"][sws_process][/sws_section]'),
    HTML(cta()),
])
page(slug="home", title="Home", menu_order=0, content=home_content,
     seo_title="Law Enforcement Instructor Training San Diego | POST Certified | Southwestern Solutions",
     seo_desc="POST-certified Chemical Agent & Less Lethal Instructor courses in San Diego, CA. AB 48 compliant training taught by tactical operators. Plan IV reimbursable. Reserve a seat.",
     focus_kw="law enforcement instructor training San Diego",
     hero="training-launcher.webp")

# 2. ABOUT -----------------------------------------------------------------
about_content = "\n\n".join([
    HTML("""[sws_section][sws_split img="instructor-scope" alt="Southwestern Solutions instructor observing a tactical operator during training" badge="Years of Experience" badge_num="50+"]
<span class="eyebrow">Our Mission</span>
<h2>Prepare the Instructors Who Prepare Everyone Else</h2>
<p>Southwestern Solutions is a San Diego–based provider of POST-certified law enforcement instructor training. We focus on the disciplines where training quality has the greatest impact on public safety, officer safety and agency liability: chemical agents and less-lethal munitions.</p>
<p>Our instructors are former and current Law Enforcement Tactical Operators with over 50 years of experience. We bring that experience to every class we teach.</p>
<div class="btn-row"><a class="btn" href="/courses/">Explore Courses <span class="arrow">→</span></a></div>
[/sws_split][/sws_section]"""),
    HTML('[sws_section class="section--steel" eyebrow="What We Stand For" title="Our Standards" center="1"][sws_features items="shield|Integrity First|We teach the law as it is written and the tactics as they are practiced — no shortcuts, no exaggeration.;;scale|Accountability|Every technique is paired with the policy, documentation and use-of-force review that make it defensible.;;users|Instructor Development|We don’t just certify skills. We build teachers who can transfer them to an entire agency.;;target|Realism|Scenario-driven practical work that mirrors the conditions officers will actually face.;;book|Current Curriculum|Lesson plans updated for AB 48, Penal Code 13652 and evolving POST guidance.;;badge|Respect for Your Budget|POST Plan IV reimbursable courses designed to deliver maximum value per training hour."][/sws_section]'),
    HTML('[sws_section class="section--tight"][sws_stats][/sws_section]'),
    HTML(cta("Train With Operators Who’ve Been There", "Talk with our team about seats, hosting a course or Plan IV eligibility.", "Contact Our Team", "/contact/")),
])
page(slug="about-us", title="About Southwestern Solutions", menu_order=1, layout="sections", content=about_content,
     eyebrow="About Us", subtitle="Instructor-level law enforcement training from San Diego, built by tactical operators for law enforcement agencies.",
     seo_title="About Southwestern Solutions | Tactical Instructor Training San Diego",
     seo_desc="Meet Southwestern Solutions: San Diego law enforcement trainers and tactical operators delivering POST-certified chemical agent and less-lethal instructor courses.",
     focus_kw="tactical instructor training San Diego", hero="night-ops.webp")

# 3. COURSES -----------------------------------------------------------------
courses_content = "\n\n".join([
    HTML('[sws_section eyebrow="POST-Certified Programs" title="Instructor Courses" lead="Each program is built to certify instructors who can teach, evaluate and document proficiency inside their own agency — fully aligned with AB 48 and Penal Code 13652." center="1"][sws_courses][/sws_section]'),
    HTML('[sws_section class="section--steel" eyebrow="Included In Every Course" title="What Sets Our Training Apart"][sws_features cols="4" items="badge|POST Certified|POST-certified instructor-level courses.;;dollar|Plan IV Reimbursable|Tuition eligible for POST Plan IV reimbursement.;;scale|AB 48 Coverage|PC 13652 standards taught, drilled and documented.;;target|Practical Evaluation|Hands-on drills and scenarios, not just lecture."][/sws_section]'),
    HTML('[sws_section eyebrow="Process" title="How to Enroll" center="1"][sws_process][/sws_section]'),
    HTML(cta("Secure Seats for Your Officers", "Classes are capped to protect instructor-to-student ratios. Reserve early.", "Request Seats", "/contact/")),
])
page(slug="courses", title="Law Enforcement Instructor Courses", menu_order=2, layout="sections", content=courses_content,
     eyebrow="Courses", subtitle="Chemical Agent Instructor and Less Lethal Instructor certification for law enforcement.",
     seo_title="POST Certified Instructor Courses | Chemical Agent & Less Lethal",
     seo_desc="Compare Southwestern Solutions' POST-certified Chemical Agent Instructor (40 hr) and Less Lethal Instructor (30 hr) courses. AB 48 compliant, Plan IV reimbursable.",
     focus_kw="POST certified instructor courses", hero="night-ops.webp")

# 4. CHEMICAL AGENT ------------------------------------------------------------
chem_content = "\n\n".join([
    HTML("""[sws_section][sws_split img="chemical-agent" alt="APR and gloves used in the Chemical Agent Instructor Course" badge="Hour Course" badge_num="40"]
<span class="eyebrow">Course Overview</span>
<h2>Chemical Agent Instructor Course</h2>
<p class="lead">A 40-hour, POST-certified instructor course that prepares officers to teach, deploy and document chemical agents safely, lawfully and effectively.</p>
""" + checklist([
        "Review of use of force and related agency policies",
        "Deployment techniques and munition selection",
        "APR use",
        "Use of chemical agent munitions",
        "Decontamination and aftercare",
        "Instruction techniques and lesson-plan development",
        "Scenario exercises — including AB 48 / PC 13652 requirements",
    ]) + """
<p class="price">$1,881 <small>tuition per student · POST Plan IV reimbursable</small></p>
<div class="btn-row"><a class="btn" href="/product/chemical-agent-instructor-course/">Register Online <span class="arrow">→</span></a><a class="btn btn--ghost" href="/training-schedule/">View Dates</a></div>
[/sws_split][/sws_section]"""),
    HTML('[sws_section class="section--steel" eyebrow="Learning Outcomes" title="What Your Instructors Will Master"][sws_features items="scale|Legal Framework|Use-of-force standards, agency policy review and AB 48 / Penal Code 13652 restrictions on crowd-control deployment.;;mask|APR Use|Air-purifying respirator fitting, inspection, clearing and confidence exercises that build trust in the equipment.;;target|Deployment Methods|Delivery systems, munition characteristics, wind and terrain considerations and team coordination.;;shield|Decontamination|Officer and subject decontamination, medical considerations and aftercare protocols.;;book|Teaching Methodology|Building lesson plans, running safe exposures and evaluating student proficiency.;;users|Scenarios|Realistic practical exercises that integrate warnings, dispersal time and documentation."][/sws_section]'),
    HTML("""[sws_section eyebrow="At a Glance" title="Course Details"]<div class="table-scroll"><table class="schedule"><tbody>
<tr><th>Duration</th><td>40 hours (instructor level)</td></tr>
<tr><th>Certification</th><td>POST certified</td></tr>
<tr><th>Reimbursement</th><td>POST Plan IV (tuition)</td></tr>
<tr><th>Tuition</th><td>$1,881 per student</td></tr>
<tr><th>Compliance</th><td>AB 48 / Penal Code 13652 taught in course</td></tr>
<tr><th>Location</th><td>San Diego and select host agencies</td></tr>
</tbody></table></div>[/sws_section]"""),
    HTML('[sws_section class="section--steel" eyebrow="FAQ" title="Chemical Agent Course Questions"]' + faq_html(CHEM_FAQ) + "[/sws_section]"),
    HTML(cta("Certify Your Next Chemical Agent Instructor", "Seats are limited. Reserve now or ask us about hosting this course at your agency.", "Reserve a Seat", "/contact/?course=Chemical")),
])
page(slug="chemical-agent-instructor-course", title="Chemical Agent Instructor Course", menu_order=3, layout="sections", content=chem_content,
     eyebrow="40-Hour · POST Certified · AB 48", subtitle="Teach chemical agent deployment, APR use and decontamination with confidence — and full AB 48 compliance.",
     seo_title="Chemical Agent Instructor Course San Diego | 40-Hr POST Certified | AB 48",
     seo_desc="40-hour POST-certified Chemical Agent Instructor Course in San Diego. Use of force, deployment, APR use, decontamination and AB 48 / PC 13652. Plan IV.",
     focus_kw="chemical agent instructor course", hero="hero-1.webp", faq=True,
     course={"name": "Chemical Agent Instructor Course", "description": "40-hour POST-certified instructor course covering use of force, chemical agent deployment, APR use, munitions, decontamination, instruction techniques and AB 48 / Penal Code 13652 requirements.", "workload": "PT40H", "price": "1881", "credential": "Chemical Agent Instructor certificate (POST certified course)", "location": "San Diego County, CA"})

# 5. LESS LETHAL -----------------------------------------------------------------
ll_content = "\n\n".join([
    HTML("""[sws_section][sws_split img="training-launcher" alt="Officer deploying a less-lethal launcher during a Southwestern Solutions instructor course" badge="Hour Course" badge_num="30"]
<span class="eyebrow">Course Overview</span>
<h2>Less Lethal Instructor Course</h2>
<p class="lead">A 30-hour, POST-certified instructor course that builds officers into instructors capable of running safe, defensible kinetic energy projectile programs — with AB 48 requirements and compliance covered in depth.</p>
""" + checklist([
        "Legal standards, use-of-force policy and AB 48 / PC 13652",
        "Less-lethal platforms, munitions and their characteristics",
        "Target areas, distances and prohibited targeting",
        "Marksmanship, malfunctions and safe range operations",
        "Medical considerations and post-deployment procedures",
        "Documentation, reporting and instructor methodology",
    ]) + """
<p class="price">$1,200 <small>tuition per student · POST Plan IV reimbursable</small></p>
<div class="btn-row"><a class="btn" href="/product/less-lethal-instructor-course/">Register Online <span class="arrow">→</span></a><a class="btn btn--ghost" href="/training-schedule/">View Dates</a></div>
[/sws_split][/sws_section]"""),
    HTML('[sws_section class="section--steel" eyebrow="Learning Outcomes" title="Build a Defensible Less-Lethal Program"][sws_features items="scale|Law & Policy|How Penal Code 13652 limits kinetic energy projectiles in crowd situations and what that means for your policy.;;target|Precision & Targeting|Shot placement, distance considerations and the prohibition on targeting the head, neck and vital organs.;;shield|Safe Range Operations|Range safety plans, malfunction clearance and qualification standards your agency can adopt.;;users|Teaching Skills|Structuring courses, coaching shooters and evaluating proficiency fairly and consistently.;;book|Documentation|Report writing, deployment documentation and the data agencies must track for public reporting.;;badge|Certification Pathway|Graduate ready to lead and maintain your agency’s less-lethal program."][/sws_section]'),
    HTML("""[sws_section eyebrow="At a Glance" title="Course Details"]<div class="table-scroll"><table class="schedule"><tbody>
<tr><th>Duration</th><td>30 hours (instructor level)</td></tr>
<tr><th>Certification</th><td>POST certified</td></tr>
<tr><th>Reimbursement</th><td>POST Plan IV (tuition)</td></tr>
<tr><th>Tuition</th><td>$1,200 per student</td></tr>
<tr><th>Compliance</th><td>AB 48 requirements and compliance covered</td></tr>
<tr><th>Location</th><td>San Diego and select host agencies</td></tr>
</tbody></table></div>[/sws_section]"""),
    HTML('[sws_section class="section--steel" eyebrow="FAQ" title="Less Lethal Course Questions"]' + faq_html(LL_FAQ) + "[/sws_section]"),
    HTML(cta("Lead Your Agency’s Less-Lethal Program", "Reserve a seat or bring the course to your training facility.", "Reserve a Seat", "/contact/?course=Less")),
])
page(slug="less-lethal-instructor-course", title="Less Lethal Instructor Course", menu_order=4, layout="sections", content=ll_content,
     eyebrow="30-Hour · POST Certified · AB 48", subtitle="Certify instructors to train, qualify and document kinetic energy projectile use the right way.",
     seo_title="Less Lethal Instructor Course San Diego | 30-Hr POST | AB 48 Compliant",
     seo_desc="30-hour POST-certified Less Lethal Instructor Course in San Diego. Kinetic energy projectiles, targeting, range safety, documentation and AB 48 compliance. Plan IV.",
     focus_kw="less lethal instructor course", hero="training-launcher.webp", faq=True,
     course={"name": "Less Lethal Instructor Course", "description": "30-hour POST-certified instructor course covering kinetic energy projectile platforms, targeting standards, range safety, documentation, teaching methodology and AB 48 compliance.", "workload": "PT30H", "price": "1200", "credential": "Less Lethal Instructor certificate (POST certified course)", "location": "San Diego, CA"})

# 6. AB 48 -----------------------------------------------------------------------
ab48 = prose("""
## What Is AB 48?
Assembly Bill 48 (2021) added **Section 13652 to the Penal Code**, effective January 1, 2022. It restricts how law enforcement agencies may use kinetic energy projectiles and chemical agents to disperse an assembly, protest or demonstration — and it ties lawful use directly to training.

[sws_notice title="AB 48 — Certifications Prior to January 2022"]Assembly Bill 48 states that any kinetic energy projectiles and chemical agents shall only be deployed by a peace officer that has received training on their proper use by the Commission on Peace Officer Standards and Training (POST), starting January 2022. <strong>All previous certifications prior to January 2022 have been de-certified.</strong> Southwestern Solutions Chemical Agent and Less Lethal Instructor Courses meet AB 48 requirements and are POST certified.[/sws_notice]

## The Core Requirements
Under PC 13652, kinetic energy projectiles and chemical agents may be used in crowd situations only when objectively reasonable to defend against a threat to life or serious bodily injury, or to bring an objectively dangerous and unlawful situation safely and effectively under control — and only in accordance with conditions that include:
- Attempting de-escalation and other reasonable alternatives when objectively reasonable.
- Repeated, audible announcements of the intent to use these tools and the type to be used, in a manner and languages likely to be understood, when objectively reasonable.
- Reasonable efforts to distinguish individuals engaged in violent acts from those who are not, and targeting only those engaged in violent acts.
- Providing an objectively reasonable opportunity to disperse and leave the scene.
- Never aiming kinetic energy projectiles at the head, neck or other vital organs.
- Not deploying solely because of a curfew violation, a verbal threat or noncompliance with a directive.
- Ensuring medical aid is available or summoned after deployment.

## Reporting Obligations
AB 48 also requires agencies to publish on their websites a summary of each incident in which these tools were used to disperse a crowd (Penal Code 13652.1). Accurate documentation starts in training.

## How Southwestern Solutions Helps
- Our **Chemical Agent Instructor Course** teaches AB 48 / PC 13652 directly inside its 40-hour curriculum.
- Our **Less Lethal Instructor Course** covers AB 48 requirements and compliance throughout its 30 hours.
- Graduates return with lesson plans, drills and documentation practices that support your agency's policy and reporting.

[sws_cta title="Make AB 48 Compliance Second Nature" text="Certify instructors who can teach the law, the tactics and the documentation as one system." button="View Courses" url="/courses/"]

<p class="disclaimer">This summary is for training and educational purposes only and is not legal advice. Refer to the full text of Penal Code sections 13652 and 13652.1, current POST guidelines and your agency's legal counsel.</p>
""")
page(slug="ab-48-compliance", title="AB 48 Compliance Training", menu_order=5, content=ab48,
     eyebrow="Penal Code 13652", subtitle="What AB 48 requires — and how instructor training keeps your agency compliant.",
     seo_title="AB 48 Compliance Training | Penal Code 13652 Explained",
     seo_desc="Understand AB 48 and Penal Code 13652 rules for kinetic energy projectiles and chemical agents, and how POST-certified instructor training supports compliance.",
     focus_kw="AB 48 compliance training", hero="compliance.webp")

# 7. SCHEDULE -----------------------------------------------------------------------
sched = "\n\n".join([
    HTML("""[sws_section eyebrow="Upcoming Sessions" title="Training Schedule" lead="Sessions fill quickly. Contact us to reserve seats or to be notified when new dates are published."]<div class="table-scroll"><table class="schedule">
<thead><tr><th>Course</th><th>Dates</th><th>Location</th><th>Hours</th><th>Tuition</th><th>Status</th><th></th></tr></thead><tbody>
<tr class="is-soldout"><td>Chemical Agent Instructor Course</td><td>December 14 – 18, 2026</td><td>San Diego</td><td>40</td><td>$1,881</td><td><span class="status status--soldout">Sold Out</span></td><td><a class="btn btn--ghost" href="/contact/?course=Chemical">Join Waitlist</a></td></tr>
<tr><td>Less Lethal Instructor Course</td><td>December 9 – 11, 2026</td><td>San Diego</td><td>30</td><td>$1,200</td><td><span class="status status--open">Registration Open</span></td><td><a class="btn" href="/product/less-lethal-instructor-course/">Register</a></td></tr>
<tr><td>Chemical Agent Instructor Course</td><td>February 8 – 12, 2027</td><td>San Diego</td><td>40</td><td>$1,881</td><td><span class="status status--open">Registration Open</span></td><td><a class="btn" href="/product/chemical-agent-instructor-course/">Register</a></td></tr>
</tbody></table></div>
<p class="disclaimer" style="margin-top:20px">Dates and locations are subject to change. Verify current sessions in the POST course catalog or with our team before booking travel.</p>[/sws_section]"""),
    HTML('[sws_section class="section--steel" eyebrow="Can’t Make These Dates?" title="Bring the Course to Your Agency"][sws_split img="hero-2" alt="Police instructor teaching a law enforcement class" reverse="1"]<h3>Host a Course</h3><p>Have a classroom and a suitable outdoor training area? Host a session and train more of your own officers locally while opening remaining seats to neighboring agencies.</p><div class="btn-row"><a class="btn" href="/host-a-course/">Learn About Hosting <span class="arrow">→</span></a></div>[/sws_split][/sws_section]'),
])
page(slug="training-schedule", title="Training Schedule", menu_order=6, layout="sections", content=sched,
     eyebrow="Calendar", subtitle="Upcoming Chemical Agent and Less Lethal Instructor sessions.",
     seo_title="Law Enforcement Training Schedule 2026–2027 | San Diego | Southwestern Solutions",
     seo_desc="Upcoming POST-certified Chemical Agent Instructor and Less Lethal Instructor course dates in San Diego and at host agencies. Reserve seats for your agency today.",
     focus_kw="law enforcement training schedule San Diego", hero="hero-3.webp")

# 8. HOST A COURSE ---------------------------------------------------------------
host = "\n\n".join([
    HTML("""[sws_section][sws_split img="training-launcher" alt="Officers training during an instructor course hosted by an agency"]
<span class="eyebrow">Agency Partnerships</span>
<h2>Train Your Team Without the Travel</h2>
<p class="lead">Hosting a Southwestern Solutions course brings POST-certified instructor training to your own facility — reducing travel time for your officers and giving neighboring agencies access to quality training in your region.</p>
""" + checklist([
        "Train multiple officers locally on your schedule",
        "Reduce travel and overtime costs for your agency",
        "Strengthen regional partnerships by opening seats to nearby agencies",
        "Course content aligned with AB 48 and your agency policies",
    ]) + """
<div class="btn-row"><a class="btn" href="/contact/?course=Host">Start the Conversation <span class="arrow">→</span></a></div>
[/sws_split][/sws_section]"""),
    HTML('[sws_section class="section--steel" eyebrow="What You Provide" title="Hosting Requirements" center="1"][sws_features items="book|Classroom|A classroom with projector and seating for the class.;;target|Training Area|An outdoor area suitable for practical exercises and deployments (requirements vary by course).;;users|Point of Contact|A coordinator to help with logistics, access and scheduling."][/sws_section]'),
    HTML(cta("Ready to Host?", "Tell us your preferred dates, location and expected class size.", "Request Hosting Info", "/contact/?course=Host")),
])
page(slug="host-a-course", title="Host a Course at Your Agency", menu_order=7, layout="sections", content=host,
     eyebrow="For Agencies", subtitle="Bring POST-certified instructor training to your own facility.",
     seo_title="Host a Law Enforcement Training Course | On-Site Agency Training",
     seo_desc="Host a POST-certified Chemical Agent or Less Lethal Instructor course at your agency. Train officers locally, cut travel costs and stay AB 48 compliant.",
     focus_kw="host law enforcement training course", hero="hero-2.webp")

# 9. FAQ -------------------------------------------------------------------------
faq_all = CHEM_FAQ[:2] + LL_FAQ[:2] + [
    ("What does POST Plan IV reimbursement cover?", "Plan IV reimburses tuition for eligible POST-certified courses. It does not cover travel or per diem. Your agency training manager can confirm eligibility and submit the request."),
    ("How do I register?", "Use the contact form or call " + PHONE + ". Our team confirms seat availability, sends registration details and answers Plan IV questions."),
    ("Can we host a course at our agency?", "Yes. Agencies with a classroom and a suitable outdoor training area can host a session. Visit our Host a Course page or contact us to discuss dates."),
    ("Where are you located?", "Southwestern Solutions is based in San Diego and delivers courses in San Diego County and at host agencies."),
]
page(slug="faq", title="Frequently Asked Questions", menu_order=8, layout="sections", content=HTML('[sws_section eyebrow="Answers" title="Common Questions"]' + faq_html(faq_all) + "[/sws_section]") + "\n\n" + HTML(cta()), faq=True,
     eyebrow="FAQ", subtitle="Answers about our courses, POST reimbursement, AB 48 and registration.",
     seo_title="FAQ | Chemical Agent & Less Lethal Instructor Courses | Southwestern Solutions",
     seo_desc="Answers about POST Plan IV reimbursement, AB 48 compliance, course length, registration and hosting for Southwestern Solutions instructor courses.",
     focus_kw="less lethal instructor course FAQ", hero="hero-1.webp")

# 10. CONTACT ----------------------------------------------------------------------
contact = HTML("""[sws_section]<div class="split" id="contact-form"><div data-reveal="left"><span class="eyebrow">Get in Touch</span><h2>Reserve Seats or Ask a Question</h2><p class="lead">Tell us about your agency and the training you need. We reply within one business day.</p>[sws_contact_info]</div><div class="card" data-reveal="right">[sws_contact_form]</div></div>[/sws_section]""")
page(slug="contact", title="Contact Southwestern Solutions", menu_order=9, layout="sections", content=contact,
     eyebrow="Contact", subtitle="Reserve seats, request hosting information or ask about Plan IV reimbursement.",
     seo_title="Contact Southwestern Solutions | Reserve Instructor Course Seats | San Diego",
     seo_desc="Contact Southwestern Solutions in San Diego to reserve seats in POST-certified Chemical Agent or Less Lethal Instructor courses. Call +1 (928) 614-0964.",
     focus_kw="contact law enforcement training San Diego", hero="san-diego.webp")

# Privacy Policy page removed at client request (Nov 2026).

# ---------------------------------------------------------------------------
# BLOG POSTS
# ---------------------------------------------------------------------------
POSTS = []

def post(**kw):
    POSTS.append(kw)

# Blog removed at client request (Nov 2026): no posts are imported.

# ---------------------------------------------------------------------------
# MENU
# ---------------------------------------------------------------------------
MENU = [
    ("home", "Home", None),
    ("about-us", "About", None),
    ("courses", "Courses", None),
    ("chemical-agent-instructor-course", "Chemical Agent Instructor", "courses"),
    ("less-lethal-instructor-course", "Less Lethal Instructor", "courses"),
    ("host-a-course", "Host a Course", "courses"),
    ("ab-48-compliance", "AB 48", None),
    ("training-schedule", "Schedule", None),
    ("contact", "Contact", None),
]

# ---------------------------------------------------------------------------
# WXR writer
# ---------------------------------------------------------------------------

def cdata(s):
    return "<![CDATA[" + str(s).replace("]]>", "]]]]><![CDATA[>") + "]]>"

def meta(k, v):
    return f"\t\t<wp:postmeta>\n\t\t\t<wp:meta_key>{cdata(k)}</wp:meta_key>\n\t\t\t<wp:meta_value>{cdata(v)}</wp:meta_value>\n\t\t</wp:postmeta>\n"

def seo_meta(d):
    out = ""
    pairs = {
        "_sws_seo_title": d["seo_title"], "_sws_seo_desc": d["seo_desc"], "_sws_focus_kw": d["focus_kw"],
        "_yoast_wpseo_title": d["seo_title"], "_yoast_wpseo_metadesc": d["seo_desc"], "_yoast_wpseo_focuskw": d["focus_kw"],
        "rank_math_title": d["seo_title"], "rank_math_description": d["seo_desc"], "rank_math_focus_keyword": d["focus_kw"],
        "_sws_hero": d.get("hero", "hero-1.webp"),
    }
    if d.get("robots"):
        pairs["_sws_robots"] = d["robots"]
        pairs["_yoast_wpseo_meta-robots-noindex"] = "1"
        pairs["rank_math_robots"] = 'a:2:{i:0;s:7:"noindex";i:1;s:6:"follow";}'
    for k in ("eyebrow", "subtitle", "layout"):
        if d.get(k):
            pairs["_sws_" + k] = d[k]
    if d.get("faq"):
        pairs["_sws_faq_schema"] = "1"
    if d.get("course"):
        pairs["_sws_course"] = json.dumps(d["course"])
    for k, v in pairs.items():
        out += meta(k, v)
    return out

def item(pid, title, slug, content, ptype, date, parent=0, order=0, excerpt="", extra="", cats=()):
    gmt = date
    link = f"{SITE}/{slug}/" if slug != "home" else f"{SITE}/"
    cat_xml = "".join(f'\t\t<category domain="{d}" nicename="{n}">{cdata(l)}</category>\n' for d, n, l in cats)
    return f"""	<item>
		<title>{cdata(title)}</title>
		<link>{escape(link)}</link>
		<pubDate>Mon, 01 Jan 2026 00:00:00 +0000</pubDate>
		<dc:creator>{cdata('admin')}</dc:creator>
		<guid isPermaLink="false">{escape(SITE)}/?p={pid}</guid>
		<description></description>
		<content:encoded>{cdata(content)}</content:encoded>
		<excerpt:encoded>{cdata(excerpt)}</excerpt:encoded>
		<wp:post_id>{pid}</wp:post_id>
		<wp:post_date>{cdata(date)}</wp:post_date>
		<wp:post_date_gmt>{cdata(gmt)}</wp:post_date_gmt>
		<wp:post_modified>{cdata(date)}</wp:post_modified>
		<wp:post_modified_gmt>{cdata(gmt)}</wp:post_modified_gmt>
		<wp:comment_status>{cdata('closed')}</wp:comment_status>
		<wp:ping_status>{cdata('closed')}</wp:ping_status>
		<wp:post_name>{cdata(slug)}</wp:post_name>
		<wp:status>{cdata('publish')}</wp:status>
		<wp:post_parent>{parent}</wp:post_parent>
		<wp:menu_order>{order}</wp:menu_order>
		<wp:post_type>{cdata(ptype)}</wp:post_type>
		<wp:post_password>{cdata('')}</wp:post_password>
		<wp:is_sticky>0</wp:is_sticky>
{cat_xml}{extra}	</item>
"""

def slugify(s):
    import re
    return re.sub(r"[^a-z0-9]+", "-", s.lower()).strip("-")

def build():
    items, ids = [], {}
    pid = 100
    for p in PAGES:
        pid += 1
        ids[p["slug"]] = pid
    for p in PAGES:
        parent = ids.get(p.get("parent"), 0)
        items.append(item(ids[p["slug"]], p["title"], p["slug"], p["content"], "page", "2026-11-15 08:00:00", parent, p.get("menu_order", 0), "", seo_meta(p)))

    cats = sorted({x["cat"] for x in POSTS})
    tags = sorted({t for x in POSTS for t in x["tags"]})
    pid = 300
    for x in POSTS:
        pid += 1
        c = [("category", slugify(x["cat"]), x["cat"])] + [("post_tag", slugify(t), t) for t in x["tags"]]
        items.append(item(pid, x["title"], x["slug"], x["content"], "post", x["date"], 0, 0, x["excerpt"], seo_meta(x), c))

    # Menu items
    pid = 500
    menu_ids = {}
    for i, (slug, label, parent_slug) in enumerate(MENU):
        pid += 1
        menu_ids[slug] = pid
        extra = (meta("_menu_item_type", "post_type") + meta("_menu_item_menu_item_parent", str(menu_ids.get(parent_slug, 0)))
                 + meta("_menu_item_object_id", str(ids[slug])) + meta("_menu_item_object", "page")
                 + meta("_menu_item_target", "") + meta("_menu_item_classes", 'a:1:{i:0;s:0:"";}')
                 + meta("_menu_item_xfn", "") + meta("_menu_item_url", ""))
        items.append(item(pid, label, f"menu-item-{pid}", "", "nav_menu_item", "2026-11-15 08:00:00", 0, i + 1, "", extra,
                          [("nav_menu", "main-menu", "Main Menu")]))

    term_xml = ""
    tid = 10
    for c in cats:
        tid += 1
        term_xml += f"\t<wp:category>\n\t\t<wp:term_id>{tid}</wp:term_id>\n\t\t<wp:category_nicename>{cdata(slugify(c))}</wp:category_nicename>\n\t\t<wp:category_parent>{cdata('')}</wp:category_parent>\n\t\t<wp:cat_name>{cdata(c)}</wp:cat_name>\n\t</wp:category>\n"
    for t in tags:
        tid += 1
        term_xml += f"\t<wp:tag>\n\t\t<wp:term_id>{tid}</wp:term_id>\n\t\t<wp:tag_slug>{cdata(slugify(t))}</wp:tag_slug>\n\t\t<wp:tag_name>{cdata(t)}</wp:tag_name>\n\t</wp:tag>\n"
    tid += 1
    term_xml += f"\t<wp:term>\n\t\t<wp:term_id>{tid}</wp:term_id>\n\t\t<wp:term_taxonomy>{cdata('nav_menu')}</wp:term_taxonomy>\n\t\t<wp:term_slug>{cdata('main-menu')}</wp:term_slug>\n\t\t<wp:term_name>{cdata('Main Menu')}</wp:term_name>\n\t</wp:term>\n"

    xml = f"""<?xml version="1.0" encoding="UTF-8" ?>
<!-- WordPress eXtended RSS export — Southwestern Solutions redesign -->
<!-- Import: Tools → Import → WordPress → upload this file. Activate the "Southwestern Solutions" theme first. -->
<rss version="2.0"
	xmlns:excerpt="http://wordpress.org/export/1.2/excerpt/"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:wp="http://wordpress.org/export/1.2/"
>
<channel>
	<title>Southwestern Solutions</title>
	<link>{SITE}</link>
	<description>POST-Certified Law Enforcement Instructor Training in San Diego</description>
	<pubDate>Sun, 15 Nov 2026 08:00:00 +0000</pubDate>
	<language>en-US</language>
	<wp:wxr_version>1.2</wp:wxr_version>
	<wp:base_site_url>{SITE}</wp:base_site_url>
	<wp:base_blog_url>{SITE}</wp:base_blog_url>
	<wp:author><wp:author_id>1</wp:author_id><wp:author_login>{cdata('admin')}</wp:author_login><wp:author_email>{cdata(EMAIL)}</wp:author_email><wp:author_display_name>{cdata('Southwestern Solutions')}</wp:author_display_name><wp:author_first_name>{cdata('')}</wp:author_first_name><wp:author_last_name>{cdata('')}</wp:author_last_name></wp:author>
{term_xml}	<generator>https://wordpress.org/?v=6.7</generator>
{''.join(items)}</channel>
</rss>
"""
    os.makedirs(os.path.dirname(OUT), exist_ok=True)
    with open(OUT, "w", encoding="utf-8") as f:
        f.write(xml)
    print(f"Wrote {OUT}: {len(PAGES)} pages, {len(POSTS)} posts, {len(MENU)} menu items")

if __name__ == "__main__":
    build()
