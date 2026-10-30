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

## Cloudflare Pages

El sitio estático (`index.html` + `assets/`) se publica en Cloudflare Pages. `npm run build` copia solo los archivos públicos a `dist/`.

```bash
npm run dev      # vista previa local con wrangler
npm run deploy   # publica manualmente (requiere `npx wrangler login`)
```

**Opción A – Conectar el repo en el panel de Cloudflare:** Workers & Pages → Create → Pages → Connect to Git → `paginaswebtijuana`. Build command: `npm run build`, Build output directory: `dist`.

**Opción B – GitHub Actions:** agrega los secretos `CLOUDFLARE_API_TOKEN` (permiso *Cloudflare Pages: Edit*) y `CLOUDFLARE_ACCOUNT_ID` en el repo. El workflow `.github/workflows/cloudflare-pages.yml` despliega cada push a la rama principal (`claude/hallmark-install-k82SX`) y crea previews en los PRs.
