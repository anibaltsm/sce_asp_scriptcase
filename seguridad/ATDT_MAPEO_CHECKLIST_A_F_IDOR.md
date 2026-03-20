# Mapeo checklist A-F a requerimientos ATDT (uso operativo)

## Objetivo

Asegurar que el llenado del checklist por sistema cubra explicitamente la tabla de 12 requerimientos institucionales.

## Mapeo de cobertura

| Checklist | Control | Requerimiento(s) ATDT relacionado(s) | Evidencia principal requerida |
|---|---|---|---|
| A1 | Autorizacion por objeto | 1, 3, 4 | Logica de autorizacion, diagrama de flujo, ownership check |
| A2 | No depende solo de sesion autenticada | 3, 4 | Pruebas negativas y denegacion de acceso |
| A3 | No acceso a terceros por manipulacion de IDs | 3, 6, 7 | Pruebas de manipulacion y resultados |
| A4 | Pruebas negativas IDOR | 6 | Capturas solicitud/respuesta y bitacoras |
| B1 | IDs protegidos por pertenencia | 3, 7 | Reglas de validacion de pertenencia |
| B2 | UUID/hash no sustituyen autorizacion | 3, 7 | Pruebas con IDs validos no autorizados |
| B3 | IDs no predecibles/reutilizables | 7 | Esquema de identificadores y mitigaciones |
| C1 | Controles en todos los metodos HTTP | 5, 10 | Matriz endpoint/metodo/control |
| C2 | Sin versiones antiguas relajadas | 5 | Inventario de versiones y estado |
| C3 | Formato no altera autorizacion | 10 | Pruebas de exportacion/formato |
| C4 | Autorizacion centralizada | 8 | Arquitectura y componente comun |
| D1 | Flujos secundarios no exponen recursos ajenos | 10 | Revision de exportacion/notificacion/recuperacion |
| D2 | No IDOR ciegos | 6, 10 | Pruebas de impactos secundarios |
| E1 | Rate limiting | 11 | Configuracion de rate limiting/WAF |
| E2 | Registro de accesos no autorizados | 11 | Extractos de logs y politica de registro |
| E3 | Alertas por enumeracion/acceso anomalo | 11 | Reglas SIEM/alertas/reportes |
| E4 | Rotacion de credenciales | 12 | Procedimiento y bitacora de cambios |
| F1 | Inventario de expuestos | 2 | Inventario de activos y URLs |
| F2 | Retiro/aislamiento de servicios no necesarios | 9 | Evidencia de deshabilitacion/reglas de red |
| F3 | Restriccion a redes autorizadas | 9 | ACL/VPN/allowlist/diagrama de red |

## Referencias documentales del paquete

- Portada ejecutiva:
  - `/opt/sce_asp_scriptcase/seguridad/ATDT_PORTADA_EJECUTIVA_IDOR.md`
- Informe principal:
  - `/opt/sce_asp_scriptcase/seguridad/INFORME_CUMPLIMIENTO_IDOR_PLANTILLA.md`
- Mapeo 12 requerimientos:
  - `/opt/sce_asp_scriptcase/seguridad/ATDT_MAPEO_12_REQUERIMIENTOS_IDOR.md`
- Indice de anexos:
  - `/opt/sce_asp_scriptcase/seguridad/ATDT_INDICE_ANEXOS_EVIDENCIA_IDOR.md`
- Plan de accion:
  - `/opt/sce_asp_scriptcase/seguridad/ATDT_ACTA_PLAN_ACCION_IDOR.md`

## Regla operativa de llenado

Para cada sistema (SCE, SCE_ASP, SCE_ENBC):

1. Llenar checklist A-F.
2. Pasar estados a tabla de 12 requerimientos.
3. Asociar anexo por control.
4. Si estado != Cumple, registrar accion en plan de cierre.

