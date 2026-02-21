# Error al sincronizar tabla form_aspirantes_admvo

## Mensaje de error

```
Fatal error: Uncaught Error: Call to a member function SelectLimit() on null 
in /Applications/Scriptcase/v9-php81/wwwroot/scriptcase/devel/lib/php/database.inc.php:1266

Stack trace:
#0 nm_select.class.php(556): nm_db_fields()
#1 nm_select.class.php(157): nm_select->_PrepareFields()
#2 nm_select_atualiza.php(148): nm_select->AnalizeSql()
#3 nm_select_atualiza.php(2): sg_load()
```

## Qué significa

- **SelectLimit() on null**: Se está llamando al método `SelectLimit()` sobre un objeto que es **null**.
- Ese objeto suele ser la **conexión a la base de datos** (o el recordset) que usa ScriptCase para leer la estructura de la tabla.
- **Conclusión**: En el momento de sincronizar la tabla, la conexión asociada a esa aplicación/tabla **no está inicializada** o **no existe** en el contexto donde se ejecuta la sincronización.

## Causas habituales

1. **Conexión no definida o mal nombrada**  
   La aplicación **form_aspirantes_admvo** (o la tabla que sincronizas) está configurada para usar una conexión que:
   - No existe en el proyecto, o  
   - Tiene otro nombre en el proyecto (typo o conexión borrada).

2. **Conexión no cargada en el entorno de desarrollo**  
   La herramienta “Sincronizar tabla” en el **entorno de desarrollo** (devel) puede usar solo una conexión por defecto. Si la tabla pertenece a **otra conexión** y esa no se carga al abrir el asistente, el objeto conexión queda **null** y aparece este error.

3. **Proyecto/carpeta distinta**  
   Si el proyecto que tienes abierto en ScriptCase no es el que contiene la conexión donde está la tabla, o si la app está en otro proyecto, la conexión correcta no estará disponible.

## Qué hacer (pasos recomendados)

### 1. Comprobar la aplicación y su conexión

- En ScriptCase, abre la aplicación **form_aspirantes_admvo**.
- Revisa en la configuración de la aplicación (por ejemplo en **Conexión** o **Connection**) qué **nombre de conexión** está asignado.
- Anota ese nombre exacto (sensible a mayúsculas/minúsculas).

### 2. Verificar que la conexión existe en el proyecto

- En ScriptCase: **Base de datos** (o **Connections**) → listado de conexiones.
- Comprueba que exista una conexión con **exactamente** el mismo nombre que usa la aplicación.
- Si no existe, créala con los datos correctos (host, usuario, contraseña, base de datos) y **Pruébala**.
- Si el nombre no coincide (typo o nombre antiguo), o bien:
  - **Corrige el nombre** en la aplicación para que use la conexión que sí existe, o  
  - **Renombra la conexión** en el proyecto para que coincida con lo que usa la aplicación.

### 3. Comprobar la tabla en esa conexión

- En el **Administrador de base de datos** (o Database Builder) de ScriptCase, selecciona la **misma conexión** que usa la aplicación.
- Verifica que la tabla que quieres sincronizar (la de form_aspirantes_admvo) exista en esa base de datos y que puedas ver su estructura sin errores.

### 4. Sincronizar de nuevo

- Con la conexión existente, probada y asignada correctamente a la aplicación, vuelve a usar **Sincronizar tabla** sobre form_aspirantes_admvo.

### 5. Si sigue fallando: revisar conexión por defecto del proyecto

- En el **proyecto** (no solo en la app): **Configuración del proyecto** o **Project Settings**.
- Revisa si hay una **conexión por defecto** y que sea la misma donde está la tabla (o al menos una conexión válida).  
  A veces la herramienta de sincronización usa esa conexión por defecto cuando no puede resolver la de la aplicación.

## Resumen

| Síntoma | Causa probable | Acción |
|--------|------------------|--------|
| `SelectLimit() on null` al sincronizar | Conexión null en el flujo de sincronización | Asegurar que la app use una conexión que **existe** en el proyecto y que esté **probada**. |
| Solo falla con esta tabla/app | Esta app usa otra conexión que no se carga | Revisar conexión asignada a la aplicación y conexión por defecto del proyecto. |
| Nunca has configurado conexión para esta app | Conexión en blanco o por defecto inexistente | Definir y probar la conexión; asignarla a la aplicación. |

Si después de esto el error continúa, conviene revisar los **logs de PHP** (por ejemplo `php_error_log` en XAMPP) en el momento exacto en que ejecutas “Sincronizar tabla”, por si aparece otro mensaje previo (por ejemplo “connection failed” o “unknown connection”) que indique por qué la conexión no se está creando.
