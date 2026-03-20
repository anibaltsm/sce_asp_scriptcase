# Verificación SSL – posgrados.inecol.mx

## Resultado de la verificación

| Comprobación | Resultado |
|--------------|-----------|
| **Puertos 80 y 443** | En escucha por **LAMPP (XAMPP)**: `/opt/lampp/bin/` (varios PIDs). |
| **Nginx** | `failed` (puerto 80 en uso por LAMPP). |
| **Apache2 (systemd)** | No existe; el Apache que sirve es el de LAMPP. |
| **Certificado en 127.0.0.1:443** | CN=posgrados.inecol.mx, **emisor: ZeroSSL** (ACME). Válido hasta 12 Mar 2026 (vencido). |
| **Config SSL** | **LAMPP**: `/opt/lampp/etc/extra/httpd-ssl.conf` y `httpd-vhosts.conf`. |
| **Certificado actual (archivos)** | `/opt/lampp/etc/ssl/certs/posgrados.crt` y `/opt/lampp/etc/ssl/private/posgrados.key`. |

## Conclusión

- **Quién sirve 80 y 443:** **XAMPP (LAMPP)** en `/opt/lampp/`. No es nginx ni Apache del sistema.
- **Dónde está el certificado hoy:**  
  - Certificado: `/opt/lampp/etc/ssl/certs/posgrados.crt`  
  - Clave privada: `/opt/lampp/etc/ssl/private/posgrados.key`
- **Dónde colocar el certificado nuevo:** Reemplazar esos dos archivos (respaldo antes).

## Pasos para instalar el certificado nuevo (LAMPP)

1. **Respaldo de los archivos actuales:**
   ```bash
   sudo cp /opt/lampp/etc/ssl/certs/posgrados.crt /opt/lampp/etc/ssl/certs/posgrados.crt.bak
   sudo cp /opt/lampp/etc/ssl/private/posgrados.key /opt/lampp/etc/ssl/private/posgrados.key.bak
   ```

2. **Copiar el certificado nuevo:**
   - El archivo del **certificado** (o fullchain = certificado + cadena intermedia) → copiarlo como:
     ```bash
     sudo cp /ruta/donde/te/entregaron/fullchain.pem /opt/lampp/etc/ssl/certs/posgrados.crt
     ```
     (Si te dieron solo `.crt`, usa ese archivo directamente como `posgrados.crt`.)
   - La **clave privada** → copiarla como:
     ```bash
     sudo cp /ruta/donde/te/entregaron/privkey.pem /opt/lampp/etc/ssl/private/posgrados.key
     ```

3. **Permisos:**
   ```bash
   sudo chmod 644 /opt/lampp/etc/ssl/certs/posgrados.crt
   sudo chmod 600 /opt/lampp/etc/ssl/private/posgrados.key
   ```

4. **Reiniciar Apache de LAMPP:**
   ```bash
   sudo /opt/lampp/lampp restartapache
   ```
   (O reinicio completo: `sudo /opt/lampp/lampp restart`.)

5. **Comprobar:**
   ```bash
   echo | openssl s_client -connect 127.0.0.1:443 -servername posgrados.inecol.mx 2>/dev/null | openssl x509 -noout -subject -issuer -dates
   curl -Iv https://127.0.0.1/
   ```

No hace falta cambiar la configuración en `httpd-ssl.conf` ni en `httpd-vhosts.conf`: ya apuntan a `posgrados.crt` y `posgrados.key`; solo se reemplazan los archivos.
