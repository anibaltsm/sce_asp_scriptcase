# Tema grp__NM__SCE: pasar de Windows a Linux

## Error durante la generación de código

Si al **generar** (Generate) en Scriptcase te sale:

> El tema grp__NM__SCE utilizado no se encontró en su entorno. Hemos sustituido por el tema scriptcase__NM__Sc8_Ceropegia.

es porque el **proyecto de desarrollo** (el que usa Scriptcase para generar) no tiene el tema SCE en su `_lib`. Hay que poner el tema en el proyecto de desarrollo **una vez**:

```bash
sudo bash /opt/sce_asp_scriptcase/scripts/poner_tema_sce_en_desarrollo.sh
```

Ese script aplica a **todos** los proyectos de desarrollo que usan el tema (SCE, **SCE_**, **SCE_dev**, SCE_2_prueba), porque la generación puede ejecutarse desde cualquiera de ellos (el log muestra `Cod_Prj=SCE_.` o `SCE_dev`):

- Copia la carpeta del tema `SCE` desde producción al `_lib/css/` de cada proyecto si no existe.
- Añade las entradas (SCE, grp__NM__SCE, scriptcase__NM__Green) en el `schemas.ini` de cada proyecto si faltan.

Después de ejecutarlo, vuelve a generar en Scriptcase desde el proyecto que uses (SCE, SCE_ o SCE_dev); el error no debería aparecer.

**Si generas desde SCE_dev y el error sigue:**

1. **Cierra y vuelve a abrir el proyecto** en Scriptcase (o recarga la interfaz), para que cargue de nuevo la lista de temas desde disco.
2. Vuelve a ejecutar el script (por si al abrir/generar Scriptcase hubiera sobrescrito `schemas.ini`):  
   `sudo bash /opt/sce_asp_scriptcase/scripts/poner_tema_sce_en_desarrollo.sh`
3. Genera de nuevo (Generate).

---

## Error "could not be copied" al desplegar

Si al **desplegar** (Deploy) te salen errores como:

> Error: File '.../SCE_dev/_lib/css/SCE/SCE_grid.css' could not be copied!

es porque el directorio de **destino** en producción (`/opt/lampp/htdocs/sce/_lib/css/SCE`) tiene permisos **755** y el proceso de deploy corre como usuario **daemon**, que no puede escribir ahí. Hay que dar permisos de escritura al grupo:

```bash
sudo bash /opt/sce_asp_scriptcase/scripts/permisos_deploy_sce_tema.sh
```

Ese script pone **775** en la carpeta SCE y **664** en los archivos, manteniendo propietario `posgrado:daemon`, para que daemon pueda copiar al desplegar.

---

## Después de cada publicación (producción)

**Cada vez que vuelvas a publicar** el proyecto sce a producción, Scriptcase regenera `_lib/css/schemas.ini` en el servidor y **borra** las entradas del tema. Para que el tema funcione otra vez en producción, ejecuta:

```bash
sudo bash /opt/sce_asp_scriptcase/scripts/agregar_temas_sce_schemas.sh
```

Conviene hacerlo justo después de cada deploy (o añadirlo a tu checklist de publicación).

---

## Error que aparecía

En app_Login (o en el diagnóstico de Scriptcase):

```text
El tema grp__NM__SCE utilizado no se encontró en su entorno.
Hemos sustituido por el tema scriptcase__NM__Sc8_Ceropegia.
```

## Causa

El tema **grp__NM__SCE** es un tema de proyecto (grupo) que en Windows estaba en:

- `C:\wamp64\www\SCE\_lib\css\SCE\` (todos los CSS del tema)
- Registro en `_lib/css/schemas.ini`

En Linux (`/opt/lampp/htdocs/sce`) la carpeta del tema no existía, por eso Scriptcase sustituía por Sc8_Ceropegia.

## Qué se hizo

1. **Copiar el tema SCE desde el servidor Windows**
   - Recurso: `//192.168.2.68/C$/wamp64/www/SCE/_lib`
   - Con smbclient se descargó la carpeta `_lib/css/SCE` completa al servidor Linux en:
     - `/opt/lampp/htdocs/sce/_lib/css/SCE/`
   - Comando usado (desde `/opt/lampp/htdocs/sce/_lib/css`):
     ```bash
     echo "PASSWORD" | smbclient "//192.168.2.68/C$" -U "Administrador%PASSWORD" -W WORKGROUP \
       -D "wamp64/www/SCE/_lib/css" -c "recurse ON; prompt OFF; mget SCE"
     ```

2. **Actualizar `schemas.ini` en Linux**
   - Archivo: `/opt/lampp/htdocs/sce/_lib/css/schemas.ini`
   - Se ajustó la línea del tema SCE para que coincida con la de Windows:
     - Antes: `SCE#nm#Sc9_Rhino#nm#`
     - Después: `SCE#nm#SCE#nm#grp__NM__ico__NM__scriptcase__NM__img__NM__projetos__NM__Posgrado.png`
   - **Importante:** La aplicación usa el nombre **grp__NM__SCE** (tema de proyecto). Se añadió una línea explícita para que ese nombre resuelva al mismo tema:
     - `grp__NM__SCE#nm#SCE#nm#grp__NM__ico__NM__scriptcase__NM__img__NM__projetos__NM__Posgrado.png`
     - Así Scriptcase encuentra el tema cuando la app pide "grp__NM__SCE" y usa la carpeta `SCE`.

3. **Permisos**
   - Se aplicó `chmod -R 755` a `_lib/css/SCE` para que el servidor web pueda leer los CSS.

## Cómo comprobar

- Entrar a la aplicación (por ejemplo app_Login) y revisar que ya no salga el mensaje de sustitución de tema.
- En Scriptcase, en el diagnóstico del proyecto, el tema grp__NM__SCE debería aparecer como encontrado.

## Otros temas que dan error (blank, menu_admon)

Si el diagnóstico muestra también:

- **blank:** "El tema scriptcase__NM__Green utilizado no se encontró"
- **menu_admon:** "El tema grp__NM__SCE utilizado no se encontró"

Hay que añadir en el mismo `schemas.ini` estas líneas (al final del archivo):

```ini
SCE#nm#SCE#nm#grp__NM__ico__NM__scriptcase__NM__img__NM__projetos__NM__Posgrado.png
grp__NM__SCE#nm#SCE#nm#grp__NM__ico__NM__scriptcase__NM__img__NM__projetos__NM__Posgrado.png
scriptcase__NM__Green#nm#Sc7_Green#nm#
```

**Script para aplicarlo (el archivo es propiedad de daemon, hace falta sudo):**

```bash
sudo bash /opt/sce_asp_scriptcase/scripts/agregar_temas_sce_schemas.sh
```

Así se añaden los tres temas de una vez. La carpeta `SCE` debe existir en `_lib/css/`; `Sc7_Green` ya viene con Scriptcase.

## Si sigue sin aparecer: carpeta grp__NM__SCE con enlaces

La app publicada construye la ruta del tema como `_lib/css/grp__NM__SCE/grp__NM__SCE_*.css`. Aunque `schemas.ini` tenga la entrada `grp__NM__SCE`, el PHP generado puede no usarla y pedir esa ruta literal. Si la carpeta **grp__NM__SCE** no existe, el tema no se encuentra.

**Solución:** Crear la carpeta `grp__NM__SCE` con enlaces simbólicos a los archivos de `SCE` (cada `grp__NM__SCE_*` → `../SCE/SCE_*`):

```bash
bash /opt/sce_asp_scriptcase/scripts/crear_tema_grp_NM_SCE_enlaces.sh
```

(Desde el repo; la variable `CSS_BASE` por defecto es `/opt/lampp/htdocs/sce/_lib/css`.) Se crean 65 enlaces. Si la carpeta no es escribible, ejecutar con `sudo bash ...`.

Después de crearla, recargar la app y vaciar caché del navegador si hace falta.

## Otras comprobaciones si sigue sin aparecer

1. **Caché del navegador:** Probar en ventana de incógnito o vaciar caché (Ctrl+Shift+Supr) y recargar.
2. **Comprobar `schemas.ini`:** Debe contener la línea `grp__NM__SCE#nm#SCE#nm#...` para que el nombre usado por la app resuelva a la carpeta `SCE`.
3. **Permisos:** `_lib/css/SCE`, `_lib/css/grp__NM__SCE` y `_lib/css/schemas.ini` deben ser legibles por el usuario del servidor web (p. ej. `chmod -R 755 _lib/css/SCE`, `chmod 755 _lib/css/grp__NM__SCE`, `chmod 664 _lib/css/schemas.ini`).
4. **Traer todo _lib desde Windows:** Si el problema persiste, puede haber más archivos del tema o de proyecto en otras carpetas de _lib (img, buttons, etc.). En ese caso, conviene hacer respaldo de _lib en Linux y reemplazar con la _lib completa de Windows (comprimida y descomprimida en el servidor).

## Si en el futuro añades más temas desde Windows

- Temas en Windows: `C:\wamp64\www\SCE\_lib\css\<NombreTema>\`
- En Linux: `/opt/lampp/htdocs/sce/_lib/css/<NombreTema>/`
- Copiar la carpeta del tema y, si hace falta, añadir o ajustar su línea en `_lib/css/schemas.ini` (puedes comparar con el `schemas.ini` de Windows).

## Imágenes del proyecto (opcional)

En Windows hay imágenes de proyecto en `_lib/img/` con prefijo `grp__NM__` (por ejemplo `grp__NM__bg__NM__back_SCE2.png`). Si alguna aplicación usa esas imágenes y no se ven en Linux, se pueden copiar de la misma forma con smbclient desde `wamp64/www/SCE/_lib/img` a `/opt/lampp/htdocs/sce/_lib/img/`.
