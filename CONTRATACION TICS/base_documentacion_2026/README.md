# Base para documentacion de contratacion TIC (2026)

Esta carpeta junta el material de **referencia (ejemplos ATDT)** y lo **elaborado en 2025**, para alimentar la documentacion **2026**.

## Archivos principales (un MD por lado)

Para trabajar con la IA o revisar todo en un solo lugar:

| Archivo | Uso |
|---------|-----|
| [**CONSULTA_IA_TODO_EJEMPLO_PLANTILLA_ATDT.md**](CONSULTA_IA_TODO_EJEMPLO_PLANTILLA_ATDT.md) | **Plantilla / ejemplo**: forma, secciones y redaccion tipo ATDT (anexos 01, 02, 03, 04, 14). |
| [**CONSULTA_IA_TODO_DOCUMENTOS_2025.md**](CONSULTA_IA_TODO_DOCUMENTOS_2025.md) | **Tu version 2025**: contenido ya institucional (01, 02, 04, 07, 14). |

Flujo sugerido para **2026**: seguir la **estructura del ejemplo** y trasladar o adaptar texto del archivo **2025** donde aplique; completar huecos que solo aparecen en el ejemplo (p. ej. anexo 03 estudio de mercado si no existe en 2025).

## Estructura de carpetas (copias locales)

| Carpeta | Contenido |
|---------|------------|
| `lado_ejemplo/extractos_md/` | Markdown + `media/` copiados desde `documentos_base_ejemplo/extractos_md/` |
| `lado_2025/extractos_md/` | Markdown + `media/` copiados desde `documentos 2025/extractos_md/` |

## Archivo consolidado historico (opcional)

| Archivo | Nota |
|---------|------|
| `CONSOLIDADO_PARA_2026.md` | Mezcla ejemplo + 2025 en un solo documento con texto dentro de bloques ` ```markdown ` . **Redundante** frente a los dos `CONSULTA_IA_TODO_*` anteriores; conservalo solo si prefieres un unico archivo o como respaldo. |

## Regenerar extractos desde Word

```bash
python3 "CONTRATACION TICS/scripts/extraer_docx_a_md_plano.py" "CONTRATACION TICS/documentos_base_ejemplo"
python3 "CONTRATACION TICS/scripts/extraer_docx_a_md_plano.py" "CONTRATACION TICS/documentos 2025"
```

## Copiar extractos a esta base y regenerar los dos MD completos

```bash
cp -a "CONTRATACION TICS/documentos_base_ejemplo/extractos_md/"* "CONTRATACION TICS/base_documentacion_2026/lado_ejemplo/extractos_md/"
cp -a "CONTRATACION TICS/documentos 2025/extractos_md/"* "CONTRATACION TICS/base_documentacion_2026/lado_2025/extractos_md/"
python3 "CONTRATACION TICS/scripts/regenerar_consulta_ia_base_2026.py"
```

El script `regenerar_consulta_ia_base_2026.py` lee `lado_ejemplo` y `lado_2025`, y vuelve a escribir **CONSULTA_IA_TODO_EJEMPLO_PLANTILLA_ATDT.md** y **CONSULTA_IA_TODO_DOCUMENTOS_2025.md** (lineas *Fuente* apuntan a las rutas canonicas bajo `documentos_base_ejemplo` y `documentos 2025`).

## Salida de trabajo 2026

Los borradores o versiones finales en Markdown pueden vivir en `CONTRATACION TICS/documentacion_2026/md/` (u otro folder que definas para el tramite).
