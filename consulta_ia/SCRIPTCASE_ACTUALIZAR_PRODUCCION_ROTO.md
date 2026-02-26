# ScriptCase: "Actualizar" entorno de producción lo rompió – qué hacer

## Qué pasó

Al pulsar **Actualizar** en el aviso *"¡Nueva versión del entorno de producción!"*, ScriptCase **actualiza automáticamente los archivos del entorno de producción**. Si la versión del entorno de producción (los archivos que sirven las apps) no coincide con la versión con la que se publicaron las aplicaciones, pueden aparecer **incompatibilidades** y dejar de funcionar cosas (pantallas en blanco, errores PHP, redirecciones rotas, etc.).

Documentación oficial: [Configuración de producción](https://www.scriptcase.net/docs/es_es/v9/manual/12-despliegue/04-entorno-de-produccion/04-configuracion-produccion/) – sección "Actualizar Entorno de Producción".

---

## Qué hacer a partir de ahora (evitar que se rompa)

1. **No volver a pulsar "Actualizar"** en ese aviso.
2. **Usar "Ignorar"** cuando aparezca *"Nueva versión del entorno de producción"*: así sigues trabajando sin que ScriptCase sobrescriba los archivos de producción.
3. Si en el futuro necesitas sincronizar versiones, hazlo con **backup previo** y en un momento controlado (ver abajo).

---

## Opciones para recuperar lo que se rompió

### 1. Restaurar desde backup de ScriptCase (recomendado si tienes backup)

Si en desarrollo hiciste un **backup** antes de tocar "Actualizar":

1. En **ScriptCase (entorno de desarrollo)**: **Opciones / Configuración > Restaurar** (o **Settings > Services > Restore**).
2. Sube el archivo de backup (zip) que descargaste en su momento.
3. Tras restaurar, si hace falta: **Opciones > Configuración > Seguridad > Usuarios** y vuelve a dar permisos a tu usuario sobre los proyectos restaurados.

Esto restaura **proyectos y aplicaciones** en desarrollo. Para **archivos del entorno de producción** (los que se sirven en el navegador), sigue el punto 2 o 3.

### 2. Volver a publicar el proyecto (sincronizar desarrollo → producción)

Si el problema es que las **aplicaciones publicadas** quedaron incompatibles con el entorno de producción actual:

1. En ScriptCase (desarrollo), abre el **proyecto** (ej. `sce_asp` o el que uses).
2. **Publicar** de nuevo el proyecto (Publicación típica o avanzada, según cómo lo tengas).
3. Asegúrate de publicar sobre el **mismo directorio** que usa el entorno de producción (ej. la carpeta que está bajo `wwwroot/scriptcase/app/` o la que tengas configurada).

Así se regeneran los archivos publicados con la versión actual de desarrollo y suelen volver a ser compatibles con el entorno de producción.

### 3. Restaurar archivos de producción desde la carpeta backup (avanzado)

En la instalación de ScriptCase (en Mac, bajo `/Applications/Scriptcase/v9-php81/wwwroot/scriptcase/`) existe una carpeta **`backup`** con copias antiguas (por fecha e imports). Ahí puede haber una copia anterior de `_lib/prod` o de los archivos que se actualizaron.

- **No** hay un "deshacer" oficial de un solo clic para "Actualizar entorno de producción".
- Si tienes experiencia con la estructura de ScriptCase, puedes:
  - Identificar en `backup` la copia anterior a cuando pulsaste Actualizar.
  - Restaurar manualmente solo los archivos/directorios que creas que se sobrescribieron (por ejemplo comparando con la copia en `backup`).

Hacer esto mal puede empeorar el estado; solo conviene si controlas la estructura de carpetas de ScriptCase.

### 4. Foro y soporte oficial

- **Foro (español):** <https://www.scriptcase.net/forum/forumdisplay.php?f=17>  
- **Soporte:** <https://www.scriptcase.net/support/> o support@scriptcase.net  

Puedes explicar que pulsaste "Actualizar" en el aviso de nueva versión del entorno de producción y que después las aplicaciones dejaron de funcionar; ellos pueden indicar si hay una forma concreta de revertir esa actualización en tu versión.

---

## Resumen rápido

| Situación | Acción |
|-----------|--------|
| Que no se vuelva a romper | Usar **Ignorar** en el aviso; no usar **Actualizar** salvo que sepas qué hace y tengas backup. |
| Recuperar proyectos/apps en desarrollo | **Opciones > Restaurar** con un backup previo. |
| Recuperar lo que se ve en el navegador (producción) | **Volver a publicar** el proyecto desde desarrollo al mismo directorio de producción. |
| Dudas o caso específico | Foro o soporte ScriptCase. |

Referencias: [Visión general entorno de producción](https://www.scriptcase.net/docs/es_es/v9/manual/12-despliegue/04-entorno-de-produccion/01-vision-general/), [Configuración de producción](https://www.scriptcase.net/docs/es_es/v9/manual/12-despliegue/04-entorno-de-produccion/04-configuracion-produccion/).
