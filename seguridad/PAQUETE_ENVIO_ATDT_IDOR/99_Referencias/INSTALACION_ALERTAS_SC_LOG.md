# Instalacion operativa de alertas `sc_log` (E3)

## 1) Objetivo

Automatizar deteccion de patrones anómalos en `sc_log` para SCE, SCE_ASP y SCE_ENBC:

- picos de `login Fail` por IP en ventana corta;
- posible enumeracion (muchas apps consultadas por la misma identidad en poco tiempo).

Archivo base:

- `99_Referencias/alertas_sc_log.sh`

## 2) Prerrequisitos

- Acceso al servidor con permisos para cron.
- Ejecutable MySQL disponible: `/opt/lampp/bin/mysql`.
- Permisos de lectura sobre `sc_log` en `sce`, `sce_asp`, `sce_enbc`.

## 3) Instalacion recomendada

Dar permiso de ejecucion al script:

```bash
chmod +x "/opt/sce_asp_scriptcase/seguridad/PAQUETE_ENVIO_ATDT_IDOR/99_Referencias/alertas_sc_log.sh"
```

Probar manualmente:

```bash
"/opt/sce_asp_scriptcase/seguridad/PAQUETE_ENVIO_ATDT_IDOR/99_Referencias/alertas_sc_log.sh"
echo $?
```

## 4) Programar en cron

Ejemplo: cada 5 minutos

```cron
*/5 * * * * /opt/sce_asp_scriptcase/seguridad/PAQUETE_ENVIO_ATDT_IDOR/99_Referencias/alertas_sc_log.sh >> /opt/sce_asp_scriptcase/seguridad/PAQUETE_ENVIO_ATDT_IDOR/04_Anexos/EVIDENCIAS/alertas_sc_log_cron.log 2>&1
```

## 5) Parametros ajustables

Variables de entorno soportadas:

- `WINDOW_MIN` (default `5`)
- `TH_LOGIN_FAIL` (default `10`)
- `TH_ENUM_APPS` (default `20`)
- `ALERT_LOG` (ruta de salida principal)

Ejemplo:

```bash
WINDOW_MIN=10 TH_LOGIN_FAIL=15 TH_ENUM_APPS=25 \
"/opt/sce_asp_scriptcase/seguridad/PAQUETE_ENVIO_ATDT_IDOR/99_Referencias/alertas_sc_log.sh"
```

## 6) Evidencia para Anexo H (cierre E3)

Capturas sugeridas:

1. `crontab -l` con entrada activa.
2. Ejecucion manual del script con timestamp.
3. Contenido de `alertas_sc_log_runtime.log`.
4. Una corrida de prueba que dispare al menos una alerta controlada.

## 7) Nota de cumplimiento

Esta implementacion cubre el requisito E3 (alertamiento operativo automatizado).
Para cumplimiento institucional completo, conservar evidencia periodica y bitacoras
de ejecucion junto con responsables/fechas de revision.
