# Consulta rápida – Soporte y fallos (sce_asp_scriptcase)

Documento en **raíz del proyecto** para localizar soluciones cuando algo falle. Usar como índice o “skill” de consulta.

---

## Dónde está cada cosa

| Tema | Archivo / carpeta | Para qué sirve |
|------|-------------------|----------------|
| **Base de datos sce_asp** | `README_BD_SCE_ASP.md` | Estructura, tablas, relaciones, convenciones. |
| **Permisos (Guardar en Grupos/Aplicaciones, menú deshabilitado)** | `data/PERMISOS_APLICACION_SEC_ASP.md` | Por qué no sale el botón Guardar, app_type, sec_asp_apps / sec_asp_groups_apps. |
| **Error 500 al sincronizar aplicaciones** | `consulta_ia/DEBUG_500_APP_SYNC_APPS.md` | Causa (carpeta friendly_url, array_diff), logs, onValidate corregido, Parse error. |
| **Form recomendantes (eventos, método, flujo)** | `scriptcase/apps/form_recomendantes/` | README, Eventos (onValidate, onAfterUpdate, onLoadRecord…), método crear_usuario_recomendante. |
| **Índice y guías form_recomendantes** | `scriptcase/apps/form_recomendantes/docs/INDEX.md` | Índice de toda la documentación del form. |
| **Guía para IA (form_recomendantes)** | `consulta_ia/GUIA_FORM_RECOMENDANTES.md` | Contexto para IA: tablas, flujo, logs, problemas conocidos. |

---

## Fallos frecuentes y qué abrir

| Síntoma | Dónde mirar | Acción rápida |
|--------|-------------|----------------|
| **500 al hacer “Sincronizar aplicaciones”** | `consulta_ia/DEBUG_500_APP_SYNC_APPS.md` | Crear carpeta `_lib/friendly_url` en htdocs/sce_asp o usar onValidate corregido del mismo doc. Revisar `php_error_log`. |
| **No sale el botón Guardar en Grupos/Aplicaciones** | `data/PERMISOS_APLICACION_SEC_ASP.md` | Comprobar que la app esté en sec_asp_apps y que `app_type` no esté vacío. Scripts en `data/sql_fix_permisos_*.sql`, `sql_fix_form_recomendantes_1_permisos.sql`. |
| **No se ve el botón Guardar en el form form_asp_requisitos_1** (al abrirlo como Recomendante) | `data/PERMISOS_APLICACION_SEC_ASP.md` (sección **Solución probada**) | 1) Diagnóstico: `data/sql_diagnostico_form_asp_requisitos_1.sql`. 2) Corrección: `data/sql_form_asp_requisitos_1_ver_boton_guardar.sql`. 3) Cerrar sesión y volver a entrar. Grupo **Recomendante = 7** debe quedar con `priv_access = 'Y'` y `priv_update = 'Y'`. Solución probada y documentada. |
| **Ítem “Recomendantes” en gris / no activo en el menú** | `data/PERMISOS_APLICACION_SEC_ASP.md`, `data/sql_permiso_aspirante_form_recomendantes.sql` | Dar `priv_access = 'Y'` a form_recomendantes para grupo 2 (Aspirante) en sec_asp_groups_apps. Ejecutar el SQL del script. Cerrar sesión y volver a entrar. |
| **Tabla no existe (sce.asp_recomendantes)** | `README_BD_SCE_ASP.md` | Las tablas de aspirantes/recomendantes están en BD **sce_asp**. Usar prefijo `sce_asp.` en las consultas (ej. `sce_asp.asp_recomendantes`). |
| **Truncated incorrect DOUBLE value (correos/nombres)** | Método `crear_usuario_recomendante` | Si sc_sql_injection() no añade comillas, los strings deben ir entre comillas en el SQL. |
| **Error SQL syntax: `''valor''` al agregar recomendante** | Método `crear_usuario_recomendante` | En tu ScriptCase, **sc_sql_injection() ya devuelve el valor entre comillas**. No añadir comillas manuales: usar solo `sc_sql_injection($x)` en INSERT/UPDATE para strings. Si se añade `'" . sc_sql_injection($x) . "'"` se generan comillas dobles y falla el SQL. |
| **Form recomendantes: eventos, crear usuario, correos** | `scriptcase/apps/form_recomendantes/README.md`, `docs/INDEX.md` | Ver orden de eventos, método crear_usuario_recomendante, envío de correos. |
| **Correo y usuario creados pero recomendantes sin login_FK / cc_edit=0** | Evento `onAfterUpdate` | No usar **sc_redir** dentro de onAfterUpdate: puede provocar rollback de la transacción del form y que el UPDATE a `recomendantes` (login_FK, cc_edit) no se persista. Si persiste: revisar permisos UPDATE en `sce_asp.recomendantes` para el usuario de la conexión. |

---

## Activación de usuarios (sec_asp_users)

| Campo / flujo | Uso |
|---------------|-----|
| **sec_asp_users.active** | `'Y'` = puede entrar al login (App_login). `'N'` = mensaje "cuenta no activa". |
| **sec_asp_users.activation_code** | Código que se envía por correo en **app_form_add_users** (aspirantes). Al abrir `app_form_add_users/index.php?a={codigo}` se activa la cuenta (UPDATE active='Y'). La lógica del parámetro `a` puede estar en eventos o en el código generado por ScriptCase. |
| **Aspirantes (app_form_add_users)** | Se crean por el formulario (normalmente `active='N'`). Reciben correo con enlace `?a=...`; al hacer clic se activa la cuenta. |
| **Recomendantes (crear_usuario_recomendante)** | Mismo flujo que aspirantes: se crean con **active='N'**; se envía correo con enlace `app_form_add_users/index.php?a={codigo}`; al hacer clic se activa la cuenta (active='Y'). |

---

## Scripts SQL en `data/` (para aplicar a mano si hace falta)

| Script | Uso |
|--------|-----|
| `sql_permiso_aspirante_form_recomendantes.sql` | Activar “Recomendantes” en menú Aspirante (priv_access Y para grupo 2). |
| `sql_fix_permisos_form_asp_requisitos_1.sql` | Poner Y/N en permisos de form_asp_requisitos_1 y quitar .DS_Store de sec_asp_apps. |
| `sql_diagnostico_form_asp_requisitos_1.sql` | **Solo lectura:** ver estado de form_asp_requisitos_1 en sec_asp_apps y sec_asp_groups_apps; confirmar grupo Recomendante (7). Ejecutar ANTES de cualquier corrección. |
| `sql_form_asp_requisitos_1_ver_boton_guardar.sql` | Que en el form form_asp_requisitos_1 se vea el botón Guardar para **Recomendante (grupo 7)**: app en sec_asp_apps con app_type=form + grupo 7 con priv_access/priv_update Y. |
| `sql_fix_form_recomendantes_1_permisos.sql` | Poner app_type = 'form' para form_recomendantes_1 (y form_recomendantes). |
| `sql_permisos_recomendantes_todos_Y.sql` | Dar todos los permisos (Y) a las apps de recomendantes para grupo 7 (Recomendante). |
| `sql_insert_app_sec_asp_apps.sql` | Registrar una app en sec_asp_apps (ej. form_asp_requisitos_1). |

---

## Logs (XAMPP macOS)

- **PHP:** `tail -100 /Applications/XAMPP/xamppfiles/logs/php_error_log`
- **Apache:** `tail -50 /Applications/XAMPP/xamppfiles/logs/error_log`
- **Seguir en vivo:** `tail -f /Applications/XAMPP/xamppfiles/logs/php_error_log`

---

## BD y conexión

- **Proyecto aspirantes/recomendantes:** BD **sce_asp** (no sce).
- **Tablas clave:** sec_asp_apps, sec_asp_groups, sec_asp_groups_apps, sec_asp_users, sec_asp_users_groups; recomendantes, asp_recomendantes.
- **Ejemplo conexión:** `mysql -u root -h 127.0.0.1 -p... sce_asp -e "SELECT ..."`

---

*Actualizado para consulta cuando falle algún archivo o flujo. Revisar los archivos enlazados para el detalle.*
