# Visor de documentos administrativo (SCE_ASP)

Documentación para revisar en una sola pantalla los archivos que el aspirante subió en la convocatoria vigente, sin exponer rutas directas bajo `_lib/file/doc`.

## Objetivo

- El personal INECOL abre el formulario/grid **`form_asp_requisitos_admvo`** y usa un enlace **“Ver documentos”** con **token HMAC** (mismo patrón que la guía `TOKEN_SCRIPTCASE_GUIA.md` en `formatos-pago/docs` en el servidor).
- El visor lista requisitos desde **`asp_requisitos`** + leyenda desde **`sce.list_req_gral`** y sirve PDF/JPG solo tras validar sesión iniciada con ese token.

## Datos y convocatoria

- Al registrar un aspirante, [`add_asp_aspirantes`](../../app_form_add_users/metodos/add_asp_aspirantes) inserta filas en `asp_requisitos` según `list_req_gral` de la convocatoria activa (`generacion`, `num_req`, `prefijo_requisito`, etc.).
- El SQL del form admin ([`sql.sql`](../sql.sql)) ya expone `id_asp_FK`, `login_FK`, `num_req`, `archivo`, flags de revisión, etc.

## Ubicación de archivos en disco (producción verificada)

Ruta típica en el servidor:

```text
/opt/lampp/htdocs/sce_asp/_lib/file/doc/aspirantes/{generacion}/{email_del_aspirante}/{nombre_archivo}
```

Ejemplo: `.../aspirantes/2026/usuario@gmail.com/2026_311_01_cart_solicitud.pdf`

**Nota:** En algunos entornos se menciona una subcarpeta `documentos/`; en el muestreo de `2026` los PDF estaban **directamente** bajo el correo. El visor resuelve la ruta con:

1. Campo **`asp_requisitos.archivo`** (solo el nombre base, vía `basename()`).
2. **`aspirantes.generacion`** + **`aspirantes.email`** (o `login_FK` si `email` viene vacío).

## Código del visor (despliegue)

Fuente versionada en el repo:

- [`/opt/sce_asp_scriptcase/visor-requisitos-admvo/`](/opt/sce_asp_scriptcase/visor-requisitos-admvo/)

En el servidor web debe quedar accesible como URL pública, por ejemplo:

- `https://posgrados.inecol.mx/visor-requisitos-admvo/`

**Recomendación:** enlace simbólico desde `htdocs`:

```bash
ln -sfn /opt/sce_asp_scriptcase/visor-requisitos-admvo /opt/lampp/htdocs/visor-requisitos-admvo
```

### Configuración

1. Copiar `config.local.example.php` → `config.local.php` (este archivo **no** se versiona; está cubierto por `.gitignore`).
2. Definir `TOKEN_SECRET` (cadena larga aleatoria, **distinta** a la de formatos-pago).
3. Ajustar `VISOR_PUBLIC_BASE_URL`, `DB_*`, `ASPIRANTS_DOC_ROOT` si las rutas difieren.

### Contrato HTTP

| Parámetro | Uso |
|-----------|-----|
| `index.php?type=adm-visor-req&id={id_asp}&token=...` | Lista de requisitos + enlaces a vista/descarga. |
| `serve.php?id_req={id_asp_req}` | Sirve el binario (requiere sesión PHP válida abierta por `index.php`). |

Errores habituales: **403** (token inválido/expirado, sesión caducada, archivo fuera de ruta permitida).

- `type` **`adm-visor-req`** forma parte de la firma; un token de otro `type` no sirve.

## Integración Scriptcase (`form_asp_requisitos_admvo`)

Ver fragmentos listos para copiar en:

- [`../snippets/integracion_scriptcase_visor.php`](../snippets/integracion_scriptcase_visor.php)

### Dónde colocar el código

| Tipo de app | Evento sugerido |
|-------------|-----------------|
| **Grid** de requisitos | **`onRecord`**: añadir botón/enlace por fila usando `{id_asp_FK}` (o el campo que corresponda al aspirante). |
| **Form** (requisitos por registro) | **`onLoad`**: generar el token y emitir JavaScript que inserte el enlace (implementado en [`../Eventos/onLoad`](../Eventos/onLoad)). **No** pongas el HTML dentro de `id_asp_FK`: en Scriptcase ese campo es **numérico** y el valor se escapa; el `<a>` no se renderiza. |
| **Form** | **Botón** de barra → `onExecute` con `window.open` / `sc_redir` si no quieres JS inyectado. |
| **`onApplicationInit`** | No sustituye a `onLoad` para esta URL: corre al iniciar la app; al cambiar de registro el `id_asp` cambia y el enlace debe recalcularse al cargar cada registro (véase manual v9: eventos de formulario, `onLoad` / `onLoadRecord`). |

### Publicación desde Scriptcase (obligatorio)

Los archivos bajo [`../Eventos/`](../Eventos/) en Git **no** sustituyen al código que ejecuta el servidor. Scriptcase inyecta el evento en el PHP generado (`*_apl.php`, `*_js0.php`, etc.) solo cuando en el IDE se pega el código, se **genera código fuente** y se **publica** al entorno (`sce_asp_test`, `sce_asp`, etc.).

Pasos recomendados:

1. Abrir la aplicación `form_asp_requisitos_admvo` en Scriptcase y confirmar que el evento **onLoad** contiene el mismo contenido que [`../Eventos/onLoad`](../Eventos/onLoad) (o equivalente).
2. **Generar código fuente** y **publicar** hacia la carpeta del entorno de pruebas o producción.

### Verificación en el PHP generado (servidor)

Tras publicar, en el host donde quedó la app debe aparecer texto reconocible del visor. Ejemplo para pruebas bajo `sce_asp_test`:

```bash
grep -R "adm-visor-req" /opt/lampp/htdocs/sce_asp_test/form_asp_requisitos_admvo/
```

Si **no** hay coincidencias, el botón no puede mostrarse: el fallo es de **publicación o sincronización del evento**, no de la lógica del visor en sí. Compruebe también en el navegador (F12) el elemento `#sc_btn_visor_expediente_admvo` o el texto “Abrir expediente”.

### Formulario multipágina y detalle en iframe

Este formulario puede usarse como **multiregistro / paginación parcial** y embebido con `script_case_detail=Y` (iframe). En ese contexto:

- La barra `.scFormToolbar` puede **no existir**; el evento inserta el enlace con **`position: fixed`** (esquina superior derecha) cuando no hay toolbar reconocible.
- En **onLoad** global, la macro `{id_asp_FK}` a veces viene **vacía**; el código intenta entonces resolver `id_asp` vía **`{id_asp_req}`** y `sc_lookup` a `asp_requisitos.id_asp_FK`. El token HMAC se genera **solo en PHP**; no basta leer `id_asp` en el DOM sin un endpoint adicional firmado en servidor.

Rutas del visor en disco que prueba el evento (la primera que exista con `lib/token.php`):

- `/opt/lampp/htdocs/visor-requisitos-admvo`
- `/opt/sce_asp_scriptcase/visor-requisitos-admvo`

Requisitos en el servidor PHP de Scriptcase:

- `require_once` a `config.php` y `lib/token.php` del visor (ruta **absoluta** en disco, igual que en la guía de formatos-pago).

## Seguridad

1. **Token HMAC + expiración:** evita enumeración trivial de `id_asp`; si el enlace se filtra dentro del TTL, sigue siendo usable (usar TTL corto en `config.local.php`).
2. **Sesión en el visor:** tras abrir `index.php` con token válido, `serve.php` solo entrega archivos si la sesión contiene el mismo `id_asp` y la fila `id_asp_req` pertenece a ese aspirante.
3. **Path traversal:** solo se usa `basename(archivo)` y `realpath()` bajo el directorio base del aspirante.
4. **MIME:** solo se sirven extensiones permitidas (pdf, jpg, jpeg, png).
5. **Bloqueo HTTP directo a `_lib/file/doc`:** en este despliegue se añadió [`/opt/lampp/htdocs/sce_asp/_lib/file/doc/.htaccess`](/opt/lampp/htdocs/sce_asp/_lib/file/doc/.htaccess) con `Require all denied`. **Importante:** después de aplicarlo, probar que el flujo del aspirante en Scriptcase (previsualización/descarga que use URL directa) siga funcionando; si no, valorar reglas más finas o mover el storage fuera de `htdocs` a mediano plazo.

## Pruebas manuales

1. Configurar `config.local.php` y abrir `index.php` sin token → 403.
2. Desde Scriptcase (usuario admin), generar URL con token y abrir → tabla con requisitos.
3. Clic en “Ver” PDF → se muestra o descarga según navegador.
4. Requisito sin `archivo` en BD → fila indica “Sin archivo”.
5. Tras expirar token, recargar lista → 403; generar nuevo enlace desde Scriptcase.

## Mantenimiento

- Si cambia `TOKEN_SECRET`, todos los enlaces emitidos antes quedan inválidos.
- Mantener el mismo `TOKEN_SECRET` en **un solo** `config.local.php` del visor (Scriptcase solo genera tokens leyendo esa config).
