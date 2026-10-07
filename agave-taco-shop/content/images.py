# -*- coding: utf-8 -*-
"""Image library imported into the WordPress Media Library.

Keys match agave_image_library() in the theme (inc/business.php): the theme
looks up the attachment slug "agave-<key>" first and falls back to the remote URL.

Sources
- Freepik / Magnific stock (free licence — credit "Freepik" in the footer, already included).
  With a Freepik/Magnific Premium plan, download the high-res originals (no attribution needed)
  and re-upload them with the same slug.
- Magnific AI (generated for this project) — signed URL valid until 2026-10-10.
  Import before that date or download it from your Magnific "Personal" project.
"""

FP = "https://img.magnific.com/free-photo/"

IMAGES = {
    "hero-ai-quesabirria": {
        "url": "https://pikaso.cdnpk.net/private/production/5657334566/render.jpg?token=exp=1791590400~hmac=fbe6473b4bcd8007c75196f3efb335b1b0a7eb73165d14e1528c3430bd6e17e0",
        "title": "Quesabirria tacos with consommé — panoramic hero (AI, Magnific)",
        "alt": "Crispy quesabirria tacos with melted cheese and a cup of birria consommé at sunset, Agave Taco Shop San Diego",
        "source": "Magnific AI (Nano Banana 2 Lite) — generated for Agave Taco Shop",
    },
    "hero-quesabirria": {"url": FP + "banner-delicious-tacos_23-2150831065.jpg", "title": "Birria tacos panoramic banner", "alt": "Panoramic spread of birria tacos with salsa and lime in Point Loma, San Diego", "source": "Freepik #69799362"},
    "hero-birria-night": {"url": FP + "hand-reaching-fresh-tacos-wooden-board-candlelight_1308-189504.jpg", "title": "Fresh tacos by candlelight", "alt": "Hand reaching for fresh birria tacos on a wooden board", "source": "Freepik #427586315"},
    "hero-sunrise": {"url": FP + "perfect-burrito_23-2147640348.jpg", "title": "The perfect burrito", "alt": "Breakfast burrito wrapped and ready at Agave Taco Shop, open 7 AM", "source": "Freepik #1172226"},
    "hero-catering": {"url": FP + "high-angle-delicious-taco-mexican-party_23-2149362784.jpg", "title": "Mexican taco party spread", "alt": "Taco catering party spread for an event in San Diego", "source": "Freepik #24957767"},
    "hero-drive-thru": {"url": FP + "banner-delicious-tacos_23-2150831069.jpg", "title": "Tacos to go banner", "alt": "Tacos ready for drive-thru pickup and delivery in Point Loma", "source": "Freepik #69799361"},
    "dish-quesabirria": {"url": FP + "delicious-tacos-arrangement_23-2150878147.jpg", "title": "Quesabirria tacos", "alt": "Quesabirria tacos with consommé — Agave Taco Shop San Diego", "source": "Freepik #72264563"},
    "dish-street-tacos": {"url": FP + "closeup-mexican-tasty-tacos-de-pastor-plate_181624-42045.jpg", "title": "Street tacos", "alt": "Carne asada street tacos with onion and cilantro", "source": "Freepik #16538903"},
    "dish-california": {"url": FP + "mexican-burrito-with-rice_1147-395.jpg", "title": "California burrito", "alt": "California burrito with carne asada and fries, a San Diego icon", "source": "Freepik #1055231"},
    "dish-breakfast": {"url": FP + "burrito-with-rice_1147-391.jpg", "title": "Breakfast burrito", "alt": "Bacon breakfast burrito in Point Loma near Ocean Beach", "source": "Freepik #1055227"},
    "dish-fries": {"url": FP + "garnished-delicious-mexican-nachos-plate-with-tacos_23-2148042533.jpg", "title": "Birria fries", "alt": "Birria fries smothered with cheese, onion and cilantro", "source": "Freepik #3775858"},
    "dish-aguas": {"url": FP + "glasses-refreshing-hibiscus-ice-tea_23-2149893654.jpg", "title": "Aguas frescas — jamaica", "alt": "Jamaica hibiscus agua fresca at Agave Taco Shop", "source": "Freepik #34136087"},
    "dish-menudo": {"url": FP + "top-view-appetizing-pozole-bowl_23-2149248554.jpg", "title": "Menudo", "alt": "Traditional Mexican menudo soup with lime and oregano", "source": "Freepik #22116617"},
    "story-kitchen": {"url": FP + "man-preparing-delicious-food-side-view_23-2149661343.jpg", "title": "In the Agave kitchen", "alt": "Cook preparing fresh tacos in the Agave Taco Shop kitchen", "source": "Freepik #31488552"},
    "story-grill": {"url": FP + "close-up-hand-cooking-delicious-meat_23-2148723235.jpg", "title": "On the plancha", "alt": "Carne asada sizzling on the grill", "source": "Freepik #10753198"},
    "catering-spread": {"url": FP + "people-enjoying-mexican-barbecue_23-2151000341.jpg", "title": "Taco catering in San Diego", "alt": "Friends enjoying a taco catering spread at a San Diego party", "source": "Freepik #94956607"},
    "catering-table": {"url": FP + "top-view-delicious-mexican-food-with-guacamole_23-2148614474.jpg", "title": "Taco bar table", "alt": "Taco bar with guacamole and salsas for catering", "source": "Freepik #9332553"},
    "gallery-hands": {"url": FP + "hands-holding-delicious-tacos_23-2150878219.jpg", "title": "Tacos in hand", "alt": "Hands holding birria tacos", "source": "Freepik #72265509"},
    "gallery-taco": {"url": FP + "front-view-hands-holding-delicious-taco_23-2151048006.jpg", "title": "Taco close-up", "alt": "Close-up of a taco with fresh toppings", "source": "Freepik #94942109"},
    "gallery-board": {"url": FP + "high-angle-delicious-tacos-arrangement_23-2150799473.jpg", "title": "Taco board", "alt": "Board of assorted tacos from Agave Taco Shop", "source": "Freepik #67390178"},
    "gallery-street": {"url": FP + "delicious-street-food-still-life_23-2151535327.jpg", "title": "Street food still life", "alt": "Late-night Mexican street food in San Diego", "source": "Freepik #201005039"},
    "gallery-salsa": {"url": FP + "traditional-mexican-tacos-salsa-sauce-with-meat-vegetables-cutting-board_23-2148042498.jpg", "title": "Tacos and salsa", "alt": "Traditional tacos with salsa on a cutting board", "source": "Freepik #3764752"},
    "gallery-aguas": {"url": FP + "person-pouring-refreshing-hibiscus-ice-tea-clear-glass-container_23-2149893698.jpg", "title": "Pouring jamaica", "alt": "Pouring jamaica agua fresca", "source": "Freepik #34136147"},
}
