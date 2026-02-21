# Solución: Bloqueo de campos por fila (cc_edit)

## El problema

- **onLoad** se ejecuta **UNA sola vez** para todo el formulario
- En ese momento `$sc_seq_vert` no existe en ese ámbito
- El código deshabilita **TODAS** las filas en lugar de solo las que tienen `cc_edit = 0`
- Resultado: todo aparece bloqueado desde el inicio

## La solución

La lógica debe estar en **onLoadRecord**, que se ejecuta **por cada fila** con el contexto correcto (`$sc_seq_vert` = número de fila).

---

## Pasos en Scriptcase

### 1. Vaciar el evento onLoad

En **Events** → **onLoad**: eliminar todo el código y dejarlo vacío (o con un comentario).

### 2. Poner el código en onLoadRecord

En **Events** → **onLoadRecord**: pegar este código:

```php
if ({cc_edit} == 0) {
    sc_field_readonly("nombre_", 'on');
    sc_field_readonly("apellido_p_", 'on');
    sc_field_readonly("apellido_m_", 'on');
    sc_field_readonly("correo_", 'on');
}
```

**Nota:** No usar `sc_seq_register()` como tercer parámetro — da error de compilación.

### 4. Generate Source Code y Deploy

---

## Parche manual directo (si no puedes usar Scriptcase ahora)

Si necesitas corregir el PHP desplegado sin pasar por Scriptcase:

**Archivo:** `htdocs/sce_asp/form_recomendantes/form_recomendantes_apl.php`

1. **En `nm_proc_onload_record`** (aprox. línea 3087): sustituir el cuerpo vacío por:

```php
function nm_proc_onload_record($sc_seq_vert=0)
{
    if ($this->cc_edit_ !== null && $this->cc_edit_ !== '' && $this->cc_edit_ == 0) {
        $this->sc_field_readonly("nombre_", 'on', $sc_seq_vert);
        $_SESSION['sc_session'][$this->Ini->sc_page]['form_recomendantes']['Field_disabled_macro']['nombre_'] = array('I'=>array(),'U'=>array());
        $this->sc_field_readonly("apellido_p_", 'on', $sc_seq_vert);
        $_SESSION['sc_session'][$this->Ini->sc_page]['form_recomendantes']['Field_disabled_macro']['apellido_p_'] = array('I'=>array(),'U'=>array());
        $this->sc_field_readonly("apellido_m_", 'on', $sc_seq_vert);
        $_SESSION['sc_session'][$this->Ini->sc_page]['form_recomendantes']['Field_disabled_macro']['apellido_m_'] = array('I'=>array(),'U'=>array());
        $this->sc_field_readonly("correo_", 'on', $sc_seq_vert);
        $_SESSION['sc_session'][$this->Ini->sc_page]['form_recomendantes']['Field_disabled_macro']['correo_'] = array('I'=>array(),'U'=>array());
    }
}
```

2. **En `nm_proc_onload`** (aprox. línea 3090): eliminar el bloque que deshabilita campos (el `if ($this->cc_edit_ == 0) { ... }`). Dejar solo el resto del código (original_cc_edit_, etc.).

---

## Flujo esperado

1. **cc_edit = 1** → campos editables, candado abierto
2. Usuario edita y guarda → onAfterUpdate crea usuario, envía correo, pone **cc_edit = 0**
3. Al recargar, **cc_edit = 0** → onLoadRecord deshabilita **solo esa fila**
4. Las otras filas con cc_edit = 1 siguen editables

---

## Para desbloquear manualmente

```sql
UPDATE recomendantes SET cc_edit = 1 WHERE id_recom = X;
```

Donde `X` es el `id_recom` del recomendante que quieras volver a permitir editar.
