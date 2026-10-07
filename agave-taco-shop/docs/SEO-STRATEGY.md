# Estrategia SEO — Agave Taco Shop (Point Loma, San Diego)

Objetivo: posicionar a Agave Taco Shop en el **Top 3 del “Local Pack” de Google Maps** y en la primera página orgánica para búsquedas de birria, tacos y burritos en Point Loma / Ocean Beach / San Diego, y convertir esas visitas en pedidos en línea, visitas al drive-thru y cotizaciones de catering.

## 1. Investigación de palabras clave (mercado EE. UU., inglés)

| Intención | Palabra clave principal | Secundarias / long tail | Página destino |
| --- | --- | --- | --- |
| Marca + local | birria tacos San Diego | best birria San Diego, birria near me, birria Point Loma | Home |
| Producto estrella | quesabirria San Diego | quesabirria near me, quesabirria tacos with consommé | Menu, Blog #1 |
| Comparativa | best birria tacos San Diego | best tacos Point Loma, best tacos Ocean Beach | Blog #2 |
| Informativa | what is quesabirria | how to eat birria, birria consommé | Blog #1, #3 |
| Local | taco shop Point Loma | Mexican food Point Loma, tacos near Ocean Beach, Midway District tacos | Visit Us |
| Desayuno | breakfast burrito Point Loma | breakfast near Ocean Beach, drive-thru breakfast San Diego | Blog #4 |
| Icono local | California burrito San Diego | best California burrito, carne asada fries San Diego | Blog #5, Menu |
| Catering | taco catering San Diego | birria catering, taco bar catering, office lunch catering San Diego | Catering, Blog #6 |
| Noche | late night tacos San Diego | late night food Point Loma, open late Mexican food | Blog #7 |
| Servicio | drive-thru tacos San Diego | Mexican food delivery Point Loma | Home, Visit |

## 2. SEO on-page (ya implementado)

Cada página y artículo del XML trae **título SEO, meta descripción y palabra clave foco** para Yoast SEO (`_yoast_wpseo_*`) y Rank Math (`rank_math_*`). Si no hay plugin instalado, el tema los imprime igual.

| Página | Title tag | Keyword foco |
| --- | --- | --- |
| Home | Agave Taco Shop \| Best Birria Tacos & Quesabirria in Point Loma, San Diego | birria tacos San Diego |
| Menu | Menu \| Quesabirria, Birria Tacos, Burritos & Breakfast \| Agave Taco Shop San Diego | quesabirria menu San Diego |
| Our Story | Our Story \| Family-Owned Mexican Taco Shop in Point Loma, San Diego | family owned taco shop Point Loma |
| Catering | Taco Catering San Diego \| Birria & Taco Bar Catering \| Agave Taco Shop | taco catering San Diego |
| Visit Us | Hours & Location \| Taco Shop near Ocean Beach & Point Loma \| Agave Taco Shop | taco shop Point Loma |
| Contact | Contact Agave Taco Shop \| Point Loma, San Diego \| (619) 230-5282 | Agave Taco Shop contact |
| Blog | The Agave Journal \| Birria, Tacos & San Diego Food Guides | San Diego taco blog |

Además:

- Un solo `<h1>` por página; jerarquía H2/H3 semántica en todo el contenido.
- Texto alternativo (alt) descriptivo con keyword + ubicación en las 23 imágenes del XML y en todas las imágenes del tema.
- Enlazado interno: artículos → Menu / Catering / Visit / otros artículos; migas de pan (breadcrumbs) visibles.
- URLs limpias (`/menu/`, `/catering/`, `/what-is-quesabirria-san-diego-guide/`).
- Llamadas a la acción en cada artículo (Order Online + View Menu).
- NAP (nombre, dirección, teléfono) idéntico en header, footer, Visit Us, Contact y schema.

## 3. Datos estructurados (Schema.org, JSON-LD) — automáticos

| Schema | Dónde | Beneficio |
| --- | --- | --- |
| `Restaurant` + `LocalBusiness` | Todo el sitio | Dirección, geo, horario, `servesCuisine`, `priceRange`, `hasMenu`, `sameAs` (Facebook, Instagram, Yelp, Tripadvisor), `amenityFeature` (drive-thru, patio, delivery, catering), `OrderAction` hacia el pedido en línea |
| `WebSite` + `SearchAction` | Todo el sitio | Sitelinks search box |
| `Menu` → `MenuSection` → `MenuItem` | /menu/ | Menú legible para Google y asistentes de IA |
| `FAQPage` | /catering/ y /visit/ (se genera solo desde los bloques `details.faq`) | Respuestas directas, búsquedas por voz y AI Overviews |
| `BlogPosting` | Cada artículo | Fechas, imagen, publisher |
| `BreadcrumbList` | Páginas internas | Migas en resultados |

Validar después de publicar en <https://search.google.com/test/rich-results> y <https://validator.schema.org/>.

## 4. SEO técnico (ya implementado)

- Meta robots: `index, follow, max-image-preview:large`; `noindex` en búsquedas, 404, archivos de autor/fecha y Privacy Policy.
- Sitemap XML nativo de WordPress (`/wp-sitemap.xml`) o el de Yoast/Rank Math (`/sitemap_index.xml`).
- `robots.txt` bloquea resultados de búsqueda interna.
- Open Graph (incluye `restaurant.restaurant` y datos de contacto) + Twitter Cards para que los enlaces se vean bien en Facebook, Instagram, WhatsApp y X.
- Meta geo (`geo.region`, `geo.position`, `ICBM`).
- Rendimiento: sin jQuery ni page builder, JavaScript diferido, imágenes `lazy`, primera imagen del hero con `fetchpriority="high"`, `preconnect` a Google Fonts, tamaños de imagen dedicados.
- Accesibilidad: enlace “skip to content”, foco visible, `aria` en el carrusel, `prefers-reduced-motion`.

## 5. Google Business Profile (el factor #1 del SEO local)

1. Reclamar/verificar el perfil “Agave Taco Shop” en 4111 W Point Loma Blvd.
2. Categoría principal: **Mexican Restaurant**. Secundarias: Taco Restaurant, Burrito Restaurant, Breakfast Restaurant, Caterer, Takeout Restaurant.
3. Usar la descripción de `docs/COPYWRITING.md` (750 caracteres).
4. Atributos: drive-thru, outdoor seating, takeout, delivery, breakfast, late-night food, catering.
5. Enlaces: sitio web, menú (`/menu/`), pedidos (Toast) y reservas/catering (`/catering/`).
6. Subir 3–5 fotos nuevas por semana (birria, consomé, drive-thru, fachada, equipo).
7. Publicar un “Google Post” semanal (ofertas, nuevo artículo del blog, catering).
8. Responder TODAS las reseñas en menos de 48 h, mencionando de forma natural “birria”, “Point Loma”, “quesabirria”.
9. Pedir reseñas con un QR en mostrador, ticket y bolsa del drive-thru (“Loved your birria? Tell San Diego!”).

## 6. Citas locales (NAP consistente)

Mismo nombre, dirección y teléfono exactos en: Google Business Profile, Apple Maps (Business Connect), Bing Places, Yelp, Tripadvisor, Facebook, Instagram, DoorDash, Uber Eats, Postmates, Toast, Nextdoor, Foursquare, OpenTable/Restaurantji, Chamber of Commerce de Point Loma y Ocean Beach MainStreet Association.

`Agave Taco Shop · 4111 W Point Loma Blvd, San Diego, CA 92110 · (619) 230-5282 · https://www.agavetacoshop.com`

## 7. Plan de contenidos (12 meses)

- 2 artículos al mes. Ideas: “Birria vs. barbacoa”, “Best tacos near Pechanga Arena / Midway”, “Where to eat after a day at Ocean Beach”, “Taco Tuesday in Point Loma”, “Office catering checklist”, “Our salsa guide (mild to fuego)”, “Vegetarian options at a taco shop”, “Game-day catering in San Diego”, guías por temporada (Cinco de Mayo, Super Bowl, graduaciones, fiestas decembrinas).
- Cada artículo: 900–1,400 palabras, 1 keyword foco, FAQ al final con `<details class="faq">` (genera schema solo), 2–3 enlaces internos y CTA.

## 8. Link building local

- Prensa local: SanDiegoVille (ya publicó la apertura), Eater San Diego, San Diego Magazine, Point Loma-OB Monthly, PB Monthly, NBC 7 / Fox 5 segmentos de comida.
- Colaboraciones: equipos deportivos juveniles de Point Loma, escuelas, iglesias, gimnasios y surf shops (catering a cambio de mención/enlace).
- Influencers de comida de San Diego (TikTok/Instagram) con el “consommé dip”.
- Enlace cruzado con el sitio hermano Agave Birrieria (Encinitas).

## 9. Medición

- Google Search Console (enviar sitemap), Google Analytics 4 con eventos: clic en “Order Online”, clic en teléfono, clic en “Get directions”, envío de formulario de catering.
- Google Business Profile Insights: llamadas, rutas, clics al sitio.
- KPIs a 90 días: +40 % impresiones en búsquedas locales, Top 3 Local Pack para “birria tacos Point Loma”, 15+ reseñas nuevas, 10+ solicitudes de catering al mes.
