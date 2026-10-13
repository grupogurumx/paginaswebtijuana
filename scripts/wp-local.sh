#!/usr/bin/env bash
# Levanta un WordPress local (PHP + SQLite, sin MySQL) con uno de los temas del repo activo.
# Uso: scripts/wp-local.sh [tema] [puerto] [directorio-destino]
#   tema: webmaster-tijuana (por defecto) o cardio-canseco
set -euo pipefail

REPO="$(cd "$(dirname "$0")/.." && pwd)"
THEME="${1:-webmaster-tijuana}"
PORT="${2:-8080}"
DEST="${3:-$REPO/.wp-local/$THEME}"
[ -f "$REPO/$THEME/style.css" ] || { echo "No existe el tema $THEME"; exit 1; }
URL="http://localhost:$PORT"
case "$THEME" in
  cardio-canseco) TITLE="Cardiología Tijuana" ;;
  *)              TITLE="Webmaster Tijuana" ;;
esac

mkdir -p "$DEST"
cd "$DEST"

[ -f wp-cli.phar ] || curl -sSfL -o wp-cli.phar https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
WP="php $DEST/wp-cli.phar --allow-root --path=$DEST/wordpress"

[ -d wordpress ] || git clone -q --depth 1 --branch 6.8.3 https://github.com/WordPress/WordPress.git wordpress

PLUGIN="$DEST/wordpress/wp-content/plugins/sqlite-database-integration"
[ -d "$PLUGIN" ] || git clone -q --depth 1 --branch v2.2.2 https://github.com/WordPress/sqlite-database-integration.git "$PLUGIN"
sed -e "s#{SQLITE_IMPLEMENTATION_FOLDER_PATH}#$PLUGIN#" \
    -e "s#{SQLITE_PLUGIN}#sqlite-database-integration/load.php#" \
    "$PLUGIN/db.copy" > wordpress/wp-content/db.php

ln -sfn "$REPO/$THEME" "wordpress/wp-content/themes/$THEME"

if ! $WP core is-installed 2>/dev/null; then
  $WP config create --dbname=wp --dbuser=x --dbpass=x --skip-check --force
  $WP core install --url="$URL" --title="$TITLE" \
    --admin_user=admin --admin_password=admin123 --admin_email=admin@example.com --skip-email
  $WP rewrite structure '/%postname%/'
  $WP post delete 2 --force >/dev/null 2>&1 || true
fi
# Fija la URL (también si cambias de puerto entre ejecuciones).
$WP option update home "$URL" >/dev/null
$WP option update siteurl "$URL" >/dev/null
$WP theme activate "$THEME"

echo "WordPress en $URL  (admin: $URL/wp-admin  usuario: admin / admin123)"
echo "Entra una vez al admin para que el tema cree sus páginas, contenido y portada."
exec php -S "0.0.0.0:$PORT" -t wordpress
