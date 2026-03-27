# PDF, Word (DOCX) y Markdown — conversión y extracción

Guía para extraer información de **PDF** y **DOCX**, generar **Markdown** limpio, y volver a **DOCX/PDF** cuando haga falta.

## Herramientas recomendadas en este entorno

| Objetivo | Herramienta | Notas |
|----------|-------------|--------|
| PDF → texto plano | `pdftotext` (poppler-utils) | Rápido; pierde estructura compleja. |
| PDF → Markdown aproximado | `pandoc` | Depende del PDF; a veces falla con escaneados. |
| DOCX → Markdown | `pandoc` | Mejor opción; tablas e imágenes con cuidado. |
| Markdown → DOCX | `pandoc` | Muy fiable. |
| Markdown → PDF | `pandoc` (+ LaTeX o motor PDF) | Requiere dependencias extra en el servidor. |
| DOCX → MD plano + imágenes | Script del repo | Ver abajo. |

## PDF a Markdown o texto

### Solo texto (auditoría, búsqueda, pegar en informes)

```bash
pdftotext -layout "entrada.pdf" "salida.txt"
```

Markdown “manual”: pegar el texto en un `.md` y marcar títulos a mano si hace falta.

### Con Pandoc (estructura aproximada)

```bash
pandoc "entrada.pdf" -t gfm -o "salida.md" --wrap=none
```

Si el PDF es **escaneado** (imágenes), hace falta **OCR** (p. ej. `ocrmypdf`, Tesseract); no asumir que `pdftotext` devuelve contenido útil.

## DOCX a Markdown

### Básico (sin extraer imágenes a archivos)

```bash
pandoc "doc.docx" -f docx -t gfm --wrap=none -o "doc.md"
```

### Con imágenes embebidas en carpeta `media/`

```bash
pandoc "doc.docx" -f docx -t gfm --wrap=none \
  --extract-media="./salida_media" -o "doc.md"
```

Pandoc crea `salida_media/media/image1.png`, etc. Revisa rutas en el `.md` (a veces salen absolutas; conviene normalizar a `media/...`).

### Flujo usado en este repo (varios DOCX, nombres únicos, `<img>` → `![]()`)

Script: `CONTRATACION TICS/scripts/extraer_docx_a_md_plano.py`

```bash
python3 "CONTRATACION TICS/scripts/extraer_docx_a_md_plano.py" "/ruta/carpeta_con_docx"
```

Salida: todos los `.md` en `carpeta_con_docx/extractos_md/` y un solo `extractos_md/media/` con archivos `NombreDocx__imageN.ext`.

## Markdown a DOCX

```bash
pandoc "informe.md" -f gfm -o "informe.docx" --standalone
```

Si usas HTML embebido (`<img>`, tablas HTML), Pandoc suele respetarlos razonablemente; para máxima compatibilidad Word, preferir tablas GFM y `![](ruta)`.

Rutas de imágenes: deben ser **accesibles desde el directorio de trabajo** (relativas al `.md` o rutas absolutas).

## Markdown a PDF

Opción típica (si hay LaTeX):

```bash
pandoc "informe.md" -o "informe.pdf" --pdf-engine=xelatex
```

Sin LaTeX, valorar generar **HTML** y luego imprimir a PDF desde navegador, o usar otro motor si está instalado en el servidor.

## Problemas frecuentes

1. **Tablas Word complejas** → Pandoc emite HTML; revisar o convertir a tablas Markdown a mano.
2. **Misma imagen duplicada en el MD** → Word duplica anclas; el script del repo deduplica líneas `![](...)` repetidas.
3. **PDF sin texto** → OCR obligatorio.
4. **Caracteres raros** → Forzar UTF-8 al guardar el `.md`; en terminal `export LANG=es_MX.UTF-8` si aplica.

## Cuándo pedir ayuda al asistente

- Normalizar rutas `media/` tras Pandoc.
- Pasar tablas HTML a GFM.
- Automatizar lotes de PDF/DOCX en una carpeta del proyecto.
- Integrar salida con plantillas INECOL / ATDT (contratación, seguridad, etc.).
