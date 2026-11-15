# Hospital Nova: rediseño web 2026 (tema WordPress)

Sitio médico moderno para **Hospital Nova (Tijuana)**: slider panorámico 3D, animaciones motion, formulario de captación de pacientes, SEO técnico y versión **español (predeterminada) / inglés**.

## Contenido de esta carpeta
| Ruta | Qué es |
|---|---|
| `hospital-nova-theme.zip` | Tema listo para subir a WordPress |
| `wp-theme/hospital-nova/` | Código fuente editable del tema (PHP, CSS y JS) |
| `hospital-nova-contenido.xml` | Archivo WXR para importar: 14 páginas (7 ES + 7 EN) y 20 artículos (10 ES + 10 EN) |
| `contenido/*.js` | Textos editables de páginas y blog; regeneran el XML |
| `prototipo/index.html` · `index-en.html` | Vista previa estática de la portada, generada desde el tema |
| `SEO-ESTRATEGIA.md` | Palabras clave ES/EN, SEO técnico y local, plan de contenido y KPIs |
| `PROMPTS-IMAGENES.md` | Prompts para generar las imágenes finales en Higgsfield, Magnific o Canva |

## Instalación (unos 15 minutos)
1. **Plugins**: instala **Polylang** (bilingüe), **WordPress Importer**, **WP Mail SMTP** (entrega del correo) y, opcionalmente, **Rank Math SEO**.
2. **Idiomas** (Idiomas → Idiomas): crea **Español (es_MX)** con código `es` como idioma predeterminado, y **English (en_US)** con código `en`.
3. **Tema**: Apariencia → Temas → Añadir → Subir → `hospital-nova-theme.zip` → Activar.
4. **Contenido**: Herramientas → Importar → WordPress → sube `hospital-nova-contenido.xml` y asígnalo a tu usuario.
   - Cada página y entrada se importa con su idioma. Si alguna pareja ES↔EN no queda enlazada, únelas en el editor desde el panel de Polylang (columna de banderas).
5. **Lectura** (Ajustes → Lectura): portada estática = **Inicio**; página de entradas = **Blog de salud**. En Polylang, asigna **Home** como portada EN y **Health Blog** como blog EN.
6. **Enlaces permanentes**: "Nombre de la entrada".
7. **Personalizar → Hospital Nova**: confirma correo (`info@hospitalnova.com`), teléfonos, **dirección completa**, latitud y longitud, y redes. Sube el **logotipo** en *Identidad del sitio*.
8. **Menús**: crea "Principal" ES y EN (Inicio, Especialidades, Servicios 24/7, Médicos, Blog, Contacto) y asígnalos. Mientras no exista un menú, el tema muestra uno automático.
9. **Aviso de privacidad**: revisa la plantilla con el área legal y márcala en Ajustes → Privacidad.

## Formulario de contacto
- Shortcode `[nova_contact_form]` (ya incluido en *Contacto*, *Especialidades*, *Médicos* y la portada).
- Envía cada solicitud a `info@hospitalnova.com` (configurable) con *Reply-To* del paciente, y **guarda una copia** en el menú **Solicitudes / Leads** del admin.
- Antispam: nonce, honeypot, tiempo mínimo de llenado y límite de 5 envíos por IP cada 10 minutos.
- Las tarjetas de especialidad abren el formulario con el servicio preseleccionado (`/contacto/?esp=neurologia#cita`).

## Secciones como shortcodes
`[nova_specialties]` `[nova_partners]` `[nova_doctors]` `[nova_stats]` `[nova_maternity]` `[nova_faq]` `[nova_latest_posts count="3"]` `[nova_contact]`
Insértalas con el bloque *Shortcode* en cualquier página. Los datos de médicos, especialidades y FAQ están en `inc/helpers.php`.

## Hero: slider panorámico 3D
- Cilindro 3D en CSS (`perspective` + `rotateY`/`translateZ`): las tarjetas se duplican hasta formar un anillo de 10 caras, con radio calculado automáticamente.
- Autoplay con barra de progreso, flechas, puntos, teclado (← →), arrastre o swipe, y parallax 3D con el mouse.
- Título con revelado "magnific" palabra por palabra (desenfoque + deslizamiento), malla de gradiente animada, botones magnéticos y marquee de servicios.
- Respeta `prefers-reduced-motion`.
- Imágenes y títulos editables en el Personalizador; velocidad en *Autoplay (ms)*.

## Editar textos y regenerar el XML
```bash
node hospital-nova/scripts/build-wxr.js
```

## Regenerar el prototipo estático (prueba las plantillas sin WordPress)
```bash
node hospital-nova/scripts/export-posts.js /tmp/posts.json
```
```bash
php hospital-nova/scripts/render-prototype.php es /tmp/posts.json
```

## Pendientes del cliente
- **Dirección exacta** y coordenadas (no se pudo leer el sitio actual).
- Confirmar qué **WhatsApp general** usar. Por ahora es 664 464 93 91, el del flyer de maternidad.
- Confirmar la grafía del nombre del internista: el flyer dice "Cessar"; en el sitio se usa "César".
- Fotos reales del hospital y logotipo en PNG o SVG.
