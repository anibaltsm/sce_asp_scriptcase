#!/usr/bin/env bash
# Recolección de metadatos para inventario ATDT (sin contraseñas ni secretos).
# Ejecutar en el servidor LAMPP (p. ej. srvpg). Opcional: export INECOL_MYSQL_PASS
# para que las consultas SQL al final se ejecuten (no imprime contraseñas).

set -euo pipefail

echo "=== inventario ATDT — recolección $(date -Iseconds) — $(hostname) ==="
echo
echo "--- SO ---"
uname -a || true
[ -f /etc/os-release ] && head -6 /etc/os-release || true

echo
echo "--- LAMPP: PHP / Apache / cliente mysql ---"
[ -x /opt/lampp/bin/php ] && /opt/lampp/bin/php -v | head -3 || echo "php: no"
[ -x /opt/lampp/bin/httpd ] && /opt/lampp/bin/httpd -v | head -2 || echo "httpd: no"
[ -x /opt/lampp/bin/mysql ] && /opt/lampp/bin/mysql --version || echo "mysql: no"
openssl version 2>/dev/null || true

echo
echo "--- Puertos 80/443 ---"
ss -ltnp 2>/dev/null | grep -E ':80 |:443 ' || true

echo
echo "--- Certificado TLS (SNI posgrados.inecol.mx) ---"
echo | openssl s_client -connect 127.0.0.1:443 -servername posgrados.inecol.mx 2>/dev/null \
  | openssl x509 -noout -subject -issuer -dates 2>/dev/null || echo "(fallo openssl s_client)"

echo
echo "--- IP pública saliente (opcional) ---"
curl -4 -s --max-time 5 ifconfig.me 2>/dev/null || echo "(no disponible)"

echo
echo "--- ScriptCase sc_version (ejemplos) ---"
for d in sce sce_asp sce_enbc; do
  f="/opt/lampp/htdocs/$d/_lib/_app_data/app_Login_ini.php"
  [ -f "$f" ] || f="/opt/lampp/htdocs/$d/_lib/_app_data/App_login_ini.php"
  if [ -f "$f" ]; then
    echo -n "$d: "
    grep -m1 "sc_version" "$f" || true
  fi
done

echo
echo "--- WAF / mod_security (httpd LAMPP) ---"
grep -r "evasive\|mod_security" /opt/lampp/etc/*.conf /opt/lampp/etc/extra/*.conf 2>/dev/null || echo "(sin coincidencias)"

echo
echo "--- Cron alertas sc_log (si existe) ---"
[ -f /etc/cron.d/idor_sc_log_alertas ] && cat /etc/cron.d/idor_sc_log_alertas || echo "(archivo no encontrado)"

echo
echo "--- MySQL (solo si INECOL_MYSQL_PASS está definida; usa MYSQL_PWD, no -p en línea de comandos) ---"
if [ -n "${INECOL_MYSQL_PASS:-}" ]; then
  export MYSQL_PWD="$INECOL_MYSQL_PASS"
  /opt/lampp/bin/mysql -u root -N -e "SELECT VERSION();" 2>/dev/null || echo "(error conexión)"
  /opt/lampp/bin/mysql -u root -N -e "SELECT COUNT(*) FROM sce.sec_users WHERE active='Y';" 2>/dev/null || true
  /opt/lampp/bin/mysql -u root -N -e "SELECT COUNT(*) FROM sce_asp.sec_asp_users WHERE active='Y';" 2>/dev/null || true
  /opt/lampp/bin/mysql -u root -N -e "SELECT COUNT(*) FROM sce_enbc.sec_enbc_users WHERE active='Y';" 2>/dev/null || true
  unset MYSQL_PWD
else
  echo "Omitido: defina INECOL_MYSQL_PASS en el entorno para conteos de usuarios."
fi

echo
echo "=== fin ==="
