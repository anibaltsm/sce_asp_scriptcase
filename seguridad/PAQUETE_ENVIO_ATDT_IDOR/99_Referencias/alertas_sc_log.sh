#!/usr/bin/env bash
set -euo pipefail

# Hardening E3 - Alertas automáticas sobre sc_log
# ATDT IDOR 2026 - SCE / SCE_ASP / SCE_ENBC
#
# Uso:
#   ./alertas_sc_log.sh
#
# Variables opcionales:
#   MYSQL_BIN=/opt/lampp/bin/mysql
#   DB_USER=root
#   DB_PASS=***
#   WINDOW_MIN=5
#   TH_LOGIN_FAIL=10
#   TH_ENUM_APPS=20
#   ALERT_LOG=/opt/sce_asp_scriptcase/seguridad/PAQUETE_ENVIO_ATDT_IDOR/04_Anexos/EVIDENCIAS/alertas_sc_log_runtime.log

MYSQL_BIN="${MYSQL_BIN:-/opt/lampp/bin/mysql}"
DB_USER="${DB_USER:-root}"
DB_PASS="${DB_PASS:-515t3ma5}"
WINDOW_MIN="${WINDOW_MIN:-5}"
TH_LOGIN_FAIL="${TH_LOGIN_FAIL:-10}"
TH_ENUM_APPS="${TH_ENUM_APPS:-20}"
ALERT_LOG="${ALERT_LOG:-/opt/sce_asp_scriptcase/seguridad/PAQUETE_ENVIO_ATDT_IDOR/04_Anexos/EVIDENCIAS/alertas_sc_log_runtime.log}"

DBS=("sce" "sce_asp" "sce_enbc")
NOW="$(date '+%Y-%m-%d %H:%M:%S')"
ANY_ALERT=0

run_query() {
    local db="$1"
    local sql="$2"
    "${MYSQL_BIN}" -u "${DB_USER}" -p"${DB_PASS}" "${db}" -N -e "${sql}" 2>/dev/null || true
}

log_line() {
    local line="$1"
    printf '%s\n' "${line}" | tee -a "${ALERT_LOG}"
}

log_line "=== [${NOW}] Ejecucion de alertas sc_log ==="
log_line "Parametros: ventana=${WINDOW_MIN}m, th_login_fail=${TH_LOGIN_FAIL}, th_enum_apps=${TH_ENUM_APPS}"

for db in "${DBS[@]}"; do
    log_line "--- Base: ${db} ---"

    # A) Login fail por IP en ventana de tiempo
    SQL_FAIL_BY_IP="
        SELECT IFNULL(ip_user,'(sin_ip)') AS ip_user, COUNT(*) AS total
        FROM sc_log
        WHERE action='login Fail'
          AND inserted_date >= (NOW() - INTERVAL ${WINDOW_MIN} MINUTE)
        GROUP BY ip_user
        HAVING total >= ${TH_LOGIN_FAIL}
        ORDER BY total DESC;
    "
    RES_FAIL_BY_IP="$(run_query "${db}" "${SQL_FAIL_BY_IP}")"
    if [[ -n "${RES_FAIL_BY_IP}" ]]; then
        ANY_ALERT=1
        log_line "ALERTA login_fail_por_ip (${db}):"
        while IFS= read -r row; do
            [[ -z "${row}" ]] && continue
            ip="$(awk '{print $1}' <<<"${row}")"
            cnt="$(awk '{print $2}' <<<"${row}")"
            log_line "  - ip=${ip} total=${cnt}"
        done <<< "${RES_FAIL_BY_IP}"
    else
        log_line "OK login_fail_por_ip (${db}): sin umbral excedido"
    fi

    # B) Posible enumeracion: mismo usuario accediendo a muchas apps distintas
    SQL_ENUM_APPS="
        SELECT username, COUNT(DISTINCT application) AS apps_distintas, COUNT(*) AS eventos
        FROM sc_log
        WHERE inserted_date >= (NOW() - INTERVAL ${WINDOW_MIN} MINUTE)
          AND action='access'
          AND username IS NOT NULL
          AND username<>''
        GROUP BY username
        HAVING apps_distintas >= ${TH_ENUM_APPS}
        ORDER BY apps_distintas DESC, eventos DESC;
    "
    RES_ENUM_APPS="$(run_query "${db}" "${SQL_ENUM_APPS}")"
    if [[ -n "${RES_ENUM_APPS}" ]]; then
        ANY_ALERT=1
        log_line "ALERTA enumeracion_apps (${db}):"
        while IFS= read -r row; do
            [[ -z "${row}" ]] && continue
            user="$(awk '{print $1}' <<<"${row}")"
            apps="$(awk '{print $2}' <<<"${row}")"
            evs="$(awk '{print $3}' <<<"${row}")"
            log_line "  - user=${user} apps_distintas=${apps} eventos=${evs}"
        done <<< "${RES_ENUM_APPS}"
    else
        log_line "OK enumeracion_apps (${db}): sin umbral excedido"
    fi
done

if [[ "${ANY_ALERT}" -eq 1 ]]; then
    log_line "RESULTADO GLOBAL: ALERTAS DETECTADAS"
    exit 2
fi

log_line "RESULTADO GLOBAL: SIN ALERTAS"
exit 0
