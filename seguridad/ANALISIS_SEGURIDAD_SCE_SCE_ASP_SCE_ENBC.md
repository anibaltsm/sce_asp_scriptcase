# Análisis de seguridad del sistema SCE / SCE_ASP / SCE_ENBC

**Fecha del análisis:** marzo 2025  
**Alcance:** Proyectos ScriptCase **sce**, **sce_asp** y base de datos **sce_enbc** (sistema de gestión de posgrado INECOL).

---

## 1. Resumen ejecutivo

El sistema se compone de:

| Sistema      | Tipo        | Descripción |
|-------------|-------------|-------------|
| **sce**     | Proyecto SC | Estudiantes, tesorería, personal administrativo, menú EBC (programa 9). Login en `app_Login`, tablas `sec_users`, `sec_users_groups`, `sec_groups_apps`. |
| **sce_asp** | Proyecto SC | Aspirantes al posgrado, recomendantes, pagos, requisitos, entrevistadores. Login en `App_login`, tablas `sec_asp_users`, `sec_asp_users_groups`, `sec_asp_groups_apps`. |
| **sce_enbc** | Base de datos | BD independiente; respaldos en `respaldos bd/`. En el código de **sce** se usa para estudiantes del programa 9 (`menu_est_ebc`). No hay proyecto ScriptCase `apps_sce_enbc` en el repo. |

**Nivel de riesgo global:** **Alto**. Se identifican vulnerabilidades críticas y altas en autenticación, control de acceso y manejo de datos sensibles. A continuación se detallan por categoría.

---

## 2. Autenticación y contraseñas

### 2.1 Almacenamiento de contraseñas (CRÍTICO)

- **sce (`sec_users`):**
  - Campo `pswd` varchar(255). En respaldos de BD aparecen **contraseñas en texto plano** (ej. `RESA991109`, `Tecjeck2579`, `Gordito15`, `NinaGonzaloMax7`).
  - Comparación en login: `WHERE login = $slogin AND pswd = $spswd` — compatible con texto plano o con hash según cómo se guarde.

- **sce_asp (`sec_asp_users`):**
  - Campo `pswd` varchar(32). En respaldos hay mezcla: algunas en texto plano (`nimda`, `321`, `moreno2303`, `JgBseuvU`), otras podrían ser MD5 (32 caracteres hex).
  - Mismo patrón de comparación en `App_login/Eventos/ onValidate`.

**Riesgo:** Exposición total de credenciales si hay fuga de BD o respaldos. Cumplimiento (LGPD, buenas prácticas) comprometido.

**Recomendación:**
- Migrar a **password_hash(..., PASSWORD_ARGON2ID)** o al menos **bcrypt**; nunca texto plano ni MD5.
- Guardar solo el hash; en login usar `password_verify()`.
- Plan de migración: nueva columna `pswd_hash`, migración por lotes, luego eliminar `pswd`.

### 2.2 Sanitización en login

- **sce** y **sce_asp:** En el evento **onValidate** del login se usa `sc_sql_injection({login})` y `sc_sql_injection(({pswd}))` para construir la consulta. **Positivo:** reduce riesgo de inyección SQL en el punto de entrada.
- **onValidateSuccess (sce y sce_asp):** Las consultas posteriores usan `[usr_login]` interpolado directamente en SQL (ej. `WHERE login = '". [usr_login] ."'`). El valor viene de la sesión establecida tras un login exitoso; el riesgo es menor pero **recomendable** sanitizar o usar consultas preparadas también ahí para defensa en profundidad.

### 2.3 Cierre de sesión y funciones faltantes

- En producción (`/opt/lampp/htdocs/sce`) el código generado llama a `sc_logged_check_logout()`, `sc_logged_out()`, `sc_logged_in_fail()`. Si no están definidas en `_lib`, la app devuelve **500** (ver `docs/SOLUCION_SCE_APP_LOGIN_500_FUNCIONES_LOGOUT.md`).
- Solución actual: parche en `fix.php` y script post-deploy. Cualquier redeploy puede sobrescribir `fix.php` si no se usa el script con bloqueo (`chattr +i`).

**Recomendación:** Centralizar logout en funciones de ScriptCase o en un único include versionado para no depender de parches frágiles.

---

## 3. Control de acceso y autorización

### 3.1 Modelo de permisos

- **sce:** `sec_users_groups` (login → group_id), `sec_groups_apps` (group_id, app_name, priv_*). Redirección por tipo: menu_master, menu_estudiante, menu_est_ebc, Menu_Tesoreria, menu_admvo_posgrado, menu_aspirante, etc.
- **sce_asp:** `sec_asp_users_groups`, `sec_asp_groups_apps`; permisos por aplicación (access, insert, delete, update, export, print). Redirección: menu, menu_aspirante, menu_admvo, menu_eval_gral_2025, menu_inv, menu_sp, form_reactivar_registro.

El diseño (grupos y matriz de permisos por app) es adecuado; el riesgo está en la aplicación de ese modelo (ver IDOR más abajo).

### 3.2 Validación de sesión en aplicaciones

- **form_recomendantes:** En **onApplicationInit** se valida `$_SESSION['id_asp']` y se redirige a `menu_aspirante` si no hay aspirante. **Correcto.**
- **grid_pagos:** En **onApplicationInit** se usa `id_asp` desde **sesión** o desde **GET** (`$_GET['id_asp']`). Si se envía `?id_asp=123`, se **sobrescribe la sesión** con ese valor y el grid muestra pagos de ese `id_asp` sin comprobar que corresponda al usuario logueado.

**Riesgo (IDOR – Insecure Direct Object Reference):** Un aspirante puede ver/editar datos de otro aspirante cambiando el parámetro en la URL.

**Recomendación:** En **grid_pagos** (y cualquier app que use `id_asp`):
- Para usuarios con rol **aspirante**, ignorar `id_asp` de la URL y usar **únicamente** `$_SESSION['id_asp']` establecido en el login (onValidateSuccess).
- Si se recibe `id_asp` por GET, validar que `id_asp` corresponda al `login` actual (consulta a `aspirantes` por `login_FK` y `generacion`) y rechazar o redirigir si no coincide.

### 3.3 Exposición de datos en logs

- En `sc_log` (respaldos y documentación) aparecen registros de **app_form_add_users** con **contraseña en claro** en el campo “fields” del insert (ej. `pswd (new): OrdoñezYDan`). Si el módulo de log guarda los valores de formulario, las contraseñas quedan registradas.

**Recomendación:** Excluir el campo `pswd` (y cualquier campo de contraseña) del log de cambios; en ScriptCase revisar configuración del módulo de log para no registrar ese campo.

---

## 4. Inyección SQL y validación de entradas

### 4.1 Uso de sc_sql_injection

- Login en **sce** y **sce_asp** usa `sc_sql_injection()` para login y contraseña. **Bien.**
- En **onValidateSuccess** (sce y sce_asp) y en **sc_validate_success** (sce_asp) hay múltiples consultas con `[usr_login]` concatenado en el SQL sin pasar por `sc_sql_injection`. El valor proviene del login recién validado, por lo que el riesgo inmediato es bajo; no obstante, si en el futuro ese valor pudiera ser manipulado (ej. por otra app que comparta sesión), existiría riesgo.

**Recomendación:** Usar siempre sanitización o consultas preparadas para cualquier valor que se inserte en SQL, incluido `[usr_login]` en eventos posteriores al login.

### 4.2 Parámetro id_asp

- En **grid_pagos** se hace `ltrim($_GET['id_asp'], "0")` y se usa en sesión y en WHERE. No hay validación de tipo (entero) ni de pertenencia al usuario. Además del IDOR ya citado, un valor mal formado podría provocar comportamientos inesperados.

**Recomendación:** Validar que `id_asp` sea numérico (ej. `ctype_digit`) y que pertenezca al usuario antes de usarlo.

---

## 5. Exposición de credenciales y datos sensibles

### 5.1 Contraseña de base de datos en repositorio

- En `respaldos bd/README.md` y en scripts de respaldo aparece la contraseña de MySQL en claro (ej. `-p515t3ma5`). Cualquier persona con acceso al repositorio puede conocer credenciales de BD.

**Recomendación:**
- No incluir contraseñas en código ni en documentación versionada.
- Usar variables de entorno o archivos de configuración excluidos del repo (ej. `.env` en `.gitignore`) y leer la contraseña desde ahí en scripts y en la aplicación.

### 5.2 Respaldos con datos personales y contraseñas

- Los archivos `.sql` en `respaldos bd/` contienen:
  - Contraseñas en texto plano (o hashes débiles) en `sec_users` y `sec_asp_users`.
  - Datos personales (nombre, email, teléfono, direcciones, etc.).
  - Posiblemente documentos (rutas o contenido en tablas de evidencias).

Si estos archivos están en un repositorio accesible, el riesgo de fuga es alto.

**Recomendación:**
- Excluir respaldos con datos reales del repositorio (`.gitignore`: `respaldos bd/*.sql` o similar).
- Mantener respaldos en almacenamiento seguro, cifrado y con control de acceso.
- Para desarrollo, usar solo dumps anonimizados o de prueba sin datos reales.

---

## 6. Subida y gestión de archivos

- **form_pagos** y **form_asp_requisitos_1:** Subida de PDFs y documentos; nomenclatura estandarizada (ej. `generacion_id_asp_num_req_prefijo.ext`). Las rutas referencian `_lib/file/doc/pagos/`, etc.
- No se revisó en detalle la validación de tipo MIME, extensión, tamaño ni el no guardar en directorios ejecutables. Es importante asegurar:
  - Whitelist de extensiones y validación de contenido.
  - Almacenamiento fuera del document root o con reglas que impidan ejecución.
  - Que no se pueda sobrescribir archivos de otros usuarios (por ejemplo validando que el path derivado de `id_asp` corresponda al usuario).

**Recomendación:** Auditar todos los formularios que suben archivos (validación, rutas, permisos de escritura y control de acceso por usuario).

---

## 7. XSS y CSRF

- No se realizó un barrido exhaustivo de salidas HTML (echo, templates) ni de formularios sin token CSRF. ScriptCase suele generar salidas que pueden escapar contenido en muchos casos, pero los eventos personalizados (PHP y HTML inyectado en eventos) pueden introducir XSS si se imprimen variables sin escapar.
- Formularios que modifican datos (insert/update) deberían estar protegidos contra CSRF (tokens por sesión). Depende de cómo ScriptCase los genere.

**Recomendación:** Revisar todas las salidas que incluyan `[id_asp]`, `[usr_login]` o cualquier dato de usuario y asegurar escape (ej. `htmlspecialchars(..., ENT_QUOTES, 'UTF-8')`). Revisar si el framework aplica tokens anti-CSRF en formularios críticos.

---

## 8. Resumen por sistema

### 8.1 SCE (app_Login, sec_users, menús estudiantes/administrativos/EBC)

| Aspecto              | Estado   | Notas |
|----------------------|----------|--------|
| Contraseñas          | Crítico  | Texto plano en BD/respaldos. |
| SQL en login         | Aceptable| Uso de sc_sql_injection. |
| SQL en onValidateSuccess | Mejorable | [usr_login] sin sanitizar en varias consultas. |
| Logout               | Mejorable| Dependencia de fix.php y post-deploy. |
| Permisos por grupo   | Correcto | sec_groups_apps aplicado. |
| EBC (menu_est_ebc)   | Correcto | Mismo modelo de permisos; BD sce_enbc usada por datos. |

### 8.2 SCE_ASP (App_login, sec_asp_*, aspirantes, recomendantes, pagos)

| Aspecto              | Estado   | Notas |
|----------------------|----------|--------|
| Contraseñas          | Crítico  | Texto plano o hash débil en sec_asp_users. |
| SQL en login         | Aceptable| sc_sql_injection en onValidate. |
| SQL en sc_validate_success | Mejorable | [usr_login] y [generacion] en cadenas SQL. |
| IDOR grid_pagos      | Crítico  | id_asp por GET sin validar pertenencia. |
| Sesión id_asp        | Correcto | form_recomendantes valida sesión. |
| Log de contraseñas   | Alto     | sc_log puede registrar pswd en inserts. |

### 8.3 SCE_ENBC (base de datos)

- **sce_enbc** es una base de datos; no hay aplicación ScriptCase específica en el repo. Se usa desde **sce** para el menú de estudiantes EBC (programa 9). Los mismos criterios de seguridad de BD aplican: acceso solo con credenciales fuertes, sin contraseñas en repo, respaldos cifrados y restringidos.

---

## 9. Plan de acción recomendado (priorizado)

1. **Inmediato**
   - Eliminar contraseñas de BD y de respaldos del repositorio; usar variables de entorno para scripts y documentación.
   - En **grid_pagos**: no confiar en `id_asp` por GET para aspirantes; usar solo sesión y validar pertenencia si se permite algún parámetro.
   - Excluir `pswd` del registro en módulo de log (evitar que se guarde en sc_log).

2. **Corto plazo**
   - Migrar almacenamiento de contraseñas a hash seguro (Argon2id o bcrypt) y actualizar lógica de login.
   - Revisar y corregir cualquier otra pantalla que use `id_asp` o identificadores análogos por GET sin validar pertenencia al usuario.
   - Añadir sanitización (o prepared statements) para `[usr_login]` en onValidateSuccess y sc_validate_success.

3. **Mediano plazo**
   - Auditar subida de archivos (validación, rutas, permisos).
   - Revisar salidas HTML y formularios para XSS y CSRF.
   - Endurecer post-deploy (logout y fix.php) para no depender de parches manuales tras cada publicación.

4. **Continuo**
   - Mantener respaldos de BD fuera del repo y con control de acceso y cifrado.
   - Revisar permisos por grupo al añadir nuevas aplicaciones (sincronización sec_asp_apps / sec_apps y sec_asp_groups_apps / sec_groups_apps).

---

## 10. Referencias en el repositorio

- Login y permisos sce: `scriptcase/apps_sce/app_Login/Eventos/onValidate`, `onValidateSuccess`.
- Login y permisos sce_asp: `scriptcase/apps_sce_asp/App_login/Eventos/ onValidate`, `scriptcase/apps_sce_asp/App_login/metodos/sc_validate_success`.
- IDOR y sesión: `scriptcase/apps_sce_asp/grid_pagos/Eventos/onApplicationInit`, `scriptcase/apps_sce_asp/form_recomendantes/Eventos/onApplicationInit`.
- Logout 500: `docs/SOLUCION_SCE_APP_LOGIN_500_FUNCIONES_LOGOUT.md`, `scripts/post_deploy_sce.sh`.
- Permisos sec_asp: `data/PERMISOS_APLICACION_SEC_ASP.md`.
- Respaldos: `respaldos bd/README.md` (contiene credenciales; no versionar contraseñas).
- Estructura BD: `README_BD_SCE_ASP.md`, `docs/DIFERENCIA_LINUX_WINDOWS_LOGIN_MENUBASE.md`.

---

*Documento generado como análisis de seguridad del sistema SCE/SCE_ASP/SCE_ENBC. Debe revisarse y actualizarse ante cambios en autenticación, permisos o despliegue.*
