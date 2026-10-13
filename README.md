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

## Bot de WhatsApp (open-wa)

```bash
npm run bot:install
npm run bot
```

Ver [whatsapp-bot/README.md](whatsapp-bot/README.md) para requisitos y detalles.

## Temas WordPress

| Tema | Carpeta | Sitio |
| --- | --- | --- |
| **Webmaster Tijuana** | [`webmaster-tijuana/`](webmaster-tijuana/) | Sitio de la agencia (reemplaza al `index.html` estático) |
| Cardio Canseco | [`cardio-canseco/`](cardio-canseco/) | Cardiología Tijuana, Dr. Eduardo Canseco |

Para correr cualquiera localmente (PHP 7.4+ con SQLite, sin MySQL):

```bash
scripts/wp-local.sh                       # webmaster-tijuana en http://localhost:8080
scripts/wp-local.sh cardio-canseco 8081   # el otro tema
```

Usuario `admin` / `admin123`. Al entrar por primera vez a `/wp-admin` el tema crea su contenido inicial.
Para producción, comprime la carpeta del tema y súbela en Apariencia → Temas → Añadir nuevo.

### Webmaster Tijuana: qué incluye

- **Inicio**: slider de servicios, por qué elegirnos, servicios, proceso, testimonios y formulario de cotización.
- **Servicios** (`/servicios/`) y **Portafolio** (`/portafolio/`) administrables desde el escritorio, con icono y lista «Qué incluye» por servicio.
- **Testimonios** administrables.
- **Formulario de cotización**: cada solicitud se guarda en *Cotizaciones* y se envía por correo al destinatario configurado (con nonce, campo trampa y límite de un envío por minuto).
- **Personalizador → Webmaster Tijuana**: teléfono, WhatsApp, correo, dirección, horario, redes sociales, textos e imágenes de cada slide y textos de la sección de cotización.
- Al activarse crea las páginas (Inicio, Nosotros, Contacto, Cotizar ahora, Blog, Aviso de privacidad), los 6 servicios, 3 testimonios y los menús, y deja la portada configurada. Nunca sobrescribe contenido existente.
- Datos estructurados `ProfessionalService` y `Service`, meta descripción y Open Graph si no hay plugin de SEO.
