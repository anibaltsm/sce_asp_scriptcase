#!/bin/bash
# Compara número de registros (COUNT(*)) por tabla entre BD sce en Windows y Linux.
# Uso: ./comparar_registros_win_lin.sh [archivo_salida]
# Sin argumentos escribe en docs/diferencias_registros_win_lin.txt

set -e
WIN_CMD="/opt/lampp/bin/mysql -h 192.168.2.68 -u monica -p515t3ma5 -N sce"
LIN_CMD="/opt/lampp/bin/mysql -u root -p515t3ma5 -N sce"
SCE_REPO="${SCE_REPO:-/opt/sce_asp_scriptcase}"
OUT="${1:-$SCE_REPO/docs/diferencias_registros_win_lin.txt}"

# Tablas comunes
WIN_TABLES=$(mktemp)
LIN_TABLES=$(mktemp)
$WIN_CMD -e "SHOW TABLES;" 2>/dev/null | sort -u > "$WIN_TABLES"
$LIN_CMD -e "SHOW TABLES;" 2>/dev/null | sort -u > "$LIN_TABLES"
comm -12 "$WIN_TABLES" "$LIN_TABLES" > "${WIN_TABLES}.common"
N=$(wc -l < "${WIN_TABLES}.common")

echo "Comparando COUNT(*) en $N tablas comunes (Windows vs Linux)..."
echo "Puede tardar varios minutos por la latencia a 192.168.2.68."
echo ""

{
  echo "# Diferencias de registros por tabla - sce"
  echo "# Windows: -h 192.168.2.68 -u monica | Linux: localhost root"
  echo "# Generado: $(date -Iseconds)"
  echo ""
  echo "Tabla|Windows|Linux"
  echo "-----|--------|-----"
} > "$OUT"

difs=0
while IFS= read -r t; do
  [ -z "$t" ] && continue
  w=$($WIN_CMD -e "SELECT COUNT(*) FROM \`$t\`;" 2>/dev/null)
  l=$($LIN_CMD -e "SELECT COUNT(*) FROM \`$t\`;" 2>/dev/null)
  if [ "$w" != "$l" ]; then
    echo "${t}|${w}|${l}" >> "$OUT"
    difs=$((difs+1))
  fi
done < "${WIN_TABLES}.common"

rm -f "$WIN_TABLES" "$LIN_TABLES" "${WIN_TABLES}.common"

echo "Total tablas con distinto número de registros: $difs"
echo "Resultado en: $OUT"
