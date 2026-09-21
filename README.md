# Paginas Web Tijuana

Sitio web para Paginas Web Tijuana.

## Instalación

```bash
npm install
```

## Uso

```bash
npm start
```

## Landing page: Grupo Guru (guía de Google)

Archivo: `guia-google.html`

Landing de captación (lead magnet) para Grupo Guru con la guía
"5 razones por las que tu empresa no aparece en Google".
Es una página estática (Tailwind + Alpine desde CDN); se abre directo en el
navegador o se sube a `www.grupoguru.com/guia-google.html`.

### Pendientes de configuración

Dentro del archivo, marcados con `TODO` o en el bloque de configuración del
script al final:

- `FORM_ENDPOINT`: URL que recibe los leads (Formspree, Make, Zapier o API
  propia). Si se deja vacío, el formulario abre el correo del usuario como
  respaldo hacia `CORREO_LEADS`.
- `GUIA_PDF_URL`: ruta del PDF de la guía. Si se deja vacía, se oculta el
  botón de descarga directa.
- Logo oficial, número de WhatsApp, correo, redes sociales y enlace al aviso
  de privacidad.
- Imagen Open Graph (`assets/og-guia-google.jpg`, 1200x630).
- Paleta de marca en `tailwind.config` (primary, secondary, gold).
