# Guia de presentacion - Paquete ATDT IDOR/BOLA

## Objetivo

Presentar un paquete unico, verificable y trazable donde cada requerimiento ATDT tenga:

1. control implementado,
2. prueba ejecutada,
3. evidencia adjunta,
4. referencia exacta a anexo.

## Estructura recomendada de envio

### Documento 1 - Portada ejecutiva

- Archivo: `/opt/sce_asp_scriptcase/seguridad/ATDT_PORTADA_EJECUTIVA_IDOR.md`
- Uso: resumen para directivos y para oficio de remision.

### Documento 2 - Informe principal

- Archivo base: `/opt/sce_asp_scriptcase/seguridad/INFORME_CUMPLIMIENTO_IDOR_PLANTILLA.md`
- Uso: cuerpo tecnico oficial (tabla 12 requerimientos + checklist A-F por sistema).

### Documento 3 - Mapeo de requerimientos a evidencia

- Archivo: `/opt/sce_asp_scriptcase/seguridad/ATDT_MAPEO_12_REQUERIMIENTOS_IDOR.md`
- Uso: trazabilidad de cumplimiento por cada requerimiento.

### Documento 4 - Indice y control de anexos

- Archivo: `/opt/sce_asp_scriptcase/seguridad/ATDT_INDICE_ANEXOS_EVIDENCIA_IDOR.md`
- Uso: control documental de capturas, logs, matrices y configuraciones.

### Documento 5 - Plan de accion y cierre

- Archivo: `/opt/sce_asp_scriptcase/seguridad/ATDT_ACTA_PLAN_ACCION_IDOR.md`
- Uso: compromisos para items en proceso/no cumple.

## Secuencia de presentacion sugerida (en reunion o entrega formal)

1. Contexto y alcance (2-3 min)
2. Estado global por sistema (tabla ejecutiva)
3. Matriz de 12 requerimientos (cumple/en proceso/no cumple)
4. Evidencia clave por riesgo alto (A3, A4, E1, E3, C2)
5. Plan de cierre con fechas y responsables
6. Confirmacion de anexos y version del paquete

## Estandar minimo de evidencia

- Pruebas de autorizacion:
  - caso positivo (permitido) y caso negativo (denegado),
  - solicitud/respuesta,
  - resultado esperado vs real.
- Codigo/arquitectura:
  - punto central de autorizacion y regla por objeto.
- Operacion:
  - extractos de logs de denegacion,
  - evidencia de alertamiento o plan documentado.
- Gestion:
  - inventario de exposicion y controles de red,
  - procedimiento de rotacion de credenciales.

## Criterios de calidad previos al envio

- Trazabilidad completa: cada afirmacion del informe tiene anexo de respaldo.
- Consistencia documental: estados iguales entre:
  - tabla 12 requerimientos,
  - checklist A-F,
  - plan de accion.
- Pendientes cerrables: todo item en proceso/no cumple tiene:
  - responsable,
  - fecha compromiso,
  - criterio de cierre,
  - evidencia esperada.
- Control de version: fecha, version, autor y responsable de emision.

## Referencias base utilizadas

- Requerimientos ATDT:
  - `/opt/sce_asp_scriptcase/seguridad/tics req/IDOR_02_2026.md`
- Checklist obligatorio:
  - `/opt/sce_asp_scriptcase/seguridad/tics req/Checklist_obligatorio_IDOR.md`
- Plantilla central de informe:
  - `/opt/sce_asp_scriptcase/seguridad/INFORME_CUMPLIMIENTO_IDOR_PLANTILLA.md`

