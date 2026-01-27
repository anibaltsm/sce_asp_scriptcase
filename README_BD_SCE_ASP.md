# Análisis de la base de datos `sce_asp`

**Documento para consulta por IA.** Contiene estructura, tablas, vistas, relaciones y convenciones de la BD de **aspirantes al posgrado** (INECOL / sistema SCE). Usar este README como fuente de verdad al generar consultas SQL, migraciones o documentación sobre `sce_asp`.

---

## 1. Conexión y entorno

- **Base de datos:** `sce_asp`
- **MySQL:** XAMPP/LAMPP (`/opt/lampp/bin/mysql`)
- **Ejemplo de conexión:**
  ```bash
  /opt/lampp/bin/mysql -u root -p<contraseña> sce_asp -e "SHOW TABLES;"
  ```

---

## 2. Resumen ejecutivo

| Concepto | Valor |
|----------|--------|
| **Tablas base** | ~90 |
| **Vistas** | ~20 |
| **Motores** | MyISAM (mayoría), InnoDB (tablas recientes, seguridad, algunas operativas) |
| **Charsets** | utf8 / utf8mb4 / latin1 (legado) |
| **Uso** | Gestión de aspirantes, requisitos, estados de solicitud, entrevistas, cuestionarios, revisión de desempeño, usuarios y permisos |

La BD contiene **historiales por generación/año** (tablas `*_2020`, `*_2021`, …, `*_2025`) y numerosas **copias/respaldos** (`*_copy`, `*_copy1`, `*_ant`, etc.). Las tablas “activas” suelen ser las **sin sufijo** o las del **año en curso**.

---

## 3. Dependencias externas: base de datos `sce`

Varias **vistas y lógica** de `sce_asp` dependen de la BD **`sce`**:

| Recurso en `sce` | Uso en `sce_asp` |
|------------------|-------------------|
| `sce.persacadposg` | Tutores / profesores; `aspirantes.id_persacad_posg_FK` → `id_persacadposg` |
| `sce.programas` | Programas de posgrado; `aspirantes.id_prog_FK` → `id_prog`; ej. `abreviatura` |
| `sce.pagos` | Vista `pagos` en `sce_asp` es un alias de `sce.pagos` |

**Vistas que usan `sce`:**
- `vw_aspirante_tutor`: `sce_asp.aspirantes` + `sce.persacadposg` + `sce.programas` + `sce_asp.asp_estados_sol`
- `pagos`: definida sobre `sce.pagos`

---

## 4. Tablas principales (operativas, sin sufijo de año/copia)

### 4.1 Aspirantes y estados

| Tabla | Filas (aprox.) | Descripción |
|-------|----------------|-------------|
| **aspirantes** | 1 257 | Registro de aspirantes al posgrado. PK: `id_asp`. |
| **asp_estados_sol** | 5 203 | Estados de la solicitud por aspirante. PK: `id_asp_edo_sol`. FK: `id_asp_FK`, `id_tip_edo_FK`. |
| **asp_requisitos** | 17 965 | Requisitos documentales por aspirante. PK: `id_asp_req`. FK: `id_asp_FK`, `id_lisreq_FK`. |
| **asp_recomendantes** | 6 | Relación aspirante ↔ recomendante. FK: `id_asp_FK`, `id_recom_FK`. |
| **recomendantes** | 3 | Catálogo de recomendantes (nombre, apellidos, correo). PK: `id_recom`. |

### 4.2 Grupos, entrevistas y evaluación

| Tabla | Filas (aprox.) | Descripción |
|-------|----------------|-------------|
| **grupos** | 5 | Grupos de evaluación (Grupo 1 … Grupo 5). PK: `id_grupo`. |
| **gpos_asps** | 69 | Asignación aspirante ↔ grupo. FK: `id_grupo_FK`, `id_asp_FK`. |
| **gpos_entrev** | 58 | Asignación entrevistador ↔ grupo. FK: `id_entrevistador_FK`, `id_grupo_FK`. |
| **entrevistadores** | 141 | Evaluadores/oral. PK: `id_entrevistador`. FK: `login_FK` → `sec_asp_users`. |
| **observadores** | 22 | Observadores de exámenes. PK: `id_observador`. |
| **observ_examen** | 151 | Asignación aspirante ↔ observador. FK: `id_asp_FK`, `id_observador_FK`. |
| **rev_desem** | 50 | Revisión de desempeño (entrevista). FK: `id_asp_FK`, `id_grupo_FK`, `id_entrevistador_FK`. Campos `d1`…`d10`, `calif`, `com`, `notas`. |

### 4.3 Cuestionarios y encuestas

| Tabla | Filas (aprox.) | Descripción |
|-------|----------------|-------------|
| **cuestionarios_2024** | 259 | Cuestionarios de entrevista (ej. 2024). `id_asp_FK`, `id_entrevistador_FK`, `id_grupo_FK`, `p1`…`p12`, `pp1`…`pp12`, `califo`, `comentarios`. |
| **cuestionarios_mae_2025** | 250 | Cuestionarios maestría 2025. |
| **cuestionarios_doc_2025** | 95 | Cuestionarios doctorado 2025. |
| **entrev_cuestionarios** | 17 | Registro de cuestionarios de entrevista. FK: `id_asp_FK`, `id_entrevistador_FK`. |
| **encuestas_ceneval** | 962 | Encuestas CENEVAL. FK: `id_asp_FK`. |

### 4.4 Seguridad y auditoría

| Tabla | Filas (aprox.) | Descripción |
|-------|----------------|-------------|
| **sec_asp_users** | 1 279 | Usuarios. PK: `login`. Campos: `pswd`, `name`, `apat`, `amat`, `email`, `active`, `priv_admin`. |
| **sec_asp_groups** | 6 | Grupos de seguridad. PK: `group_id`. |
| **sec_asp_users_groups** | 1 276 | Usuario ↔ grupo. PK: (`login`, `group_id`). |
| **sec_asp_apps** | 210 | Aplicaciones/módulos. PK: `app_name`. |
| **sec_asp_groups_apps** | 1 150 | Permisos por grupo y app: `priv_access`, `priv_insert`, `priv_delete`, `priv_update`, `priv_export`, `priv_print`. |
| **sc_log** | 297 755 | Log de acciones (ScriptCase). `username`, `application`, `action`, `description`, `ip_user`, etc. |
| **usuarios** | 80 | Otro esquema de usuarios (nombre, apellidos, usuario, contraseña, `id_tipo_users`). PK: `id_user`. |

### 4.5 Otras tablas operativas

| Tabla | Descripción |
|-------|-------------|
| **asp_dt** | Director de tesis (vacía en muestreo). |
| **asp_emergencias** | Datos de emergencia (vacía). |
| **asp_respuestas_eval** | Respuestas de evaluación (vacía). |
| **users** | Usuarios adicionales (11 filas). |

---

## 5. Estructura detallada de tablas clave

### 5.1 `aspirantes`

- **PK:** `id_asp` (AUTO_INCREMENT).
- **Identificación y contacto:** `nombres`, `ap_pat`, `ap_mat`, `CURP`, `email`, `tel`, `cel`, `identificacion`, `foto`.
- **Derivados:** `completo_apnom`, `completo_nomap` (nombre formateado).
- **Programa y tutor:** `id_prog_FK` (→ `sce.programas`), `id_persacad_posg_FK` (→ `sce.persacadposg`), `id_lin_inv_FK`.
- **Generación y trámite:** `generacion`, `matric`, `inscrito`, `cc_finalizado`, `cc_conc_insc`, `firmado_asp`, `firmado_sp`.
- **Domicilio:** `direccion`, `col`, `municipio`, `ciudad`, `id_edos_rep_FK`, `id_nacionalidad_FK_1`, `cp`.
- **Nacimiento y otros:** `fec_nac`, `lugar_nac`, `id_edo_nac_FK`, `id_pais_FK`, `edo_civil`, `genero`, `tipo_sangre`, `alergias`, `padecimientos`, `capac_dif`.
- **Estudios:** `c_grado_FK`, `titulo_l`, `id_inst_lic_FK`, `promedio_lic`, `titulo_m`, `id_inst_mtr_FK`, `promedio_mas`, `cedula`, `cedula_m`, documentos (`*_doc`).
- **Exámenes:** `fecha_exani`, `folio_exani`, `lugar_exani`, `calif_exani`, `calif_ingles`, `calif_contec`, `calif_ingl_toefl`, `tipo_ex_ingles`.
- **Proyecto y CV:** `tit_proy`, `palabras_cve`, `cvu`, `motivos`, `trabaja_act`, `cc_egres_INECOL`.
- **Control y auditoría:** `login_FK` (→ `sec_asp_users`), `notas`, `notas_asp`, `notas_insc`, `login_insert`, `fecha_alta`, `ip_alta`, `login_last`, `fecha_ult_act`, `ip_last`, `examen_prob`, `notas_observador`.

### 5.2 `asp_estados_sol`

- **PK:** `id_asp_edo_sol`.
- **FK:** `id_asp_FK` → `aspirantes.id_asp`, `id_tip_edo_FK` (tipo de estado), `login_FK` (usuario que registra).
- **Auditoría:** `fecha_hora_reg`, `notas`, `login_insert`, `fecha_alta`, `ip_alta`, `login_last`, `fecha_ult_act`, `ip_last`.

**Valores observados de `id_tip_edo_FK`:** 1–11, 13–21, 23–24. Ejemplos de uso en vistas: **4** = estado asociado a “tutor” en `vw_aspirante_tutor`; **9** y **20** = aceptados para inscripción en `aceptados_inscripcion`.

### 5.3 `asp_requisitos`

- **PK:** `id_asp_req`.
- **FK:** `id_asp_FK` → `aspirantes`, `id_lisreq_FK` → lista de requisitos (catálogo en `sce` o similar), `login_FK`.
- **Documento:** `num_req`, `archivo`, `notas_aspirante`, `cc_correcto`, `notas_revisor`, `fecha_revision`, `notas_internas`, `id_carga_req`, `usu_carga_req`, `ip_revision`.
- **Auditoría:** `login_insert`, `fecha_alta`, `ip_alta`, `login_last`, `fecha_ult_act`, `ip_last`.

### 5.4 `asp_recomendantes` y `recomendantes`

- **asp_recomendantes:** une `id_asp_FK` con `id_recom_FK`. UK (`id_asp_FK`, `id_recom_FK`).
- **recomendantes:** `id_recom`, `id_persacadposg_FK`, `nombre`, `apellido_p`, `apellido_m`, `correo` (UNIQUE), `num_recom`.

### 5.5 `rev_desem` (revisión de desempeño)

- **PK:** `id_rev_des`.
- **FK:** `id_asp_FK`, `id_grupo_FK`, `id_entrevistador_FK`.
- **Criterios:** `d1`…`d10` (numéricos), `d4_revistas`, `d4_art_jcr`, `d4_art_otros`, `d4_divulga`, `d4_capitulos`, `d4_cap_internac`, `d4_cap_nac`, `d4_libros`, `d4_patentes`.
- **Resumen:** `calif`, `com`, `notas`.
- **Auditoría:** `login_insert`, `fecha_alta`, `ip_alta`, `login_last`, `fecha_ult_act`, `ip_last`.

Existen tablas análogas por año/programa: `rev_desem_2022`, `rev_desem_2023`, `rev_desem_2024`, `rev_desem_2024_doc`, `rev_desem_2025_dc_resp`, `rev_desem_2025_mc_resp`, `rev_desem_mae_2025`, `rev_desem_doc_2025`, etc.

### 5.6 `sec_asp_*`

- **sec_asp_users:** `login` (PK), `pswd`, `name`, `apat`, `amat`, `email`, `active`, `activation_code`, `priv_admin`, `com_apat`, `com_nom`, `ip_alta`, `fecha_alta`, `sp`.
- **sec_asp_groups:** `group_id` (PK), `description` (UNIQUE).
- **sec_asp_users_groups:** (`login`, `group_id`) PK; enlace usuario–grupo.
- **sec_asp_apps:** `app_name` (PK), `app_type`, `description`.
- **sec_asp_groups_apps:** (`group_id`, `app_name`) PK; permisos por app (`priv_*`).

---

## 6. Vistas principales

| Vista | Propósito |
|-------|-----------|
| **aceptados_inscripcion** | Aspirantes generación 2024 con estado 9 o 20 en `asp_estados_sol`. Campos: `id_asp`, `matric`, `inscrito`, `completo_apnom`, `completo_nomap`, `email`, `id_prog_FK`, `notas`, `id_tip_edo_FK`, `id_pais_FK`, `login_FK`. |
| **aceptados_inscripcion_2025** | Análoga para 2025. |
| **faltantes** | Cuestionarios maestría 2025 con datos de entrevistador y aspirante (`cuestionarios_mae_2025` + `entrevistadores` + `aspirantes`). |
| **faltantes_doctorado** | Similar para doctorado. |
| **pagos** | Alias de `sce.pagos` (pagos de aspirantes/inscripción). |
| **vw_aspirante_tutor** | Aspirante + tutor (`persacadposg`) + `abreviatura` del programa, solo `id_tip_edo_FK = 4`. |
| **vw_qry_calif_desempeno_dc_2022** | Calificaciones de desempeño doctorado 2022 (`rev_desem_2022` + `aspirantes` + `entrevistadores`). |
| **vw_qry_calif_desempeno_dc_2023** | Idem doctorado 2023. |
| **vw_qry_calif_desempeno_dc_2024** | Idem 2024 (usa `rev_desem_2023`). |
| **vw_qry_calif_desempeno_doc_2024** | Desempeño doctorado 2024 con `rev_desem_2024_doc`. |
| **vw_qry_calif_desempeno_doc_2025** | Desempeño doctorado 2025. |
| **vw_qry_calif_desempeno_mae_2024** | Desempeño maestría 2024. |
| **vw_qry_calif_desempeno_mae_2025** | Desempeño maestría 2025. |
| **vw_qry_calif_desempeno_mc_2022** … **mc_2024** | Desempeño maestría por año. |
| **vw_res_eval_aptitudes_doc_2025** | Resultados evaluación de aptitudes doctorado 2025. |
| **vw_res_eval_aptitudes_mae_2025** | Idem maestría 2025. |

---

## 7. Relaciones y claves foráneas (lógicas)

- **aspirantes** ← `asp_estados_sol`, `asp_requisitos`, `asp_recomendantes`, `gpos_asps`, `observ_examen`, `rev_desem`, cuestionarios, encuestas (vía `id_asp_FK`).
- **aspirantes** → `sce.programas` (`id_prog_FK`), `sce.persacadposg` (`id_persacad_posg_FK`), `sec_asp_users` (`login_FK`).
- **asp_requisitos** → `id_lisreq_FK` (catálogo en `sce` u otro esquema).
- **recomendantes** ← `asp_recomendantes`; opcionalmente `sce.persacadposg` vía `id_persacadposg_FK`.
- **grupos** ← `gpos_asps`, `gpos_entrev`.
- **entrevistadores** ← `gpos_entrev`, `rev_desem`, cuestionarios; → `sec_asp_users` (`login_FK`).
- **observadores** ← `observ_examen`.

No hay FKs físicas en la mayoría de tablas MyISAM; las relaciones se mantienen por convención de nombres `id_*_FK`.

---

## 8. Convenciones de nombres

- **PK:** `id_<tabla>` o `id_<tabla>_<sufijo>` (ej. `id_asp`, `id_asp_edo_sol`).
- **FK:** `id_<tabla>_FK` (ej. `id_asp_FK`, `id_prog_FK`, `id_grupo_FK`).
- **Control/banderas:** prefijo `cc_` (ej. `cc_finalizado`, `cc_conc_insc`, `cc_correcto`).
- **Auditoría:** `login_insert`, `fecha_alta`, `ip_alta`, `login_last`, `fecha_ult_act`, `ip_last`.
- **Tablas por año:** `*_2020` … `*_2025`.
- **Copias/respaldos:** `*_copy`, `*_copy1`, `*_ant`, `*_respaldo`, etc.

---

## 9. Catálogos y códigos

- **id_prog_FK:** En `aspirantes`, valores 7 y 8 observados (programas en `sce.programas`). 7 = doctorado, 8 = maestría (confirmar en `sce`).
- **id_tip_edo_FK:** Estados de solicitud. 4 = usado en “aspirante–tutor”; 9 y 20 = aceptados inscripción.
- **id_grupo:** 1–5 corresponden a “Grupo 1” … “Grupo 5”.

---

## 10. Tablas por generación/año y respaldos

Se usan tablas duplicadas por **generación** (ej. `aspirantes_2024`, `aspirantes_2025`) y por **respaldos** (`*_copy`, `*_07062022`, etc.). Para reportes o desarrollo:

- Usar **tablas sin sufijo** o **sufijo del año vigente** según el módulo.
- Las vistas `vw_qry_calif_desempeno_*` y `*_2025` indican qué tablas por año se usan en cada caso.

---

## 11. Glosario breve para IA

| Término | Significado |
|--------|-------------|
| **asp** | Aspirante |
| **edo_sol** | Estado de solicitud |
| **lisreq** | Lista de requisitos (catálogo) |
| **rev_desem** | Revisión de desempeño (entrevista) |
| **gpos** | Grupos |
| **entrev** | Entrevista / entrevistador |
| **dc** | Doctorado (en vistas) |
| **mae** | Maestría |
| **mc** | Maestría (en vistas de calificación) |
| **doc** | Doctorado (en tablas/vistas) |
| **cc_** | Campo de control / bandera |
| **FK** | Clave foránea (por convención) |

---

*Análisis generado a partir de inspección de la BD `sce_asp` (MySQL). Última actualización: enero 2026.*
