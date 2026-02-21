# Configurar conexión a base de datos en ScriptCase

## Error que estás viendo

```
Se produjo un error al conectar con la base de datos:
Connection attempt failed: SQLSTATE[HY000] [2002] Connection refused
```

**URL:** `http://localhost:8091/scriptcase/app/Aspirantes2_dev/grid_aspirantes/`

- **Proyecto:** Aspirantes2_dev  
- **Aplicación:** grid_aspirantes  

Si cambiaste el nombre de la base de datos (antes `sce_aspirantes`, ahora `conn_sce_asp`), hay que **actualizar o crear la conexión** en ScriptCase y asegurarte de que MySQL esté accesible.

---

## 1. Dónde se configura la conexión (documentación oficial)

En ScriptCase las conexiones se gestionan **por proyecto**, desde la interfaz:

- **Menú:** **Base de datos** → **Nueva conexión** (o listado de conexiones para editar).
- O desde el **proyecto**: icono **Nueva conexión** en la barra del proyecto.

Documentación oficial:

- **Conexiones – Visión general:**  
  https://www.scriptcase.net/docs/es_es/v9/manual/05-conexiones-scriptcase/01-vision-general-db
- **Crear conexión MySQL (ej. Mac PDO):**  
  https://www.scriptcase.net/docs/es_es/v9/manual/05-conexiones-scriptcase/07-mysql/04-mac/01-mysql-pdo/
- **Conexiones en producción (mismo nombre que en desarrollo):**  
  https://www.scriptcase.net/docs/es_es/v9/manual/12-despliegue/04-entorno-de-produccion/03-conexion-de-base-de-datos/

Importante: **el nombre de la conexión en producción debe coincidir con el usado en desarrollo.**

---

## 2. Pasos para crear o editar la conexión en desarrollo

1. Abre **ScriptCase** y entra al **proyecto Aspirantes2_dev**.
2. Ve a **Base de datos** → **Nueva conexión** (o abre una conexión existente para editarla).
3. Configura los datos de la conexión:
   - **Nombre de la conexión:** el que usa tu aplicación.  
     Si ahora la BD se llama `conn_sce_asp`, puedes usar por ejemplo **conn_sce_asp** como nombre de conexión (ScriptCase suele usar prefijo `conn_` + nombre de BD).
   - **Driver:** MySQL PDO o MySQLi.
   - **SGBD host o IP:** `127.0.0.1` o `localhost` (en Mac a veces `127.0.0.1` evita problemas).
   - **Puerto:** `3306` (por defecto MySQL).
   - **Usuario** y **Contraseña** de MySQL.
   - **Nombre de la Base de datos:** `conn_sce_asp` (el nombre real de la BD en MySQL).
4. Usa el botón para **Probar** la conexión.
5. Guarda.

Si la aplicación **grid_aspirantes** estaba usando una conexión llamada por ejemplo `conn_sce_aspirantes`, tienes dos opciones:

- **Opción A:** Editar esa conexión y cambiar solo el **nombre de la base de datos** a `conn_sce_asp`, dejando el mismo **nombre de la conexión** (así la app sigue usando la misma conexión).
- **Opción B:** Crear una nueva conexión llamada por ejemplo `conn_sce_asp` apuntando a la BD `conn_sce_asp` y luego en la aplicación **grid_aspirantes** asignar esta nueva conexión (ver punto 4).

---

## 3. Por qué sale "Connection refused" (2002)

Este error indica que **no se puede establecer la conexión TCP** al servidor MySQL. No es un error de “nombre de BD” sino de **no llegar al servidor**. Revisa:

| Causa | Qué hacer |
|-------|------------|
| MySQL no está corriendo | Iniciar MySQL (XAMPP/MAMP/Laragon, o `mysql.server start` según tu instalación). |
| Host incorrecto | En la conexión usar `127.0.0.1` en lugar de `localhost` (o al revés según cómo tengas MySQL). |
| Puerto incorrecto | Debe ser el puerto donde escucha MySQL (por defecto **3306**). |
| Firewall bloqueando | Comprobar que el puerto 3306 esté permitido. |

Después de cambiar nombre de BD, lo más habitual es que sigas usando la **misma conexión** en ScriptCase pero con el campo **Nombre de la Base de datos** actualizado a `conn_sce_asp`. Si además cambiaste de servidor o puerto, hay que actualizar también **host** y **puerto** en esa conexión.

---

## 4. Asignar la conexión a la aplicación grid_aspirantes

La aplicación **grid_aspirantes** tiene asignada una conexión en su configuración:

1. En ScriptCase, abre la aplicación **grid_aspirantes** (proyecto Aspirantes2_dev).
2. En la configuración de la aplicación busca la sección **Conexión** / **Connection** (o **Base de datos**).
3. En **Seleccione la conexión** elige la conexión que apunta a la BD `conn_sce_asp` (la que creaste o editaste en el paso 2).
4. Guarda la aplicación.

Si el nombre de la conexión no coincide con ninguna de las existentes en el proyecto, verás errores de conexión o “connection null”. El nombre debe ser **exactamente** el mismo (sensible a mayúsculas/minúsculas).

---

## 5. Resumen

| Qué hacer | Dónde |
|-----------|--------|
| Crear/editar conexión con BD `conn_sce_asp` | ScriptCase → Proyecto **Aspirantes2_dev** → **Base de datos** → Nueva conexión / Editar conexión |
| Comprobar host, puerto, usuario, contraseña y nombre de BD | Formulario de la conexión; probar con el botón **Probar** |
| Asignar la conexión a grid_aspirantes | Abrir app **grid_aspirantes** → Configuración → **Conexión** → elegir la conexión correcta |
| Asegurar que MySQL esté en marcha y accesible | Servicio MySQL (XAMPP/MAMP/etc.) y, si aplica, `127.0.0.1:3306` |

---

## 6. Error del Módulo de Log (Log:sce_aspirantes) – "La conexión no está definida"

Si al generar o ejecutar **grid_aspirantes** aparece:

- *(Log:sce_aspirantes) : Esta aplicación utiliza un módulo de log y la conexión no está definida.*

significa que la aplicación está vinculada a un **esquema de registro (Log)** que usa la conexión antigua **sce_aspirantes**. Hay que **cambiar la conexión del esquema de log** en ScriptCase.

### Pasos (documentación oficial)

1. Menú superior: **Módulos** → **Registrar** (o **Modules** → **Log**).
2. Clic en **Crear / Editar módulo de registro**.
3. En la lista de esquemas, localiza el asociado a **sce_aspirantes** y clic en **Editar**.
4. En **Creación / edición de esquema**, campo **Conexión**: cámbialo a tu conexión actual (ej. **conn_sce_asp**). Guardar.
5. Vuelve a generar/ejecutar **grid_aspirantes**.

Doc: https://www.scriptcase.net/docs/es_es/v9/manual/10-modulos/04-modulo-de-log/

Si después de esto el error continúa, revisa los logs de PHP en el momento de ejecutar la aplicación por si aparece un mensaje más concreto (por ejemplo “unknown connection” o “connection failed”).
