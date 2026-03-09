#!/bin/bash
# Da permisos para que el deploy de Scriptcase (usuario daemon) pueda copiar
# el tema SCE a producción. Sin esto sale "could not be copied".
# Ejecutar con: sudo bash permisos_deploy_sce_tema.sh

DEST="/opt/lampp/htdocs/sce/_lib/css/SCE"

if [ ! -d "$DEST" ]; then
  echo "Creando $DEST"
  mkdir -p "$DEST"
fi

# Grupo daemon debe poder escribir (775); propietario sigue siendo posgrado
chown posgrado:daemon "$DEST"
chmod 775 "$DEST"
# Archivos dentro también: que daemon pueda sobrescribir al desplegar
find "$DEST" -type d -exec chmod 775 {} \;
find "$DEST" -type f -exec chmod 664 {} \;
find "$DEST" -type d -exec chown posgrado:daemon {} \;
find "$DEST" -type f -exec chown posgrado:daemon {} \;

echo "Listo. $DEST y su contenido son escribibles por el grupo daemon (deploy)."
stat -c "%a %U:%G %n" "$DEST"
