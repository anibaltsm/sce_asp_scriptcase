#!/bin/bash
# Instala el certificado posgrados.inecol.mx_202603 (1):
#   1. Respaldo del cert y key actuales
#   2. Copia del nuevo fullchain y clave a LAMPP
#   3. Permisos y reinicio de Apache LAMPP
# Ejecutar: sudo bash /opt/sce_asp_scriptcase/seguridad/instalar_cert_posgrados_202603.sh

set -e
ORIGEN="/opt/sce_asp_scriptcase/posgrados.inecol.mx_202603 (1)"
CERT_LAMPP="/opt/lampp/etc/ssl/certs/posgrados.crt"
KEY_LAMPP="/opt/lampp/etc/ssl/private/posgrados.key"

if [ "$(id -u)" -ne 0 ]; then
  echo "Ejecuta con sudo: sudo bash $0"
  exit 1
fi

echo "=== 1. Respaldo de los archivos actuales ==="
cp -a "$CERT_LAMPP" "${CERT_LAMPP}.bak"
cp -a "$KEY_LAMPP" "${KEY_LAMPP}.bak"
ls -la "${CERT_LAMPP}.bak" "${KEY_LAMPP}.bak"

echo ""
echo "=== 2. Crear fullchain si no existe ==="
if [ ! -f "$ORIGEN/fullchain.crt" ]; then
  cat "$ORIGEN/certificate.crt" "$ORIGEN/ca_bundle.crt" > "$ORIGEN/fullchain.crt"
  echo "Creado $ORIGEN/fullchain.crt"
fi

echo ""
echo "=== 3. Copiar nuevo certificado y clave a LAMPP ==="
cp "$ORIGEN/fullchain.crt" "$CERT_LAMPP"
cp "$ORIGEN/private.key" "$KEY_LAMPP"
chmod 644 "$CERT_LAMPP"
chmod 600 "$KEY_LAMPP"
ls -la "$CERT_LAMPP" "$KEY_LAMPP"

echo ""
echo "=== 4. Reiniciar Apache LAMPP ==="
if /opt/lampp/lampp restartapache; then
  echo "Apache LAMPP reiniciado correctamente."
else
  echo "Fallo restartapache. Diagnóstico rápido:"
  ss -ltnp 2>/dev/null | grep -E ':80 |:443 ' || true
  /opt/lampp/bin/httpd -t -f /opt/lampp/etc/httpd.conf -DSSL -DPHP || true

  echo ""
  echo "Intentando arranque manual de Apache LAMPP..."
  rm -f /opt/lampp/logs/httpd.pid
  /opt/lampp/bin/apachectl -k start -E /opt/lampp/logs/error_log -DSSL -DPHP || true
  sleep 2

  if ss -ltnp 2>/dev/null | grep -qE ':80 |:443 '; then
    echo "Apache LAMPP quedó levantado (puertos 80/443 en escucha)."
  else
    echo "ERROR: Apache no levantó. Revisa /opt/lampp/logs/error_log"
    echo "Si necesitas rollback:"
    echo "  cp ${CERT_LAMPP}.bak $CERT_LAMPP"
    echo "  cp ${KEY_LAMPP}.bak $KEY_LAMPP"
    echo "  /opt/lampp/bin/apachectl -k start -E /opt/lampp/logs/error_log -DSSL -DPHP"
    exit 1
  fi
fi

echo ""
echo "=== Listo. Verificar con ==="
echo "  openssl s_client -connect 127.0.0.1:443 -servername posgrados.inecol.mx </dev/null 2>/dev/null | openssl x509 -noout -subject -issuer -dates"
echo "  curl -Iv https://127.0.0.1/"
