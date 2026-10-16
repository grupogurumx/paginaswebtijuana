# Peanut Bakery 2.0: sitemap y wireframes página por página

Se conservan las **mismas secciones del sitio actual**: Inicio, Nosotros, Productos, Ventas (Mayoreo) y Contacto. Cambian el diseño, la estructura y el contenido. Además, "Ventas", que antes era solo un ancla `#mayoreo`, pasa a ser una **página propia indexable**, y se agrega un **Blog** para el SEO.

## Sitemap

```
peanutbakery.com
├── /                      Inicio           (front-page.php)
├── /nosotros/             Nosotros         (template-nosotros.php)
├── /productos/            Productos        (template-productos.php)
│   ├── #masa-madre
│   ├── #pan-dulce
│   ├── #bolillo-y-birote
│   ├── #panes-artesanales
│   └── #reposteria-fina
├── /mayoreo/              Ventas · Mayoreo (template-mayoreo.php)   ← menú "Ventas"
├── /blog/                 Blog             (index.php)
│   ├── /pan-de-masa-madre-rosarito/
│   ├── /proveedor-de-pan-para-restaurantes-tijuana-rosarito/
│   └── /birote-salado-vs-bolillo/
├── /contacto/             Contacto         (template-contacto.php)
└── /wp-sitemap.xml        Sitemap XML para Google
```

**Menú principal:** Inicio · Nosotros · Productos · Ventas · Blog · Contacto, más el botón verde **"Pedir ahora" (WhatsApp)**.

---

## Elementos globales (todas las páginas)

| # | Bloque | Contenido | Motion |
|---|---|---|---|
| G1 | **Barra superior** | Ubicación · horario · teléfono · correo · redes | — |
| G2 | **Header fijo** | Logo, menú y CTA WhatsApp | Efecto vidrio (blur); sombra al hacer scroll; subrayado animado en el menú; en móvil, hamburguesa animada con menú a pantalla completa |
| G3 | **Banda CTA** | "¿Se te antojó? Haz tu pedido en un mensaje" + WhatsApp + Cotizar mayoreo | Revelado al entrar |
| G4 | **Footer** | Marca, navegación, líneas de producto, contacto completo (NAP) y redes | Íconos con elevación |
| G5 | **WhatsApp flotante** | Botón fijo abajo a la derecha | Pulso continuo; la etiqueta "¿Pedimos pan?" aparece sola a los 3.5 s |

---

## 1. Inicio (wireframe)

```
┌──────────────────────────────────────────────────────────────┐
│ G1 Barra superior: 📍 Rosarito · 🕐 Horario · ☎ · ✉            │
├──────────────────────────────────────────────────────────────┤
│ G2 [Logo]     Inicio Nosotros Productos Ventas Blog Contacto  [WhatsApp] │
├──────────────────────────────────────────────────────────────┤
│ H1  SLIDER PANORÁMICO 3D (4 slides, alto completo)           │
│  ┌ eyebrow ─────────────┐                                    │
│  │ TÍTULO GRANDE        │      Foto real a sangre completa   │
│  │ texto                │      (cilindro 3D que gira)        │
│  │ [CTA] [Hacer pedido] │                                    │
│  └──────────────────────┘                                    │
│  01/04  ▬ ▬ ▬ ▬ (barras de progreso)        (←) (→)         │
├──────────────────────────────────────────────────────────────┤
│ Marquesina inclinada: Masa madre ✦ Conchas ✦ Birote ✦ …      │
├──────────────────────────────────────────────────────────────┤
│ INGENIERÍA DEL PAN   [Foto con tilt 3D + insignia "30 h"]    │
│                       H2 + texto + 3 contadores + CTA        │
├──────────────────────────────────────────────────────────────┤
│ LÍNEAS DE PAN: 5 tarjetas 3D (3 arriba + 2 abajo)            │
├──────────────────────────────────────────────────────────────┤
│ PROCESO (fondo espresso): 01 → 02 → 03 → 04 (línea animada)  │
├──────────────────────────────────────────────────────────────┤
│ #mayoreo  H2 + 4 beneficios + [Programa] [Cotizar WhatsApp]  │
├──────────────────────────────────────────────────────────────┤
│ GALERÍA con filtros por categoría (mosaico)                  │
├──────────────────────────────────────────────────────────────┤
│ FAQ (6 preguntas, acordeón + Schema FAQPage)                 │
├──────────────────────────────────────────────────────────────┤
│ VISÍTANOS: 5 tarjetas de contacto + mapa de Google           │
├──────────────────────────────────────────────────────────────┤
│ G3 Banda CTA → G4 Footer                       G5 WhatsApp ● │
└──────────────────────────────────────────────────────────────┘
```

### Slides del encabezado panorámico 3D
| # | Eyebrow | Título | CTA | Foto (Biblioteca de Medios, automática) |
|---|---|---|---|---|
| 1 | Panadería artesanal en Playas de Rosarito | Pan de masa madre con *30 horas* de fermentación | Ver productos | contiene "masa", "hogaza" o "hero" (o el video del Personalizador) |
| 2 | Pan dulce tradicional | Conchas, donas y pan dulce *recién horneado* | Pedir por WhatsApp | "concha", "dona" o "dulce" |
| 3 | Bolillo y birote | El birote salado que tu *torta* merece | Conocer la línea | "birote", "bolillo" |
| 4 | Ventas de mayoreo | Pan para *restaurantes, cafés y hoteles* | Cotizar mayoreo | "mayoreo", "horno", "entrega" |

**Cómo funciona el 3D:** las 4 fotos forman las caras de un cilindro (`perspective: 1600px`, `rotateY` y `translateZ`). Al avanzar, el anillo gira 90° mientras el escenario se aleja (escala 0.86) y vuelve. Así se percibe la profundidad, como una vista panorámica. Además tiene:
- Ken Burns (zoom lento) sobre la foto activa
- Parallax de profundidad que sigue al mouse
- Textos que entran por capas con rotación en X
- Autoplay de 7 s con barra de progreso; pausa con hover, foco o pestaña oculta
- Swipe táctil y flechas del teclado
- Con `prefers-reduced-motion`, todo se vuelve estático (accesibilidad)

---

## 2. Nosotros
```
Header top panorámico (parallax + ola) · migas · H1 "Nosotros: la ingeniería del pan"
Historia (2 párrafos + contenido editable de la página) | Foto tilt + insignia 30 h
Valores: 4 tarjetas (Ingeniería del pan · Hecho a mano · Fermentación lenta · Calidad transparente)
Proceso de 30 h (4 pasos, fondo oscuro)
El espacio: foto panorámica con parallax + tarjeta flotante (dirección, horario, "Cómo llegar")
Banda CTA → Footer
```

## 3. Productos
```
Header top · H1 "Pan de masa madre, pan dulce y birote"
Sub-navegación fija con las 5 líneas (se resalta la línea visible)
Por cada línea (alternando izquierda y derecha):
   Foto 4:5 con tilt + número gigante 01…05
   chip · H2 "<Línea> en Rosarito" · descripción
   Lista tipo menú: producto ........ [Pedir 🟢] (WhatsApp con el producto prellenado)
   [Pedir esta línea] [Precio de mayoreo]
Banda CTA → Footer
```

## 4. Ventas · Mayoreo
```
Header top · H1 "Pan al mayoreo para restaurantes, cafés y hoteles"
4 beneficios (entregas programadas · precio preferente · calidad constante · menú a la medida)
A quién surtimos: Cafeterías · Restaurantes y taquerías · Hoteles y eventos · Tiendas
Tu primer pedido en 4 pasos (Cotiza → Prueba → Programa → Recibe)
Formulario de cotización (correo a ventas@ o "Enviar por WhatsApp")
```

## 5. Contacto
```
Header top · H1 "Contacto"
5 tarjetas: WhatsApp · Teléfono · Correo · Ubicación · Horario
Formulario (Nombre, Teléfono, Correo, Motivo, Mensaje) → ventas@peanutbakery.com o WhatsApp
Mapa de Google
```

## 6. Blog y artículos
Header top, tarjetas de artículos (3 columnas) y, en cada artículo, una caja CTA de WhatsApp al final. Schema BlogPosting.

---

## Sistema visual
| Token | Valor | Uso |
|---|---|---|
| Harina | `#fffaf3` | Fondo principal |
| Crema | `#f5ebdd` | Secciones alternas |
| Cacahuate | `#c98a4b` | Color de marca, CTA, acentos en cursiva |
| Corteza | `#8a4b22` | Hover y textos de acento |
| Espresso | `#2a1a12` | Texto, secciones oscuras, barra superior |
| WhatsApp | `#25d366` | Todos los CTA de pedido |
| Display | **Fraunces** (serif con cursiva expresiva) | Títulos |
| Texto | **Inter** | Párrafos e interfaz |

Bordes redondeados de 22 px, sombras cálidas y profundas, curvas de animación `cubic-bezier(.22,1,.36,1)`.
