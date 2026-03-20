# Checklist de cumplimiento obligatorio IDOR
## Sistema: SCE – Sistema de Control Escolar Posgrado INECOL
**Plataforma:** ScriptCase (PHP) sobre Apache/MySQL (LAMPP)  
**URL de producción:** `/sce/` (dominio institucional)  
**Base de datos:** `sce`  
**Fecha de evaluación:** marzo 2026  
**Versión del documento:** 1.0

---

## Descripción del sistema

El **SCE** gestiona información académica de **estudiantes de posgrado** (doctorado, maestría y programa EBC). Incluye módulos de control escolar, tesorería, evaluación docente, tutorías y convenios institucionales.

### Tipos de usuario y menús asignados

| group_id | Rol | Menú asignado | Descripción |
|----------|-----|----------------|-------------|
| 1 | Administrador general | `menu_master` | Acceso total |
| 2 | Estudiante (posgrado) | `menu_estudiante` / `menu_est_ebc` | Solo sus propios registros |
| 3 | Personal admvo. INECOL | `Menu_Tesoreria` | Módulo de tesorería |
| 4 | Personal admvo. Posgrado | `menu_admvo_posgrado` | Gestión académica |
| 5 | Aspirante (histórico SCE) | `menu_aspirante` | Transición |
| 6 | Visitante / Externo | Menú restringido | Solo consulta |
| 7+ | Otros (investigadores, coord.) | Menús específicos | Funciones acotadas |

### Tablas de seguridad

| Tabla | Función |
|-------|---------|
| `sec_users` | Credenciales de usuarios (login, pswd, active, priv_admin) |
| `sec_users_groups` | Asignación usuario → grupo |
| `sec_groups_apps` | Permisos por grupo y aplicación (access, insert, delete, update, export, print) |
| `sec_apps` | Catálogo de aplicaciones del sistema |
| `sec_logged` | Registro de intentos de login (éxito/fallo) |
| `sc_log` | Bitácora de acciones (CRUD, accesos) por usuario y aplicación |

---

## A. Control de acceso

### A1. Cada recurso valida autorización a nivel de objeto

**Estado: CUMPLE**

**Lógica de autorización documentada:**

El proceso de autorización es de dos capas:

**Capa 1 – Autenticación (onValidate):**
```php
$slogin = sc_sql_injection({login});
$spswd  = sc_sql_injection(({pswd}));
$sql = "SELECT priv_admin, active, name, email
        FROM sec_users
        WHERE login = $slogin AND pswd = $spswd";
sc_lookup(rs, $sql);
// Si no hay resultado → error de credenciales
// Si active != 'Y' → error de cuenta inactiva
```

**Capa 2 – Autorización por grupo y objeto (onValidateSuccess):**
```php
// 1. Cargar permisos de todas las apps a las que tiene acceso el grupo del usuario
$sql = "SELECT app_name, priv_access, priv_insert, priv_delete,
               priv_update, priv_export, priv_print
        FROM sec_groups_apps
        WHERE group_id IN (
            SELECT group_id FROM sec_users_groups WHERE login = '". [usr_login] ."'
        )";
sc_select(rs, $sql);
// 2. Aplicar el estado de cada app en el runtime de ScriptCase
while (!$rs->EOF) {
    sc_apl_status($rs->fields[0], $rs->fields[1] == 'Y' ? 'on' : 'off');
    sc_apl_conf($rs->fields[0], 'insert', has_priv($rs->fields[2]));
    sc_apl_conf($rs->fields[0], 'delete', has_priv($rs->fields[3]));
    sc_apl_conf($rs->fields[0], 'update', has_priv($rs->fields[4]));
    ...
}
// 3. Derivar id de objeto propio del usuario (e.g. id_usu_est para estudiante)
$sql_id_usu_est = "SELECT id_est, id_prog_FK FROM estudiantes WHERE login_FK = '". [usr_login] ."'";
sc_lookup(idusu, $sql_id_usu_est);
$id_usu_est = {idusu[0][0]};
sc_set_global($id_usu_est);  // Solo sus propios registros quedan en sesión
```

**Resultado:** Una aplicación marcada como `priv_access = 'N'` para el grupo del usuario queda deshabilitada en tiempo de ejecución (`sc_apl_status('off')`); la solicitud no se procesa. Los identificadores de objetos propios del usuario (id_est, id_usu_ai, etc.) se almacenan en sesión desde el login y se usan en los WHERE de cada aplicación.

---

### A2. El acceso no depende únicamente de que la sesión esté autenticada

**Estado: CUMPLE**

Tener una sesión activa válida no es suficiente para acceder a una aplicación o recurso. Se requiere adicionalmente:
1. Que el grupo del usuario tenga `priv_access = 'Y'` para esa aplicación en `sec_groups_apps`.
2. Que el recurso solicitado (registro) esté filtrado por el identificador propio del usuario almacenado en sesión.

Si un usuario autenticado intenta acceder directamente a la URL de una aplicación para la que su grupo tiene `priv_access = 'N'`, ScriptCase aplica `sc_apl_status('off')` y redirige o deniega el acceso.

---

### A3. No es posible acceder a recursos de terceros modificando identificadores

**Estado: CUMPLE**

Los identificadores de objeto (id_est, id_usu_ai, id_usu_ap, etc.) no son parámetros de URL navegables por el usuario final. Son variables globales de sesión establecidas **exclusivamente en el proceso de login** (onValidateSuccess) mediante consulta a la tabla del rol correspondiente vinculada al `login_FK` autenticado. No existen formularios ni vistas que expongan o acepten estos identificadores como parámetro externo para el rol estudiante.

**Ejemplo de filtrado por objeto propio:**
```php
// En el login para rol estudiante (group_id = 2):
$sql_id_usu_est = "SELECT id_est, id_prog_FK
                   FROM estudiantes
                   WHERE login_FK = '". [usr_login] ."'";
sc_lookup(idusu, $sql_id_usu_est);
$id_usu_est = {idusu[0][0]};
sc_set_global($id_usu_est);   // Fijado desde BD por login autenticado
sc_set_global($num_usu);      // Mismo valor; aplicaciones usan [num_usu] en WHERE
```
Las aplicaciones del menú estudiante usan `[num_usu]` o `[id_usu_est]` en su cláusula WHERE, por lo que la consulta siempre está limitada al registro del usuario logueado.

---

### A4. Se realizan pruebas negativas de autorización (IDOR testing)

**Estado: CUMPLE**

Se ejecutaron pruebas manuales de manipulación de identificadores:

| Prueba | Acción | Resultado |
|--------|--------|-----------|
| Acceso a app sin permiso de grupo | URL directa a app con `priv_access=N` | ScriptCase devuelve pantalla de acceso denegado; `sc_apl_status('off')` activo. |
| Modificar id_est en sesión | Intentar sobreescribir variable global de sesión desde URL | No aplica: variables globales ScriptCase no se aceptan por GET/POST externo. |
| Login con credenciales de otro grupo | Usuario grupo 2 intenta acceder a `menu_master` | Redirección al menú propio del grupo; `menu_master` no está en sus permisos. |

**Referencia de código:** `scriptcase/apps_sce/app_Login/Eventos/onValidate`, `onValidateSuccess`

---

## B. Identificadores

### B1. Identificadores protegidos por validación de pertenencia

**Estado: CUMPLE**

Cada solicitud que referencia un objeto personal (expediente de estudiante, registro de pago, tesis, etc.) utiliza el identificador derivado del `login_FK` autenticado. El valor se establece en la sesión durante el login y no puede ser sustituido por parámetros externos para roles de usuario final.

**Modelo de autorización (resumen):**
```
Autenticación → login verificado contra sec_users
    ↓
Permisos de app → group_id del usuario en sec_groups_apps
    ↓
Identificador de objeto → id_est / id_usu_ai / id_usu_ap obtenido de BD por login_FK
    ↓
WHERE aplicado en cada vista/formulario usando ese identificador de sesión
```

---

### B2. UUID u otros identificadores no sustituyen la autorización

**Estado: CUMPLE**

El sistema no usa UUID como mecanismo de acceso. El acceso depende de la combinación: sesión activa + grupo con permisos + identificador propio obtenido de BD. Conocer un identificador válido sin pasar por el login no permite acceder al recurso.

---

### B3. No existen identificadores predecibles que permitan enumeración

**Estado: CUMPLE (con observación)**

Los identificadores primarios son enteros autoincrementales (e.g. `id_est`). Sin embargo, la enumeración no representa riesgo porque:
1. El identificador del objeto **no se expone como parámetro de URL** para los roles de usuario final.
2. La autorización se valida contra `login_FK` en BD, no contra el identificador directamente.
3. Una solicitud con un `id_est` distinto al de la sesión no devuelve datos: el WHERE siempre filtra por el identificador propio del usuario.

**Observación:** Se recomienda a futuro complementar con identificadores opacos (UUID) como medida adicional de defensa en profundidad, aunque el control de autorización ya opera correctamente con los IDs actuales.

---

## C. APIs y endpoints

### C1. Todos los métodos HTTP aplican controles de autorización

**Estado: CUMPLE**

El SCE es una aplicación web generada con ScriptCase (no una API REST). Todas las páginas/aplicaciones son renderizadas por el framework con la lógica de permisos aplicada en `onApplicationInit` y en el motor de ScriptCase. El acceso a operaciones de inserción, actualización o eliminación requiere:
- Sesión activa.
- `priv_insert / priv_update / priv_delete = 'Y'` para el grupo en `sec_groups_apps`.
- ScriptCase oculta/deshabilita los botones de CRUD cuando el permiso es `'N'`; adicionalmente, el backend rechaza la operación si el usuario intenta ejecutarla sin el permiso correspondiente.

---

### C2. No existen versiones antiguas con controles relajados

**Estado: PARCIAL**

El sistema no tiene versiones de API; es una aplicación web monolítica. Existen módulos históricos (ej. apps de periodos anteriores) que permanecen activos pero bajo el mismo esquema de autenticación/autorización. No se han identificado rutas con controles relajados respecto a la versión actual.

**Acción de mejora:** Realizar inventario formal de aplicaciones publicadas y retirar aquellas que ya no estén en uso operativo.

---

### C3. El cambio de formato no altera el control de acceso

**Estado: CUMPLE**

Las exportaciones de datos (XLS, PDF, CSV, RTF, Word) en ScriptCase están controladas por `priv_export`. Si el grupo no tiene `priv_export = 'Y'`, el botón de exportación no se muestra y la operación no se ejecuta en el backend. La exportación siempre opera sobre el conjunto de datos ya filtrado por la sesión del usuario.

---

### C4. La autorización se aplica de forma centralizada y consistente

**Estado: CUMPLE**

El mecanismo de autorización es centralizado a través del evento `onValidateSuccess` del login, que:
1. Carga la matriz de permisos de toda la sesión en una sola pasada.
2. Aplica `sc_apl_status()` y `sc_apl_conf()` a cada aplicación.
3. Almacena en sesión el identificador propio del usuario.

Todas las aplicaciones del proyecto heredan este estado sin necesidad de reimplementar controles individuales. ScriptCase aplica las restricciones de forma uniforme en todas las rutas generadas.

**Referencia:** `scriptcase/apps_sce/app_Login/Eventos/onValidateSuccess`

---

## D. Flujos secundarios

### D1. Endpoints secundarios no exponen recursos ajenos

**Estado: CUMPLE**

Las funciones de exportación, descarga de documentos y notificación operan dentro de la sesión activa y sobre los registros filtrados por el identificador del usuario. No existen endpoints de descarga de archivos que acepten rutas o identificadores arbitrarios sin validación de sesión.

---

### D2. No existen IDOR ciegos

**Estado: CUMPLE**

Las acciones con impacto secundario (envío de correos institucionales, generación de documentos) están integradas en los formularios del sistema y requieren sesión activa con los permisos correspondientes. No se identificaron funciones que ejecuten acciones sobre recursos de terceros sin respuesta directa al usuario que las invoca.

---

## E. Operación y monitoreo

### E1. Rate limiting en endpoints sensibles

**Estado: PARCIAL**

No se cuenta actualmente con rate limiting específico a nivel de aplicación. El servidor cuenta con el firewall institucional como primera línea de defensa. ScriptCase implementa el módulo `sc_logged` que registra intentos de login fallidos y puede bloquear cuentas por exceso de intentos (`sc_logged_in_fail`, `sc_logged_is_blocked`).

**Plan de acción:** Implementar rate limiting a nivel de servidor web (mod_ratelimit en Apache o reglas en el WAF institucional) para la URL de login.

---

### E2. Registro de accesos no autorizados

**Estado: CUMPLE**

El sistema registra en la tabla `sc_log` todos los eventos de acceso, login exitoso, login fallido, inserciones, actualizaciones y eliminaciones. La tabla incluye: usuario, aplicación, IP, fecha/hora y tipo de evento.

**Extracto de estructura de log:**
```sql
-- Tabla sc_log (base sce):
-- login (usuario), nm_apl (aplicación), ip (IP de origen),
-- date_log (fecha), tipo (login, login Fail, access, insert, update, delete)
```

Los intentos de login fallidos quedan registrados con `tipo = 'login Fail'` y el login del usuario que intentó ingresar.

---

### E3. Alertas por patrones de enumeración o acceso anómalo

**Estado: PARCIAL**

Existe bitácora completa (`sc_log`), pero no se cuenta con un SIEM o sistema de alertamiento automático. La revisión de logs es manual y periódica.

**Plan de acción:** Integrar revisión automatizada de logs o implementar reglas de alerta sobre la tabla `sc_log` para detectar patrones como múltiples intentos fallidos desde la misma IP o accesos repetitivos en periodos cortos.

---

### E4. Procedimiento de rotación de credenciales

**Estado: CUMPLE**

Las credenciales de usuarios pueden ser modificadas por el administrador del sistema a través del módulo de seguridad (`app_form_edit_users`). El administrador puede:
- Cambiar contraseña de cualquier usuario.
- Desactivar cuentas (`active = 'N'`).
- Invalidar la sesión activa al desactivar la cuenta.

Ante un riesgo de exposición, el procedimiento es: desactivar la cuenta (`active = 'N'`), lo que impide el acceso inmediato, y luego restablecer la contraseña.

---

## F. Superficie de exposición

### F1. Inventario de sistemas expuestos a Internet

**Estado: CUMPLE**

| Sistema | URL pública | Responsable | Estado |
|---------|-------------|-------------|--------|
| SCE (Control Escolar) | `/sce/` (dominio institucional) | Secretaría de Posgrado INECOL | Activo |
| Login SCE | `/sce/app_Login/` | Secretaría de Posgrado | Activo |

El acceso al sistema requiere autenticación; no existen páginas de datos accesibles sin sesión.

---

### F2. Servicios no necesarios fueron retirados o aislados

**Estado: CUMPLE**

El sistema opera detrás del firewall institucional. No se exponen servicios de base de datos, administración de servidor ni paneles internos a Internet. El acceso a ScriptCase (entorno de desarrollo) está restringido a red interna.

---

### F3. Servicios restringen acceso a redes autorizadas

**Estado: CUMPLE**

El acceso al sistema está protegido mediante:
- Firewall institucional con reglas de acceso.
- Autenticación obligatoria en toda la superficie de la aplicación.
- Separación entre el entorno de desarrollo (ScriptCase, acceso interno) y producción (acceso web institucional).

---

## Resumen ejecutivo

| Sección | Control | Estado |
|---------|---------|--------|
| A | Control de acceso | ✅ Cumple (A1–A4) |
| B | Identificadores | ✅ Cumple (B1–B3, con observación en B3) |
| C | APIs y endpoints | ✅ Cumple (C1, C3, C4) / ⚠️ Parcial (C2) |
| D | Flujos secundarios | ✅ Cumple (D1–D2) |
| E | Operación y monitoreo | ✅ Cumple (E2, E4) / ⚠️ Parcial (E1, E3) |
| F | Superficie de exposición | ✅ Cumple (F1–F3) |

**Elementos con plan de mejora activo:**
- C2: Inventario formal de aplicaciones publicadas.
- E1: Rate limiting en URL de login.
- E3: Automatización de alertas sobre bitácora `sc_log`.

**Referencias técnicas:**
- `scriptcase/apps_sce/app_Login/Eventos/onValidate`
- `scriptcase/apps_sce/app_Login/Eventos/onValidateSuccess`
- `scriptcase/apps_sce/app_Login/Eventos/onScriptInit`
