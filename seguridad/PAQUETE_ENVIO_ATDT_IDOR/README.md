# Conversión Markdown a Word con Pandoc

Este paquete incluye un flujo en Linux para convertir archivos `.md` a `.docx` con imagenes incrustadas.
El script transforma automaticamente etiquetas HTML `<img ...>` y bloques Mermaid (```mermaid) para que Pandoc no los omita en Word.

## 1) Instalar Pandoc

Verifica si ya esta instalado:

```bash
pandoc --version
```

Si no esta instalado:

- Debian/Ubuntu:

```bash
sudo apt update
sudo apt install -y pandoc
```

- Fedora/CentOS/RHEL:

```bash
sudo dnf install -y pandoc
# o: sudo yum install -y pandoc
```

## 2) Script incluido

Archivo: `convert_md_to_docx.sh`

Dar permisos:

```bash
chmod +x convert_md_to_docx.sh
```

Uso general (convierte todos los `.md` de la carpeta actual):

```bash
./convert_md_to_docx.sh
```

Uso para un archivo especifico:

```bash
./convert_md_to_docx.sh INFORME_MAESTRO_ATDT_IDOR_PARA_WORD.md
```

Uso con plantilla de Word:

```bash
./convert_md_to_docx.sh INFORME_MAESTRO_ATDT_IDOR_PARA_WORD.md --reference-doc plantilla.docx
```

Si el Markdown contiene Mermaid, el script genera PNG en `04_Anexos/EVIDENCIAS` y los inserta automaticamente.
Requisito para Mermaid: tener `npx` (Node.js) o `mmdc` disponible.

## 3) Rutas de imagenes (`--resource-path`)

El script usa por defecto:

```text
.:img:images:media:04_Anexos:04_Anexos/EVIDENCIAS
```

Puedes sobreescribirlo con variable de entorno:

```bash
RESOURCE_PATHS=".:04_Anexos/EVIDENCIAS" ./convert_md_to_docx.sh INFORME_MAESTRO_ATDT_IDOR_PARA_WORD.md
```

Carpeta de salida de PNG Mermaid (opcional):

```bash
MERMAID_OUTPUT_DIR="04_Anexos/EVIDENCIAS" ./convert_md_to_docx.sh INFORME_MAESTRO_ATDT_IDOR_PARA_WORD.md
```

## 4) Comando directo equivalente

```bash
pandoc INFORME_MAESTRO_ATDT_IDOR_PARA_WORD.md \
  --resource-path=".:04_Anexos:04_Anexos/EVIDENCIAS" \
  -o INFORME_MAESTRO_ATDT_IDOR_PARA_WORD.docx
```

## 5) Verificación rapida

1. Abre el `.docx` generado.
2. Confirma que encabezados, listas, tablas y bloques de codigo se ven correctos.
3. Verifica que las capturas del bloque `04_Anexos/EVIDENCIAS` aparezcan incrustadas.

Si una imagen no aparece, revisa:

- Que exista en disco.
- Que el `src` en el Markdown sea relativo y correcto.
- Que su carpeta este incluida en `RESOURCE_PATHS`.
