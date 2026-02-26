# 🗑️ Cómo Ocultar Botones de Borrar en Multiple Records

## 🎯 Problema

En formularios tipo "Multiple Records" (Editable Grid), Scriptcase muestra:
1. **Botón global "Delete"** en la toolbar (arriba)
2. **Iconos de borrar por fila** (🗑️) en cada registro

El macro `sc_btn_display("delete", "off")` solo oculta el botón global, NO los iconos por fila.

---

## ✅ Solución Implementada

### Método 1: CSS (en onApplicationInit)
- Inyecta estilos CSS para ocultar iconos
- Usa selectores múltiples para cubrir todas las variantes

### Método 2: JavaScript (en onLoadRecord)
- Busca dinámicamente los elementos
- Los oculta con JavaScript
- Se ejecuta múltiples veces para asegurar que funcione

---

## 📂 Archivos Actualizados

### 1. onApplicationInit
**Agregado:**
- CSS con múltiples selectores
- `display: none !important`
- Oculta imágenes, botones y links de delete

### 2. onLoadRecord
**Agregado:**
- JavaScript que busca y oculta elementos
- Se ejecuta en DOMContentLoaded
- Se repite tras 500ms y 1000ms

---

## 🔍 Verificar si Funciona

### En el navegador:
1. Abrir formulario de recomendantes
2. Presionar **F12** para abrir DevTools
3. Ir a pestaña **Console**

**Buscar:**
```
🗑️ Botones de borrar ocultados via JavaScript
```

### Con el Inspector:
1. Click derecho en un botón de borrar → **Inspeccionar**
2. Verificar que tiene estilos:
   ```css
   display: none !important;
   visibility: hidden !important;
   opacity: 0 !important;
   ```

---

## 🚨 Si NO Funciona

### Opción A: Configurar en Scriptcase UI

**No programático - Más confiable:**

1. Abrir `form_recomendantes` en Scriptcase
2. Ir a: **Form Settings** → **Toolbar**
3. En sección **Update:**
   - **Delete** → Mover a la sección de la derecha (disabled)
   - O simplemente NO seleccionarlo
4. Generar y desplegar

**Ventaja:** No necesita código, Scriptcase no genera los botones

---

### Opción B: Macro por fila (si disponible)

En `onLoadRecord`:

```php
// Intentar ocultar botón de esta fila específicamente
sc_btn_display("delete_" . sc_seq_register(), "off");
```

**Nota:** Puede no funcionar en todas las versiones de Scriptcase.

---

### Opción C: CSS más agresivo

En `onApplicationInit`, agregar:

```php
?>
<style>
/* Ocultar TODO lo que parezca un botón de delete */
*[class*="delete"],
*[class*="Delete"],
*[id*="delete"],
*[id*="Delete"],
*[name*="delete"],
*[name*="excluir"],
img[src*="delete"],
img[src*="Delete"],
img[src*="del"],
img[src*="trash"],
a[href*="delete"],
button[onclick*="delete"] {
    display: none !important;
    visibility: hidden !important;
}

/* Ocultar columna de acciones completa si es necesario */
td:has(img[src*="delete"]),
td:has(a[onclick*="delete"]) {
    display: none !important;
}
</style>
<?php
```

---

## 📝 Recomendación

**La mejor solución es configurar en Scriptcase UI:**

1. **Form Settings** → **Toolbar** → **Update** section
2. **NO seleccionar** el botón "Delete"
3. Generar y desplegar

Esto previene que Scriptcase genere los botones en primer lugar.

---

## 🔧 Aplicar los Cambios

### Copiar eventos actualizados:

1. **onApplicationInit** → Copiar de `/Eventos/onApplicationInit`
2. **onLoadRecord** → Copiar de `/Eventos/onLoadRecord`

### Generar y desplegar:
```
Generate Source Code (uno por uno) → Deploy
```

### Verificar en logs:
```bash
tail -f /Applications/XAMPP/xamppfiles/logs/php_error_log | grep "CSS para ocultar\|Botones de borrar"
```

**Esperado:**
```
📋 form_recomendantes onApplicationInit: CSS para ocultar iconos de borrar inyectado
```

### Verificar en navegador:
- Abrir DevTools (F12) → Console
- Buscar: `🗑️ Botones de borrar ocultados via JavaScript`

---

## 🎯 Alternativa: Deshabilitar en Configuración

Si todo lo demás falla, la forma más confiable:

```
Scriptcase → form_recomendantes → Settings → Toolbar → Update
```

**Desmarca/Mueve:**
- [ ] Delete

**Resultado:** Scriptcase no genera ningún botón de delete.

---

## ✅ Checklist

Después de aplicar:

- [ ] CSS inyectado (verificar en logs)
- [ ] JavaScript ejecutado (verificar en consola navegador)
- [ ] NO se ven botones de borrar en la interfaz
- [ ] Se puede editar normalmente
- [ ] Confirmación funciona
- [ ] Recarga automática funciona
- [ ] Campos se bloquean correctamente
