# 🤖 Guía para IA - form_recomendantes

**Propósito:** Documentación autónoma para que una IA comprenda la aplicación al retomar trabajo en otro entorno.

**Proyecto:** sce_asp_scriptcase | Scriptcase v9 | PHP 8.1  
**Aplicación:** form_recomendantes (Form **Editable grid (view)** – no "Multiple records")  
**Última actualización:** Feb 2026

---

## 📋 RESUMEN EJECUTIVO

Formulario que permite al aspirante editar los datos de sus 3 recomendantes (nombre, apellido paterno, apellido materno, correo). Al guardar:
1. Se valida que todos los campos estén llenos
2. Se pide confirmación (no se podrá modificar después)
3. Se crea usuario en `sec_asp_users` con grupo 7
4. Se envían 2 correos (admin + recomendante)
5. El registro queda bloqueado (`cc_edit = 0`)

---

## 🗄️ BASE DE DATOS

### Tablas principales

| Tabla | Uso |
|-------|-----|
| `recomendantes` | Datos de los 3 recomendantes por aspirante |
| `asp_recomendantes` | Relación aspirante ↔ recomendantes |
| `sec_asp_users` | Usuarios del sistema (login = correo) |
| `sec_asp_users_groups` | Grupos de usuario (7 = recomendantes) |

### Campos clave

| Campo | Tabla | Tipo | Descripción |
|-------|-------|------|-------------|
| `id_recom` | recomendantes | PK | ID del recomendante |
| `cc_edit` | recomendantes | TINYINT(1) | 1=editable, 0=bloqueado (ya tiene usuario) |
| `login_FK` | recomendantes | FK → sec_asp_users.login | Usuario creado para el recomendante |
| `nombre`, `apellido_p`, `apellido_m`, `correo` | recomendantes | VARCHAR | Datos editables |

### Filtro por aspirante

- WHERE: recomendantes del aspirante logueado vía `asp_recomendantes` y `[id_asp]`
- `[id_asp]` viene de `$_SESSION['id_asp']` (login)

---

## 📂 ESTRUCTURA DE ARCHIVOS

```
scriptcase/apps/form_recomendantes/
├── Eventos/
│   ├── onApplicationInit    → Ocultar Delete, CSS, validar sesión
│   ├── onScriptInit         → Vacío
│   ├── onLoad                → Mensaje éxito
│   ├── onLoadRecord          → Bloquear campos si cc_edit=0
│   ├── onValidate            → Validar campos obligatorios
│   ├── onBeforeUpdateAll     → sc_confirm() (advertencia Cancelar/Guardar)
│   ├── OnBeforeUpdate        → No se ejecuta en Multiple Records
│   └── onAfterUpdate         → Llamar crear_usuario_recomendante
├── metodos/
│   └── crear_usuario_recomendante($id_recom, $nombre, $apellido_p, $apellido_m, $correo)
└── docs/
    ├── DIAGRAMA_FLUJO.md
    └── referencias/REFERENCIAS_SCRIPTCASE_V9.md
```

---

## 🔄 FLUJO DE EVENTOS

### Al cargar la página

```
onApplicationInit → onLoad → onLoadRecord (×N filas)
```

**Nota:** `onAfterUpdate` puede ejecutarse con datos vacíos al cargar. Por eso hay validación de `id_recom` y `correo` antes de ejecutar lógica.

### Al guardar (Click Update)

```
onValidate → onBeforeUpdateAll → [Guardar BD] → onAfterUpdate (por fila)
```

---

## 📌 CÓDIGO POR EVENTO

### onApplicationInit
- Aviso visible: "Una vez guardado no podrá modificarse"
- `sc_btn_display("delete", "off")` – Oculta botón Delete
- CSS + JS para ocultar iconos de borrar por fila
- Validación de sesión `[id_asp]`

### onValidate
- Valida: nombre, apellido_p, apellido_m, correo no vacíos
- Valida formato email con `filter_var($correo, FILTER_VALIDATE_EMAIL)`
- Valida correo no duplicado: no puede usarse en otro recomendante del mismo aspirante
- Bloquea si cc_edit=0 (ya tiene usuario)
- Si falta algo o email inválido/duplicado: `sc_error_message()` y return
- Si `id_recom` vacío: return (carga de página)

### onBeforeUpdateAll (Multiple Records)
- `sc_confirm("mensaje")` – Advertencia con Cancelar/Guardar. Se ejecuta UNA vez al guardar.
- **Nota:** En Multiple Records, OnBeforeUpdate NO se ejecuta; usar onBeforeUpdateAll.

### OnBeforeUpdate
- En Multiple Records NO se ejecuta. La validación cc_edit está en onValidate.

### onAfterUpdate
- Valida `id_recom` y `correo` no vacíos
- Llama `crear_usuario_recomendante()`
- Marca `$_SESSION['form_recomendantes_guardado_exitoso']`

### onLoadRecord
- Si `cc_edit = 0`: `sc_field_disabled_record("nombre_=true;apellido_p_=true;apellido_m_=true;correo_=true")`
- JavaScript para ocultar botones borrar por fila

### crear_usuario_recomendante
1. Si `id_recom` vacío → return (carga)
2. Si `correo` vacío → error y return
3. Si `cc_edit = 0` → return (ya tiene usuario)
4. Si login existe en `sec_asp_users` → Vincular solo, cc_edit=0, return (NO correos)
5. Si no existe → Crear usuario, INSERT grupo 7, UPDATE recomendantes, enviar 2 correos

---

## 🔧 MACROS SCRIPTCASE (v9)

| Macro | Uso |
|-------|-----|
| `sc_confirm("msg")` | Confirmación. NO usar `if (!sc_confirm())` |
| `sc_error_message("texto")` | Mensaje de error, cancela envío |
| `sc_lookup(rs, "SQL")` | SELECT y guardar en variable |
| `sc_exec_sql("SQL")` | INSERT/UPDATE/DELETE |
| `sc_sql_injection(val)` | Protección SQL injection |
| `sc_btn_display("botón", "on/off")` | Mostrar/ocultar botón |
| `sc_field_disabled_record("campo=true;...")` | Bloquear campos por fila |
| `sc_redir('app')` | Redirigir |
| `sc_mail_send(...)` | Enviar correo |

**Documentación:** https://www.scriptcase.net/docs/en_us/v9/manual/14-macros/02-macros/

---

## 📊 LOGS

### Ubicación
- **XAMPP:** `/Applications/XAMPP/xamppfiles/logs/php_error_log`
- **Linux:** `/var/log/apache2/error.log` o según configuración PHP

### Prefijos de log por evento

| Prefijo | Evento |
|---------|--------|
| `📋 form_recomendantes onApplicationInit` | onApplicationInit |
| `🔄 form_recomendantes onLoad` | onLoad |
| `🔔 form_recomendantes onValidate` | onValidate |
| `💾 form_recomendantes onAfterUpdate` | onAfterUpdate |
| `🔒 form_recomendantes onLoadRecord` | onLoadRecord |
| `crear_usuario_recomendante:` | Método crear_usuario_recomendante |
| `⚠️ form_recomendantes onBeforeUpdateAll` | onBeforeUpdateAll |

**Nota:** En Multiple Records, OnBeforeUpdate no se ejecuta; usar onBeforeUpdateAll para sc_confirm.

### Comandos útiles

```bash
# Ver logs del formulario
tail -f /Applications/XAMPP/xamppfiles/logs/php_error_log | grep "form_recomendantes"

# Últimos 50 logs del formulario
tail -200 /Applications/XAMPP/xamppfiles/logs/php_error_log | grep "form_recomendantes"

# Buscar errores
tail -100 /Applications/XAMPP/xamppfiles/logs/php_error_log | grep -i "parse\|fatal\|error"

# Logs del método crear_usuario
tail -100 /Applications/XAMPP/xamppfiles/logs/php_error_log | grep "crear_usuario_recomendante"
```

### Mensajes esperados por flujo

**Al cargar formulario:**
```
📋 form_recomendantes onApplicationInit: INICIO
📋 form_recomendantes onApplicationInit: Botón DELETE global ocultado
🔄 form_recomendantes onLoad: INICIO
🔒 form_recomendantes onLoadRecord: id_recom=26 cc_edit=1
```

**Al guardar correctamente:**
```
🔔 form_recomendantes onValidate: INICIO
🔔 form_recomendantes onValidate: FIN - Todos los campos válidos
💾 form_recomendantes onAfterUpdate: INICIO id_recom=26 correo=user@mail.com
crear_usuario_recomendante: INICIO id_recom=26 correo=user@mail.com
crear_usuario_recomendante: cc_edit=1 para id_recom=26
crear_usuario_recomendante: Correo enviado al admin (anibal.sanchez@inecol.mx)
crear_usuario_recomendante: Correo enviado al recomendante (user@mail.com)
💾 form_recomendantes onAfterUpdate: FIN
```

**Al cargar (onAfterUpdate con datos vacíos):**
```
💾 form_recomendantes onAfterUpdate: INICIO id_recom= correo=
crear_usuario_recomendante: INICIO id_recom= correo=
crear_usuario_recomendante: SKIP - id_recom vacío (carga de página, no guardado)
```

### Errores frecuentes y qué significan

| Log | Significado |
|-----|-------------|
| `crear_usuario_recomendante: ERROR correo vacío` | Correo vacío en guardado real o carga con datos vacíos |
| `crear_usuario_recomendante: SKIP - id_recom vacío` | Normal: carga de página, no es un guardado |
| `crear_usuario_recomendante: SALIDA ya tiene usuario` | cc_edit=0, no se vuelve a crear usuario |
| `Parse error: unexpected token` | Error de sintaxis, muchas veces por `if (!sc_confirm())` |

### Usuario y correo OK pero tabla recomendantes no se actualiza (login_FK vacío, cc_edit sigue 1)

- **Causa 1:** `sc_redir()` en onAfterUpdate puede provocar rollback. **Solución:** no usar sc_redir en onAfterUpdate.
- **Causa 2:** La transacción no hace commit y al terminar el request se hace rollback. **Solución:** en `crear_usuario_recomendante`, tras el UPDATE a `recomendantes` se llama **sc_commit_trans()** para forzar el commit (igual que en app_form_add_users).
- **Alternativa:** Si sigue fallando, en ScriptCase revisar que los campos **login_FK** y **cc_edit** no estén incluidos en el UPDATE del formulario (que sean solo lectura o que el form no los envíe al guardar), para que no sobrescriban nuestros valores. Y comprobar permisos UPDATE/INSERT en `sce_asp.recomendantes`.

---

## ⚠️ PROBLEMAS CONOCIDOS Y SOLUCIONES

### 1. Diálogo "Output" al guardar
- **Causa:** Output HTML/script en eventos (onLoad, onLoadRecord). Scriptcase captura output durante AJAX y lo muestra en ventana "Output".
- **Solución:** No inyectar `<script>` con console.log; mover JS a onApplicationInit (una sola vez); eliminar console.log.

### 2. sc_confirm / onBeforeUpdateAll no disponible
- **Causa:** Con orientación "Editable grid (view)", onBeforeUpdateAll solo existe en "Multiple records".
- **Solución:** Mostrar aviso estático en onApplicationInit: "Una vez guardado no podrá modificarse".

### 3. onAfterUpdate con datos vacíos al cargar
- **Causa:** En Multiple Records se ejecuta al cargar
- **Solución:** Validar `id_recom` y `correo` antes de ejecutar; en `crear_usuario_recomendante` salir silencioso si `id_recom` vacío

### 4. Botones de borrar siguen visibles
- **Solución 1:** Form Settings → Toolbar → Desmarcar "Delete"
- **Solución 2:** CSS + `sc_btn_display` en onApplicationInit

### 5. Parse error con sc_confirm
- **Causa:** `if (!sc_confirm())` genera código inválido
- **Solución:** Solo `sc_confirm("mensaje");` sin if

---

## ✅ CORREO REPETIDO – NO se valida duplicado

**No se valida correo duplicado** entre recomendantes. Si el correo ya existe en `sec_asp_users`:
- NO se crea otra cuenta
- Solo se asigna grupo 7 y se vincula (login_FK, cc_edit=0)
- NO se envían correos
- Código: líneas 45-54 de `crear_usuario_recomendante`
- **Vista del recomendante:** Para ver todos los casos (si lo agregaron varios aspirantes), filtrar por `r.login_FK = [login_usuario]` en vez de solo `id_recom_FK`

---

## 📚 DOCUMENTACIÓN OFICIAL SCRIPTCASE v9

- Form Events: https://www.scriptcase.net/docs/en_us/v9/manual/06-applications/05-form-application/18-form-events/
- onValidate: https://www.scriptcase.net/docs/en_us/v9/manual/06-applications/05-form-application/18-form-events/08-onValidate
- Form Buttons: https://www.scriptcase.net/docs/en_us/v9/manual/06-applications/05-form-application/20-form-buttons
- Macros: https://www.scriptcase.net/docs/en_us/v9/manual/14-macros/02-macros/

---

## 🚀 DEPLOY

1. **Crear evento onBeforeUpdateAll** en Scriptcase: Form Settings → Events → Agregar `onBeforeUpdateAll` (si no existe)
2. Copiar contenido de `Eventos/onBeforeUpdateAll`
3. Scriptcase → Generate Source Code (uno por uno)
4. Deploy
5. Ruta típica: `htdocs/sce_asp/form_recomendantes/`
6. Verificar logs en `/Applications/XAMPP/xamppfiles/logs/php_error_log`

---

## 📝 NOTAS PARA IA

- Usar **Scriptcase v9** y macros oficiales; no modificar PHP generado directamente
- `{campo}` se expande a valor; `sc_field_disabled_record` para bloquear por fila
- Orden eventos: onValidate → OnBeforeUpdate → guardado BD → onAfterUpdate
- `sc_confirm()` debe llamarse solo, sin condicionales
- En formularios Multiple Records, validar datos antes de ejecutar en onAfterUpdate
- Correo admin: `anibal.sanchez@inecol.mx` | Grupo recomendantes: `7`
- BD: `sce_asp` | Tablas: `recomendantes`, `sec_asp_users`, `sec_asp_users_groups`
- **form_asp_requisitos_1 sin botón Guardar (Recomendante):** Ver `data/PERMISOS_APLICACION_SEC_ASP.md` → sección "Solución probada". Ejecutar `sql_diagnostico_form_asp_requisitos_1.sql` (diagnóstico) y `sql_form_asp_requisitos_1_ver_boton_guardar.sql` (corrección para grupo 7). Cerrar sesión y volver a entrar.