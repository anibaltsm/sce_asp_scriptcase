# Resumen breve de seguridad implementada

Fecha: 2026-03-20  
Sistemas: `sce`, `sce_asp`, `sce_enbc`

## Objetivo

Reducir exposición de información por URL pública sin afectar la operación normal de aplicaciones Scriptcase.

## Qué se cubrió

- Prevención de listado de carpetas en web.
- Bloqueo de descarga directa de archivos sensibles.
- Cierre de rutas de respaldo expuestas en producción.
- Reducción de exposición directa de rutas raíz de entorno Scriptcase (`/_lib` y `/_lib/prod`).

## Qué se implementó

### 1) Hardening general en los 3 sistemas

Se aplicaron reglas `.htaccess` en:

- `/opt/lampp/htdocs/sce/.htaccess`
- `/opt/lampp/htdocs/sce_asp/.htaccess`
- `/opt/lampp/htdocs/sce_enbc/.htaccess`

Controles incluidos:

- `Options -Indexes` para evitar `Index of /...`.
- Denegación de archivos sensibles por extensión: `.sql`, `.zip`, `.tar`, `.gz`, `.tgz`, `.bak`, `.old`, `.log`.
- Bloqueo de rutas `backups*`.
- Bloqueo de acceso directo por URL a:
  - `/_lib/`
  - `/_lib/prod/`

Nota: no se bloqueó todo `/_lib/*` para evitar romper recursos que Scriptcase utiliza en tiempo de ejecución.

### 2) Cierre específico de respaldos expuestos en `sce_asp`

Se agregaron reglas `Require all denied` en:

- `/opt/lampp/htdocs/sce_asp/backups/.htaccess`
- `/opt/lampp/htdocs/sce_asp/backups_20251104_150812/.htaccess`
- `/opt/lampp/htdocs/sce_asp/backups_20251104_150846/.htaccess`

Con esto se mitiga la exposición de respaldos `.sql` y `.zip` vía URL.

## Riesgos mitigados

- Fuga de datos por respaldos accesibles públicamente.
- Enumeración de contenido por listado de directorios.
- Exposición de rutas internas de entorno de producción.

## Pendiente recomendado

Normalizar permisos de archivos/carpetas en `sce_enbc` (se detectó alta cantidad de elementos `world-writable`).  
Se recomienda ejecutar la corrección con privilegios de administrador para completar el endurecimiento del sistema de archivos.

## Estado actual (ejecutivo)

- `sce`: endurecimiento web aplicado.
- `sce_asp`: endurecimiento web aplicado + respaldos cerrados.
- `sce_enbc`: endurecimiento web aplicado; pendiente cierre total de permisos inseguros a nivel sistema de archivos.

## Equivalencia en servidor Windows (WAMP) — solo SCE

En Windows: SCE y, con el mismo criterio, los proyectos **convenios**, **cursos**, **diplomados**, **evaluaciones** y **tesis** bajo `C:\wamp64\www\`. Detalle: [HARDENING_WAMP_WINDOWS_SCRIPTCASE.md](HARDENING_WAMP_WINDOWS_SCRIPTCASE.md). Plantilla: [plantillas/htaccess_SCE_WAMP_raiz_apache24.txt](plantillas/htaccess_SCE_WAMP_raiz_apache24.txt). SMB: [deploy_sce_htaccess_wamp_smb.sh](../scripts/seguridad/deploy_sce_htaccess_wamp_smb.sh) (solo SCE) y [deploy_wamp_projects_htaccess_smb.sh](../scripts/seguridad/deploy_wamp_projects_htaccess_smb.sh) (varios).
