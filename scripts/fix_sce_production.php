<?php

    /**
     * Funciones requeridas por app_Login (Scriptcase) cuando usa opción de logout.
     * Si faltan, aparece: Call to undefined function sc_looged_check_logout() → 500.
     * Tras cada deploy hay que volver a añadir este bloque si fix.php se sobrescribe.
     */
    if (!function_exists('sc_looged_check_logout')) {
        function sc_looged_check_logout() { /* no-op; compatibilidad con typo en código generado */ }
    }
    if (!function_exists('sc_logged_check_logout')) {
        function sc_logged_check_logout() { /* no-op */ }
    }
    if (!function_exists('sc_logged_out')) {
        function sc_logged_out($usr_login = '', $date_login = '') {
            if (function_exists('sc_user_logout')) {
                @sc_user_logout($usr_login, '', 'app_Login', '_parent');
            }
        }
    }
    if (!function_exists('sc_logged_in_fail')) {
        function sc_logged_in_fail($login) { }
    }

    function nm_fix_SubDirUpload($orig_file, $path, $sub_dir)
    {
        try {
            $sub_dir_wrong = ($sub_dir[0] == '/' ? substr($sub_dir, 1) : $sub_dir);
            $path_wrong = ($path[strlen($path)] == '/' ? substr($path, 0, -1) : $path);
            if (file_exists($path_wrong . $sub_dir_wrong .'/'. $orig_file)) {
                @mkdir($path .'/'. $sub_dir, 0755, true);
                @rename($path_wrong . $sub_dir_wrong .'/'. $orig_file, $path .'/'. $sub_dir .'/'. $orig_file);
            }
        } catch (Exception $e) {

        }

    }


?>
