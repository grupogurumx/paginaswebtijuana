# Peanut Bakery: posicionamiento orgánico, keywords y competencia

> Objetivo: ganar visibilidad en Google para búsquedas locales de **Playas de Rosarito** y **Tijuana** a corto plazo (30 a 90 días), con dos motores de venta: **pedidos por WhatsApp** (consumidor final) y **mayoreo** (restaurantes, cafeterías, hoteles y tiendas).

**Nota sobre volúmenes de búsqueda:** las herramientas de volumen (Ahrefs y Similarweb) no estaban conectadas en esta sesión. Por eso la prioridad de cada keyword se basa en tres cosas: intención de compra, competencia observada en los resultados y encaje con el negocio. No son volúmenes medidos. Al conectar Google Search Console verás impresiones reales en 2 a 4 semanas; ajusta con esos datos.

---

## 1. Análisis de la competencia

| Competidor | Ubicación | En qué se posiciona | Debilidad que aprovechamos |
|---|---|---|---|
| **Bastón Horno de Pan** | Blvd. Popotla km 31.5, Rosarito | Masa madre, pan dulce tradicional, bizcochería, abierto diario de 8 a 21 h, menciona mayoreo. Fuerte en Instagram y TikTok | No tiene un sitio web con contenido propio indexable. Su presencia depende de redes y menciones de terceros |
| **Casa Nagú** | Carretera libre km 17.5, Rosarito | "Conchas", pan hecho a mano sin maquinaria, notas de prensa (SanDiegoRed) | Enfocado en turismo y menudeo. Poca presencia para mayoreo o para negocios |
| **La Espiga** | Benito Juárez 298, Rosarito | Pan dulce y conchas recién horneadas (Yelp) | Sin sitio propio optimizado. Depende de Yelp |
| **Mr. Bisquet** | Rosarito | Brunch y bakehouse con masa madre (Tripadvisor) | Es restaurante, no proveedor ni panadería de línea |
| **SOCO Café y Galería** | Rosarito | Café y pan de masa madre europeo | Su oferta de pan es secundaria |
| **Panificadora Rosarito** | Rosarito | Pan tradicional y hojaldres | No trabaja masa madre ni mayoreo especializado |
| **AC Gourmet Mayoreo** | Av. Matamoros, Tijuana | Pan artesanal al mayoreo para negocios | Está en Tijuana, no cubre la costa. Sin contenido de marca |
| **Panadería La Mejor / Pan y Mantequilla / Panadería Diego** | Tijuana | Pan dulce, croissants, tradición | Enfocadas en menudeo dentro de Tijuana |

**Conclusión:** en Rosarito nadie tiene un **sitio web con SEO real** que combine *masa madre, pan dulce y mayoreo*. La mayoría vive en Instagram, Yelp o TikTok. Peanut Bakery ya aparece en Google para "pan artesanal Rosarito"; con el rediseño atacamos tres huecos:

1. **Masa madre en Rosarito:** contenido técnico ("30 horas de fermentación", "ingeniería del pan") que nadie más tiene en su sitio.
2. **Mayoreo y proveedor de pan en Tijuana y Rosarito:** página dedicada, cuando los competidores solo lo mencionan.
3. **Preguntas frecuentes con Schema FAQ:** permiten ocupar más espacio en el resultado de Google.

---

## 2. Mapa de keywords (por página)

Prioridad: **A** = atacar ya (alta intención, baja competencia), **B** = mes 2, **C** = largo plazo y blog.

### Inicio `/`
| Keyword | Intención | Prioridad |
|---|---|---|
| panadería en Rosarito | local, transaccional | A |
| panadería artesanal Rosarito | local, transaccional | A |
| panadería Playas de Rosarito | local | A |
| pan artesanal Rosarito | local | A |
| panadería cerca de mí (Rosarito) | local, móvil | A (se gana con Google Business Profile) |
| bakery Rosarito / Rosarito bakery | turistas de EE. UU. | B |

### Productos `/productos/`
| Keyword | Ancla | Prioridad |
|---|---|---|
| pan de masa madre Rosarito | `#masa-madre` | A |
| sourdough Rosarito / sourdough bread Baja | `#masa-madre` | B |
| conchas Rosarito / pan dulce Rosarito | `#pan-dulce` | A |
| birote salado Rosarito / Tijuana | `#bolillo-y-birote` | A |
| bolillo Rosarito | `#bolillo-y-birote` | B |
| croissants Rosarito | `#reposteria-fina` | B |
| focaccia / baguette Rosarito | `#panes-artesanales` | C |
| donas Rosarito | `#pan-dulce` | B |

### Mayoreo (Ventas) `/mayoreo/`
| Keyword | Prioridad |
|---|---|
| pan al mayoreo Rosarito | A |
| pan al mayoreo Tijuana | A |
| proveedor de pan para restaurantes Tijuana | A |
| proveedor de pan para cafeterías | A |
| pan para hoteles Rosarito | B |
| birote al mayoreo / bolillo al mayoreo Tijuana | A |
| pan para taquerías Tijuana | B |

### Nosotros `/nosotros/`
| Keyword | Prioridad |
|---|---|
| Peanut Bakery (marca) | A |
| ingeniería del pan | B (concepto propio, fácil de ganar) |
| panadería de masa madre fermentación lenta | C |

### Contacto `/contacto/`
| Keyword | Prioridad |
|---|---|
| Peanut Bakery teléfono / WhatsApp | A (marca) |
| pedido de pan por WhatsApp Rosarito | B |
| pan para eventos Rosarito | B |

### Blog `/blog/` (artículos ya incluidos en la importación)
| Artículo | Keyword principal |
|---|---|
| Pan de masa madre en Rosarito: qué es y por qué lo fermentamos 30 horas | pan de masa madre Rosarito |
| Proveedor de pan para restaurantes en Tijuana y Rosarito | proveedor de pan restaurantes Tijuana |
| Birote salado vs. bolillo | birote vs bolillo, birote salado |

**Próximos artículos sugeridos (uno cada 2 semanas):**
1. "Rosca de Reyes en Rosarito: cómo encargarla" (publicar en noviembre)
2. "Pan de muerto artesanal en Rosarito" (publicar a inicios de octubre)
3. "Cómo calentar pan de masa madre para que quede crujiente"
4. "Las mejores tortas de Baja: qué pan usar"
5. "Pan para bodas y eventos en Rosarito: guía de cantidades"
6. "Beneficios del pan de fermentación lenta"

---

## 3. SEO on-page ya implementado en el tema

| Elemento | Implementación |
|---|---|
| **Títulos únicos** de 60 caracteres o menos por página | `inc/seo.php` → `pb_seo_map()` |
| **Meta descripción** de 155 caracteres o menos con keyword + "Rosarito" + CTA | Igual. Editable por página en la caja "SEO · Meta descripción" |
| **Un solo H1** por página con la keyword principal | Comprobado en las 7 páginas |
| **Schema.org Bakery (LocalBusiness)** | Dirección, geo, horario, teléfono, área atendida (Rosarito, Tijuana, Ensenada), catálogo de productos y acción de pedido por WhatsApp |
| **Schema FAQPage** | 6 preguntas en Inicio, con opción a resultados enriquecidos |
| **BreadcrumbList y BlogPosting** | Páginas interiores y artículos |
| **Open Graph y Twitter Cards** | Imagen y texto al compartir en WhatsApp y Facebook |
| **Geo meta** (`geo.region MX-BCN`) | Señal local |
| **Sitemap XML** | El nativo de WordPress: `/wp-sitemap.xml` |
| **Alt text** descriptivo con keyword + ubicación | En todas las imágenes del tema |
| **Rendimiento** | Sin jQuery ni librerías; JS de unos 12 KB; `fetchpriority` en la imagen del hero; `lazy` en el resto; fuentes con `preconnect` |
| **Compatibilidad con Yoast o Rank Math** | Si se activa uno, el tema cede título, meta y OG, y mantiene el Schema local |
| **Enlazado interno** | Footer con anclas a cada línea; artículos enlazan a `/productos/#...` y `/mayoreo/` |

---

## 4. Plan de posicionamiento a corto plazo (90 días)

### Semana 1: base técnica e indexación
1. Instalar el tema y la importación (ver `03-INSTALACION.md`).
2. **Google Search Console**: verificar `https://www.peanutbakery.com`, enviar `https://www.peanutbakery.com/wp-sitemap.xml` y usar **Inspección de URL → Solicitar indexación** en: `/`, `/productos/`, `/mayoreo/`, `/nosotros/`, `/contacto/` y los 3 artículos.
3. **Bing Webmaster Tools**: importar desde Search Console (1 clic). Con eso también llega a Yahoo y DuckDuckGo.
4. **Google Analytics 4** con eventos de clic a WhatsApp (`wa.me`) y `tel:` como conversiones.
5. En el Personalizador (*Peanut Bakery → Datos de contacto*), completar **calle y número, código postal, latitud y longitud y horario real**. Con eso el Schema queda completo.

### Semana 1–2: Google Business Profile (el factor #1 del SEO local)
- Categoría principal: **Panadería**. Secundarias: *Pastelería*, *Mayorista de alimentos*, *Tienda de pan*.
- Nombre exacto: "Peanut Bakery" (sin agregar keywords: Google penaliza).
- Descripción con: *pan de masa madre, 30 horas de fermentación, pan dulce, birote, mayoreo, Playas de Rosarito*.
- Enlace de sitio web: `https://www.peanutbakery.com/?utm_source=gbp`.
- Botón de WhatsApp / "Pedir" → `https://wa.me/526611147744`.
- Subir **mínimo 20 fotos reales** (las mismas de la Biblioteca de Medios y de la sesión PB_01 a PB_05) y publicar 1 *post* semanal.
- **Reseñas:** pedir reseña a cada cliente de mayoreo y por WhatsApp después de cada pedido. Meta: 30 reseñas en 90 días. Responder todas.

### Semana 2–4: citas locales (NAP idéntico en todas)
Usar **exactamente** el mismo Nombre, Dirección y Teléfono que en el sitio:
- Apple Business Connect (Apple Maps), Bing Places, Waze
- Facebook e Instagram (botón de WhatsApp y enlace al sitio)
- Yelp México, Tripadvisor (categoría Panadería), Foursquare
- Sección Amarilla, Cylex México, Hotfrog México, Infoisinfo
- Directorios de Rosarito: Rosarito.org (Comité de Turismo), guías de Baja (Baja.com, Discover Baja)

### Mes 2: contenido y enlaces
- Publicar un artículo cada 2 semanas (lista arriba).
- Contactar a creadores de contenido que ya hablan de panaderías en Rosarito (por ejemplo @rosaritofood, @caliraisedtjlivin, Learning by Taste) para una visita o degustación. Cada mención con enlace es un backlink local.
- Pedir enlace a los **clientes de mayoreo** ("Nuestro pan es de Peanut Bakery") en su sitio o menú digital.
- Nota de prensa a medios de la región (SanDiegoRed, Zeta, El Imparcial) sobre "la panadería que aplica ingeniería del pan".

### Mes 3: optimizar con datos
- En Search Console, buscar consultas con **posición 8 a 20**: reforzar esa página con un párrafo y una pregunta frecuente nueva.
- Revisar CTR: si alguna página tiene muchas impresiones y CTR bajo, reescribir su meta descripción.
- Agregar reseñas reales de Google al sitio (sección testimonios) **solo con reseñas reales** y con permiso.

---

## 5. Indexación con WhatsApp (conversión)
- Botón flotante en todas las páginas, más CTA en header, hero, cada producto ("Pedir" por producto con mensaje prellenado), mayoreo, FAQ y footer.
- El formulario de Contacto y Mayoreo ofrece **"Enviar por WhatsApp"**: arma el mensaje con nombre, teléfono, negocio y pedido.
- El número se cambia en un solo lugar: *Apariencia → Personalizar → Peanut Bakery → Datos de contacto*.
- Medición: en GA4 marcar como conversión los clics a `wa.me` y `tel:`.

## 6. Datos de contacto (NAP oficial)
- **Nombre:** Peanut Bakery
- **Ciudad:** Playas de Rosarito, Baja California, México
- **Teléfono / WhatsApp:** 661 114 7744 (+52 661 114 7744)
- **Correo de ventas:** ventas@peanutbakery.com
- **Web:** https://www.peanutbakery.com
- **Por completar en el Personalizador:** calle y número, código postal, coordenadas y horario confirmado (el horario por defecto, lunes a domingo de 7:00 a 21:00, es provisional).
