# Auditoría y hardening Scriptcase

Fecha: 2026-03-20

## Alcance

- `https://posgrados.inecol.mx/sce/` -> `/opt/lampp/htdocs/sce`
- `https://posgrados.inecol.mx/sce_asp/` -> `/opt/lampp/htdocs/sce_asp`
- `https://posgrados.inecol.mx/sce_enbc/` -> `/opt/lampp/htdocs/sce_enbc`

## Hallazgos

### 1) Exposición pública crítica de respaldos (confirmado)

Se confirmó listado de directorio y acceso a archivos de respaldo en:

- `/sce_asp/backups/`
- `/sce_asp/backups_20251104_150812/`
- `/sce_asp/backups_20251104_150846/`

Tipos de archivos expuestos: `.zip` y `.sql` (alto riesgo de fuga de datos).

### 2) Exposición de ruta `_lib` (confirmado)

En las tres apps, `/_lib/` responde con interfaz de "Production Environment" de Scriptcase.  
No fue listado de archivos, pero la ruta es públicamente alcanzable.

### 3) Permisos inseguros en sistema de archivos (confirmado)

Conteo de elementos world-writable:

- `sce`: 0 dirs / 62 files
- `sce_asp`: 0 dirs / 65 files
- `sce_enbc`: 1756 dirs / 14008 files

`sce_enbc` presenta superficie de riesgo alta por permisos de escritura global.

## Cambios aplicados (hardening)

### A) Bloqueo de exposición y listados por `.htaccess`

Se crearon reglas en:

- `/opt/lampp/htdocs/sce/.htaccess`
- `/opt/lampp/htdocs/sce_asp/.htaccess`
- `/opt/lampp/htdocs/sce_enbc/.htaccess`

Reglas aplicadas:

- `Options -Indexes` (evita listados de directorio).
- Denegación de archivos sensibles (`.sql`, `.zip`, `.tar`, `.gz`, `.tgz`, `.bak`, `.old`, `.log`).
- Regla de bloqueo para rutas `backups*`.

### B) Cierre explícito de directorios de respaldo expuestos

Se añadió `Require all denied` en:

- `/opt/lampp/htdocs/sce_asp/backups/.htaccess`
- `/opt/lampp/htdocs/sce_asp/backups_20251104_150812/.htaccess`
- `/opt/lampp/htdocs/sce_asp/backups_20251104_150846/.htaccess`

## Pendiente detectado durante ejecución

Se intentó normalizar permisos en `sce_enbc` con `chmod -R o-w`, pero hubo múltiples `Operación no permitida` por falta de propiedad/permisos sobre parte del árbol.

Acción recomendada con usuario privilegiado:

```bash
sudo chown -R daemon:daemon /opt/lampp/htdocs/sce_enbc
sudo find /opt/lampp/htdocs/sce_enbc -type d -perm -0002 -exec chmod o-w {} +
sudo find /opt/lampp/htdocs/sce_enbc -type f -perm -0002 -exec chmod o-w {} +
```

## Política mínima recomendada de permisos (Scriptcase)

- Base producción: directorios `755`, archivos `644`.
- Solo carpetas operativas puntuales con escritura del usuario de Apache.
- Evitar `777` permanente.
- Respaldos fuera de `htdocs` siempre que sea posible.

## Checklist de validación post-hardening

1. Confirmar que `https://posgrados.inecol.mx/sce_asp/backups/` responde `403` o `404`.
2. Confirmar que `https://posgrados.inecol.mx/sce_asp/backups_20251104_150812/` responde `403` o `404`.
3. Confirmar que `https://posgrados.inecol.mx/sce_asp/backups_20251104_150846/` responde `403` o `404`.
4. Verificar login y navegación básica en `sce`, `sce_asp`, `sce_enbc`.
5. Verificar carga/descarga de adjuntos en módulos que escriben archivos.
6. Re-ejecutar escaneo de permisos para comprobar reducción de world-writable en `sce_enbc`.
