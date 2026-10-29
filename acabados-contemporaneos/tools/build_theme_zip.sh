#!/usr/bin/env bash
# Empaqueta el tema para subirlo en Apariencia → Temas → Añadir nuevo → Subir tema.
set -euo pipefail
cd "$(dirname "$0")/../theme"
out="../wordpress-import/acabados-contemporaneos-theme.zip"
rm -f "$out"
zip -qr "$out" acabados-contemporaneos -x "*/assets/img/*" "*.DS_Store"
echo "Tema empaquetado en wordpress-import/$(basename "$out")"
