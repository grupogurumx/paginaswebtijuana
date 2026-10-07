# Bot de WhatsApp (open-wa)

Bot de respuestas automáticas para el WhatsApp de Paginas Web Tijuana,
construido con [`@open-wa/wa-automate`](https://github.com/open-wa/wa-automate-nodejs).

## Requisitos

- Node.js 18 o superior
- Google Chrome o Chromium instalado en el servidor
- `zstd` instalado en el sistema (open-wa lo necesita para cargar):

```bash
sudo apt-get install -y zstd
```

## Instalación

```bash
cd whatsapp-bot
npm install
```

## Uso

```bash
npm start
```

La primera vez aparece un código QR en la terminal. Escanéalo desde el
teléfono del negocio en **WhatsApp > Dispositivos vinculados > Vincular un
dispositivo**. La sesión se guarda localmente y no hace falta volver a escanear.

Si Chrome no está en la ruta por defecto, indica dónde está:

```bash
CHROME_PATH=/usr/bin/chromium npm start
```

## Qué hace

Responde a cada mensaje privado con un menú de servicios; si el cliente
contesta con un número del 1 al 5 recibe la información de ese servicio.
Los textos se editan en `index.js`.

> Nota: open-wa no es una API oficial de WhatsApp. Úsalo con un número de
> negocio y evita envíos masivos para no arriesgar un bloqueo.
