# Plan de accion y cierre — IDOR/BOLA ATDT

**Fecha de elaboracion:** Marzo 2026
**Sistemas:** SCE, SCE_ASP, SCE_ENBC

## Acciones de cierre

### Accion 1: Consolidar alcance de modulos activos
- **Prioridad:** Alta
- **Detalle:** Confirmar y documentar que solo se evaluan modulos activos en produccion.
- **Responsable:** [NOMBRE]
- **Estado:** Cumplido (24-mar-2026)
- **Cierre esperado:** Inventario/acta publicado en Anexo C (`ACTA_GOBERNANZA_SUPERFICIE_IDOR.md`).

### Accion 2: Configurar rate limiting en login
- **Prioridad:** Alta
- **Detalle:** Aplicar reglas de limitacion para rutas de login en los 3 sistemas.
- **Responsable:** [NOMBRE]
- **Estado:** Cumplido (aplicado en servidor 24-mar-2026).
- **Cierre esperado:** Include activo de `99_Referencias/rate_limit_login_apache.conf` + evidencia operativa.

### Accion 3: Activar alertas operativas sobre sc_log
- **Prioridad:** Alta
- **Detalle:** Script/cron para detectar picos de login fail y accesos anomalo.
- **Responsable:** [NOMBRE]
- **Estado:** Cumplido (cron activo 24-mar-2026).
- **Cierre esperado:** `99_Referencias/alertas_sc_log.sh` + cron + log de ejecucion.

### Accion 4: Retirar respaldos expuestos por URL
- **Prioridad:** Media
- **Detalle:** Mover/bloquear respaldos fuera de htdocs. Estado: SCE, SCE_ASP y SCE_ENBC ya movidos a carpeta de respaldo por sistema.
- **Responsable:** [NOMBRE]
- **Estado:** Cumplido
- **Cierre esperado:** 403/404 en rutas de respaldo y evidencia de movimiento a carpeta de resguardo fuera de htdocs.

### Accion 5: Cerrar evidencia operativa minima
- **Prioridad:** Media
- **Detalle:** Integrar capturas minimas requeridas en Anexo E.
- **Responsable:** responsable operativo
- **Estado:** Cumplido
- **Cierre esperado:** Anexo E completo.

## Registro de avance

| Accion | Fecha inicio | Fecha cierre | Evidencia |
|---|---|---|---|
| 1. Alcance modulos activos | 20-mar-2026 | 24-mar-2026 | Acta de gobernanza + Anexo C |
| 2. Rate limiting | 24-mar-2026 | 24-mar-2026 | `rate_limit_login_apache.conf` + include activo + Apache reload OK |
| 3. Alertas sc_log | 24-mar-2026 | 24-mar-2026 | `alertas_sc_log.sh` + `/etc/cron.d/idor_sc_log_alertas` + runtime log |
| 4. Retiro de respaldos | 18-mar-2026 | 20-mar-2026 | Capturas 403/404 + C1_A/C1_B |
| 5. Evidencia minima | 20-mar-2026 | 24-mar-2026 | Anexo E completo |
