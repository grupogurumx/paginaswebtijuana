# -*- coding: utf-8 -*-
"""Page content for the Agave Taco Shop WordPress import (English, US market).

Mini-markup understood by build_wxr.py:
  ## / ###  headings      - item  bullet list     > quote
  lines starting with "<"  raw HTML block          blank line  new block
"""

PAGES = [
    {
        "slug": "home",
        "title": "Home",
        "template": "",
        "order": 0,
        "excerpt": "",
        "seo_title": "Agave Taco Shop | Best Birria Tacos & Quesabirria in Point Loma, San Diego",
        "seo_desc": "Famous quesabirria and birria tacos with consommé, California burritos and breakfast burritos from 7 AM. Drive-thru, delivery & catering in Point Loma, San Diego.",
        "focus_kw": "birria tacos San Diego",
        "body": """
Agave Taco Shop is Point Loma's home of slow-braised birria, cheesy quesabirria tacos with consommé, San Diego-style California burritos and breakfast burritos served from 7 AM every day. Visit us at 4111 W Point Loma Blvd, roll through the drive-thru, or order online for pickup and delivery.
""",
    },
    {
        "slug": "menu",
        "title": "Menu",
        "template": "page-templates/template-menu.php",
        "order": 1,
        "excerpt": "Slow-braised birria, quesabirria with consommé, street tacos, California burritos and breakfast from 7 AM — all made to order in Point Loma.",
        "seo_title": "Menu | Quesabirria, Birria Tacos, Burritos & Breakfast | Agave Taco Shop San Diego",
        "seo_desc": "See the Agave Taco Shop menu: quesabirria tacos with consommé, birria burritos & fries, carne asada, California burritos, breakfast burritos and aguas frescas in Point Loma.",
        "focus_kw": "quesabirria menu San Diego",
        "body": """
<p class="agave-lead">Everything on our menu is made to order — from the birria that braises for hours to the salsas we blend every morning. Start with the quesabirria, stay for everything else.</p>

Looking for the <strong>best birria tacos in San Diego</strong>? You are in the right place. Our birria de res is marinated overnight in a guajillo and ancho chile adobo, slow-braised until it falls apart, and served with the rich consommé it was cooked in. Pair it with an ice-cold horchata and you will understand why Point Loma lines up.
""",
    },
    {
        "slug": "our-story",
        "title": "Our Story",
        "template": "page-templates/template-landing.php",
        "order": 2,
        "kicker": "Family recipe · Point Loma pride",
        "excerpt": "A family birria recipe, a promise of no shortcuts and a taco shop on West Point Loma Boulevard that feeds San Diego from sunrise to midnight.",
        "seo_title": "Our Story | Family-Owned Mexican Taco Shop in Point Loma, San Diego",
        "seo_desc": "Meet Agave Taco Shop: a family-owned Mexican taco shop in Point Loma built on an authentic birria recipe, made-from-scratch salsas and real San Diego hospitality.",
        "focus_kw": "family owned taco shop Point Loma",
        "body": """
<p class="agave-lead">Some recipes are written down. Ours was handed down — tasted, adjusted and perfected around a family table long before it ever reached a plancha in San Diego.</p>

## Born from birria

Agave began with one dish: <strong>birria de res</strong>, the slow-braised, chile-red stew from Jalisco that turns a simple taco into a ritual. Our founder, Juan Pablo Oceguera, first shared that family recipe with North County at Agave Birrieria in Encinitas. The response was immediate — lines out the door, regulars on a first-name basis and a city asking for more.

So we brought the birria south to Point Loma. At 4111 West Point Loma Boulevard, Agave Taco Shop became the neighborhood spot where surfers grab breakfast burritos at 7 AM, families share birria fries on the patio and night owls chase the perfect quesabirria until midnight on weekends.

<div class="agave-quote-band"><p>“No shortcuts. If it takes all night to braise the birria, then it takes all night.”</p><cite>— The Agave kitchen rule</cite></div>

## What we believe

<div class="agave-feature-grid">
<div class="agave-feature"><span class="agave-feature__icon">🔥</span><h3>Slow food, served fast</h3><p>Our birria braises for hours so your order can be ready in minutes — at the counter, the drive-thru or your door.</p></div>
<div class="agave-feature"><span class="agave-feature__icon">🌶</span><h3>Scratch-made, daily</h3><p>Salsas, consommé, guacamole and aguas frescas are made in-house every single day.</p></div>
<div class="agave-feature"><span class="agave-feature__icon">🤝</span><h3>Family hospitality</h3><p>Generous portions, friendly faces and a “welcome back” every time you return.</p></div>
<div class="agave-feature"><span class="agave-feature__icon">🌊</span><h3>Point Loma proud</h3><p>Minutes from Ocean Beach, Liberty Station and the Midway District — your neighborhood taco shop.</p></div>
</div>

## Our journey

<ul class="agave-timeline">
<li><strong>The family table</strong>A birria recipe passed down through generations, built on dried chiles, patience and love.</li>
<li><strong>2021 · Agave Birrieria, Encinitas</strong>The first Agave opens in North County and quickly becomes a birria destination.</li>
<li><strong>2022 · Agave Taco Shop, Point Loma</strong>We open on West Point Loma Blvd with a full taco shop menu, breakfast from 7 AM and a drive-thru.</li>
<li><strong>Today</strong>Serving San Diego from sunrise to late night, plus catering for parties, offices and celebrations across the county.</li>
</ul>

## Come hungry

Whether it is your first quesabirria or your hundredth California burrito, we cannot wait to feed you. <a href="/menu/">Explore the menu</a>, <a href="/visit/">find us in Point Loma</a> or <a href="/catering/">bring Agave to your next event</a>.
""",
    },
    {
        "slug": "catering",
        "title": "Catering",
        "template": "page-templates/template-catering.php",
        "order": 3,
        "excerpt": "Birria bars, street taco bars and burrito boxes for parties, offices and celebrations anywhere in San Diego.",
        "seo_title": "Taco Catering San Diego | Birria & Taco Bar Catering | Agave Taco Shop",
        "seo_desc": "Book taco catering in San Diego: birria & quesabirria bars, street taco bars, burrito boxes and aguas frescas for offices, birthdays, weddings and parties. Request a quote.",
        "focus_kw": "taco catering San Diego",
        "body": """
<p class="agave-lead">Feeding a crowd should feel like a fiesta, not a chore. Agave catering brings San Diego's favorite birria and street tacos to your office, backyard or venue — hot, fresh and ready to impress.</p>

## Catering packages

<div class="agave-packages">
<div class="agave-package agave-package--featured"><p class="agave-package__for">Most popular</p><h3>Birria Bar</h3><ul><li>Slow-braised birria de res</li><li>Corn tortillas &amp; melted cheese for quesabirria</li><li>Hot consommé for dipping</li><li>Onion, cilantro, limes &amp; salsas</li><li>Rice &amp; beans</li></ul></div>
<div class="agave-package"><p class="agave-package__for">Crowd pleaser</p><h3>Street Taco Bar</h3><ul><li>Choose up to 3: carne asada, carnitas, pollo asado, birria</li><li>Warm corn tortillas</li><li>Guacamole, pico de gallo &amp; salsas</li><li>Rice, beans &amp; chips</li></ul></div>
<div class="agave-package"><p class="agave-package__for">Meetings &amp; game days</p><h3>Burrito Boxes</h3><ul><li>California, carne asada, birria or bean &amp; cheese</li><li>Individually wrapped &amp; labeled</li><li>Chips &amp; salsa</li><li>Perfect for offices and teams</li></ul></div>
<div class="agave-package"><p class="agave-package__for">Early starts</p><h3>Breakfast Burrito Trays</h3><ul><li>Bacon, chorizo or carnitas &amp; egg</li><li>Vegetarian options</li><li>Salsa roja &amp; verde</li><li>Ready as early as 7 AM</li></ul></div>
</div>

Add <strong>horchata and jamaica by the gallon</strong>, chips and guacamole, or extra consommé to any package.

## Perfect for

- Office lunches and corporate meetings in Point Loma, Liberty Station, Downtown and Sorrento Valley
- Birthdays, graduations, quinceañeras and family reunions
- Rehearsal dinners, weddings and engagement parties
- Game days, team celebrations and school events
- Beach days and bonfires at Ocean Beach, Mission Bay and beyond

## How it works

<ul class="agave-timeline">
<li><strong>1. Tell us about your event</strong>Send the date, headcount and location with the form on this page or call (619) 230-5282.</li>
<li><strong>2. Get your custom menu</strong>We recommend quantities, build your menu and send a clear quote within one business day.</li>
<li><strong>3. We cook, you celebrate</strong>Pick up your order hot and ready in Point Loma, or ask us about delivery and setup options.</li>
</ul>

## Catering FAQ

<details class="faq"><summary>How far in advance should I book taco catering?</summary><p>We recommend booking at least 72 hours ahead, and one to two weeks ahead for weekends, holidays and groups of 75+ guests. Last-minute request? Call us — we will always try to make it happen.</p></details>
<details class="faq"><summary>What is the minimum order for catering?</summary><p>Catering packages start at 10 guests. For smaller groups, our online ordering is the fastest way to order family-size quantities.</p></details>
<details class="faq"><summary>Do you offer vegetarian options?</summary><p>Yes. Bean and cheese burritos, cheese quesadillas, veggie-friendly sides, rice, beans, guacamole and fresh salsas are available for every package.</p></details>
<details class="faq"><summary>Do you deliver catering orders in San Diego?</summary><p>Pickup in Point Loma is always available. Delivery and on-site setup may be available depending on date, distance and group size — just ask when you request your quote.</p></details>
<details class="faq"><summary>How is the birria kept hot?</summary><p>Birria and consommé are packed in insulated containers so you can serve them hot and fresh. We include simple serving instructions with every order.</p></details>
""",
    },
    {
        "slug": "visit",
        "title": "Visit Us",
        "template": "page-templates/template-visit.php",
        "order": 4,
        "excerpt": "4111 W Point Loma Blvd, San Diego. Open daily from 7 AM, until midnight on Fridays and Saturdays. Drive-thru, patio and easy parking.",
        "seo_title": "Hours & Location | Taco Shop near Ocean Beach & Point Loma | Agave Taco Shop",
        "seo_desc": "Visit Agave Taco Shop at 4111 W Point Loma Blvd, San Diego, CA 92110. Open 7 AM daily, until midnight Fri–Sat. Drive-thru, patio seating and parking near Ocean Beach.",
        "focus_kw": "taco shop Point Loma",
        "body": """
## Your taco shop in Point Loma

Agave Taco Shop sits on West Point Loma Boulevard, just minutes from <strong>Ocean Beach</strong>, the <strong>Midway District</strong>, <strong>Loma Portal</strong>, <strong>Liberty Station</strong> and the sports arena area. It is the easy stop on the way to the beach, after a game, or whenever the birria craving hits.

- <strong>Drive-thru:</strong> open during all business hours — perfect for breakfast burritos on the way to work.
- <strong>Patio seating:</strong> grab a table outside and enjoy your quesabirria with a little San Diego sunshine.
- <strong>Parking:</strong> on-site and street parking available.
- <strong>Late night:</strong> open until midnight on Fridays and Saturdays.

## Hours

<p><strong>Sunday – Thursday:</strong> 7:00 AM – 10:00 PM<br><strong>Friday – Saturday:</strong> 7:00 AM – 12:00 AM</p>

Holiday hours may vary — follow <a href="https://www.instagram.com/agavetacoshop/" target="_blank" rel="noopener">@agavetacoshop</a> on Instagram for updates and daily specials.

## Our sister restaurant

Craving Agave in North County? Visit <strong>Agave Birrieria</strong> at 865 Orpheus Ave, Encinitas, CA 92024 — the birrieria where it all began.

## Visit FAQ

<details class="faq"><summary>What time does Agave Taco Shop open?</summary><p>We open at 7:00 AM every day, serving breakfast burritos and the full menu.</p></details>
<details class="faq"><summary>Is Agave Taco Shop open late?</summary><p>Yes. We are open until 10:00 PM Sunday through Thursday and until midnight on Friday and Saturday.</p></details>
<details class="faq"><summary>Does Agave Taco Shop have a drive-thru?</summary><p>Yes, our Point Loma drive-thru is open during all business hours.</p></details>
<details class="faq"><summary>Can I order Agave for delivery?</summary><p>Yes. Order pickup directly online, or get delivery through DoorDash, Uber Eats and Postmates.</p></details>
""",
    },
    {
        "slug": "contact",
        "title": "Contact",
        "template": "page-templates/template-contact.php",
        "order": 5,
        "excerpt": "Questions, large orders, feedback or partnerships — we would love to hear from you.",
        "seo_title": "Contact Agave Taco Shop | Point Loma, San Diego | (619) 230-5282",
        "seo_desc": "Contact Agave Taco Shop in Point Loma, San Diego. Call (619) 230-5282, visit 4111 W Point Loma Blvd or send us a message about orders, catering and feedback.",
        "focus_kw": "Agave Taco Shop contact",
        "body": """
<p class="agave-lead">Have a question about the menu, a big order for the team or a shout-out for our crew? Send us a message or give us a call — a real person will get back to you.</p>

For <strong>same-day orders</strong>, the fastest way is to <a href="https://order.toasttab.com/online/agave-taco-shop-4111-w-point-loma-blvd" target="_blank" rel="noopener">order online</a> or call us directly. For events of 10+ guests, visit our <a href="/catering/">catering page</a>.
""",
    },
    {
        "slug": "blog",
        "title": "Blog",
        "template": "",
        "order": 6,
        "excerpt": "",
        "seo_title": "The Agave Journal | Birria, Tacos & San Diego Food Guides",
        "seo_desc": "Birria deep-dives, California burrito history, catering tips and local San Diego food guides from the team at Agave Taco Shop in Point Loma.",
        "focus_kw": "San Diego taco blog",
        "body": "",
    },
    {
        "slug": "privacy-policy",
        "title": "Privacy Policy",
        "template": "",
        "order": 7,
        "excerpt": "",
        "seo_title": "Privacy Policy | Agave Taco Shop",
        "seo_desc": "How Agave Taco Shop collects, uses and protects the information you share through our website, forms and online ordering partners.",
        "focus_kw": "",
        "noindex": True,
        "body": """
This website is operated by Agave Taco Shop, 4111 W Point Loma Blvd, San Diego, CA 92110.

## Information we collect

When you use our contact or catering forms we collect the details you provide (such as your name, email, phone number and event details) solely to respond to your request. We do not sell your personal information.

## Online ordering and delivery

Online orders are processed by our ordering partners (such as Toast, DoorDash, Uber Eats and Postmates). Their own privacy policies apply to information you provide on their platforms.

## Cookies and analytics

We may use basic cookies and analytics tools to understand how visitors use our site and to improve it. You can disable cookies in your browser settings.

## Your rights

California residents may request access to or deletion of their personal information. Contact us at (619) 230-5282 or through our contact page.

## Updates

We may update this policy from time to time. Changes take effect when posted on this page.
""",
    },
]
