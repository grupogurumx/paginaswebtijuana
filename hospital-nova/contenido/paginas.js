// Páginas del sitio (ES por defecto + EN). Las secciones [nova_*] son shortcodes del tema.
const sc = (code) => `<!-- wp:shortcode -->\n${code}\n<!-- /wp:shortcode -->`;
const p = (html) => `<!-- wp:paragraph -->\n<p>${html}</p>\n<!-- /wp:paragraph -->`;

module.exports = [
  // ---------- ESPAÑOL ----------
  { pair: 'home', lang: 'es', slug: 'inicio', title: 'Inicio', front: true,
    meta: 'Hospital Nova en Tijuana: urgencias 24/7, especialistas en medicina interna, neurología, cirugía oncológica y maternidad. Laboratorio, rayos X y banco de sangre.',
    content: '' },
  { pair: 'specialties', lang: 'es', slug: 'especialidades', title: 'Especialidades médicas en Tijuana',
    excerpt: 'Medicina interna, neurología, cirugía oncológica, maternidad, urgencias y hospitalización en un solo hospital.',
    meta: 'Especialidades médicas en Tijuana: medicina interna, neurología, cirugía oncológica, ginecología y urgencias 24/7. Agenda tu valoración en Hospital Nova.',
    content: [sc('[nova_specialties]'), sc('[nova_partners]'), sc('[nova_contact]')].join('\n\n') },
  { pair: 'services', lang: 'es', slug: 'servicios', title: 'Servicios 24/7: urgencias, quirófano y hospitalización',
    excerpt: 'Siempre abierto. Consulta médica, quirófano, hospitalización y diagnóstico 24/7 en Tijuana.',
    meta: 'Hospital 24 horas en Tijuana: urgencias, quirófano, hospitalización, laboratorio, rayos X y banco de sangre. Siempre abierto en Hospital Nova.',
    content: [sc('[nova_stats]'), sc('[nova_partners]'), sc('[nova_maternity]'), sc('[nova_faq]')].join('\n\n') },
  { pair: 'doctors', lang: 'es', slug: 'medicos', title: 'Médicos especialistas',
    excerpt: 'Conoce a los especialistas que consultan en Hospital Nova y agenda directo por WhatsApp.',
    meta: 'Directorio de médicos especialistas en Tijuana: internista, neurólogo y cirujanos oncólogos. Agenda tu cita en Hospital Nova.',
    content: [sc('[nova_doctors]'), sc('[nova_contact]')].join('\n\n') },
  { pair: 'contact', lang: 'es', slug: 'contacto', title: 'Contacto y citas',
    excerpt: 'Agenda tu cita por teléfono, WhatsApp o con el formulario. Atención 24/7.',
    meta: 'Contacta a Hospital Nova en Tijuana: agenda tu cita por teléfono, WhatsApp o formulario. Urgencias abiertas 24 horas.',
    content: [sc('[nova_contact]'), sc('[nova_faq]')].join('\n\n') },
  { pair: 'blog', lang: 'es', slug: 'blog', title: 'Blog de salud', posts: true,
    meta: 'Blog de salud de Hospital Nova Tijuana: artículos de medicina interna, neurología, maternidad, prevención y urgencias.', content: '' },
  { pair: 'privacy', lang: 'es', slug: 'aviso-de-privacidad', title: 'Aviso de privacidad', privacy: true,
    meta: 'Aviso de privacidad de Hospital Nova.',
    content: [
      p('<strong>Plantilla — revisar con el área legal del hospital antes de publicar.</strong>'),
      p('Hospital Nova, con domicilio en Tijuana, Baja California, es responsable del tratamiento de los datos personales que nos proporcione a través de este sitio web, conforme a la Ley Federal de Protección de Datos Personales en Posesión de los Particulares.'),
      p('Los datos que recabamos mediante el formulario (nombre, teléfono, correo y motivo de consulta) se utilizan exclusivamente para contactarle, agendar su cita y dar seguimiento a su solicitud.'),
      p('Para ejercer sus derechos ARCO escriba a <a href="mailto:info@hospitalnova.com">info@hospitalnova.com</a>.')
    ].join('\n\n') },

  // ---------- ENGLISH ----------
  { pair: 'home', lang: 'en', slug: 'home', title: 'Home',
    meta: 'Hospital Nova in Tijuana: 24/7 ER, specialists in internal medicine, neurology, surgical oncology and maternity. On-site lab, X-ray and blood bank.',
    content: '' },
  { pair: 'specialties', lang: 'en', slug: 'specialties', title: 'Medical Specialties in Tijuana',
    excerpt: 'Internal medicine, neurology, surgical oncology, maternity, emergency and inpatient care in one hospital.',
    meta: 'Medical specialties in Tijuana: internal medicine, neurology, surgical oncology, OB-GYN and 24/7 ER. Book your evaluation at Hospital Nova.',
    content: [sc('[nova_specialties]'), sc('[nova_partners]'), sc('[nova_contact]')].join('\n\n') },
  { pair: 'services', lang: 'en', slug: 'services', title: '24/7 Services: ER, Surgery & Inpatient Care',
    excerpt: 'Always open. Consultations, operating rooms, inpatient care and 24/7 diagnostics in Tijuana.',
    meta: '24-hour hospital in Tijuana: ER, operating rooms, inpatient care, lab, X-ray and blood bank. Always open at Hospital Nova.',
    content: [sc('[nova_stats]'), sc('[nova_partners]'), sc('[nova_maternity]'), sc('[nova_faq]')].join('\n\n') },
  { pair: 'doctors', lang: 'en', slug: 'doctors', title: 'Specialist Doctors',
    excerpt: 'Meet the specialists who practice at Hospital Nova and book directly on WhatsApp.',
    meta: 'Specialist doctors in Tijuana: internist, neurologist and surgical oncologists. Book your appointment at Hospital Nova.',
    content: [sc('[nova_doctors]'), sc('[nova_contact]')].join('\n\n') },
  { pair: 'contact', lang: 'en', slug: 'contact', title: 'Contact & Appointments',
    excerpt: 'Book by phone, WhatsApp or the form. 24/7 care.',
    meta: 'Contact Hospital Nova in Tijuana: book by phone, WhatsApp or online form. ER open 24 hours.',
    content: [sc('[nova_contact]'), sc('[nova_faq]')].join('\n\n') },
  { pair: 'blog', lang: 'en', slug: 'blog-en', title: 'Health Blog',
    meta: 'Hospital Nova Tijuana health blog: internal medicine, neurology, maternity, prevention and emergency care.', content: '' },
  { pair: 'privacy', lang: 'en', slug: 'privacy-notice', title: 'Privacy Notice',
    meta: 'Hospital Nova privacy notice.',
    content: [
      p('<strong>Template — review with the hospital’s legal team before publishing.</strong>'),
      p('Hospital Nova, located in Tijuana, Baja California, is responsible for the personal data you provide through this website, in accordance with Mexico’s Federal Law on Protection of Personal Data Held by Private Parties.'),
      p('Data collected via the form (name, phone, email and reason for visit) is used solely to contact you, schedule your appointment and follow up on your request.'),
      p('To exercise your ARCO rights, write to <a href="mailto:info@hospitalnova.com">info@hospitalnova.com</a>.')
    ].join('\n\n') },
];
