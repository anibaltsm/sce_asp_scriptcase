# Base para documentación ATDT 2026

Esta carpeta concentra una **vista comparativa** entre los anexos de **ejemplo (plantilla)** y los anexos **elaborados en 2025**, en un solo Markdown, para usar como punto de partida al armar los entregables **2026**.

## Contenido

| Archivo | Descripción |
|---------|-------------|
| `CONSOLIDADO_EJEMPLO_VS_2025.md` | Texto completo fusionado por número de anexo, con bloques *Ejemplo* y *Versión 2025* cuando ambos existen. |

Las **imágenes no se duplican** aquí: el consolidado enlaza a los PNG en:

- `../documentos_base_ejemplo/extractos_md/media/`
- `../documentos 2025/extractos_md/media/`

## Cobertura

| Anexo | Ejemplo (plantilla) | Versión 2025 |
|-------|---------------------|----------------|
| 01 Justificación | Sí | Sí |
| 02 Técnico | Sí | Sí |
| 03 Estudio de mercado | Sí | No en esta carpeta |
| 04 Diagrama conceptual | Sí | Sí |
| 07 Calendario | No en plantilla ejemplo | Sí |
| 14 CompraNet | Sí | Sí |

## Regenerar el consolidado

Tras actualizar los `.md` en `extractos_md` (por ejemplo volviendo a correr `extraer_docx_a_md_plano.py`):

```bash
python3 "CONTRATACION TICS/scripts/armar_consolidado_ejemplo_vs_2025.py"
```

El script escribe `CONSOLIDADO_EJEMPLO_VS_2025.md` en esta carpeta.

## Fuentes

- Ejemplo: `CONTRATACION TICS/documentos_base_ejemplo/extractos_md/`
- 2025: `CONTRATACION TICS/documentos 2025/extractos_md/`
