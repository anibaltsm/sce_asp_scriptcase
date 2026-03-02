# Error fwrite al publicar en /opt/lampp/htdocs/sce_enbc

## Resumen de la revisión de logs

### Dónde está el error
- **Log de Scriptcase (donde sí sale el error):**  
  `/opt/Scriptcase/v9-php81/components/apache/logs/error_log`
- **Log de PHP de LAMPP:**  
  `/opt/lampp/logs/php_error_log`  
  (ahí no aparece este error porque el asistente de publicación corre en Scriptcase, no en LAMPP)

### Entradas encontradas (26-Feb-2026)
En el error_log de Scriptcase aparecen varias veces:
```
PHP Fatal error: Uncaught TypeError: fwrite(): Argument #1 ($stream) must be of type resource, bool given
in .../nmPagePublishWizard.class.php:1086
...
fwrite(false, '<html>\r\n  </bod...')
nmPagePublishWizard->MakePublish(Array)
```
Es decir: un `fopen()` previo falla (devuelve `false`) y el código no lo comprueba antes de llamar a `fwrite()`.

### Pista adicional en el mismo log
Justo antes de uno de los errores aparece:
```
tar: /opt/Scriptcase/v9-php81/components/apache/lib/libselinux.so.1: no version information available (required by tar)
```
El proceso de publicación podría usar `tar`; si algo falla ahí, la ruta donde luego se escribe el HTML podría no existir o no crearse.

### Usuario con el que corre Scriptcase
- Los procesos de Scriptcase (Apache y PHP-CGI) corren como usuario **`daemon`** (uid=1, gid=1).
- Por tanto, quien necesita poder **crear/escribir** en el directorio de publicación es **`daemon`**, no el usuario con el que abres el navegador.

### Estado del directorio de destino
- `/opt/lampp/htdocs/sce_enbc`: propietario `posgrado`, grupo `daemon`, permisos `drwxrwsrwx` (2777).
- En teoría `daemon` (grupo daemon) puede escribir. Si el wizard intenta escribir en un **subdirectorio que aún no existe**, `fopen()` puede fallar porque PHP no crea carpetas intermedias por sí solo.

---

## Qué hacer (pasos recomendados)

### 1. Dar propiedad o permisos de escritura a `daemon` en el destino
En una terminal (con sudo):

```bash
# Opción A: dar propiedad al usuario daemon (recomendado para que el wizard pueda crear subcarpetas)
sudo chown -R daemon:daemon /opt/lampp/htdocs/sce_enbc
sudo chmod -R u+rwX /opt/lampp/htdocs/sce_enbc

# Opción B: si prefieres mantener propietario posgrado, asegurar que el grupo daemon pueda escribir y crear
sudo chgrp -R daemon /opt/lampp/htdocs/sce_enbc
sudo chmod -R g+rwX /opt/lampp/htdocs/sce_enbc
sudo chmod g+s /opt/lampp/htdocs/sce_enbc
```

### 2. Comprobar que daemon puede escribir
```bash
sudo -u daemon touch /opt/lampp/htdocs/sce_enbc/test_write.txt && echo "OK" && sudo -u daemon rm /opt/lampp/htdocs/sce_enbc/test_write.txt
```

### 3. Revisar la ruta en el asistente de publicación
- En el wizard, verificar que el directorio de publicación sea exactamente:  
  **`/opt/lampp/htdocs/sce_enbc`**
- Si se publica en un subdirectorio (por ejemplo `sce_enbc/mi_app`), crear antes esa carpeta y dar a `daemon` permisos de escritura sobre ella (o sobre todo `sce_enbc` como en el paso 1).

### 4. Si sigue fallando: publicar primero en una ruta bajo Scriptcase
- Probar publicar en una carpeta a la que `daemon` tenga acceso seguro, por ejemplo:  
  `/opt/Scriptcase/v9-php81/wwwroot/scriptcase/publish_test`
- Crear la carpeta y dar permisos a `daemon`:
  ```bash
  sudo mkdir -p /opt/Scriptcase/v9-php81/wwwroot/scriptcase/publish_test
  sudo chown daemon:daemon /opt/Scriptcase/v9-php81/wwwroot/scriptcase/publish_test
  ```
- Si ahí la publicación termina bien, el problema es permisos o ruta en `/opt/lampp/htdocs/sce_enbc`. Luego puedes copiar el resultado a `sce_enbc` o ajustar permisos y ruta.

### 5. Contacto con Scriptcase
- El fallo está en código protegido (SourceGuardian) en `nmPagePublishWizard.class.php`: un `fopen()` falla y no se comprueba antes de `fwrite()`.
- Si con los pasos anteriores no se resuelve, conviene reportar a Scriptcase el error (incluyendo el fragmento del `error_log` de Scriptcase y que el proceso corre como `daemon`) para que corrijan la validación del handle antes de `fwrite()`.

---

## Ubicación de logs útiles

| Log | Ruta |
|-----|------|
| **Errores PHP del asistente de publicación (Scriptcase)** | `/opt/Scriptcase/v9-php81/components/apache/logs/error_log` |
| Errores PHP de LAMPP | `/opt/lampp/logs/php_error_log` |
| Acceso Scriptcase | `/opt/Scriptcase/v9-php81/components/apache/logs/access_log` (si existe) |
| Log interfaz Scriptcase (por día) | `/opt/Scriptcase/v9-php81/wwwroot/scriptcase/log/iface/log_YYYYMMDD.log` |

Para ver en tiempo real el error al publicar:
```bash
tail -f /opt/Scriptcase/v9-php81/components/apache/logs/error_log
```
