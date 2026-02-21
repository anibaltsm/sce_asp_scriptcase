# 📚 Referencias - Scriptcase v9 | PHP 8.1

## 🎯 Documentación Oficial

| Tema | URL |
|------|-----|
| **Form Events** | https://www.scriptcase.net/docs/en_us/v9/manual/06-applications/05-form-application/18-form-events/ |
| **onValidate** | https://www.scriptcase.net/docs/en_us/v9/manual/06-applications/05-form-application/18-form-events/08-onValidate |
| **Form Buttons** | https://www.scriptcase.net/docs/en_us/v9/manual/06-applications/05-form-application/20-form-buttons |
| **Form Toolbar** | https://www.scriptcase.net/docs/en_us/v9/manual/06-applications/05-form-application/06-form-toolbar |
| **Macros** | https://www.scriptcase.net/docs/en_us/v9/manual/14-macros/02-macros/ |

---

## 📌 Macros Usados (Palabras Reservadas)

| Macro | Uso | Evento/Método |
|-------|-----|---------------|
| `sc_confirm("mensaje")` | Confirmación antes de acción. NO usar `if`. Si cancela, detiene automáticamente | OnBeforeUpdate |
| `sc_error_message("texto")` | Mensaje de error. Cancela envío del formulario | onValidate, OnBeforeUpdate, crear_usuario_recomendante |
| `sc_error_exit()` | Salir tras error | - |
| `sc_lookup(rs, "SQL")` | Ejecutar SELECT y guardar en variable | OnBeforeUpdate, crear_usuario_recomendante |
| `sc_exec_sql("SQL")` | Ejecutar INSERT/UPDATE/DELETE | crear_usuario_recomendante |
| `sc_sql_injection(valor)` | Proteger valor contra SQL injection | OnBeforeUpdate, crear_usuario_recomendante |
| `sc_btn_display("botón", "on/off")` | Mostrar/ocultar botón toolbar | onApplicationInit |
| `sc_field_disabled_record("campo=true;...")` | Bloquear campos por fila (Multiple Records) | onLoadRecord |
| `sc_redir('app')` | Redirigir a aplicación | onApplicationInit |
| `sc_mail_send(...)` | Enviar correo | crear_usuario_recomendante |

---

## ⚠️ Notas Importantes sobre sc_confirm()

**Documentación oficial:** [sc_confirm](https://www.scriptcase.net/docs/en_us/v9/manual/14-macros/02-macros/) - "This macro shows a Javascript confirmation screen."

### ✅ CORRECTO - NO usar if/return
```php
sc_confirm("ADVERTENCIA\n\n¿Desea GUARDAR? (Cancelar = No guardar)");

// Tu código continúa aquí...
if ({cc_edit} == 'N') {
    sc_error_message("Sin permiso");
    exit;
}
```

### ❌ INCORRECTO
```php
// NO usar así - causa errores de parse
if (!sc_confirm("¿Estás seguro?")) {
    return;
}
```

**Comportamiento:**
- Usuario **OK / Aceptar** → Continúa ejecutando el código (equivale a "Guardar")
- Usuario **Cancel / Cancelar** → Scriptcase detiene la ejecución automáticamente (no guarda)

---

## 📋 Botones Estándar vs Personalizados

| Tipo | "Confirmation Message" | Confirmación |
|------|------------------------|--------------|
| **Estándar** (Update, Insert, Delete) | ❌ NO existe | Usar `sc_confirm()` en eventos |
| **Personalizados** (JavaScript, PHP, Ajax, Link) | ✅ SÍ existe | Configurar en UI del botón |

**Fuente:** [Form Buttons Settings](https://www.scriptcase.net/docs/en_us/v9/manual/06-applications/05-form-application/20-form-buttons)

---

## 📧 Validación de correo electrónico

En `onValidate` se valida formato con PHP nativo:

```php
if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    sc_error_message("El correo electrónico ingresado no es válido...");
    return;
}
```

**Orden de validación:** Obligatorios primero → formato email después.

---

## 🔧 Configuración Sugerida

**Highlight Field with Error** (mejora UX en validaciones):
```
Settings → Form Settings → Layout and Behavior → Highlight Field with Error
```
Activar para enfocar el primer campo con error al validar.

---

## 📂 Eventos y Macros por Archivo

| Archivo | Macros | URL Documentación |
|---------|--------|-------------------|
| **onApplicationInit** | sc_btn_display, sc_error_message, sc_redir | [Form Events](https://www.scriptcase.net/docs/en_us/v9/manual/06-applications/05-form-application/18-form-events/) |
| **onScriptInit** | (ninguno) | [Form Events](https://www.scriptcase.net/docs/en_us/v9/manual/06-applications/05-form-application/18-form-events/) |
| **onLoad** | (ninguno; $_SESSION) | [Form Events](https://www.scriptcase.net/docs/en_us/v9/manual/06-applications/05-form-application/18-form-events/) |
| **onValidate** | sc_error_message, filter_var (PHP) | [onValidate](https://www.scriptcase.net/docs/en_us/v9/manual/06-applications/05-form-application/18-form-events/08-onValidate) |
| **onBeforeUpdateAll** | sc_confirm | [onBeforeUpdateAll](https://www.scriptcase.net/docs/en_us/v9/manual/06-applications/05-form-application/18-form-events/17-onBeforeUpdateAll) |
| **OnBeforeUpdate** | No se ejecuta en Multiple Records | - |
| **onAfterUpdate** | (llama crear_usuario_recomendante) | [Form Events](https://www.scriptcase.net/docs/en_us/v9/manual/06-applications/05-form-application/18-form-events/) |
| **onLoadRecord** | sc_field_disabled_record | [Macros](https://www.scriptcase.net/docs/en_us/v9/manual/14-macros/02-macros/) |
| **crear_usuario_recomendante** | sc_lookup, sc_sql_injection, sc_exec_sql, sc_mail_send, sc_error_message | [Macros](https://www.scriptcase.net/docs/en_us/v9/manual/14-macros/02-macros/) |

---

## 🎯 Versión

- **Scriptcase:** v9
- **PHP:** 8.1
- **Form Type:** Multiple Records (Editable Grid)
- **Última actualización:** Feb 2026
