#!/bin/bash
# Verificación SSL/certificado posgrados.inecol.mx
# Ejecutar en el servidor: bash seguridad/verificar_ssl_posgrados.sh
# (algunos comandos requieren sudo)

set -e
echo "=== 1. Proceso en puertos 80 y 443 ==="
ss -ltnp 2>/dev/null | grep -E ':80 |:443 ' || true
echo ""
echo "Con sudo (si tienes permisos):"
sudo ss -ltnp 2>/dev/null | grep -E ':80 |:443 ' || true

echo ""
echo "=== 2. Servicios web (nginx, apache, httpd, LAMPP) ==="
for s in nginx apache2 httpd; do
  if systemctl list-unit-files "$s.service" &>/dev/null; then
    echo -n "$s: "; systemctl is-active "$s.service" 2>/dev/null || echo "no encontrado"
  fi
done
[ -x /opt/lampp/lampp ] && echo "LAMPP (XAMPP): /opt/lampp/ (atiende 80 y 443 en este servidor)" || true

echo ""
echo "=== 3. Rutas de certificados en Nginx ==="
grep -R "ssl_certificate\|ssl_certificate_key" /etc/nginx/ 2>/dev/null || true

echo ""
echo "=== 4. Rutas de certificados en Apache / LAMPP ==="
grep -R "SSLCertificate" /etc/apache2/ /etc/httpd/ 2>/dev/null || true
grep "SSLCertificate" /opt/lampp/etc/extra/httpd-ssl.conf /opt/lampp/etc/extra/httpd-vhosts.conf 2>/dev/null || true

echo ""
echo "=== 5. Directorios de certificados ==="
echo "LAMPP (posgrados) - DONDE ESTÁ HOY EL CERT:"
ls -la /opt/lampp/etc/ssl/certs/posgrados.crt /opt/lampp/etc/ssl/private/posgrados.key 2>/dev/null || echo "  (no existe o sin permiso)"
echo "/etc/letsencrypt/live/:"
ls -la /etc/letsencrypt/live/ 2>/dev/null || echo "  (no existe o sin permiso)"
echo "/etc/ssl/posgrados.inecol.mx/:"
ls -la /etc/ssl/posgrados.inecol.mx/ 2>/dev/null || echo "  (no existe)"
echo "Snakeoil (solo referencia):"
ls -la /etc/ssl/certs/ssl-cert-snakeoil.pem /etc/ssl/private/ssl-cert-snakeoil.key 2>/dev/null || true

echo ""
echo "=== 6. Certificado actual en 127.0.0.1:443 ==="
echo | openssl s_client -connect 127.0.0.1:443 -servername posgrados.inecol.mx 2>/dev/null | openssl x509 -noout -subject -issuer -dates 2>/dev/null || echo "  (fallo al conectar o sin openssl)"

echo ""
echo "=== 7. Resumen ==="
echo "- Certificado actual: CN=posgrados.inecol.mx, emisor ZeroSSL (ACME)."
echo "- Quien atiende 80/443: LAMPP (XAMPP) en /opt/lampp/."
echo "- Archivos a reemplazar con el certificado nuevo:"
echo "  Certificado: /opt/lampp/etc/ssl/certs/posgrados.crt"
echo "  Clave:       /opt/lampp/etc/ssl/private/posgrados.key"
echo "- Config que los usa: /opt/lampp/etc/extra/httpd-ssl.conf y httpd-vhosts.conf"
echo "- Pasos:"
echo "  1. Respaldo: sudo cp /opt/lampp/etc/ssl/certs/posgrados.crt /opt/lampp/etc/ssl/certs/posgrados.crt.bak"
echo "             sudo cp /opt/lampp/etc/ssl/private/posgrados.key /opt/lampp/etc/ssl/private/posgrados.key.bak"
echo "  2. Copiar el nuevo cert como posgrados.crt y la clave como posgrados.key en esas rutas."
echo "  3. Si te dieron fullchain: usar ese contenido para posgrados.crt (certificado + cadena)."
echo "  4. Permisos: chmod 644 .../posgrados.crt; chmod 600 .../posgrados.key"
echo "  5. Reiniciar LAMPP: sudo /opt/lampp/lampp restartapache  (o sudo /opt/lampp/lampp restart)"
