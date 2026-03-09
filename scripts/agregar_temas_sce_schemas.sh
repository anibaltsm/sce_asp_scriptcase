#!/bin/bash
# Añade las entradas de tema SCE y Green a schemas.ini de sce.
# Scriptcase SOBRESCRIBE schemas.ini en cada publicación, por eso hay que ejecutar
# este script DESPUÉS DE CADA PUBLISH del proyecto sce.
#
# Uso: sudo bash agregar_temas_sce_schemas.sh

SCHEMAS="/opt/lampp/htdocs/sce/_lib/css/schemas.ini"
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
EXTRA_LINES="${SCRIPT_DIR}/schemas_ini_lineas_temas_sce.txt"

if [ ! -f "$SCHEMAS" ]; then
  echo "No existe $SCHEMAS"
  exit 1
fi

if grep -q "grp__NM__SCE#" "$SCHEMAS" 2>/dev/null; then
  echo "Las entradas ya existen en schemas.ini. Nada que hacer."
  exit 0
fi

if [ -f "$EXTRA_LINES" ]; then
  echo "Añadiendo entradas de tema desde $EXTRA_LINES"
  cat "$EXTRA_LINES" >> "$SCHEMAS"
else
  echo "Añadiendo entradas de tema (inline)"
  cat >> "$SCHEMAS" << 'EOF'
SCE#nm#SCE#nm#grp__NM__ico__NM__scriptcase__NM__img__NM__projetos__NM__Posgrado.png
grp__NM__SCE#nm#SCE#nm#grp__NM__ico__NM__scriptcase__NM__img__NM__projetos__NM__Posgrado.png
scriptcase__NM__Green#nm#Sc7_Green#nm#
EOF
fi
echo "Listo. Temas: SCE, grp__NM__SCE, scriptcase__NM__Green -> Sc7_Green"
tail -5 "$SCHEMAS"
