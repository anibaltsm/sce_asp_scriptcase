# Permisos de aplicaciones – Módulo de seguridad (sec_asp)

## Dos “botón Guardar” distintos

| Dónde no se ve | Causa | Dónde se corrige |
|----------------|--------|-------------------|
| **En la pantalla de Seguridad → Grupos / Aplicaciones** (al editar permisos de una app) | La app no está en `sec_asp_apps` o tiene `app_type` vacío. | `sec_asp_apps`: que la app exista y tenga `app_type = 'form'` (o el tipo que corresponda). |
| **En el formulario form_asp_requisitos_1** cuando lo abre un usuario (ej. **Recomendante**, grupo 7) | Para el grupo de ese usuario, en `sec_asp_groups_apps` la app tiene `priv_access = 'N'` o `priv_update = 'N'` (o NULL). ScriptCase oculta el botón Guardar/Update. | `sec_asp_groups_apps`: para el grupo del usuario (**7 = Recomendante**), poner `priv_access = 'Y'` y `priv_update = 'Y'` para `form_asp_requisitos_1`. |

**Diagnóstico (solo lectura):** ejecutar primero `data/sql_diagnostico_form_asp_requisitos_1.sql` para ver el estado actual en `sec_asp_apps` y `sec_asp_groups_apps` (y confirmar que el grupo Recomendante es el 7).  
**Script de corrección:** `data/sql_form_asp_requisitos_1_ver_boton_guardar.sql` (registra la app en `sec_asp_apps` con `app_type = 'form'` y da acceso + actualización al **grupo 7 = Recomendante** para que en el form se vea el Guardar).

---

## Solución probada: form_asp_requisitos_1 sin botón Guardar (grupo Recomendante)

**Problema:** El usuario que entra como **Recomendante** (grupo 7) abre el formulario `form_asp_requisitos_1` y **no ve el botón Guardar**.

**Causa:** En `sec_asp_groups_apps`, para `group_id = 7` y `app_name = 'form_asp_requisitos_1'`, los permisos estaban en `'N'` (priv_access, priv_update, etc.). ScriptCase oculta el botón Guardar cuando el grupo no tiene `priv_access = 'Y'` y `priv_update = 'Y'`.

**Pasos que funcionan:**

1. **Diagnóstico (solo lectura, no modifica nada):**
   ```bash
   mysql -u root -h 127.0.0.1 -p<contraseña> sce_asp < data/sql_diagnostico_form_asp_requisitos_1.sql
   ```
   Revisar la salida: confirmar que el grupo 7 = Recomendante y ver los valores actuales de `priv_access`, `priv_update` para form_asp_requisitos_1.

2. **Aplicar corrección:**
   ```bash
   mysql -u root -h 127.0.0.1 -p<contraseña> sce_asp < data/sql_form_asp_requisitos_1_ver_boton_guardar.sql
   ```
   El script asegura que la app esté en `sec_asp_apps` con `app_type = 'form'` y pone para el grupo 7: `priv_access = 'Y'`, `priv_insert = 'Y'`, `priv_update = 'Y'`.

3. **En la aplicación:** Cerrar sesión y volver a entrar como usuario Recomendante. Abrir form_asp_requisitos_1; el botón Guardar debe mostrarse.

**Resultado esperado en BD (grupo 7):** `priv_access = Y`, `priv_update = Y`. Con eso el botón Guardar ya se ve en el form.

---

## Por qué no aparece el botón Guardar para una aplicación (pantalla de permisos)

En ScriptCase, los permisos por grupo usan **dos tablas** en la BD `sce_asp`:

| Tabla | Uso |
|-------|-----|
| **sec_asp_apps** | Lista de aplicaciones que el módulo de seguridad conoce. **Si la app no está aquí, no podrás asignarle permisos** (y puede no aparecer el botón Guardar). |
| **sec_asp_groups_apps** | Permisos por grupo: (`group_id`, `app_name`) y columnas `priv_access`, `priv_insert`, `priv_delete`, `priv_update`, `priv_export`, `priv_print`. |

Si **form_asp_requisitos_1** no está en `sec_asp_apps`, la pantalla de permisos por grupo no la tendrá “registrada” y por eso no se puede guardar.

**Causas habituales por las que no sale el botón Guardar:**

1. La aplicación no está en **sec_asp_apps**.
2. **`app_type` vacío en sec_asp_apps.** Si la app está en la lista pero **no deja guardar** mientras otra sí (ej. form_asp_recomendantes sí, form_recomendantes_1 no), compara en BD: la que funciona tiene `app_type = 'form'` (o `'grid'`, `'cons'`, etc.) y la que no suele tener `app_type = ''`. ScriptCase usa `app_type` para considerar la fila editable. Solución: `UPDATE sec_asp_apps SET app_type = 'form', description = '...' WHERE app_name = 'form_recomendantes_1';` (ver **data/sql_fix_form_recomendantes_1_permisos.sql**).
3. En **sec_asp_groups_apps** los permisos están en **NULL** o vacíos. La interfaz a veces solo muestra o habilita Guardar cuando los valores son `'Y'` o `'N'`. Ejecutar **data/sql_fix_permisos_form_asp_requisitos_1.sql** (o el de form_recomendantes_1) deja esos valores en Y/N.
4. Apps con nombres inválidos en **sec_asp_apps** (ej. **.DS_Store**) pueden romper la pantalla. El script de requisitos opcionalmente borra `.DS_Store`.
5. En la interfaz hay que **abrir el grupo** (o la aplicación) sobre el que quieres cambiar permisos; a veces el botón Guardar solo aparece en esa pantalla de detalle.

---

## Solución 1: Sincronizar aplicaciones (recomendado)

1. En ScriptCase, abre el **Módulo de seguridad** (por grupo).
2. Ejecuta la opción **Sincronizar aplicaciones** (o “Sincronización de aplicaciones” / app que publique las apps del proyecto).
3. Eso rellena `sec_asp_apps` con las aplicaciones del proyecto, incluida **form_asp_requisitos_1** si existe en el proyecto.
4. Después de sincronizar, entra de nuevo a **Permisos por grupo** y asigna los permisos a **form_asp_requisitos_1**; el botón Guardar debería aparecer y funcionar.

Si al sincronizar da error 500 o “Duplicate entry”, ver **consulta_ia/DEBUG_500_APP_SYNC_APPS.md**.

---

## Solución 2: Registrar la app a mano en la BD

Si no puedes usar la sincronización, puedes insertar la aplicación directamente en `sec_asp_apps`:

```sql
-- Usar la BD del proyecto (sce_asp)
USE sce_asp;

-- Registrar la aplicación para que aparezca en permisos por grupo
INSERT IGNORE INTO sec_asp_apps (app_name, app_type, description)
VALUES ('form_asp_requisitos_1', 'form', 'Form Asp Requisitos 1');
```

- **app_name:** debe ser **exactamente** el nombre de la aplicación en ScriptCase (carpeta de la app).
- **app_type:** suele ser `form`, `grid`, `menu`, etc., según el tipo de aplicación.
- **description:** texto libre para identificarla.

Después de este `INSERT`, entra en el módulo de seguridad → Permisos por grupo y asigna permisos a **form_asp_requisitos_1**; el botón Guardar debería funcionar.

---

## Cómo se guardan los permisos (sec_asp_groups_apps)

Cuando en la interfaz marcas permisos y guardas, ScriptCase escribe en **sec_asp_groups_apps**:

- **group_id:** número del grupo (1, 2, 3, 4, 5, 6, …).
- **app_name:** mismo nombre que en `sec_asp_apps` (ej. `form_asp_requisitos_1`).
- **priv_access, priv_insert, priv_delete, priv_update, priv_export, priv_print:** normalmente `'Y'` o `'N'`.

Ejemplo para dar solo acceso y actualización al grupo 2:

```sql
USE sce_asp;

INSERT INTO sec_asp_groups_apps (group_id, app_name, priv_access, priv_insert, priv_delete, priv_update, priv_export, priv_print)
VALUES (2, 'form_asp_requisitos_1', 'Y', 'N', 'N', 'Y', 'N', 'N')
ON DUPLICATE KEY UPDATE
  priv_access = 'Y',
  priv_insert = 'N',
  priv_delete = 'N',
  priv_update = 'Y',
  priv_export = 'N',
  priv_print = 'N';
```

(Ajusta `group_id` y los `'Y'`/`'N'` según lo que necesites.)

---

## Resumen

| Problema | Qué hacer |
|----------|-----------|
| No sale el botón Guardar para **form_asp_requisitos_1** | La app no está en **sec_asp_apps**. Sincronizar aplicaciones o hacer `INSERT` en `sec_asp_apps` como arriba. |
| Los permisos se guardan en | **sec_asp_groups_apps** (por grupo y aplicación). |
| Nombre de la app | Debe coincidir **exactamente** con el nombre de la carpeta de la aplicación en el proyecto (ej. `form_asp_requisitos_1`). |

Si el nombre real de la app en tu proyecto es otro (por ejemplo con otro sufijo o sin `_1`), usa ese mismo nombre en `app_name` en ambas tablas.

---

## Por qué no aparece el botón Guardar (revisado con proyecto sce)

En el proyecto **sce** (y en **sce_asp**) la aplicación que edita permisos por grupo es **app_form_sec_groups_apps**. En el PHP generado (`*_apl.php`) hace:

1. `SELECT app_name, app_type FROM sec_asp_apps` (en sce_asp; en sce es `sec_apps`) y guarda en `$_SESSION['arr_apps']` (app_name → app_type).
2. Por cada fila (cada aplicación), hace `switch(trim(app_type))`:
   - **`case 'form':`** → no deshabilita nada → la fila se puede editar y **aparece el Guardar**.
   - **`case 'cons':`** → deshabilita insert/delete/update.
   - **`default:`** (app_type vacío o cualquier otro valor) → deshabilita **todos** los permisos (insert, delete, update, export, print) → **no se puede guardar** esa fila.

Por tanto, si **form_asp_requisitos_1** tiene `app_type` vacío en **sec_asp_apps**, esa fila entra en `default` y el botón Guardar no aparece para ella.

**Qué hacer:**

1. **Base de datos:** Asegurar en `sce_asp` que la app tenga `app_type = 'form'`:
   ```sql
   UPDATE sec_asp_apps SET app_type = 'form', description = COALESCE(NULLIF(TRIM(description),''), 'Form Asp Requisitos') WHERE app_name = 'form_asp_requisitos_1';
   ```
2. **Caché de sesión:** El formulario carga `sec_asp_apps` al cargar la página y guarda el resultado en **sesión** (`$_SESSION['arr_apps']`). Si entraste a Grupos/Aplicaciones cuando `app_type` estaba vacío, la sesión sigue teniendo el valor antiguo.
   - Cierra **todas** las pestañas de ese proyecto (sce_asp) en el navegador, o cierra sesión en ScriptCase y vuelve a entrar.
   - Vuelve a abrir **Seguridad → Grupos / Aplicaciones** y filtra por la aplicación. Al cargar de nuevo, se vuelve a ejecutar el `SELECT` y se rellena `arr_apps` con `app_type = 'form'`; el Guardar debería aparecer para **form_asp_requisitos_1**.
