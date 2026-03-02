# Diagnóstico: "Column 'correo' cannot be null" en app_form_add_users

**Error mostrado:**  
*Se produjo un error al acceder a la base de datos. Column 'correo' cannot be null*

**SQL que falla:**  
`INSERT INTO recomendantes (id_recom, nombre, apellido_p, apellido_m, correo, num_recom, login_FK) VALUES (9, NULL, NULL, NULL, NULL, 1, 'anibal.sanchez+999@inecol.mx')`

**Fecha diagnóstico:** Feb 2026

---

## 1. Revisión de logs (README_LOGS.md)

Ruta del log PHP en este entorno (LAMPP/Linux):

- **`/opt/lampp/logs/php_error_log`**

En el log **no** aparece el texto literal "cannot be null" ni "Column 'correo'": ScriptCase captura el error de MySQL y lo muestra en pantalla, no necesariamente en `error_log`.

### Qué sí aparece en el log relacionado con app_form_add_users

| Hora (26-Feb-2026) | Mensaje |
|--------------------|---------|
| 02:50:39 | `REGISTRO: Nuevo aspirante creado - id_asp=1271, generacion=2025, login=anibal.sanchez+999@inecol.mx` |
| 02:52:38 | `REGISTRO: Nuevo aspirante creado - id_asp=1272, ... login=anibal.sanchez+555@inecol.mx` |
| 02:52:38 | Pago insertado en PRODUCCIÓN para id_asp=1272 |
| 02:55:48 | **PHP Fatal error:** `Call to a member function Close() on null` en app_form_add_users_apl.php:1590 |

Interpretación: el registro de **anibal.sanchez+999@inecol.mx** (id_asp=1271) **sí llegó a crear aspirante** en una ejecución anterior (02:50:39). Si el error "correo cannot be null" ocurre al registrar de nuevo (por ejemplo otro usuario o reintento), el fallo es en el **PASO 3.5** de `add_asp_aspirantes`: el `INSERT` en `recomendantes` con `correo = NULL`.

---

## 2. Origen del error en código

**Archivo:**  
`scriptcase/apps_sce_asp/app_form_add_users/metodos/add_asp_aspirantes`

**Líneas 81-96 (PASO 3.5):** se insertan 3 filas en `recomendantes` como “placeholders” (el aspirante llena después nombre y correo de cada recomendante). El código hace:

```php
$ins_recom = "INSERT INTO recomendantes (id_recom, nombre, apellido_p, apellido_m, correo, num_recom, login_FK)
              VALUES (".$id_recom_actual.", NULL, NULL, NULL, NULL, ".($r + 1).", ".sc_sql_injection($login).")";
```

Ahí se inserta **`correo = NULL`** de forma explícita.

---

## 3. Esquema de la tabla `recomendantes`

- Si la columna `correo` está definida como **`NOT NULL`** (sin `DEFAULT NULL`), MySQL rechaza ese `INSERT` y devuelve: *Column 'correo' cannot be null*.
- En **este** entorno local, al momento del diagnóstico, la tabla tiene `correo` con **`DEFAULT NULL`** (nullable). En ese caso el mismo `INSERT` no fallaría por NULL.
- En el entorno donde el usuario ve el error (por ejemplo producción o otro servidor), la tabla debe tener **`correo` definida como NOT NULL**.

Conclusión: el error aparece cuando la **base de datos** exige que `correo` no sea NULL y el **código** siempre inserta NULL en ese campo en el alta de nuevos aspirantes.

---

## 4. Resumen del diagnóstico

| Aspecto | Detalle |
|---------|---------|
| **Dónde falla** | `INSERT` en tabla `recomendantes` dentro del método `add_asp_aspirantes` (onAfterInsert de app_form_add_users). |
| **Causa** | Incompatibilidad: el código inserta `correo = NULL` y en el entorno donde falla la columna `correo` es **NOT NULL**. |
| **Cuándo** | Al completar el registro de un nuevo usuario/aspirante: después de insertar en `sec_asp_users`, `sec_asp_users_groups`, `aspirantes` y `asp_requisitos`, al crear los 3 recomendantes placeholder. |
| **Log** | El mensaje "cannot be null" no aparece en `php_error_log`; sí aparecen los "REGISTRO: Nuevo aspirante creado" cuando el flujo llega hasta ese punto. Para ver el error de BD en log habría que revisar si ScriptCase o el driver registran errores SQL en otro archivo o en el mismo log en tu versión. |

---

## 5. Comandos útiles para seguir revisando

**Ver definición actual de `correo` en tu BD:**

```bash
/opt/lampp/bin/mysql -u root -p515t3ma5 sce_asp -e "
  SHOW CREATE TABLE recomendantes\G
"
```

**Ver últimas líneas del log de la app (registros y errores):**

```bash
tail -100 /opt/lampp/logs/php_error_log | grep -E "REGISTRO|app_form_add_users|recomendantes|cannot|Fatal"
```

---

## 6. Solución aplicada

Implementación detallada en: **[SOLUCION_CORREO_CANNOT_BE_NULL.md](SOLUCION_CORREO_CANNOT_BE_NULL.md)**.

- **Recomendado:** ejecutar `data/sql_recomendantes_correo_nullable.sql` (permite NULL en `correo`) en el entorno donde falla.
- **Código:** en `crear_usuario_recomendante` se trata `correo` NULL o vacío para no intentar crear usuario.
- **Alternativa** (si no se puede cambiar el esquema): usar placeholder único por fila; ver el doc de solución.
