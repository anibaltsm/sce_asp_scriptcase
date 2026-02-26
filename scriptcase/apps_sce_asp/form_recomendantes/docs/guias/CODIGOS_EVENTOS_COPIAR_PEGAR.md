# 📋 Códigos de Eventos - Copiar y Pegar en Scriptcase

**VERSIÓN CORREGIDA** - Sin errores de parse

Estos son los códigos completos y listos para copiar y pegar en cada evento de Scriptcase.

---

## 📍 Evento: onApplicationInit (Opcional)

**Ruta en Scriptcase:** `Events` → `onApplicationInit`

```php
// Validar que el usuario haya iniciado sesión como aspirante
if (empty($_SESSION['id_asp']) || (string)$_SESSION['id_asp'] === '') {
    sc_error_message("Debe iniciar sesión como aspirante para acceder a Recomendantes.");
    sc_redir('menu_aspirante');
    exit;
}
[id_asp] = $_SESSION['id_asp'];
```

---

## ⚠️ Evento: onValidate (Confirmación)

**Ruta en Scriptcase:** `Events` → `onValidate`

**✅ VERSIÓN CORREGIDA** - Sintaxis válida de `sc_confirm()`

```php
// ====================================================================
// Evento: onValidate
// VERSIÓN CORREGIDA: Confirmación antes de guardar
// ====================================================================

// Mensaje de confirmación usando sc_confirm correctamente
$msg = "⚠️ IMPORTANTE:\n\nUna vez guardado este recomendante, NO podrá modificar el correo ni otros datos.\n\nPor favor, verifique que todos los datos sean correctos.\n\n¿Desea continuar?";

sc_confirm($msg);
```

**Nota:** `sc_confirm()` NO devuelve booleano. Si el usuario cancela, Scriptcase aborta automáticamente el guardado. NO usar `if (!sc_confirm())` porque genera error de parse.

---

## ⭐ Evento: onLoadRecord (IMPORTANTE - Por fila)

**Ruta en Scriptcase:** `Events` → `onLoadRecord`

**⚠️ El código DEBE estar en onLoadRecord, NO en onLoad.**

- **onLoad** se ejecuta una vez → deshabilita TODAS las filas (error)
- **onLoadRecord** se ejecuta por cada fila → deshabilita solo la fila con cc_edit=0

```php
// ====================================================================
// Evento: onLoadRecord - Se ejecuta POR CADA FILA
// Deshabilitar campos solo de la fila donde cc_edit = 0
// ====================================================================

if ({cc_edit} == 0) {
    sc_field_disabled_record("nombre_=true;apellido_p_=true;apellido_m_=true;correo_=true");
}
```

**Nota:** Usar `sc_field_disabled_record()` para bloquear por fila, NO `sc_field_readonly()` que bloquea toda la columna.

---

## 🔄 Evento: onLoad (Recarga automática)

**Ruta en Scriptcase:** `Events` → `onLoad`

**✅ NUEVA FUNCIONALIDAD:** Detecta flag de sesión y recarga automáticamente tras guardar

```php
// ====================================================================
// Evento: onLoad
// Recarga automática si se guardó algún registro
// ====================================================================

// Si se marcó para recargar (tras guardar), hacer el reload
if (isset($_SESSION['form_recomendantes_need_reload']) && $_SESSION['form_recomendantes_need_reload']) {
    // Limpiar bandera
    unset($_SESSION['form_recomendantes_need_reload']);
    
    // Recargar con JavaScript
    ?>
    <script>
        // Esperar a que cargue completamente y recargar una sola vez
        if (!sessionStorage.getItem('form_recomendantes_reloaded')) {
            sessionStorage.setItem('form_recomendantes_reloaded', '1');
            setTimeout(function() {
                window.location.reload();
            }, 500);
        } else {
            // Ya se recargó, limpiar flag
            sessionStorage.removeItem('form_recomendantes_reloaded');
        }
    </script>
    <?php
}
```

**Nota:** Usa `sessionStorage` para evitar bucles infinitos de recarga.

---

## 🔒 Evento: OnBeforeUpdate (Validación Backend)

**Ruta en Scriptcase:** `Events` → `OnBeforeUpdate`

```php
// ====================================================================
// Evento: OnBeforeUpdate
// Validación: bloquear si el recomendante ya tiene usuario creado
// ====================================================================

// Bloquear si este recomendante ya tiene usuario creado (cc_edit = 0 o 'N').
sc_lookup(rs, "SELECT cc_edit FROM recomendantes WHERE id_recom = " . sc_sql_injection({id_recom}));
$cc = isset({rs[0][0]}) ? trim({rs[0][0]}) : 1;

if ($cc == 0 || $cc === 'N') {
    sc_error_message("Este recomendante ya tiene usuario de acceso para subir cartas. No se puede editar.");
    exit;
}
```

---

## 💾 Evento: onAfterUpdate (Crear usuario + enviar correos)

**Ruta en Scriptcase:** `Events` → `onAfterUpdate`

**✅ VERSIÓN MEJORADA:** Incluye envío de 2 correos y marca flag para recarga

```php
// ====================================================================
// Evento: onAfterUpdate
// VERSIÓN MEJORADA: Crea usuario + envía correos + recarga automática
// ====================================================================

error_log("form_recomendantes onAfterUpdate: INICIO id_recom={id_recom} correo={correo}");

// 1. Crear usuario y enviar correos
crear_usuario_recomendante({id_recom}, {nombre}, {apellido_p}, {apellido_m}, {correo});

error_log("form_recomendantes onAfterUpdate: FIN método ejecutado");

// 2. Marcar que necesitamos recargar (solo en el último guardado)
$_SESSION['form_recomendantes_need_reload'] = true;
```

---

## 🔧 Método: crear_usuario_recomendante

**Ruta en Scriptcase:** `Methods` → `crear_usuario_recomendante`

**Parámetros:** `$id_recom, $nombre, $apellido_p, $apellido_m, $correo`

**✅ VERSIÓN MEJORADA:** Envía 2 correos (admin + recomendante)

Ver el archivo completo en: `/metodos/crear_usuario_recomendante($id_recom, $nombre, $apellido_p, $apellido_m, $correo)`

**Cambios principales:**
1. Envía correo al administrador (anibal.sanchez@inecol.mx)
2. Envía correo al recomendante (su correo) con sus datos de acceso
3. Logs detallados para debugging

---

## ❌ Eventos NO Usados

### onAfterUpdateAll - NO USAR

**Razón:** Requiere que el formulario esté configurado como "Multiple records" con "Orientation" específica. Genera advertencia en Scriptcase y puede no funcionar.

**Solución:** Usar `onLoad` con flag de sesión (implementado arriba).

---

## 📝 Resumen de Eventos

| Evento | Descripción | ¿Obligatorio? |
|--------|-------------|---------------|
| `onApplicationInit` | Validar sesión aspirante | Opcional |
| **`onValidate`** | Confirmación antes de guardar | ✅ Sí |
| **`onLoadRecord`** | Bloquear campos por fila (cc_edit=0) | ✅ Sí |
| **`onLoad`** | Recarga automática tras guardar | ✅ Sí |
| **`OnBeforeUpdate`** | Prevenir edición si cc_edit=0 | ✅ Sí |
| **`onAfterUpdate`** | Crear usuario + correos | ✅ Sí |

---

## 🚀 Pasos para Aplicar en Scriptcase

1. **Abrir** el formulario `form_recomendantes` en Scriptcase

2. **Configurar eventos** uno por uno:
   - Events → **onValidate** → Copiar código de arriba
   - Events → **onLoad** → Copiar código de arriba
   - Events → **onLoadRecord** → Copiar código de arriba
   - Events → **OnBeforeUpdate** → Copiar código de arriba
   - Events → **onAfterUpdate** → Copiar código de arriba

3. **Verificar método:**
   - Methods → **crear_usuario_recomendante** → Debe tener el código con 2 correos

4. **Generar y desplegar:**
   ```
   Generate Source Code (uno por uno) → Deploy
   ```

5. **Verificar sin errores:**
   ```bash
   tail -50 /Applications/XAMPP/xamppfiles/logs/php_error_log | grep -i "parse\|fatal"
   ```
   
   **Esperado:** NO debe haber errores de parse

---

## 🔍 Troubleshooting

### Error: "syntax error, unexpected token ;"

**Causa:** Código `if (!sc_confirm())` mal usado

**Solución:** Usar solo `sc_confirm($msg);` sin `if`

### Error: "onAfterUpdateAll not available"

**Causa:** Formulario no configurado como "Multiple records"

**Solución:** Usar `onLoad` con flag de sesión (implementado arriba)

### Campos no se bloquean por fila

**Causa:** Código en `onLoad` en lugar de `onLoadRecord`

**Solución:** Mover código a `onLoadRecord`

### No recarga automáticamente

**Causa:** Flag de sesión no se marca en `onAfterUpdate`

**Solución:** Agregar `$_SESSION['form_recomendantes_need_reload'] = true;`

---

## 📚 Referencias

- [Macros Scriptcase](https://www.scriptcase.net/docs/en_us/v9/manual/14-macros/02-macros/)
- [Form Events](https://www.scriptcase.net/docs/en_us/v9/manual/06-applications/05-form-application/18-form-events/)
- Ver también: `SOLUCION_ERRORES_PARSE.md` para explicación detallada
