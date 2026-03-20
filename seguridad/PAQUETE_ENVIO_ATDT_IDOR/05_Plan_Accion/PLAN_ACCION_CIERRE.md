# Plan de accion y cierre — IDOR/BOLA ATDT

**Fecha de elaboracion:** Marzo 2026
**Sistemas:** SCE, SCE_ASP, SCE_ENBC

## Acciones pendientes

### Accion 1: Consolidar alcance de modulos activos
- **Prioridad:** Alta
- **Detalle:** Confirmar y documentar que solo se evaluan modulos activos en produccion.
- **Responsable:** [NOMBRE]
- **Cierre esperado:** Inventario firmado y publicado en Anexo C.

### Accion 2: Configurar rate limiting en login
- **Prioridad:** Alta
- **Detalle:** Aplicar reglas de limitacion para rutas de login en los 3 sistemas.
- **Responsable:** [NOMBRE]
- **Cierre esperado:** Configuracion aplicada + evidencia de bloqueo por exceso de intentos.

### Accion 3: Activar alertas operativas sobre sc_log
- **Prioridad:** Alta
- **Detalle:** Script/cron para detectar picos de login fail y accesos anomalo.
- **Responsable:** [NOMBRE]
- **Cierre esperado:** Evidencia de alertas de prueba.

### Accion 4: Retirar respaldos expuestos por URL
- **Prioridad:** Media
- **Detalle:** Mover/bloquear respaldos fuera de htdocs. Estado: SCE, SCE_ASP y SCE_ENBC ya movidos a carpeta de respaldo por sistema.
- **Responsable:** [NOMBRE]
- **Cierre esperado:** 403/404 en rutas de respaldo y/o evidencia de movimiento a carpeta de resguardo fuera de htdocs.

### Accion 5: Cerrar evidencia operativa minima
- **Prioridad:** Media
- **Detalle:** Integrar capturas minimas requeridas en Anexo E.
- **Responsable:** responsable operativo
- **Cierre esperado:** Anexo E completo.

## Registro de avance

| Accion | Fecha inicio | Fecha cierre | Evidencia |
|---|---|---|---|
| 1. Alcance modulos activos | [FECHA] | [FECHA] | Anexo C actualizado |
| 2. Rate limiting | [FECHA] | [FECHA] | Config + prueba |
| 3. Alertas sc_log | [FECHA] | [FECHA] | Script + alerta |
| 4. Retiro de respaldos | [FECHA] | [FECHA] | Capturas 403/404 |
| 5. Evidencia minima | [FECHA] | [FECHA] | Anexo E |
