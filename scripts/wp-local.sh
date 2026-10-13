#!/usr/bin/env bash
# Levanta un WordPress local (PHP + SQLite, sin MySQL) con el tema cardio-canseco activo.
# Uso: scripts/wp-local.sh [directorio-destino] [puerto]
set -euo pipefail

REPO="$(cd "$(dirname "$0")/.." && pwd)"
DEST="${1:-$REPO/.wp-local}"
PORT="${2:-8080}"
URL="http://localhost:$PORT"

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

ln -sfn "$REPO/cardio-canseco" wordpress/wp-content/themes/cardio-canseco

if ! $WP core is-installed 2>/dev/null; then
  $WP config create --dbname=wp --dbuser=x --dbpass=x --skip-check --force
  $WP core install --url="$URL" --title="Cardiología Tijuana" \
    --admin_user=admin --admin_password=admin123 --admin_email=admin@example.com --skip-email
  $WP rewrite structure '/%postname%/'
  $WP post delete 2 --force >/dev/null 2>&1 || true
fi
$WP theme activate cardio-canseco

echo "WordPress en $URL  (admin: $URL/wp-admin  usuario: admin / admin123)"
echo "Entra una vez al admin para que el tema siembre páginas, procedimientos y portada."
exec php -S "0.0.0.0:$PORT" -t wordpress
