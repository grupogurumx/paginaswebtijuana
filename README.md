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

## Tema WordPress: Cardio Canseco

El tema está en [`cardio-canseco/`](cardio-canseco/). Para correrlo localmente (PHP 7.4+ con SQLite, sin MySQL):

```bash
scripts/wp-local.sh          # http://localhost:8080 — admin / admin123
```

Al entrar por primera vez a `/wp-admin` el tema crea las páginas, los procedimientos y la portada.
Para producción, comprime la carpeta `cardio-canseco/` y súbela en Apariencia → Temas → Añadir nuevo.
