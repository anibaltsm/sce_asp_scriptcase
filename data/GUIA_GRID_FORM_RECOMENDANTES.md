# Guía: Grid + Formulario de recomendantes (ScriptCase)

Nombres de apps, pasos y consultas para implementar el grid de recomendantes del aspirante y el formulario de alta.

> **Nota:** En el repo la app en uso es **form_recomendantes** (Editable grid). Ver `scriptcase/apps/form_recomendantes/README.md`. La guía siguiente es referencia para grid + form alternativo.

---

## Resumen rápido

| Paso | App | Archivo SQL |
|------|-----|-------------|
| 1 | **grid_recomendantes_aspirante** | `data/qry_grid_recomendantes_aspirante.sql` |
| 2 | Botones en el grid | — |
| 3 | **form_recomendante** | `data/ins_asp_recomendante_desde_form.sql` (referencia) |

---

## Nombres de aplicaciones (usar tal cual)

| Paso | Tipo | Nombre de la app |
|------|------|-------------------|
| 1 | Grid | **`grid_recomendantes_aspirante`** |
| 2 | (botones en el grid) | — |
| 3 | Formulario | **`form_recomendante`** |

---

## PASO 1: Crear GRID → `grid_recomendantes_aspirante`

### 1.1 Crear la aplicación

- **Tipo:** Grid.
- **Nombre:** `grid_recomendantes_aspirante`.

### 1.2 Fuente de datos

**No usar tabla directa.** Usar **consulta SQL**. En ScriptCase:

- Fuente: **Consulta** (o “Query” / “SQL”).
- Nombre sugerido de la consulta: `qry_recomendantes_aspirante`.

**Consulta:**

```sql
SELECT 
    ar.id_asp_recom,
    ar.id_asp_FK,
    ar.id_recom_FK,
    ar.num_req,
    CONCAT(r.nombre, ' ', r.apellido_p, ' ', IFNULL(r.apellido_m, '')) AS nombre_completo,
    r.nombre,
    r.apellido_p,
    r.apellido_m,
    r.correo
FROM asp_recomendantes ar
INNER JOIN recomendantes r ON r.id_recom = ar.id_recom_FK
WHERE ar.id_asp_FK = {id_asp}
ORDER BY ar.id_asp_recom
```

### 1.3 Filtro por aspirante (sesión)

- En el grid, **Condición de filtro** / **Filtro SQL** / **Where**:  
  debe cumplirse siempre `id_asp_FK =` valor del aspirante logueado.

Si usas la consulta anterior, **ya está** el `WHERE ar.id_asp_FK = {id_asp}`. Solo hay que asegurar que `{id_asp}` sea la variable de sesión del aspirante:

- En ScriptCase, **Variable de sesión** o **Global** para el aspirante: normalmente `[id_asp]` o `{id_asp}`.
- En la consulta usa ese mismo nombre. Si tu proyecto usa `$_SESSION['id_asp']`, en la condición pon algo como el equivalente en ScriptCase (p. ej. `{id_asp}` si así se expone).

**Resumen:** Misma consulta, `WHERE ar.id_asp_FK = {id_asp}`. `{id_asp}` = sesión del aspirante.

### 1.4 Columnas a mostrar

Sugerido mostrar (y ocultar el resto):

| Campo / alias | Mostrar | Encabezado |
|---------------|--------|------------|
| `nombre_completo` | Sí | Recomendante |
| `correo` | Sí | Correo |
| `num_req` | Opcional | No. requisito |
| `id_asp_recom` | No (oculto) | — |
| `id_asp_FK` | No (oculto) | — |
| `id_recom_FK` | No (oculto) | — |

### 1.5 Habilitar inserción y eliminación

- **Inserción:** Activada (la usaremos para “Agregar”).
- **Eliminación:** Activada (botón Eliminar).

---

## PASO 2: Botones del grid (+AGREGAR, ELIMINAR)

### 2.1 +AGREGAR

- **Tipo:** Botón / enlace que abre **otra aplicación**.
- **Acción:** Abrir el formulario `form_recomendante`.
- **Texto:** `+ Agregar` o `+ AGREGAR`.

**Cómo enlazar:**

- En el grid, **Botones** / **Enlaces** → **Agregar botón**.
- **Ejecutar aplicación:** `form_recomendante`.
- Si el form espera parámetros (p. ej. volver al grid), configurar **Retorno** o **Aplicación siguiente** = `grid_recomendantes_aspirante`.

### 2.2 ELIMINAR

- Usar la **eliminación nativa** del grid (por registro).
- Asegurar que **Eliminación** esté permitida en el grid (ya en Paso 1).
- El grid usa la consulta con `id_asp_recom`; la eliminación debe hacerse sobre `asp_recomendantes` (por `id_asp_recom`).  
  Si la fuente es la consulta de solo lectura, en ScriptCase a veces se define **Tabla principal para eliminar** = `asp_recomendantes`, **Clave** = `id_asp_recom`. Ajustar según tu versión.

### 2.3 Otros botones (opcional)

- **Actualizar:** Recargar grid (si no hay auto-refresh).
- **Cerrar / Volver:** Volver a `menu_aspirante` o a la pantalla anterior.

---

## PASO 3: Crear FORMULARIO → `form_recomendante`

### 3.1 Crear la aplicación

- **Tipo:** Formulario (Form).
- **Nombre:** `form_recomendante`.

### 3.2 Fuente de datos

- **Tabla:** `recomendantes`.

### 3.3 Campos del formulario

Mostrar y permitir edición solo de:

| Campo | Tipo | Obligatorio | Notas |
|-------|------|-------------|-------|
| `nombre` | Texto | Sí | varchar(50) |
| `apellido_p` | Texto | Sí | varchar(80) |
| `apellido_m` | Texto | No | varchar(80) |
| `correo` | Texto / Email | Sí | varchar(80), UNIQUE |

**No mostrar** (valores por defecto o evento):

- `id_recom`: AUTO_INCREMENT, no tocarlo.
- `id_persacadposg_FK`: NULL.
- `num_recom`: NULL o un valor por defecto si lo usas.
- `login_FK`: **NOT NULL**. Poner **valor por defecto** = `0` o el login del aspirante `{usr_login}` según reglas de negocio.

### 3.4 Después de guardar: asignar al aspirante

Al **insertar** un nuevo recomendante, hay que crear también la fila en `asp_recomendantes` (asignar ese recomendante al aspirante logueado).

**Evento:** `onAfterInsert` (o el que use ScriptCase “después de insertar”).

**Código sugerido (PHP dentro del evento):**

```php
$id_asp = {id_asp};  // sesión del aspirante

// Validar: máximo 3 recomendantes por aspirante
sc_lookup(rs_count, "SELECT COUNT(*) AS n FROM asp_recomendantes WHERE id_asp_FK = " . sc_sql_injection($id_asp));
if (isset({rs_count[0][0]}) && (int){rs_count[0][0]} >= 3) {
    sc_error_message("Ya tienes 3 recomendantes asignados. No se puede agregar más.");
    exit;
}

// Obtener id_recom del registro recién insertado en recomendantes
sc_lookup(rs, "SELECT LAST_INSERT_ID() AS id");
$id_recom = {rs[0][0]};

$sql = "INSERT INTO asp_recomendantes (id_asp_FK, id_recom_FK, num_req)
        VALUES (" . sc_sql_injection($id_asp) . ", " . sc_sql_injection($id_recom) . ", NULL)";
sc_exec_sql($sql);

sc_redir('grid_recomendantes_aspirante');
```

- Ajusta `{id_asp}` y `{rs}` si tu proyecto usa otras convenciones (p. ej. `[id_asp]`).
- Si quieres limitar a 3 recomendantes, antes del `INSERT` puedes hacer un `SELECT COUNT(*) ... WHERE id_asp_FK = $id_asp` y, si ya hay 3, mostrar error y no insertar.

### 3.5 Redirección tras guardar

- **Aplicación siguiente / Retorno:** `grid_recomendantes_aspirante` (o hacer `sc_redir` en el evento como arriba).

---

## Consultas listas para copiar y pegar

### Consulta del grid (PASO 1)

```sql
SELECT 
    ar.id_asp_recom,
    ar.id_asp_FK,
    ar.id_recom_FK,
    ar.num_req,
    CONCAT(r.nombre, ' ', r.apellido_p, ' ', IFNULL(r.apellido_m, '')) AS nombre_completo,
    r.nombre,
    r.apellido_p,
    r.apellido_m,
    r.correo
FROM asp_recomendantes ar
INNER JOIN recomendantes r ON r.id_recom = ar.id_recom_FK
WHERE ar.id_asp_FK = {id_asp}
ORDER BY ar.id_asp_recom;
```

### Eliminación (tabla y clave)

- **Tabla:** `asp_recomendantes`
- **Clave primaria:** `id_asp_recom`

### Insert en asp_recomendantes (desde form, evento)

```sql
INSERT INTO asp_recomendantes (id_asp_FK, id_recom_FK, num_req)
VALUES ({id_asp}, <id_recom_insertado>, NULL);
```

---

## Resumen de qué ingresar dónde

| Dónde | Qué ingresar |
|-------|---------------|
| **Grid – nombre app** | `grid_recomendantes_aspirante` |
| **Grid – fuente** | Consulta SQL (texto de la sección “Consulta del grid”) |
| **Grid – filtro** | `WHERE ar.id_asp_FK = {id_asp}` (ya en la consulta) |
| **Grid – sesión** | Variable `{id_asp}` = aspirante logueado |
| **Grid – botón +AGREGAR** | Abre `form_recomendante` |
| **Grid – Eliminar** | Sobre `asp_recomendantes`, clave `id_asp_recom` |
| **Form – nombre app** | `form_recomendante` |
| **Form – tabla** | `recomendantes` |
| **Form – campos** | `nombre`, `apellido_p`, `apellido_m`, `correo` |
| **Form – login_FK** | Oculto, valor por defecto `0` (o `{usr_login}`) |
| **Form – onAfterInsert** | Código PHP anterior (INSERT en `asp_recomendantes` + redirigir) |

---

## Menú

En **`menu_aspirante`**, agregar un ítem que abra `grid_recomendantes_aspirante` (ej. “Mis recomendantes” o “Recomendantes”).

---

## Archivos creados (rutas)

| Archivo | Uso |
|---------|-----|
| **`data/GUIA_GRID_FORM_RECOMENDANTES.md`** | Esta guía (pasos, nombres, consultas). |
| **`data/qry_grid_recomendantes_aspirante.sql`** | Consulta del grid. Copiar el SELECT a ScriptCase. |
| **`data/ins_asp_recomendante_desde_form.sql`** | Referencia del INSERT; la lógica va en `onAfterInsert` del form. |
