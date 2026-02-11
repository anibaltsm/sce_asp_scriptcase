# Guía: Deshabilitar campos con cc_edit en Scriptcase

Esta guía explica cómo usar el campo de control `cc_edit` (TINYINT(1)) para **bloquear/deshabilitar** campos de un formulario **Editable Grid** en Scriptcase una vez que el registro haya sido guardado y procesado (en este caso, cuando se crea el usuario de acceso para el recomendante).

---

## Concepto

- **cc_edit = 1** → El registro es **editable** (estado inicial, default).
- **cc_edit = 0** → El registro **no es editable** (ya se creó usuario, campos bloqueados).

Una vez que se guarda el registro y se ejecuta `onAfterUpdate` (que crea el usuario y envía correo), el campo `cc_edit` se actualiza a `0` en la BD, y en el siguiente cargue del grid, los campos se mostrarán **deshabilitados** (disabled) y no se podrán editar.

---

## Estrategias para deshabilitar campos

Existen **3 enfoques** para deshabilitar los campos según el valor de `cc_edit`:

### Opción 1: onRecord (Recomendado para Editable Grid - Multiple Records)

En **Form Settings** → **Events** → **onRecord**:

```php
// Deshabilitar campos si cc_edit = 0 (ya tiene usuario creado)
if ({cc_edit} == 0) {
    // Deshabilitar campos individuales
    {nombre}->setReadOnly(true);
    {apellido_p}->setReadOnly(true);
    {apellido_m}->setReadOnly(true);
    {correo}->setReadOnly(true);
    
    // Opcional: ocultar el botón Guardar para este registro
    // sc_btn_save_display(false);
    
    // Opcional: cambiar el estilo visual para indicar que está bloqueado
    {nombre}->setCss('background-color', '#f0f0f0');
    {apellido_p}->setCss('background-color', '#f0f0f0');
    {apellido_m}->setCss('background-color', '#f0f0f0');
    {correo}->setCss('background-color', '#f0f0f0');
}
```

**¿Por qué onRecord?**
- En un **Editable Grid (Multiple Records)**, `onRecord` se ejecuta **para cada fila** cargada.
- Permite deshabilitar campos **fila por fila** según el valor de `cc_edit` de cada registro.
- Es la solución más limpia y visual para grids editables.

---

### Opción 2: onLoad (Para Form Simple o Single Record)

En **Form Settings** → **Events** → **onLoad**:

```php
// Si es un formulario simple (un solo registro por vez)
if ({cc_edit} == 0) {
    {nombre}->setReadOnly(true);
    {apellido_p}->setReadOnly(true);
    {apellido_m}->setReadOnly(true);
    {correo}->setReadOnly(true);
    
    // Ocultar botón Guardar
    sc_btn_update_display(false);
    
    // Mostrar mensaje informativo
    sc_message("Este recomendante ya tiene usuario de acceso. No se puede editar.", 'info');
}
```

**¿Cuándo usar onLoad?**
- Para formularios **simples** (Single Record) donde solo se edita un registro a la vez.
- No funciona bien en **Editable Grid** porque `onLoad` se ejecuta una sola vez para todo el grid, no por fila.

---

### Opción 3: onBeforeUpdate + Mensaje de Error (Validación en Backend)

Ya está implementado en tu código (`Eventos/OnBeforeUpdate`):

```php
// Bloquear si este recomendante ya tiene usuario creado (cc_edit = 0 o 'N').
sc_lookup(rs, "SELECT cc_edit FROM recomendantes WHERE id_recom = " . sc_sql_injection({id_recom}));
$cc = isset({rs[0][0]}) ? trim({rs[0][0]}) : 1;
if ($cc == 0 || $cc === 'N') {
    sc_error_message("Este recomendante ya tiene usuario de acceso para subir cartas. No se puede editar.");
    exit;
}
```

**Ventaja:** Seguridad en backend. Aunque el usuario intente modificar el HTML del formulario, el servidor lo bloqueará.

**Desventaja:** El usuario no ve que los campos están bloqueados hasta que intenta guardar.

---

## Recomendación Final: Combinar estrategias

Para máxima usabilidad y seguridad:

1. **onRecord** (frontend): Deshabilitar campos visualmente, cambiar color de fondo.
2. **onBeforeUpdate** (backend): Validación de seguridad, bloquear guardado en servidor.

```php
// ========== onRecord ==========
if ({cc_edit} == 0) {
    {nombre}->setReadOnly(true);
    {apellido_p}->setReadOnly(true);
    {apellido_m}->setReadOnly(true);
    {correo}->setReadOnly(true);
    
    // Cambiar fondo a gris claro para indicar visualmente que no es editable
    {nombre}->setCss('background-color', '#e9ecef');
    {apellido_p}->setCss('background-color', '#e9ecef');
    {apellido_m}->setCss('background-color', '#e9ecef');
    {correo}->setCss('background-color', '#e9ecef');
    
    // Opcional: agregar un ícono o tooltip
    {nombre}->setHelp("Este recomendante ya tiene usuario creado. No es editable.");
}

// ========== onBeforeUpdate (ya implementado) ==========
sc_lookup(rs, "SELECT cc_edit FROM recomendantes WHERE id_recom = " . sc_sql_injection({id_recom}));
$cc = isset({rs[0][0]}) ? trim({rs[0][0]}) : 1;
if ($cc == 0 || $cc === 'N') {
    sc_error_message("Este recomendante ya tiene usuario de acceso para subir cartas. No se puede editar.");
    exit;
}
```

---

## Cómo implementar en Scriptcase

### Paso 1: Agregar el campo cc_edit al formulario

1. En Scriptcase, abre el form `form_recomendantes`.
2. Ve a **Application** → **Fields**.
3. Agrega el campo `cc_edit` (si no está ya agregado).
4. En **Field Settings** → **Display Settings**, configúralo como **Hidden** (oculto) para que no se muestre al usuario, pero esté disponible en el código.

### Paso 2: Agregar código en onRecord

1. Ve a **Events** → **onRecord**.
2. Pega el código del ejemplo de **onRecord** (opción 1).
3. Guarda y despliega la aplicación.

### Paso 3: Probar

1. Accede al formulario y edita un recomendante con `cc_edit = 1` → Debe estar **editable**.
2. Guarda el registro → Se crea usuario, se envía correo, y `cc_edit` se actualiza a `0`.
3. Recarga el formulario → Esa fila debe aparecer con campos **deshabilitados** y fondo gris.

---

## JSON de ejemplo con cc_edit

```json
{
  "recomendantes": [
    {
      "id_recom": 1,
      "id_persacadposg_FK": 1,
      "nombre": "Carolina",
      "apellido_p": "Valdespino",
      "apellido_m": "Quevedo",
      "correo": "carolina.valdespino@inecol.mx",
      "num_recom": 1,
      "login_FK": "0",
      "cc_edit": 1
    },
    {
      "id_recom": 2,
      "id_persacadposg_FK": 1,
      "nombre": "Salvador",
      "apellido_p": "Mandujano",
      "apellido_m": "Rodríguez",
      "correo": "salvador.mandujano@inecol.mx",
      "num_recom": 2,
      "login_FK": "salvador.mandujano@inecol.mx",
      "cc_edit": 0
    }
  ]
}
```

En el ejemplo anterior:
- **Recomendante 1** (`cc_edit = 1`) → **Editable** (aún no se ha creado usuario).
- **Recomendante 2** (`cc_edit = 0`) → **No editable** (ya tiene usuario creado, campos bloqueados).

---

## Métodos útiles de Scriptcase para deshabilitar

| Método | Descripción | Uso |
|--------|-------------|-----|
| `{campo}->setReadOnly(true)` | Marca el campo como solo lectura (input disabled) | Frontend |
| `{campo}->setCss('background-color', '#e9ecef')` | Cambia el color de fondo del campo | Estilo visual |
| `{campo}->setHelp("Texto")` | Agrega un tooltip/ayuda al campo | Info al usuario |
| `sc_btn_update_display(false)` | Oculta el botón Guardar/Update | Form simple |
| `sc_btn_save_display(false)` | Oculta el botón Guardar para esa fila | Grid editable |
| `sc_error_message("Mensaje")` | Muestra mensaje de error y bloquea guardado | Backend (onBeforeUpdate) |

---

## Resumen

1. **Columna cc_edit** en la tabla: `TINYINT(1)`, default `1` (editable).
2. **onAfterUpdate**: Tras crear usuario, actualiza `cc_edit = 0`.
3. **onRecord**: Al cargar cada fila, si `cc_edit = 0`, deshabilita campos con `setReadOnly(true)` y cambia estilo visual.
4. **onBeforeUpdate**: Validación de seguridad en backend para bloquear guardado si `cc_edit = 0`.

**Resultado:** Experiencia de usuario clara (campos visualmente deshabilitados) + seguridad (validación en servidor).
