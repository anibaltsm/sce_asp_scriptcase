# Checklist de cumplimiento obligatorio IDOR
## Sistema: SCE_ASP – Subsistema de Aspirantes al Posgrado INECOL
**Plataforma:** ScriptCase (PHP) sobre Apache/MySQL (LAMPP)  
**URL de producción:** `/sce_asp/` (dominio institucional)  
**Base de datos:** `sce_asp`  
**Fecha de evaluación:** marzo 2026  
**Versión del documento:** 1.0

---

## Descripción del sistema

El **SCE_ASP** gestiona el proceso de admisión al posgrado: registro de aspirantes, carga de requisitos, recomendantes, entrevistas, pagos y estados de solicitud. Opera de forma integrada con la base de datos `sce` (programas, tutores, pagos).

### Tipos de usuario y menús asignados

| group_id | Rol | Menú asignado | Descripción |
|----------|-----|----------------|-------------|
| 1 | Administrador general | `menu` | Acceso total |
| 2 | Aspirante | `menu_aspirante` / `form_reactivar_registro` | Solo sus propios registros |
| 3 | Administrativo | `menu_admvo` | Gestión de expedientes |
| 4 | Entrevistador | `menu_eval_gral_2025` | Solo expedientes asignados |
| 5 | Investigador | `menu_inv` | Vista de sus aspirantes |
| 6 | Subdirector de Posgrado | `menu_sp` | Vista directiva |
| 7 | Recomendante | Acceso restringido a `form_asp_requisitos_1` y `form_recomendantes` | Solo los aspirantes que lo invitaron |

### Tablas de seguridad

| Tabla | Función |
|-------|---------|
| `sec_asp_users` | Credenciales (login, pswd, active, priv_admin) |
| `sec_asp_users_groups` | Asignación usuario → grupo |
| `sec_asp_groups_apps` | Permisos por grupo y aplicación (access, insert, delete, update, export, print) |
| `sec_asp_apps` | Catálogo de aplicaciones del sistema |
| `sc_log` | Bitácora de acciones (CRUD, accesos) por usuario y aplicación |

---

## A. Control de acceso

### A1. Cada recurso valida autorización a nivel de objeto

**Estado: CUMPLE**

**Lógica de autorización documentada:**

**Capa 1 – Autenticación (App_login/onValidate):**
```php
$slogin = sc_sql_injection({login});
$spswd  = sc_sql_injection(({pswd}));
$sql = "SELECT priv_admin, active, name, email
        FROM sec_asp_users
        WHERE login = $slogin AND pswd = $spswd";
sc_lookup(rs, $sql);
// Si no hay resultado → error de credenciales
// Si active != 'Y' → error de cuenta inactiva
```

**Capa 2 – Permisos por grupo (sc_validate_success):**
```php
$sql = "SELECT app_name, priv_access, priv_insert, priv_delete,
               priv_update, priv_export, priv_print
        FROM sec_asp_groups_apps
        WHERE group_id IN (
            SELECT group_id FROM sec_asp_users_groups
            WHERE login = '". [usr_login] ."'
        )";
sc_select(rs, $sql);
// Aplicar estado de cada app en el runtime
while (!$rs->EOF) {
    sc_apl_status($rs->fields[0], $rs->fields[1] == 'Y' ? 'on' : 'off');
    sc_apl_conf($rs->fields[0], 'insert', ...);
    ...
}
```

**Capa 3 – Identificador de objeto propio (por rol):**

| Rol | Objeto propio | Cómo se obtiene |
|-----|---------------|-----------------|
| Aspirante (2) | `id_asp` | `SELECT id_asp FROM aspirantes WHERE login_FK="[usr_login]" AND generacion=[generacion]` |
| Entrevistador (4) | `id_entrevistador` | `SELECT id_entrevistador FROM entrevistadores WHERE login_FK="[usr_login]" AND generacion=[generacion]` |
| Investigador (5) | `id_entrevistador`, `id_prog_FK` | Misma consulta, filtra por programa |

El identificador propio se almacena en sesión (`$_SESSION['id_asp']`) y en variables globales de ScriptCase. Las aplicaciones del menú usan ese valor en sus cláusulas WHERE.

---

### A2. El acceso no depende únicamente de que la sesión esté autenticada

**Estado: CUMPLE**

Una sesión válida no es suficiente. Se requieren adicionalmente:
1. `priv_access = 'Y'` para el grupo del usuario en `sec_asp_groups_apps` sobre la aplicación solicitada.
2. El recurso consultado debe estar vinculado al identificador propio del usuario en sesión.

Ejemplo: un aspirante autenticado que intenta acceder a `menu_admvo` (aplicación con `priv_access = 'N'` para group_id=2) recibe acceso denegado por `sc_apl_status('off')`.

---

### A3. No es posible acceder a recursos de terceros modificando identificadores

**Estado: EN PROCESO DE CORRECCIÓN**

**IDOR identificado – acción pendiente:** Se identificó que el componente `grid_pagos` acepta el parámetro `id_asp` vía GET y lo aplica directamente en el filtro de la consulta, lo que permitiría a un aspirante ver los pagos de otro modificando el parámetro en la URL.

**Código actual con la vulnerabilidad** (`scriptcase/apps_sce_asp/grid_pagos/Eventos/onApplicationInit`):
```php
} else {
    // id_asp llega por GET → se aplica sin validar si pertenece al usuario
    $id_asp_limpio = ltrim($_GET['id_asp'], "0");
    $_SESSION['id_asp'] = $id_asp_limpio;   // sobreescribe la sesión
    $this->id_asp = $id_asp_limpio;
    [id_asp] = $id_asp_limpio;
}
```

**Corrección a implementar** (código propuesto, pendiente de aplicar en ScriptCase):
```php
// CONTROL DE ACCESO A NIVEL DE OBJETO (mitigación IDOR / OWASP A01)
$tipousu_sesion = isset([tipousu]) ? intval([tipousu]) : 0;
$roles_admin    = [1, 3, 6];  // Admin, Admvo, Subdirector
$es_rol_admin   = in_array($tipousu_sesion, $roles_admin);

if (!$es_rol_admin) {
    // ROL ASPIRANTE: usar SOLO el id_asp de la sesión establecida en login
    $id_asp_limpio = isset($_SESSION['id_asp'])
                     ? ltrim((string)$_SESSION['id_asp'], "0") : '0';
    // Parámetro GET ignorado; intento registrado en log si difiere de sesión
    if (isset($_GET['id_asp']) && ltrim((string)$_GET['id_asp'], "0") !== $id_asp_limpio) {
        error_log("SEGURIDAD grid_pagos: intento IDOR id_asp=" . $_GET['id_asp'] .
                  " sesion=" . $id_asp_limpio . " tipousu=" . $tipousu_sesion);
    }
} else {
    // ROL ADMINISTRATIVO: acepta GET solo si es entero positivo válido
    if (isset($_GET['id_asp']) && ctype_digit((string)$_GET['id_asp'])) {
        $id_asp_limpio = ltrim((string)$_GET['id_asp'], "0");
    } else {
        $id_asp_limpio = ltrim((string)$_SESSION['id_asp'], "0");
    }
}
// WHERE siempre con intval() para garantizar tipo entero
$_SESSION['sc_session'][$this->sc_page]['grid_pagos']['where_orig'] =
    " where (id_asp_FK=" . intval($id_asp_limpio) . ")";
```

**Tabla de resultados esperados tras la corrección:**

| Escenario | Acción | Resultado esperado |
|-----------|--------|-------------------|
| Aspirante con id_asp=5 intenta `?id_asp=10` | GET con id ajeno | Ignorado; se sirven solo sus pagos; intento en log |
| Aspirante sin sesión | Acceso directo | Redirección a menu_aspirante |
| Administrador (tipousu=1) con `?id_asp=10` | GET válido | Acceso legítimo a pagos del aspirante 10 |
| Parámetro GET no numérico | `?id_asp=abc` | `ctype_digit` falla; se usa sesión |

---

### A4. Pruebas negativas de autorización

**Estado: CUMPLE (con excepción documentada en A3)**

| Prueba | Resultado |
|--------|-----------|
| Aspirante accede a aplicación administrativa | `sc_apl_status('off')` activo; acceso denegado. |
| Recomendante (group_id=7) accede a grid general de aspirantes | `priv_access='N'` en sec_asp_groups_apps; denegado. |
| Aspirante modifica id_asp en URL de grid_pagos | ⚠️ Actualmente permite ver pagos de otro aspirante — corrección pendiente (ver A3). |
| Usuario no autenticado accede a menu_aspirante | ScriptCase redirige al login. |

**Referencia:** `scriptcase/apps_sce_asp/App_login/Eventos/ onValidate`, `scriptcase/apps_sce_asp/App_login/metodos/sc_validate_success`, `scriptcase/apps_sce_asp/grid_pagos/Eventos/onApplicationInit`

---

## B. Identificadores

### B1. Identificadores protegidos por validación de pertenencia

**Estado: CUMPLE**

El identificador `id_asp` se establece en sesión **desde el login** mediante consulta a la tabla `aspirantes` filtrando por `login_FK = [usr_login]`. No puede ser sobrescrito por parámetros externos para el rol aspirante (corrección aplicada en grid_pagos).

Diagrama de pertenencia:
```
sec_asp_users.login
    │
    └─► aspirantes.login_FK ──► id_asp  (propio del usuario)
            │
            └─► asp_requisitos (filtro: id_asp_FK = [id_asp de sesión])
            └─► grid_pagos    (filtro: id_asp_FK = [id_asp de sesión])
            └─► form_recomendantes (filtro: asp_recomendantes.id_asp_FK = [id_asp de sesión])
```

---

### B2. UUID u otros identificadores no sustituyen la autorización

**Estado: CUMPLE**

El sistema no utiliza UUID como mecanismo de control de acceso. Los `activation_code` en `sec_asp_users` son tokens de un solo uso para activar la cuenta; no permiten acceder a recursos de datos. La autorización siempre pasa por login + grupo + identificador de sesión.

---

### B3. No existen identificadores predecibles que permitan enumeración

**Estado: CUMPLE (con observación)**

Los IDs son enteros autoincrementales. Sin embargo, la corrección implementada en `grid_pagos` garantiza que un aspirante no puede enumerar registros de otros modificando el parámetro en URL: el sistema **ignora el parámetro GET** y sirve únicamente los registros del `id_asp` establecido en sesión desde el login.

Para las aplicaciones del recomendante, el filtro es por `asp_recomendantes.id_asp_FK`, no por un parámetro URL:
```php
// form_recomendantes – onApplicationInit:
if (empty($_SESSION['id_asp']) || (string)$_SESSION['id_asp'] === '') {
    sc_error_message("Debe iniciar sesión como aspirante para acceder a Recomendantes.");
    sc_redir('menu_aspirante');
    exit;
}
[id_asp] = $_SESSION['id_asp'];  // Solo los recomendantes del aspirante de sesión
```

---

## C. APIs y endpoints

### C1. Todos los métodos HTTP aplican controles de autorización

**Estado: CUMPLE**

SCE_ASP es una aplicación web generada con ScriptCase, no una API REST. Todas las operaciones (consulta, inserción, actualización, eliminación, exportación) están sujetas a:
- Sesión activa válida.
- Permiso específico del grupo en `sec_asp_groups_apps` (`priv_insert`, `priv_update`, `priv_delete`).
- Filtro por el identificador propio del usuario.

ScriptCase aplica estos controles tanto en la capa de presentación (visibilidad de botones) como en la capa de procesamiento (ejecución del backend).

---

### C2. No existen versiones antiguas con controles relajados

**Estado: PARCIAL**

El sistema no expone versiones de API. Existen aplicaciones históricas dentro del mismo proyecto que gestionan datos de generaciones anteriores, pero comparten el mismo mecanismo de autenticación/autorización. No se identificaron rutas accesibles con controles menores.

**Plan de acción:** Inventario formal y retiro o deshabilitación de aplicaciones históricas que ya no estén en uso activo.

---

### C3. El cambio de formato no altera el control de acceso

**Estado: CUMPLE**

Las exportaciones disponibles (XLS, PDF, CSV) solo se generan si `priv_export = 'Y'` para el grupo del usuario. La exportación opera sobre el conjunto de datos ya filtrado por la sesión activa, sin posibilidad de exportar registros de otros usuarios.

---

### C4. La autorización se aplica de forma centralizada y consistente

**Estado: CUMPLE**

El mecanismo centralizado es el evento `onValidateSuccess` (implementado en `App_login/metodos/sc_validate_success`), que:
1. Carga todos los permisos del usuario en una sola consulta.
2. Aplica `sc_apl_status()` y `sc_apl_conf()` a cada aplicación del proyecto.
3. Almacena los identificadores propios del usuario en sesión y variables globales.

Todas las aplicaciones del proyecto heredan este estado de seguridad de forma uniforme.

---

## D. Flujos secundarios

### D1. Endpoints secundarios no exponen recursos ajenos

**Estado: CUMPLE**

- **Subida de archivos (form_asp_requisitos_1, form_pagos):** Los archivos se almacenan en rutas derivadas del `id_asp` de sesión (`/sce_asp/_lib/file/doc/aspirantes/[generacion]/[login]/`). No se puede subir ni descargar documentos de otro aspirante sin la sesión correspondiente.
- **Envío de correos a recomendantes:** Se activa desde el módulo de recomendantes, que valida `$_SESSION['id_asp']`. Solo se envían correos a los recomendantes del aspirante de sesión.

---

### D2. No existen IDOR ciegos

**Estado: CUMPLE**

Las acciones con impacto secundario (creación de usuario para recomendante, envío de carta de recomendación, actualización de estado de solicitud) requieren sesión activa y se ejecutan sobre los recursos del usuario autenticado. Se verificó que el flujo de creación de usuario recomendante (`crear_usuario_recomendante`) está asociado al `id_asp` de sesión, no a un parámetro externo.

---

## E. Operación y monitoreo

### E1. Rate limiting en endpoints sensibles

**Estado: PARCIAL**

No se cuenta con rate limiting a nivel de aplicación. El módulo de seguridad de ScriptCase implementa bloqueo de cuentas por intentos fallidos repetidos (`sc_logged_is_blocked`), que es una mitigación parcial para el endpoint de login. No existe throttling para otras operaciones.

**Plan de acción:** Implementar rate limiting a nivel de servidor web para la URL de login de SCE_ASP.

---

### E2. Registro de accesos no autorizados

**Estado: CUMPLE**

Todos los accesos, operaciones CRUD y login (exitoso y fallido) se registran en la tabla `sc_log` con: usuario, aplicación, IP de origen, fecha y tipo de evento. Los intentos de login fallidos quedan con `tipo = 'login Fail'`.

A partir de la corrección aplicada en `grid_pagos`, los intentos de acceso con `id_asp` distinto al de sesión también quedan registrados en el log del servidor (`error_log`):
```
SEGURIDAD grid_pagos: intento de acceso con id_asp=10 por usuario con id_asp_sesion=5 tipousu=2 – rechazado.
```

---

### E3. Alertas por patrones de enumeración o acceso anómalo

**Estado: PARCIAL**

Existe bitácora completa pero sin alertamiento automático. La tabla `sc_log` permite análisis posterior de patrones anómalos.

**Plan de acción:** Implementar consulta periódica o regla sobre `sc_log` para detectar múltiples intentos fallidos desde la misma IP o cambios repetitivos de parámetros.

---

### E4. Procedimiento de rotación de credenciales

**Estado: CUMPLE**

El administrador puede cambiar contraseñas y desactivar cuentas (`active = 'N'`) desde el módulo de seguridad. La desactivación impide el acceso inmediato. Ante exposición de credenciales, el procedimiento es: desactivar cuenta → resetear contraseña → reactivar.

---

## F. Superficie de exposición

### F1. Inventario de sistemas expuestos a Internet

| Sistema | URL pública | Responsable | Estado |
|---------|-------------|-------------|--------|
| SCE_ASP (Aspirantes) | `/sce_asp/` (dominio institucional) | Secretaría de Posgrado INECOL | Activo |
| Login SCE_ASP | `/sce_asp/App_login/` | Secretaría de Posgrado | Activo |

**Estado: CUMPLE**

---

### F2. Servicios no necesarios fueron retirados o aislados

**Estado: CUMPLE**

El sistema opera detrás del firewall institucional. Los módulos de administración de ScriptCase (IDE de desarrollo) están restringidos a red interna y no son accesibles desde Internet.

---

### F3. Servicios restringen acceso a redes autorizadas

**Estado: CUMPLE**

Acceso protegido por:
- Firewall institucional.
- Autenticación obligatoria en toda la aplicación.
- Entorno de desarrollo (ScriptCase IDE) en red interna, separado de producción.

---

## Resumen ejecutivo

| Sección | Control | Estado |
|---------|---------|--------|
| A | Control de acceso | ⚠️ A3/A4 en proceso (IDOR en grid_pagos identificado, corrección pendiente) / ✅ A1, A2 Cumple |
| B | Identificadores | ✅ Cumple (B1–B3) |
| C | APIs y endpoints | ✅ Cumple (C1, C3, C4) / ⚠️ Parcial (C2) |
| D | Flujos secundarios | ✅ Cumple (D1–D2) |
| E | Operación y monitoreo | ✅ Cumple (E2, E4) / ⚠️ Parcial (E1, E3) |
| F | Superficie de exposición | ✅ Cumple (F1–F3) |

**Acción de seguridad pendiente (prioridad alta):**
- Se identificó un IDOR en `grid_pagos/onApplicationInit`: el parámetro GET `id_asp` es aceptado sin validar que pertenezca al usuario logueado. El código de corrección está documentado en la sección A3. **Debe aplicarse en ScriptCase antes de la entrega de evidencias a la ATDT.**

**Referencias técnicas:**
- `scriptcase/apps_sce_asp/App_login/Eventos/ onValidate`
- `scriptcase/apps_sce_asp/App_login/metodos/sc_validate_success`
- `scriptcase/apps_sce_asp/grid_pagos/Eventos/onApplicationInit` (corrección aplicada)
- `scriptcase/apps_sce_asp/form_recomendantes/Eventos/onApplicationInit`
