# Inventario ATDT — Tabla de las 3 filas (Excel) + plan de revisión con documentación del repo

Las **3 filas** van en la hoja **`Inventario_Sistemas`** del archivo `Instrumento_Institucional_Inventario_APF.xlsx` (mismas columnas en cada fila; los **Score** suelen ser fórmulas del libro).

La lista detallada de los 72 campos sigue en: `LISTA_CAMPOS_INSTRUMENTO_INV_APF_PARA_IA.md`.

---

## 1. Tabla: las tres filas a inventariar

| Fila (orden sugerido) | Nombre corto / código | Nombre para columna *Nombre oficial del sistema* (propuesta) | *Acrónimo* | *Tipo de sistema* (según instrumento) | *Base de datos* (nombre) | URL de producción (documentada en repo) | Documentación principal en este repositorio |
|----------------------|------------------------|-------------------------------------------------------------|------------|----------------------------------------|---------------------------|----------------------------------------|---------------------------------------------|
| 1 | **SCE** | Sistema de Control Escolar (posgrado INECOL) | SCE | Web (ScriptCase / PHP) | `sce` (MySQL) | `https://posgrados.inecol.mx/sce/` | `seguridad/PAQUETE_ENVIO_ATDT_IDOR/02_Checklist_por_Sistema/CHECKLIST_SCE.md`, `seguridad/EVIDENCIA_IDOR_SCE.md`, `seguridad/ANALISIS_SEGURIDAD_SCE_SCE_ASP_SCE_ENBC.md` |
| 2 | **SCE_ASP** | Subsistema de aspirantes al posgrado (SCE_ASP) | SCE_ASP | Web (ScriptCase / PHP) | `sce_asp` (MySQL) | `https://posgrados.inecol.mx/sce_asp/` | `README_BD_SCE_ASP.md`, `CHECKLIST_SCE_ASP.md` (misma carpeta de checklists), `EVIDENCIA_IDOR_SCE_ASP.md`, `ANALISIS_SEGURIDAD_…` |
| 3 | **SCE_ENBC** | Subsistema ENBC (programa 9 / aspirantes ENBC) | SCE_ENBC | Web (ScriptCase / PHP) | `sce_enbc` (MySQL) | `https://posgrados.inecol.mx/sce_enbc/` | `CHECKLIST_SCE_ENBC.md`, `EVIDENCIA_IDOR_SCE_ENBC.md`, `ANALISIS_SEGURIDAD_…` |

**Notas para llenado:**

- En `ANALISIS_SEGURIDAD_SCE_SCE_ASP_SCE_ENBC.md` se aclara que **sce_enbc** es sobre todo **BD** consumida desde **sce** para el menú EBC; en el paquete IDOR también se documenta **URL** `…/sce_enbc/`. En el Excel define **un sistema por fila**: usa el criterio institucional (¿una fila “aplicación web ENBC” o enfatizar BD?). Si dudas, alinea con **RIC/UTIC**.
- **Usuarios activos (campo 56):** en `CHECKLIST_SCE.md` figura cifra de usuarios SCE (orden de magnitud); confirma en producción/IAM si el instrumento pide número exacto y fecha de corte.
- **Dependencia / Entidad, Unidad responsable, Función institucional, Clasificación (Crítico/Alto/…):** suelen salir de **normativa o directorio institucional**, no solo del repo técnico. Completar con **área de negocio** o **oficios internos**.

---

## 2. Plan de revisión (por bloques de campos y documentos)

Objetivo: recorrer **toda la documentación útil del repo** y anotar evidencias por **fila** (SCE / SCE_ASP / SCE_ENBC) antes de pasar valores al Excel.

### Fase 0 — Preparación (30–60 min)

| Paso | Qué hacer |
|------|-----------|
| 0.1 | Abrir el Excel oficial y la hoja **Catálogos** para respetar listas (Sí/No, tipos, etc.). |
| 0.2 | Crear una hoja de trabajo (puede ser copia local) con **3 filas** ya rotuladas como en la tabla de arriba. |
| 0.3 | Tener a mano `LISTA_CAMPOS_INSTRUMENTO_INV_APF_PARA_IA.md` como checklist de los 72 campos. |

### Fase 1 — Identidad y alcance del sistema (campos ~1–9, 56–59)

| Documento / fuente | Qué extraer |
|--------------------|------------|
| Tabla de la sección 1 de **este archivo** | Códigos, URLs, nombres, BD. |
| `CHECKLIST_SCE.md`, `CHECKLIST_SCE_ASP.md`, `CHECKLIST_SCE_ENBC.md` | Plataforma (ScriptCase 9, PHP, Apache, MySQL), contexto de uso. |
| `ANALISIS_SEGURIDAD_SCE_SCE_ASP_SCE_ENBC.md` | Descripción funcional (quién usa qué: estudiantes, aspirantes, EBC). |
| **Fuera del repo (obligatorio si aplica)** | Dependencia oficial, unidad responsable, función institucional, **clasificación de criticidad** institucional. |

**Salida:** borrador de columnas 1–9; para 56–59 (usuarios, revisiones de acceso) marcar “confirmar con ID/operaciones” si no hay cifra auditada.

### Fase 2 — Stack tecnológico y versiones (campos ~10–23, 19–22 open source / EOL)

| Documento / fuente | Qué extraer |
|--------------------|------------|
| `README_BD_SCE_ASP.md` | Motores MySQL, charsets, tablas, **aproximación** a versiones de BD (confirmar `SELECT VERSION()` en prod). |
| `ANALISIS_SEGURIDAD_…` | Lenguaje PHP, ScriptCase, patrones de login, riesgos (útil para contexto, no siempre versión exacta). |
| Código bajo `scriptcase/apps_sce_asp/…` (si aplica al despliegue) | Nombres de apps; para **framework** suele ser ScriptCase/PHP — validar versión PHP y SC en servidor. |
| **Servidor (primaria)** | Versiones reales de SO, Apache, PHP, MySQL/MariaDB, OpenSSL: **documentación de infra** o inventario de CMDB; el repo solo da pistas. |

**Salida:** lista de componentes con versión o **“Por confirmar”**; listado open source (campo 20) a partir de stack conocido (PHP, MySQL, librerías del proyecto).

### Fase 3 — Exposición, red y correo (campos ~24–35, 30–33)

| Documento / fuente | Qué extraer |
|--------------------|------------|
| `seguridad/PAQUETE_ENVIO_ATDT_IDOR/04_Anexos/EVIDENCIAS/_g_evidence_src/g_c3_tls_sce.html`, `g_c4_tls_sce_asp.html`, `g_c5_tls_sce_enbc.html` | Evidencia TLS/navegador por sistema (útil para SSL, URL pública). |
| `seguridad/PAQUETE_ENVIO_ATDT_IDOR/INFORME_MAESTRO_ATDT_IDOR_PARA_WORD.md` | Narrativa de controles, URLs, contexto de seguridad (buscar “sce”, “sce_asp”, “enbc”). |
| **Equipo de red / seguridad perimetral** | WAF, CDN, IP públicas, puertos, exposición a Internet (campos 26–27, 34–35). |

### Fase 4 — Infraestructura y continuidad (campos ~40–51)

| Documento / fuente | Qué extraer |
|--------------------|------------|
| `respaldos bd/README.md` | Procedimiento de **mysqldump** de `sce`, `sce_asp`, `sce_enbc` (sustenta “¿hay respaldo?” y frecuencia **si** está automatizado en cron — verificar en ops). |
| **Infra / CPD / nube** | On-prem vs nube, proveedor, segmentación, RTO/RPO oficiales (el repo no suele tener SLAs firmados). |

### Fase 5 — Identidad, privilegios y monitoreo (campos ~52–68)

| Documento / fuente | Qué extraer |
|--------------------|------------|
| `CHECKLIST_*.md` (secciones A–D) | RBAC por `sec_*_groups_apps`, uso de sesión vs parámetros, pruebas negativas. |
| `EVIDENCIA_IDOR_*.md` | Detalle por sistema coherente con el checklist. |
| `ANALISIS_SEGURIDAD_…` | MFA, contraseñas, IDOR, logs (indica **gaps** para campos “¿tiene MFA?”, PAM, EDR, SIEM, SOC, pentest). |
| `README_LOGS.md` | Dónde y cómo se registran logs en desarrollo; **producción** debe confirmarse con operaciones. |

**Salida:** muchos campos pueden quedar en **No** o **Por confirmar** si no hay contrato SOC/SIEM; es válido si es veraz y alineado al instructivo.

### Fase 6 — Cierre del inventario (campos ~69–72 y revisión cruzada)

| Paso | Qué hacer |
|------|-----------|
| 6.1 | Verificar que **fórmulas** de Score / Nivel de riesgo se recalculen; no sobrescribir si el libro las trae. |
| 6.2 | **Declaratoria de veracidad (72):** solo tras revisión del **RIC** o quien corresponda. |
| 6.3 | Cruzar las **3 filas** entre sí: dependencias entre BD (`sce_asp` ↔ `sce` en `README_BD_SCE_ASP.md`) para describir bien “infra compartida” o acoplamientos (campo 42 y notas internas). |

### Fase 7 — Entrega ATDT (fuera del llenado celda a celda)

- Validación interna, cifrado con PGP DGCiber, firma RIC (ver `REQUERIMIENTO_ATDT_INVENTARIO_APF_CONSOLIDADO.md`).

---

## 3. Lista corta de rutas del repo (checklist de lectura)

Marca al revisar:

- [ ] `seguridad/ANALISIS_SEGURIDAD_SCE_SCE_ASP_SCE_ENBC.md`
- [ ] `seguridad/PAQUETE_ENVIO_ATDT_IDOR/02_Checklist_por_Sistema/CHECKLIST_SCE.md`
- [ ] `seguridad/PAQUETE_ENVIO_ATDT_IDOR/02_Checklist_por_Sistema/CHECKLIST_SCE_ASP.md`
- [ ] `seguridad/PAQUETE_ENVIO_ATDT_IDOR/02_Checklist_por_Sistema/CHECKLIST_SCE_ENBC.md`
- [ ] `seguridad/EVIDENCIA_IDOR_SCE.md`
- [ ] `seguridad/EVIDENCIA_IDOR_SCE_ASP.md`
- [ ] `seguridad/EVIDENCIA_IDOR_SCE_ENBC.md`
- [ ] `README_BD_SCE_ASP.md`
- [ ] `respaldos bd/README.md`
- [ ] `seguridad/PAQUETE_ENVIO_ATDT_IDOR/INFORME_MAESTRO_ATDT_IDOR_PARA_WORD.md` (búsqueda por sistema)
- [ ] Evidencias TLS HTML: `…/EVIDENCIAS/_g_evidence_src/g_c3_tls_sce.html`, `g_c4_tls_sce_asp.html`, `g_c5_tls_sce_enbc.html`
- [ ] `README_LOGS.md` (opcional, contexto de logging)

---

*Documento de trabajo. Las URLs y nombres reflejan lo documentado en el repositorio; la versión contractual u oficial de cada sistema la debe validar la entidad.*

---

## Entregables actualizados (recolección en servidor)

- Respuestas en JSON (72 campos × 3 sistemas) con trazabilidad: [inventario_ATDT_3_sistemas_respuestas.json](inventario_ATDT_3_sistemas_respuestas.json) (`meta.recoleccion`).
- Script de recolección repetible (sin secretos en repo): [recolecta_inventario_servidor.sh](recolecta_inventario_servidor.sh). Para volcar al **Excel oficial**, copiar celda a celda desde el JSON o importar con una herramienta que respete las listas del libro; no modificar columnas del `.xlsx`.
