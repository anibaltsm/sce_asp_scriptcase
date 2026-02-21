# 🔍 Problema: onAfterUpdate se ejecuta múltiples veces

## ❌ Problema Detectado

En los logs vemos:

```
22:49:07 - ✅ CORRECTO:
💾 onAfterUpdate: id_recom=00000000028 correo=sshdsds@dawd.com
crear_usuario_recomendante: Correo enviado al admin
crear_usuario_recomendante: Correo enviado al recomendante

22:49:27 - ❌ INCORRECTO (20 segundos después):
💾 onAfterUpdate: id_recom= correo=
crear_usuario_recomendante: ERROR correo vacío
```

---

## 🔍 Causa

En formularios tipo **"Multiple Records"** (Editable Grid), el evento `onAfterUpdate` puede ejecutarse en dos momentos:

1. ✅ **Al guardar un registro** - Aquí SÍ tiene datos válidos
2. ❌ **Al cargar la página** - Aquí NO tiene datos (vacío)

Scriptcase ejecuta `onAfterUpdate` por cada registro al cargar, pero con campos vacíos.

---

## ✅ Solución

Agregar **validación al inicio** de `onAfterUpdate` para verificar que hay datos reales:

```php
// VALIDACIÓN CRÍTICA: Solo ejecutar si hay datos válidos
$id_recom_val = trim({id_recom});
$correo_val = trim({correo});

error_log("💾 onAfterUpdate: INICIO id_recom=$id_recom_val correo=$correo_val");

// Si no hay id_recom, NO hacer nada (es una carga, no un guardado)
if (empty($id_recom_val) || $id_recom_val === '' || $id_recom_val === '0') {
    error_log("💾 onAfterUpdate: SKIP - id_recom vacío (no es guardado real)");
    return;
}

// Si no hay correo, NO crear usuario
if (empty($correo_val) || $correo_val === '') {
    error_log("💾 onAfterUpdate: SKIP - correo vacío");
    return;
}

// Aquí sí ejecutar la lógica normal
crear_usuario_recomendante(...);
```

---

## 📊 Comparación

### ❌ Antes (sin validación)

```
[Cargar página]
→ onAfterUpdate ejecutado con id_recom="" correo=""
→ ERROR: correo vacío
→ Mensaje de error al usuario
```

### ✅ Después (con validación)

```
[Cargar página]
→ onAfterUpdate ejecutado con id_recom="" correo=""
→ SKIP (return inmediato)
→ No hace nada, no hay error

[Guardar registro]
→ onAfterUpdate ejecutado con id_recom="28" correo="email@test.com"
→ Validación pasa
→ Crea usuario y envía correos
→ ✅ Éxito
```

---

## 🚀 Aplicar la Solución

### Paso 1: Actualizar onAfterUpdate

**Copiar de:** `/Eventos/onAfterUpdate`

### Paso 2: Generar y desplegar

```
Generate Source Code (uno por uno) → Deploy
```

### Paso 3: Verificar logs

```bash
tail -f /Applications/XAMPP/xamppfiles/logs/php_error_log | grep "onAfterUpdate"
```

**Esperado al cargar:**
```
💾 onAfterUpdate: INICIO id_recom= correo=
💾 onAfterUpdate: SKIP - id_recom vacío (no es guardado real)
```

**Esperado al guardar:**
```
💾 onAfterUpdate: INICIO id_recom=28 correo=test@example.com
crear_usuario_recomendante: INICIO
crear_usuario_recomendante: Correo enviado al admin
crear_usuario_recomendante: Correo enviado al recomendante
💾 onAfterUpdate: FIN
```

---

## ✅ Resultado

- ✅ NO muestra error "correo vacío" al cargar
- ✅ SÍ crea usuario cuando realmente guardas
- ✅ SÍ envía correos cuando hay datos válidos
- ✅ Logs más limpios

---

## 📝 Lección Aprendida

En formularios "Multiple Records", **SIEMPRE validar** que hay datos reales antes de ejecutar lógica en eventos como:
- `onAfterUpdate`
- `onAfterInsert`
- `onBeforeUpdate`

**Patrón recomendado:**

```php
// Al inicio del evento
$campo_clave = trim({campo_clave});

if (empty($campo_clave)) {
    error_log("EVENTO: SKIP - sin datos válidos");
    return;
}

// Resto de la lógica...
```

---

## 🔗 Eventos Afectados

En este proyecto:
- ✅ **onAfterUpdate** - Actualizado con validación
- ✅ **crear_usuario_recomendante** - Ya tiene validación de correo
- ✅ **OnBeforeUpdate** - Ya valida cc_edit

Todos ahora validan datos antes de ejecutar.
