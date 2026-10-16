# Peanut Bakery 2.0: rediseño WordPress multipágina

Rediseño completo de **www.peanutbakery.com**, panadería artesanal en Playas de Rosarito, B.C.

| Carpeta | Contenido |
|---|---|
| `wp-theme/peanut-bakery/` | Tema de WordPress a la medida (código fuente) |
| `dist/peanut-bakery.zip` | El mismo tema listo para subir en *Apariencia → Temas → Subir* |
| `wordpress-import/peanutbakery-rediseno.xml` | Importación: página Mayoreo, Blog, 3 artículos SEO y menú nuevo |
| `docs/01-SEO-KEYWORDS-Y-COMPETENCIA.md` | Análisis de la competencia, mapa de keywords por página y plan SEO de 90 días |
| `docs/02-SITEMAP-Y-WIREFRAMES.md` | Sitemap y wireframe de cada página, slider 3D y sistema visual |
| `docs/03-INSTALACION-Y-FOTOS.md` | Instalación paso a paso y cómo se usan las fotos actuales del sitio |

## Qué incluye el tema
- **Slider panorámico 3D** en Inicio: cilindro con `rotateY`, zoom de profundidad, Ken Burns, parallax con el mouse, swipe y teclado, y video opcional en el slide 1.
- **Motion**: revelado al hacer scroll, tarjetas con inclinación 3D, contadores animados, marquesina, línea de proceso animada, header con vidrio esmerilado y parallax en los encabezados. Respeta `prefers-reduced-motion`.
- **Header top con imagen panorámica** en cada página interior (Nosotros, Productos, Mayoreo, Contacto, Blog).
- **Fotos reales del sitio actual**: se asignan automáticamente desde la Biblioteca de Medios por palabras clave (concha, birote, masa…). No usa imágenes de stock ni de IA.
- **WhatsApp en todas partes**: botón flotante, CTA en header y hero, "Pedir" por producto con mensaje prellenado, y formularios con opción "Enviar por WhatsApp".
- **SEO local**: títulos y metas por página, Schema Bakery (LocalBusiness), FAQPage, Breadcrumb, BlogPosting, Open Graph y geo meta. Compatible con Yoast y Rank Math.
- **Datos editables** en *Apariencia → Personalizar → Peanut Bakery*: teléfono, WhatsApp, correo, dirección, horario, mapa, redes, video y fotos.

## Datos de contacto
Peanut Bakery · Playas de Rosarito, B.C. · Tel. y WhatsApp **661 114 7744** · **ventas@peanutbakery.com**

## Probado
Instalado en un WordPress local (SQLite) importando primero el XML actual del sitio y después el de rediseño:
- Las 7 URLs responden sin errores de PHP.
- Sin páginas duplicadas.
- JSON-LD válido.
- Un solo H1 por página.
- Sin desbordamiento horizontal en escritorio (1440 px) ni en móvil (390 px).
