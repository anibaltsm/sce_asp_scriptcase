# Validación: ¿Tiene sentido? + Consultas BD verificadas

Resumen de si las instrucciones que pegaste tienen sentido, qué corregir y las **consultas SQL y PHP ya probadas** contra la BD.

> **Nota:** En el repo la app de recomendantes en uso es **form_recomendantes** (Editable grid). Las apps form_agregar_recomendante y grid_aspirantes_recomendantes fueron eliminadas. Las secciones que citan form_agregar_recomendante siguen como referencia para consultas/validaciones reutilizables.

---

## 1. ¿Tiene sentido? **Sí, en conjunto**

El flujo es correcto:

1. **Grid** sobre `asp_recomendantes` + JOIN `recomendantes`, filtrado por aspirante.
2. **Botones** Agregar (+), Eliminar (X), Volver.
3. **Formulario** de alta en `recomendantes`; al guardar, insertar también en `asp_recomendantes` y redirigir al grid.

La BD lo soporta: tablas existen, la relación y el JOIN funcionan.

---

## 2. Consultas BD verificadas (ejecutadas en `sce_asp`)

### 2.1 Grid – lista de recomendantes del aspirante

**Uso:** Consulta principal del grid. Reemplaza `{id_asp}` por la variable de sesión del aspirante (en tu proyecto: `{id_asp}` o `[id_asp]`).

```sql
SELECT 
    ar.id_asp_recom,
    ar.id_asp_FK,
    ar.id_recom_FK,
    r.id_recom,
    r.nombre,
    r.apellido_p,
    r.apellido_m,
    r.correo
FROM asp_recomendantes ar
INNER JOIN recomendantes r ON ar.id_recom_FK = r.id_recom
WHERE ar.id_asp_FK = {id_asp}
ORDER BY ar.id_asp_recom;
```

**Comprobado:** Con `id_asp = 1222` devuelve 3 filas (ej. Carolina, Salvador, Juan).  
**Importante:** En ScriptCase uses `{id_asp}` (o el nombre que tengas en sesión). **No** `{SESSION[id_asp]}` salvo que tu versión lo documente así.

---

### 2.2 Validación: máximo 3 recomendantes (beforeInsert)

**Uso:** Comprobar que el aspirante tenga menos de 3 antes de insertar.

```sql
SELECT COUNT(*) AS total 
FROM asp_recomendantes 
WHERE id_asp_FK = {id_asp};
```

Si `total >= 3` → mostrar error y no insertar.

**Comprobado:** Para `id_asp_FK = 1222` devuelve `3`.

---

### 2.3 Validación: correo no repetido para el mismo aspirante (beforeInsert)

**Uso:** Evitar asignar otra vez un recomendante con el mismo correo a ese aspirante.

```sql
SELECT COUNT(*) AS total 
FROM asp_recomendantes ar 
INNER JOIN recomendantes r ON ar.id_recom_FK = r.id_recom
WHERE ar.id_asp_FK = {id_asp} 
  AND r.correo = {correo};
```

Si `total > 0` → “Este recomendante ya está asignado” (o similar).  
**Nota:** Usar siempre `sc_sql_injection` o parámetros para `{correo}`.

**Comprobado:** Para `id_asp = 1222` y `correo = 'carolina.valdespino@inecol.mx'` devuelve `1`.

---

### 2.4 afterInsert: insertar en `asp_recomendantes`

**Uso:** Tras insertar en `recomendantes`, enlazar ese recomendante con el aspirante.

```sql
INSERT INTO asp_recomendantes (id_asp_FK, id_recom_FK, num_req)
VALUES ({id_asp}, {id_recom}, {num_req});
```

- `{id_asp}`: sesión del aspirante.
- `{id_recom}`: `LAST_INSERT_ID()` después del INSERT en `recomendantes`.
- `{num_req}`: opcional. Puede ser 1, 2, 3 según el orden (p. ej. `COUNT(*) + 1` antes del INSERT).

**Comprobado:** Estructura de `asp_recomendantes` correcta; el INSERT es válido.

---

## 3. Qué ajustar respecto a las instrucciones que pegaste

| Punto | Instrucción original | Ajuste recomendado |
|-------|----------------------|---------------------|
| **Variable de sesión** | `{SESSION[id_asp]}` en SQL | Usar `{id_asp}` (o el nombre que use tu proyecto). En PHP, `$_SESSION['id_asp']` o variable global de ScriptCase. |
| **Funciones PHP** | `sc_get_db_object()`, `sc_last_id()`, `sc_DataSourceFieldValue()` | En tu proyecto se usan `sc_lookup`, `sc_exec_sql`, etc. Sustituir por esas. |
| **Obtener último ID** | `sc_last_id()` | `sc_lookup(rs, "SELECT LAST_INSERT_ID() AS id");` y usar `{rs[0][0]}`. |
| **Modal + redirección** | Abrir form en `window.open(..., "modal")` y en afterInsert `sc_redir` al grid | Si abres en modal, al guardar suele ser mejor cerrar el modal y recargar el grid en la ventana padre (p. ej. `opener.location.reload(); window.close();`). Si abres en misma ventana, `sc_redir` al grid está bien. |
| **Botón “GUARDAR CAMBIOS” en el grid** | Submit en el grid | El grid solo muestra datos (consulta). No hay formulario de edición en el grid. Ese botón sobra; el “Guardar” va solo en el **formulario** de agregar. |
| **Eliminar** | Columna Acciones → Delete | Correcto. Asegurar que la eliminación sea sobre `asp_recomendantes` usando `id_asp_recom`. |

---

## 4. Código PHP sugerido (estilo de tu proyecto)

Usando `sc_lookup`, `sc_exec_sql`, `sc_error_message`, `sc_redir`, como en `add_asp_aspirantes` y App_login.

### 4.1 beforeInsert (referencia; en el repo se usa `form_recomendantes` para editar los 3 recomendantes)

Valida obligatorios, email, máximo 3 y correo no repetido.  
Sustituye `{id_asp}` y los nombres de campo por los que use tu form si son distintos.

```php
$id_asp = {id_asp};  // sesión aspirante

// Ajustar si tu form usa otros nombres (ej. sc_DataSourceFieldValue('form_recomendantes','nombre'))
$nombre     = trim({nombre});
$apellido_p = trim({apellido_p});
$correo     = trim({correo});

if (empty($nombre) || empty($apellido_p) || empty($correo)) {
    sc_error_message("Los campos Nombre, Apellido paterno y Correo son obligatorios.");
    return false;
}

if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    sc_error_message("El correo no es válido.");
    return false;
}

sc_lookup(rs_count, "SELECT COUNT(*) AS n FROM asp_recomendantes WHERE id_asp_FK = " . sc_sql_injection($id_asp));
$n = isset({rs_count[0][0]}) ? (int){rs_count[0][0]} : 0;
if ($n >= 3) {
    sc_error_message("Ya tienes 3 recomendantes asignados.");
    return false;
}

$correo_esc = sc_sql_injection($correo);
sc_lookup(rs_dup, "SELECT COUNT(*) AS n FROM asp_recomendantes ar 
                   INNER JOIN recomendantes r ON ar.id_recom_FK = r.id_recom 
                   WHERE ar.id_asp_FK = " . sc_sql_injection($id_asp) . " AND r.correo = " . $correo_esc);
$dup = isset({rs_dup[0][0]}) ? (int){rs_dup[0][0]} : 0;
if ($dup > 0) {
    sc_error_message("Este recomendante ya está asignado.");
    return false;
}

return true;
```

### 4.2 afterInsert (referencia; form_recomendantes solo actualiza, no inserta nuevos)

Obtiene `id_recom` con `LAST_INSERT_ID()`, calcula `num_req` (1, 2, 3), inserta en `asp_recomendantes` y redirige al grid.

```php
$id_asp = {id_asp};

sc_lookup(rs_id, "SELECT LAST_INSERT_ID() AS id");
$id_recom = {rs_id[0][0]};

sc_lookup(rs_num, "SELECT COUNT(*) AS n FROM asp_recomendantes WHERE id_asp_FK = " . sc_sql_injection($id_asp));
$num_req = (int){rs_num[0][0]} + 1;

$sql = "INSERT INTO asp_recomendantes (id_asp_FK, id_recom_FK, num_req) 
        VALUES (" . sc_sql_injection($id_asp) . ", " . sc_sql_injection($id_recom) . ", " . $num_req . ")";
sc_exec_sql($sql);

sc_redir('app_recomendantes');
```

Si el grid se llama distinto, cambia `app_recomendantes` por ese nombre en `sc_redir`.

**Archivos SQL creados (copiar/pegar):**
- `data/sql_grid_recomendantes.sql` — consulta del grid
- `data/sql_validar_max3_recomendantes.sql` — validación máximo 3
- `data/sql_validar_correo_no_duplicado.sql` — validación correo no repetido
- `data/sql_insert_asp_recomendantes_after_form.sql` — INSERT en afterInsert

---

## 5. Nombres de apps y archivos (resumen)

| Concepto | Nombre |
|----------|--------|
| Grid | `app_recomendantes` |
| Formulario recomendantes | `form_recomendantes` (Editable grid, actualiza los 3) |
| Menú aspirante | `menu_aspirante` |

---

## 6. Checklist rápido

- [ ] Grid: fuente = consulta SQL anterior; filtro `id_asp_FK = {id_asp}`.
- [ ] Eliminar en grid sobre `asp_recomendantes`, clave `id_asp_recom`.
- [ ] Botón “+ AGREGAR” abre `form_recomendantes` (editar los 3 recomendantes, según prefieras).
- [ ] Botón “VOLVER” → `menu_aspirante`.
- [ ] Form: tabla `recomendantes`; campos nombre, apellido_p, apellido_m, correo; `login_FK` oculto (p. ej. `0`).
- [ ] beforeInsert: validaciones con las consultas de este documento.
- [ ] afterInsert: `LAST_INSERT_ID()`, INSERT en `asp_recomendantes`, `sc_redir` al grid.
- [ ] No usar “GUARDAR CAMBIOS” en el grid; solo “Guardar” en el form.

---

**Conclusión:** El diseño tiene sentido. Usa las consultas y el PHP de este archivo para que coincidan con tu BD y con el estilo de tu proyecto (ScriptCase).
