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

## Solución definitiva (que no se desconfigure tras cada deploy)

Cada vez que se **vuelve a publicar** el proyecto (Deploy / Publish Wizard), Scriptcase **sobrescribe** `_lib/lib/php/fix.php` y se pierden las funciones, por eso la página vuelve a dar 500.

Para que **no vuelva a pasar**:

1. **Tras cada publicación** (o la primera vez que falle), ejecuta en el servidor:
   ```bash
   sudo bash /opt/sce_asp_scriptcase/scripts/post_deploy_sce.sh
   ```
   Este script:
   - Vuelve a inyectar en `fix.php` las funciones de logout/login (y `schemas.ini` de temas).
   - **Bloquea** `fix.php` con `chattr +i` para que el **próximo deploy no pueda sobrescribirlo**. Así no tendrás que ejecutar el script después de cada publicación.

2. **Si en el futuro** necesitas que Scriptcase vuelva a poder modificar `fix.php` (por ejemplo, actualización de Scriptcase):
   ```bash
   sudo chattr -i /opt/lampp/htdocs/sce/_lib/lib/php/fix.php
   ```
   Luego publica y vuelve a ejecutar `post_deploy_sce.sh`.

3. **Sin bloqueo:** si prefieres no usar `chattr +i`, ejecuta después de **cada** deploy:
   ```bash
   sudo bash /opt/sce_asp_scriptcase/scripts/post_deploy_sce.sh --no-lock
   ```

Resumen: **una sola ejecución de `post_deploy_sce.sh` (sin `--no-lock`) deja fix.php parcheado e inmutable, y los siguientes deploys ya no lo desconfiguran.**

## Referencias

- **Script único post-deploy:** `scripts/post_deploy_sce.sh` (parche + temas + bloqueo de fix.php).
- Logs: `/opt/lampp/logs/php_error_log`
- Solución similar para menú aspirante: `docs/SOLUCION_LOGOUT_MENU_ASPIRANTE.md`
- Scriptcase: macro `sc_user_logout()` para cierre de sesión
