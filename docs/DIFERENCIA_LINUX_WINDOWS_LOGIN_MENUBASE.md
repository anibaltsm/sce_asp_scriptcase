# Diferencia Linux vs Windows: login y "Usuario no autorizado"

## Aclaración: qué código corre dónde

- **El código que realmente se ejecuta** (login, permisos, redirección) está en **`/opt/lampp/htdocs/sce`** (publicado). Ese es el que usa el servidor.
- **Este repo** (`/opt/sce_asp_scriptcase`) es el proyecto de desarrollo en ScriptCase; **no** es el que sirve la app en producción.

Se revisó **`/opt/lampp/htdocs/sce/app_Login/app_Login_apl.php`**: usa **`sec_groups_apps`** y **`sec_users_groups`** y redirección a **MenuBase**. Es decir, **el código que corre en el servidor (htdocs/sce) es el mismo tipo que en Windows** (sec_* y MenuBase), **no** el del repo (sec_asp_*). Por tanto la diferencia Linux/Windows no es "repo vs Windows", sino algo como: a qué BD se conecta cada uno, o los datos del usuario (ej. si en la BD que usa Linux ese usuario no está en sec_users_groups o MenuBase sigue en NULL).

---

## 1. Tablas en la base de datos

Se listaron las tablas `sec%` en **ambas** bases (Windows y Linux):

| Base    | ¿Tiene sec_asp_users? | ¿Tiene sec_asp_groups_apps? | ¿Tiene sec_asp_users_groups? | ¿Tiene sec_users_groups? | ¿Tiene sec_groups_apps? |
|---------|------------------------|------------------------------|------------------------------|---------------------------|--------------------------|
| Windows | **No**                 | **No**                       | **No**                       | Sí                        | Sí                       |
| Linux   | **No**                 | **No**                       | **No**                       | Sí                        | Sí                       |

**Conclusión:** En ninguna de las dos bases existen tablas `sec_asp_*`. Solo existen `sec_users`, `sec_users_groups`, `sec_groups_apps`, `sec_apps`, `sec_groups`, etc.

---

## 2. Código que usa cada entorno

### En Windows (el que “funciona”)

- **Tablas:** `sec_groups_apps`, `sec_users_groups` (y para login seguramente `sec_users`).
- **Redirección:** `sc_redir('MenuBase');`
- Es el código que pegaste: consulta `sec_groups_apps` por grupo del usuario, hace `sc_apl_status(app, 'on'/'off')` según `priv_access`, y al final redirige a **MenuBase**.

Como las tablas **existen**, la consulta devuelve datos, se ejecuta el bloque de permisos y el `sc_redir('MenuBase')`. MenuBase tiene `priv_access = NULL` en la BD, así que queda en `'off'`; aun así en Windows no ves el error (puede ser por otra configuración o por otra versión del código publicada).

### En Linux (repo – el que da “Usuario no autorizado”)

El archivo del repo es:

`scriptcase/apps_sce_asp/App_login/metodos/sc_validate_success`

- **Tablas:** `sec_asp_groups_apps`, `sec_asp_users_groups` (y en onValidate: `sec_asp_users`).
- **Redirección:** `sc_redir('menu')`, `sc_redir('menu_aspirante')`, `sc_redir('menu_admvo')`, etc. **No** usa `sc_redir('MenuBase')`.

Como en la BD de Linux **no existen** `sec_asp_groups_apps` ni `sec_asp_users_groups`:

1. La consulta a `sec_asp_groups_apps` / `sec_asp_users_groups` falla o devuelve vacío.
2. El resultado es “no hay datos” → la condición `if ({rs} !== false)` puede no cumplirse como se espera y **no se ejecuta** (o no bien) el bloque que:
   - asigna permisos con `sc_apl_status` / `sc_apl_conf`,
   - y hace el `switch` por `group_id` y el `sc_redir('menu')` / `menu_aspirante` / etc.
3. ScriptCase puede acabar redirigiendo por defecto (por ejemplo a MenuBase) **sin haber puesto en “on” ninguna app** para ese usuario → al abrir MenuBase, la comprobación de permiso falla → **“Usuario no autorizado”**.

Además, en onValidate el login usa **sec_asp_users**. Si esa tabla no existe en Linux, el propio login puede fallar o comportarse raro.

---

## 3. Tabla comparativa: qué corre dónde

| Dónde                 | Ruta                         | Tablas que usa           | Redirección |
|-----------------------|------------------------------|--------------------------|-------------|
| **Producción (corre)**| `/opt/lampp/htdocs/sce`      | `sec_groups_apps`, `sec_users_groups` | MenuBase |
| **Este repo (dev)**   | `/opt/sce_asp_scriptcase`    | `sec_asp_*` (en el repo; no es lo que corre en htdocs/sce) | menu, menu_aspirante, etc. |

Windows y el servidor Linux (htdocs/sce) usan el **mismo tipo** de código (sec_* y MenuBase). La diferencia hay que buscarla en BD/conexión/datos.

---

## 4. Por qué Linux “está así” y Windows no

- **No** es que la BD de Linux esté “mal” o “diferente” en lo que a MenuBase se refiere (en ambas MenuBase tiene `priv_access = NULL`).
- **Sí** es que:
  - En **Windows** se está ejecutando el código que usa **sec_groups_apps** y **sec_users_groups** (que sí existen), así que el flujo de permisos y redirección se ejecuta.
  - En **Linux** se está ejecutando el código del **repo**, que usa **sec_asp_***, y esas tablas **no existen en ninguna de las dos BDs**. Por eso en Linux la lógica de permisos y la redirección por tipo de usuario no se aplican bien y acabas en “Usuario no autorizado”.

La diferencia no es “Linux vs Windows” en la BD, sino **qué código corre en cada servidor** y **contra qué tablas** (sec_* existentes vs sec_asp_* inexistentes).

---

## 5. Qué puedes hacer (sin tocar nada aún, solo opciones)

Tienes dos caminos coherentes:

**A) Hacer que en Linux se use el mismo esquema que en Windows**

- Que la aplicación en Linux use **sec_groups_apps** y **sec_users_groups** (y **sec_users** para login), igual que el código de Windows que pegaste.
- Eso implica que el **código** que corre en Linux (onValidateSuccess / sc_validate_success) sea el de Windows (consultas a `sec_*` y `sc_redir('MenuBase')`), no el del repo actual (sec_asp_* y redirección a menu/menu_aspirante/…).
- Y, si quieres evitar “Usuario no autorizado” al entrar a MenuBase, en la BD (la que use Linux) poner `priv_access = 'Y'` para MenuBase en los grupos que deban ver el menú.

**B) Hacer que en Linux existan las tablas que espera el repo**

- Crear en la BD de Linux (y si aplica en la de Windows) las tablas **sec_asp_users**, **sec_asp_users_groups**, **sec_asp_groups_apps** (y las que falten) y migrar/copiar los datos desde **sec_users**, **sec_users_groups**, **sec_groups_apps**.
- Así el código del repo (sec_asp_* y redirección a menu/menu_aspirante/…) podría funcionar sin cambiar código.

La opción A suele ser más rápida si ya tienes el código de Windows probado y solo quieres que Linux se comporte igual.

---

## 6. Dónde se muestra "Usuario no autorizado" (hallazgo en htdocs/sce)

El mensaje **"Usuario no autorizado"** sale de **MenuBase** en el código publicado:

- **Archivo:** `/opt/lampp/htdocs/sce/MenuBase/index.php` (aprox. líneas 589-611).
- **Texto:** `$this->Nm_lang['lang_errm_unth_user']` (en español: "Usuario no autorizado", en `_lib/lang/es.lang.php`).

**Condición para mostrarlo:**

```php
if (isset($_SESSION['nm_session']['user']['sec']['flag']) && $_SESSION['nm_session']['user']['sec']['flag'] == "N") 
{ 
    $_SESSION['scriptcase']['sc_apl_seg']['MenuBase'] = "on";  // bypass: permite acceso
} 
if (!isset($_SESSION['scriptcase']['MenuBase']['session_timeout']['redir']) && 
    (!isset($_SESSION['scriptcase']['sc_apl_seg']['MenuBase']) || $_SESSION['scriptcase']['sc_apl_seg']['MenuBase'] != "on"))
{ 
    $NM_Mens_Erro = $this->Nm_lang['lang_errm_unth_user'];  // → "Usuario no autorizado"
    // ... muestra el mensaje y botón OK
}
```

Es decir:

1. Si existe **`$_SESSION['nm_session']['user']['sec']['flag'] == "N"`**, MenuBase se pone en "on" y **no** se muestra el error.
2. Si **no** se cumple eso y además **`sc_apl_seg['MenuBase']`** no está definido o no es `"on"`, se muestra "Usuario no autorizado".

En app_Login (htdocs/sce) los permisos se rellenan desde **sec_groups_apps**: cuando **priv_access** es **NULL** (como en MenuBase en ambas BDs), se hace **sc_apl_seg['MenuBase'] = "off"**. Por tanto, al abrir MenuBase, la condición anterior se cumple y se muestra el mensaje, **salvo** que el bypass por **nm_session['user']['sec']['flag'] == "N"** esté activo.

**Posible diferencia Linux vs Windows:**  
En Windows podría estar definido **`nm_session['user']['sec']['flag'] = 'N'`** (seguridad desactivada o bypass), y en Linux no. Ese valor no se encontró asignado en app_Login en htdocs/sce; puede venir de configuración global de ScriptCase o de otro módulo de seguridad. No se pudo verificar sin acceso al proyecto en ScriptCase o a la config que escribe esa sesión.

**Resumen de causas probables de la diferencia:**

| Causa | Comprobación |
|-------|----------------|
| **MenuBase con priv_access = NULL** en la BD que usa el servidor | En ambas BDs (Windows y Linux) está NULL → app_Login pone MenuBase en "off" → MenuBase muestra el error. **Solución:** `UPDATE sec_groups_apps SET priv_access='Y' WHERE app_name='MenuBase' AND group_id IN (...);` en la BD a la que se conecta el servidor. |
| **Bypass `nm_session['user']['sec']['flag'] = 'N'`** | Si en Windows está en "N", MenuBase se marca "on" y no muestra el error. En Linux habría que revisar en el proyecto/Config si ese flag se define igual. |
| **Conexión a BD distinta** | La conexión en htdocs/sce está en `_lib/conf/prod.config.php` (valores cifrados). Si Linux usa 127.0.0.1 y Windows 192.168.2.68, los datos pueden diferir; conviene confirmar en ScriptCase o en el servidor qué host usa cada uno. |

---

## 7. Consultas para comprobar en tu entorno

```sql
-- En la BD que use la app (Linux o Windows):
SHOW TABLES LIKE 'sec%';

-- Debe mostrar sec_groups_apps, sec_users_groups, sec_users.
-- No mostrará sec_asp_* a menos que las hayas creado.
```

El código que corre en el servidor Linux está en **htdocs/sce** y usa **sec_groups_apps** / **sec_users_groups** y por eso hay diferencia con Windows. La diferencia no es “qué tiene la BD de Linux vs la de Windows”, sino **qué tablas usa el código que corre en cada uno** (igual que Windows). Este repo es solo el proyecto de desarrollo; no es el que se ejecuta en producción.
