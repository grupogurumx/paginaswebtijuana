# Instalación en peanutbakery.com y uso de las fotos actuales

## A. Instalar el tema (5 minutos)
1. **Respaldo** primero: plugin UpdraftPlus o el respaldo del hosting.
2. *Apariencia → Temas → Añadir nuevo → Subir tema* → `dist/peanut-bakery.zip` → **Activar**.
3. *Apariencia → Menús* → selecciona el menú **Principal** actual → **Eliminar menú**. Es obligatorio: el importador siempre agrega elementos de menú y, sin este paso, quedarían duplicados.
4. *Herramientas → Importar → WordPress* (instalar el importador si lo pide) → subir `wordpress-import/peanutbakery-rediseno.xml` → asignar el autor a tu usuario actual.
   - Las páginas **Inicio, Nosotros, Productos y Contacto** ya existen: el importador las reconoce y **no las duplica**. Conservan sus plantillas (`template-nosotros.php`, etc.), que este tema ya incluye.
   - Se crean: página **Mayoreo** (plantilla Mayoreo), página **Blog**, **3 artículos SEO** y el menú **Principal** nuevo (Inicio · Nosotros · Productos · Ventas → /mayoreo/ · Blog · Contacto).
   - *Probado en local: importando primero el XML actual del sitio y después este, no hubo páginas duplicadas.*
5. *Ajustes → Lectura* → "Una página estática": **Portada = Inicio**, **Entradas = Blog**.
6. *Ajustes → Enlaces permanentes* → "Nombre de la entrada" → Guardar (regenera las URLs).
7. *Apariencia → Menús* → menú **Principal** (el nuevo) → ubicación **Menú principal**. Para el pie, crea un menú y asígnalo a **Menú del pie de página** (si no, se usa uno automático).
8. *Apariencia → Personalizar → Identidad del sitio* → sube el **logo** de Peanut Bakery.
9. *Apariencia → Personalizar → Peanut Bakery → Datos de contacto* → completa **calle, código postal, latitud y longitud, horario** y el **mapa embebido** (Google Maps → Compartir → Insertar mapa → copia solo la URL del `src`).
10. *Redes sociales*: pega las URL de Instagram, Facebook, TikTok y YouTube. Los íconos aparecen solos en el header y el footer.

## B. Fotos: se usan las de la página actual automáticamente
El tema **no usa imágenes de stock ni de IA**. Cada sección busca la foto así:

1. **La que elijas tú** en *Personalizar → Peanut Bakery → Fotos del sitio*.
2. **Automática desde la Biblioteca de Medios actual de peanutbakery.com.** El tema lee las fotos que ya están subidas (las del sitio actual) y las asigna por nombre, título o texto alternativo:

| Si el archivo, título o alt contiene… | Se usa en… |
|---|---|
| `masa`, `hogaza`, `sourdough`, `hero`, `slide` | Slide 1 y línea Masa madre |
| `concha`, `dona`, `dulce`, `cuerno` | Slide 2 y línea Pan dulce |
| `birote`, `bolillo`, `telera` | Slide 3 y línea Bolillo y birote |
| `mayoreo`, `horno`, `entrega`, `charola` | Slide 4 y página Mayoreo |
| `croissant`, `pastel`, `galleta`, `canela` | Línea Repostería fina |
| `baguette`, `focaccia`, `brioche`, `artesanal` | Línea Panes artesanales |
| `panadero`, `manos`, `equipo`, `proceso` | Nosotros e Ingeniería del pan |
| `local`, `fachada`, `interior`, `tienda` | Nosotros → El espacio y Contacto |

   - Solo toma **fotos de 900 px de ancho o más**, así que no usa logos ni íconos.
   - Si una sección no encuentra coincidencia, usa otra foto real de la biblioteca para no dejar huecos.
   - **Tip:** si una foto queda en un lugar que no te gusta, edítale el *Título* o el *Texto alternativo* en *Medios* (por ejemplo "Conchas de vainilla Peanut Bakery Rosarito"). Así mejoras también el SEO de imágenes.
3. **Fotos de la sesión profesional**: copia `PB_01.jpg` … `PB_05.jpg` (Drive → *PEANUT BAKERY / FOTOS*) a `wp-content/themes/peanut-bakery/assets/img/`. O mejor: súbelas a *Medios* con nombres descriptivos.
4. Si no hay ninguna foto, se muestra un degradado de marca (nunca una imagen rota).

**Antes de subir:** comprime las fotos de 7 a 12 MB de la sesión a **máximo 2400 px de ancho y unos 300 KB** (con squoosh.app, TinyPNG o el plugin ShortPixel). Las fotos pesadas arruinan la velocidad y el SEO.

**Video del hero (opcional):** el sitio actual usa un video en la portada. Súbelo a *Medios* (MP4 H.264, 10 a 20 s, sin audio, menos de 8 MB) y pega su URL en *Personalizar → Peanut Bakery → Slider panorámico*. Se reproduce de fondo en el slide 1.

## C. Formularios
Los formularios de Contacto y Mayoreo envían a `ventas@peanutbakery.com` con `wp_mail()`. Para que no lleguen a spam, instala **WP Mail SMTP** y configúralo con la cuenta del dominio. El botón "Enviar por WhatsApp" funciona sin configuración.

## D. Plugins recomendados (opcionales)
- **Rank Math o Yoast** (si los usas, el tema les cede título, meta y OG, y conserva el Schema local de panadería).
- **WP Mail SMTP** (entrega de correos).
- **ShortPixel o Imagify** (WebP y compresión).
- **LiteSpeed Cache o WP Super Cache** (velocidad).

## E. Verificación final
- [ ] https://search.google.com/test/rich-results → probar `/`: debe detectar **Bakery** y **FAQPage**
- [ ] https://pagespeed.web.dev → móvil por encima de 85
- [ ] Search Console: enviar `/wp-sitemap.xml` y solicitar indexación de las 5 páginas y 3 artículos
- [ ] Probar el botón de WhatsApp desde un celular
- [ ] Enviar el formulario de prueba y confirmar que llega a ventas@
