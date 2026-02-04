# grid_asp_recomendantes

Grid que lista los **3 recomendantes** del aspirante logueado (id_asp en sesión). Los 3 se crean al dar de alta al aspirante; aquí solo se **editan**, no se agregan ni eliminan.

## Configuración en ScriptCase

1. **Fuente de datos:** Consulta SQL → usar el método `qry_grid_recomendantes` (o pegar la consulta del archivo).
2. **Filtro:** La consulta ya filtra por `id_asp_FK = [id_asp]`. Asegurar que `[id_asp]` (o `{id_asp}`) sea la variable de sesión del aspirante.
3. **Inserción:** **Deshabilitar** (no hay botón “+ Agregar”). El aspirante no agrega recomendantes; solo edita los 3 existentes.
4. **Edición:** **Habilitar**. En cada fila, botón/enlace **“Editar”** que abre el formulario `form_agregar_recomendante` en **modo Edición**, pasando la clave del registro:
   - **Clave para editar:** `id_recom` (o `id_asp_recom` si el form está configurado por esa clave; normalmente el form edita la tabla `recomendantes`, clave `id_recom`).
   - En ScriptCase: En el grid, **Edición** → **Aplicación de edición** = `form_agregar_recomendante`, **Campo clave** = `id_recom` (y que la consulta del grid devuelva `id_recom` o `r.id_recom`).
5. **Eliminación:** **Deshabilitar** (el aspirante no debe borrar recomendantes; siempre son 3).

## Columnas sugeridas

- Mostrar: `nombre`, `apellido_p`, `apellido_m`, `correo` (y opcionalmente `num_req` como “No. requisito”).
- Ocultas: `id_asp_recom`, `id_asp_FK`, `id_recom_FK`, `id_recom` (pero `id_recom` debe estar en la consulta para usarlo como clave de edición).

## Flujo

- Menú aspirante → abre `grid_asp_recomendantes`.
- El aspirante ve sus 3 recomendantes (inicialmente con datos vacíos o placeholder).
- Clic en “Editar” en una fila → abre `form_agregar_recomendante` en modo Edición con ese `id_recom`.
- Tras guardar en el form → redirección a `grid_asp_recomendantes`.
