# form_recomendantes

Formulario **Editable grid** (Multiple Records) para que el aspirante actualice sus 3 recomendantes: **nombre**, **apellido_p**, **apellido_m**, **correo**. Los registros se filtran por `[id_asp]`.

- **Tabla:** `recomendantes`
- **Clave primaria:** `id_recom`
- **Campo de control:** `cc_edit` (TINYINT(1), default `1`). `1` = editable; `0` = ya se creó usuario para cartas, no editar. Hay que añadirlo con el script en `data/alter_recomendantes_cc_edit_recom.sql`.
- **WHERE (SQL Settings):** solo los recomendantes del aspirante logueado vía `asp_recomendantes` y `[id_asp]`.

En este repo solo se mantiene **form_recomendantes** para recomendantes. Las apps **form_agregar_recomendante** y **grid_aspirantes_recomendantes** fueron eliminadas; la edición de los 3 recomendantes se hace desde este form.

---

## Eventos

### onApplicationInit

En el repo el archivo `Eventos/onApplicationInit` está vacío. Si en tu despliegue necesitas asegurar `[id_asp]` (por ejemplo si el form se abre sin pasar por menu_aspirante), en Scriptcase → **Form Settings** → **Events** → **onApplicationInit** puedes pegar:

```php
if (empty($_SESSION['id_asp']) || (string)$_SESSION['id_asp'] === '') {
    sc_error_message("Debe iniciar sesión como aspirante para acceder a Recomendantes.");
    sc_redir('menu_aspirante');
    exit;
}
[id_asp] = $_SESSION['id_asp'];
```

---

## Variable [id_asp]

- Se define en el login: **App_login** → `sc_validate_success` (`[id_asp]` y `$_SESSION['id_asp']`).
- El form debe abrirse desde **menu_aspirante** (enlace “Recomendantes” o similar) para que la sesión y `[id_asp]` estén cargados.

---

## Error "unexpected identifier recom" (500)

Si al desplegar aparece en PHP: `unexpected identifier "recom"`, Scriptcase está generando `$this->id recom` (con espacio).

**En Scriptcase:** En **Form Settings** → **Edit Fields** o **Fields** → **# Id Recom** → **General Settings**, cambiar el **nombre del campo** de `Id Recom` a `Id_Recom` o `id_recom` y volver a desplegar.

**Parche en el PHP desplegado:** Sustituir `$this->id recom` por `$this->{'id recom'}` en `form_recomendantes_apl.php`, o ejecutar el script `fix_id_recom_parse_error.sh` (ver script en esta carpeta).

---

## Campo de control cc_edit

En la tabla **recomendantes** se usa **cc_edit** (TINYINT(1)):

- **1** (default): el registro se puede editar; al guardar se crea usuario y se envía correo, y se pasa a **0**.
- **0**: ya se creó el usuario de acceso para ese recomendante; **onBeforeUpdate** impide guardar de nuevo.

**Antes de usar el form** hay que ejecutar el ALTER en la BD:

```bash
mysql -u root -h 127.0.0.1 -p515t3ma5 sce_asp < data/alter_recomendantes_cc_edit_recom.sql
```

Ver `data/alter_recomendantes_cc_edit_recom.sql`. Si la tabla ya tiene datos, los nuevos registros tendrán `cc_edit = 1` por defecto.

---

## Botón Guardar: crear usuario y enviar correo

Al hacer clic en **Guardar** (por fila o “Guardar seleccionados”):

1. **OnBeforeUpdate:** Si **cc_edit = 0**, se muestra error y no se permite guardar (ese recomendante ya tiene usuario creado).
2. **onAfterUpdate:** Se llama al método **crear_usuario_recomendante**, que:
   - Comprueba **cc_edit**; si es `0`, no hace nada.
   - Crea el usuario en **sec_asp_users** (login = correo, contraseña aleatoria 8 caracteres, name/apat/amat/email, active='Y').
   - Inserta en **sec_asp_users_groups** con **group_id = 7** (recomendantes que suben cartas).
   - Actualiza **recomendantes**: `login_FK` = login creado y **cc_edit = 0** (bloquea futuras ediciones).
   - Envía un correo a **anibal.sanchez@inecol.mx** con los datos de acceso (usuario y contraseña).

El envío de correo usa la misma configuración SMTP que en **app_form_add_users** (Gmail). Para cambiar el destinatario, editar en el método `crear_usuario_recomendante` la variable `$mail_to`.

---

## Estructura en repo

```
form_recomendantes/
├── Eventos/
│   ├── onApplicationInit   (vacío; código opcional en README)
│   ├── OnBeforeUpdate     (bloquear si cc_edit_recom = 'N')
│   └── onAfterUpdate      (llamar crear_usuario_recomendante)
├── metodos/
│   └── crear_usuario_recomendante($id_recom, $nombre, $apellido_p, $apellido_m, $correo)
├── fix_id_recom_parse_error.sh
└── README.md
```

Este form **actualiza** los 3 recomendantes ya creados en el alta del aspirante (`add_asp_aspirantes`). Tras el primer guardado de un recomendante con correo, se crea su usuario de acceso y ese registro **no vuelve a ser editable**.
