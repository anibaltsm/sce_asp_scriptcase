#!/usr/bin/env bash
#
# Sirve la raíz del repo para ver el visor de documentación ATDT 2026 (Contratación TICS).
# Puerto por defecto 8766 (distinto del visor de seguridad en 8765).
#
# Uso (desde la raíz del repo):
#   ./scripts/local/levantar_visor_documentacion_2026.sh
#
# Variables opcionales:
#   PORT=8777
#   NO_BROWSER=1
#   LIBERAR_PUERTO=1
#   SIN_CACHE=1   (por defecto activado)
#
set -euo pipefail

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
REPO_ROOT="$(cd "${SCRIPT_DIR}/../.." && pwd)"
PORT="${PORT:-8766}"
VIEWER_PATH="CONTRATACION TICS/documentacion_2026/viewer.html"
# Espacios en la ruta → %20 para URL
VIEWER_URL_PATH="${VIEWER_PATH// /%20}"
URL="http://127.0.0.1:${PORT}/${VIEWER_URL_PATH}"
SIN_CACHE="${SIN_CACHE:-1}"

port_en_uso() {
  if command -v ss >/dev/null 2>&1; then
    ss -ltn 2>/dev/null | grep -qE ":${PORT}[[:space:]]"
    return $?
  fi
  if command -v lsof >/dev/null 2>&1; then
    lsof -iTCP:"${PORT}" -sTCP:LISTEN >/dev/null 2>&1
    return $?
  fi
  return 1
}

cd "${REPO_ROOT}"

if port_en_uso; then
  if [[ "${LIBERAR_PUERTO:-0}" == "1" ]] && command -v fuser >/dev/null 2>&1; then
    echo "[info] Liberando puerto ${PORT}..."
    fuser -k "${PORT}/tcp" 2>/dev/null || true
    sleep 1
  fi
fi

if port_en_uso; then
  echo "ERROR: El puerto ${PORT} ya está en uso."
  echo "  Ejemplo: PORT=8777 ./scripts/local/levantar_visor_documentacion_2026.sh"
  exit 1
fi

echo "Raíz del sitio: ${REPO_ROOT}"
echo "URL del visor:  ${URL}?v=$(date +%s)"
echo "Borrador directo: ${URL}?v=$(date +%s)#BORRADOR_TODO_2026.md"
echo "Puerto:         ${PORT}"
echo "Detener:        Ctrl+C"
echo ""

if [[ "${NO_BROWSER:-0}" != "1" ]]; then
  if command -v xdg-open >/dev/null 2>&1; then
    ( sleep 1 && xdg-open "${URL}?v=$(date +%s)#BORRADOR_TODO_2026.md" ) >/dev/null 2>&1 &
  elif command -v open >/dev/null 2>&1; then
    ( sleep 1 && open "${URL}?v=$(date +%s)#BORRADOR_TODO_2026.md" ) >/dev/null 2>&1 &
  fi
fi

if [[ "${SIN_CACHE}" == "1" ]]; then
  export PORT
  exec python3 -c '
import http.server
import socketserver
import os

PORT = int(os.environ.get("PORT", "8766"))

class NoCacheHandler(http.server.SimpleHTTPRequestHandler):
    def end_headers(self):
        self.send_header("Cache-Control", "no-store, no-cache, must-revalidate, max-age=0")
        self.send_header("Pragma", "no-cache")
        self.send_header("Expires", "0")
        super().end_headers()

with socketserver.TCPServer(("", PORT), NoCacheHandler) as httpd:
    print(f"Sirviendo con no-cache en puerto {PORT}")
    httpd.serve_forever()
'
else
  exec python3 -m http.server "${PORT}"
fi
