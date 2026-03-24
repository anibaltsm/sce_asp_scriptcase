# Checklist obligatorio IDOR - SCE_ASP

Sistema: SCE_ASP (Subsistema de Aspirantes al Posgrado)  
Plataforma: ScriptCase 9 (PHP / Apache / MySQL)  
URL: `https://posgrados.inecol.mx/sce_asp/`  
Base de datos: `sce_asp`

> Fuentes para llenado (prioridad):
> 1) Evidencia primaria del sistema (codigo vigente, configuracion, logs, pruebas).  
> 2) Requerimientos oficiales ATDT.  
> 3) `EVIDENCIA_IDOR_SCE_ASP.md` solo como referencia interna.

---

## A. Control de acceso

### A1. Cada recurso valida autorizacion a nivel de objeto
**Estado:** Cumple

`sc_validate_success` carga permisos desde `sec_asp_groups_apps`, aplica `sc_apl_status` y `sc_apl_conf`, y vincula identidad por `login_FK` -> `id_asp` en sesion.

**Referencia de anexo:** Anexo B, Anexo D

### A2. El acceso no depende unicamente de que la sesion este autenticada
**Estado:** Cumple

El grupo Aspirante (2) solo tiene acceso a apps autorizadas. Las apps administrativas no tienen `priv_access` para ese grupo.

**Referencia de anexo:** Anexo D, Anexo E (evidencia operativa)

### A3. No es posible acceder a recursos de terceros modificando identificadores
**Estado:** Cumple

Flujos evaluados usan identidad de sesion y relacion por `login_FK`; no se cierra evidencia con parametros del cliente sin validacion.

**Referencia de anexo:** Anexo B

### A4. Se realizan pruebas negativas de autorizacion
**Estado:** Cumple

Evidencia operativa minima integrada: bloqueo por permisos, acceso restringido y trazabilidad en log.

**Referencia de anexo:** Anexo E

---

## B. Identificadores

### B1. Identificadores directos protegidos por validacion de pertenencia
**Estado:** Cumple

Se vincula usuario autenticado con su registro por `login_FK` y sesion de servidor.

### B2. UUID/hashes no sustituyen autorizacion
**Estado:** Cumple

El control es por autorizacion backend y permisos de grupo.

### B3. Identificadores predecibles o reutilizables
**Estado:** Cumple

Se usan IDs secuenciales; mitigados por autenticacion, permisos y validacion de pertenencia.

---

## C. APIs y endpoints

### C1. Todos los metodos HTTP aplican controles de autorizacion
**Estado:** Cumple

ScriptCase aplica controles de aplicacion y permisos por grupo.

### C2. No existen versiones antiguas con controles relajados
**Estado:** Cumple

Respaldos historicos retirados/aislados y con evidencia de no exposicion externa.

### C3. El cambio de formato no altera el control de acceso
**Estado:** Cumple

`sc_apl_conf` mantiene control en exportacion e impresion.

### C4. La autorizacion se aplica de forma centralizada y consistente
**Estado:** Cumple

Punto central en login (`onValidateSuccess` + metodo de permisos).

---

## D. Flujos secundarios

### D1. Endpoints secundarios no exponen recursos ajenos
**Estado:** Cumple

Exportaciones y descargas se condicionan por sesion/permisos.

### D2. No existen IDOR ciegos
**Estado:** Cumple

Acciones secundarias (correo, archivos, actualizaciones) operan con contexto de sesion.

---

## E. Operacion y monitoreo

### E1. Rate limiting en endpoints sensibles
**Estado:** Cumple

Rate limiting operativo aplicado por ruta de login.

### E2. Registro de accesos no autorizados
**Estado:** Cumple

`sc_log` registra login, login fail, access y CRUD.

### E3. Alertas por patrones de enumeracion o acceso anomalo
**Estado:** Cumple

Alertamiento automatizado implementado con script + cron sobre `sc_log`.

### E4. Rotacion de credenciales
**Estado:** Cumple

Apps de cambio y recuperacion de contrasena disponibles.

---

## F. Superficie de exposicion

### F1. Inventario de sistemas expuestos a Internet
**Estado:** Cumple

Sistema inventariado y documentado en paquete.

### F2. Servicios no necesarios retirados/aislados
**Estado:** Cumple

Respaldos historicos retirados/aislados y validados.

### F3. Servicios restringen acceso a redes autorizadas
**Estado:** Cumple

HTTPS activo; acceso publico justificado por operacion de aspirantes.
