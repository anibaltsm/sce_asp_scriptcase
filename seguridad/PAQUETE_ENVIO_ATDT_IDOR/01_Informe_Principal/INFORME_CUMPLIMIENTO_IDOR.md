# Informe de cumplimiento IDOR / BOLA
## OWASP A01: Broken Access Control — Respuesta institucional

**Institucion:** Instituto de Ecologia, A.C. (INECOL)  
**Responsable:** Secretaria de Posgrado  
**Responsable Institucional de Ciberseguridad:** [NOMBRE]  
**Sistemas evaluados:** SCE, SCE_ASP, SCE_ENBC  
**Fecha de elaboracion:** Marzo 2026  
**Oficio de referencia:** ATDT – Direccion General de Ciberseguridad (febrero 2026)

---

## PARTE I — Estado de 12 requerimientos ATDT

| # | Requerimiento | SCE | SCE_ASP | SCE_ENBC | Evidencia principal |
|---|---|---|---|---|---|
| 1 | Control de acceso a nivel de objeto | Cumple | Cumple | Cumple | Login central + permisos por grupo |
| 2 | Revision de servicios expuestos | Cumple | Cumple | Cumple | Inventario de URLs y apps activas |
| 3 | Validacion explicita de autorizacion por solicitud | Cumple | Cumple | Cumple | Vinculo por `login_FK` y sesion |
| 4 | Autorizacion independiente de autenticacion | Cumple | Cumple | Cumple | `sc_apl_status` / `sc_apl_conf` |
| 5 | Controles uniformes en endpoints/metodos/versiones | Cumple | Cumple | Cumple | Config uniforme en ScriptCase |
| 6 | Pruebas negativas de acceso no autorizado | Cumple | Cumple | Cumple | Evidencia operativa minima |
| 7 | Evitar referencias directas inseguras | Cumple | Cumple | Cumple | Validacion de pertenencia |
| 8 | Control centralizado y reutilizable | Cumple | Cumple | Cumple | Punto unico de autorizacion |
| 9 | Retiro/aislamiento de servicios innecesarios | Cumple | Cumple | Cumple | Evidencia de retiro/aislamiento y acta de gobernanza |
| 10 | Control en consulta/modificacion/descarga/eliminacion | Cumple | Cumple | Cumple | CRUD/export por permisos |
| 11 | Monitoreo de accesos anomalos | Cumple | Cumple | Cumple | `sc_log` + script de alertas + cron operativo |
| 12 | Rotacion de credenciales | Cumple | Cumple | Cumple | `app_change_pswd`/`app_retrieve_pswd` |

---

## PARTE II — Resumen tecnico por sistema

### SCE
- Seguridad por grupos con `sec_groups_apps` y `sec_users_groups`.
- Carga central de permisos en `onValidateSuccess`.
- Trazabilidad de eventos en `sc_log`.

### SCE_ASP
- Seguridad por grupos con `sec_asp_groups_apps` y `sec_asp_users_groups`.
- Carga central de permisos en `sc_validate_success`.
- Vinculacion de identidad por `login_FK` + sesion.

### SCE_ENBC
- Seguridad por grupos con `sec_enbc_groups_apps` y `sec_enbc_users_groups`.
- Mismo patron de autorizacion de ScriptCase.
- Evidencia primaria basada en BD/configuracion y validacion operativa.

---

## PARTE III — Evidencia primaria requerida

1. **Codigo y configuracion de autorizacion (Anexo B)**
   - `onValidateSuccess` / `sc_validate_success`
   - Uso de `sc_apl_status` y `sc_apl_conf`
2. **Estructura de tablas de seguridad (Anexo D)**
   - `sec_*_users`, `sec_*_groups`, `sec_*_groups_apps`, `sec_*_users_groups`
3. **Bitacora operativa (Anexo F)**
   - resumen por accion (`login`, `login Fail`, `access`, CRUD)
4. **Configuracion de infraestructura (Anexo G)**
   - HTTPS activo y configuracion Apache relevante
5. **Evidencia operativa minima (Anexo E)**
   - Bloqueo por permisos en los 3 sistemas
   - Login fallido con registro en `sc_log`
   - HTTPS activo

---

## PARTE IV — Plan de cierre

Pendientes principales:
- Sin pendientes tecnicos criticos para los 12 requerimientos ATDT.

Ver detalle en: `05_Plan_Accion/PLAN_ACCION_CIERRE.md`.

---

## Firmas

| Rol | Nombre | Firma | Fecha |
|---|---|---|---|
| Responsable tecnico | [NOMBRE] |  | [FECHA] |
| Responsable Institucional de Ciberseguridad | [NOMBRE] |  | [FECHA] |
| Titular / enlace ATDT | [NOMBRE] |  | [FECHA] |
