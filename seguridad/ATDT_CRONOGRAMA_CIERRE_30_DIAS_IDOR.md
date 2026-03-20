# Cronograma de cierre 30 dias habiles - IDOR/BOLA (ATDT)

## Objetivo

Cerrar de forma controlada los items en proceso/no cumple dentro de la ventana solicitada por ATDT, con responsables por rol, hitos y evidencia de cierre.

## Supuestos de gobernanza

- Dia 0 = fecha de notificacion ATDT.
- Seguimiento semanal (comite tecnico).
- Evidencia obligatoria para cerrar cada hito.

## Responsables por rol

| Rol | Responsabilidad |
|---|---|
| Lider tecnico de seguridad | Coordina plan, valida criterios de cierre y consistencia documental |
| Desarrollador lider ScriptCase | Implementa controles en aplicaciones/eventos y pruebas tecnicas |
| Administrador de infraestructura | Configura rate limiting, ACL, firewall, segmentacion, monitoreo |
| Analista de QA/Seguridad | Ejecuta pruebas negativas y consolida evidencias |
| Responsable institucional de ciberseguridad | Aprueba paquete final y remision ATDT |

## Hitos por semana

| Ventana | Entregable | Responsable principal | Evidencia minima |
|---|---|---|---|
| Dias 1-5 | Congelar alcance y confirmar pendientes oficiales | Lider tecnico de seguridad | Lista de pendientes aprobada + matriz 12 requerimientos actualizada |
| Dias 6-10 | Corregir controles de autorizacion por objeto pendientes | Desarrollador lider ScriptCase | Diff tecnico, evidencia funcional, pruebas de no regresion |
| Dias 11-15 | Ejecutar pruebas negativas IDOR (horizontal/vertical) | Analista de QA/Seguridad | Matriz de pruebas, solicitud/respuesta, resultados 401/403 o politica definida |
| Dias 16-20 | Implementar/reforzar controles de operacion (rate limiting, logs, alertas) | Administrador de infraestructura | Configuracion aplicada, extractos de logs y reglas de monitoreo |
| Dias 21-25 | Consolidar anexos y trazabilidad final | Lider tecnico de seguridad | Indice de anexos completo y validado |
| Dias 26-30 | Revision directiva, firma y remision oficial | Responsable institucional de ciberseguridad | Paquete final firmado y versionado |

## Plan de cierre por control tipico en proceso

| Control | Fecha objetivo | Responsable primario | Dependencias | Criterio de cierre |
|---|---|---|---|---|
| A3 / Req 3 | Dia 10 | Desarrollador lider ScriptCase | Acceso a codigo y despliegue | Solicitudes manipuladas no exponen recursos ajenos |
| A4 / Req 6 | Dia 15 | QA/Seguridad | Ambiente de prueba y cuentas de prueba | Evidencia positiva/negativa firmada por QA |
| C2 / Req 5 | Dia 20 | Lider tecnico + Infra | Inventario de apps/versiones | Inventario vigente y rutas antiguas tratadas |
| E1 / Req 11 | Dia 20 | Infraestructura | Acceso a servidor/WAF | Rate limiting activo y probado |
| E3 / Req 11 | Dia 22 | Infraestructura + Seguridad | Fuente de logs y reglas | Alertas configuradas o mecanismo equivalente documentado |
| E4 / Req 12 | Dia 25 | Seguridad institucional | Procedimiento aprobado | Procedimiento de rotacion publicado y evidencia de prueba |

## Criterio de aceptacion final del paquete

- 100% de requerimientos ATDT con estado y evidencia asociada.
- 100% de controles en proceso con fecha y responsable.
- 0 inconsistencias entre:
  - tabla de 12 requerimientos,
  - checklist A-F por sistema,
  - acta de plan de accion,
  - indice de anexos.

## Control de cambios

| Version | Fecha | Cambio | Responsable |
|---|---|---|---|
| 1.0 | [FECHA] | Emision inicial del cronograma | [NOMBRE] |

