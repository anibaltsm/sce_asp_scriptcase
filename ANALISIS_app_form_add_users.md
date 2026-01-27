# Análisis de aplicaciones SCE-ASP (ScriptCase)

**Incluye:** `app_form_add_users` (registro de aspirantes), `App_login` (autenticación y menús), y referencias cruzadas con `crea_referencia`.

---

## 📋 Resumen Ejecutivo

**app_form_add_users** gestiona el **registro de nuevos usuarios** que desean ingresar como aspirantes al posgrado. El flujo incluye:

1. Creación de usuario en `sec_asp_users`
2. Asignación a grupo por defecto
3. Creación de registro en `aspirantes`
4. Generación de requisitos iniciales
5. Creación de referencia de pago
6. Envío de correos (usuario y administradores)
7. Generación de código de activación

**App_login** es la app de **autenticación**: valida en `sec_asp_users`, aplica permisos por grupo, obtiene la generación activa y redirige al menú según el rol (administrador, aspirante, entrevistador, etc.). Configura y resetea `app_form_add_users` y `app_retrieve_pswd`. Tras el registro, podría redirigirse al login (`sc_redir('app_Login')`), pero esa línea está comentada.

---

## 🗂️ Estructura de Archivos

```
app_form_add_users/
├── Eventos/
│   └── onAfterInsert          # Evento que se ejecuta después de insertar usuario
└── metodos/
    ├── add_user_to_group($login)           # Asigna usuario a grupo por defecto
    ├── add_asp_aspirantes                  # Crea registro de aspirante y requisitos
    ├── send_mail_to_new_user               # Envía email con código de activación
    ├── send_mail_to_admin                  # Notifica a administradores
    ├── envia_email($para, $asunto, $msj, $copias)  # Función genérica de envío
    ├── num_rand_psw                        # Genera contraseña aleatoria (4 caracteres)
    └── act_code.txt                        # Texto/plantilla (no código ejecutable)
```

---

## 🔄 Flujo de Ejecución

### Evento: `onAfterInsert`

Se ejecuta **después de insertar un nuevo usuario** en `sec_asp_users`. Orden de ejecución:

```php
1. add_user_to_group({login})           // Asigna a grupo
2. add_asp_aspirantes({login}, ...)     // Crea aspirante y requisitos
3. send_mail_to_new_user()              // Envía email de activación
4. sc_commit_trans()                    // Confirma transacción
// 5. sc_redir('app_Login')             // (Comentado) Redirección a App_login tras registro
```

---

## 📝 Métodos Detallados

### 1. `add_user_to_group($login)`

**Propósito:** Asigna el nuevo usuario al grupo por defecto (ID = 2).

**Código:**
```php
$group_default = 2;

$sql = "INSERT INTO
            sec_asp_users_groups( login, group_id )
        VALUES 
            (". sc_sql_injection($login). ", ".
                sc_sql_injection($group_default) . ")";

sc_exec_sql($sql);
```

**Tabla afectada:** `sec_asp_users_groups`

**Nota:** El grupo 2 es el grupo por defecto para nuevos usuarios.

---

### 2. `add_asp_aspirantes`

**Propósito:** Crea el registro del aspirante, genera requisitos y referencia de pago.

**Parámetros recibidos (variables ScriptCase):**
- `$login` - Login del usuario
- `$name` - Nombre
- `$apat` - Apellido paterno
- `$amat` - Apellido materno
- `$email` - Email

**Proceso en 4 pasos:**

#### PASO 1: Obtener Generación Activa

```php
$get_gen_activa = 'SELECT generacion 
                   FROM sce.convocatorias_posg 
                   WHERE cc_activa=1 
                   AND (id_prog_FK<>9 OR ISNULL(id_prog_FK))
                   LIMIT 1';
```

- Consulta la convocatoria activa en BD `sce`
- Excluye programa con ID 9
- Si no hay convocatoria activa, muestra error y termina

#### PASO 2: Insertar Aspirante

```php
INSERT INTO aspirantes(
    nombres, ap_pat, ap_mat, email, login_FK, 
    generacion, login_insert, fecha_alta, ip_alta
) VALUES (...)
```

**Campos insertados:**
- Datos personales básicos
- `login_FK` → vincula con `sec_asp_users`
- `generacion` → obtenida de convocatoria activa
- Auditoría: `login_insert`, `fecha_alta`, `ip_alta`

**Obtiene `id_asp` generado:**
```php
sc_lookup(rs14, "SELECT @@identity AS id");
$id_asp = {rs14[0][0]};
```

#### PASO 3: Insertar Requisitos

```php
SELECT list_req_gral.id_lisreq, list_req_gral.num_requisito, cc_mostrar_usu 
FROM sce.list_req_gral
INNER JOIN sce.convocatorias_posg ON ...
WHERE sce.convocatorias_posg.cc_activa=1 
AND (sce.convocatorias_posg.id_prog_FK<>9 OR ISNULL(...))
ORDER BY list_req_gral.num_requisito ASC
```

**Proceso:**
- Obtiene lista de requisitos de la convocatoria activa
- Para cada requisito, inserta en `asp_requisitos`:
  - `id_asp_FK` → ID del aspirante
  - `id_lisreq_FK` → ID del requisito
  - `num_req` → Número de requisito
  - `usu_carga_req` → Si se muestra al usuario
  - Auditoría: `login_insert`, `fecha_alta`, `ip_alta`

#### PASO 4: Crear Referencia de Pago

**Validación:**
- Verifica si ya existe pago en `sce.pagos` para el aspirante (group_id_FK=5)
- Si existe, muestra mensaje y termina

**Generación de referencia:**
```php
// Limpia ceros del id_asp
$id_asp_limpio = ltrim($id_asp, "0");

// Formato: INECOLPA0002 + id_asp (con ceros) + "00"
// Ejemplo: id_asp=1222 → "INECOLPA0002122200"
if ($dato <= 3) {
    // Añade ceros según longitud
    $referencia = "INECOLPA0002" . $ceros . $datosinceros . "00";
} else {
    $referencia = "INECOLPA0002" . $datosinceros . "00";
}
```

**Insert en `sce.pagos` (producción):**
```php
INSERT INTO sce.pagos (
    group_id_FK,        // '5'
    id_asp_FK,          // id_asp sin ceros
    nombre_interesado,  // Nombre completo
    concepto,           // "Derecho al proceso de seleccion {generacion}"
    monto,              // '600'
    referencia,        // Generada arriba
    login_insert,      // Login del usuario
    fecha_alta,        // NOW()
    ip_alta            // IP del cliente
)
```

**Conexión:** Usa `conn_sce` (conexión a BD producción `sce`)

**Función auxiliar `get_client_ip()`:**
- Detecta IP real del cliente considerando proxies/load balancers
- Revisa: `HTTP_CLIENT_IP`, `HTTP_X_FORWARDED_FOR`, `REMOTE_ADDR`, etc.

**Mensaje final:**
```php
sc_alert("Usuario creado exitosamente.\n\nReferencia de pago: " . $referencia . 
         "\nGeneracion: " . $generacion_activa . "\nId: " . $datosinceros);
```

---

### 3. `send_mail_to_new_user`

**Propósito:** Envía email al nuevo usuario con código de activación y credenciales.

**Proceso:**

1. **Genera código de activación:**
   ```php
   $act_code = act_code();  // Función que genera código aleatorio
   ```

2. **Actualiza `sec_asp_users`:**
   ```php
   UPDATE sec_asp_users
   SET activation_code = {código generado}
   WHERE login = {login}
   ```

3. **Construye URL de activación:**
   ```php
   $url_mess = "http://posgrados.inecol.mx/sce_asp/app_form_add_users/index.php?a=" . $act_code;
   ```

4. **Mensaje HTML:**
   - Saludo personalizado
   - Instrucciones de activación
   - Enlace de activación
   - **Credenciales:**
     - Usuario: `{email}`
     - Contraseña: `{pswd}` (generada por ScriptCase)

5. **Envío vía Gmail SMTP:**
   ```php
   $mail_smtp_server    = 'smtp.gmail.com';
   $mail_smtp_user      = 'sce.posgrado@gmail.com';
   $mail_smtp_pass      = 'fqczuzvfomytleda';  // ⚠️ App password Gmail
   $mail_from           = 'sce.posgrado@gmail.com';
   $mail_to             = {email};
   $mail_copies         = 'monica.enriquez@inecol.mx';  // CC
   $mail_format         = 'H';  // HTML
   $mail_port           = '465';  // SSL
   $mail_tp_connection  = 'S';  // Seguro
   ```

6. **Manejo de errores:**
   ```php
   try {
       sc_mail_send(...);
       sc_commit_trans();
       if({sc_mail_ok}) {
           sc_log_add("Send active code", {lang_sended_active_code});
       } else {
           sc_log_add("Email warning", "Email could not be sent");
       }
   } catch (Exception $e) {
       error_log("Error email: " . $e->getMessage());
       sc_log_add("Email failed", "Error: " . $e->getMessage());
   }
   ```

7. **Mensaje al usuario:**
   ```php
   sc_alert("Usuario creado exitosamente. Revisa tu correo para activar tu cuenta.");
   ```

---

### 4. `send_mail_to_admin`

**Propósito:** Notifica a los administradores del sistema sobre el nuevo registro.

**Proceso:**

1. **Obtiene emails de administradores:**
   ```php
   SELECT email
   FROM sec_asp_users
   WHERE priv_admin = 'Y'
   ```

2. **Construye lista de destinatarios:**
   ```php
   $emails_admin = array();
   foreach({rs} as $value)
       $emails_admin[] = $value[0];
   $emails_admin = implode('; ', $emails_admin);
   ```

3. **Mensaje:**
   ```php
   $mail_message = sprintf({lang_new_user_sign_in}, {name}, {email}, {email});
   $mail_subject = {lang_subject_mail_new_user};
   ```

4. **Envío vía localhost (SMTP local):**
   ```php
   $mail_smtp_server = 'localhost';
   $mail_smtp_user = 'admin';
   $mail_smtp_pass = 'admin';
   $mail_from = 'monica.enriquez@inecol.mx';
   $mail_to = $emails_admin;
   $mail_format = 'H';  // HTML
   ```

5. **Log:**
   ```php
   sc_log_add("New user", {lang_send_mail_admin});
   ```

**Nota:** Este método usa SMTP local, no Gmail. Puede requerir configuración de servidor de correo local.

---

### 5. `envia_email($para, $asunto, $msj, $copias)`

**Propósito:** Función genérica para envío de emails vía Gmail.

**Parámetros:**
- `$para` - Destinatario
- `$asunto` - Asunto
- `$msj` - Mensaje (HTML)
- `$copias` - Emails en copia (separados por `;`)

**Configuración:**
```php
$mail_smtp_server    = 'smtp.gmail.com';
$mail_smtp_user      = 'sce.posgrado@gmail.com';
$mail_smtp_pass      = 'fqczuzvfomytleda';
$mail_from           = 'sce.posgrado@gmail.com';
$mail_to             = $para;
$mail_subject        = $asunto;
$mail_message        = $msj;
$mail_copies         = $copias;
$mail_format         = 'H';  // HTML
$mail_tp_copies      = 'CCC';  // Con copia
$mail_port           = '465';  // SSL
$mail_tp_connection  = 'S';  // Seguro
```

**Retorno:**
- `true` si `{sc_mail_ok}` es verdadero
- `false` si hay error (muestra `{sc_mail_err}`)

**Nota:** Esta función no se usa actualmente en el flujo principal; `send_mail_to_new_user` hace el envío directamente.

---

### 6. `num_rand_psw`

**Propósito:** Genera contraseña aleatoria de 4 caracteres.

**Caracteres permitidos:**
- Minúsculas: `a-z`
- Mayúsculas: `A-Z`
- Números: `0-9`
- Especiales: `!_`

**Código:**
```php
$chars = 'abcdefghijklmnopqrstuvxywz';
$chars .= 'ABCDEFGHIJKLMNOPQRSTUVXYWZ';
$chars .= '0123456789!_';
$max = strlen($chars)-1;
$num_rand='';
for($i=0; $i < 4; $i++)
{
    $num_rand .= $chars[mt_rand(0, $max)];
}
return $num_rand;
```

**Nota:** Esta función genera solo 4 caracteres. **No se usa en el flujo actual**; ScriptCase genera la contraseña automáticamente y la pasa como `{pswd}`.

---

### 7. `act_code.txt`

**Contenido:** Archivo de texto (no código ejecutable). Probablemente contiene una plantilla o referencia.

**Nota:** La función `act_code()` que se llama en `send_mail_to_new_user` no está definida en estos archivos. Probablemente es:
- Una función global de ScriptCase
- Una función definida en otro módulo/aplicación
- Genera código de activación de 32 caracteres (formato: `"new_" + 28 caracteres aleatorios`)

**Formato probable del código:**
```
new_ + [28 caracteres aleatorios]
Caracteres: a-z, A-Z, 0-9, !@$*.,;:
```

---

## 🗄️ Tablas de Base de Datos Utilizadas

### `sce_asp` (Base de datos principal)

| Tabla | Operación | Descripción |
|-------|-----------|-------------|
| `sec_asp_users` | UPDATE | Actualiza `activation_code` |
| `sec_asp_users_groups` | INSERT | Asigna usuario a grupo |
| `aspirantes` | INSERT | Crea registro de aspirante |
| `asp_requisitos` | INSERT | Crea requisitos del aspirante |

### `sce` (Base de datos externa - producción)

| Tabla | Operación | Descripción |
|-------|-----------|-------------|
| `convocatorias_posg` | SELECT | Obtiene generación activa |
| `list_req_gral` | SELECT | Lista de requisitos de convocatoria |
| `pagos` | SELECT, INSERT | Verifica/crea referencia de pago |

---

## 🔐 Credenciales y Configuración

### Gmail SMTP (Producción)

```
Servidor: smtp.gmail.com
Puerto: 465 (SSL)
Usuario: sce.posgrado@gmail.com
Contraseña: fqczuzvfomytleda (App Password)
From: sce.posgrado@gmail.com
CC por defecto: monica.enriquez@inecol.mx
```

### SMTP Local (Admin)

```
Servidor: localhost
Usuario: admin
Contraseña: admin
From: monica.enriquez@inecol.mx
```

### URLs

- **Activación:** `http://posgrados.inecol.mx/sce_asp/app_form_add_users/index.php?a={codigo}`

---

## ⚠️ Consideraciones de Seguridad

1. **Contraseñas en código:**
   - La contraseña de Gmail está hardcodeada en múltiples archivos
   - **Recomendación:** Mover a variables de entorno o configuración segura

2. **SQL Injection:**
   - Se usa `sc_sql_injection()` para sanitizar inputs
   - ✅ Correcto

3. **Código de activación:**
   - Se genera aleatoriamente
   - Se almacena en BD
   - Se envía por email (canal no completamente seguro)

4. **IP del cliente:**
   - Se captura considerando proxies
   - Se almacena para auditoría

---

## 🔄 Dependencias Externas

1. **Base de datos `sce`:**
   - Debe tener convocatoria activa (`cc_activa=1`)
   - Debe tener `list_req_gral` con requisitos asociados

2. **Servidor SMTP:**
   - Gmail SMTP debe estar accesible
   - Credenciales válidas

3. **Conexión `conn_sce`:**
   - Debe estar configurada en ScriptCase
   - Debe apuntar a BD `sce` (producción)

---

## 📊 Flujo de Datos Completo

```
┌─────────────────────────────────────────────────────────────┐
│ 1. Usuario completa formulario de registro                 │
└──────────────────┬──────────────────────────────────────────┘
                   │
                   ▼
┌─────────────────────────────────────────────────────────────┐
│ 2. ScriptCase inserta en sec_asp_users                      │
└──────────────────┬──────────────────────────────────────────┘
                   │
                   ▼
┌─────────────────────────────────────────────────────────────┐
│ 3. onAfterInsert se ejecuta                                 │
│    ├─ add_user_to_group()                                   │
│    ├─ add_asp_aspirantes()                                  │
│    │   ├─ Obtiene generación activa (sce)                    │
│    │   ├─ Inserta aspirante                                 │
│    │   ├─ Inserta requisitos                                │
│    │   └─ Crea referencia de pago (sce.pagos)                │
│    ├─ send_mail_to_new_user()                               │
│    │   ├─ Genera act_code                                   │
│    │   ├─ Actualiza sec_asp_users                           │
│    │   └─ Envía email con credenciales                      │
│    └─ sc_commit_trans()                                     │
└──────────────────┬──────────────────────────────────────────┘
                   │
                   ▼
┌─────────────────────────────────────────────────────────────┐
│ 4. Usuario recibe email y activa cuenta                     │
└─────────────────────────────────────────────────────────────┘
```

---

## 🔗 App relacionada: `crea_referencia`

### ¿Tiene relación con `app_form_add_users`?

**Sí, pero solo a nivel funcional:** ambas crean la **referencia de pago** en `sce.pagos` (mismo formato `INECOLPA0002...`, mismo concepto, monto 600). **No hay invocación en código:** ninguna app llama a `crea_referencia` desde PHP ni desde eventos.

### ¿Dónde se invoca `crea_referencia`?

**En el código del proyecto no se invoca.** No hay referencias a `crea_referencia` en ningún archivo (greps en `.php`, `.xml`, `.conf` y resto del repo no devuelven resultados).

Se asume que se abre **por navegación de usuario**:

- Enlace o botón en otra app (p. ej. grid de aspirantes o de pagos) que lleva a `crea_referencia` con parámetros.
- Entrada en menú de ScriptCase que apunta a esa app.

Sin el proyecto/definiciones de ScriptCase (menús, enlaces) no puede confirmarse el punto exacto de entrada.

### Qué hace `crea_referencia`

| Aspecto | Detalle |
|--------|---------|
| **Ubicación** | `scriptcase/apps/crea_referencia/` |
| **Evento** | `OnExecute` (al ejecutar la app) |
| **Parámetros** | `[id_asp]`, `[generacion]`, `[usr_login]` (formulario o URL) |

**Flujo:**

1. Comprueba si ya existe pago en `sce.pagos` para `Id=[id_asp]` y `group_id_FK="5"`.
2. **Si existe:** redirige a `grid_pagos`.
3. **Si no existe:**
   - Obtiene IP del cliente (`get_client_ip()`).
   - Genera referencia `INECOLPA0002` + `id_asp` (sin ceros) + `"00"` (misma lógica que `add_asp_aspirantes`).
   - Consulta nombre en `sce_asp.aspirantes` (`nombres`, `ap_pat`, `ap_mat`) por `id_asp`.
   - Inserta en `sce.pagos`: `group_id_FK='5'`, `Id`, `nombre_interesado`, concepto `"Derecho al proceso de selección [generacion]"`, `monto='600'`, `referencia`, `login_insert=[usr_login]`, `fecha_alta`, `ip_alta`.
   - Redirige a `grid_pagos`.

### Relación con `add_asp_aspirantes`

| | `app_form_add_users` → `add_asp_aspirantes` | `crea_referencia` |
|---|---------------------------------------------|-------------------|
| **Cuándo** | Al **registrar** nuevo usuario (alta de aspirante) | Para un **aspirante ya existente** |
| **Origen de datos** | Formulario de registro (nombre, apellidos, etc.) | Solo `id_asp` y `generacion` (y login de quien ejecuta) |
| **Tablas** | Crea aspirante + requisitos + pago | Solo crea pago; lee aspirante |
| **Conexión** | `conn_sce` en insert de pago | No se especifica; usa conexión por defecto |

**Resumen:** `crea_referencia` es una app **independiente** para **generar la referencia de pago manualmente** cuando el aspirante ya está en el sistema (p. ej. si falló el alta vía `app_form_add_users` o se dio de alta por otro medio). La lógica de referencia es la misma; la invocación es solo vía menú/enlace, no desde código.

---

## 🔐 App `App_login`

Aplicación de **login** del sistema. Valida credenciales en `sec_asp_users`, asigna permisos por grupos y redirige al menú según el rol.

### Estructura

```
App_login/
├── Eventos/
│   ├── onApplicationInit   # Resetea config de app_form_add_users y app_retrieve_pswd
│   ├── onScriptInit       # Resetea estado y globales de sesión
│   ├──  onLoad            # Marca app_form_add_users como inicio "new"
│   ├──  onValidate        # Valida usuario/contraseña
│   └── onValidateSuccess  # Llama sc_validate_success (permisos + redirección)
└── metodos/
    ├── sc_validate_success   # Permisos por app y redirección por grupo
    └── has_priv($param)      # Convierte Y/N en 'on'/'off'
```

### Eventos

| Evento | Acción |
|--------|--------|
| **onApplicationInit** | `sc_reset_apl_conf("app_form_add_users")`, `sc_reset_apl_conf("app_retrieve_pswd")` |
| **onScriptInit** | `sc_reset_apl_status()`, `sc_reset_global([usr_login], [usr_email], [generacion], [prog], [entrev])` |
| **onLoad** | `sc_apl_conf('app_form_add_users', 'start', 'new')` — formulario de registro como pantalla de inicio |
| **onValidate** | Consulta `sec_asp_users` (login/pswd), verifica `active='Y'`, obtiene `generacion` de `sce.convocatorias_posg`, asigna `[usr_login]`, `[usr_priv_admin]`, `[usr_name]`, `[usr_email]`. Si falla → `sc_log_add`, `sc_error_message`. Si no activo → `sc_error_not_active`, `sc_error_exit`. |
| **onValidateSuccess** | Ejecuta `sc_validate_success()`. |

### Método `sc_validate_success`

1. **Permisos:** Consulta `sec_asp_groups_apps` + `sec_asp_users_groups` por `[usr_login]`. Para cada app define `access`, `insert`, `delete`, `update`, `export`, `print` y los aplica con `sc_apl_status` / `sc_apl_conf`.
2. **Generación:** Obtiene `generacion` de `sce.convocatorias_posg` (cc_activa=1, id_prog≠9).
3. **Grupo:** Obtiene `group_id` de `sec_asp_users_groups` para el usuario.
4. **Redirección según `group_id`:**

| group_id | Rol | Menú |
|----------|-----|------|
| 1 | Administrador | `menu` |
| 2 | Aspirante | `menu_aspirante` o `form_reactivar_registro` |
| 3 | Administrativo | `menu_admvo` |
| 4 | Entrevistador | `menu_eval_gral_2025` |
| 5 | Investigador | `menu_inv` |
| 6 | Subdirector posgrado | `menu_sp` |

**Aspirante (2):** Si tiene registro en la generación actual → `menu_aspirante` y `[id_asp]` en sesión. Si no, busca registro anterior → `form_reactivar_registro` y guarda `id_asp_anterior`, `generacion_anterior`, `aspirante_reactivar=SI`. Si no hay ningún registro → error y `exit`.

**Entrevistador (4):** Consulta `entrevistadores` por `login_FK` y `generacion`, asigna `[entrev]` → `menu_eval_gral_2025`.

**Investigador (5) / Subdirector (6):** Consulta `entrevistadores`, asigna `[entrev]`, `[prog]` → `menu_inv` o `menu_sp`.

Al final siempre `sc_redir($menu)`.

### Método `has_priv($param)`

`return ($param == 'Y' ? 'on' : 'off');` — utilidad para mapear flags de BD a config de ScriptCase.

### Tablas utilizadas

- `sec_asp_users`, `sec_asp_users_groups`, `sec_asp_groups_apps`
- `sce.convocatorias_posg`
- `aspirantes`, `entrevistadores`

---

## 🔗 Referencias entre aplicaciones

| Quién | Referencia | Dónde |
|-------|------------|--------|
| **App_login** | Usa/configura **app_form_add_users** | `onApplicationInit`: reset config; `onLoad`: `start` = `new` |
| **App_login** | Usa **app_retrieve_pswd** | `onApplicationInit`: reset config |
| **App_login** | Redirige a menús | `sc_validate_success`: `menu`, `menu_aspirante`, `menu_admvo`, `menu_eval_gral_2025`, `form_reactivar_registro`, `menu_inv`, `menu_sp` |
| **app_form_add_users** | Posible redirección a **App_login** | `onAfterInsert`: `//sc_redir('app_Login')` — **comentado** |
| **crea_referencia** | Redirige a **grid_pagos** | `OnExecute` tras crear referencia o si ya existe |
| **send_mail_to_new_user** | URL de activación | `app_form_add_users/index.php?a={codigo}` |

**Resumen:** `App_login` es el punto de entrada de sesión, configura y resetea `app_form_add_users` y `app_retrieve_pswd`, y dirige a los menús según el grupo. `app_form_add_users` podría enviar al login tras el registro pero esa redirección está desactivada.

---

## 🐛 Posibles Problemas

1. **No hay convocatoria activa:**
   - Error: "No hay convocatoria activa. Contacte al administrador."
   - Solución: Activar convocatoria en `sce.convocatorias_posg`

2. **Email no se envía:**
   - Verificar credenciales Gmail
   - Verificar conectividad SMTP
   - Revisar logs (`sc_log`)

3. **Pago duplicado:**
   - Si ya existe pago, muestra mensaje pero continúa
   - No crea nuevo pago

4. **Función `act_code()` no definida:**
   - Verificar que esté disponible globalmente
   - O definir en módulo común

---

## 📝 Notas Adicionales

- El código usa **sintaxis ScriptCase** con variables entre llaves: `{login}`, `{email}`, etc.
- Las funciones `sc_*` son funciones nativas de ScriptCase
- Los logs se escriben en `sc_log` (tabla de auditoría)
- La aplicación está diseñada para **producción** (usa BD `sce` directamente)
- El grupo por defecto es **2** (configurable en `add_user_to_group`)

---

*Documento generado mediante análisis del código fuente. Última actualización: enero 2026.*
