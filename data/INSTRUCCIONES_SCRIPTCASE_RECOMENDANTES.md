# Instrucciones paso a paso: Grid + Formulario de recomendantes en ScriptCase

Sigue estos pasos en orden. Cada uno indica **dónde** hacer clic y **qué** pegar o configurar.

---

## Antes de empezar

- Base de datos: **`sce_asp`**.
- El aspirante debe estar logueado (App_login asigna **`id_asp`** en sesión).
- Nombres de apps:
  - Grid: **`grid_asp_recomendantes`**
  - Formulario: **`form_agregar_recomendante`**

**Estructura en `scriptcase/apps/`** (como `app_form_add_users`):
- **grid_asp_recomendantes/** → `Eventos/onLoad`, `metodos/qry_grid_recomendantes` (SQL).
- **form_agregar_recomendante/** → `Eventos/onBeforeInsert`, `Eventos/onAfterInsert`, `metodos/validar_recomendante(...)`, `metodos/insert_asp_recomendante_after`.

**Variables:** En el código se usan `{id_asp}`, `{nombre}`, `{apellido_p}`, `{correo}`. Si en tu proyecto ScriptCase usa `[id_asp]` u otro formato, cámbialo en la consulta SQL y en los eventos del form.

---

# PASO 1: Crear el GRID `app_recomendantes`

## 1.1 Nueva aplicación

1. En ScriptCase, **Nueva aplicación** (o **New application**).
2. Tipo: **Grid**.
3. Nombre: **`app_recomendantes`**.
4. Conexión: la que use **`sce_asp`**.
5. Crear / Aceptar.

---

## 1.2 Fuente de datos (consulta SQL)

1. En la app, ve a **Editar** / **Editar Aplicação**.
2. Busca **Fuente de datos** / **Data source** / **Tabela**.
3. Elige **Consulta** / **Query** / **SQL** (no tabla directa).
4. En **SQL da Aplicação** / **Consulta** / **Query**, pega **exactamente** esto:

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
ORDER BY ar.id_asp_recom
```

5. **Importante:** `{id_asp}` debe ser la variable de sesión del aspirante. Si en tu proyecto usas otro nombre (ej. `[id_asp]`), cámbialo en la consulta.
6. Guarda.

---

## 1.3 Campos / columnas del grid

1. Ve a la pestaña **Campos** / **Fields** / **Colunas**.
2. Configura así:

| Campo        | Mostrar en grid | Encabezado   | Notas                    |
|-------------|------------------|--------------|---------------------------|
| `id_asp_recom` | No (oculto)    | —            | Clave para eliminar       |
| `id_asp_FK`   | No (oculto)    | —            |                          |
| `id_recom_FK` | No (oculto)    | —            |                          |
| `id_recom`    | No (oculto)    | —            |                          |
| `nombre`      | Sí              | Nombre       |                          |
| `apellido_p`  | Sí              | Ap. paterno  |                          |
| `apellido_m`  | Sí              | Ap. materno  | Opcional                  |
| `correo`      | Sí              | Correo       |                          |

3. Guarda.

---

## 1.4 Insertar y eliminar

1. Pestaña **Inserção** / **Insert** (o similar): **Não permitir** / **Desativar**.  
   (Los datos nuevos se agregan desde el formulario, no desde el grid.)
2. Pestaña **Exclusão** / **Delete**: **Permitir**.
3. Si te pide **tabela para exclusão** / **table for delete**: **`asp_recomendantes`**.
4. **Chave** / **Key**: **`id_asp_recom`**.
5. Opción **Confirmar antes de eliminar**: Sí.
6. Guarda.

---

## 1.5 Probar el grid

1. **Test** / **Executar**.
2. Debes entrar logueado como **aspirante** (con `id_asp` en sesión). Si no, el grid puede estar vacío o dar error.
3. Verifica que se listen los recomendantes del aspirante (o que esté vacío si aún no tiene).

---

# PASO 2: Botones del grid

## 2.1 Botón «+ AGREGAR RECOMENDANTE»

1. En `app_recomendantes`, **Editar**.
2. Pestaña **Botões** / **Buttons** / **Toolbar**.
3. **Adicionar** / **Nuevo botón**.
4. Configura:
   - **Nome** / **Name:** `btn_agregar`
   - **Rótulo** / **Label:** `+ AGREGAR RECOMENDANTE`
   - **Tipo:** **Link** o **Executar aplicação** / **Run application**.
5. Si es “Ejecutar aplicación”:
   - **Aplicação:** `form_agregar_recomendante`.
   - Abrir en **mesma janela** (misma ventana) para que el `sc_redir` del formulario funcione bien.
6. Si es botón con **onclick** y tu versión lo permite, puedes usar algo como:
   - `window.location = '{url_form_agregar_recomendante}';`  
   (ajusta según cómo ScriptCase genere la URL del form.)
7. Guarda.

---

## 2.2 Botón «VOLVER»

1. Misma pestaña **Botões**.
2. **Nuevo botón**.
3. Configura:
   - **Nome:** `btn_volver`
   - **Rótulo:** `VOLVER`
   - **Tipo:** **Link** o **Executar aplicação**.
4. Si es “Ejecutar aplicación”:
   - **Aplicação:** `menu_aspirante`.
5. Si usas **onclick**:
   - `window.location = '{url_menu_aspirante}';`
6. Guarda.

---

## 2.3 Eliminar (columna de acciones)

1. En **Campos** del grid, si hay columna **Ações** / **Actions**:
   - Asegura que incluya **Excluir** / **Delete**.
   - **Confirmar antes de excluir:** Sí.
2. La exclusão ya se configuró en el Paso 1.4 sobre `asp_recomendantes` con clave `id_asp_recom`.

---

# PASO 3: Crear el formulario `form_agregar_recomendante`

## 3.1 Nueva aplicación

1. **Nueva aplicación**.
2. Tipo: **Form** / **Formulário**.
3. Nombre: **`form_agregar_recomendante`**.
4. Conexión: **`sce_asp`**.
5. Crear.

---

## 3.2 Fuente y modo

1. **Editar** el formulario.
2. **Tabela** / **Table:** **`recomendantes`**.
3. **Modo** / **Action:** **Inserir** / **Insert new** (solo alta, no editar).
   - **IMPORTANTE:** Si el form muestra registros existentes (7 recomendantes), busca en la configuración:
     - **"Modo"** / **"Action"** / **"Tipo"** → Selecciona **"Insert"** / **"Inserir"** / **"Nuevo registro"**.
     - O desactiva **"Búsqueda"** / **"Search"** / **"Mostrar registros"**.
     - El form debe estar en modo que **NO muestre registros existentes**, solo permita agregar nuevos.

---

## 3.3 Campos del formulario

1. Pestaña **Campos** / **Fields**.
2. Usa solo estos:

| Campo       | Tipo    | Obrigatório | Mostrar | Valor padrão / Default   |
|------------|---------|-------------|---------|---------------------------|
| `nombre`   | Texto   | Sim         | Sim     | —                         |
| `apellido_p` | Texto | Sim         | Sim     | —                         |
| `apellido_m` | Texto  | Não         | Sim     | —                         |
| `correo`   | Texto   | Sim         | Sim     | — (puedes usar tipo Email si existe) |
| `login_FK` | Oculto  | —           | Não     | `0`                       |

3. **No** uses en el form: `id_recom` (auto), `id_persacadposg_FK`, `num_recom`.  
4. Guarda.

---

## 3.4 Evento **beforeInsert** (validaciones)

1. En el form, **Eventos** / **Events**.
2. Busca **beforeInsert** / **Antes de inserir** / **Antes de gravar**.
3. Abre el editor y pega **todo** este código:

```php
$id_asp = {id_asp};

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
sc_lookup(rs_dup, "SELECT COUNT(*) AS n FROM asp_recomendantes ar INNER JOIN recomendantes r ON ar.id_recom_FK = r.id_recom WHERE ar.id_asp_FK = " . sc_sql_injection($id_asp) . " AND r.correo = " . $correo_esc);
$dup = isset({rs_dup[0][0]}) ? (int){rs_dup[0][0]} : 0;
if ($dup > 0) {
    sc_error_message("Este recomendante ya está asignado.");
    return false;
}

return true;
```

4. Si tu form usa otros nombres de campo (ej. con prefijo o distinta nomenclatura), sustituye `{nombre}`, `{apellido_p}`, `{correo}` por los que correspondan.
5. Guarda.

---

## 3.5 Evento **afterInsert** (insertar en asp_recomendantes y redirigir)

1. Misma sección **Eventos**.
2. **afterInsert** / **Depois de inserir** / **Después de gravar**.
3. Pega **todo** este código:

```php
$id_asp = {id_asp};

sc_lookup(rs_id, "SELECT LAST_INSERT_ID() AS id");
$id_recom = {rs_id[0][0]};

sc_lookup(rs_num, "SELECT COUNT(*) AS n FROM asp_recomendantes WHERE id_asp_FK = " . sc_sql_injection($id_asp));
$num_req = (int){rs_num[0][0]} + 1;

$sql = "INSERT INTO asp_recomendantes (id_asp_FK, id_recom_FK, num_req) VALUES (" . sc_sql_injection($id_asp) . ", " . sc_sql_injection($id_recom) . ", " . $num_req . ")";
sc_exec_sql($sql);

sc_redir('grid_asp_recomendantes');
```

4. **Importante:** En `sc_redir` usa el **nombre exacto** de tu grid. Si es `grid_asp_recomendantes`, deja eso.
5. Guarda.

---

## 3.6 Botones del formulario

1. **Botões** del form.
2. **GUARDAR:** suele venir por defecto (tipo Submit). Verifica que envíe el form.
3. **CANCELAR:** si lo quieres:
   - Tipo **Button**.
   - **onclick:** cerrar o volver al grid, según cómo abras el form (ej. `window.location = '{url_app_recomendantes}';` o `window.close();` si lo abres en popup).

---

## 3.7 Probar el formulario

1. Entra como **aspirante** (con `id_asp` en sesión).
2. Abre `app_recomendantes` y pulsa **+ AGREGAR RECOMENDANTE**.
3. Debe abrirse `form_agregar_recomendante`.
4. Llena nombre, apellido paterno, correo (apellido materno opcional) y guarda.
5. Debe redirigir al grid y aparecer el nuevo recomendante.
6. Repite hasta 3. En el cuarto intento debe salir “Ya tienes 3 recomendantes asignados.”
7. Prueba correo inválido y campos vacíos; deben mostrarse los mensajes de error.

---

# PASO 4: Menú del aspirante

1. Abre la app del **menú de aspirantes** (`menu_aspirante` o como la tengas).
2. Añade un ítem que ejecute **`app_recomendantes`**.
3. Texto sugerido: **Mis recomendantes** o **Recomendantes**.
4. Guarda.

---

# Resumen de comprobaciones

- [ ] Grid `app_recomendantes` usa la consulta SQL con `WHERE id_asp_FK = {id_asp}`.
- [ ] Eliminar está sobre `asp_recomendantes`, clave `id_asp_recom`.
- [ ] Botón **+ AGREGAR** abre `form_agregar_recomendante`.
- [ ] Botón **VOLVER** va a `menu_aspirante`.
- [ ] Form `form_agregar_recomendante`: tabla `recomendantes`, campos nombre, apellido_p, apellido_m, correo; `login_FK` oculto = `0`.
- [ ] **beforeInsert** con validaciones (obligatorios, email, máximo 3, correo no duplicado).
- [ ] **afterInsert** con `LAST_INSERT_ID`, `INSERT` en `asp_recomendantes` y `sc_redir` al nombre exacto del grid (ej. `grid_asp_recomendantes`).
- [ ] Menú aspirante tiene enlace al grid.

---

# Si algo falla

- **Grid vacío o error en consulta:** comprueba que `{id_asp}` exista en sesión (logueo como aspirante en App_login).
- **“Variable no definida”:** revisa que los nombres `{id_asp}`, `{nombre}`, etc. coincidan con los de tu proyecto.
- **No redirige al grid:** revisa que el nombre en `sc_redir` sea **exactamente** el de tu app grid (ej. `grid_asp_recomendantes`).
- **Error al eliminar:** confirma tabla `asp_recomendantes` y clave `id_asp_recom`.

---

# “Dice que se registró pero no sale nada en el grid”

## 1. Revisar `sc_redir`

El **afterInsert** del form debe redirigir al **mismo nombre** que tiene tu grid.

- Si tu grid se llama **`grid_asp_recomendantes`**, en el afterInsert debe ir:  
  `sc_redir('grid_asp_recomendantes');`
- Si usas otro nombre, cámbialo ahí. Si apunta a una app que no existe o a otra app, volverás a otra pantalla y no verás el grid actualizado.

## 2. Revisar `id_asp` en el form

El **INSERT** en `asp_recomendantes` usa `id_asp_FK = id_asp`. Ese valor debe ser el **mismo** con el que el grid filtra (`WHERE id_asp_FK = [id_asp]`).

En el **afterInsert** usa sesión si hace falta:

```php
$id_asp = isset($_SESSION['id_asp']) ? $_SESSION['id_asp'] : {id_asp};
```

Si `$id_asp` está vacío o es distinto al del aspirante logueado, se insertaría con otro `id_asp_FK` y el grid no mostraría esos registros.

## 3. Confirmar en la base de datos

Ejecuta en MySQL:

```sql
SELECT * FROM asp_recomendantes ORDER BY id_asp_recom DESC LIMIT 10;
```

Comprueba:
- Que existan filas nuevas tras agregar desde el form.
- El valor de `id_asp_FK` en esas filas.

Luego prueba la consulta del grid con ese mismo `id_asp`:

```sql
SELECT ar.id_asp_recom, ar.id_asp_FK, r.nombre, r.apellido_p, r.correo
FROM asp_recomendantes ar
INNER JOIN recomendantes r ON ar.id_recom_FK = r.id_recom
WHERE ar.id_asp_FK = 1222
ORDER BY ar.id_asp_recom;
```

(Sustituye `1222` por el `id_asp` del usuario con el que pruebas.) Si aquí sí salen registros y en el grid no, el problema está en la variable `[id_asp]` del grid o en la sesión.

## 4. Formato de `id_asp` (ceros)

`id_asp` a veces se guarda con ceros (`00000001222`). Si en el INSERT usas `1222` y en el grid `00000001222` (o al revés), en principio MySQL suele aceptarlo, pero si hubiera diferencias, unifica formato. Por ejemplo, usar siempre el valor que tienes en `$_SESSION['id_asp']` tanto en el form como en el grid.

## 5. Commit antes de redirigir

Tras el `sc_exec_sql` del INSERT en `asp_recomendantes`, prueba asegurar el commit antes del `sc_redir`:

```php
sc_exec_sql($sql);
if (function_exists('sc_commit_trans')) { sc_commit_trans(); }
sc_redir('grid_asp_recomendantes');
```

---

Si tu versión de ScriptCase usa otros nombres (pestañas, opciones), adapta los pasos; la lógica es la misma.
