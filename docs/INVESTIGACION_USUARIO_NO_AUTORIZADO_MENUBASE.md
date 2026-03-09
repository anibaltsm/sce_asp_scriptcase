# Investigación: "Usuario no autorizado" en https://posgrados.inecol.mx/sce/MenuBase/

## Resumen

El mensaje **"Usuario no autorizado"** aparece al acceder a `/sce/MenuBase/`. En este repositorio **no existe** ese texto literal; es un mensaje que muestra **ScriptCase** cuando bloquea el acceso a una aplicación por permisos. La investigación solo revisa causas y dónde mirar; no se aplican cambios.

---

## 1. Dónde se genera el mensaje

- **En el código del proyecto (apps_sce_asp, App_login, etc.):** no hay ninguna cadena "Usuario no autorizado" ni "no autorizado".
- **En ScriptCase:** el mensaje es típico del núcleo de ScriptCase al denegar acceso a una app (p. ej. la que se publica como `MenuBase`). Suele mostrarse cuando:
  - El usuario no tiene permiso de **acceso** a esa aplicación, o
  - La aplicación está deshabilitada para su grupo.

Por tanto, la causa está en **permisos del usuario/grupo**, no en un `sc_error_message()` propio del login.

---

## 2. Flujo de autorización (qué revisar)

### 2.1 Tras el login

1. **App_login** valida usuario/contraseña en `sec_asp_users` (evento onValidate).
2. Si es correcto, se ejecuta **onValidateSuccess** → método **`sc_validate_success`** (en `App_login/metodos/sc_validate_success`).

### 2.2 En `sc_validate_success`

- **Permisos:** Se ejecuta una consulta que obtiene los permisos de las aplicaciones según los **grupos del usuario**:

  ```sql
  SELECT app_name, priv_access, priv_insert, ...
  FROM sec_asp_groups_apps
  WHERE group_id IN (
    SELECT group_id FROM sec_asp_users_groups WHERE login = '<usr_login>'
  )
  ```

- Con ese resultado se llama **`sc_apl_status($app, 'on'/'off')`** por cada aplicación. Solo las apps con `priv_access = 'Y'` para algún grupo del usuario quedan en **on**.
- **Redirección:** Según el `group_id` del usuario (tabla `sec_asp_users_groups`) se elige el menú (case 1 → `menu`, case 2 → `menu_aspirante`, etc.) y se hace **`sc_redir($menu)`**.

Si el usuario **no tiene filas en `sec_asp_users_groups`**, la consulta de permisos no devuelve nada y **ninguna aplicación recibe `sc_apl_status(..., 'on')`**. Entonces, al intentar abrir `/sce/MenuBase/`, ScriptCase considera que no tiene permiso y muestra "Usuario no autorizado".

---

## 3. Logs a revisar (solo lectura)

### 3.1 PHP (producción)

Según la documentación del proyecto, en producción:

- **Ruta:** `/opt/lampp/logs/php_error_log`
- **Qué buscar:**
  - Errores PHP o fatals al cargar MenuBase o app_Login.
  - Líneas que ya se escriben desde el código:
    - `LOGIN: Aspirante con registro actual gen=...` (login OK aspirante)
    - `LOGIN: Aspirante con registro anterior gen=...` (reactivación)
    - `LOGIN: No se encontró registro para <login>` (aspirante sin registro)

Para el mensaje "Usuario no autorizado" **no** hay un `error_log()` propio en este repo; el bloqueo lo hace ScriptCase antes de llegar a lógica personalizada. Por eso en `php_error_log` puede no aparecer nada específico de "no autorizado", pero sí errores de BD o de sesión.

### 3.2 Bitácora de ScriptCase (sc_log_add)

En **sc_validate_success** solo se registra login exitoso:

- `sc_log_add('login', {lang_login_ok});`

Los fallos de login se registran en **onValidate** con:

- `sc_log_add('login Fail', {lang_login_fail} . {login});`

La ubicación donde ScriptCase escribe esas entradas de `sc_log_add` depende de la configuración del proyecto (p. ej. tabla o archivo de log). Conviene revisar en la documentación de ScriptCase o en la configuración del proyecto publicado dónde se almacenan.

### 3.3 Resumen de logs

| Dónde | Qué revisar |
|-------|-------------|
| `/opt/lampp/logs/php_error_log` | Errores PHP, fatals, y los mensajes `LOGIN:` del código (aspirantes). |
| Bitácora de ScriptCase (sc_log) | Entradas "login" y "login Fail" para el usuario que ve "Usuario no autorizado". |
| Logs del servidor web (Apache/Nginx) | Accesos a `/sce/MenuBase/` y códigos HTTP (403, 302, etc.). |

---

## 4. Revisión en base de datos (solo diagnóstico)

Para el **login** que recibe "Usuario no autorizado" conviene comprobar:

### 4.1 Que el usuario tenga grupo

```sql
-- Sustituir 'LOGIN_DEL_USUARIO' por el login real
SELECT login, group_id
FROM sec_asp_users_groups
WHERE login = 'LOGIN_DEL_USUARIO';
```

- Si **no hay filas** → ese usuario no tiene grupo; en `sc_validate_success` no se asignan permisos a ninguna app y ScriptCase bloqueará el acceso (p. ej. a MenuBase).
- Si hay filas, anotar el `group_id` (p. ej. 1 = administrador, 2 = aspirante, etc.).

### 4.2 Que el grupo tenga acceso a la aplicación del menú

El nombre de la aplicación en la URL es **MenuBase**; en la BD puede estar como `menu`, `MenuBase` u otro. Comprobar en **sec_asp_groups_apps** para el `group_id` del usuario:

```sql
-- Sustituir 1 por el group_id del usuario
SELECT app_name, priv_access, priv_insert, priv_update
FROM sec_asp_groups_apps
WHERE group_id = 1
  AND (app_name LIKE '%menu%' OR app_name = 'MenuBase')
ORDER BY app_name;
```

- Si **no hay fila** para la app que corresponde a MenuBase, o **`priv_access` no es 'Y'** → ScriptCase mostrará "Usuario no autorizado" al entrar a esa app.

### 4.3 Listar aplicaciones con acceso para ese grupo

```sql
SELECT app_name, priv_access
FROM sec_asp_groups_apps
WHERE group_id = 1  -- usar el group_id del usuario
ORDER BY app_name;
```

Así se ve si la aplicación del menú (el nombre que use el proyecto) tiene `priv_access = 'Y'` para ese grupo.

---

## 5. Causas probables (resumen)

1. **Usuario sin grupo:** no hay fila en `sec_asp_users_groups` para ese login → no se asignan permisos → "Usuario no autorizado" al abrir cualquier app protegida (incluida MenuBase).
2. **Grupo sin permiso a MenuBase:** el grupo del usuario no tiene en `sec_asp_groups_apps` una fila para la app que se publica como MenuBase con `priv_access = 'Y'`.
3. **Nombre de app distinto:** en la BD la app puede llamarse `menu` y en la URL aparecer como `MenuBase`; hay que asegurar que el `app_name` en `sec_asp_groups_apps` coincida con el que usa ScriptCase para esa aplicación.

---

## 6. Archivos relevantes en el repo

- **Permisos y redirección tras login:**  
  `scriptcase/apps_sce_asp/App_login/metodos/sc_validate_success`
- **Validación de usuario/contraseña y mensajes de error de login:**  
  `scriptcase/apps_sce_asp/App_login/Eventos/ onValidate`
- **Explicación de sec_asp_apps y sec_asp_groups_apps:**  
  `data/PERMISOS_APLICACION_SEC_ASP.md`
- **Diagnóstico de permisos por grupo (ejemplo form_asp_requisitos_1):**  
  `data/sql_diagnostico_form_asp_requisitos_1.sql` (puede adaptarse para la app del menú).

---

*Documento solo de investigación; no se aplican cambios en código ni en BD.*
