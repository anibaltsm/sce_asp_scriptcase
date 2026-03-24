# Mapeo de 12 requerimientos institucionales ATDT — IDOR/BOLA

## Trazabilidad requerimiento -> evidencia

| # | Requerimiento ATDT | SCE | SCE_ASP | SCE_ENBC | Evidencia primaria | Anexo |
|---|---|---|---|---|---|---|
| 1 | Control de acceso a nivel de objeto | Cumple | Cumple | Cumple | onValidateSuccess/sc_validate_success + sec_*_groups_apps | A, B, D |
| 2 | Revision de servicios expuestos | Cumple | Cumple | Cumple | Inventario de URLs y apps activas | C |
| 3 | Validacion explicita de autorizacion por solicitud | Cumple | Cumple | Cumple | Vinculo por login_FK + variables de sesion | B |
| 4 | Autorizacion independiente de autenticacion | Cumple | Cumple | Cumple | Modelo grupo->app->permisos | A, D |
| 5 | Controles uniformes en endpoints/metodos/versiones | Cumple | Cumple | Cumple | sc_apl_conf uniforme por app/grupo | B |
| 6 | Pruebas negativas de acceso no autorizado | Cumple | Cumple | Cumple | Evidencia operativa minima por sistema | E |
| 7 | Evitar referencias directas inseguras | Cumple | Cumple | Cumple | Validacion por sesion y pertenencia | B |
| 8 | Controles centralizados y reutilizables | Cumple | Cumple | Cumple | Punto unico de autorizacion en login | A, B |
| 9 | Retiro/aislamiento de servicios innecesarios | Cumple | Cumple | Cumple | Inventario + evidencia A/B/C + acta de gobernanza | C, H |
| 10 | Control en consulta/modificacion/descarga/eliminacion | Cumple | Cumple | Cumple | Permisos CRUD/export/print por grupo | B, D |
| 11 | Monitoreo de accesos anomalos | Cumple | Cumple | Cumple | sc_log + script de alertas + cron operativo en servidor | F, H |
| 12 | Rotacion/reinicio de credenciales | Cumple | Cumple | Cumple | app_change_pswd/app_retrieve_pswd + logs | F |

## Resumen por sistema

| Sistema | Cumple | En proceso | No cumple |
|---|---:|---:|---:|
| SCE | 12 | 0 | 0 |
| SCE_ASP | 12 | 0 | 0 |
| SCE_ENBC | 12 | 0 | 0 |
