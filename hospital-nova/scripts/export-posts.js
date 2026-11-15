// Exporta los artículos a JSON para el render del prototipo.
const path = require('path');
const fs = require('fs');
const pick = (a) => ({ slug: a.slug, title: a.title, excerpt: a.excerpt, img: a.img, category: a.category });
const data = {
  es: require(path.join(__dirname, '../contenido/blog-es.js')).map(pick),
  en: require(path.join(__dirname, '../contenido/blog-en.js')).map(pick),
};
const out = process.argv[2] || path.join(__dirname, 'posts.json');
fs.writeFileSync(out, JSON.stringify(data));
console.log('posts →', out);
