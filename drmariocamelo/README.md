# drmariocamelo.com — Sitio WordPress bilingüe (EN/ES)

Rediseño completo del sitio del **Dr. Mario Camelo, #SuperDrSleeve**, cirujano bariatra certificado con más de 10,000 cirugías. Está pensado para captar pacientes de Estados Unidos (inglés como idioma principal) y de México (español).

## Contenido

| Ruta | Qué es |
|---|---|
| `dist/drmariocamelo-theme.zip` | Tema de WordPress listo para subir (Apariencia → Temas → Añadir → Subir) |
| `import/drmariocamelo-wordpress-import.xml` | Archivo WXR con 22 páginas (11 EN + 11 ES), 10 artículos de blog (5 EN + 5 ES), categorías, etiquetas, imágenes destacadas y metadatos SEO (Yoast y Rank Math) |
| `wp-theme/drmariocamelo/` | Código fuente del tema |
| `vercel-preview/` | Copia estática del sitio lista para Vercel (solo vista previa) |
| `tools/` | Generador del XML (`python3 tools/build_wxr.py https://drmariocamelo.com`), exportador estático y todos los textos |

## Vista previa en Vercel

`vercel-preview/` es una copia estática del sitio, exportada del WordPress de prueba con `tools/export_static.py`. Sirve para mostrar el diseño al cliente: tiene las 32 páginas, el slider y las animaciones, y el Typeform funciona. **El formulario de contacto solo muestra un aviso**, porque necesita WordPress. Está marcada como `noindex` para que Google no la confunda con drmariocamelo.com.

1. En vercel.com → **Add New… → Project**, importa el repo `grupogurumx/paginaswebtijuana`.
2. En **Root Directory** elige `drmariocamelo/vercel-preview`. En Framework Preset deja **Other**, sin comando de build.
3. **Deploy.** Si la rama de producción del proyecto es `main`, cada push a `claude/sweet-fermi-h5wpb2` crea una URL de *preview*; o haz merge a `main` para tener la URL de producción.

Para regenerarla tras cambiar el tema: levanta WordPress con el tema y el XML, y corre `python3 tools/export_static.py http://localhost:8099 urls.txt vercel-preview`.

## Instalación (en este orden)

1. WordPress 6.0 o superior, PHP 7.4 o superior.
2. **Sube y activa el tema** `dist/drmariocamelo-theme.zip`. Debe estar activo antes de importar, porque las imágenes se descargan desde la carpeta del tema.
3. Instala el plugin **WordPress Importer** (Herramientas → Importar → WordPress).
4. Importa `import/drmariocamelo-wordpress-import.xml` y marca **"Descargar e importar archivos adjuntos"**.
5. Entra de nuevo a `/wp-admin`. El tema configura solo la página de inicio, la página del blog y los enlaces permanentes `/%postname%/`.
6. (Recomendado) Instala **Yoast SEO** o **Rank Math**: los títulos SEO, las descripciones y las palabras clave de cada página ya vienen importados. Si no instalas ninguno, el tema imprime él mismo las metaetiquetas.
7. Ve a **Apariencia → Personalizar → Dr. Camelo Settings** y llena:
   - **Teléfono, WhatsApp y correo** (los leads llegan a ese correo). No los pude obtener del sitio anterior. Mientras estén vacíos, el botón flotante de WhatsApp no aparece.
   - Calificación y número de reseñas de Google (para las estrellas y el schema `AggregateRating`).
   - GA4, Google Tag Manager, Meta Pixel y el código de verificación de Search Console.
   - Revisa la **latitud y longitud** (vienen aproximadas a Playas de Tijuana).
8. Sube el logo oficial en Personalizar → Identidad del sitio. Mientras tanto se muestra un logo SVG dorado con el estómago, inspirado en los gráficos de redes sociales.

> Probado localmente con WordPress 6.6.2: la importación termina sin errores y todas las páginas responden 200 sin errores de PHP ni de JavaScript, sin desplazamiento horizontal a 390, 1280 y 1440 px. El formulario de contacto quedó probado de punta a punta.

## Qué incluye el diseño

- **Hero con slides panorámicos 3D**: transiciones con perspectiva (rotateY + translateZ), efecto Ken Burns, parallax que sigue al mouse, partículas doradas en canvas, barra de progreso, flechas, swipe en móvil y teclado.
- Animaciones al hacer scroll (reveal 3D), contadores animados, tarjetas con inclinación 3D, botones magnéticos, marquesina de texto y bandas panorámicas con parallax.
- Paleta azul marino y dorado, tomada de los gráficos de Instagram del doctor; tipografías Playfair Display y Montserrat.
- Respeta `prefers-reduced-motion`.
- **4 titulares de impacto** en el slider, en inglés y en español:
  1. *Your new life begins with one decision.* / *Tu nueva vida comienza con una decisión.*
  2. *Beat obesity. Reclaim your health.* / *Vence la obesidad. Recupera tu salud.*
  3. *World-class surgery, just across the border.* / *Cirugía de clase mundial, al otro lado de la frontera.*
  4. *Invest in yourself. Pay at your pace.* / *Invierte en ti. Paga a tu ritmo.*

## Páginas y URLs

| Inglés | Español |
|---|---|
| `/` | `/es/` |
| `/about-dr-mario-camelo/` | `/es/sobre-el-dr-mario-camelo/` |
| `/gastric-sleeve-tijuana/` | `/es/manga-gastrica-tijuana/` |
| `/gastric-bypass-tijuana/` | `/es/bypass-gastrico-tijuana/` |
| `/revision-bariatric-surgery/` | `/es/cirugia-de-revision/` |
| `/metabolic-medicine/` | `/es/medicina-metabolica/` |
| `/financing/` | `/es/financiamiento/` |
| `/reviews/` | `/es/testimonios/` |
| `/contact/` | `/es/contacto/` |
| `/blog/` | `/es/blog/` |
| `/privacy/` | `/es/aviso-de-privacidad/` |

El botón EN/ES lleva a la página equivalente en el otro idioma (metadato `_dmc_translation`).

### Blog (5 temas × 2 idiomas, basados en las publicaciones del doctor)
- Gallstones after bariatric surgery / Piedras en la vesícula y cirugía bariátrica
- 4 complications of untreated gallstones / 4 complicaciones de las piedras en la vesícula
- Risks of self-medicating for weight loss (GLP-1) / Riesgos de automedicarse para bajar de peso
- Gastric sleeve vs. gastric bypass / Manga gástrica vs. bypass gástrico
- Gastric sleeve in Tijuana: guide for U.S. patients / Manga gástrica en Tijuana: guía completa

## Financiamiento (Typeform)

La sección de financiamiento tiene incrustado el formulario `https://mendmx.pro.typeform.com/solicitud1`, con un botón para abrirlo en pantalla completa. Está en `/financing/`, `/es/financiamiento/` y en la página de inicio, y se puede insertar en cualquier página con el shortcode `[dmc_financing]`. La URL se cambia en el Personalizador.

## Formulario de valoración gratuita

Cada solicitud se **envía por correo** y además **se guarda en WordPress** (menú *Patient Leads*), así no se pierde ningún lead si el hosting no envía correos. Tiene nonce y honeypot antispam. Para asegurar la entrega de correos, se recomienda el plugin **WP Mail SMTP**.

Shortcodes disponibles: `[dmc_cta]`, `[dmc_lead_form]`, `[dmc_financing]`, `[dmc_reviews]`, `[dmc_faq]`, `[dmc_procedures]`, `[dmc_logos]`.

## Reseñas

El enlace de reseñas de Google (`share.google/37Q6n39XZZboHRoR1`) está bloqueado desde este entorno, así que **no copié ni inventé testimonios**: inventarlos en un sitio médico es un riesgo legal (FTC/COFEPRIS). La sección muestra el botón "Read our reviews on Google". Para mostrar reseñas reales, pégalas en `wp-theme/drmariocamelo/reviews.json`:

```json
[
  { "name": "Maria G.", "rating": 5, "lang": "en", "text": "Texto exacto de la reseña de Google..." },
  { "name": "Juan P.", "rating": 5, "lang": "es", "text": "..." }
]
```

## Logos de clientes y aliados

Copia los logos (PNG, SVG, JPG o WebP) en `wp-theme/drmariocamelo/assets/img/logos/` y aparecerán automáticamente en la sección de reseñas, en escala de grises con color al pasar el mouse. El nombre del archivo se usa como texto alternativo (`hospital-angeles.png` → "Hospital Angeles").

## Imágenes

**Incluidas en el tema:** las 2 fotos de quirófano y las 3 infografías que me enviaste.

**Generadas con Magnific / Freepik** (6 imágenes, 150 créditos). El CDN de Magnific está bloqueado desde este entorno, así que no pude descargarlas al repositorio. Descárgalas desde tu cuenta, guárdalas con estos nombres en `wp-theme/drmariocamelo/assets/img/`, y el tema las usará en lugar de las fotos de respaldo (acepta `.png`, `.jpg` o `.webp`):

| Archivo | Uso | Enlace |
|---|---|---|
| `hero-quirofano.png` | Slide 1 | https://www.magnific.com/app/creation/iGfHgfJ3uK |
| `hero-vida-sana.png` | Slide 2 | https://www.magnific.com/app/creation/KLnM7XTkqp |
| `hero-playa.png` | Slide 3 + banda panorámica | https://www.magnific.com/app/creation/rgceyGwxtc |
| `hero-consulta.png` | Slide 4 | https://www.magnific.com/app/creation/cpklIUD0eP |
| `recovery-suite.png` | Uso libre (página de contacto o de financiamiento) | https://www.magnific.com/app/creation/TdrSmilVNR |
| `manga-gastrica-3d.png` | Render 3D de la manga gástrica (uso libre) | https://www.magnific.com/app/creation/XmSPuGjBfo |

**Higgsfield:** la cuenta tiene 0 créditos, así que no se generó nada ahí. Al recargar, se pueden crear videos cortos de 5 s con movimiento para el hero.

**Facebook e Instagram:** no se pueden descargar desde este entorno. Las fotos que me enviaste son las de @superdrsleeve; para agregar más, súbelas a la Biblioteca de medios y úsalas como imagen destacada de cada página (también se usan de fondo en el encabezado de la página).

## SEO incluido

- Título SEO, meta descripción y palabra clave principal en cada página y artículo (Yoast y Rank Math).
- Etiquetas **hreflang** en-US / es-MX / x-default en cada par de páginas y `<html lang>` correcto.
- **Schema JSON-LD**: `MedicalClinic`, `Physician`, `MedicalProcedure` (manga, bypass y revisión), `FAQPage` (5 preguntas en la página de inicio), `BlogPosting` revisado por el médico, `BreadcrumbList` y `WebSite`. `AggregateRating` se activa al llenar la calificación de Google.
- Open Graph y Twitter Cards, URL canónica, `robots.txt` que excluye la búsqueda interna, y sitemap del núcleo de WordPress (o el de Yoast) sin el listado de usuarios.
- Aviso de privacidad marcado como `noindex`.
- Seguimiento de conversiones con eventos `generate_lead`, `whatsapp_click`, `call_click`, `financing_click` y `cta_*` (GA4, GTM y Meta Pixel `Lead`/`Contact`).

**Mapa de palabras clave principales**

| Página | EN | ES |
|---|---|---|
| Inicio | bariatric surgery Tijuana | cirugía bariátrica Tijuana |
| Manga | gastric sleeve Tijuana | manga gástrica Tijuana |
| Bypass | gastric bypass Tijuana | bypass gástrico Tijuana |
| Revisión | revision bariatric surgery Tijuana | cirugía de revisión bariátrica |
| Doctor | bariatric surgeon Tijuana | cirujano bariatra Tijuana |
| Financiamiento | bariatric surgery financing | financiamiento cirugía bariátrica |
| Blog | gastric sleeve Mexico, gastric sleeve vs gastric bypass, gallstones after bariatric surgery | manga gástrica en Tijuana, piedras en la vesícula cirugía bariátrica |

**Siguientes pasos de SEO:** dar de alta el sitio en Search Console y enviar el sitemap; poner el enlace del sitio en el Perfil de Empresa de Google; publicar 2 artículos al mes; y conseguir enlaces desde directorios médicos (Doctoralia, WhatClinic, Top Doctors).

## Pendiente de confirmar con el cliente

- Teléfono, WhatsApp y correo; logo oficial; logos de clientes y aliados (el sitio archivado está bloqueado desde aquí).
- La dirección viene de un directorio público (Paseo Playas de Tijuana No. 19, CP 22504) y el horario de L–V 9–18 h: hay que confirmarlos.
- Cédula profesional y certificación del consejo, para agregarlas a la página "Sobre el doctor" (aumentan la confianza y el E-E-A-T).
- Revisión legal del aviso de privacidad. Los porcentajes de pérdida de peso vienen de las infografías del doctor y van acompañados del aviso "los resultados varían".
