# Agave Taco Shop — Nuevo sitio web WordPress

Rediseño completo de **agavetacoshop.com** (Point Loma, San Diego, CA): tema WordPress a la medida, contenido en inglés para el mercado de EE. UU., archivo XML para importar páginas y blog, y SEO local completo.

## Qué incluye

| Entregable | Ruta |
| --- | --- |
| Tema WordPress (zip, listo para subir) | `dist/agave-taco-shop-theme.zip` |
| Archivo XML de importación (páginas, blog, menús, imágenes, SEO) | `dist/agave-taco-shop-wordpress-import.xml` |
| Código fuente del tema | `theme/agave-taco-shop/` |
| Generador del XML (editable y reproducible) | `content/build_wxr.py`, `content/pages.py`, `content/posts.py`, `content/images.py` |
| Estrategia SEO completa | `docs/SEO-STRATEGY.md` |
| Textos de marketing en inglés (hero, redes, Google Business) | `docs/COPYWRITING.md` |
| Imágenes: fuentes, licencias y prompts para Higgsfield / Magnific | `docs/IMAGES.md` |
| Capturas de pantalla (con imágenes temporales) | `screenshots/` |

### El diseño

- **Hero 3D panorámico con motion**: 5 slides en carrusel 3D (perspectiva, rotación en eje Y, profundidad Z), zoom tipo Ken Burns, títulos que se arman letra por letra, parallax con el mouse por capas, swipe en móvil, teclado y autoplay con barra de progreso.
- Paleta “agave”: verde agave nocturno, rojo chile, dorado cempasúchil y crema masa. Tipografías Fraunces (display), Manrope (texto) y Caveat (acentos).
- Efectos: preloader animado, marquesinas, revelado al hacer scroll, tarjetas con inclinación 3D, botones magnéticos, contadores, parallax, header inteligente, menú móvil de pantalla completa y botón fijo “Order Online” en móvil.
- Funciona sin page builder, en JavaScript puro (≈12 KB) y respeta `prefers-reduced-motion`.

### Páginas incluidas en el XML

Home · Menu · Our Story · Catering (con formulario y FAQ) · Visit Us (horarios, mapa, FAQ) · Contact (con formulario) · Blog · Privacy Policy.

### Blog (7 artículos SEO en inglés)

1. What Is Quesabirria? San Diego’s Guide to the Cheesiest Taco on Earth
2. The Best Birria Tacos in San Diego: Why Point Loma Lines Up at Agave
3. How to Eat Birria Like a Pro: The Consommé Dip, Explained
4. Breakfast Burritos in Point Loma: Your 7 AM Fuel Before Ocean Beach
5. The California Burrito: A San Diego Icon (and Where to Get a Great One)
6. Taco Catering in San Diego: The Complete Party Planning Guide
7. Late-Night Tacos in San Diego: Open Until Midnight on Weekends

## Instalación (10 minutos)

1. **Subir el tema**: WordPress → Apariencia → Temas → Añadir nuevo → Subir tema → `dist/agave-taco-shop-theme.zip` → Activar.
2. **(Recomendado) Instalar plugins**: *WordPress Importer* (obligatorio para el paso 3), *Yoast SEO* o *Rank Math* (lee automáticamente los títulos, descripciones y palabras clave del XML) y *WP Mail SMTP* (para que lleguen los formularios).
3. **Importar el contenido**: Herramientas → Importar → WordPress → subir `dist/agave-taco-shop-wordpress-import.xml` → asignar autor → marcar **“Descargar e importar archivos adjuntos”** → Enviar.
4. Al terminar, el tema configura solo la portada, la página del blog, los menús, los enlaces permanentes `/%postname%/`, la zona horaria y el lema. Si hiciera falta, en el Escritorio aparece el botón **“Run one-click setup”**.
5. **Logo**: Apariencia → Personalizar → Identidad del sitio → Logo (sube el logo oficial de Agave en PNG transparente). Mientras no haya logo se muestra un wordmark animado con el ícono de agave.
6. **Datos del negocio y slides**: Apariencia → Personalizar → *Agave Taco Shop* → teléfono, correo de formularios, enlaces de pedido (Toast, DoorDash, Uber Eats, Postmates), redes sociales y los 5 slides del hero (imagen, textos y botón).
7. Ajustes → Lectura: confirma que **“Disuade a los motores de búsqueda”** está desmarcado antes de lanzar.

> El XML usa `https://www.agavetacoshop.com` como dominio base. Para otro dominio de pruebas: `python3 content/build_wxr.py --site https://staging.ejemplo.com`.

## Cosas que debe confirmar el cliente antes de publicar

- **Menú**: los platillos se basan en la información pública (pedido en línea, prensa y reseñas). Revisar nombres y agregar/quitar en `theme/agave-taco-shop/inc/menu-data.php`. Los precios no se muestran a propósito: el botón “Order Online” lleva al menú con precios actualizados.
- **Políticas de catering** (mínimo de 10 personas, reservar con 72 h, entrega/montaje): son una propuesta; ajustar en la página Catering.
- **Coordenadas GPS** (`32.7535, -117.2187`): verificarlas con el pin exacto de Google Maps en Personalizar → Latitud/Longitud.
- **Correo** para formularios: configurarlo en Personalizar (si se deja vacío llegan al correo del administrador).
- **Reseñas**: la sección de la portada resume los temas que más mencionan los clientes en reseñas públicas (porciones, servicio, birria y aguas frescas); no inventa nombres. Se puede reemplazar por un widget oficial de Google Reviews.

## Logo, fotos de Facebook e Instagram

Este entorno de trabajo tiene bloqueado el acceso a agavetacoshop.com, Facebook e Instagram (firewall del sandbox), así que **no se pudieron descargar el logo ni las fotos de las redes**. Por eso:

- El tema soporta el **logo oficial** desde el Personalizador (paso 5).
- Cada imagen del sitio se puede reemplazar subiendo una foto a la Biblioteca de medios con el *slug* `agave-<clave>` (por ejemplo `agave-dish-quesabirria`); el tema la detecta sola. La lista de claves está en `docs/IMAGES.md`. Recomendado: usar las mejores fotos reales de @agavetacoshop.
- Los logos de “clientes/partners” (Toast, DoorDash, Uber Eats, Postmates, Yelp) se muestran como tarjetas tipográficas con sus colores de marca y enlaces reales, sin usar archivos de logotipos con derechos de marca.

## Regenerar el XML

```bash
python3 content/build_wxr.py            # escribe dist/agave-taco-shop-wordpress-import.xml
```

Edita los textos en `content/pages.py` y `content/posts.py`; las imágenes en `content/images.py`.
