# Error "Error al insertar - Violación de la Clave Única local" en app_form_add_users

**URL:** https://posgrados.inecol.mx/sce_asp/app_form_add_users/  
**Fecha doc:** Feb 2026

---

## 1. Dónde sale el error

Ese mensaje lo muestra **ScriptCase** cuando MySQL devuelve un error de **clave duplicada** (típicamente código **1062** – Duplicate entry) al ejecutar el `INSERT` del formulario. No está definido en el código del proyecto; es un mensaje del motor de ScriptCase al capturar el error de la base de datos.

---

## 2. Tabla involucrada y causa más probable

La aplicación **app_form_add_users** tiene como tabla principal **`sec_asp_users`**.

- **Clave primaria:** `login` (varchar 255).
- No hay otro índice UNIQUE en esa tabla en la BD revisada.

Por tanto, la causa más frecuente del error es:

- **Intentar registrar un usuario con un `login` que ya existe en `sec_asp_users`**  
  (por ejemplo, el mismo correo usado como usuario en un registro anterior).

El flujo es:

1. El usuario rellena el formulario (nombre, apellidos, email, etc.).
2. ScriptCase ejecuta el `INSERT` en `sec_asp_users` (con `login` = email u otro identificador).
3. Si ese `login` ya existe → MySQL devuelve **Duplicate entry for key 'PRIMARY'** → ScriptCase muestra **"Error al insertar - Violación de la Clave Única local"**.
4. Los eventos **onAfterInsert** (add_user_to_group, add_asp_aspirantes, etc.) **solo se ejecutan si el INSERT fue correcto**; si el error aparece al “insertar”, el fallo es en ese primer INSERT.

---

## 3. Cómo comprobarlo en la base de datos

Conectar a la BD y comprobar si el login (por ejemplo el email que intentan registrar) ya existe:

```bash
/opt/lampp/bin/mysql -u root -p515t3ma5 sce_asp -e "
  -- Sustituir 'EMAIL_O_LOGIN' por el valor que intentó registrar el usuario
  SELECT login, email, name, apat, amat, fecha_alta
  FROM sec_asp_users
  WHERE login = 'EMAIL_O_LOGIN' OR email = 'EMAIL_O_LOGIN';
"
```

Listar últimos usuarios registrados (por si quieres ver duplicados o intentos recientes):

```bash
/opt/lampp/bin/mysql -u root -p515t3ma5 sce_asp -e "
  SELECT login, email, fecha_alta
  FROM sec_asp_users
  ORDER BY fecha_alta DESC
  LIMIT 20;
"
```

---

## 4. Otras tablas con restricciones únicas en el flujo

Si en algún momento el error ocurriera **después** del alta en `sec_asp_users` (por ejemplo por reintentos o por ejecución manual de scripts), estas tablas también tienen restricciones que pueden generar “clave duplicada”:

| Tabla                    | Restricción                          | Cuándo podría fallar                          |
|--------------------------|--------------------------------------|-----------------------------------------------|
| **sec_asp_users**        | PRIMARY KEY (`login`)                | Mismo login/email ya registrado (caso habitual). |
| **sec_asp_users_groups** | PRIMARY KEY (`login`,`group_id`)     | Mismo usuario ya asignado al mismo grupo.     |
| **recomendantes**        | UNIQUE `uk_correo_recom` (`correo`)  | Mismo correo en otro recomendante.           |
| **asp_recomendantes**    | UNIQUE `uk_asp_recom` (id_asp_FK, id_recom_FK) | Misma pareja aspirante–recomendante.  |

En el flujo normal de “registro nuevo” desde el formulario, el único INSERT que hace el usuario es en **sec_asp_users**; el resto lo hace **onAfterInsert**. Por eso, en la práctica, el mensaje “Violación de la Clave Única local” en esta app suele corresponder a **login duplicado en `sec_asp_users`**.

---

## 5. Logs

- El mensaje concreto **"Error al insertar - Violación de la Clave Única local"** no está en el repositorio del proyecto; viene del motor ScriptCase.
- En el código del proyecto, **add_asp_aspirantes** escribe en PHP `error_log` solo cuando el flujo llega a crear aspirante/pago (es decir, cuando el INSERT en `sec_asp_users` ya fue exitoso). Si el error ocurre en el INSERT de usuario, no habrá entradas de ese tipo en el log para ese intento.
- Para ver intentos fallidos habría que revisar:
  - **Log de PHP** (según configuración del servidor, p. ej. `error_log` de Apache o `php_errors.log`).
  - **Log de MySQL** (si está habilitado), buscando errores 1062 en el momento del intento de registro.

Ejemplo de búsqueda en log de PHP (ruta según el servidor):

```bash
grep -i "duplicate\|1062\|sec_asp_users\|app_form_add_users" /ruta/al/php_error.log
```

---

## 6. Recomendaciones

1. **Comprobar en BD** si el email/login que el usuario intenta usar ya existe en `sec_asp_users` (consultas de la sección 3).
2. **Validación previa en el formulario:** en **onValidate** o **BeforeInsert** de app_form_add_users, hacer un `SELECT` en `sec_asp_users` por el login/email que se va a insertar; si ya existe, mostrar un mensaje claro (por ejemplo: “Ese correo ya está registrado”) y cancelar el insert para no depender solo del error de MySQL.
3. **Mensaje al usuario:** si no se añade validación previa, al menos documentar internamente que “Violación de la Clave Única local” en esta app significa, en la práctica, **correo/login ya registrado**, para dar una respuesta clara al usuario (por ejemplo: “Ese correo ya está dado de alta. Si ya te registraste, usa Recuperar contraseña o contacta a administración.”).
