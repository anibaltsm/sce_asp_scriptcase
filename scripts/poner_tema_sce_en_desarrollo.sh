#!/bin/bash
# Pone el tema SCE en los proyectos de DESARROLLO de Scriptcase (SCE, SCE_, SCE_dev)
# para que la generación no dé "El tema grp__NM__SCE utilizado no se encontró".
# Ejecutar con: sudo bash poner_tema_sce_en_desarrollo.sh
#
# El log muestra Cod_Prj=SCE_. o SCE_dev según desde qué proyecto generes;
# por eso aplicamos a todos.

set -e
BASE_APP="/opt/Scriptcase/v9-php81/wwwroot/scriptcase/app"
ORIGEN_SCE="/opt/lampp/htdocs/sce/_lib/css/SCE"
EXTRA_LINES="$(dirname "$0")/schemas_ini_lineas_temas_sce.txt"

# Proyectos que pueden tener app_Login con tema grp__NM__SCE
# (Si generas desde SCE_dev, ese es el que debe tener el tema)
PROYECTOS="SCE SCE_ SCE_dev SCE_2_prueba SCE__"

echo "=== Tema grp__NM__SCE en proyectos de desarrollo Scriptcase ==="

for PROY in $PROYECTOS; do
  DESTINO_CSS="${BASE_APP}/${PROY}/_lib/css"
  SCHEMAS_DEV="${DESTINO_CSS}/schemas.ini"

  [ ! -d "$DESTINO_CSS" ] && continue
  [ ! -f "$SCHEMAS_DEV" ] && continue

  echo ""
  echo "--- Proyecto: $PROY ---"

  # 1. Copiar carpeta SCE si no existe, está vacía o tiene pocos archivos (por si se borró)
  if [ -d "$ORIGEN_SCE" ]; then
    N_ARCHIVOS_ORIG="$(ls -A "$ORIGEN_SCE" 2>/dev/null | wc -l)"
    N_ARCHIVOS_DEST="$(ls -A "$DESTINO_CSS/SCE" 2>/dev/null | wc -l)"
    if [ ! -d "$DESTINO_CSS/SCE" ] || [ "$N_ARCHIVOS_DEST" -eq 0 ] || [ "$N_ARCHIVOS_DEST" -lt 50 ]; then
      echo "  Copiando carpeta SCE (origen: $N_ARCHIVOS_ORIG archivos)..."
      rm -rf "$DESTINO_CSS/SCE"
      cp -r "$ORIGEN_SCE" "$DESTINO_CSS/"
      chown -R daemon:daemon "$DESTINO_CSS/SCE"
      echo "  OK ($(ls -A "$DESTINO_CSS/SCE" 2>/dev/null | wc -l) archivos)."
    else
      echo "  Carpeta SCE ya existe ($N_ARCHIVOS_DEST archivos)."
    fi
  else
    echo "  AVISO: No existe $ORIGEN_SCE (ejecuta antes en producción o copia desde Windows)."
  fi

  # 2. Añadir entradas a schemas.ini si no están
  if grep -q "grp__NM__SCE#" "$SCHEMAS_DEV" 2>/dev/null; then
    echo "  schemas.ini ya tiene grp__NM__SCE."
  else
    echo "  Añadiendo entradas a schemas.ini..."
    if [ -f "$EXTRA_LINES" ]; then
      cat "$EXTRA_LINES" >> "$SCHEMAS_DEV"
    else
      cat >> "$SCHEMAS_DEV" << 'EOF'
SCE#nm#SCE#nm#grp__NM__ico__NM__scriptcase__NM__img__NM__projetos__NM__Posgrado.png
grp__NM__SCE#nm#SCE#nm#grp__NM__ico__NM__scriptcase__NM__img__NM__projetos__NM__Posgrado.png
scriptcase__NM__Green#nm#Sc7_Green#nm#
EOF
    fi
    chown daemon:daemon "$SCHEMAS_DEV"
    echo "  OK."
  fi
done

echo ""
echo "Listo. Genera de nuevo desde Scriptcase (SCE, SCE_ o SCE_dev)."
