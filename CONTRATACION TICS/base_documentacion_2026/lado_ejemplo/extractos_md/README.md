# Extracción Markdown (estructura plana)

Los `.md` están **directamente en esta carpeta**. Las imágenes extraídas del Word están en **`media/`**, con nombre único:

`<nombre_del_docx>__imageN.ext`

Ejemplo: `media/04_Anexo_Diagrama_Conceptual_ATDT_Ejemplo_2025__image1.png`

Las figuras se referencian en Markdown como `![texto alternativo](media/...)`.

## Regenerar

Desde la raíz del repositorio:

```bash
python3 "CONTRATACION TICS/scripts/extraer_docx_a_md_plano.py" "CONTRATACION TICS/documentos_base_ejemplo"
```

El script borra anteriores `.md` de salida (excepto este `README.md`) y vuelve a crear `media/`.
