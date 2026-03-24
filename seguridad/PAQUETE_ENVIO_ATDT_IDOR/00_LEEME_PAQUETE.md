# Paquete de envio ATDT - IDOR/BOLA

Este paquete esta organizado para envio formal y revision tecnica.

## Estructura

- `00_Portada/`
  - portada ejecutiva para oficio/remision.
- `01_Informe_Principal/`
  - informe central de cumplimiento.
- `02_Checklist_por_Sistema/`
  - checklist A-F separado para SCE, SCE_ASP y SCE_ENBC.
- `03_Mapeo_Trazabilidad/`
  - mapeo de 12 requerimientos y cobertura checklist A-F.
- `04_Anexos/`
  - indice y control de evidencias.
- `05_Plan_Accion/`
  - acta de cierre y cronograma de 30 dias habiles.
- `99_Referencias/`
  - referencias tecnicas (ATDT, OWASP, ScriptCase).

## Evidencia operativa

- La evidencia visual y tecnica consolidada se integra directamente en `04_Anexos/EVIDENCIAS/` y en el informe maestro (Anexo E/F/H).

## Orden recomendado de llenado (ya completado)

1. `01_Informe_Principal/INFORME_CUMPLIMIENTO_IDOR.md` — Llenado
2. `02_Checklist_por_Sistema/*.md` — Llenado (3 archivos)
3. `03_Mapeo_Trazabilidad/*.md` — Llenado
4. `04_Anexos/INDICE_ANEXOS_EVIDENCIA.md` — Llenado
5. `05_Plan_Accion/*.md` — Llenado
6. `00_Portada/PORTADA_EJECUTIVA.md` — Llenado

## Regla de calidad antes de enviar

- Cada estado debe tener evidencia asociada.
- Cada evidencia debe tener referencia de anexo.
- Todo item "en proceso" debe tener responsable y fecha compromiso.
- Los 3 sistemas deben quedar cubiertos (SCE, SCE_ASP, SCE_ENBC).

## Fuentes de verdad (orden de prioridad)

1. Evidencia primaria del sistema (fuente oficial):
   - Codigo vigente en ScriptCase (eventos/metodos/seguridad),
   - pruebas ejecutadas (solicitud/respuesta),
   - logs y monitoreo,
   - configuracion de infraestructura (firewall/ACL/VPN/WAF/rate limiting).
2. Requerimientos oficiales ATDT:
   - `tics req/IDOR_02_2026.pdf`
   - `tics req/Checklist_obligatorio_IDOR.pdf`
3. Documentos internos de apoyo (no fuente principal):
   - `EVIDENCIA_*` y analisis historicos.

## Regla de dependencia documental

- El paquete final NO debe depender de `EVIDENCIA_*` como evidencia principal.
- `EVIDENCIA_*` solo se usa como apoyo de redaccion o referencia interna.
- Toda afirmacion del informe debe poder verificarse contra evidencia primaria en anexos.

