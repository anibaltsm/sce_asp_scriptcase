# ✅ Guía: Configurar Confirmación en el Botón Guardar

## 📋 Según la Documentación Oficial de Scriptcase

La forma **oficial y recomendada** para mostrar confirmación antes de guardar es usar la opción **"Confirmation Message"** del botón en la configuración del formulario.

**Fuente:** [Form Buttons Settings - Scriptcase](https://www.scriptcase.net/docs/en_us/v9/manual/06-applications/05-form-application/20-form-buttons)

---

## 🎯 Orden del Flujo

1. Usuario completa los campos (nombre, apellido p, apellido m, correo)
2. Usuario hace clic en **Guardar** (Update)
3. **Confirmación** (si está configurada): "¿Está seguro? No podrá modificar después"
4. Si acepta → El formulario se envía al servidor
5. **onValidate** valida que todos los campos estén llenos
6. Si hay error → Se cancela y se muestra mensaje
7. Si todo OK → Se guarda → onAfterUpdate crea usuario y envía correos

---

## ⚙️ Pasos para Configurar la Confirmación

### 1. Abrir el formulario en Scriptcase
```
Proyecto → form_recomendantes
```

### 2. Ir a la configuración del Toolbar
```
Form Settings (icono engrane) → Toolbar
```

### 3. Buscar la sección "Buttons Settings" o "Opciones de Botones"

En la parte inferior del panel de Toolbar suele haber:
- **Button:** Lista de botones (Insert, Update, Delete, Cancel, etc.)
- **Label:** Etiqueta del botón
- **Hint:** Texto al pasar el mouse
- **Confirmation Message:** Mensaje de confirmación al hacer clic

### 4. Seleccionar el botón "Update" (Guardar)

Haz clic en el botón **Update** de la lista para ver sus propiedades.

### 5. Configurar "Confirmation Message"

En el campo **Confirmation Message** pegar o escribir:

```
IMPORTANTE: Una vez guardado este recomendante, NO podrá modificar el correo ni otros datos.

Por favor, verifique que todos los datos sean correctos antes de continuar.

¿Está seguro de que desea guardar?
```

### 6. Guardar
```
Save
```

### 7. Generar y desplegar
```
Generate Source Code (uno por uno) → Deploy
```

---

## 📸 Dónde Buscar (Referencia Visual)

La configuración puede estar en:
- **Toolbar** → Click en el icono del botón Update → Ver propiedades
- O en un panel lateral al seleccionar el botón
- Buscar: "Confirmation Message", "Mensaje de confirmación", "Confirmación"

---

## ✅ Validación en onValidate (Ya implementada)

El evento **onValidate** ya valida que:
- ✅ Nombre no esté vacío
- ✅ Apellido Paterno no esté vacío
- ✅ Apellido Materno no esté vacío
- ✅ Correo no esté vacío

Si falta alguno, muestra mensaje y **cancela el guardado**.

---

## 🔄 Resumen de Cambios

| Componente | Función |
|------------|---------|
| **onValidate** | Valida que nombre, apellido_p, apellido_m, correo estén llenos |
| **Confirmation Message (botón)** | Pregunta "¿Está seguro?" antes de enviar |
| **OnBeforeUpdate** | Bloquea si cc_edit=0 (ya tiene usuario) |
| **onAfterUpdate** | Crea usuario y envía correos |
| **crear_usuario_recomendante** | Salida silenciosa si id_recom vacío (carga) |

---

## ❓ Si no encuentras "Confirmation Message"

En algunas versiones de Scriptcase puede estar en:
- **Application** → **Form** → **Buttons** → **Update** → Propiedades
- O: **Layout** → **Toolbar** → Configuración de botones

Si usas **SweetAlert** en Application Settings, la confirmación nativa puede verse diferente. La funcionalidad es la misma.

---

## 📚 Referencias Oficiales

- [onValidate - Form Events](https://www.scriptcase.net/docs/en_us/v9/manual/06-applications/05-form-application/18-form-events/08-onValidate)
- [Form Buttons Settings](https://www.scriptcase.net/docs/en_us/v9/manual/06-applications/05-form-application/20-form-buttons)
- [Form Toolbar](https://www.scriptcase.net/docs/en_us/v9/manual/06-applications/05-form-application/06-form-toolbar)
