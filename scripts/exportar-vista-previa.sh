#!/usr/bin/env bash
# Genera una copia estática del WordPress local en vista-previa/ para publicarla
# como vista previa (Vercel u otro hosting estático). Requiere el sitio corriendo
# con scripts/wp-local.sh. El formulario abre WhatsApp, porque no hay PHP.
# Uso: scripts/exportar-vista-previa.sh [url-local]
set -euo pipefail

REPO="$(cd "$(dirname "$0")/.." && pwd)"
SRC="${1:-http://localhost:8080}"
OUT="$REPO/vista-previa"
TMP="$(mktemp -d)"
trap 'rm -rf "$TMP"' EXIT

cd "$TMP"
wget -q -m -p -E -nH --no-proxy -e robots=off \
  --reject-regex '(wp-admin|wp-json|xmlrpc|/feed|wp-login|\?s=|/comments/|oembed|\?p=|replytocom)' \
  "$SRC/" || true
wget -q --no-proxy -O 404.html --content-on-error "$SRC/no-existe/" || true

python3 -I "$REPO/scripts/vista-previa-post.py" "$TMP" "$SRC"
find . -name '*.html' -exec sed -i "/rel='dns-prefetch' href='\/\/localhost'/d" {} +

rm -rf "$OUT"
mkdir -p "$OUT"
cp -r . "$OUT/"
cat > "$OUT/vercel.json" <<'JSON'
{ "cleanUrls": false, "trailingSlash": true, "headers": [ { "source": "/(.*)", "headers": [ { "key": "X-Robots-Tag", "value": "noindex" } ] } ] }
JSON
echo "Vista previa generada en $OUT"
