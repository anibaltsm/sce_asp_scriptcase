---
name: pdf-docx-markdown
description: >-
  Extracts text from PDFs and converts between DOCX and Markdown using pandoc,
  pdftotext, and the project's docx batch script. Use when the user asks to
  convert Word to Markdown or back, extract PDF content to md/txt, embed images
  from docx, or optimize document conversion workflows in this repository.
---

# PDF, DOCX y Markdown

## Prioridad de herramientas

1. **DOCX ↔ MD**: `pandoc` (`-t gfm`, `--wrap=none`). Para DOCX con figuras usar `--extract-media=DIR`.
2. **PDF → texto/md**: `pdftotext -layout` para texto fiable; `pandoc -t gfm` si el PDF es compatible. PDF escaneado requiere OCR (no asumir texto extraíble).
3. **Varios DOCX a MD plano + `media/` con nombres únicos y `![]()`**: ejecutar el script del repo  
   `CONTRATACION TICS/scripts/extraer_docx_a_md_plano.py` sobre la carpeta que contenga los `.docx`.
4. **MD → DOCX**: `pandoc informe.md -f gfm -o informe.docx --standalone` (verificar rutas de imágenes).

## Documentación extendida

Guía detallada y tabla de casos: [skills/herramientas/pdf-docx-markdown.md](../../../skills/herramientas/pdf-docx-markdown.md) (raíz del repositorio).

## Buenas prácticas

- Tras `--extract-media`, comprobar si Pandoc generó rutas absolutas y normalizar a `media/...` si hace falta portabilidad.
- Tablas complejas en Word pueden salir como HTML en el MD; avisar al usuario o convertir a tablas GFM cuando el informe final deba ser limpio.
- No inventar contenido de PDFs: si la extracción está vacía o ilegible, proponer OCR o fuente editable.
