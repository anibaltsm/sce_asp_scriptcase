# Solución: Página /sce/app_Login/ no abre (500 – funciones de logout no definidas)

## Síntoma

- **URL:** `https://posgrados.inecol.mx/sce/app_Login/`
- La página no carga o devuelve **500 Internal Server Error**.

## Causa (encontrada en logs)

En **`/opt/lampp/logs/php_error_log`** aparece:

```text
PHP Fatal error: Uncaught Error: Call to undefined function sc_logged_check_logout()
in /opt/lampp/htdocs/sce/app_Login/app_Login_apl.php:1030
```

En el código generado de `app_Login_apl.php` se llama a:

- **`sc_looged_check_logout()`** (línea 1030; typo con tres “o”)
- **`sc_logged_out($usr_login, $date_login)`** (línea 1032)
- **`sc_logged_in_fail($login)`** (línea 1932) – cuando el login falla (usuario no encontrado o validación); si no está definida, el POST al login devuelve 500.

Estas funciones **no existen** en las librerías estándar de Scriptcase en producción (`_lib`). Son propias de la aplicación de seguridad/login; si no están definidas, PHP lanza fatal y la página devuelve 500.

## Solución aplicada

Se definieron las funciones en **`/opt/lampp/htdocs/sce/_lib/lib/php/fix.php`** (archivo que ya se incluye al cargar app_Login):

1. **`sc_looged_check_logout()`** – compatibilidad con el typo del código generado.
2. **`sc_logged_check_logout()`** – por si en alguna publicación se genera con el nombre correcto.
3. **`sc_logged_out($usr_login, $date_login)`** – cierre de sesión; internamente usa `sc_user_logout()` si existe.
4. **`sc_logged_in_fail($login)`** – llamada cuando el login falla (línea 1932); evita 500 en el POST al enviar credenciales.

Así, al cargar `/sce/app_Login/`, `fix.php` se incluye antes y las llamadas dejan de ser “undefined function” y la página puede abrir.

## Cómo comprobar

1. **Logs:**  
   Tras recargar la página, no debería aparecer en `php_error_log` el fatal de `sc_logged_check_logout` ni de `sc_logged_out`.

2. **Navegador:**  
   Abrir `https://posgrados.inecol.mx/sce/app_Login/` y confirmar que carga la pantalla de login (o la redirección esperada) y no 500.

3. **Desde el servidor:**  
   ```bash
   curl -sI -k "https://posgrados.inecol.mx/sce/app_Login/"
   ```  
   La primera línea debería ser `HTTP/2 200` (o `HTTP/1.1 200`), no `500`.

## Mantenimiento al volver a publicar

Cada vez que se **vuelva a publicar** el proyecto a `/opt/lampp/htdocs/sce` (Deploy / Publish Wizard), Scriptcase puede **sobrescribir** `_lib/lib/php/fix.php` y **quitar** estas definiciones.

Opciones:

1. **Después de cada publicación:**  
   Volver a añadir en `fix.php` las tres funciones (o ejecutar un script que las inyecte).

2. **En el proyecto de desarrollo (Scriptcase):**  
   Si existe un `fix.php` o un include común que se publique dentro de `_lib`, definir ahí las mismas funciones para que cada despliegue ya las traiga.

3. **Corregir en Scriptcase (recomendado a largo plazo):**  
   En la aplicación **app_Login**, revisar el evento que genera la llamada a `sc_looged_check_logout()` / `sc_logged_out()` y sustituir por el macro oficial **`sc_user_logout()`** y la redirección adecuada (ver documentación de Scriptcase y, en este repo, `docs/SOLUCION_LOGOUT_MENU_ASPIRANTE.md`). Así no se dependen de funciones que no existen en _lib.

## Referencias

- Logs: `/opt/lampp/logs/php_error_log`
- Solución similar para menú aspirante: `docs/SOLUCION_LOGOUT_MENU_ASPIRANTE.md`
- Scriptcase: macro `sc_user_logout()` para cierre de sesión
