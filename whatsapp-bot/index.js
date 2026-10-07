// Bot de WhatsApp para Paginas Web Tijuana usando open-wa (@open-wa/wa-automate).
// Al iniciar muestra un código QR en la terminal: escanéalo desde
// WhatsApp > Dispositivos vinculados para conectar el número del negocio.
const { create } = require('@open-wa/wa-automate');

const SITIO = 'https://webmastertijuana.com';
const TELEFONO = '664 409 7979';
const CORREO = 'contacto@webmastertijuana.com';

const MENU = [
  '¡Hola! 👋 Gracias por escribir a *Webmaster Tijuana*.',
  '',
  'Responde con el número de la opción:',
  '1️⃣ Diseño de páginas web',
  '2️⃣ Tiendas virtuales',
  '3️⃣ Marketing y publicidad digital',
  '4️⃣ Manejo de redes sociales',
  '5️⃣ Cotizar ahora / hablar con un asesor',
].join('\n');

const RESPUESTAS = {
  1: `🖥️ *Diseño de páginas web*\nSitios modernos, rápidos y optimizados para móviles y Google.\nMás información: ${SITIO}`,
  2: `🛒 *Tiendas virtuales*\nVende en línea con pagos, inventario y envíos integrados.\nMás información: ${SITIO}`,
  3: `📈 *Marketing y publicidad digital*\nCampañas en Google, Facebook e Instagram enfocadas en resultados.\nMás información: ${SITIO}`,
  4: `📱 *Manejo de redes sociales*\nContenido, publicaciones y atención a tu comunidad.\nMás información: ${SITIO}`,
  5: `🤝 En breve un asesor te atenderá por este medio.\nTambién puedes llamarnos al ${TELEFONO} o escribir a ${CORREO}.`,
};

function respuestaPara(texto) {
  const opcion = (texto || '').trim().charAt(0);
  return RESPUESTAS[opcion] || MENU;
}

function start(client) {
  client.onMessage(async (message) => {
    // Ignorar grupos, estados y mensajes propios.
    if (message.isGroupMsg || message.fromMe || message.from === 'status@broadcast') return;
    try {
      await client.sendText(message.from, respuestaPara(message.body));
    } catch (err) {
      console.error('Error al responder a', message.from, err);
    }
  });
  console.log('✅ Bot de WhatsApp listo y escuchando mensajes.');
}

create({
  sessionId: 'paginaswebtijuana',
  multiDevice: true,
  authTimeout: 60,
  qrTimeout: 0,
  headless: true,
  blockCrashLogs: true,
  disableSpins: true,
  logConsole: false,
  popup: false,
  // Necesario si el servidor ejecuta el bot como root (p. ej. un VPS o Docker).
  chromiumArgs: ['--no-sandbox', '--disable-setuid-sandbox'],
  // Usa el Chrome/Chromium instalado en el servidor si se indica.
  ...(process.env.CHROME_PATH ? { executablePath: process.env.CHROME_PATH } : { useChrome: true }),
})
  .then(start)
  .catch((err) => {
    console.error('No se pudo iniciar open-wa:', err);
    process.exit(1);
  });
