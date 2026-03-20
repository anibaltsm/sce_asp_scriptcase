# Referencias ScriptCase para sustento tecnico (IDOR/BOLA)

Este documento sirve para justificar que los controles descritos en el informe se alinean con capacidades nativas de ScriptCase.

## 1) Seguridad de aplicacion (Use security)

Referencia:

- https://scriptcase.net/docs/en_us/v9/manual/06-applications/06-tab-application/05-tab-security/01-security

Puntos relevantes para el informe:

- Cuando `Use security` esta habilitado, ScriptCase bloquea acceso no autorizado.
- El acceso puede ser controlado por modulo de seguridad o macro `sc_apl_status`.
- Opcion para evitar acceso directo por URL (`Allow direct calling by URL`).

Aplicacion en tus 3 sistemas:

- SCE, SCE_ASP y SCE_ENBC pueden documentar control de acceso por app y bloqueo de acceso directo cuando aplique.

## 2) Modulo de seguridad ScriptCase

Referencia:

- https://scriptcase.net/docs/en_us/v9/manual/10-modules/02-security-module/01-general-overview

Puntos relevantes para el informe:

- Tipos de seguridad: por usuario, aplicacion, grupo y LDAP.
- Enfasis para tus sistemas: seguridad por grupo/aplicacion para control granular de permisos.

Aplicacion en tus 3 sistemas:

- Justifica el modelo basado en grupos/permisos (`sec_*_groups_apps`).

## 3) Macros relevantes para autorizacion y flujo

Referencia macros:

- https://www.scriptcase.net/docs/en_us/v9/manual/14-macros/02-macros/

Macros a citar:

- `sc_apl_status("Application", "Status")`: habilita/deshabilita acceso a aplicaciones.
- `sc_apl_conf("Application", "Property", "Value")`: configura permisos/propiedades de ejecucion por app.
- `sc_error_message("Text")`: muestra mensaje de denegacion/validacion.
- `sc_redir(...)`: redireccion de seguridad (ej. al menu permitido o login).
- `sc_log_add("action", "description")`: registro adicional de eventos cuando se requiera evidencia.

## 4) Como citar esto en el informe ATDT

En secciones A, C y E del checklist:

- A1/A2/A3: describir autorizacion por objeto + denegacion + redireccion segura.
- C4: explicar centralizacion de reglas con `sc_apl_status`/`sc_apl_conf`.
- E2/E3: complementar con bitacora (`sc_log`/`sc_log_add`) y monitoreo.

## 5) Nota de buenas practicas OWASP (complemento)

Referencias generales:

- OWASP Top 10 A01 Broken Access Control:
  - https://owasp.org/Top10/A01_2021-Broken_Access_Control
- OWASP WSTG Authorization Testing:
  - https://owasp.org/www-project-web-security-testing-guide/stable/4-Web_Application_Security_Testing/05-Authorization_Testing/02-Testing_for_Bypassing_Authorization_Schema
- OWASP API1 BOLA (2023):
  - https://owasp.org/API-Security/editions/2023/en/0xa1-broken-object-level-authorization/

