# Enlaces a Documentación Oficial de Scriptcase

Guía rápida con enlaces directos a la documentación oficial que necesitas consultar para este proyecto.

---

## 🔗 Enlaces principales

### Documentación general
- **Portal principal:** https://www.scriptcase.net/docs/
- **Manual en español:** https://www.scriptcase.net/docs/es_es/
- **Manual en inglés:** https://www.scriptcase.net/docs/en_us/

---

## 📚 Macros y métodos específicos

### 1. Métodos de campos (Field Methods)

**Usar para:** Deshabilitar campos, cambiar estilos, agregar tooltips

```php
{campo}->setReadOnly(true);
{campo}->setCss('property', 'value');
{campo}->setHelp("texto");
```

**Documentación:**
- 🇬🇧 https://www.scriptcase.net/docs/en_us/v9/manual/08-form/02-events/#field-methods
- 🇪🇸 https://www.scriptcase.net/docs/es_es/v9/manual/08-form/02-events/#metodos-de-campo

**Buscar en docs:** "Field Methods", "setReadOnly", "setCss"

---

### 2. Eventos de Grid (Grid Events)

**Usar para:** Conocer cuándo usar onRecord, onLoad, onBeforeUpdate, etc.

**Eventos clave:**
- `onApplicationInit` - Inicialización de la app
- `onRecord` - Para cada fila del grid
- `onBeforeUpdate` - Antes de actualizar
- `onAfterUpdate` - Después de actualizar

**Documentación:**
- 🇬🇧 https://www.scriptcase.net/docs/en_us/v9/manual/07-grid/02-events/
- 🇪🇸 https://www.scriptcase.net/docs/es_es/v9/manual/07-grid/02-events/

**Buscar en docs:** "Grid Events", "onRecord", "Editable Grid"

---

### 3. Botones (Button Display Macros)

**Usar para:** Mostrar/ocultar botones de guardado, eliminación, etc.

```php
sc_btn_save_display(false);
sc_btn_update_display(false);
sc_btn_delete_display(false);
```

**Documentación:**
- 🇬🇧 https://www.scriptcase.net/docs/en_us/v9/manual/05-programming/01-macros/03-display/
- 🇪🇸 https://www.scriptcase.net/docs/es_es/v9/manual/05-programming/01-macros/03-display/

**Buscar en docs:** "Button Macros", "sc_btn_display", "Hide buttons"

---

### 4. Consultas SQL (Database Macros)

**Usar para:** Consultar datos con sc_lookup, ejecutar SQL con sc_exec_sql

```php
sc_lookup(dataset, "SELECT campo FROM tabla WHERE id = valor");
sc_exec_sql("UPDATE tabla SET campo = valor WHERE id = X");
```

**Documentación:**
- 🇬🇧 https://www.scriptcase.net/docs/en_us/v9/manual/05-programming/01-macros/16-database/
- 🇪🇸 https://www.scriptcase.net/docs/es_es/v9/manual/05-programming/01-macros/16-database/

**Buscar en docs:** "sc_lookup", "sc_exec_sql", "Database Macros"

---

### 5. Mensajes (Message Macros)

**Usar para:** Mostrar mensajes de error, éxito, info, warning

```php
sc_error_message("Texto del error");
sc_message("Texto", "tipo"); // tipo: info, success, warning, error
```

**Documentación:**
- 🇬🇧 https://www.scriptcase.net/docs/en_us/v9/manual/05-programming/01-macros/06-messages/
- 🇪🇸 https://www.scriptcase.net/docs/es_es/v9/manual/05-programming/01-macros/06-messages/

**Buscar en docs:** "Message Macros", "sc_error_message", "sc_message"

---

### 6. Redirección (Redirect Macros)

**Usar para:** Redirigir a otra aplicación

```php
sc_redir('nombre_aplicacion');
```

**Documentación:**
- 🇬🇧 https://www.scriptcase.net/docs/en_us/v9/manual/05-programming/01-macros/09-redirect/
- 🇪🇸 https://www.scriptcase.net/docs/es_es/v9/manual/05-programming/01-macros/09-redirect/

**Buscar en docs:** "sc_redir", "Redirect Macros"

---

### 7. Seguridad SQL (Security Macros)

**Usar para:** Prevenir SQL Injection

```php
sc_sql_injection($variable);
```

**Documentación:**
- 🇬🇧 https://www.scriptcase.net/docs/en_us/v9/manual/05-programming/01-macros/17-security/
- 🇪🇸 https://www.scriptcase.net/docs/es_es/v9/manual/05-programming/01-macros/17-security/

**Buscar en docs:** "sc_sql_injection", "Security Macros", "SQL Injection"

---

### 8. Envío de correos (Mail Macros)

**Usar para:** Enviar correos electrónicos desde Scriptcase

```php
sc_mail_send($smtp_server, $smtp_user, $smtp_pass, $from, $to, $subject, $message, ...);
```

**Documentación:**
- 🇬🇧 https://www.scriptcase.net/docs/en_us/v9/manual/05-programming/01-macros/05-mail/
- 🇪🇸 https://www.scriptcase.net/docs/es_es/v9/manual/05-programming/01-macros/05-mail/

**Buscar en docs:** "sc_mail_send", "Mail Macros", "SMTP"

---

### 9. Variables globales y de sesión

**Usar para:** Trabajar con variables de sesión y globales

```php
$_SESSION['variable'];
[variable_global];
```

**Documentación:**
- 🇬🇧 https://www.scriptcase.net/docs/en_us/v9/manual/05-programming/02-global-variables/
- 🇪🇸 https://www.scriptcase.net/docs/es_es/v9/manual/05-programming/02-global-variables/

**Buscar en docs:** "Global Variables", "Session Variables", "[]"

---

### 10. WHERE Clause (SQL Settings)

**Usar para:** Filtrar datos del grid con WHERE dinámico

**Documentación:**
- 🇬🇧 https://www.scriptcase.net/docs/en_us/v9/manual/07-grid/01-settings/02-sql-settings/
- 🇪🇸 https://www.scriptcase.net/docs/es_es/v9/manual/07-grid/01-settings/02-sql-settings/

**Buscar en docs:** "SQL Settings", "WHERE Clause", "Grid Filter"

---

## 🎥 Videos tutoriales

### Canal oficial de YouTube
- **Scriptcase (inglés):** https://www.youtube.com/c/Scriptcase
- **Scriptcase Español:** https://www.youtube.com/c/ScriptcaseEspanol

### Videos relevantes para este proyecto:
1. **Editable Grid Tutorial:** https://www.youtube.com/watch?v=ejemplo
2. **Events in Scriptcase:** https://www.youtube.com/watch?v=ejemplo
3. **Field Methods:** https://www.youtube.com/watch?v=ejemplo

---

## 💬 Foro y comunidad

### Foro oficial
- **Foro inglés:** https://www.scriptcase.net/forum/
- **Foro español:** https://www.scriptcase.net/forum/forumdisplay.php?f=17

### Buscar temas específicos:
- **Editable Grid:** https://www.scriptcase.net/forum/search.php?search_keywords=editable+grid
- **onRecord Event:** https://www.scriptcase.net/forum/search.php?search_keywords=onRecord
- **setReadOnly:** https://www.scriptcase.net/forum/search.php?search_keywords=setReadOnly

---

## 📖 Guías útiles en docs

### 1. Editable Grid (Multiple Records)
**Para:** Entender cómo funciona el tipo de aplicación que estamos usando

🇬🇧 https://www.scriptcase.net/docs/en_us/v9/manual/07-grid/03-editable/
🇪🇸 https://www.scriptcase.net/docs/es_es/v9/manual/07-grid/03-editable/

### 2. Form Events
**Para:** Conocer todos los eventos disponibles y cuándo se ejecutan

🇬🇧 https://www.scriptcase.net/docs/en_us/v9/manual/08-form/02-events/
🇪🇸 https://www.scriptcase.net/docs/es_es/v9/manual/08-form/02-events/

### 3. Programming Macros (General)
**Para:** Ver todas las macros disponibles en Scriptcase

🇬🇧 https://www.scriptcase.net/docs/en_us/v9/manual/05-programming/01-macros/
🇪🇸 https://www.scriptcase.net/docs/es_es/v9/manual/05-programming/01-macros/

### 4. Security and Validation
**Para:** Mejores prácticas de seguridad

🇬🇧 https://www.scriptcase.net/docs/en_us/v9/manual/08-form/01-settings/05-security-settings/
🇪🇸 https://www.scriptcase.net/docs/es_es/v9/manual/08-form/01-settings/05-security-settings/

---

## 🔍 Cómo buscar en la documentación

### Método 1: Búsqueda directa
1. Ve a https://www.scriptcase.net/docs/
2. Usa el buscador (lupa) en la esquina superior derecha
3. Escribe el término: "onRecord", "setReadOnly", etc.

### Método 2: Búsqueda en Google
Formato: `site:scriptcase.net/docs [término]`

Ejemplos:
- `site:scriptcase.net/docs onRecord`
- `site:scriptcase.net/docs setReadOnly`
- `site:scriptcase.net/docs sc_lookup`

### Método 3: Macros Helper en Scriptcase
1. En Scriptcase, abre tu aplicación
2. Ve a **Events** → Cualquier evento
3. Haz clic en el botón **Macros** (icono de engranaje)
4. Navega por las categorías: Display, Messages, Database, etc.
5. Cada macro tiene descripción y ejemplos

---

## 📱 Soporte oficial

### Contacto con Scriptcase
- **Email soporte:** support@scriptcase.net
- **Tickets:** https://www.scriptcase.net/support/
- **Chat en vivo:** Disponible en el portal (horario de oficina)

### Versiones de documentación
- **v9 (actual):** https://www.scriptcase.net/docs/en_us/v9/
- **v8:** https://www.scriptcase.net/docs/en_us/v8/

**Nota:** Asegúrate de consultar la versión correcta según tu instalación de Scriptcase.

---

## 🎓 Cursos y entrenamientos

### Academia Scriptcase
- **Portal:** https://www.scriptcase.net/academy/
- **Cursos gratuitos:** Disponibles en el portal
- **Certificaciones:** Disponibles tras completar cursos

---

## 📝 Términos clave para buscar

Cuando busques ayuda en la documentación o foro, usa estos términos:

| Español | Inglés | Buscar en docs |
|---------|--------|----------------|
| Deshabilitar campo | Disable field | `setReadOnly`, `Field Methods` |
| Evento por fila | Row event | `onRecord`, `Grid Events` |
| Consulta SQL | SQL query | `sc_lookup`, `Database Macros` |
| Mensaje de error | Error message | `sc_error_message`, `Message Macros` |
| Enviar correo | Send email | `sc_mail_send`, `Mail Macros` |
| Validación | Validation | `onValidate`, `Validation Methods` |
| Redirigir | Redirect | `sc_redir`, `Redirect Macros` |
| Variable global | Global variable | `Global Variables`, `[]` |
| Botón guardar | Save button | `sc_btn_save_display`, `Button Macros` |
| Grid editable | Editable grid | `Editable Grid`, `Multiple Records` |

---

## ⚙️ Configuración SMTP para Gmail (referencia rápida)

Si necesitas ayuda con configuración SMTP:

**Documentación Gmail App Passwords:**
https://support.google.com/accounts/answer/185833

**Configuración en Scriptcase:**
```php
$mail_smtp_server   = 'smtp.gmail.com';
$mail_smtp_user     = 'tu-email@gmail.com';
$mail_smtp_pass     = 'tu-app-password'; // No la contraseña normal
$mail_port          = '465';
$mail_tp_connection = 'S'; // SSL
```

---

## 🆘 Problemas comunes - Buscar en docs

| Problema | Buscar en docs |
|----------|----------------|
| Los campos no se deshabilitan | "Field Methods", "setReadOnly" |
| No se ejecuta onRecord | "Grid Events", "Event Execution Order" |
| Error SQL Injection | "sc_sql_injection", "Security" |
| No se envían correos | "sc_mail_send", "Mail Configuration" |
| Variable [id_asp] vacía | "Global Variables", "Session" |
| Botones no se ocultan | "Button Macros", "sc_btn_display" |

---

**Última actualización:** Febrero 2026

**Tip:** Guarda este archivo como favorito en tu navegador para acceso rápido a los enlaces.
