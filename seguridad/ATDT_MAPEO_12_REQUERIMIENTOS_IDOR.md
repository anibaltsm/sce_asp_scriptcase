# Mapeo de 12 requerimientos ATDT a evidencia concreta

## Uso

Este documento es la matriz de trazabilidad central. Para cada requerimiento:

1. define estado por sistema,
2. referencia seccion tecnica,
3. referencia anexo,
4. identifica pendiente (si aplica).

## Matriz de trazabilidad

| Req | Requerimiento ATDT | Evidencia minima esperada | Fuente tecnica principal | Anexo sugerido | SCE | SCE_ASP | SCE_ENBC | Brecha / accion |
|---|---|---|---|---|---|---|---|---|
| 1 | Control de acceso a nivel de objeto | Descripcion/diagrama de autorizacion por objeto | `INFORME_CUMPLIMIENTO_IDOR_PLANTILLA.md` Parte II A1 | A/B/C/D | [ESTADO] | [ESTADO] | [ESTADO] | [ACCION] |
| 2 | Revision de servicios expuestos | Inventario de sistemas, URLs y criticidad | Parte II F1 + F2 + F3 | G | [ESTADO] | [ESTADO] | [ESTADO] | [ACCION] |
| 3 | Validacion explicita de autorizacion por solicitud | Ownership check + logica de autorizacion | Parte II A1 + A3 | E | [ESTADO] | [ESTADO] | [ESTADO] | [ACCION] |
| 4 | Autorizacion independiente de autenticacion | Modelo roles/permisos/ACL backend | Parte II A2 + B1 + C4 | B/C/D | [ESTADO] | [ESTADO] | [ESTADO] | [ACCION] |
| 5 | Controles uniformes en endpoints/metodos/versiones | Matriz endpoint x control | Parte II C1 + C2 + C4 | E | [ESTADO] | [ESTADO] | [ESTADO] | [ACCION] |
| 6 | Pruebas de acceso no autorizado (401/403) | Capturas/reporte de pruebas negativas | Parte II A4 + C1 | E | [ESTADO] | [ESTADO] | [ESTADO] | [ACCION] |
| 7 | No exponer referencias directas sin autorizacion | Revision de parametros sensibles y controles previos | Parte II A3 + B1 + B3 | E | [ESTADO] | [ESTADO] | [ESTADO] | [ACCION] |
| 8 | Controles centralizados y reutilizables | Arquitectura de autorizacion central | Parte II C4 | B/C/D | [ESTADO] | [ESTADO] | [ESTADO] | [ACCION] |
| 9 | Retirar/deshabilitar/aislar servicios sin exposicion necesaria | Evidencia de red y deshabilitacion | Parte II F2 + F3 | G | [ESTADO] | [ESTADO] | [ESTADO] | [ACCION] |
| 10 | Controles en consulta/modificacion/descarga/eliminacion | Pruebas por operacion y bitacora | Parte II C1 + C3 + D1 | E/F | [ESTADO] | [ESTADO] | [ESTADO] | [ACCION] |
| 11 | Monitoreo de accesos anomalos/enumeracion | Logs + alertas + reglas SIEM | Parte II E2 + E3 | F | [ESTADO] | [ESTADO] | [ESTADO] | [ACCION] |
| 12 | Rotacion/restablecimiento de credenciales/tokens/llaves | Procedimiento y bitacora de cambios | Parte II E4 | H | [ESTADO] | [ESTADO] | [ESTADO] | [ACCION] |

## Criterio para marcar estado

- Cumple:
  - Control implementado y probado,
  - evidencia adjunta y verificable.
- En proceso:
  - control parcial o pendiente tecnico,
  - fecha compromiso y responsable definidos.
- No cumple:
  - control no implementado,
  - plan de remediacion obligatorio.

## Regla de trazabilidad obligatoria

Cada fila debe poder responder estas 4 preguntas sin ambiguedad:

1. Que control existe?
2. Como se probo?
3. Donde esta la evidencia?
4. Que falta y cuando cierra?

