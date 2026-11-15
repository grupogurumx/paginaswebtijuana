# Southwestern Solutions — Rediseño WordPress completo

Rediseño profesional de **southwesternsolutions.org** (capacitación de instructores policiales certificada por POST en San Diego, CA: *Chemical Agent Instructor*, *Less Lethal Instructor* y cumplimiento *AB 48 / Código Penal 13652*).

![Vista previa](docs/preview/desktop-hero.jpg)

## 📦 Qué incluye

| Entregable | Ruta |
|---|---|
| **Tema WordPress** listo para subir (ZIP) | `release/southwestern-solutions-theme.zip` |
| Código fuente del tema | `theme/southwestern-solutions/` |
| **XML de importación** (12 páginas, 6 artículos de blog, categorías, etiquetas, menú y SEO) | `import/southwestern-solutions.WordPress.xml` |
| **SEO completo página por página (inglés)** | `docs/SEO-STRATEGY.md` |
| **Textos de alto impacto ES / EN (3 versiones por bloque)** + copys de anuncios | `docs/COPY-ES-EN.md` |
| 8 imágenes generadas con IA (Magnific / Freepik), optimizadas WebP + JPG | `theme/southwestern-solutions/assets/img/` |
| Capturas de la versión probada | `docs/preview/` |
| Generador del XML (por si editas textos) | `tools/build_wxr.py` |

## ✨ Diseño y efectos

- **Slider panorámico 3D**: tres escenas con transición en profundidad (perspectiva, `rotateY` y `translateZ`). La imagen es más ancha que la pantalla y se desplaza con el cursor (efecto panorámico), con capas de profundidad (parallax), efecto Ken Burns, humo animado, títulos que se revelan línea por línea, barra de progreso, flechas, teclado y swipe en el celular.
- Tarjetas con **inclinación 3D** y reflejo que sigue al cursor, aparición de secciones al hacer scroll, contadores animados, marquesina de credenciales, parallax en los encabezados internos, menú móvil a pantalla completa y botón flotante de llamada.
- **Selector EN / ES** en el encabezado: cambia los textos del hero y de los botones al español.
- Paleta táctica: negro carbón, ámbar dorado y acero. Tipografías Barlow Condensed e Inter.
- Accesible: un solo H1 por página, enlace para saltar al contenido, ARIA en el slider y respeto a `prefers-reduced-motion`.
- Sin jQuery ni plugins de slider (unos 6 KB de JS).

## 🚀 Instalación (10 minutos)

1. **Respalda** el sitio actual (UpdraftPlus o tu hosting).
2. **Apariencia → Temas → Añadir nuevo → Subir tema** → sube `release/southwestern-solutions-theme.zip` → **Activar**.
3. **Herramientas → Importar → WordPress** (instala el importador si te lo pide) → sube `import/southwestern-solutions.WordPress.xml` → asigna el autor → **Enviar**.
4. Entra a cualquier página del admin. El tema configura **automáticamente**:
   - Página de inicio = *Home* y página de entradas = *Training Insights* (`/blog/`)
   - Menú principal = *Main Menu*
   - Enlaces permanentes `/%postname%/` (si no estaban configurados)
5. **Apariencia → Personalizar → Business Info**: confirma teléfono, correo, horario y redes sociales.
6. (Opcional) Instala **Rank Math** o **Yoast SEO**. Todos los títulos, descripciones y palabras clave ya vienen cargados en sus campos.
7. Instala un plugin SMTP (WP Mail SMTP / FluentSMTP) para que el formulario de reservas llegue a `info@southwesternsolutions.org`.

> ⚠️ Si el sitio actual usa WooCommerce, el tema redirige con **301** las URLs antiguas (`/product/...`, `/shop/`, `/home-it-service/`) a las nuevas páginas para conservar el posicionamiento.

## 🧩 Secciones reutilizables (shortcodes)

Puedes armar cualquier página nueva con un bloque *HTML personalizado* o *Shortcode*:

`[sws_slider]` · `[sws_trustbar]` · `[sws_courses]` · `[sws_features]` · `[sws_stats]` · `[sws_process]` · `[sws_split img="hero-2"]…[/sws_split]` · `[sws_cta title="…" text="…" button="…" url="/contact/"]` · `[sws_contact_form]` · `[sws_contact_info]` · `[sws_latest_posts count="3"]` · `[sws_section eyebrow="…" title="…"]…[/sws_section]`

## ✅ Antes de publicar: verificar con el cliente

Estos datos se tomaron de los resultados de búsqueda del sitio actual y del catálogo POST (no fue posible abrir el sitio ni web.archive.org desde este entorno):

- Precios: **$1,881** (Chemical Agent, 40 h) y **$1,200** (Less Lethal, 30 h).
- Fecha publicada: **14–18 de diciembre de 2026, Miramar**. Las demás aparecen como "2027 dates coming soon".
- Teléfono **+1 (928) 614-0964** y correo **info@southwesternsolutions.org**. El horario (L–V 8–5 PT) es un supuesto razonable.
- La página **Host a Course** describe un servicio que hay que confirmar con el cliente.
- **Imagen del equipo (`instructors.jpg`)**: está generada con IA y es solo un marcador. Reemplázala por fotos reales del equipo antes de publicar, porque presentar personas ficticias como instructores reales afectaría la confianza y el E-E-A-T.
- Los textos sobre AB 48 son educativos. Conviene que un abogado de la agencia o del cliente los revise.

## 🖼️ Imágenes generadas (Magnific / Freepik AI)

| Archivo | Uso | Prompt resumido |
|---|---|---|
| hero-1 | Slide 1, curso de agentes químicos | Ejercicio táctico al atardecer en el desierto, oficiales con máscara entre humo |
| hero-2 | Slide 2, cursos | Instructor dando clase a oficiales, luz azul y ámbar |
| hero-3 | Slide 3, curso menos letal | Línea de oficiales con escudos y máscaras, humo y luces rojo/azul |
| chemical-agent | Tarjeta del curso | Máscara de gas y guantes sobre mesa de acero |
| less-lethal | Tarjeta del curso | Instructor guiando a una oficial con lanzador 40 mm naranja |
| instructors | Quiénes somos (**marcador**) | Equipo de cuatro instructores frente a instalaciones de entrenamiento |
| compliance | AB 48 | Carpeta de políticas, laptop y documentos en oficina policial |
| san-diego | Contacto | Vista aérea de la costa y el centro de San Diego al anochecer |

Higgsfield no tenía créditos disponibles (saldo 0), así que todas las imágenes se generaron con **Magnific** (plan Premium, ~600 créditos). Las originales en alta resolución están en tu cuenta de Magnific, carpeta *Personal*.

## 🔁 Editar textos y regenerar el XML

```bash
python3 tools/build_wxr.py
```
