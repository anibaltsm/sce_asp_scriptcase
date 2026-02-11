# Códigos de Eventos - Copiar y Pegar en Scriptcase

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

## ⭐ Evento: onLoadRecord (IMPORTANTE - Por fila)

**Ruta en Scriptcase:** `Events` → `onLoadRecord`

**⚠️ El código DEBE estar en onLoadRecord, NO en onLoad.**

- **onLoad** se ejecuta una vez → deshabilita TODAS las filas (error)
- **onLoadRecord** se ejecuta por cada fila → deshabilita solo la fila con cc_edit=0

**DEJAR onLoad VACÍO.** Solo usar onLoadRecord.

```php
// ====================================================================
// Evento: onLoadRecord - Se ejecuta POR CADA FILA
// Deshabilitar campos solo de la fila donde cc_edit = 0
// ====================================================================

if ({cc_edit} == 0) {
    sc_field_readonly("nombre_", 'on');
    sc_field_readonly("apellido_p_", 'on');
    sc_field_readonly("apellido_m_", 'on');
    sc_field_readonly("correo_", 'on');
}
```

**Nota:** No usar `sc_seq_register()` como tercer parámetro, da error de parse en la compilación.

## Evento: onLoad (debe estar VACÍO)

**Ruta en Scriptcase:** `Events` → `onLoad`

```php
// Vacío - el código está en onLoadRecord
```

---

## 🔒 Evento: OnBeforeUpdate (Validación Backend)

**Ruta en Scriptcase:** `Events` → `OnBeforeUpdate`

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

**Nota:** Esta es la capa de seguridad. Aunque el frontend desabilite los campos con `onRecord`, esta validación asegura que nadie pueda modificar el HTML y enviar datos.

---

## 📧 Evento: onAfterUpdate (Crear usuario + Recargar)

**Ruta en Scriptcase:** `Events` → `onAfterUpdate`

```php
crear_usuario_recomendante({id_recom}, {nombre}, {apellido_p}, {apellido_m}, {correo});

// Recargar para que se vea el bloqueo (cc_edit=0) de inmediato
sc_redir('form_recomendantes');
```

**Si el form está dentro de menu_aspirante**, usar: `sc_redir('menu_aspirante');`

**Nota:** Si sc_redir impide el guardado, quitarlo y revisar en Buttons si hay "Redirect after Update".

---

## 🔧 Método: crear_usuario_recomendante

**Ruta en Scriptcase:** `Programming` → `Methods` → `New Method`

**Nombre del método:** `crear_usuario_recomendante`

**Parámetros:** `$id_recom, $nombre, $apellido_p, $apellido_m, $correo`

**Código completo:**

```php
// Crear usuario en sec_asp_users para el recomendante, asignar grupo 7 y enviar correo con datos de acceso.
// Llamar desde onAfterUpdate: crear_usuario_recomendante({id_recom}, {nombre}, {apellido_p}, {apellido_m}, {correo});
// Destino del correo (por ahora): anibal.sanchez@inecol.mx
// Campo de control: cc_edit = 0/'N' tras crear usuario (bloquea nueva edición).

$nombre     = trim($nombre);
$apellido_p = trim($apellido_p);
$apellido_m = trim($apellido_m);
$correo     = trim($correo);

if ($correo === '') {
    sc_error_message("El correo del recomendante es obligatorio para crear el usuario de acceso.");
    return;
}

// No crear si ya se marcó como no editable (cc_edit = 0 o 'N')
sc_lookup(rs_cc, "SELECT cc_edit FROM recomendantes WHERE id_recom = " . sc_sql_injection($id_recom));
$cc_edit = isset({rs_cc[0][0]}) ? trim({rs_cc[0][0]}) : 1;
if ($cc_edit == 0 || $cc_edit === 'N') {
    return; // Ya tiene usuario creado, no volver a crear
}

$login = $correo;

// ¿Ya existe el login en sec_asp_users? (p. ej. mismo correo usado en otro recomendante)
sc_lookup(rs_usr, "SELECT login FROM sec_asp_users WHERE login = " . sc_sql_injection($login));
if (isset({rs_usr[0][0]})) {
    // Solo asignar a grupo 7, vincular recomendante y bloquear edición
    $sql_grp = "INSERT IGNORE INTO sec_asp_users_groups (login, group_id) VALUES (" . sc_sql_injection($login) . ", 7)";
    sc_exec_sql($sql_grp);
    $upd = "UPDATE recomendantes SET login_FK = " . sc_sql_injection($login) . ", cc_edit = 0 WHERE id_recom = " . sc_sql_injection($id_recom);
    sc_exec_sql($upd);
    return;
}

// Generar contraseña aleatoria (8 caracteres)
$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
$pswd = '';
for ($i = 0; $i < 8; $i++) {
    $pswd .= $chars[mt_rand(0, strlen($chars) - 1)];
}

// INSERT sec_asp_users (campos mínimos como en el sistema)
$ins_user = "INSERT INTO sec_asp_users (login, pswd, name, apat, amat, email, active, priv_admin, fecha_alta) VALUES ("
    . sc_sql_injection($login) . ", "
    . sc_sql_injection($pswd) . ", "
    . sc_sql_injection($nombre) . ", "
    . sc_sql_injection($apellido_p) . ", "
    . sc_sql_injection($apellido_m) . ", "
    . sc_sql_injection($correo) . ", "
    . "'Y', 'N', NOW())";
sc_exec_sql($ins_user);

// INSERT sec_asp_users_groups → group_id = 7 (recomendantes que suben cartas)
$ins_grp = "INSERT INTO sec_asp_users_groups (login, group_id) VALUES (" . sc_sql_injection($login) . ", 7)";
sc_exec_sql($ins_grp);

// Vincular recomendante con el usuario y marcar como no editable (cc_edit = 0)
$upd_recom = "UPDATE recomendantes SET login_FK = " . sc_sql_injection($login) . ", cc_edit = 0 WHERE id_recom = " . sc_sql_injection($id_recom);
sc_exec_sql($upd_recom);

// Enviar correo con datos de acceso (por ahora a anibal.sanchez@inecol.mx)
$mail_to = 'anibal.sanchez@inecol.mx';
$mail_message = 'Se ha creado usuario de acceso para recomendante (cartas):<br><br>'
    . '<strong>Recomendante:</strong> ' . htmlspecialchars($nombre . ' ' . $apellido_p . ' ' . $apellido_m) . '<br>'
    . '<strong>Correo:</strong> ' . htmlspecialchars($correo) . '<br><br>'
    . '<strong>Datos de acceso para el recomendante:</strong><br>'
    . 'Usuario: <strong>' . htmlspecialchars($login) . '</strong><br>'
    . 'Contraseña: <strong>' . htmlspecialchars($pswd) . '</strong><br><br>'
    . 'Con estos datos el recomendante puede iniciar sesión y subir sus cartas.';

$asunto = 'INECOL. Usuario de acceso creado para recomendante (cartas)';

try {
    $mail_smtp_server    = 'smtp.gmail.com';
    $mail_smtp_user      = 'sce.posgrado@gmail.com';
    $mail_smtp_pass      = 'fqczuzvfomytleda';
    $mail_from           = 'sce.posgrado@gmail.com';
    $mail_copies         = '';
    $mail_format         = 'H';
    $mail_tp_copies      = 'CCC';
    $mail_port           = '465';
    $mail_tp_connection  = 'S';

    @sc_mail_send($mail_smtp_server, $mail_smtp_user, $mail_smtp_pass, $mail_from,
        $mail_to, $asunto, $mail_message, $mail_format, $mail_copies, $mail_tp_copies,
        $mail_port, $mail_tp_connection);
} catch (Exception $e) {
    error_log("form_recomendantes: Error enviando correo usuario recomendante: " . $e->getMessage());
}
```

**Personalización:**
- Cambia `$mail_to` a tu correo o al correo del administrador
- Ajusta el contenido de `$mail_message` según necesites
- Modifica las credenciales SMTP si usas otro servidor (líneas 61-68)

---

## 📊 Configuración SQL (WHERE Clause)

**Ruta en Scriptcase:** `Application` → `SQL Settings` → `WHERE`

**Opción 1 - Subconsulta:**
```sql
recomendantes.id_recom IN (
    SELECT ar.id_recom_FK 
    FROM asp_recomendantes ar 
    WHERE ar.id_asp_FK = [id_asp]
)
```

**Opción 2 - JOIN (recomendado):**
```sql
SELECT r.* 
FROM recomendantes r
INNER JOIN asp_recomendantes ar ON ar.id_recom_FK = r.id_recom
WHERE ar.id_asp_FK = [id_asp]
ORDER BY r.num_recom
```

**Nota:** Asegúrate de que la variable `[id_asp]` esté definida en tu login.

---

## 🎨 Configuración de Campos

**Campo cc_edit:**
- **Type:** Integer (tinyint)
- **Display:** Hidden
- **Editable:** No
- **Required:** No

**Campos editables (nombre, apellido_p, apellido_m, correo):**
- **Type:** Text (varchar)
- **Display:** Text
- **Editable:** Yes
- **Required:** Yes (según tus necesidades)

---

## ✅ Checklist de implementación

Marca cada paso al completarlo:

- [ ] 1. Campo `cc_edit` agregado a la tabla en la BD
- [ ] 2. Campo `cc_edit` agregado en Scriptcase como Hidden
- [ ] 3. Evento `onRecord` copiado y pegado
- [ ] 4. Evento `OnBeforeUpdate` copiado y pegado
- [ ] 5. Evento `onAfterUpdate` copiado y pegado
- [ ] 6. Método `crear_usuario_recomendante` creado y copiado
- [ ] 7. WHERE clause configurado con `[id_asp]`
- [ ] 8. Variable `[id_asp]` definida en el login
- [ ] 9. Aplicación generada (Generate Source Code)
- [ ] 10. Aplicación desplegada y probada

---

## 🚀 Orden de implementación

1. **Base de datos** → Asegurar que `cc_edit` existe (ya está hecho)
2. **Scriptcase - Fields** → Agregar `cc_edit` como Hidden
3. **Scriptcase - SQL** → Configurar WHERE con `[id_asp]`
4. **Scriptcase - Methods** → Crear método `crear_usuario_recomendante`
5. **Scriptcase - Events** → Agregar `onRecord`, `OnBeforeUpdate`, `onAfterUpdate`
6. **Generate & Deploy** → Generar código y desplegar
7. **Test** → Probar con usuario aspirante

---

## 📞 Contacto y soporte

Si algo no funciona, revisa:
1. La documentación oficial: https://www.scriptcase.net/docs/
2. El archivo `CONFIGURACION_SCRIPTCASE_PASO_A_PASO.md` en esta carpeta
3. El foro de Scriptcase: https://www.scriptcase.net/forum/

**Última actualización:** Febrero 2026
