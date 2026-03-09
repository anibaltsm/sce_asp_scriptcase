<?php
/**
 * Fragmento a insertar al inicio de /opt/lampp/htdocs/sce/_lib/lib/php/fix.php
 * (después de <?php y antes de function nm_fix_SubDirUpload)
 *
 * Causa del 500: app_Login_apl.php línea 1030 llama sc_looged_check_logout() y
 * línea 1032 llama sc_logged_out() — no existen en _lib. Sin definirlas, PHP Fatal.
 *
 * Aplicar con:
 *   sudo bash scripts/aplicar_fix_app_login_500.sh
 */

    if (!function_exists('sc_looged_check_logout')) {
        function sc_looged_check_logout() { return true; }
    }
    if (!function_exists('sc_logged_check_logout')) {
        function sc_logged_check_logout() { return true; }
    }
    if (!function_exists('sc_logged_out')) {
        function sc_logged_out($usr_login, $date_login) {
            if (function_exists('sc_user_logout')) {
                sc_user_logout();
            }
        }
    }
