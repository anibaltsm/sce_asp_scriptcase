#!/usr/bin/env bash
set -euo pipefail

# Aplica hardening operativo E1/E3 en servidor (requiere root/sudo)
# - E1: include de rate limiting para endpoints login
# - E3: cron de alertas sobre sc_log
#
# Uso recomendado:
#   sudo bash /opt/sce_asp_scriptcase/seguridad/PAQUETE_ENVIO_ATDT_IDOR/99_Referencias/aplicar_hardening_e1e3.sh

HTTPD_CONF="/opt/lampp/etc/httpd.conf"
RATE_CONF="/opt/sce_asp_scriptcase/seguridad/PAQUETE_ENVIO_ATDT_IDOR/99_Referencias/rate_limit_login_apache.conf"
ALERT_SCRIPT="/opt/sce_asp_scriptcase/seguridad/PAQUETE_ENVIO_ATDT_IDOR/99_Referencias/alertas_sc_log.sh"
CRON_FILE="/etc/cron.d/idor_sc_log_alertas"
EVID_DIR="/opt/sce_asp_scriptcase/seguridad/PAQUETE_ENVIO_ATDT_IDOR/04_Anexos/EVIDENCIAS"
DATE_TAG="$(date +%Y%m%d_%H%M%S)"
BACKUP_HTTPD="/opt/lampp/etc/httpd.conf.bak_idor_${DATE_TAG}"

if [[ ! -f "${RATE_CONF}" ]]; then
  echo "ERROR: no existe ${RATE_CONF}" >&2
  exit 1
fi

if [[ ! -f "${ALERT_SCRIPT}" ]]; then
  echo "ERROR: no existe ${ALERT_SCRIPT}" >&2
  exit 1
fi

echo "[1/7] Preparando respaldos y permisos..."
cp -a "${HTTPD_CONF}" "${BACKUP_HTTPD}"
chmod +x "${ALERT_SCRIPT}"
mkdir -p "${EVID_DIR}"
mkdir -p /opt/lampp/logs/mod_evasive || true

echo "[2/7] Validando include E1 en httpd.conf..."
INCLUDE_LINE="Include \"${RATE_CONF}\""
if ! python3 - <<'PY'
from pathlib import Path
import sys
p = Path("/opt/lampp/etc/httpd.conf")
line = 'Include "/opt/sce_asp_scriptcase/seguridad/PAQUETE_ENVIO_ATDT_IDOR/99_Referencias/rate_limit_login_apache.conf"'
txt = p.read_text(errors='ignore')
sys.exit(0 if line in txt else 1)
PY
then
  echo "${INCLUDE_LINE}" >> "${HTTPD_CONF}"
  echo "  -> include agregado"
else
  echo "  -> include ya existia"
fi

echo "[3/7] Escribiendo cron E3..."
cat > "${CRON_FILE}" <<'EOF'
SHELL=/bin/bash
PATH=/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin
*/5 * * * * root /opt/sce_asp_scriptcase/seguridad/PAQUETE_ENVIO_ATDT_IDOR/99_Referencias/alertas_sc_log.sh >> /opt/sce_asp_scriptcase/seguridad/PAQUETE_ENVIO_ATDT_IDOR/04_Anexos/EVIDENCIAS/alertas_sc_log_cron.log 2>&1
EOF
chmod 644 "${CRON_FILE}"

echo "[4/7] Probando sintaxis Apache..."
/opt/lampp/bin/httpd -t

echo "[5/7] Recargando Apache..."
/opt/lampp/lampp reloadapache

echo "[6/7] Ejecutando prueba de alertas..."
WINDOW_MIN=1440 TH_LOGIN_FAIL=5 TH_ENUM_APPS=50 ALERT_LOG="${EVID_DIR}/alertas_sc_log_runtime.log" "${ALERT_SCRIPT}" || true

echo "[7/7] Evidencia operativa..."
{
  echo "=== hardening_e1e3_aplicado_${DATE_TAG} ==="
  echo "backup_httpd=${BACKUP_HTTPD}"
  echo "rate_conf=${RATE_CONF}"
  echo "cron_file=${CRON_FILE}"
  echo "date=$(date '+%Y-%m-%d %H:%M:%S')"
  echo ""
  echo "--- apache_test ---"
  /opt/lampp/bin/httpd -t 2>&1 || true
  echo ""
  echo "--- include_validacion ---"
  python3 - <<'PY'
from pathlib import Path
p = Path("/opt/lampp/etc/httpd.conf")
needle = 'Include "/opt/sce_asp_scriptcase/seguridad/PAQUETE_ENVIO_ATDT_IDOR/99_Referencias/rate_limit_login_apache.conf"'
print("present=", needle in p.read_text(errors='ignore'))
PY
  echo ""
  echo "--- cron_file ---"
  cat /etc/cron.d/idor_sc_log_alertas
} > "${EVID_DIR}/hardening_e1e3_aplicado_${DATE_TAG}.log"

echo "OK: hardening aplicado."
echo "Evidencias:"
echo " - ${EVID_DIR}/alertas_sc_log_runtime.log"
echo " - ${EVID_DIR}/hardening_e1e3_aplicado_${DATE_TAG}.log"
echo " - ${EVID_DIR}/alertas_sc_log_cron.log (se ira llenando por cron)"
