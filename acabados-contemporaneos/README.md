# Acabados Contemporáneos · Rediseño web en WordPress

Sitio bilingüe (español / inglés) para **Acabados Contemporáneos**, empresa mexicana con más de 35 años en la comercialización de recubrimientos, cerámicas, porcelánicos y accesorios para la construcción.

- Tema a la medida con **slider panorámico 3D**: las diapositivas giran sobre un cilindro con perspectiva, zoom Ken Burns, paralaje con el puntero, títulos que se revelan palabra por palabra, arrastre táctil, teclado y miniaturas con barra de progreso.
- **Motion** en todo el sitio: revelado al hacer scroll, títulos por líneas, tarjetas con inclinación 3D y brillo, fondos con paralaje, contadores, carril de ambientes arrastrable, botones magnéticos y marquesina. Respeta `prefers-reduced-motion`.
- **28 páginas y 10 artículos de blog** (14 páginas + 5 artículos por idioma) listos para importar en XML.
- **SEO completo:** títulos y descripciones por URL (también para Yoast y Rank Math), hreflang, Open Graph y Schema.org de negocio local, migas de pan, artículo y FAQ.
- **17 imágenes** fotorrealistas generadas con IA en Magnific (Freepik), optimizadas a WebP.

## Contenido de la carpeta

```
acabados-contemporaneos/
├── wordpress-import/
│   ├── acabados-contemporaneos-wxr.xml     ← páginas + blog (importa este)
│   ├── acabados-paginas.xml                ← solo páginas
│   ├── acabados-blog.xml                   ← solo blog
│   └── acabados-contemporaneos-theme.zip   ← tema listo para subir
├── theme/acabados-contemporaneos/          ← código fuente del tema
├── content/{es,en}/{pages,posts}/          ← textos fuente de cada página y artículo
├── seo/
│   ├── ESTRATEGIA-SEO.md                   ← palabras clave, metas por URL, SEO técnico y local, plan editorial
│   ├── COPY-ES-EN.md                       ← textos de marca ES/EN con palabras clave
│   └── robots.txt
├── vercel/                                 ← sitio estático completo listo para Vercel
├── preview/                                ← vistas previas sueltas para QA
└── tools/                                  ← generadores del XML, del ZIP y de la vista previa
```

## Instalación (15 minutos)

1. **Sube el tema.** En WordPress ve a *Apariencia → Temas → Añadir nuevo → Subir tema*, elige `wordpress-import/acabados-contemporaneos-theme.zip` y actívalo.
2. **Importa el contenido.** Ve a *Herramientas → Importar → WordPress* (instala el importador si te lo pide), sube `acabados-contemporaneos-wxr.xml` y asigna los contenidos a tu usuario.
3. **Termina la configuración.** Al activar el tema se abre *Apariencia → Configurar Acabados*:
   - **Importar imágenes:** descarga el paquete de imágenes y las registra en la Biblioteca de medios, con texto alternativo y como imagen destacada de cada artículo. Si tu hosting bloquea descargas externas, descarga el ZIP desde el enlace de abajo y súbelo en el mismo panel.
   - **Configurar sitio:** crea los menús en español e inglés, fija «Inicio» como portada y activa los enlaces permanentes `/%postname%/`.
4. **Captura los datos del negocio** en *Apariencia → Personalizar → Acabados Contemporáneos*: teléfono, WhatsApp, correo, dirección, horario, coordenadas, redes, Search Console y GA4. Los campos vacíos no se muestran.
5. **Sube el logotipo** en *Personalizar → Identidad del sitio*. Mientras no haya logotipo, el tema muestra un logotipo tipográfico.
6. Revisa la **checklist de lanzamiento** en `seo/ESTRATEGIA-SEO.md`.

### Paquete de imágenes

ZIP con las 17 imágenes en WebP (3.1 MB), alojado en el almacenamiento de Higgsfield:
<https://d2ol7oe51mr4n9.cloudfront.net/user_39X9oUM6mjMuWX1gzCztnOmmGzI/f080e1db-c8f3-47ba-aa12-875448352dd3.zip>

Los originales en alta resolución (PNG de hasta 3168 px) están en tu cuenta de Magnific, en el proyecto *Personal*. También puedes copiar los `.webp` a `theme/acabados-contemporaneos/assets/img/`: el tema los usa si no están en la Biblioteca de medios.

| Imagen | Uso |
|---|---|
| `hero-sala`, `hero-bano`, `hero-cocina`, `hero-terraza`, `hero-showroom` | Slider panorámico (21:9) |
| `cat-porcelanico`, `cat-ceramica`, `cat-recubrimientos`, `cat-madera`, `cat-mosaicos`, `cat-accesorios` | Tarjetas de colecciones (4:5) |
| `nosotros-asesoria`, `textura-marmol` | Nosotros y fondo de la banda panorámica |
| `blog-ceramica-vs-porcelanato`, `blog-tendencias`, `blog-instalacion`, `blog-gran-formato` | Artículos del blog (16:9) |

## Ver el sitio en Vercel (demo navegable)

**Demo publicada:** <https://acabados-contemporaneos.vercel.app/> (proyecto `acabados-contemporaneos` en la cuenta de Vercel de Grupo Gurú).

La carpeta `vercel/` contiene una **versión estática de todo el sitio**: 38 páginas ES/EN, blog, 404 y sitemap, renderizadas con las plantillas reales del tema. Sirve para revisar el diseño antes de instalar WordPress. En Vercel las imágenes se descargan al compilar desde el ZIP público, y la demo tiene `noindex` para no competir con el dominio real.

1. Entra a <https://vercel.com/new> e importa el repositorio `grupogurumx/paginaswebtijuana`.
2. En **Root Directory** elige `acabados-contemporaneos/vercel`. El resto se toma de `vercel.json`: Framework *Other*, build `npm run build`, salida `public`.
3. Pulsa **Deploy**. Mientras los cambios vivan en la rama `claude/peaceful-allen-p4muoh`, Vercel publica una URL de vista previa; cuando se una a `main`, queda en producción.

En la demo, el formulario de cotización solo muestra un aviso: se activa al instalar el tema en WordPress.

Para regenerar la demo después de cambiar el tema o los textos:

```bash
python3 tools/build_static.py
```

## Ver el sitio en Cloudflare Pages

La misma carpeta `vercel/` funciona en Cloudflare Pages (incluye `_headers` con caché y `noindex`).

1. En el panel de Cloudflare ve a **Workers & Pages → Create → Pages → Connect to Git** y elige `grupogurumx/paginaswebtijuana`.
2. **Production branch:** `claude/peaceful-allen-p4muoh` (o `main` cuando se una).
3. **Framework preset:** None · **Build command:** `npm install && npm run build` · **Build output directory:** `public` · **Root directory:** `acabados-contemporaneos/vercel`.
4. Pulsa **Save and Deploy**. La dirección queda como `https://<proyecto>.pages.dev`.

## Bilingüe sin plugins

- Las páginas en inglés cuelgan de la página `en` (`/en/about/`, `/en/products/…`). El blog en inglés usa la categoría `blog-en`.
- Cada página o entrada guarda su idioma (`_ac_lang`) y la ruta de su traducción (`_ac_translation`). Con eso funcionan el botón ES/EN, el menú de cada idioma y las etiquetas hreflang.
- Para editarlos sin plugin SEO, usa la caja **SEO · Acabados** del editor. Si después instalas Polylang o WPML, el tema usa su idioma activo.

## Pendientes del cliente

Estos datos no estaban disponibles (el sitio actual no fue accesible durante el trabajo), así que quedaron como campos configurables y no se inventaron:

- Teléfono, WhatsApp, correo, dirección, horario, coordenadas y redes sociales (en el personalizador).
- Razón social y domicilio para el **aviso de privacidad** (marcados con `[CORCHETES]`).
- Confirmar el tiempo de respuesta de cotizaciones (el texto dice 24 h hábiles), la cobertura de envíos y el año de fundación.
- Logotipo oficial en SVG o PNG transparente.

## Regenerar los archivos

```bash
python3 tools/build_wxr.py --site https://acabadoscontemporaneos.com
```

```bash
tools/build_theme_zip.sh
```

```bash
php tools/preview/render.php home-es > preview/home-es.html
```
