# Scripts del repositorio `sce_asp_scriptcase`

Rutas relativas desde la raíz del repo: `/opt/sce_asp_scriptcase`.

## Herramientas locales (sin tocar producción)

| Script | Descripción |
|--------|-------------|
| [`local/levantar_visor_paquete_seguridad.sh`](local/levantar_visor_paquete_seguridad.sh) | HTTP estático en `127.0.0.1` para ver `seguridad/PAQUETE_ENVIO_ATDT_IDOR/viewer.html` (Markdown + Mermaid). Puerto por defecto **8765**. |
| [`local/levantar_visor_documentacion_2026.sh`](local/levantar_visor_documentacion_2026.sh) | Mismo tipo de visor para `CONTRATACION TICS/documentacion_2026/` (borrador + anexos en `md/`). Puerto por defecto **8766**. |

**Uso rápido:**

```bash
cd /opt/sce_asp_scriptcase
chmod +x scripts/local/levantar_visor_paquete_seguridad.sh   # una vez
./scripts/local/levantar_visor_paquete_seguridad.sh
```

```bash
chmod +x scripts/local/levantar_visor_documentacion_2026.sh   # una vez
./scripts/local/levantar_visor_documentacion_2026.sh
```

Puerto ocupado: `PORT=8766 ./scripts/local/levantar_visor_paquete_seguridad.sh`  
Sin abrir navegador: `NO_BROWSER=1 ./scripts/local/levantar_visor_paquete_seguridad.sh`  
Liberar puerto (Linux): `LIBERAR_PUERTO=1 ./scripts/local/levantar_visor_paquete_seguridad.sh`

Documentación 2026: otro puerto si hace falta — `PORT=8777 ./scripts/local/levantar_visor_documentacion_2026.sh`

---

## Deploy y post-deploy SCE (servidor / LAMPP)

| Script | Descripción |
|--------|-------------|
| [`post_deploy_sce.sh`](post_deploy_sce.sh) | **Recomendado tras publicar:** parche `fix.php` (login/logout), temas en `schemas.ini`, opción de bloquear `fix.php`. |
| [`deploy_fix_permissions_sce.sh`](deploy_fix_permissions_sce.sh) | Permisos generales en `/opt/lampp/htdocs/sce` (daemon + web). |
| [`aplicar_fix_app_login_500.sh`](aplicar_fix_app_login_500.sh) | Solo inserta funciones en `fix.php` (solapa parte de `post_deploy_sce.sh`; usar uno u otro según necesidad). |
| [`fix_sce_production.php`](fix_sce_production.php) | Utilidad PHP de mantenimiento (revisar comentarios al inicio del archivo). |

Documentación relacionada: `docs/SOLUCION_SCE_APP_LOGIN_500_FUNCIONES_LOGOUT.md`.

---

## Tema GRP / NM_SCE / `schemas.ini`

| Script / recurso | Descripción |
|------------------|-------------|
| [`poner_tema_sce_en_desarrollo.sh`](poner_tema_sce_en_desarrollo.sh) | Tema en desarrollo. |
| [`permisos_deploy_sce_tema.sh`](permisos_deploy_sce_tema.sh) | Permisos del directorio del tema `_lib/css/SCE` para deploy (daemon). |
| [`agregar_temas_sce_schemas.sh`](agregar_temas_sce_schemas.sh) | Entradas de tema en `schemas.ini`. |
| [`crear_tema_grp_NM_SCE_enlaces.sh`](crear_tema_grp_NM_SCE_enlaces.sh) | Enlaces del tema GRP. |
| [`patch_sce_schemas_ini_theme_entries.txt`](patch_sce_schemas_ini_theme_entries.txt) | Parche manual / referencia. |
| [`schemas_ini_lineas_temas_sce.txt`](schemas_ini_lineas_temas_sce.txt) | Referencia de líneas. |

Documentación: `docs/TEMA_GRP_NM_SCE_WINDOWS_A_LINUX.md`.

---

## Base de datos / comparación

| Script | Descripción |
|--------|-------------|
| [`comparar_registros_win_lin.sh`](comparar_registros_win_lin.sh) | Comparar registros entre entornos (ver `docs/DIFERENCIAS_TABLAS_BD_WINDOWS_LINUX.md`). |

---

## Correo / SMTP (pruebas)

| Archivo | Descripción |
|---------|-------------|
| [`envio_correo_prueba_smtp.php`](envio_correo_prueba_smtp.php) | Prueba SMTP genérica. |
| [`envio_correo_prueba_outlook.php`](envio_correo_prueba_outlook.php) | Prueba orientada a Outlook. |

---

## Notas de mantenimiento

- **No borramos** `aplicar_fix_app_login_500.sh`: aunque se solapa con `post_deploy_sce.sh`, puede ser útil para un parche mínimo sin el resto del post-deploy.
- Los scripts que citan rutas absolutas (`/opt/lampp/...`) están pensados para el servidor estándar del proyecto; ajústalos si tu entorno difiere.
