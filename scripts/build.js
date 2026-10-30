// Copia solo los archivos públicos del sitio a dist/ para Cloudflare Pages.
const fs = require('fs');
const path = require('path');

const root = path.join(__dirname, '..');
const out = path.join(root, 'dist');
const publicFiles = ['index.html', 'assets', '_headers'];

fs.rmSync(out, { recursive: true, force: true });
fs.mkdirSync(out);

for (const file of publicFiles) {
  const src = path.join(root, file);
  if (fs.existsSync(src)) {
    fs.cpSync(src, path.join(out, file), { recursive: true });
  }
}

console.log(`Sitio listo en ${path.relative(root, out)}/`);
