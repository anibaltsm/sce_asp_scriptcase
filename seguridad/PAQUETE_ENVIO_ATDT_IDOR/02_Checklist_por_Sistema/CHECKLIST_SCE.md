# Checklist obligatorio IDOR - SCE

Sistema: SCE (Sistema de Control Escolar)
Plataforma: ScriptCase 9 (PHP 7.x / Apache / XAMPP)
URL: `https://posgrados.inecol.mx/sce/`
Base de datos: `sce` (MySQL)
Usuarios: 2,166 (2,143 activos)
Grupos: 11

> Fuentes para llenado (prioridad):
> 1) Evidencia primaria: codigo vigente ScriptCase, pruebas ejecutadas, logs y configuracion.
> 2) Requerimientos oficiales ATDT (IDOR_02_2026 y Checklist_obligatorio_IDOR).
> 3) Referencia interna opcional: `EVIDENCIA_IDOR_SCE.md` (solo como apoyo, no evidencia principal).

---

## A. Control de acceso

### A1. Cada recurso valida autorizacion a nivel de objeto
**Estado:** Cumple

**Control implementado:**
El evento `onValidateSuccess` de `app_Login` carga permisos de `sec_groups_apps` segun el grupo del usuario y aplica `sc_apl_status` (on/off) por cada aplicacion. Despues determina el `group_id` y obtiene el ID especifico del usuario consultando la tabla de su rol con `WHERE login_FK = [usr_login]`. Este ID se almacena como variable global y se usa en los WHEREs de cada aplicacion.

**Fragmento de codigo:**
```php
// onValidateSuccess - Obtener ID del usuario segun su grupo
case 2: // Estudiante
    $sql_id_usu_est = "SELECT id_est, id_prog_FK FROM estudiantes 
                        WHERE login_FK = '". [usr_login] ."'";
    sc_lookup(idusu, $sql_id_usu_est);
    $id_usu_est = {idusu[0][0]};
    sc_set_global($id_usu_est);
```

**Prueba:** Las apps filtran datos por variable global de sesion, no por parametro del cliente.
**Referencia de anexo:** Anexo B (codigo onValidateSuccess completo)

---

### A2. El acceso no depende unicamente de que la sesion este autenticada
**Estado:** Cumple

**Control implementado:**
`sc_apl_status` deshabilita el acceso a aplicaciones no autorizadas para el grupo. Para el grupo Estudiante (grupo 2), solo las apps especificas de estudiante tienen `priv_access = 'Y'`. Apps administrativas (`menu_master`, formularios admin) tienen `priv_access = NULL` o `N`.

**Prueba:** Si un estudiante intenta acceder por URL directa a una app admin, ScriptCase no renderiza la aplicacion.
**Referencia de anexo:** Anexo D (tabla sec_groups_apps grupo 2); Anexo E [evidencia operativa F2]

---

### A3. No es posible acceder a recursos de terceros modificando identificadores
**Estado:** Cumple

**Control implementado:**
Los formularios y grids usan variables globales de sesion (`$id_usu_est`, `$num_usu`) establecidas en `onValidateSuccess` via `login_FK`. Estas variables no se reciben por parametro GET/POST; se resuelven internamente desde el login autenticado. Un usuario no puede alterar su ID desde la URL.

**Prueba:** Cambiar parametros en URL no modifica la variable global de sesion.
**Referencia de anexo:** Anexo B (codigo onValidateSuccess)

---

### A4. Se realizan pruebas negativas de autorizacion (IDOR testing)
**Estado:** Cumple

**Pruebas integradas:**
- Acceso por URL directa a modulo administrativo con bloqueo funcional.
- Login fallido con registro en `sc_log`.
- Intento de acceso sin sesion valida sin exposicion de datos.

**Referencia de anexo:** Anexo E (capturas operativas consolidadas)

---

## B. Identificadores

### B1. Identificadores directos protegidos por validacion de pertenencia
**Estado:** Cumple

**Control implementado:**
Flujo de pertenencia:
1. Login -> `onValidate` verifica credenciales contra `sec_users`
2. `onValidateSuccess` determina `group_id` del usuario
3. Consulta tabla de rol con `WHERE login_FK = [usr_login]`
4. Almacena ID como variable global (`$id_usu_est`, `$id_usu_asp`, etc.)
5. Apps usan variable global en WHERE (no parametro del cliente)

**Referencia de anexo:** Anexo A (diagrama); Anexo B (codigo)

---

### B2. UUID, hashes u otros identificadores no sustituyen la autorizacion
**Estado:** Cumple

**Control implementado:**
El sistema usa IDs numericos (auto_increment). La autorizacion se basa en el modelo de permisos por grupo (`sec_groups_apps`) y la vinculacion usuario-recurso via `login_FK`, no en la ofuscacion del identificador.

**Referencia de anexo:** Seccion A1 (descripcion del mecanismo)

---

### B3. No existen identificadores predecibles o reutilizables
**Estado:** Cumple

**Situacion:**
IDs (`id_est`, `id_asp`, `id_pers_admvo_*`) son `INT AUTO_INCREMENT` (secuenciales). Mitigado porque:
1. Acceso requiere autenticacion
2. Filtro de datos se basa en `login_FK`, no en el ID numerico
3. IDs no se exponen en URLs sin sesion

**Referencia de anexo:** Anexo D (estructura de tablas)

---

## C. APIs y endpoints

### C1. Todos los metodos HTTP aplican controles de autorizacion
**Estado:** Cumple

**Control implementado:**
ScriptCase genera aplicaciones PHP con formularios POST. `sc_apl_conf` configura permisos granulares (insert, delete, update, export, print) por app y grupo. No existen APIs REST independientes.

**Referencia de anexo:** Anexo B (codigo sc_apl_conf); Anexo D (sec_groups_apps)

---

### C2. No existen versiones antiguas con controles relajados
**Estado:** Cumple

**Apps respaldo detectadas en produccion:**
- `app_Login_copia`
- `app_Login_respaldo`
- `app_Login_resp29102024`
- `app_form_add_users_respaldo`

**Accion ejecutada:** respaldos retirados/aislados y evidencia externa `404/403` integrada.
**Referencia de anexo:** Anexo C (inventario y evidencia A/B/C)

---

### C3. El cambio de formato no altera el control de acceso
**Estado:** Cumple

**Control implementado:**
`sc_apl_conf` controla exportacion en todos los formatos (xls, word, pdf, xml, csv, rtf, print) con el mismo permiso del grupo (`priv_export`, `priv_print`).

```php
$export_permission = 'btn_display_'. has_priv($rs->fields[5]);
sc_apl_conf($rs->fields[0], $export_permission, 'xls');
sc_apl_conf($rs->fields[0], $export_permission, 'word');
// ... pdf, xml, csv, rtf, print
```

**Referencia de anexo:** Anexo B (codigo onValidateSuccess lineas 33-44)

---

### C4. La autorizacion se aplica de forma centralizada y consistente
**Estado:** Cumple

**Control implementado:**
Toda la logica de permisos esta en un unico punto: `onValidateSuccess` del `app_Login`. Este evento carga permisos de `sec_groups_apps`, aplica `sc_apl_status`/`sc_apl_conf` a TODAS las apps, determina el tipo de usuario y redirige al menu autorizado. No existen rutas alternativas.

**Referencia de anexo:** Anexo A (diagrama de arquitectura); Anexo B (codigo)

---

## D. Flujos secundarios

### D1. Endpoints secundarios no exponen recursos ajenos
**Estado:** Cumple

**Flujos revisados:**
- Exportacion: controlada por `sc_apl_conf` con `priv_export` del grupo
- Descarga de archivos: `_lib/file/doc/` bajo estructura `[generacion]/[login]/`, requiere sesion
- Recuperacion de contrasena: envia al email registrado, no expone datos
- Impresion: controlada por `priv_print` del grupo

**Referencia de anexo:** Anexo B; Anexo E [evidencia operativa F9]

---

### D2. No existen IDOR ciegos
**Estado:** Cumple

**Control implementado:**
Acciones secundarias (correos, generacion de archivos, cambios de estado) operan sobre datos del usuario autenticado usando `[usr_email]` y variables globales de sesion.

**Referencia de anexo:** Anexo B (codigo eventos)

---

## E. Operacion y monitoreo

### E1. Rate limiting en endpoints sensibles
**Estado:** Cumple

**Situacion:** regla de rate limiting aplicada en servidor para rutas de login.
**Referencia de anexo:** Anexo G + Anexo H + `99_Referencias/rate_limit_login_apache.conf`

---

### E2. Registro de accesos no autorizados
**Estado:** Cumple

**Mecanismo:**
Tabla `sc_log` con campos: `inserted_date`, `username`, `application`, `creator`, `ip_user`, `action`, `description`.

**Estadisticas:**
- login: 65,563 | login Fail: 11,651 | access: 1,176,884 | update: 40,563 | insert: 13,441 | delete: 1,145 | Retrieve Password: 2,160 | Change Password: 84

**Referencia de anexo:** Anexo F (extractos sc_log)

---

### E3. Alertas por patrones de enumeracion o acceso anomalo
**Estado:** Cumple

**Situacion:** script de monitoreo + cron operativo en servidor, con evidencia de ejecucion.
**Referencia de anexo:** Anexo H + `99_Referencias/alertas_sc_log.sh` + `04_Anexos/EVIDENCIAS/alertas_sc_log_runtime.log`

---

### E4. Procedimiento de rotacion de credenciales
**Estado:** Cumple

**Mecanismos:**
- `app_change_pswd`: cambio voluntario (84 registros en sc_log)
- `app_retrieve_pswd`: recuperacion por email (2,160 registros)
- Reset administrativo via panel

**Referencia de anexo:** Anexo E [evidencia operativa F7]; Anexo F (registros Change Password)

---

## F. Superficie de exposicion

### F1. Inventario de sistemas expuestos a Internet
**Estado:** Cumple

| URL | Responsable | Datos | Criticidad | Estado |
|-----|-------------|-------|------------|--------|
| https://posgrados.inecol.mx/sce/ | Sec. Posgrado | Datos academicos, pagos, expedientes | Alto | Activo |

**Referencia de anexo:** Anexo C

---

### F2. Servicios no necesarios fueron retirados, deshabilitados o aislados
**Estado:** Cumple

**Estado final:** respaldos retirados/aislados fuera de `htdocs` y sin exposicion publica.
**Referencia de anexo:** Anexo C (A/B/C) + Acta de gobernanza

---

### F3. Servicios restringen acceso a redes autorizadas
**Estado:** Cumple

**Mecanismos activos:**
- HTTPS obligatorio (Redirect permanent en VirtualHost)
- Certificado SSL valido para posgrados.inecol.mx
- Acceso publico justificado: aspirantes, estudiantes y academicos acceden desde ubicaciones externas

**Referencia de anexo:** Anexo G (configuracion SSL/Apache); Anexo E [evidencia operativa F10]
