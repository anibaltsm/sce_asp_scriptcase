#!/bin/bash
# Crea la carpeta grp__NM__SCE con enlaces a los CSS de SCE, para que el tema
# "grp__NM__SCE" usado por la app resuelva (la app pide _lib/css/grp__NM__SCE/grp__NM__SCE_*.css).
# Ejecutar con: sudo bash crear_tema_grp_NM_SCE_enlaces.sh
# O desde el directorio del repo: sudo bash scripts/crear_tema_grp_NM_SCE_enlaces.sh

CSS_BASE="${CSS_BASE:-/opt/lampp/htdocs/sce/_lib/css}"
SCE_DIR="$CSS_BASE/SCE"
GRP_DIR="$CSS_BASE/grp__NM__SCE"

if [ ! -d "$SCE_DIR" ]; then
  echo "No existe $SCE_DIR. Crear primero la carpeta SCE (copiando desde Windows si hace falta)."
  exit 1
fi

mkdir -p "$GRP_DIR"
if [ $? -ne 0 ]; then
  echo "No se pudo crear $GRP_DIR (¿ejecutando con sudo?)"
  exit 1
fi

n=0
for f in "$SCE_DIR"/*; do
  [ -f "$f" ] || continue
  base=$(basename "$f")
  # Solo archivos que empiezan por SCE_
  case "$base" in SCE_*)
    dest="$GRP_DIR/grp__NM__$base"
    if [ ! -e "$dest" ]; then
      ln -s "../SCE/$base" "$dest" 2>/dev/null && echo "Enlace: grp__NM__$base -> SCE/$base" && n=$((n+1))
    fi
    ;;
  esac
done

echo "Listo. Enlaces creados: $n"
ls -la "$GRP_DIR" 2>/dev/null | head -10
