#!/usr/bin/env bash
#
# Sirve el repositorio con Python para abrir el visor del paquete ATDT/IDOR en el navegador.
# No requiere sudo. Desde la raíz del repo:
#   bash scripts/local/levantar_visor_paquete_seguridad.sh
#
# Variables opcionales:
#   PORT=8766  — otro puerto si 8765 está ocupado
#   NO_BROWSER=1  — no abrir el navegador automáticamente
#   LIBERAR_PUERTO=1  — intenta liberar el puerto con fuser antes de arrancar (Linux)
#   SIN_CACHE=1  — fuerza cabeceras HTTP no-cache (por defecto activado)
#
set -euo pipefail

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
REPO_ROOT="$(cd "${SCRIPT_DIR}/../.." && pwd)"
PORT="${PORT:-8765}"
VIEWER_PATH="seguridad/PAQUETE_ENVIO_ATDT_IDOR/viewer.html"
URL="http://127.0.0.1:${PORT}/${VIEWER_PATH}"
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
  echo "  Opciones:"
  echo "    PORT=8766 bash scripts/local/levantar_visor_paquete_seguridad.sh"
  echo "    LIBERAR_PUERTO=1 bash scripts/local/levantar_visor_paquete_seguridad.sh"
  exit 1
fi

echo "Raíz del sitio: ${REPO_ROOT}"
echo "URL del visor:  ${URL}?v=$(date +%s)"
echo "Puerto:         ${PORT}"
echo "Detener:        Ctrl+C"
echo ""

if [[ "${NO_BROWSER:-0}" != "1" ]]; then
  if command -v xdg-open >/dev/null 2>&1; then
    ( sleep 1 && xdg-open "${URL}?v=$(date +%s)" ) >/dev/null 2>&1 &
  elif command -v open >/dev/null 2>&1; then
    ( sleep 1 && open "${URL}?v=$(date +%s)" ) >/dev/null 2>&1 &
  fi
fi

if [[ "${SIN_CACHE}" == "1" ]]; then
  export PORT
  exec python3 -c '
import http.server
import socketserver
import os

PORT = int(os.environ.get("PORT", "8765"))

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
