# form_agregar_recomendante — fuentes ScriptCase

**Todos los cambios deben hacerse aquí.** Copiar estos archivos a ScriptCase y regenerar. No editar archivos generados ni productivos.

## Estructura

- **Eventos:** `Eventos/onBeforeInsert.txt`, `Eventos/onAfterInsert.txt`
- **Métodos:** `metodos/validar_recomendante(...)`, `metodos/insert_asp_recomendante_after`, `metodos/mi_log($mensaje)`

## mi_log (evitar 500 / redeclare)

- **Solo existe** el método `mi_log($mensaje)`; su contenido es **solo el cuerpo** (sin `function` ni `function_exists`).
- **No** usar fallback `if (!function_exists('mi_log')) { function mi_log(...) }` en eventos ni métodos.
- Si se agrega ese fallback, ScriptCase genera **dos** métodos `mi_log` → "Cannot redeclare mi_log" → 500.

## Logs

- `mi_log($mensaje)` escribe en `logs/debug_log.txt` dentro de la carpeta de la app generada.
- Ruta: `<carpeta_form_agregar_recomendante>/logs/debug_log.txt`.

## "$ is not defined" (consola del navegador)

- Suele aparecer cuando la **página de error** (`form_agregar_recomendante_erro.php`) o la **redirección** (Fredir) se muestra **sin** cargar jQuery antes.
- Comprobar en **Network**: que `jquery.js` devuelva **200** (ruta `url_third` / `path_prod`).
- Asegurar que `_lib`, `third/jquery`, etc. estén desplegados en producción.
- Los archivos `*_erro.php`, `*_form0.php`, etc. son **generados** por ScriptCase; no se editan desde estas fuentes.

## Comprobar que prod tiene los cambios

En la app generada (ej. `form_agregar_recomendante_apl.php`):

- Una sola `function mi_log($mensaje)` (no dos).
- En `insert_asp_recomendante_after`:  
  `$this->mi_log("LAST_INSERT_ID (id_recom): " . (string)$this->rs_id[0][0]);`  
  (no `$id_recom` suelto).
- Sin `if (!function_exists('mi_log')) { function mi_log(...) }` en eventos ni métodos.

## Despliegue

1. Copiar estos archivos a ScriptCase (reemplazar los del proyecto).
2. Regenerar la aplicación en ScriptCase.
3. Desplegar/copiar la app generada a producción.
