#!/usr/bin/env node
// Genera el archivo WXR (XML de WordPress) con páginas ES/EN y el blog bilingüe.
// Uso: node hospital-nova/scripts/build-wxr.js
// Salida: hospital-nova/hospital-nova-contenido.xml
const fs = require('fs');
const path = require('path');

const root = path.join(__dirname, '..');
const pages = require(path.join(root, 'contenido/paginas.js'));
const blogEs = require(path.join(root, 'contenido/blog-es.js'));
const blogEn = require(path.join(root, 'contenido/blog-en.js'));

const SITE = 'https://hospitalnova.com';
const cdata = (s) => `<![CDATA[${String(s || '').replace(/]]>/g, ']]]]><![CDATA[>')}]]>`;
const esc = (s) => String(s).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
const slugify = (s) => s.toLowerCase().normalize('NFD').replace(/[̀-ͯ]/g, '').replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');

// PHP serialize para el mapa de traducciones de Polylang.
const phpSerialize = (obj) => {
  const keys = Object.keys(obj);
  return `a:${keys.length}:{` + keys.map((k) => `s:${Buffer.byteLength(k)}:"${k}";i:${obj[k]};`).join('') + '}';
};

let id = 9100;
const items = [];
const pairs = {};
const cats = new Map();
const tags = new Map();

const meta = (k, v) => `\t\t<wp:postmeta>\n\t\t\t<wp:meta_key>${cdata(k)}</wp:meta_key>\n\t\t\t<wp:meta_value>${cdata(v)}</wp:meta_value>\n\t\t</wp:postmeta>`;

// Fechas escalonadas para que el blog tenga un orden natural.
const baseDate = new Date('2026-09-01T09:00:00Z');
const dateFor = (i) => {
  const d = new Date(baseDate.getTime() + i * 6 * 86400000);
  return d.toISOString().replace('T', ' ').slice(0, 19);
};

function addItem(o) {
  const postId = ++id;
  if (o.pair) {
    pairs[o.pair] = pairs[o.pair] || {};
    pairs[o.pair][o.lang] = postId;
  }
  const terms = [];
  terms.push(`\t\t<category domain="language" nicename="${o.lang}">${cdata(o.lang === 'en' ? 'English' : 'Español')}</category>`);
  if (o.pair) terms.push(`\t\t<category domain="post_translations" nicename="pll_${o.pair}">${cdata('pll_' + o.pair)}</category>`);
  (o.categories || []).forEach((c) => {
    const nicename = slugify(c);
    cats.set(nicename, c);
    terms.push(`\t\t<category domain="category" nicename="${nicename}">${cdata(c)}</category>`);
  });
  (o.tags || []).forEach((t) => {
    const nicename = slugify(t);
    tags.set(nicename, t);
    terms.push(`\t\t<category domain="post_tag" nicename="${nicename}">${cdata(t)}</category>`);
  });
  const metas = [];
  if (o.meta) {
    metas.push(meta('_nova_meta_description', o.meta));
    metas.push(meta('rank_math_description', o.meta));
    metas.push(meta('_yoast_wpseo_metadesc', o.meta));
  }
  if (o.keyword) {
    metas.push(meta('rank_math_focus_keyword', o.keyword));
    metas.push(meta('_yoast_wpseo_focuskw', o.keyword));
  }
  if (o.img) metas.push(meta('_nova_fallback_img', o.img));
  if (o.template) metas.push(meta('_wp_page_template', o.template));

  items.push(`\t<item>
\t\t<title>${cdata(o.title)}</title>
\t\t<link>${SITE}/${o.slug}/</link>
\t\t<pubDate>${new Date(o.date.replace(' ', 'T') + 'Z').toUTCString()}</pubDate>
\t\t<dc:creator>${cdata('admin')}</dc:creator>
\t\t<guid isPermaLink="false">${SITE}/?p=${postId}</guid>
\t\t<description></description>
\t\t<content:encoded>${cdata(o.content.trim())}</content:encoded>
\t\t<excerpt:encoded>${cdata(o.excerpt || '')}</excerpt:encoded>
\t\t<wp:post_id>${postId}</wp:post_id>
\t\t<wp:post_date>${cdata(o.date)}</wp:post_date>
\t\t<wp:post_date_gmt>${cdata(o.date)}</wp:post_date_gmt>
\t\t<wp:comment_status>${cdata('closed')}</wp:comment_status>
\t\t<wp:ping_status>${cdata('closed')}</wp:ping_status>
\t\t<wp:post_name>${cdata(o.slug)}</wp:post_name>
\t\t<wp:status>${cdata('publish')}</wp:status>
\t\t<wp:post_parent>0</wp:post_parent>
\t\t<wp:menu_order>${o.order || 0}</wp:menu_order>
\t\t<wp:post_type>${cdata(o.type)}</wp:post_type>
\t\t<wp:post_password>${cdata('')}</wp:post_password>
\t\t<wp:is_sticky>0</wp:is_sticky>
${terms.join('\n')}
${metas.join('\n')}
\t</item>`);
}

pages.forEach((pg, i) => addItem({ ...pg, type: 'page', date: dateFor(0), order: i }));
blogEs.forEach((a, i) => {
  addItem({ ...a, type: 'post', lang: 'es', pair: 'post' + i, categories: [a.category], date: dateFor(i + 1) });
  const en = blogEn[i];
  addItem({ ...en, type: 'post', lang: 'en', pair: 'post' + i, categories: [en.category], date: dateFor(i + 1) });
});

const termXml = [];
let tid = 500;
cats.forEach((name, slug) => termXml.push(`\t<wp:category>\n\t\t<wp:term_id>${++tid}</wp:term_id>\n\t\t<wp:category_nicename>${cdata(slug)}</wp:category_nicename>\n\t\t<wp:category_parent>${cdata('')}</wp:category_parent>\n\t\t<wp:cat_name>${cdata(name)}</wp:cat_name>\n\t</wp:category>`));
tags.forEach((name, slug) => termXml.push(`\t<wp:tag>\n\t\t<wp:term_id>${++tid}</wp:term_id>\n\t\t<wp:tag_slug>${cdata(slug)}</wp:tag_slug>\n\t\t<wp:tag_name>${cdata(name)}</wp:tag_name>\n\t</wp:tag>`));
// Grupos de traducción Polylang (se enlazan si los IDs se conservan al importar).
Object.entries(pairs).forEach(([pair, map]) => {
  termXml.push(`\t<wp:term>\n\t\t<wp:term_id>${++tid}</wp:term_id>\n\t\t<wp:term_taxonomy>${cdata('post_translations')}</wp:term_taxonomy>\n\t\t<wp:term_slug>${cdata('pll_' + pair)}</wp:term_slug>\n\t\t<wp:term_parent>${cdata('')}</wp:term_parent>\n\t\t<wp:term_name>${cdata('pll_' + pair)}</wp:term_name>\n\t\t<wp:term_description>${cdata(phpSerialize(map))}</wp:term_description>\n\t</wp:term>`);
});

const xml = `<?xml version="1.0" encoding="UTF-8" ?>
<!-- Hospital Nova — contenido para importar en WordPress (Herramientas > Importar > WordPress). -->
<!-- Generado por hospital-nova/scripts/build-wxr.js — no editar a mano; edita hospital-nova/contenido/*.js -->
<rss version="2.0"
\txmlns:excerpt="http://wordpress.org/export/1.2/excerpt/"
\txmlns:content="http://purl.org/rss/1.0/modules/content/"
\txmlns:wfw="http://wellformedweb.org/CommentAPI/"
\txmlns:dc="http://purl.org/dc/elements/1.1/"
\txmlns:wp="http://wordpress.org/export/1.2/">
<channel>
\t<title>Hospital Nova</title>
\t<link>${SITE}</link>
\t<description>${esc('¡Servicios Médicos de Confianza!')}</description>
\t<language>es-MX</language>
\t<wp:wxr_version>1.2</wp:wxr_version>
\t<wp:base_site_url>${SITE}</wp:base_site_url>
\t<wp:base_blog_url>${SITE}</wp:base_blog_url>
\t<wp:author><wp:author_id>1</wp:author_id><wp:author_login>${cdata('admin')}</wp:author_login><wp:author_email>${cdata('info@hospitalnova.com')}</wp:author_email><wp:author_display_name>${cdata('Equipo médico Hospital Nova')}</wp:author_display_name><wp:author_first_name>${cdata('')}</wp:author_first_name><wp:author_last_name>${cdata('')}</wp:author_last_name></wp:author>
${termXml.join('\n')}
${items.join('\n')}
</channel>
</rss>
`;

const out = path.join(root, 'hospital-nova-contenido.xml');
fs.writeFileSync(out, xml);
console.log(`WXR listo: ${path.relative(process.cwd(), out)} — ${pages.length} páginas, ${blogEs.length + blogEn.length} entradas`);
