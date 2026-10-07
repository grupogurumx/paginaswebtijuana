# Imágenes — fuentes, licencias y prompts

## Qué se usó

| Clave (slug `agave-<clave>`) | Uso en el sitio | Fuente |
| --- | --- | --- |
| `hero-ai-quesabirria` | Slide 1 del hero (portada) | **Magnific AI** — generada para este proyecto (ver prompt abajo) |
| `hero-quesabirria`, `hero-birria-night`, `hero-sunrise`, `hero-catering`, `hero-drive-thru` | Slides 1–5 y fondos | Freepik / Magnific stock (licencia gratuita) |
| `dish-*` (7) | Tarjetas del menú y Menu | Freepik / Magnific stock |
| `story-*`, `catering-*`, `gallery-*` | Our Story, Catering, galería estilo Instagram, blog | Freepik / Magnific stock |

Los IDs exactos de cada foto están en `content/images.py`. El crédito “Photos: Freepik / Magnific” ya está en el footer (requisito de la licencia gratuita). Con el plan **Premium** de Freepik/Magnific puedes descargar los originales en alta resolución sin atribución y volver a subirlos con el mismo slug.

### Imagen IA de Magnific (importante)

- Se generó 1 imagen panorámica 21:9 de quesabirria con consomé (Magnific → modelo Nano Banana 2 Lite). Está en tu proyecto **Personal** de Magnific: <https://www.magnific.com/app/creation/s7YfCD9l8e>
- El enlace incluido en el XML es **temporal (válido hasta el 10 de octubre de 2026)**. Importa el XML antes de esa fecha o descárgala desde Magnific y súbela a WordPress con el slug `agave-hero-ai-quesabirria`.
- Los créditos de Magnific alcanzaron solo para 1 imagen IA (quedaban 72 créditos; cada imagen cuesta 60).

### Higgsfield

La cuenta de Higgsfield conectada tiene **0 créditos** (plan gratuito), por lo que no se pudo generar con Higgsfield. Abajo están los prompts listos para usar en cuanto tenga créditos (recomendado: modelo `gpt_image_2_5` o `marketing_studio_image`, 21:9 para los slides y 4:5 para las tarjetas).

### Logo y fotos de Facebook / Instagram

El firewall de este entorno bloquea agavetacoshop.com, facebook.com e instagram.com, así que el logo y las fotos de redes no se pudieron descargar. Para usarlas: súbelas a la Biblioteca de medios con el slug de la tabla (por ejemplo, la mejor foto de quesabirria de Instagram → `agave-dish-quesabirria`) y el tema las tomará automáticamente.

## Prompts (Higgsfield / Magnific / Freepik AI)

Estilo base para todos: *premium restaurant advertising photography, warm golden-hour light, terracotta + crimson + agave green palette, shallow depth of field, steam, no text, no logos.*

1. **Hero 1 — Quesabirria panorámica (21:9)** — *ya generada en Magnific*
   “Cinematic ultra-wide panoramic food photograph: a rustic dark slate table with four crispy golden quesabirria tacos dripping melted Oaxaca cheese, a steaming clay cup of deep red birria consommé, chopped white onion, cilantro, lime wedges, charred jalapeños and salsa roja. Blue agave plants softly out of focus in the background, warm golden-hour sunset light from a San Diego coastline, rising steam, shallow depth of field, rich terracotta, crimson and gold color palette, premium magazine-quality restaurant advertising photography, generous negative space on the left third for headline text. No text, no logos.”
2. **Hero 2 — El dip del consomé (21:9)**
   “Macro slow-motion moment of a crispy birria taco being dipped into a glossy red consommé, droplets flying, dark moody background with warm rim light, steam, cinematic food commercial, negative space on the left.”
3. **Hero 3 — Amanecer en Ocean Beach (21:9)**
   “A bacon breakfast burrito cut in half showing eggs, crispy potatoes and melted cheese, on the hood of a vintage surf van at sunrise near Ocean Beach pier San Diego, surfboard, golden morning haze, lifestyle advertising photography.”
4. **Hero 4 — Birria bar para eventos (21:9)**
   “Overhead panoramic catering table at a backyard fiesta in San Diego: copper pots of birria, stacks of tortillas, bowls of consommé, salsas, limes, papel picado garlands, string lights, happy hands reaching in, warm evening light.”
5. **Hero 5 — Drive-thru nocturno (21:9)**
   “A paper bag of tacos and a horchata handed through a taco shop drive-thru window at night, neon glow in red and agave green, palm tree silhouettes, cinematic San Diego street photography.”
6. **Tarjetas del menú (4:5)**: “Hero shot of [California burrito / birria fries / carne asada street tacos / menudo / horchata and jamaica aguas frescas] on a rustic terracotta surface, warm side light, premium Mexican restaurant menu photography.”
7. **Video corto para redes (Higgsfield `seedance_2_5`, 9:16, 5 s)**: “Close-up of melted cheese stretching as a quesabirria taco is pulled apart, then dipped into consommé, slow motion, steam, warm light.”

Tamaños recomendados: slides 2400×1100 px (mínimo), tarjetas 900×1100 px, blog 1600×900 px, JPG calidad 80 o WebP.
