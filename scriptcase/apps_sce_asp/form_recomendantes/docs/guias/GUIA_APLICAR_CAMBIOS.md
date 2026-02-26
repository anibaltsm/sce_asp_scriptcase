# 🚀 Guía Paso a Paso - Aplicar Cambios en Scriptcase

## ✅ Cambios Implementados

### 1. ⚠️ Confirmación JavaScript (más confiable)
- Reemplaza `sc_confirm()` por JavaScript puro
- Muestra diálogo de confirmación antes de guardar

### 2. 🔄 Recarga automática con logs
- Detecta cuando se guardó un registro
- Recarga automáticamente el formulario
- Logs detallados para debugging

### 3. ❌ Botón de borrar OCULTO
- Usa `sc_btn_display("delete", "off")`
- Se oculta en `onApplicationInit`

### 4. 📊 Logs en todos los eventos
- Prefijos con emojis para fácil identificación:
  - 📋 onApplicationInit
  - 🔔 onValidate
  - 🔄 onLoad
  - 💾 onAfterUpdate
  - 🔒 onLoadRecord

---

## 📂 Eventos a Configurar en Scriptcase

### 1️⃣ onApplicationInit (NUEVO - Importante)

**Ruta:** Form Settings → Events → onApplicationInit

**Copiar de:** `/Eventos/onApplicationInit`

**Qué hace:**
- ✅ Oculta el botón "Delete" (borrar)
- ✅ Valida sesión del aspirante
- ✅ Logs para debugging

---

### 2️⃣ onValidate (ACTUALIZADO)

**Ruta:** Form Settings → Events → onValidate

**Copiar de:** `/Eventos/onValidate`

**Qué hace:**
- ✅ Muestra confirmación con JavaScript puro (más confiable)
- ✅ Logs para verificar que se ejecuta

**Cambio clave:** JavaScript directo en lugar de `sc_confirm()`

---

### 3️⃣ onLoad (ACTUALIZADO)

**Ruta:** Form Settings → Events → onLoad

**Copiar de:** `/Eventos/onLoad`

**Qué hace:**
- ✅ Detecta flag `$_SESSION['form_recomendantes_need_reload']`
- ✅ Recarga automáticamente tras guardar
- ✅ Logs detallados de cada paso

---

### 4️⃣ onAfterUpdate (ACTUALIZADO)

**Ruta:** Form Settings → Events → onAfterUpdate

**Copiar de:** `/Eventos/onAfterUpdate`

**Qué hace:**
- ✅ Crea usuario + envía correos
- ✅ Marca flag de recarga en sesión
- ✅ Logs con emoji 💾

---

### 5️⃣ onLoadRecord (ACTUALIZADO)

**Ruta:** Form Settings → Events → onLoadRecord

**Copiar de:** `/Eventos/onLoadRecord`

**Qué hace:**
- ✅ Bloquea campos por fila si cc_edit=0
- ✅ Logs de cada fila procesada

---

### 6️⃣ OnBeforeUpdate (Sin cambios)

**Ruta:** Form Settings → Events → OnBeforeUpdate

**Copiar de:** `/Eventos/OnBeforeUpdate`

**Qué hace:**
- ✅ Previene guardado si cc_edit=0

---

## 🔧 Pasos para Aplicar

### Paso 1: Abrir Scriptcase
```
Abrir proyecto → form_recomendantes
```

### Paso 2: Copiar cada evento

Para cada evento (onApplicationInit, onValidate, onLoad, onAfterUpdate, onLoadRecord, OnBeforeUpdate):

1. **En VS Code/Cursor:**
   - Abrir archivo del evento en `/Eventos/[nombre_evento]`
   - Seleccionar TODO el contenido (Cmd+A o Ctrl+A)
   - Copiar (Cmd+C o Ctrl+C)

2. **En Scriptcase:**
   - Ir a: Form Settings → Events → [nombre_evento]
   - **Borrar** todo el contenido anterior
   - **Pegar** el nuevo código
   - Click en **Save**

### Paso 3: Generar código
```
Application → Generate Source Code (uno por uno)
```

**Importante:** Generar UNO POR UNO, no todos a la vez.

### Paso 4: Desplegar
```
Deploy
```

### Paso 5: Probar y verificar logs

---

## 📊 Verificar Funcionamiento

### 1. Ver logs en tiempo real

```bash
tail -f /Applications/XAMPP/xamppfiles/logs/php_error_log | grep "form_recomendantes"
```

**Mantener esta terminal abierta mientras pruebas.**

### 2. Probar el flujo completo

#### a) Cargar formulario
**Esperado en logs:**
```
📋 form_recomendantes onApplicationInit: INICIO
📋 form_recomendantes onApplicationInit: Botón DELETE ocultado
📋 form_recomendantes onApplicationInit: id_asp = 1276
📋 form_recomendantes onApplicationInit: FIN
🔄 form_recomendantes onLoad: INICIO
🔄 form_recomendantes onLoad: need_reload = false
🔄 form_recomendantes onLoad: FIN
🔒 form_recomendantes onLoadRecord: id_recom=26 cc_edit=1
🔒 form_recomendantes onLoadRecord: id_recom=27 cc_edit=1
🔒 form_recomendantes onLoadRecord: id_recom=28 cc_edit=1
```

**Verificar en pantalla:**
- ❌ NO debe aparecer botón "Delete" (Borrar)

#### b) Editar y guardar un registro
1. Cambiar el correo de un recomendante
2. Click en **Guardar**

**Esperado:**
- ⚠️ Debe aparecer diálogo JavaScript de confirmación
- Si das **Aceptar**, continúa el guardado

**Esperado en logs:**
```
🔔 form_recomendantes onValidate: INICIO - Mostrando confirmación
🔔 form_recomendantes onValidate: FIN - Confirmación mostrada
💾 form_recomendantes onAfterUpdate: INICIO id_recom=26 correo=nuevo@correo.com
crear_usuario_recomendante: INICIO id_recom=26 correo=nuevo@correo.com
crear_usuario_recomendante: cc_edit=1 para id_recom=26
crear_usuario_recomendante: Correo enviado al admin (anibal.sanchez@inecol.mx)
crear_usuario_recomendante: Correo enviado al recomendante (nuevo@correo.com)
💾 form_recomendantes onAfterUpdate: Método crear_usuario ejecutado
💾 form_recomendantes onAfterUpdate: Flag de recarga marcado en sesión
💾 form_recomendantes onAfterUpdate: FIN
```

#### c) Recarga automática
**Esperado:**
- Tras 500ms, el formulario se recarga automáticamente
- Los campos del recomendante guardado deben estar bloqueados

**Esperado en logs:**
```
🔄 form_recomendantes onLoad: INICIO
🔄 form_recomendantes onLoad: need_reload = true
🔄 form_recomendantes onLoad: Activando recarga automática
🔄 form_recomendantes onLoad: Flag de sesión limpiado
🔄 form_recomendantes onLoad: JavaScript de recarga inyectado
🔄 form_recomendantes onLoad: FIN
```

**Luego (tras recarga):**
```
🔄 form_recomendantes onLoad: INICIO
🔄 form_recomendantes onLoad: need_reload = false
🔄 form_recomendantes onLoad: FIN
🔒 form_recomendantes onLoadRecord: id_recom=26 cc_edit=0
🔒 form_recomendantes onLoadRecord: Bloqueando campos para id_recom=26
```

#### d) Verificar en consola del navegador
1. Abrir DevTools (F12)
2. Ir a pestaña **Console**

**Esperado:**
```
🔄 onLoad: Iniciando recarga automática
🔄 onLoad: yaRecargo = false
🔄 onLoad: Marcando como recargado y recargando en 500ms
🔄 onLoad: Ejecutando window.location.reload()
```

---

## ❌ Troubleshooting

### Problema 1: No muestra confirmación

**Verificar:**
```bash
grep "🔔 form_recomendantes onValidate" /Applications/XAMPP/xamppfiles/logs/php_error_log | tail -5
```

**Si NO aparece:** El evento onValidate NO se está ejecutando
- Verificar que copiaste el código en el evento correcto
- Re-generar y re-desplegar

**Si SÍ aparece pero no se ve el diálogo:**
- Abrir consola del navegador (F12) → buscar errores JavaScript

---

### Problema 2: No recarga automáticamente

**Verificar logs:**
```bash
grep "🔄 form_recomendantes onLoad" /Applications/XAMPP/xamppfiles/logs/php_error_log | tail -10
```

**Si no dice "need_reload = true":**
- Verificar que `onAfterUpdate` marcó el flag:
  ```bash
  grep "Flag de recarga marcado" /Applications/XAMPP/xamppfiles/logs/php_error_log | tail -3
  ```

**Si el flag está pero no recarga:**
- Abrir consola del navegador (F12) → ver logs de "🔄 onLoad"

---

### Problema 3: Botón de borrar sigue visible

**Verificar logs:**
```bash
grep "Botón DELETE ocultado" /Applications/XAMPP/xamppfiles/logs/php_error_log | tail -3
```

**Si NO aparece:**
- El código de `onApplicationInit` no se copió correctamente
- Re-copiar, re-generar y re-desplegar

---

### Problema 4: Parse errors

**Ver errores:**
```bash
tail -50 /Applications/XAMPP/xamppfiles/logs/php_error_log | grep -i "parse\|fatal"
```

**Si hay errores:**
- Verificar que copiaste TODO el código (incluyendo `?>` y `<?php` si aplica)
- NO mezclar código de diferentes eventos

---

## 📝 Checklist Final

Antes de dar por terminado, verificar:

- [ ] Botón "Delete" (Borrar) NO es visible
- [ ] Al guardar, aparece diálogo de confirmación JavaScript
- [ ] Logs muestran "🔔 onValidate: INICIO"
- [ ] Logs muestran "💾 onAfterUpdate: Flag de recarga marcado"
- [ ] Formulario se recarga automáticamente tras guardar
- [ ] Logs muestran "🔄 onLoad: need_reload = true"
- [ ] Campos se bloquean tras guardar (cc_edit=0)
- [ ] Logs muestran "🔒 onLoadRecord: Bloqueando campos"
- [ ] Se envían 2 correos (admin + recomendante)
- [ ] Logs muestran "Correo enviado al admin" y "Correo enviado al recomendante"

---

## 🎯 Resumen de Archivos

| Archivo | Cambio | Prioridad |
|---------|--------|-----------|
| `onApplicationInit` | ✅ Ocultar botón delete | **ALTA** |
| `onValidate` | ✅ Confirmación JS pura | **ALTA** |
| `onLoad` | ✅ Recarga automática con logs | **ALTA** |
| `onAfterUpdate` | ✅ Marcar flag + logs | **ALTA** |
| `onLoadRecord` | ✅ Logs adicionales | Media |
| `OnBeforeUpdate` | Sin cambios | Media |

---

## 📞 Soporte

Si algo no funciona:

1. **Capturar logs:**
   ```bash
   tail -100 /Applications/XAMPP/xamppfiles/logs/php_error_log > logs_debug.txt
   ```

2. **Capturar consola del navegador:**
   - F12 → Console → Copiar todos los mensajes

3. **Capturar SQL de base de datos:**
   ```sql
   SELECT id_recom, nombre, correo, login_FK, cc_edit 
   FROM recomendantes 
   WHERE id_persacadposg_FK = 1 
   ORDER BY num_recom;
   ```

4. Compartir estos 3 elementos para debugging
