# Brief: Grid de 3 recomendantes en menú de aspirantes (ScriptCase)

**Objetivo:** En el **menú de aspirantes** (`menu_aspirante`), el aspirante debe poder **asignar exactamente 3 recomendantes** y **guardar** esa relación en la base de datos. Se plantea usar un **grid** (o alternativa equivalente en ScriptCase).

**Entregable:** Instrucciones o pasos concretos para implementar esto en ScriptCase, o código/consultas SQL necesarias.

---

## 1. Contexto del sistema

- **Proyecto:** SCE-ASP (ScriptCase), gestión de aspirantes al posgrado INECOL.
- **Menú aspirante:** Tras login, usuarios con `group_id = 2` van a `menu_aspirante`.
- **Sesión:** El aspirante logueado tiene en sesión:
  - `[id_asp]` — PK del aspirante en `aspirantes`
  - `[usr_login]` — login (ej. email)
  - `[generacion]` — generación activa

---

## 2. Base de datos (sce_asp)

### 2.1 Tablas implicadas

**`recomendantes`** (catálogo de personas que pueden dar cartas de recomendación):

| Columna           | Tipo            | Notas                          |
|-------------------|-----------------|--------------------------------|
| `id_recom`        | int UNSIGNED PK | AUTO_INCREMENT                 |
| `id_persacadposg_FK` | int UNSIGNED | NULL ok                        |
| `nombre`          | varchar(50)     |                                |
| `apellido_p`      | varchar(80)     |                                |
| `apellido_m`      | varchar(80)     |                                |
| `correo`          | varchar(80)     | NOT NULL, UNIQUE               |
| `num_recom`       | int(1)          | 1, 2, 3…                       |
| `login_FK`        | varchar(255)    | NOT NULL                       |

**`asp_recomendantes`** (relación aspirante ↔ recomendante; aquí se guardan las 3 asignaciones):

| Columna       | Tipo            | Notas                                      |
|---------------|-----------------|--------------------------------------------|
| `id_asp_recom`| int UNSIGNED PK | AUTO_INCREMENT                             |
| `id_asp_FK`   | int UNSIGNED    | NOT NULL → `aspirantes.id_asp`             |
| `num_req`     | int UNSIGNED    | NULL ok (opcional; ej. número de requisito)|
| `id_recom_FK` | int UNSIGNED    | NOT NULL → `recomendantes.id_recom`        |

- **UNIQUE** `(id_asp_FK, id_recom_FK)`: un mismo recomendante no puede asignarse dos veces al mismo aspirante.
- Un aspirante puede tener **varias filas** (una por recomendante); en este caso, **exactamente 3**.

### 2.2 Relaciones

- `aspirantes.id_asp` → `asp_recomendantes.id_asp_FK`
- `recomendantes.id_recom` → `asp_recomendantes.id_recom_FK`

### 2.3 Consultas de referencia (`consulta_recomendantes.sql`)

**Consulta 1 — Recomendantes y relación con aspirantes:**

```sql
SELECT 
    r.id_recom,
    r.nombre,
    r.apellido_p,
    r.apellido_m,
    CONCAT(r.nombre, ' ', r.apellido_p, ' ', IFNULL(r.apellido_m, '')) AS nombre_completo,
    r.correo,
    r.num_recom,
    r.id_persacadposg_FK,
    r.login_FK AS login_recomendante,
    ar.id_asp_recom,
    ar.id_asp_FK,
    ar.num_req,
    ar.id_recom_FK
FROM recomendantes r
LEFT JOIN asp_recomendantes ar ON r.id_recom = ar.id_recom_FK
ORDER BY r.id_recom, ar.id_asp_FK;
```

**Consulta 2 — Solo recomendantes con aspirantes:**

```sql
SELECT 
    r.id_recom,
    r.nombre, r.apellido_p, r.apellido_m,
    CONCAT(r.nombre, ' ', r.apellido_p, ' ', IFNULL(r.apellido_m, '')) AS nombre_completo,
    r.correo, r.num_recom,
    ar.id_asp_FK, ar.num_req,
    COUNT(ar.id_asp_FK) AS total_aspirantes
FROM recomendantes r
INNER JOIN asp_recomendantes ar ON r.id_recom = ar.id_recom_FK
GROUP BY r.id_recom, r.nombre, r.apellido_p, r.apellido_m, r.correo, r.num_recom, ar.id_asp_FK, ar.num_req
ORDER BY r.id_recom;
```

**Consulta 3 — Resumen por recomendante:**

```sql
SELECT 
    r.id_recom,
    CONCAT(r.nombre, ' ', r.apellido_p, ' ', IFNULL(r.apellido_m, '')) AS nombre_completo,
    r.correo,
    COUNT(DISTINCT ar.id_asp_FK) AS total_aspirantes_asociados,
    COUNT(ar.id_asp_recom) AS total_relaciones
FROM recomendantes r
LEFT JOIN asp_recomendantes ar ON r.id_recom = ar.id_recom_FK
GROUP BY r.id_recom, r.nombre, r.apellido_p, r.apellido_m, r.correo
ORDER BY total_aspirantes_asociados DESC, r.id_recom;
```

**Para listar recomendantes del aspirante actual (id_asp en sesión):**

```sql
SELECT r.id_recom, r.nombre, r.apellido_p, r.apellido_m, r.correo, ar.num_req, ar.id_asp_recom
FROM recomendantes r
INNER JOIN asp_recomendantes ar ON r.id_recom = ar.id_recom_FK
WHERE ar.id_asp_FK = [id_asp]
ORDER BY ar.id_asp_recom;
```

**Para insertar una asignación** (usar `sc_sql_injection` en ScriptCase donde corresponda):

```sql
INSERT INTO asp_recomendantes (id_asp_FK, id_recom_FK, num_req)
VALUES ([id_asp], [id_recom], NULL);
-- Opcional: num_req 1, 2, 3 para orden
```

---

## 3. Reglas de negocio

1. El aspirante debe asignar **exactamente 3 recomendantes**.
2. `id_asp` es el del aspirante logueado (`[id_asp]` en sesión).
3. No repetir recomendante para el mismo aspirante (respeta UK `id_asp_FK`, `id_recom_FK`).
4. Los recomendantes se eligen del catálogo `recomendantes` (p. ej. dropdown/lookup por `id_recom` o por `nombre_completo`/correo).

---

## 4. Qué hay que implementar en ScriptCase

- **Dónde:** En `menu_aspirante`, un enlace que abra la app de recomendantes (grid o formulario).
- **Qué hace la app:**
  - Mostrar las asignaciones actuales del aspirante (0 a 3 filas en `asp_recomendantes`).
  - Permitir **agregar** hasta 3 recomendantes (elegidos de `recomendantes`).
  - **Guardar** en `asp_recomendantes` (`id_asp_FK` = `[id_asp]`, `id_recom_FK`, opcionalmente `num_req`).
  - Evitar duplicados y más de 3 (validación en evento o en PHP).

Opciones típicas en ScriptCase:
- **Grid** sobre `asp_recomendantes` con filtro `id_asp_FK = [id_asp]`, + formulario de inserción (campos: lookup a `recomendantes`, opcional `num_req`). Restringir a 3 filas.
- **Formulario** con 3 lookups (recomendante 1, 2, 3) y botón “Guardar” que hace 3 `INSERT` en `asp_recomendantes` (o reemplaza las anteriores con DELETE + INSERT).
- **Grid + formulario de búsqueda** usando las consultas anteriores como fuentes.

---

## 5. Cómo hacerlo en ScriptCase: grid + inputs (paso a paso)

Sí: haces un **grid** y le pones **inputs** en el formulario de búsqueda (o de inserción). Resumen:

---

### Opción A: Grid sobre `asp_recomendantes` + formulario de inserción

1. **Crear app tipo Grid**
   - Fuente: tabla `asp_recomendantes` (o una consulta que haga JOIN con `recomendantes` para mostrar nombre/correo).

2. **Filtrar por el aspirante logueado**
   - En **Filtros / Condición de filtro / SQL**:  
     `id_asp_FK = {id_asp}`  
   - O en **Formulario de búsqueda**: campo oculto `id_asp_FK` con valor `{id_asp}` (solo lectura o hidden).  
   - Así el grid **solo muestra** los recomendantes de ese aspirante (0, 1, 2 o 3 filas).

3. **Formulario de inserción (inputs para agregar)**
   - Habilitar **Inserción** en el grid.
   - En el formulario de inserción:
     - **`id_asp_FK`**: tipo **Campo oculto**, valor por defecto `{id_asp}`. No lo toca el usuario.
     - **`id_recom_FK`**: tipo **Lookup** (lista desplegable) sobre la tabla `recomendantes`:
       - **Valor:** `id_recom`
       - **Etiqueta:** `CONCAT(nombre,' ',apellido_p,' ',IFNULL(apellido_m,''))` o `correo`, lo que prefieras.
     - **`num_req`**: opcional. Puedes usar **Lista** con valores 1, 2, 3 para “Recomendante 1”, “Recomendante 2”, “Recomendante 3”, o dejarlo vacío.

4. **Validación “máximo 3”**
   - En **Eventos** del grid, por ejemplo **Antes de insertar** (onBeforeInsert):
     - Consultar:  
       `SELECT COUNT(*) FROM asp_recomendantes WHERE id_asp_FK = {id_asp}`
     - Si el resultado ≥ 3, mostrar mensaje de error (`sc_error_message`) y cancelar la inserción.

5. **Evitar repetidos**
   - El UNIQUE `(id_asp_FK, id_recom_FK)` ya evita duplicados a nivel BD.
   - Opcional: en el lookup de `id_recom_FK`, excluir los `id_recom` que ya tiene el aspirante (consulta con subconsulta o filtro en el lookup).

6. **Columnas del grid**
   - Mostrar al menos: recomendante (nombre o correo, vía JOIN), `num_req` si lo usas.  
   - Ocultar `id_asp_FK` si no quieres que se vea.

7. **Menú**
   - En `menu_aspirante`, agregar un **enlace** a esta app de grid.

Así tienes un **grid** que lista los recomendantes del aspirante y **inputs** (lookup + oculto) para agregar nuevos hasta completar 3.

---

### Opción B: Formulario con 3 lookups fijos (sin grid de inserción)

1. **Crear app tipo Formulario** (o Form).
2. **Campos:**  
   - 3 inputs tipo **Lookup** a `recomendantes` (Recomendante 1, 2, 3), cada uno guardando `id_recom`.
   - Un campo oculto con `id_asp` = `{id_asp}`.
3. **Al guardar:**  
   - En evento **Al guardar** (o similar):  
     - Borrar registros previos del aspirante:  
       `DELETE FROM asp_recomendantes WHERE id_asp_FK = {id_asp}`  
     - Luego 3 `INSERT` en `asp_recomendantes` (uno por cada lookup no vacío).  
   - Validar que los 3 estén completos y que no se repita el mismo `id_recom`.

En este caso **no** usas grid de inserción; solo inputs y lógica al guardar.

---

### Resumen rápido

| Qué | Cómo |
|-----|------|
| **Grid** | App Grid, fuente `asp_recomendantes` (o consulta con JOIN a `recomendantes`). |
| **Filtro** | `id_asp_FK = {id_asp}` (filtro SQL o campo en form. búsqueda). |
| **Inputs para agregar** | Form. **inserción**: `id_asp_FK` oculto = `{id_asp}`, `id_recom_FK` = **Lookup** a `recomendantes`. |
| **Máximo 3** | En **Antes de insertar**, contar filas del aspirante; si ≥ 3, error y cancelar. |
| **No repetir** | UNIQUE en BD + opcional excluir en lookup los ya asignados. |

Con eso ya tienes **grid + inputs** para elegir y guardar los 3 recomendantes por aspirante.

---

## 6. Información para la IA

**Pregunta orientada a la IA:**

> En un proyecto ScriptCase (PHP) tenemos un menú de aspirantes (`menu_aspirante`). El aspirante logueado tiene `[id_asp]` en sesión. Necesitamos una pantalla (idealmente un grid o algo equivalente) donde el aspirante pueda **asignar exactamente 3 recomendantes** y **guardar** en la tabla `asp_recomendantes`. Los recomendantes vienen del catálogo `recomendantes` (id_recom, nombre, apellidos, correo). La tabla `asp_recomendantes` tiene `id_asp_recom` (PK), `id_asp_FK`, `id_recom_FK`, `num_req` (opcional), y UNIQUE (id_asp_FK, id_recom_FK). ¿Cómo lo implemento en ScriptCase paso a paso (tipo de app, fuente de datos, filtros, formulario de inserción, validaciones)? ¿Qué consultas SQL usar para listar recomendantes disponibles y para listar/insertar las asignaciones del aspirante?

**Incluir en el prompt:**
- Este documento (`BRIEF_GRID_RECOMENDANTES_ASPIRANTE.md`).
- Extracto de `README_BD_SCE_ASP.md` (secciones 4.1, 5.4, 7 y 8) para tablas y convenciones.
- El contenido de `data/consulta_recomendantes.sql` (las 3 consultas y las dos adicionales de este brief).

---

## 7. Resumen de datos clave

| Dato        | Valor / Origen                                      |
|-------------|-----------------------------------------------------|
| BD          | `sce_asp`                                          |
| Tabla catálogo | `recomendantes` (id_recom, nombre, apellidos, correo) |
| Tabla a guardar | `asp_recomendantes` (id_asp_FK, id_recom_FK, num_req) |
| id_asp      | Sesión `[id_asp]` (aspirante logueado)             |
| Cantidad    | 3 recomendantes por aspirante                      |
| UK          | (id_asp_FK, id_recom_FK)                           |

---

---

## 8. Prompt listo para IA (copiar y pegar)

```
Necesito implementar en ScriptCase (PHP) una pantalla en el menú de aspirantes donde el aspirante asigne exactamente 3 recomendantes y se guarden en la BD.

Contexto:
- Proyecto: SCE-ASP, gestión aspirantes posgrado INECOL.
- Menú: menu_aspirante. El aspirante tiene en sesión [id_asp], [usr_login], [generacion].
- Tablas: recomendantes (catálogo: id_recom, nombre, apellido_p, apellido_m, correo) y asp_recomendantes (id_asp_recom PK, id_asp_FK, id_recom_FK, num_req). UNIQUE (id_asp_FK, id_recom_FK). Un aspirante debe tener exactamente 3 filas en asp_recomendantes.

Archivos de referencia en el proyecto:
- README_BD_SCE_ASP.md: estructura BD, tablas recomendantes/asp_recomendantes, relaciones.
- data/consulta_recomendantes.sql: consultas que relacionan recomendantes y asp_recomendantes.
- data/BRIEF_GRID_RECOMENDANTES_ASPIRANTE.md: brief completo con tablas, consultas SQL, reglas y opciones (grid vs form).

Pregunta: ¿Cómo implemento esto en ScriptCase paso a paso? (tipo de app, fuente de datos, filtro por id_asp, formulario de inserción, validación de 3 recomendantes, consultas para listar disponibles y para guardar). Indica qué consultas SQL usar y cómo filtrar por el aspirante logueado.
```
