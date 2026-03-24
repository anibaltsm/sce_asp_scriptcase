#!/usr/bin/env bash
set -euo pipefail

usage() {
  cat <<'EOF'
Uso:
  ./convert_md_to_docx.sh [archivo.md ...] [--reference-doc plantilla.docx]

Comportamiento:
  - Sin archivos: convierte todos los *.md del directorio actual.
  - Con archivos: convierte solo los .md indicados.
  - Si existe plantilla.docx y no se pasa --reference-doc, se usa automaticamente.

Variables opcionales:
  RESOURCE_PATHS   Rutas para recursos, separadas por ":".
                   Default: .:img:images:media:04_Anexos:04_Anexos/EVIDENCIAS
  MERMAID_OUTPUT_DIR Carpeta de salida de PNG para bloques mermaid.
                   Default: 04_Anexos/EVIDENCIAS
EOF
}

if [[ "${1:-}" == "-h" || "${1:-}" == "--help" ]]; then
  usage
  exit 0
fi

RESOURCE_PATHS="${RESOURCE_PATHS:-.:img:images:media:04_Anexos:04_Anexos/EVIDENCIAS}"
MERMAID_OUTPUT_DIR="${MERMAID_OUTPUT_DIR:-04_Anexos/EVIDENCIAS}"
REFERENCE_DOC="${REFERENCE_DOC:-}"
declare -a INPUTS=()
TMP_FILES=()

cleanup() {
  for f in "${TMP_FILES[@]:-}"; do
    if [[ -n "$f" && -f "$f" ]]; then
      rm -f "$f"
    fi
  done
  return 0
}
trap cleanup EXIT

while [[ $# -gt 0 ]]; do
  case "$1" in
    --reference-doc)
      if [[ $# -lt 2 ]]; then
        echo "Error: falta ruta despues de --reference-doc" >&2
        exit 1
      fi
      REFERENCE_DOC="$2"
      shift 2
      ;;
    --help|-h)
      usage
      exit 0
      ;;
    *)
      INPUTS+=("$1")
      shift
      ;;
  esac
done

if [[ -z "$REFERENCE_DOC" && -f "plantilla.docx" ]]; then
  REFERENCE_DOC="plantilla.docx"
fi

declare -a FILES=()
if [[ ${#INPUTS[@]} -eq 0 ]]; then
  shopt -s nullglob
  for md in *.md; do
    FILES+=("$md")
  done
  shopt -u nullglob
else
  for md in "${INPUTS[@]}"; do
    if [[ ! -f "$md" ]]; then
      echo "Aviso: no existe '$md' (se omite)." >&2
      continue
    fi
    FILES+=("$md")
  done
fi

if [[ ${#FILES[@]} -eq 0 ]]; then
  echo "No hay archivos Markdown para convertir."
  exit 0
fi

echo "Resource path: $RESOURCE_PATHS"
echo "Mermaid output: $MERMAID_OUTPUT_DIR"
if [[ -n "$REFERENCE_DOC" ]]; then
  echo "Plantilla de referencia: $REFERENCE_DOC"
fi

# Convierte:
# 1) etiquetas HTML <img ...> a Markdown
# 2) bloques ```mermaid a imagen PNG + referencia Markdown
convert_markdown_for_docx() {
  local input_file="$1"
  local mermaid_output_dir="$2"
  local tmp_file
  tmp_file="$(mktemp --suffix=.md)"
  TMP_FILES+=("$tmp_file")

  python3 - "$input_file" "$tmp_file" "$mermaid_output_dir" <<'PY'
import re
import shutil
import sys
import subprocess
from pathlib import Path

in_file = Path(sys.argv[1])
out_file = Path(sys.argv[2])
mermaid_output_dir = Path(sys.argv[3])
text = in_file.read_text(encoding="utf-8")

img_pattern = re.compile(r'<img\b[^>]*>', re.IGNORECASE)
attr_pattern = re.compile(r'([a-zA-Z_:][\w:.-]*)\s*=\s*"([^"]*)"')
mermaid_block_pattern = re.compile(r"```mermaid\s*\n(.*?)\n```", re.DOTALL | re.IGNORECASE)
warnings = []

def repl(match):
    tag = match.group(0)
    attrs = {k.lower(): v for k, v in attr_pattern.findall(tag)}
    src = attrs.get("src", "").strip()
    if not src:
        return tag
    alt = attrs.get("alt", "").strip()
    width = attrs.get("width", "").strip()

    md = f"![{alt}]({src})"
    if width:
      if width.isdigit():
          md += f"{{width={width}px}}"
      else:
          md += f"{{width={width}}}"
    return md

converted = img_pattern.sub(repl, text)

has_mermaid = bool(mermaid_block_pattern.search(converted))
can_render_mermaid = shutil.which("mmdc") is not None or shutil.which("npx") is not None
if has_mermaid:
    mermaid_output_dir.mkdir(parents=True, exist_ok=True)

def render_mermaid_to_png(mermaid_code: str, image_path: Path) -> bool:
    tmp_mmd = image_path.with_suffix(".mmd")
    tmp_mmd.write_text(mermaid_code, encoding="utf-8")
    try:
        if shutil.which("mmdc"):
            cmd = ["mmdc", "-i", str(tmp_mmd), "-o", str(image_path)]
        else:
            cmd = ["npx", "-y", "@mermaid-js/mermaid-cli", "-i", str(tmp_mmd), "-o", str(image_path)]
        subprocess.run(cmd, check=True, capture_output=True, text=True)
        return True
    except Exception as exc:
        warnings.append(f"No se pudo renderizar Mermaid en '{image_path.name}': {exc}")
        return False
    finally:
        if tmp_mmd.exists():
            tmp_mmd.unlink()

counter = 0
base_name = re.sub(r"[^A-Za-z0-9_-]+", "_", in_file.stem).strip("_") or "documento"

def mermaid_repl(match):
    global counter
    mermaid_code = match.group(1).strip()
    if not can_render_mermaid:
        warnings.append("Se detecto bloque mermaid, pero no existe 'mmdc' ni 'npx'. Se deja el bloque sin renderizar.")
        return match.group(0)

    counter += 1
    image_name = f"MERMAID_{base_name}_{counter:02d}.png"
    image_path = mermaid_output_dir / image_name
    ok = render_mermaid_to_png(mermaid_code + "\n", image_path)
    if not ok:
        return match.group(0)

    # Ruta relativa desde el directorio del Markdown original
    rel_path = image_path.as_posix()
    return f"![Diagrama Mermaid {counter}]({rel_path})"

converted = mermaid_block_pattern.sub(mermaid_repl, converted)
out_file.write_text(converted, encoding="utf-8")

for w in warnings:
    print(f"[WARN] {w}", file=sys.stderr)
PY

  printf '%s\n' "$tmp_file"
}

for md in "${FILES[@]}"; do
  docx="${md%.md}.docx"
  tmp_md="$(convert_markdown_for_docx "$md" "$MERMAID_OUTPUT_DIR")"
  cmd=(pandoc -f markdown "$tmp_md" --resource-path="$RESOURCE_PATHS" -o "$docx")
  if [[ -n "$REFERENCE_DOC" ]]; then
    cmd+=(--reference-doc="$REFERENCE_DOC")
  fi

  echo "Convirtiendo '$md' -> '$docx'..."
  "${cmd[@]}"
done

echo "Conversion completada."
