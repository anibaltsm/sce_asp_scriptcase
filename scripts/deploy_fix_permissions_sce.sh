#!/bin/bash
# Ajusta permisos en /opt/lampp/htdocs/sce para que el Publish Wizard (usuario daemon) pueda escribir
# y el servidor web pueda servir la app. Ejecutar con: sudo bash deploy_fix_permissions_sce.sh

set -e
SCE_DIR="/opt/lampp/htdocs/sce"

echo "=== Ajustando permisos en $SCE_DIR ==="
[ ! -d "$SCE_DIR" ] && echo "ERROR: No existe $SCE_DIR" && exit 1

# Propietario y grupo (daemon debe poder escribir)
chown -R posgrado:daemon "$SCE_DIR"
# Directorios: 775
find "$SCE_DIR" -type d -exec chmod 775 {} \;
# Archivos: 664
find "$SCE_DIR" -type f -exec chmod 664 {} \;

echo "Permisos aplicados."
echo ""
echo "=== Comprobando con curl (localhost) ==="
# Probar que el servidor responde (sin seguir redirect a HTTPS externo)
HTTP=$(curl -s -o /dev/null -w "%{http_code}" --connect-timeout 5 "http://127.0.0.1/sce/app_Login/" -H "Host: 127.0.0.1" 2>/dev/null || echo "000")
if [ "$HTTP" = "301" ] || [ "$HTTP" = "200" ] || [ "$HTTP" = "302" ]; then
  echo "OK: El servidor responde (HTTP $HTTP)."
  echo "    La redirección a HTTPS es normal si está configurada en Apache."
else
  echo "Código HTTP: $HTTP (revisar Apache y PHP si no es 200/301/302)."
fi
echo ""
echo "Verificación opcional (puede tardar o dar timeout si el host no resuelve):"
curl -sI -k --connect-timeout 5 "https://posgrados.inecol.mx/sce/app_Login/" 2>/dev/null | head -1 || echo "  (timeout o no accesible desde este host)"
echo ""
echo "Página: https://posgrados.inecol.mx/sce/app_Login/"
