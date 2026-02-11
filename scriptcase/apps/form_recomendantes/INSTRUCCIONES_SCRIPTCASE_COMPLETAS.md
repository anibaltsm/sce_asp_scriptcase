# Instrucciones completas para form_recomendantes (todo por Scriptcase)

Solución para los dos problemas:
1. **"Se bloquean los 3"** al recargar → El código debe estar en **onLoadRecord**, no en onLoad
2. **"No se bloquea al guardar"** → Hay que **recargar el formulario** después del guardado para ver el estado actualizado

---

## Problema 1: Los 3 se bloquean

**Causa:** Si el código está en **onLoad**, se ejecuta una sola vez y deshabilita toda la columna. Debe estar en **onLoadRecord**, que se ejecuta por cada fila.

## Problema 2: No se bloquea inmediatamente al guardar

**Causa:** Tras guardar, la BD se actualiza correctamente (`cc_edit = 0`), pero el formulario no recarga los datos. Solo al recargar el menú se ven los cambios. Hay que forzar la recarga del formulario tras guardar.

---

# Configuración en Scriptcase

## 1. Evento onLoad → VACÍO

**Ruta:** `Form Settings` → `Events` → `onLoad`

**Borrar todo el contenido.** Dejar vacío o solo un comentario:

```php
// Vacío - la lógica está en onLoadRecord
```

---

## 2. Evento onLoadRecord → Bloquear solo la fila con cc_edit=0

**Ruta:** `Form Settings` → `Events` → `onLoadRecord`

**Pegar este código (sin sc_seq_register, que da error de compilación):**

```php
if ({cc_edit} == 0) {
    sc_field_readonly("nombre_", 'on');
    sc_field_readonly("apellido_p_", 'on');
    sc_field_readonly("apellido_m_", 'on');
    sc_field_readonly("correo_", 'on');
}
```

---

## 3. Evento onAfterUpdate → Recargar formulario tras guardar

**Ruta:** `Form Settings` → `Events` → `onAfterUpdate`

**Reemplazar el código actual por este (incluye crear_usuario + recarga):**

```php
// Crear usuario de acceso y enviar correo
crear_usuario_recomendante({id_recom}, {nombre}, {apellido_p}, {apellido_m}, {correo});

// Recargar el formulario para que se vea el bloqueo (cc_edit=0) de inmediato
sc_redir('form_recomendantes');
```

**Importante:** Si el formulario se abre desde otro (por ejemplo `menu_aspirante`), puede que debas usar:

```php
crear_usuario_recomendante({id_recom}, {nombre}, {apellido_p}, {apellido_m}, {correo});
sc_redir('menu_aspirante');  // si Recomendantes está dentro del menú
```

o el nombre exacto de la aplicación que muestra este formulario.

---

## 4. Configuración del botón Guardar (opcional)

En **Form Settings** → **Buttons** → **Update/Save**:

- Revisar si existe la opción **"Redirect after Update"** o **"Recargar después de guardar"**
- Si está disponible, activarla en lugar de usar `sc_redir` en `onAfterUpdate`

---

## 5. Verificar campo cc_edit

En **Form Settings** → **Fields** → `cc_edit`:

- **Display:** Hidden
- **Data type:** Integer
- **Values format:** Minimum = 0, Maximum = 1 (o dejarlo sin restricción si da problemas)

---

# Resumen de eventos

| Evento       | Código |
|-------------|--------|
| **onLoad**  | Vacío  |
| **onLoadRecord** | `if ({cc_edit} == 0) { sc_field_readonly(...); }` |
| **onAfterUpdate** | `crear_usuario_recomendante(...); sc_redir('form_recomendantes');` |
| **OnBeforeUpdate** | (sin cambios) Validación que bloquea si cc_edit=0 |

---

# Flujo esperado

1. Entras al formulario → Cada fila se procesa en **onLoadRecord**
2. Fila con **cc_edit=1** → Campos editables
3. Fila con **cc_edit=0** → Campos bloqueados (solo esa fila)
4. Editas una fila con cc_edit=1 y guardas → **onAfterUpdate** crea usuario, pone cc_edit=0 en BD
5. **sc_redir** recarga el formulario con datos nuevos
6. Al cargar de nuevo, esa fila tiene cc_edit=0 y **onLoadRecord** la bloquea

---

# Si sc_redir causa problemas

Si al usar `sc_redir` el guardado no se aplica o aparece algún error:

1. Quitar el `sc_redir` de `onAfterUpdate`
2. En **Form Settings** → **Buttons** → **Update**, revisar si hay opción de redirección
3. O usar en **onAfterUpdate**:

```php
crear_usuario_recomendante({id_recom}, {nombre}, {apellido_p}, {apellido_m}, {correo});
sc_set_global('[reload_form]', '1');
```

y en **JavaScript** del formulario (si existe evento onSuccess o similar) comprobar esa variable y llamar a `nm_recarga_form()`.

---

# Checklist final

- [ ] onLoad vacío
- [ ] onLoadRecord con lógica de bloqueo por fila
- [ ] onAfterUpdate con crear_usuario_recomendante + sc_redir
- [ ] Generate Source Code
- [ ] Deploy
- [ ] Probar: editar fila 1, guardar, comprobar que se recarga y solo esa fila queda bloqueada
