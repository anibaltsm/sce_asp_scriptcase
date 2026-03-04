# Solución: Error 500 y fwrite() en Publish Wizard (Scriptcase)

## Resumen del error

- **URL afectada:** `https://posgrados.inecol.mx/sce/app_Login/` → **500 Internal Server Error**
- **Error en Publish Wizard:**  
  `TypeError: fwrite(): Argument #1 ($stream) must be of type resource, bool given`  
  en `nmPagePublishWizard.class.php:1057`

### Qué significa

`fwrite()` recibe `false` porque **`fopen()` falló** (no pudo abrir/crear el archivo). En PHP 8.1 eso se traduce en un TypeError. Las causas típicas son:

1. **Permisos:** el usuario que ejecuta PHP no puede escribir en la carpeta de publicación.
2. **Ruta incorrecta o inexistente:** la carpeta de destino no existe o el path configurado en el wizard es erróneo.
3. **Carpeta padre sin permisos:** no se puede crear un subdirectorio o archivo en la ruta indicada.

---

## Entorno revisado

- **Carpeta de publicación:** `/opt/lampp/htdocs/sce`
- **Propietario de la carpeta `sce`:** `posgrado`
- **Grupo:** `daemon`
- **Permisos de `sce`:** `2775` (drwxrwsr-x) → el **grupo `daemon` tiene escritura**.
- **Usuario con el que corre PHP (Scriptcase):** **`daemon`** (visto en procesos `php-cgi`).
- **Subcarpetas bajo `sce` (ej. app_Login):** `daemon:daemon`, `755` (solo daemon puede escribir).

Conclusión: en principio **`daemon` puede escribir en `/opt/lampp/htdocs/sce`** (por grupo). El fallo puede deberse a que el wizard intenta escribir en **otra ruta** (por ejemplo una subcarpeta que no existe y no se crea, o un path mal configurado).

---

## Pasos recomendados

### 1. Comprobar la ruta en el Publish Wizard

Al publicar con **“Publicar en directorio del servidor”**:

- La ruta debe ser **exactamente** la carpeta donde quieres el proyecto, por ejemplo:  
  **`/opt/lampp/htdocs/sce`**
- No debe haber espacios ni barras finales inconsistentes.
- Debe ser una ruta **absoluta**.

Si la ruta apunta a otro sitio (por ejemplo solo `/opt/lampp/htdocs` o una carpeta que no existe), `fopen()` puede fallar y dar el error de `fwrite()`.

### 2. Ajustar permisos en `/opt/lampp/htdocs/sce`

Para que el usuario con el que corre el wizard (en tu caso **daemon**) pueda crear archivos y carpetas:

```bash
# Propietario y grupo (daemon debe poder escribir)
sudo chown -R posgrado:daemon /opt/lampp/htdocs/sce

# Directorios: 775 (lectura/escritura para grupo)
sudo find /opt/lampp/htdocs/sce -type d -exec chmod 775 {} \;

# Archivos: 664 (lectura/escritura para grupo)
sudo find /opt/lampp/htdocs/sce -type f -exec chmod 664 {} \;
```

Si prefieres que **daemon** sea también propietario (por ejemplo si solo ese usuario usa esa carpeta):

```bash
sudo chown -R daemon:daemon /opt/lampp/htdocs/sce
sudo find /opt/lampp/htdocs/sce -type d -exec chmod 755 {} \;
sudo find /opt/lampp/htdocs/sce -type f -exec chmod 644 {} \;
```

Así te aseguras de que el wizard pueda crear nuevos archivos/directorios bajo `sce`.

### 3. Crear la carpeta si no existe

Si en el wizard vas a publicar en `/opt/lampp/htdocs/sce`:

```bash
sudo mkdir -p /opt/lampp/htdocs/sce
sudo chown posgrado:daemon /opt/lampp/htdocs/sce
sudo chmod 775 /opt/lampp/htdocs/sce
```

### 4. Alternativa: publicar con Tar.Gz y descomprimir a mano

Según la [documentación de Scriptcase (Typical Deploy)](https://scriptcase.net/docs/en_us/v9/manual/12-deploy/02-typical):

- Elige **“Generate Tar.Gz with applications”** (recomendado para Linux).
- Descarga el `.tar.gz` y súbelo al servidor.
- Descomprime **en el servidor** en `/opt/lampp/htdocs/sce` con el usuario que deba ser dueño de los archivos (por ejemplo el que ejecuta el PHP en producción, en tu caso **daemon**):

```bash
cd /opt/lampp/htdocs
sudo -u daemon tar -xzf nombre_del_archivo.tar.gz -C sce
# o, si el tar ya incluye la carpeta "sce":
sudo -u daemon tar -xzf nombre_del_archivo.tar.gz
sudo mv sce_extraido/* sce/
```

Así evitas que el wizard escriba directamente en disco y controlas permisos y propietario.

### 5. Revisar logs

- **PHP:**  
  `tail -f /opt/lampp/logs/php_error_log`  
  Ahí pueden aparecer “Permission denied” o “Failed to open stream” al publicar o al cargar `app_Login`.
- **Apache:**  
  `tail -f /opt/lampp/logs/error_log`  
  Para errores 500 y mensajes del servidor.

En tus logs ya aparecen errores de **“Permiso denegado”** en rutas como `prod.config.php` y en `SCE_2/app_Login`; conviene corregir permisos en esas rutas también (lectura/escritura según lo que pida la aplicación).

### 6. Sobre el 500 en `/sce/app_Login/`

El 500 al entrar a `https://posgrados.inecol.mx/sce/app_Login/` puede ser:

- **Permisos de lectura** en `_lib`, `conf`, `app_Login`, etc.: el usuario del servidor web (daemon) debe poder leer todos los PHP e includes.
- **Permisos de escritura** donde Scriptcase escribe (p. ej. `_lib/prod`, `conf`, tmp): en los logs aparecen fallos en `prod.config.php` y en `app_Login` por “Permiso denegado”.

Ajustando como en el punto 2 (y asegurando que `daemon` sea propietario o que el grupo tenga permisos adecuados) se suele resolver tanto el 500 como los errores del wizard.

---

## Resumen rápido

| Problema | Acción |
|----------|--------|
| `fwrite()` recibe `false` en Publish Wizard | Revisar ruta de publicación y permisos de la carpeta de destino (`/opt/lampp/htdocs/sce`). |
| Publicar en `/opt/lampp/htdocs/sce` | Ruta exacta en wizard; carpeta existente; `chown`/`chmod` para que **daemon** (o el usuario de PHP) pueda escribir. |
| Evitar fallos de escritura del wizard | Alternativa: publicar como **Tar.Gz** y descomprimir en el servidor con el usuario correcto. |
| 500 en `/sce/app_Login/` | Revisar permisos de lectura/escritura en `sce`, `_lib`, `conf` y logs en `php_error_log` y `error_log`. |

---

## Referencias

- [Scriptcase – Typical Deploy](https://scriptcase.net/docs/en_us/v9/manual/12-deploy/02-typical)
- [Scriptcase – File permissions Linux FastCGI/SuPHP](https://forum.scriptcase.net/t/install-file-permissions-for-linux-running-fastcgi-suphp/15147)  
- Logs en este servidor: `/opt/lampp/logs/php_error_log`, `/opt/lampp/logs/error_log`
