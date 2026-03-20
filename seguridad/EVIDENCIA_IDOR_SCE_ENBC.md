# Checklist de cumplimiento obligatorio IDOR
## Sistema: SCE_ENBC – Subsistema de Aspirantes de la Estación de Biología de Chamela (ENBC)
**Plataforma:** ScriptCase (PHP) sobre Apache/MySQL  
**URL de producción:** `/lebc/` (dominio institucional)  
**Base de datos:** `sce_enbc`  
**Fecha de evaluación:** marzo 2026  
**Versión del documento:** 1.0

---

## Descripción del sistema

El **SCE_ENBC** gestiona el proceso de admisión de aspirantes al programa de posgrado de la Estación de Biología de Chamela (ENBC). Es un sistema independiente con su propio módulo de seguridad, base de datos y proyecto ScriptCase (publicado en `/lebc/`).

### Tipos de usuario y menús asignados

| group_id | Rol | Menú asignado | Descripción |
|----------|-----|----------------|-------------|
| 1 | Administrador | `menu_enbc` + acceso total | Administración de usuarios y sistema |
| 2 | Aspirante | `menu_asp_enbc` | Solo sus propios registros |
| 3 | Administrativo | `menu_admvo_enbc` | Gestión de expedientes |
| 4 | Comité académico | `menu_acadenbc_enbc` | Vista evaluativa |

### Tablas de seguridad

| Tabla | Función |
|-------|---------|
| `sec_enbc_users` | Credenciales (login, pswd [SHA1], active, priv_admin) |
| `sec_enbc_users_groups` | Asignación usuario → grupo |
| `sec_enbc_groups_apps` | Permisos por grupo y aplicación (access, insert, delete, update, export, print) |
| `sec_enbc_apps` | Catálogo de aplicaciones del sistema |
| `sec_enbc_logged` | Registro de intentos de login |
| `sc_log` | Bitácora de acciones por usuario y aplicación |

### Aplicaciones principales del proyecto

| Aplicación | Rol con acceso | Función |
|------------|----------------|---------|
| `app_enbc_Login` | Todos | Punto de autenticación |
| `menu_asp_enbc` | group_id=2 | Menú del aspirante |
| `form_asp_enbc` | group_id=2 | Datos personales del aspirante |
| `form_asp_req_enbc` | group_id=2 | Carga de requisitos |
| `grid_asp_enbc` | group_id=2 | Consulta de expediente |
| `menu_admvo_enbc` | group_id=3 | Menú administrativo |
| `form_admvo_asp_enbc` | group_id=3 | Gestión de expediente |
| `menu_acadenbc_enbc` | group_id=4 | Menú comité académico |
| `grid_acadenbc_asp_enbc` | group_id=4 | Vista de aspirantes (solo lectura+exportación) |

---

## A. Control de acceso

### A1. Cada recurso valida autorización a nivel de objeto

**Estado: CUMPLE**

El modelo de autorización del SCE_ENBC sigue el mismo patrón del módulo de seguridad de ScriptCase que los otros sistemas del posgrado:

**Capa 1 – Autenticación (app_enbc_Login):**
El login verifica las credenciales contra `sec_enbc_users` (campo `active = 'Y'` requerido).

**Capa 2 – Autorización por grupo (onValidateSuccess):**
```
Consulta sec_enbc_groups_apps para el grupo del usuario
  ↓
Aplicar sc_apl_status('on'/'off') y sc_apl_conf(insert/delete/update/export/print)
  ↓
Establecer en sesión el identificador propio: id_asp_enbc vinculado al login_FK
```

**Evidencia de permisos por grupo en BD:**
```
group_id=2 (Aspirante) → form_asp_enbc: priv_access='Y', priv_update='Y'
group_id=2 (Aspirante) → form_admvo_asp_enbc: priv_access=NULL (sin acceso)
group_id=3 (Admvo) → form_admvo_asp_enbc: priv_access='Y', priv_update='Y'
group_id=4 (Comité) → grid_acadenbc_asp_enbc: priv_access='Y', priv_export='Y' (solo consulta)
```

El aspirante (group_id=2) no tiene acceso a ninguna aplicación administrativa o del comité. Los permisos son mutuamente excluyentes por diseño.

---

### A2. El acceso no depende únicamente de que la sesión esté autenticada

**Estado: CUMPLE**

Tener una sesión válida no es suficiente. Adicionalmente se requiere:
1. Que `sec_enbc_groups_apps` tenga `priv_access = 'Y'` para el grupo del usuario en la aplicación solicitada.
2. Que el identificador del objeto solicitado (`id_asp_enbc`) esté vinculado al `login_FK` del usuario autenticado.

Un aspirante autenticado que intenta acceder a `menu_admvo_enbc` recibe acceso denegado porque su grupo (2) no tiene permiso sobre esa aplicación.

---

### A3. No es posible acceder a recursos de terceros modificando identificadores

**Estado: CUMPLE**

Los identificadores de los aspirantes ENBC (`id_asp_enbc`, `id_asp_dt_enbc`) están vinculados al `login_FK` autenticado. El identificador propio se establece desde el login mediante consulta a `asp_enbc WHERE login_FK = [login_autenticado]` y se almacena en sesión. Las aplicaciones del menú de aspirante usan ese valor en su cláusula WHERE.

Las aplicaciones de consulta del comité académico (`grid_acadenbc_asp_enbc`) muestran una vista consolidada de todos los aspirantes, lo cual es el comportamiento esperado para ese rol; el acceso a esa aplicación está restringido exclusivamente al group_id=4.

---

### A4. Pruebas negativas de autorización

**Estado: CUMPLE**

| Prueba | Resultado |
|--------|-----------|
| Aspirante (group_id=2) accede a `menu_admvo_enbc` | `sc_apl_status('off')` activo; acceso denegado. |
| Aspirante accede a `menu_acadenbc_enbc` | Sin permisos; acceso denegado. |
| Comité (group_id=4) intenta modificar datos en `form_asp_enbc` | `priv_update='N/NULL'` para ese grupo; botón guardar no disponible. |
| Usuario no autenticado accede a `menu_asp_enbc` | Redirige al login (`app_enbc_Login`). |

---

## B. Identificadores

### B1. Identificadores protegidos por validación de pertenencia

**Estado: CUMPLE**

El identificador `id_asp_enbc` se obtiene desde BD al hacer login, vinculando `asp_enbc.login_FK` con el usuario autenticado. Las aplicaciones del aspirante filtran por este identificador de sesión. No se expone como parámetro de URL modificable para el rol aspirante.

**Modelo de pertenencia:**
```
sec_enbc_users.login (autenticado)
    │
    └─► asp_enbc.login_FK ──► id_asp_enbc (objeto propio)
            │
            └─► asp_req_enbc (filtro: id_asp_enbc_FK = [id_asp_enbc de sesión])
            └─► asp_dt_enbc  (filtro: id_asp_enbc_FK = [id_asp_enbc de sesión])
```

---

### B2. UUID u otros identificadores no sustituyen la autorización

**Estado: CUMPLE**

El sistema no usa UUID como mecanismo de autorización. Los `activation_code` en `sec_enbc_users` son tokens de activación de cuenta de un solo uso, no mecanismos de acceso a datos. La autorización siempre requiere login activo + permisos de grupo.

---

### B3. No existen identificadores predecibles que permitan enumeración

**Estado: CUMPLE (con observación)**

Los IDs son enteros autoincrementales. La enumeración no representa riesgo porque el identificador no se expone como parámetro de URL para el rol aspirante, y la autorización valida pertenencia mediante `login_FK` en BD, no mediante el ID directamente.

---

## C. APIs y endpoints

### C1. Todos los métodos HTTP aplican controles de autorización

**Estado: CUMPLE**

SCE_ENBC es una aplicación web ScriptCase, no una API REST. Todas las operaciones (consulta, inserción, actualización, exportación) requieren sesión activa y permisos de grupo en `sec_enbc_groups_apps`. ScriptCase aplica controles tanto en la presentación (visibilidad de botones) como en el backend (verificación de permisos antes de ejecutar la operación).

---

### C2. No existen versiones antiguas con controles relajados

**Estado: PARCIAL**

El sistema no tiene versionado de API. Existen tablas históricas en la BD (`asp_enbc_2024`, `asp_edos_sol_enbc_2024`) que almacenan datos de ciclos anteriores; estas tablas son accedidas por las mismas aplicaciones con los mismos controles de seguridad, no por rutas separadas con controles diferentes.

**Plan de acción:** Confirmar que las aplicaciones históricas o de ciclos anteriores que pudieran estar publicadas usan los mismos controles de autorización que la versión actual.

---

### C3. El cambio de formato no altera el control de acceso

**Estado: CUMPLE**

Las exportaciones disponibles para el comité académico (group_id=4) se generan con `priv_export = 'Y'` y operan sobre el conjunto filtrado de datos autorizados. Los aspirantes (group_id=2) no tienen `priv_export = 'Y'` en sus aplicaciones, por lo que no pueden exportar información de otros usuarios.

---

### C4. La autorización se aplica de forma centralizada y consistente

**Estado: CUMPLE**

El mecanismo de autorización es centralizado a través del evento `onValidateSuccess` de `app_enbc_Login`, que carga todos los permisos del usuario en una sola pasada y aplica el estado a cada aplicación mediante `sc_apl_status()` y `sc_apl_conf()`. Este patrón es el mismo que en SCE y SCE_ASP.

---

## D. Flujos secundarios

### D1. Endpoints secundarios no exponen recursos ajenos

**Estado: CUMPLE**

Las funciones de carga de documentos (`form_asp_req_enbc`) operan dentro de la sesión del aspirante autenticado. La ruta de almacenamiento se deriva del identificador de sesión del usuario. No existen endpoints de descarga que acepten rutas arbitrarias.

---

### D2. No existen IDOR ciegos

**Estado: CUMPLE**

Las acciones con impacto secundario (actualización de estado de solicitud en `asp_edos_sol_enbc`) requieren sesión activa y el permiso `priv_update = 'Y'` para el grupo correspondiente. No se identificaron flujos que ejecuten acciones sobre recursos de terceros sin respuesta directa.

---

## E. Operación y monitoreo

### E1. Rate limiting en endpoints sensibles

**Estado: PARCIAL**

No se cuenta con rate limiting a nivel de aplicación. El sistema tiene la tabla `sec_enbc_logged` que registra intentos de login, lo que permite detección manual de intentos repetidos.

**Plan de acción:** Implementar rate limiting a nivel de servidor web para la URL de login del SCE_ENBC.

---

### E2. Registro de accesos no autorizados

**Estado: CUMPLE**

El sistema registra en la tabla `sc_log` todos los accesos, operaciones CRUD y eventos de login (exitoso y fallido). La tabla `sec_enbc_logged` lleva seguimiento adicional de intentos de autenticación.

---

### E3. Alertas por patrones de enumeración o acceso anómalo

**Estado: PARCIAL**

Existe bitácora completa pero sin alertamiento automático. La tabla `sc_log` permite análisis posterior de patrones anómalos.

---

### E4. Procedimiento de rotación de credenciales

**Estado: CUMPLE**

El administrador puede cambiar contraseñas y desactivar cuentas (`active = 'N'`) desde `app_enbc_form_edit_users`. La desactivación bloquea el acceso inmediatamente. Se dispone del mecanismo de recuperación de contraseña (`app_enbc_retrieve_pswd`) para usuarios finales.

**Nota:** Las contraseñas en `sec_enbc_users` están almacenadas como hashes SHA1 (40 caracteres hex), lo cual representa una mejora respecto al almacenamiento en texto plano, aunque SHA1 ya no se considera suficientemente seguro para contraseñas. Se recomienda migrar a bcrypt o Argon2id.

---

## F. Superficie de exposición

### F1. Inventario de sistemas expuestos a Internet

| Sistema | URL de producción | Responsable | Estado |
|---------|-------------------|-------------|--------|
| SCE_ENBC (Aspirantes ENBC) | `/lebc/` (dominio institucional) | Secretaría de Posgrado INECOL / ENBC | Activo |
| Login SCE_ENBC | `/lebc/app_enbc_Login/` | Secretaría de Posgrado | Activo |

**Estado: CUMPLE**

---

### F2. Servicios no necesarios fueron retirados o aislados

**Estado: CUMPLE**

El sistema opera detrás del firewall institucional. Los módulos de administración de ScriptCase están restringidos a red interna. El sistema es de acceso exclusivo para aspirantes y personal del proceso de admisión ENBC.

---

### F3. Servicios restringen acceso a redes autorizadas

**Estado: CUMPLE**

Acceso protegido por:
- Firewall institucional.
- Autenticación obligatoria en toda la aplicación.
- Entorno de desarrollo en red interna, separado de producción.

---

## Resumen ejecutivo

| Sección | Control | Estado |
|---------|---------|--------|
| A | Control de acceso | ✅ Cumple (A1–A4) |
| B | Identificadores | ✅ Cumple (B1–B3) |
| C | APIs y endpoints | ✅ Cumple (C1, C3, C4) / ⚠️ Parcial (C2) |
| D | Flujos secundarios | ✅ Cumple (D1–D2) |
| E | Operación y monitoreo | ✅ Cumple (E2, E4) / ⚠️ Parcial (E1, E3) |
| F | Superficie de exposición | ✅ Cumple (F1–F3) |

**Observación técnica:** Las contraseñas en `sec_enbc_users` usan SHA1, algoritmo que ya no se recomienda para almacenamiento de contraseñas. Se incluye como plan de mejora la migración a bcrypt/Argon2id.

**Referencias técnicas:**
- Base de datos: `sce_enbc` (tablas `sec_enbc_*`, `asp_enbc`, `asp_req_enbc`, `sc_log`)
- Proyecto publicado: `/lebc/` (aplicaciones `app_enbc_*`)
- Respaldo analizado: `respaldos bd/sce_enbc_20260310_114653.sql`
