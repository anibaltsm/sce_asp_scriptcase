# Hardening WAMP (Windows) — solo SCE

Aplica en **una sola aplicación**: `SCE` bajo WAMP, misma lógica que en Linux: menos exposición por URL sin romper Scriptcase.

## Advertencia de seguridad

No almacene contraseñas de administrador ni SMB en archivos del repo. Si alguna se filtró, **cámbiela**.

## Alcance

- **Solo** `C:\wamp64\www\SCE\` (ajuste `WIN_REL_SCE_DIR` en el script si su ruta difiere).
- No incluye `SCE_ASP` ni `SCE_ENBC` en Windows salvo que usted repita el proceso en otra carpeta.

## Qué se endurece

- Sin listado de directorios (`Options -Indexes`).
- Bloqueo de extensiones sensibles (`.sql`, `.zip`, `.tar`, `.gz`, etc.).
- Bloqueo de rutas `backups*` bajo la raíz de SCE.
- Bloqueo de acceso **directo** a `/_lib/` y `/_lib/prod/` por URL (el resto de `_lib` sigue sirviendo recursos que la app necesita).

## Archivos en este repositorio

| Uso | Ruta |
|-----|------|
| Plantilla a subir como `.htaccess` | [plantillas/htaccess_SCE_WAMP_raiz_apache24.txt](plantillas/htaccess_SCE_WAMP_raiz_apache24.txt) |
| Script opcional SMB desde Linux | [scripts/seguridad/deploy_sce_htaccess_wamp_smb.sh](../scripts/seguridad/deploy_sce_htaccess_wamp_smb.sh) |

## Opción A — Copia manual en Windows

1. Copie el contenido de `htaccess_SCE_WAMP_raiz_apache24.txt` a `C:\wamp64\www\SCE\.htaccess`.
2. WAMP → Apache → activar **rewrite_module**.
3. En `httpd.conf` o vhost, que el `<Directory "C:/wamp64/www/">` (o el que corresponda) tenga **`AllowOverride All`**.
4. Reiniciar Apache.

## Opción B — Desde Linux con `smbclient` (equivalente a su instrucción)

En el equipo Linux (por ejemplo `srvpg`), con acceso SMB al `C$` del Windows:

```bash
cd /opt/sce_asp_scriptcase
# Contraseña interactiva (recomendado):
smbclient "//192.168.2.68/C\$" -U "Administrador" -W WORKGROUP \
  -c "cd wamp64\\www\\SCE; put seguridad/plantillas/htaccess_SCE_WAMP_raiz_apache24.txt .htaccess"
```

Si prefiere no escribir la ruta a mano:

```bash
cd /opt/sce_asp_scriptcase
export SMB_SERVER=192.168.2.68
export SMB_USER=Administrador
export SMB_WORKGROUP=WORKGROUP
bash scripts/seguridad/deploy_sce_htaccess_wamp_smb.sh
```

Si la carpeta de SCE no es `wamp64\www\SCE`, indique la ruta relativa a `C:\`:

```bash
export WIN_REL_SCE_DIR='wamp64\\www\\OtraRuta\\SCE'
bash scripts/seguridad/deploy_sce_htaccess_wamp_smb.sh
```

**Nota:** En la línea de `smbclient`, las barras en `cd` deben ir dobles (`\\`) como en el ejemplo.

## Respaldos solo dentro de SCE (opcional)

Si bajo `C:\wamp64\www\SCE\` existe una carpeta `backups` o similar y debe cerrarse igual que en Linux, cree allí un `.htaccess` con:

```apache
Require all denied
```

## Validación

| Prueba | Esperado |
|--------|----------|
| URL `.../SCE/_lib/` | `403` (o equivalente) |
| URL `.../SCE/_lib/prod/` | `403` |
| Login y navegación SCE | Sin fallos de CSS/JS |

## Otros proyectos bajo `www` (misma plantilla)

Para aplicar **la misma** protección (`_lib` raíz, `backups*`, extensiones sensibles, sin listados) a más carpetas Scriptcase en el mismo WAMP, use el script por lotes:

- [scripts/seguridad/deploy_wamp_projects_htaccess_smb.sh](../scripts/seguridad/deploy_wamp_projects_htaccess_smb.sh)

Por defecto sube a (relativo a `C:\wamp64\www\`): **convenios**, **cursos**, **diplomados**, **evaluaciones**, **tesis**. Personalice con `SMB_PROJECTS` (lista separada por comas) y, si hace falta, `WIN_WWW_BASE` (por defecto `wamp64\\www`).

```bash
cd /opt/sce_asp_scriptcase
export SMB_SERVER=192.168.2.68 SMB_USER=Administrador SMB_WORKGROUP=WORKGROUP
export SMB_PROJECTS='convenios,cursos,diplomados,evaluaciones,tesis'
read -s -p "Contraseña SMB: " SMB_PASS; echo; export SMB_PASS
bash scripts/seguridad/deploy_wamp_projects_htaccess_smb.sh
```

## Relación con Linux

Resumen del endurecimiento en servidor Linux: [RESUMEN_SEGURIDAD_IMPLEMENTADA_3_SISTEMAS.md](RESUMEN_SEGURIDAD_IMPLEMENTADA_3_SISTEMAS.md).
