#!/bin/bash
set -euo pipefail

# Solo se ejecuta en Claude Code on the web
if [ "${CLAUDE_CODE_REMOTE:-}" != "true" ]; then
  exit 0
fi

cd "$CLAUDE_PROJECT_DIR"

# Instala dependencias (hallmark, linter de markdown)
npm install --no-audit --no-fund
