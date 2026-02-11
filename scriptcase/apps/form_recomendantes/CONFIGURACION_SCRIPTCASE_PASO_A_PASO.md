# Configuración de form_recomendantes en Scriptcase - Paso a Paso

Esta guía te indica **exactamente** qué configurar en Scriptcase para implementar el bloqueo de campos con `cc_edit`.

---

## 📋 Requisitos previos

1. ✅ Base de datos `sce_asp` con tabla `recomendantes` que incluye el campo `cc_edit` (TINYINT(1))
2. ✅ Método `crear_usuario_recomendante` creado en Scriptcase
3. ✅ Variable de sesión `[id_asp]` configurada en el login

---

## 🔧 Configuración en Scriptcase

### PASO 1: Abrir la aplicación

1. En Scriptcase, abre el proyecto
2. Localiza la aplicación **form_recomendantes** (tipo: **Editable Grid / Multiple Records**)
3. Haz doble clic para editarla

---

### PASO 2: Configurar campos (Fields)

#### 2.1 Verificar que todos los campos estén agregados

Ve a **Application** → **Fields** y asegúrate de tener estos campos:

| Campo | Tipo | Visible | Notas |
|-------|------|---------|-------|
| `id_recom` | int | Hidden | Clave primaria |
| `id_persacadposg_FK` | int | Hidden | FK opcional |
| `nombre` | varchar | Visible | Editable |
| `apellido_p` | varchar | Visible | Editable |
| `apellido_m` | varchar | Visible | Editable |
| `correo` | varchar | Visible | Editable |
| `num_recom` | int | Hidden o Visible | Número de recomendante (1, 2, 3) |
| `login_FK` | varchar | Hidden | Se llena automáticamente |
| **cc_edit** | tinyint | **Hidden** | ⚠️ **IMPORTANTE: debe estar HIDDEN** |

#### 2.2 Configurar el campo cc_edit como Hidden

1. Selecciona el campo `cc_edit`
2. Ve a **Field Settings** → **Display Settings**
3. En **Display**, selecciona: **Hidden**
4. Guarda

**¿Por qué Hidden?** El campo `cc_edit` es de control interno. No debe ser visible ni editable por el usuario, pero debe estar presente en el formulario para que los eventos puedan leerlo.

---

### PASO 3: Configurar SQL Settings (WHERE clause)

Para que el formulario muestre solo los recomendantes del aspirante logueado:

1. Ve a **Application** → **SQL** (o **SQL Settings**)
2. En la sección **WHERE**, agrega:

```sql
recomendantes.id_recom IN (
    SELECT ar.id_recom_FK 
    FROM asp_recomendantes ar 
    WHERE ar.id_asp_FK = [id_asp]
)
```

O si prefieres un JOIN:

```sql
SELECT r.* 
FROM recomendantes r
INNER JOIN asp_recomendantes ar ON ar.id_recom_FK = r.id_recom
WHERE ar.id_asp_FK = [id_asp]
ORDER BY r.num_recom
```

**Nota:** Asegúrate de que la variable global `[id_asp]` esté definida en tu login.

---

### PASO 4: Configurar Eventos (Events)

#### 4.1 onApplicationInit (Opcional pero recomendado)

**Ruta:** **Events** → **onApplicationInit**

```php
// Validar que el usuario haya iniciado sesión como aspirante
if (empty($_SESSION['id_asp']) || (string)$_SESSION['id_asp'] === '') {
    sc_error_message("Debe iniciar sesión como aspirante para acceder a Recomendantes.");
    sc_redir('menu_aspirante');
    exit;
}
[id_asp] = $_SESSION['id_asp'];
```

#### 4.2 onRecord ⭐ **NUEVO - IMPORTANTE**

**Ruta:** **Events** → **onRecord**

**Copiar y pegar este código:**

```php
// ====================================================================
// Evento: onRecord
// Ejecutar para cada fila del grid editable
// Deshabilitar campos si cc_edit = 0 (ya tiene usuario creado)
// ====================================================================

if ({cc_edit} == 0) {
    // Deshabilitar campos individuales
    {nombre}->setReadOnly(true);
    {apellido_p}->setReadOnly(true);
    {apellido_m}->setReadOnly(true);
    {correo}->setReadOnly(true);
    
    // Cambiar fondo a gris claro para indicar visualmente que no es editable
    {nombre}->setCss('background-color', '#e9ecef');
    {apellido_p}->setCss('background-color', '#e9ecef');
    {apellido_m}->setCss('background-color', '#e9ecef');
    {correo}->setCss('background-color', '#e9ecef');
    
    // Opcional: agregar tooltip/ayuda
    {nombre}->setHelp("Este recomendante ya tiene usuario creado. No es editable.");
    
    // Opcional: ocultar el botón Guardar para esta fila específica
    // sc_btn_save_display(false);
}
```

**Cómo agregarlo:**
1. En Scriptcase, ve a **Events**
2. Busca **onRecord** en la lista de eventos
3. Haz clic para abrirlo
4. Pega el código completo
5. Guarda (**Save**)

#### 4.3 OnBeforeUpdate (Validación de seguridad)

**Ruta:** **Events** → **OnBeforeUpdate**

**Copiar y pegar este código:**

```php
// ====================================================================
// Evento: OnBeforeUpdate
// Bloquear guardado si cc_edit = 0 (validación backend)
// ====================================================================

// Bloquear si este recomendante ya tiene usuario creado (cc_edit = 0 o 'N').
sc_lookup(rs, "SELECT cc_edit FROM recomendantes WHERE id_recom = " . sc_sql_injection({id_recom}));
$cc = isset({rs[0][0]}) ? trim({rs[0][0]}) : 1;
if ($cc == 0 || $cc === 'N') {
    sc_error_message("Este recomendante ya tiene usuario de acceso para subir cartas. No se puede editar.");
    exit;
}
```

#### 4.4 onAfterUpdate (Crear usuario y enviar correo)

**Ruta:** **Events** → **onAfterUpdate**

**Copiar y pegar este código:**

```php
// ====================================================================
// Evento: onAfterUpdate
// Crear usuario de acceso y enviar correo tras guardar
// ====================================================================

// Tras guardar: crear usuario de acceso para el recomendante (sec_asp_users, grupo 7) y enviar correo.
// Si el recomendante ya tiene login_FK, onBeforeUpdate impide editar; aquí solo se ejecuta si pasó.
crear_usuario_recomendante({id_recom}, {nombre}, {apellido_p}, {apellido_m}, {correo});
```

---

### PASO 5: Verificar el método crear_usuario_recomendante

1. Ve a **Programming** → **Methods**
2. Busca el método `crear_usuario_recomendante`
3. Verifica que tenga los parámetros: `($id_recom, $nombre, $apellido_p, $apellido_m, $correo)`
4. El código completo está en: `scriptcase/apps/form_recomendantes/metodos/crear_usuario_recomendante($id_recom, $nombre, $apellido_p, $apellido_m, $correo)`

**Si no existe el método:**
1. Crea uno nuevo: **Programming** → **Methods** → **New Method**
2. Nombre: `crear_usuario_recomendante`
3. Parámetros: `$id_recom, $nombre, $apellido_p, $apellido_m, $correo`
4. Copia el código del archivo mencionado

---

### PASO 6: Configurar botones (Buttons)

Ve a **Layout** → **Buttons** y verifica que estén habilitados:

- ✅ **Update** (o **Save**) - Para guardar cambios por fila
- ✅ **Delete** (opcional) - Solo si quieres permitir eliminar
- ❌ **Insert** - Normalmente deshabilitado (los 3 recomendantes ya están creados desde add_asp_aspirantes)

---

### PASO 7: Configurar permisos de edición

Ve a **Security** → **Field Security** (o similar) y asegúrate de que los campos estén configurados como:

- `nombre`: Read/Write
- `apellido_p`: Read/Write
- `apellido_m`: Read/Write
- `correo`: Read/Write
- `cc_edit`: Hidden (no editable directamente)

---

### PASO 8: Probar en desarrollo

1. **Run** → **Generate Source Code**
2. **Deploy** la aplicación
3. Abre el formulario desde el menú de aspirante
4. Verifica:
   - ✅ Se cargan los 3 recomendantes del aspirante logueado
   - ✅ Si `cc_edit = 1`, los campos están **editables** con fondo blanco
   - ✅ Si `cc_edit = 0`, los campos están **deshabilitados** con fondo gris
   - ✅ Al guardar un registro con `cc_edit = 1`, se crea usuario y se envía correo
   - ✅ Tras guardar, ese registro pasa a `cc_edit = 0` y se bloquea

---

## 🔍 Qué buscar en la documentación oficial de Scriptcase

Si necesitas personalizar algo, busca en la documentación oficial (https://www.scriptcase.net/docs/):

### 1. **Métodos de campos (Field Methods)**
Buscar: `"setReadOnly"` o `"Field Methods"`

- `{campo}->setReadOnly(true)` - Deshabilitar campo
- `{campo}->setCss('property', 'value')` - Cambiar CSS
- `{campo}->setHelp("texto")` - Agregar tooltip
- `{campo}->setDisplay('off')` - Ocultar campo

**URL:** https://www.scriptcase.net/docs/en_us/v9/manual/05-programming/01-macros/

### 2. **Eventos de Grid (Grid Events)**
Buscar: `"onRecord"` o `"Grid Events"`

- `onApplicationInit` - Al cargar la app
- `onRecord` - Para cada fila del grid
- `onBeforeUpdate` - Antes de actualizar
- `onAfterUpdate` - Después de actualizar

**URL:** https://www.scriptcase.net/docs/en_us/v9/manual/07-grid/02-events/

### 3. **Botones (Button Macros)**
Buscar: `"sc_btn_save_display"` o `"Button Macros"`

- `sc_btn_save_display(false)` - Ocultar botón Guardar (por fila)
- `sc_btn_update_display(false)` - Ocultar botón Update (form simple)
- `sc_btn_delete_display(false)` - Ocultar botón Eliminar

**URL:** https://www.scriptcase.net/docs/en_us/v9/manual/05-programming/01-macros/03-display/

### 4. **Consultas SQL (sc_lookup)**
Buscar: `"sc_lookup"` o `"Database Macros"`

```php
sc_lookup(dataset, "SELECT campo FROM tabla WHERE id = valor");
```

**URL:** https://www.scriptcase.net/docs/en_us/v9/manual/05-programming/01-macros/16-database/

### 5. **Mensajes (Messages)**
Buscar: `"sc_error_message"` o `"Message Macros"`

- `sc_error_message("texto")` - Mensaje de error
- `sc_message("texto", "tipo")` - Mensaje info/warning/success

**URL:** https://www.scriptcase.net/docs/en_us/v9/manual/05-programming/01-macros/06-messages/

### 6. **Seguridad SQL (SQL Injection)**
Buscar: `"sc_sql_injection"` o `"Security Macros"`

```php
sc_sql_injection($variable)
```

**URL:** https://www.scriptcase.net/docs/en_us/v9/manual/05-programming/01-macros/17-security/

---

## 📝 Checklist final antes de desplegar

- [ ] Campo `cc_edit` agregado a la BD (TINYINT(1), default 1)
- [ ] Campo `cc_edit` agregado al formulario Scriptcase como **Hidden**
- [ ] Evento `onRecord` configurado con código de deshabilitación
- [ ] Evento `OnBeforeUpdate` configurado con validación
- [ ] Evento `onAfterUpdate` configurado con llamada a método
- [ ] Método `crear_usuario_recomendante` creado y probado
- [ ] WHERE clause configurado para filtrar por `[id_asp]`
- [ ] Variable `[id_asp]` definida en el login y disponible
- [ ] Aplicación desplegada y probada en desarrollo
- [ ] Correos de prueba enviados y recibidos correctamente

---

## 🆘 Problemas comunes y soluciones

### Problema: Los campos no se deshabilitan
**Causa:** El campo `cc_edit` no está en el formulario o está mal configurado.
**Solución:** Agrégalo como Hidden en **Application** → **Fields**.

### Problema: Error "unexpected identifier"
**Causa:** Nombres de campos con espacios (`Id Recom` → `$this->id recom`).
**Solución:** Renombrar campos sin espacios: `Id_Recom` o `id_recom`.

### Problema: No se envían correos
**Causa:** Configuración SMTP incorrecta o puerto bloqueado.
**Solución:** Verificar credenciales SMTP en el método `crear_usuario_recomendante`. Para Gmail, usar contraseña de aplicación (App Password).

### Problema: `[id_asp]` está vacío
**Causa:** La variable no se define en el login.
**Solución:** En el login (app_login), en `sc_validate_success`, agregar:
```php
[id_asp] = {campo_id_asp};
$_SESSION['id_asp'] = {campo_id_asp};
```

---

## 🎯 Resultado esperado

Al final de la configuración, el formulario debe:

1. ✅ Mostrar solo los 3 recomendantes del aspirante logueado
2. ✅ Permitir editar solo los recomendantes con `cc_edit = 1`
3. ✅ Mostrar campos deshabilitados (gris) para recomendantes con `cc_edit = 0`
4. ✅ Al guardar, crear usuario en `sec_asp_users` y grupo 7
5. ✅ Enviar correo con datos de acceso
6. ✅ Actualizar `cc_edit = 0` para bloquear futuras ediciones
7. ✅ Impedir guardado en backend si alguien intenta modificar HTML

---

## 📚 Recursos adicionales

- **Documentación oficial:** https://www.scriptcase.net/docs/
- **Foro de Scriptcase:** https://www.scriptcase.net/forum/
- **Videos tutoriales:** https://www.youtube.com/c/Scriptcase

---

**Última actualización:** Febrero 2026
