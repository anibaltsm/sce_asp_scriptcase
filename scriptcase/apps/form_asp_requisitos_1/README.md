# form_asp_requisitos_1

@scriptcase form_asp_requisitos_1

- **Scriptcase:** v9 | **PHP:** 8.1
- **Tabla principal:** `sce_asp.asp_requisitos`
- **Campo archivo:** tipo Document (PDF). Subdirectorio configurado en ScriptCase: `cartas/`.

Formulario para que el aspirante suba sus **requisitos** (PDFs, cartas, etc.). Al guardar, el archivo se mueve de `cartas/` (carpeta temporal de ScriptCase) a `aspirantes/[generacion]/[usr_login]/` con nombre normalizado y se actualiza el campo `archivo` en BD.

Sigue el mismo patrón que `chg_filename` en `form_pagos`.

---

## Nomenclatura del archivo

```text
[generacion]_[id_asp]_[num_req]_[prefijo_requisito].[ext]
```

| Parte            | Origen                                         | Ejemplo  |
|-----------------|------------------------------------------------|----------|
| generacion       | Variable de sesión `[generacion]`             | 2026     |
| id_asp           | Campo `{id_asp_FK}` del registro              | 1278     |
| num_req          | Campo `{num_req}` sin ceros a la izquierda    | 8        |
| prefijo_requisito| Campo `{prefijo_requisito}` del registro; si está vacío se consulta de `sce.list_req_gral` | ident |
| ext              | Extensión del archivo subido                  | pdf      |

**Ejemplo:** `2026_1278_8_ident.pdf`

---

## Configuración del campo `archivo` en ScriptCase

**Subdirectorio para almacenamiento local:** `cartas/[generacion]`

ScriptCase crea la carpeta `cartas/[generacion]/` automáticamente y deposita el archivo subido ahí.
La subcarpeta por aspirante (`aspirantes/[generacion]/[correo_asp]/`) la crea `OnAfterUpdate` en el código.

> **Importante:** NO usar `[usr_login]` en el subdirectorio porque ese es el usuario logueado,
> que puede ser el recomendante u otro rol. El correo del aspirante se lee de `{login_FK}` del registro.

## Eventos

### OnBeforeUpdate
Crea la carpeta `cartas/` si no existe (solo necesario con Opción A). Con Opción B ScriptCase crea la carpeta automáticamente y este evento sobra.

### OnAfterUpdate
1. Valida que hay archivo subido.
2. Obtiene `prefijo_requisito` del registro (o desde `sce.list_req_gral` si está vacío).
3. Construye el nombre final.
4. Localiza el archivo en `cartas/` (hasta 3 intentos con 1 s de espera si ScriptCase lo escribe después del evento).
5. Crea la carpeta destino en `aspirantes/` si no existe (multiplataforma con `mkdir` de PHP).
6. **Mueve** el archivo de `cartas/` a `aspirantes/[generacion]/[usr_login]/`.
7. Actualiza `asp_requisitos.archivo` con el nombre final.

---

## Rutas

Ambas rutas usan `$_SERVER['DOCUMENT_ROOT']` (funciona en macOS, Linux y Windows sin rutas hardcodeadas).

| Carpeta | Ruta                                                              | Función              |
|---------|-------------------------------------------------------------------|----------------------|
| cartas/ | `DOCUMENT_ROOT/sce_asp/_lib/file/doc/cartas/`                     | Temporal (ScriptCase) |
| aspirantes/ | `DOCUMENT_ROOT/sce_asp/_lib/file/doc/aspirantes/[gen]/[login]/` | Destino final        |

---

## Logs

Ver `README_LOGS.md` en la raíz del proyecto. Prefijo de los mensajes: `form_asp_requisitos_1 OnAfterUpdate:`.

Secuencia esperada en el log al subir un archivo:
```
form_asp_requisitos_1 OnAfterUpdate: INICIO id_asp_req=... archivo=...
form_asp_requisitos_1 OnAfterUpdate: id_asp=... num_req=... num_req_short=... prefijo=... ext=...
form_asp_requisitos_1 OnAfterUpdate: nombre_pdf=... destino=...
form_asp_requisitos_1 OnAfterUpdate: archivo encontrado en .../cartas/...
form_asp_requisitos_1 OnAfterUpdate: carpeta creada .../aspirantes/.../  (solo la primera vez)
form_asp_requisitos_1 OnAfterUpdate: move OK -> 2026_1278_8_ident.pdf
form_asp_requisitos_1 OnAfterUpdate: FIN - asp_requisitos actualizado id_asp_req=...
```
