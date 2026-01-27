# Solución: Error "Falta definir las siguientes variables globales: id_recom"

## Problema

Cuando haces clic en el botón **"+ AGREGAR"** en el grid, aparece el error:
```
Falta definir las siguientes variables globales: id_recom;
```

**Causa:** El form `form_agregar_recomendante` tiene en la **Cláusula WHERE**: `id_recom = [id_recom]`

Cuando agregas un **nuevo registro**, no existe `id_recom` todavía, entonces ScriptCase no puede evaluar el WHERE y genera el error.

---

## Solución: Modificar el WHERE para permitir modo "nuevo registro"

### Opción 1: WHERE condicional (recomendada)

En **Configuración SQL** del form `form_agregar_recomendante`:

**Cláusula WHERE:**
```
(id_recom = [id_recom] AND [id_recom] IS NOT NULL) OR ([id_recom] IS NULL AND 1=0)
```

**Explicación:**
- Si hay `id_recom` (viene del grid para editar): muestra solo ese registro
- Si NO hay `id_recom` (botón "+ AGREGAR"): `1=0` siempre es falso, entonces no muestra ningún registro (modo nuevo)

---

### Opción 2: WHERE más simple (si ScriptCase lo permite)

**Cláusula WHERE:**
```
id_recom = [id_recom] OR [id_recom] IS NULL
```

**Explicación:**
- Si hay `id_recom`: muestra ese registro
- Si NO hay `id_recom`: la condición `[id_recom] IS NULL` puede hacer que no muestre registros (depende de cómo ScriptCase maneje NULL)

---

### Opción 3: WHERE vacío + validación en eventos (alternativa)

**Cláusula WHERE:** (dejar vacío o `1=1`)

Luego, en el evento **onLoad** del form:

```php
// Si viene id_recom, cargar ese registro
// Si NO viene id_recom, el form estará vacío (modo nuevo)
$id_recom = isset($_GET['id_recom']) ? $_GET['id_recom'] : (isset({id_recom}) ? {id_recom} : '');

if (!empty($id_recom)) {
    // Modo edición: cargar el registro con id_recom
    // ScriptCase debería cargarlo automáticamente si el WHERE está configurado
} else {
    // Modo nuevo: form vacío
}
```

**Nota:** Esta opción requiere que el WHERE esté configurado correctamente, así que es mejor usar la Opción 1.

---

## Pasos para implementar

### 1. Modificar el WHERE del form

1. Abre `form_agregar_recomendante` en ScriptCase
2. Ve a **Configuración SQL**
3. En **Cláusula WHERE**, cambia de:
   ```
   id_recom = [id_recom]
   ```
   a:
   ```
   (id_recom = [id_recom] AND [id_recom] IS NOT NULL) OR ([id_recom] IS NULL AND 1=0)
   ```
4. Guarda

### 2. Verificar el botón "+ AGREGAR" en el grid

El botón ya está configurado correctamente:
- **Tipo:** PHP
- **Código:** `sc_redir('form_agregar_recomendante');`

No pasa `id_recom`, lo cual es correcto para agregar un nuevo registro.

### 3. Configurar enlace en filas del grid (para editar)

Si quieres que al hacer clic en una fila del grid se abra el form para editar:

1. En `grid_asp_recomendantes`, ve a **Enlaces entre Aplicaciones**
2. Crea un enlace:
   - **Aplicación destino:** `form_agregar_recomendante`
   - **Parámetros:** Define `id_recom` = `{r.id_recom}` (o `{id_recom_FK}` según tu consulta)

---

## Resultado esperado

### Al hacer clic en "+ AGREGAR":
- El form se abre **vacío** (no muestra ningún registro)
- Puedes llenar los campos y guardar
- No aparece el error de variable global

### Al hacer clic en una fila del grid (si configuraste el enlace):
- El form se abre con **ese registro cargado** (1 registro)
- Puedes editarlo y guardar

---

## Si el error persiste

1. **Verifica la sintaxis del WHERE:**
   - Asegúrate de usar corchetes `[id_recom]` si ScriptCase usa esa sintaxis
   - O prueba con `{id_recom}` si tu proyecto usa llaves

2. **Verifica que el botón no esté pasando parámetros:**
   - El botón "+ AGREGAR" debe hacer solo `sc_redir('form_agregar_recomendante');`
   - No debe pasar `id_recom` como parámetro

3. **Prueba con WHERE vacío temporalmente:**
   - Deja el WHERE vacío
   - El form mostrará todos los registros (7), pero al menos no dará error
   - Luego ajusta el WHERE con la solución correcta
