# Nomenclatura de archivos de comprobantes de pago

Documento de referencia para la convención de nombres de los archivos de comprobantes de pago (formulario de pagos, aplicación ScriptCase).

---

## 1. Carpeta de pagos (origen)

**Ruta base:** `.../doc/pagos/[generacion]/` (sin subcarpeta por usuario)

El comprobante se guarda **solo** en `pagos/[generacion]/`. Para que ScriptCase suba el archivo ahí, en el formulario el campo del archivo (doc_compr_pago) debe tener:

- **Subdirectorio para almacenamiento local:** `pagos/[generacion]`  
  (no usar `pagos/[generacion]/[usr_login]`).

**Formato del nombre del archivo:**
```text
[referencia]_[prefijo_requisito].[ext]
```

| Parte              | Origen                    | Ejemplo           |
|--------------------|---------------------------|-------------------|
| referencia         | Campo de `sce.pagos`      | INECOLPA0002127800 |
| prefijo_requisito   | `list_req_gral.prefijo_requisito` (requisito de pago de la convocatoria activa) | comp_pago |
| ext                | Extensión del archivo subido | pdf |

**Ejemplo:** `INECOLPA0002127800_comp_pago.pdf`

- La **referencia** se genera al crear el pago (alta de aspirante o creación de referencia) con el formato: `INECOLPA0002` + id del aspirante (sin ceros a la izquierda) + `00`.

---

## 2. Carpeta de aspirantes (copia para requisitos)

**Ruta base:** `.../doc/aspirantes/[generacion]/[usr_login]/`

**Formato del nombre del archivo:**
```text
[generacion]_[id_asp]_[num_req]_[prefijo_requisito].[ext]
```

| Parte              | Origen                    | Ejemplo    |
|--------------------|----------------------------|------------|
| generacion         | Variable de sesión / año  | 2026       |
| id_asp            | Id del aspirante (`sce.pagos.id_asp_FK`) | 1278       |
| num_req           | Número de requisito, mínimo 2 dígitos (list_req_gral) | 08 |
| prefijo_requisito  | Mismo que en carpeta pagos | comp_pago  |
| ext               | Extensión del archivo      | pdf        |

**Ejemplo:** `2026_1278_08_comp_pago.pdf`

Este mismo nombre se guarda en la base de datos en `sce_asp.asp_requisitos.archivo` para el requisito de pago del aspirante.

---

---

## 3. CSF (Constancia de Situación Fiscal)

El archivo `doc_csf` sigue el **mismo flujo** que el comprobante de pago pero con sufijo fijo `csf`.

### 3.1 Carpeta de pagos (sce_asp y sce)

**Rutas:**
- `sce_asp/_lib/file/doc/pagos/[generacion]/` — upload original y archivo normalizado (sirve `form_pagos`)
- `sce/_lib/file/doc/pagos/[generacion]/` — copia para tesorería y otras apps (ej. `grid_pagos`)

**Formato del nombre:**
```text
[referencia]_csf.[ext]
```

**Ejemplo:** `INECOLPA0002127600_csf.pdf`

### 3.2 Carpeta de aspirantes (copia en sce_asp)

**Ruta base:** `sce_asp/_lib/file/doc/aspirantes/[generacion]/[usr_login]/`

**Formato del nombre:**
```text
[generacion]_[id_asp]_[num_req]_csf.[ext]
```

**Ejemplo:** `2026_1276_09_csf.pdf`

> `num_req` se obtiene de `list_req_gral` filtrando `prefijo_requisito = 'csf'` en la convocatoria activa.

### 3.3 Campos de BD actualizados

| Tabla | Campo | Valor guardado |
|-------|-------|----------------|
| `sce.pagos` | `doc_csf` | `INECOLPA0002127600_csf.pdf` |
| `sce_asp.asp_requisitos` | `archivo` | `2026_1276_09_csf.pdf` |

---

## 4. Resumen rápido

| Tipo       | Ubicación     | Patrón del nombre                                         | Ejemplo                              |
|------------|---------------|-----------------------------------------------------------|--------------------------------------|
| Comprobante| Pagos         | `referencia_prefijo_requisito.ext`                        | INECOLPA0002127800_comp_pago.pdf     |
| Comprobante| Aspirantes    | `generacion_id_asp_num_req_prefijo_requisito.ext`         | 2026_1278_08_comp_pago.pdf           |
| CSF        | Pagos         | `referencia_csf.ext`                                      | INECOLPA0002127600_csf.pdf           |
| CSF        | Aspirantes    | `generacion_id_asp_num_req_csf.ext`                       | 2026_1276_09_csf.pdf                 |

---

## 5. Origen de los datos

- **referencia:** Campo en `sce.pagos`; se asigna al crear el pago (app alta de aspirante o app crear referencia).
- **generacion:** Variable de sesión (ej. año de la convocatoria).
- **usr_login:** Variable de sesión (login del aspirante); se usa para la carpeta de **aspirantes** y para el UPDATE en `asp_requisitos`. En la carpeta **pagos** no se usa subcarpeta por usuario.
- **id_asp:** Id del aspirante, campo `id_asp_FK` en `sce.pagos`.
- **prefijo_requisito:** Definido en `list_req_gral` para el requisito de tipo pago de la convocatoria activa (ej. `comp_pago`).
- **prefijo CSF:** Fijo `csf`; el `num_req` se obtiene de `list_req_gral` donde `prefijo_requisito = 'csf'` y `cc_activa = 1`.

---

*Actualizado según método `chg_filename` del formulario de pagos.*
