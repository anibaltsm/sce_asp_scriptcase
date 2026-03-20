# Checklist obligatorio IDOR - SCE_ENBC

Sistema: SCE_ENBC (Subsistema de Aspirantes ENBC)  
Plataforma: ScriptCase 9 (PHP / Apache / MySQL)  
URL: `https://posgrados.inecol.mx/sce_enbc/`  
Base de datos: `sce_enbc`

> Fuentes para llenado (prioridad):
> 1) Evidencia primaria del sistema (codigo/BD/configuracion/logs).  
> 2) Requerimientos oficiales ATDT.  
> 3) `EVIDENCIA_IDOR_SCE_ENBC.md` solo como apoyo interno.

---

## A. Control de acceso

### A1. Cada recurso valida autorizacion a nivel de objeto
**Estado:** Cumple

Patron ScriptCase por permisos de grupo y validacion de pertenencia por `login_FK`.

### A2. El acceso no depende unicamente de que la sesion este autenticada
**Estado:** Cumple

`sec_enbc_groups_apps` define acceso por rol; apps admin bloqueadas para aspirantes.

### A3. No es posible acceder a recursos de terceros modificando identificadores
**Estado:** Cumple

Aplicaciones evaluadas operan con identidad de sesion.

### A4. Se realizan pruebas negativas de autorizacion
**Estado:** En proceso

Pendiente anexar evidencia operativa minima.

---

## B. Identificadores

### B1. Identificadores directos protegidos por validacion de pertenencia
**Estado:** Cumple

### B2. UUID/hashes no sustituyen autorizacion
**Estado:** Cumple

### B3. Identificadores predecibles o reutilizables
**Estado:** En proceso (observacion)

---

## C. APIs y endpoints

### C1. Todos los metodos HTTP aplican controles de autorizacion
**Estado:** Cumple

### C2. No existen versiones antiguas con controles relajados
**Estado:** En proceso

### C3. El cambio de formato no altera el control de acceso
**Estado:** Cumple

### C4. La autorizacion se aplica de forma centralizada y consistente
**Estado:** Cumple

---

## D. Flujos secundarios

### D1. Endpoints secundarios no exponen recursos ajenos
**Estado:** Cumple

### D2. No existen IDOR ciegos
**Estado:** Cumple

---

## E. Operacion y monitoreo

### E1. Rate limiting en endpoints sensibles
**Estado:** En proceso

### E2. Registro de accesos no autorizados
**Estado:** Cumple (parcial)

### E3. Alertas por patrones de enumeracion o acceso anomalo
**Estado:** En proceso

### E4. Rotacion de credenciales
**Estado:** Cumple

---

## F. Superficie de exposicion

### F1. Inventario de sistemas expuestos a Internet
**Estado:** Cumple

### F2. Servicios no necesarios retirados/aislados
**Estado:** En proceso

### F3. Servicios restringen acceso a redes autorizadas
**Estado:** Cumple (parcial)
