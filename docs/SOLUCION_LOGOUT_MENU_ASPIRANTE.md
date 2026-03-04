# Solución: Error al cerrar sesión (logout) en menu_aspirante

## Error

Al hacer clic en **Salir** en el menú del aspirante aparece:

```text
Fatal error: Uncaught Error: Call to undefined function sc_logged_out() in
.../menu_aspirante/menu_aspirante_form_php.php:333
```

Y la URL a la que se redirige es:

```text
https://posgrados.inecol.mx/sce_asp/menu_aspirante/menu_aspirante_form_php.php?sc_item_menu=item_9&sc_apl_menu=app_Login&sc_apl_link=...
```

## Causa

- **`sc_logged_out()` no es un macro estándar de ScriptCase.** En la documentación oficial de ScriptCase v9 solo existe el macro **`sc_user_logout()`** para cerrar sesión.
- En el foro de ScriptCase se menciona `sc_logged_out()` como algo que “si lo implementaste desde security” (opcional). En este proyecto no está definida, por eso falla.
- El ítem de menú “Salir” (item_9) está configurado para abrir o redirigir pasando por `menu_aspirante`, y ahí se ejecuta código que llama a `sc_logged_out()`.

## Dónde corregir

1. Abre el proyecto en **ScriptCase** (por ejemplo `Aspirantes2_dev`).
2. Abre la aplicación **menu_aspirante** (menú del aspirante).
3. El evento donde está el código es **onExecute** (no onApplicationInit).
4. Ese código está generando la línea 333 de `menu_aspirante_form_php.php` tras publicar.

## Qué cambiar

### Opción recomendada: usar macro oficial y redirección

**Quitar** la llamada a `sc_logged_out()` y sustituirla por el macro oficial de ScriptCase y la redirección al login.

**Código a eliminar:**

```php
sc_logged_out([usr_login]);
```

**Código a poner en su lugar (una de las dos variantes):**

**Variante A – Macro oficial de ScriptCase**

```php
// Cerrar sesión con el macro oficial y redirigir al login
sc_user_logout([usr_login], '', 'App_login', '_parent');
```

Si en tu proyecto la aplicación de login se llama exactamente `app_Login` (con ‘L’ mayúscula en Login), usa:

```php
sc_user_logout([usr_login], '', 'app_Login', '_parent');
```

**Variante B – Cerrar sesión PHP y redirigir**

Si `sc_user_logout()` no se comporta como esperas (por ejemplo, no limpia bien la sesión), puedes cerrar sesión en PHP y luego redirigir:

```php
// Cerrar sesión manualmente y redirigir al login
$_SESSION = array();
if (ini_get('session.use_cookies')) {
    setcookie(session_name(), '', time() - 42000, '/');
}
session_destroy();
sc_redir('App_login', '', '_parent');
```

Ajusta `'App_login'` por `'app_Login'` si ese es el nombre exacto de tu aplicación de login en ScriptCase.

---

## Código completo para onExecute (reemplazo listo para pegar)

Si en **onExecute** tienes exactamente esto (con typo `apps_Login` y `sc_logged_out`):

```php
if({sc_script_name} == 'apps_Login'){
    if(isset($_COOKIE['usr_data'])){
        unset($_COOKIE['usr_data']);
    }
}
if({sc_script_name} == 'app_Login'):
    sc_logged_out([logged_user], [logged_date_login]);
endif;

// Asegurar que la sesión esté iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// SIMPLEMENTE mantener id_asp de la sesión (app_Login ya lo estableció)
if (isset($_SESSION['id_asp']) && !empty($_SESSION['id_asp'])) {
    [glo_id_asp] = $_SESSION['id_asp'];
    error_log("✅ MENU_ASPIRANTE: id_asp encontrado = " . $_SESSION['id_asp']);
} else {
    error_log("❌ MENU_ASPIRANTE: id_asp NO encontrado en sesión");
}
```

**Sustitúyelo por este bloque (corregido):**

```php
// Typo corregido: app_Login (una 's')
if({sc_script_name} == 'app_Login'){
    if(isset($_COOKIE['usr_data'])){
        setcookie('usr_data', '', time() - 3600, '/');
        unset($_COOKIE['usr_data']);
    }
}

// Salir: cerrar sesión y redirigir a la pantalla de login (aspirantes)
if({sc_script_name} == 'app_Login'){
    $_SESSION = array();
    if (ini_get('session.use_cookies')) {
        setcookie(session_name(), '', time() - 42000, '/');
    }
    session_destroy();
    // Redirigir a /sce_asp/aspirantes/ (pantalla login). Misma base que posgrado.inecol.edu.mx/sce_asp/aspirantes/
    sc_redir('/sce_asp/aspirantes/', '', '_parent');
    exit;
}

// Asegurar que la sesión esté iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// SIMPLEMENTE mantener id_asp de la sesión (app_Login ya lo estableció)
if (isset($_SESSION['id_asp']) && !empty($_SESSION['id_asp'])) {
    [glo_id_asp] = $_SESSION['id_asp'];
    error_log("✅ MENU_ASPIRANTE: id_asp encontrado = " . $_SESSION['id_asp']);
} else {
    error_log("❌ MENU_ASPIRANTE: id_asp NO encontrado en sesión");
}
```

**Resumen de cambios:** (1) `apps_Login` → `app_Login`. (2) Eliminado `sc_logged_out(...)`. (3) Cuando es ítem Salir (`app_Login`), se limpia sesión, se destruye y se redirige a la pantalla de login con `sc_redir('/sce_asp/aspirantes/', '', '_parent')` (equivale a `http://posgrado.inecol.edu.mx/sce_asp/aspirantes/` o `https://posgrados.inecol.mx/sce_asp/aspirantes/` según el dominio). (4) Cookie `usr_data` se borra también en el cliente con `setcookie(..., time()-3600, '/')`.

## Después del cambio

1. Guarda el evento en ScriptCase.
2. Vuelve a **publicar** la aplicación `menu_aspirante` (o publicar el proyecto completo) para que se regenere `menu_aspirante_form_php.php`.
3. Prueba de nuevo **Salir** desde el menú del aspirante: debería ir al login sin mostrar el error de `sc_logged_out()`.

## Referencia

- Documentación ScriptCase v9 – Macros: [sc_user_logout](https://scriptcase.net/docs/en_us/v9/manual/14-macros/02-macros/) (Security): *“Macro used to log the user out to the system.”*
- En el mismo listado de macros **no** existe `sc_logged_out`; es una función opcional/custom que en este proyecto no está definida.
