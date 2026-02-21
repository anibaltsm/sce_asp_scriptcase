# Cómo diagnosticar el error 500 en app_sync_apps

**URL que falla:** `POST http://localhost/sce_asp/app_sync_apps/`  
**Referrer:** `http://localhost/sce_asp/menu/menu.php`  
**Código:** 500 Internal Server Error

---

## Qué es app_sync_apps

`app_sync_apps` es una **aplicación interna de ScriptCase** (sincronización/publicación de apps). No está en este repositorio; el código que la atiende está en la instalación de ScriptCase (por ejemplo bajo `htdocs/sce_asp/` o la ruta que uses para el proyecto).

Un 500 en esa URL suele indicar:

1. **Error PHP** al ejecutar el script de sync (parse, fatal, etc.).
2. **Error en alguna app** que ScriptCase carga o procesa durante la sincronización.
3. **Permisos, extensión PHP o configuración** del servidor.

La causa concreta **solo se puede ver en los logs del servidor**, no en el navegador.

---

## Dónde ver el error (logs)

### 1. Log de PHP (recomendado)

En **XAMPP (macOS)**:

```bash
# Ver últimas líneas del log de PHP (donde suelen aparecer Fatal/Parse)
tail -100 /Applications/XAMPP/xamppfiles/logs/php_error_log

# Filtrar solo errores graves
tail -200 /Applications/XAMPP/xamppfiles/logs/php_error_log | grep -i "fatal\|parse\|error\|exception"

# Buscar algo relacionado con sync o form_recomendantes
tail -300 /Applications/XAMPP/xamppfiles/logs/php_error_log | grep -i "sync\|app_sync\|form_recomendantes"
```

En **Linux** (según tu configuración):

```bash
tail -100 /var/log/apache2/error.log
# o
tail -100 /var/log/php*error*
```

### 2. Log de Apache

A veces el 500 se registra solo en el log de Apache:

- XAMPP: `/Applications/XAMPP/xamppfiles/logs/error_log`
- Linux: `/var/log/apache2/error.log`

```bash
tail -50 /Applications/XAMPP/xamppfiles/logs/error_log
```

### 3. Reproducir el error y ver el log al momento

1. Deja una terminal con:

   ```bash
   tail -f /Applications/XAMPP/xamppfiles/logs/php_error_log
   ```

2. En el navegador, vuelve a hacer la acción que dispara el POST a `app_sync_apps` (por ejemplo, desde el menú de ScriptCase).
3. En la terminal debería aparecer la línea con el **Fatal error**, **Parse error** o **Exception** que causa el 500.

---

## Errores conocidos en este proyecto (form_recomendantes)

Si durante el sync se carga o se genera código de **form_recomendantes**, ten en cuenta:

| Mensaje típico en log | Causa | Qué hacer |
|-----------------------|--------|-----------|
| `unexpected identifier "recom"` | ScriptCase generó `$this->id recom` (campo con espacio). | En ScriptCase: Form Settings → Fields → **Id Recom** → cambiar nombre a `Id_Recom` o `id_recom`. Regenerar y volver a desplegar. |
| Parse error / syntax en eventos | Código inválido en eventos (por ejemplo `if (!sc_confirm())`). | Revisar eventos en ScriptCase; usar solo `sc_confirm("mensaje");` sin condicional. |
| Error en `crear_usuario_recomendante` o en BD | Falta tabla/columna o conexión. | Verificar BD `sce_asp`, tablas `recomendantes`, `sec_asp_users`, `sec_asp_users_groups` y que el campo `cc_edit` exista en `recomendantes`. |

Más detalle de eventos y logs: **consulta_ia/GUIA_FORM_RECOMENDANTES.md** (sección LOGS y PROBLEMAS CONOCIDOS).

---

## Resumen de pasos

1. Reproducir el 500 (acción desde el menú que hace POST a `app_sync_apps`).
2. Ver **php_error_log** (y si hace falta **error_log** de Apache) justo después.
3. Localizar la línea con **Fatal**, **Parse** o **Exception**; esa línea indica archivo y número de línea del fallo.
4. Si el error apunta a **form_recomendantes** o a un campo `id recom`, aplicar las soluciones de la tabla anterior.
5. Si el error es de otra app o del núcleo de ScriptCase, habrá que revisar esa app o la instalación de ScriptCase según el mensaje.

Si pegas aquí la **línea exacta del log** que aparece al reproducir el 500, se puede concretar la causa y el cambio a hacer.

---

## Diagnóstico aplicado (Feb 2026)

**Error en log:**
```text
PHP Fatal error: Uncaught TypeError: array_diff(): Argument #1 ($array) must be of type array, bool given
in .../app_sync_apps/app_sync_apps_apl.php:1781
```

**Causa:** En la línea 1781 el código hace `scandir($this->Ini->path_aplicacao . "../_lib/friendly_url/")`. Esa carpeta **no existe** en el despliegue (htdocs/sce_asp/_lib/friendly_url/), por tanto `scandir()` devuelve `false` y `array_diff(false, ...)` lanza el error en PHP 8.

**Qué hacer:**

1. **En ScriptCase (recomendado):** Corregir el **onValidate** de app_sync_apps para que no use `scandir()` sin comprobar si la carpeta existe. Si la carpeta no existe, usar array vacío. Ver bloque **"onValidate corregido (copiar/pegar)"** más abajo en este documento.

2. **En el servidor (solución inmediata si no puedes editar onValidate aún):** Crear la carpeta vacía en el proyecto desplegado:
   ```bash
   mkdir -p /Applications/XAMPP/xamppfiles/htdocs/sce_asp/_lib/friendly_url
   ```

3. **Además:** Revisar si el proyecto usa **URL amigable / Friendly URL**. Si está desactivado, la carpeta `_lib/friendly_url` puede no generarse al desplegar. Hacer un **despliegue completo** (Deploy) para que ScriptCase cree la estructura `_lib` en htdocs.

---

## Error "Duplicate entry" en sec_asp_groups_apps (Feb 2026)

**Mensaje:**  
`Duplicate entry '4-form_rev_desem_mae_2025' for key 'sec_asp_groups_apps.PRIMARY'`  
`INSERT INTO sec_asp_groups_apps(app_name, group_id) VALUES ('form_rev_desem_mae_2025', '4')`

**Causa:** La misma app puede aparecer más de una vez en la lista (p. ej. por friendly_url y por carpeta sin friendly), o el registro ya existía de una sincronización anterior. Al insertar en `sec_asp_groups_apps` sin comprobar, se intenta insertar una fila que ya existe y la PRIMARY KEY falla.

**Qué hacer en ScriptCase (onValidate de app_sync_apps):**

1. **Opción recomendada:** Usar **INSERT IGNORE** para que los duplicados se ignoren y no generen error.  
   Busca la línea donde se inserta en `sec_asp_groups_apps`:
   ```php
   $sql = "INSERT INTO sec_asp_groups_apps(app_name, group_id) VALUES ('". $app ."', '". $grp ."')";
   sc_exec_sql( $sql );
   ```
   Cámbiala por:
   ```php
   $sql = "INSERT IGNORE INTO sec_asp_groups_apps(app_name, group_id) VALUES ('". $app ."', '". $grp ."')";
   sc_exec_sql( $sql );
   ```

2. **Opcional (evitar duplicados en la lista):** Justo después de  
   `$arr_apps = array_diff($arr_apps, $arr_apps_db);`  
   añade:
   ```php
   $arr_apps = array_values(array_unique($arr_apps));
   ```
   Así cada app se procesa solo una vez.

Tras cambiar, **regenerar código** de app_sync_apps y **volver a desplegar**.

---

## onValidate corregido (copiar/pegar)

Si al hacer sync obtienes **500** por `array_diff(): Argument #1 ($array) must be of type array, bool given`, sustituye todo el contenido del evento **onValidate** de **app_sync_apps** por el siguiente. Así se evita usar `scandir()` cuando la carpeta no existe (PHP 8 devuelve `false` y rompe `array_diff`).

**Pasos:** ScriptCase → app_sync_apps → Events → onValidate → sustituir todo el código por:

```php
// Evitar 500: si _lib/friendly_url no existe, scandir devuelve false y array_diff(false,...) falla en PHP 8
$path_friendly = $this->Ini->path_aplicacao . "../_lib/friendly_url/";
$arr_apps = (is_dir($path_friendly) && is_array($tmp = @scandir($path_friendly))) ? $tmp : array();
$arr_apps = array_diff($arr_apps, array('.', '..', 'index.php', 'index.html'));

foreach ($arr_apps as $k => $v) {
    $arr_apps[$k] = substr($v, 0, -8);
}
if ({check_deleted} == 'Y') {
    foreach ($arr_apps as $k => $app) {
        if (!is_dir($this->Ini->path_aplicacao . "../" . $app)) {
            unset($arr_apps[$k]);
        }
    }
}

$path_parent = $this->Ini->path_aplicacao . "../";
$arr_parent = (is_dir($path_parent) && is_array($tmp = @scandir($path_parent))) ? $tmp : array();
$arr_apps_without_friendly = array_diff($arr_parent, array('.', '..', 'index.php', 'index.html', '_lib'), $arr_apps);
$arr_apps = array_merge($arr_apps, $arr_apps_without_friendly);
$arr_apps = array_values(array_unique($arr_apps));

sc_select(rs, "SELECT app_name FROM sec_asp_apps");
$arr_apps_db = array();
while (!$rs->EOF) {
    $arr_apps_db[] = $rs->fields[0];
    $rs->MoveNext();
}
$rs->Close();
$arr_apps = array_diff($arr_apps, $arr_apps_db);

$arr_grp = array();
sc_select(rs, "SELECT group_id FROM sec_asp_groups");
while (!$rs->EOF) {
    $arr_grp[] = $rs->fields[0];
    $rs->MoveNext();
}
$rs->Close();

foreach ($arr_apps as $k => $app) {
    $app_type = '';
    $friendly_name = $app;

    if (substr($app, -4) == '_mob' && file_exists($this->Ini->path_aplicacao . "../_lib/friendly_url/" . substr($app, 0, -4) . "_ini.txt")) {
        unset($arr_apps[$k]);
        continue;
    }

    if (is_file($this->Ini->path_aplicacao . "../_lib/friendly_url/" . $app . '_ini.txt')) {
        $friendly_name = trim(file_get_contents($this->Ini->path_aplicacao . "../_lib/friendly_url/" . $app . '_ini.txt'));
    }

    $file_ini = $this->Ini->path_aplicacao . "../" . $friendly_name . "/" . $app . "_ini.txt";
    if (is_dir($this->Ini->path_aplicacao . "../" . $friendly_name) && is_file($file_ini)) {
        $_app_type = file($file_ini);
        if (isset($_app_type[4])) {
            $app_type = trim($_app_type[4]);
        }
    }

    $sql = "SELECT count(*) FROM sec_asp_apps WHERE app_name = '" . $app . "' ";
    sc_lookup(rs, $sql);
    if ({rs[0][0]} == 0) {
        $sql = "INSERT INTO sec_asp_apps(app_name, app_type) VALUES ('" . $app . "', '" . $app_type . "')";
        sc_exec_sql($sql);
        foreach ($arr_grp as $grp) {
            $sql = "INSERT IGNORE INTO sec_asp_groups_apps(app_name, group_id) VALUES ('" . $app . "', '" . $grp . "')";
            sc_exec_sql($sql);
        }
    }
}
```

**Importante:** En ScriptCase el macro `{check_deleted}` se sustituye por el valor del campo; si tu evento usa otro nombre de variable (p. ej. sin llaves), ajústalo. Tras pegar: **Regenerar código** de app_sync_apps y **Desplegar** de nuevo.

---

## Si tras desplegar ves "Parse error" en línea 3827 o "nothing happened"

**Revisión de logs (Feb 2026):**

1. **Error 500 en línea 1781** (`array_diff(): Argument #1 must be of type array, bool given`): El archivo desplegado en **htdocs** aún tenía el código viejo. Asegúrate de **Desplegar** de nuevo tras cambiar el onValidate.
2. **Parse error en línea 3827** (`unexpected token ";", expecting "function"`): El archivo generado puede tener un **doble punto y coma** que rompe el parseo, o el **cierre `?>`** al final del archivo en algunos entornos da problemas.

**Qué hacer en el archivo desplegado** (en el servidor, no en ScriptCase):

- Ruta típica:  
  `htdocs/sce_asp/app_sync_apps/app_sync_apps_apl.php`  
  (en XAMPP macOS: `/Applications/XAMPP/xamppfiles/htdocs/sce_asp/app_sync_apps/app_sync_apps_apl.php`)

1. **Quitar doble punto y coma**  
   Busca (Ctrl+F):  
   `$this->nm_flag_saida_novo = "S";;`  
   Sustituye por:  
   `$this->nm_flag_saida_novo = "S";`  
   (una sola vez `;`).

2. **Opcional: quitar el cierre PHP al final**  
   Al final del archivo suele haber:
   ```php
   }
   ?>
   ```
   Deja solo:
   ```php
   }
   ```
   (sin la línea `?>`). En PHP es recomendable no cerrar con `?>` al final del archivo.

3. **Comprobar sintaxis** en la terminal:
   ```bash
   php -l /Applications/XAMPP/xamppfiles/htdocs/sce_asp/app_sync_apps/app_sync_apps_apl.php
   ```
   Debe decir: `No syntax errors detected`.

4. **Probar de nuevo** la sincronización desde el menú (Seguridad → Sincronizar aplicaciones).
