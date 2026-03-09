#!/bin/bash
# Añade funciones del módulo de seguridad (logout + login_fail) a fix.php para evitar 500 en /sce/app_Login/
# Ejecutar: sudo bash scripts/aplicar_fix_app_login_500.sh

FIX="/opt/lampp/htdocs/sce/_lib/lib/php/fix.php"
MARKER="sc_looged_check_logout"

if [ ! -f "$FIX" ]; then
  echo "No existe $FIX"
  exit 1
fi

if grep -q "$MARKER" "$FIX" 2>/dev/null; then
  echo "Las funciones ya están en fix.php. Nada que hacer."
  exit 0
fi

# Insertar después de "<?php" y la línea en blanco, antes de "function nm_fix"
INSERT='    if (!function_exists('\''sc_looged_check_logout'\'')) {
        function sc_looged_check_logout() { return true; }
    }
    if (!function_exists('\''sc_logged_check_logout'\'')) {
        function sc_logged_check_logout() { return true; }
    }
    if (!function_exists('\''sc_logged_out'\'')) {
        function sc_logged_out($usr_login, $date_login) {
            if (function_exists('\''sc_user_logout'\'')) { sc_user_logout(); }
        }
    }
    if (!function_exists('\''sc_logged_in_fail'\'')) {
        function sc_logged_in_fail($login) { }
    }

'

# Crear archivo temporal con el contenido nuevo
tmp=$(mktemp)
{
  head -n 2 "$FIX"   # <?php y línea vacía
  echo "$INSERT"
  tail -n +3 "$FIX"  # resto del archivo
} > "$tmp"
mv "$tmp" "$FIX"
chmod 644 "$FIX"
echo "Listo. Funciones de logout y login_fail añadidas a $FIX"
grep -n "sc_looged_check_logout\|sc_logged_out\|sc_logged_in_fail" "$FIX" | head -6
