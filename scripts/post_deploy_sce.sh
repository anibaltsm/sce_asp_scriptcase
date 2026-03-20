#!/bin/bash
#
# Post-deploy SCE: reaplica parches que Scriptcase sobrescribe al publicar.
# - Añade funciones de logout/login en fix.php (evita 500 en /sce/app_Login/)
# - Añade entradas de tema SCE en schemas.ini
# - Opcional: hace fix.php inmutable para que el PRÓXIMO deploy no lo sobrescriba (solución definitiva).
#
# Uso:
#   sudo bash scripts/post_deploy_sce.sh           # Parchea y BLOQUEA fix.php (recomendado)
#   sudo bash scripts/post_deploy_sce.sh --no-lock  # Solo parchea; hay que ejecutar tras cada deploy
#   sudo chattr -i /opt/lampp/htdocs/sce/_lib/lib/php/fix.php   # Desbloquear si necesitas actualizar fix.php
#
set -e

FIX="/opt/lampp/htdocs/sce/_lib/lib/php/fix.php"
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
LOCK=true
[ "$1" = "--no-lock" ] && LOCK=false

# --- 1) Parche en fix.php (funciones sc_looged_check_logout, sc_logged_out, sc_logged_in_fail) ---
if [ ! -f "$FIX" ]; then
  echo "No existe $FIX. ¿Ya desplegaste el proyecto SCE?"
  exit 1
fi

# Si está bloqueado (inmutable), desbloquear para poder parchear
if lsattr "$FIX" 2>/dev/null | grep -q '^....i'; then
  chattr -i "$FIX"
  WAS_LOCKED=true
else
  WAS_LOCKED=false
fi

MARKER="sc_looged_check_logout"
if grep -q "$MARKER" "$FIX" 2>/dev/null; then
  echo "[fix.php] Las funciones de login/logout ya están presentes."
else
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
  tmp=$(mktemp)
  { head -n 2 "$FIX"; echo "$INSERT"; tail -n +3 "$FIX"; } > "$tmp"
  mv "$tmp" "$FIX"
  chmod 644 "$FIX"
  echo "[fix.php] Funciones de logout/login añadidas."
fi

# --- 2) Temas en schemas.ini ---
SCHEMAS="/opt/lampp/htdocs/sce/_lib/css/schemas.ini"
EXTRA_LINES="${SCRIPT_DIR}/schemas_ini_lineas_temas_sce.txt"
if [ -f "$SCHEMAS" ]; then
  if grep -q "grp__NM__SCE#" "$SCHEMAS" 2>/dev/null; then
    echo "[schemas.ini] Entradas de tema ya presentes."
  else
    if [ -f "$EXTRA_LINES" ]; then
      cat "$EXTRA_LINES" >> "$SCHEMAS"
    else
      cat >> "$SCHEMAS" << 'EOF'
SCE#nm#SCE#nm#grp__NM__ico__NM__scriptcase__NM__img__NM__projetos__NM__Posgrado.png
grp__NM__SCE#nm#SCE#nm#grp__NM__ico__NM__scriptcase__NM__img__NM__projetos__NM__Posgrado.png
scriptcase__NM__Green#nm#Sc7_Green#nm#
EOF
    fi
    echo "[schemas.ini] Entradas de tema SCE añadidas."
  fi
else
  echo "[schemas.ini] No existe $SCHEMAS, omitido."
fi

# --- 3) Hacer fix.php inmutable para que el próximo deploy no lo sobrescriba ---
if [ "$LOCK" = true ]; then
  if lsattr "$FIX" 2>/dev/null | grep -q '^....i'; then
    echo "[fix.php] Ya está bloqueado (inmutable). El deploy no lo sobrescribirá."
  else
    chattr +i "$FIX"
    echo "[fix.php] Bloqueado con chattr +i. El próximo deploy NO sobrescribirá fix.php."
    echo "          Para desbloquear: sudo chattr -i $FIX"
  fi
else
  if [ "$WAS_LOCKED" = true ]; then
    echo "[fix.php] Se había desbloqueado para parchear; no se vuelve a bloquear (--no-lock)."
  fi
  echo "[fix.php] Sin bloqueo. Ejecuta este script tras cada deploy o quita --no-lock para bloquear."
fi

echo ""
echo "Listo. Comprueba: https://posgrados.inecol.mx/sce/app_Login/"
