# Diferencias de tablas: BD sce en Windows vs Linux

Conexiones usadas para la comparación:

- **Windows:** `mysql -h 192.168.2.68 -u monica -p515t3ma5 sce`
- **Linux:** `mysql -u root -p515t3ma5 sce` (localhost)

---

## Tablas que solo existen en WINDOWS (10)

| Tabla |
|-------|
| comite_tutorial_al31102025 |
| ct_dict_al31102025 |
| ct_dict_copy2 |
| ct_miembros_al31102025 |
| estudiantes_19ene2026 |
| list_req_gral_respaldo |
| tesis_19ene2026 |
| vw_asp_excontec_resp |
| vw_historial_acad_todos |
| vw_tesis_directores_psa |

---

## Tablas que solo existen en LINUX (13)

| Tabla |
|-------|
| convocatorias_posg_26_02_2026 |
| list_req_gral_26_02_2026_resp |
| list_req_gral_29 |
| pagos_respaldo |
| resultados |
| **sec_settings** |
| tesis_definitiva |
| tesis_scriptcase |
| vista_directores_tesis_v2 |
| vw_dictamenes_detallados |
| vw_estado_comite_completo |
| vw_estudiantes-lin-investigacion |
| vw_miembros_detallados |

---

## Notas

- **sec_settings:** Solo en Linux. Puede ser tabla de configuración del módulo de seguridad de ScriptCase (opciones editables por el administrador). Si la app en Linux depende de ella, en Windows podría faltar o usarse otra vía.
- El resto son tablas/vistas de aplicación o respaldos con nombres con fecha o sufijos distintos en cada entorno.
- Las tablas de seguridad principales (**sec_users**, **sec_groups**, **sec_groups_apps**, **sec_users_groups**, **sec_logged**, **sec_apps**) existen en ambos servidores; solo **sec_settings** es exclusiva de Linux.

---

## Diferencias en número de registros (COUNT por tabla)

Para tablas que **existen en ambos** servidores, el número de registros puede no coincidir (Windows suele tener más datos por ser el origen operativo).

### Tablas de seguridad (sec_*)

| Tabla            | Windows | Linux | Nota      |
|------------------|--------:|------:|-----------|
| sec_apps         |     982 |   955 | Diferente |
| sec_groups       |      11 |    11 | Igual     |
| sec_groups_apps  |   9 615 | 9 318 | Diferente |
| sec_logged       |  13 142 |11 614 | Diferente |
| sec_users       |   2 383 | 2 164 | Diferente |
| sec_users_groups |   2 383 | 2 214 | Diferente |

### Otras tablas críticas (ejemplo)

| Tabla        | Windows | Linux | Nota      |
|--------------|--------:|------:|-----------|
| aspirantes   |     599 |   587 | Diferente |
| estudiantes  |   1 212 | 1 212 | Igual     |
| pagos        |      23 |    13 | Diferente |
| tesis        |   1 481 | 1 379 | Diferente |
| convenios    |     324 |   324 | Igual     |
| programas    |      10 |     9 | Diferente |
| persacadposg |   2 200 | 2 165 | Diferente |

### Comparación completa de registros

Para generar un listado de **todas** las tablas comunes con distinto `COUNT(*)`:

```bash
cd /opt/sce_asp_scriptcase
chmod +x scripts/comparar_registros_win_lin.sh
./scripts/comparar_registros_win_lin.sh
```

El resultado se escribe en `docs/diferencias_registros_win_lin.txt`. La ejecución puede tardar varios minutos (latencia a 192.168.2.68).

Fecha de comparación: 2026-03-08.
