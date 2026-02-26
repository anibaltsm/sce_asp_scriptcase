# 🔧 Solución de Errores de Parse en form_recomendantes

## ❌ Problema Original

Al intentar usar `sc_confirm()` y `onAfterUpdateAll`, aparecían errores:

```
PHP Parse error: syntax error, unexpected token ";" in form_recomendantes_apl.php on line 2254
PHP Parse error: Unclosed '{' on line 3095 does not match ')' on line 3098
```

**Advertencia en Scriptcase:**
> "This event is only available on the Form application when 'Orientation' is set as 'Multiple records'."

---

## 🔍 Causas del Error

### 1. `sc_confirm()` mal usado
```php
// ❌ INCORRECTO - No funciona así en Scriptcase
if (!sc_confirm("mensaje")) {
    sc_error_exit();
}
```

**Problema:** `sc_confirm()` en Scriptcase no devuelve un booleano en PHP. Genera JavaScript y no se puede usar en un `if` de PHP directamente.

### 2. `onAfterUpdateAll` no disponible
```php
// ❌ INCORRECTO - Requiere configuración específica
// En onAfterUpdateAll
?>
<script>window.location.reload();</script>
<?php
```

**Problema:** El evento `onAfterUpdateAll` solo está disponible cuando el formulario tiene "Orientation" = "Multiple records", y puede no estar configurado correctamente.

---

## ✅ Solución Implementada

### 1. `sc_confirm()` Correcto

```php
// ✅ CORRECTO - Sintaxis válida en Scriptcase
$msg = "⚠️ IMPORTANTE:\n\nUna vez guardado este recomendante, NO podrá modificar el correo ni otros datos.\n\nPor favor, verifique que todos los datos sean correctos.\n\n¿Desea continuar?";

sc_confirm($msg);
```

**Explicación:**
- `sc_confirm()` genera un `confirm()` de JavaScript automáticamente
- Si el usuario cancela, Scriptcase aborta el guardado automáticamente
- No necesita `if` ni `sc_error_exit()`

### 2. Recarga con Session Flag + onLoad

En lugar de `onAfterUpdateAll`, usamos una combinación de eventos:

#### a) `onAfterUpdate`: Marca flag en sesión
```php
// 1. Crear usuario y enviar correos
crear_usuario_recomendante({id_recom}, {nombre}, {apellido_p}, {apellido_m}, {correo});

// 2. Marcar que necesitamos recargar
$_SESSION['form_recomendantes_need_reload'] = true;
```

#### b) `onLoad`: Detecta flag y recarga
```php
if (isset($_SESSION['form_recomendantes_need_reload']) && $_SESSION['form_recomendantes_need_reload']) {
    unset($_SESSION['form_recomendantes_need_reload']);
    ?>
    <script>
        if (!sessionStorage.getItem('form_recomendantes_reloaded')) {
            sessionStorage.setItem('form_recomendantes_reloaded', '1');
            setTimeout(function() {
                window.location.reload();
            }, 500);
        } else {
            sessionStorage.removeItem('form_recomendantes_reloaded');
        }
    </script>
    <?php
}
```

**Ventajas:**
- ✅ Funciona independientemente de la configuración del formulario
- ✅ Recarga solo una vez (evita bucles infinitos)
- ✅ Compatible con "Single Record" y "Multiple Records"
- ✅ No genera errores de parse

---

## 📊 Comparación

| Aspecto | ❌ Solución Anterior | ✅ Solución Nueva |
|---------|---------------------|------------------|
| **Confirmación** | `if (!sc_confirm())` → Parse error | `sc_confirm($msg)` → Funciona |
| **Recarga** | `onAfterUpdateAll` → Requiere config | `onLoad` + Session → Funciona siempre |
| **Compatibilidad** | Solo "Multiple Records" | Cualquier orientación |
| **Errores** | Parse errors 2254, 3098 | Sin errores |
| **Complejidad** | Simple pero no funciona | Un poco más complejo pero robusto |

---

## 🚀 Pasos para Aplicar la Solución

1. **Borrar evento anterior:**
   - En Scriptcase: Events → **onAfterUpdateAll** → Borrar todo el código
   - O simplemente no crear este evento

2. **Actualizar eventos:**
   - Events → **onValidate** → Copiar código de `/Eventos/onValidate`
   - Events → **onLoad** → Copiar código de `/Eventos/onLoad`
   - Events → **onAfterUpdate** → Copiar código de `/Eventos/onAfterUpdate`

3. **Generar y desplegar:**
   ```
   Generate Source Code (uno por uno) → Deploy
   ```

4. **Verificar logs:**
   ```bash
   tail -50 /Applications/XAMPP/xamppfiles/logs/php_error_log | grep -i "parse\|fatal\|recomendante"
   ```

   **Esperado:** NO debe haber errores de parse

---

## 🔍 Verificación de Funcionamiento

### 1. Confirmación antes de guardar
- Editar un recomendante
- Clic en **Guardar**
- **Debe aparecer:** Diálogo JavaScript con mensaje de confirmación
- **Si cancela:** No se guarda
- **Si acepta:** Se guarda normalmente

### 2. Recarga automática
- Después de guardar exitosamente
- **Debe:** Recargar automáticamente tras 500ms
- **Resultado:** Ver campos bloqueados inmediatamente
- **Importante:** Solo recarga UNA vez (no bucle infinito)

### 3. Correos enviados
```bash
tail -20 /Applications/XAMPP/xamppfiles/logs/php_error_log | grep "Correo enviado"
```

**Esperado:**
```
crear_usuario_recomendante: Correo enviado al admin (anibal.sanchez@inecol.mx)
crear_usuario_recomendante: Correo enviado al recomendante (correo@ejemplo.com)
```

---

## 🎯 Flujo Final Corregido

1. Usuario edita recomendante → Clic en **Guardar**
2. ⚠️ **onValidate:** `sc_confirm()` muestra confirmación → Usuario acepta/cancela
3. 🔒 **OnBeforeUpdate:** Verifica `cc_edit != 0` (previene edición)
4. 💾 **onAfterUpdate:** 
   - Crea usuario + envía 2 correos + `cc_edit = 0`
   - Marca `$_SESSION['form_recomendantes_need_reload'] = true`
5. 📄 Scriptcase muestra mensaje de éxito
6. 🔄 **onLoad (siguiente carga):** Detecta flag → Recarga automáticamente (500ms)
7. 🔒 **onLoadRecord:** Bloquea campos donde `cc_edit = 0`

---

## 💡 Lecciones Aprendidas

1. **`sc_confirm()` no es PHP:** No devuelve booleano, genera JavaScript automáticamente
2. **Eventos específicos:** Algunos eventos (`onAfterUpdateAll`) tienen requisitos de configuración
3. **Session + JavaScript:** Combinación poderosa para recarga controlada
4. **sessionStorage:** Previene bucles infinitos de recarga
5. **Parse errors:** Siempre revisar sintaxis generada en el PHP desplegado

---

## 📚 Referencias

- [Macros Scriptcase](https://www.scriptcase.net/docs/en_us/v9/manual/14-macros/02-macros/)
- [Form Events](https://www.scriptcase.net/docs/en_us/v9/manual/06-applications/05-form-application/18-form-events/)
- [sc_confirm Macro](https://www.scriptcase.net/docs/en_us/v9/manual/14-macros/02-macros/#sc_confirm)
