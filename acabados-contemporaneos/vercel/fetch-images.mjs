// Descarga el paquete de imágenes del sitio y lo extrae en public/img/.
// Se ejecuta en el build de Vercel (npm run build).
import AdmZip from 'adm-zip';
import { mkdirSync, writeFileSync, existsSync, readdirSync } from 'node:fs';
import { basename, join } from 'node:path';

const ZIP_URL = process.env.AC_IMAGES_ZIP ||
  'https://d2ol7oe51mr4n9.cloudfront.net/user_39X9oUM6mjMuWX1gzCztnOmmGzI/585a0a48-ca28-455a-8042-bda4fa1f00f0.zip';
const DEST = join(process.cwd(), 'public', 'img');

mkdirSync(DEST, { recursive: true });

async function load() {
  if (process.env.AC_IMAGES_ZIP_FILE) {
    const { readFileSync } = await import('node:fs');
    return readFileSync(process.env.AC_IMAGES_ZIP_FILE);
  }
  const res = await fetch(ZIP_URL);
  if (!res.ok) throw new Error(`No se pudo descargar ${ZIP_URL}: HTTP ${res.status}`);
  return Buffer.from(await res.arrayBuffer());
}

const zip = new AdmZip(await load());
let count = 0;
for (const entry of zip.getEntries()) {
  if (entry.isDirectory || !entry.entryName.endsWith('.webp')) continue;
  writeFileSync(join(DEST, basename(entry.entryName)), entry.getData());
  count++;
}
if (count === 0) throw new Error('El ZIP no contiene imágenes .webp');
console.log(`${count} imágenes extraídas en public/img/`);
if (!existsSync(join(DEST, 'hero-sala.webp'))) throw new Error('Falta hero-sala.webp');
console.log(readdirSync(DEST).join(', '));
