# Solución: "Column 'correo' cannot be null" en app_form_add_users

**Contexto:** Diagnóstico en [DIAGNOSTICO_CORREO_CANNOT_BE_NULL.md](DIAGNOSTICO_CORREO_CANNOT_BE_NULL.md).

---

## 1. Documentación consultada (internet)

- **MySQL: NULL vs empty string en columnas NOT NULL**  
  [Stack Overflow: MySQL, better to insert NULL or empty string?](https://stackoverflow.com/questions/1267999/mysql-better-to-insert-null-or-empty-string)  
  NULL = “valor no definido”; vacío = “definido y vacío”. Para campos opcionales se recomienda NULL.

- **UNIQUE y NULL en MySQL**  
  [Stack Overflow: Does MySQL ignore null values on unique constraints?](https://stackoverflow.com/questions/3712222/does-mysql-ignore-null-values-on-unique-constraints)  
  En MySQL, una columna UNIQUE **permite múltiples filas con NULL** (cada NULL no se considera duplicado del otro). Así se pueden insertar varios recomendantes con `correo = NULL` sin violar `uk_correo_recom`.

- **Buenas prácticas**  
  [phpfashion: How to Deal with Empty Strings and NULL in MySQL](https://phpfashion.com/en/how-to-deal-with-the-chaos-of-empty-strings-and-null-values-in-mysql)  
  En columnas opcionales usar solo NULL para “sin valor”; no mezclar NULL y `''` para evitar condiciones del tipo `WHERE correo = '' OR correo IS NULL`.

Conclusión: para “correo aún no llenado” lo estándar es **permitir NULL** en la columna y seguir insertando NULL en el código.

---

## 2. Solución aplicada (recomendada)

### 2.1 Cambio en base de datos

Permitir NULL en `recomendantes.correo` en **todos los entornos** donde aparezca el error (desarrollo, producción, etc.):

**Script:** `data/sql_recomendantes_correo_nullable.sql`

```sql
USE sce_asp;

ALTER TABLE recomendantes
  MODIFY COLUMN `correo` varchar(80) DEFAULT NULL;
```

**Ejecución (ejemplo):**

```bash
/opt/lampp/bin/mysql -u root -p515t3ma5 sce_asp < /opt/sce_asp_scriptcase/data/sql_recomendantes_correo_nullable.sql
```

O desde MySQL:

```sql
SOURCE /opt/sce_asp_scriptcase/data/sql_recomendantes_correo_nullable.sql;
```

Tras esto, el `INSERT` en `add_asp_aspirantes` que usa `correo = NULL` deja de fallar y el UNIQUE sigue permitiendo un solo correo real por recomendante.

### 2.2 Código (sin cambio en el INSERT)

El método **add_asp_aspirantes** sigue igual: inserta 3 filas en `recomendantes` con `correo = NULL` (placeholders). No se modifica.

### 2.3 Código: manejo de correo NULL en crear_usuario_recomendante

En **form_recomendantes** → método **crear_usuario_recomendante** se normaliza el parámetro `correo` y se trata “sin correo” así:

- `$correo = $correo !== null ? trim((string)$correo) : '';`
- Condición de “correo obligatorio”: `if ($correo === '' || $correo === null)` → se muestra el mensaje de error y no se crea usuario.

Así, si por algún flujo llega `correo` NULL o vacío, no se intenta crear usuario ni enviar correo y el comportamiento queda consistente.

---

## 3. Alternativa sin cambiar el esquema (si no se puede hacer ALTER TABLE)

Si en algún entorno **no** se puede permitir NULL en `correo` (política de BD, etc.), se puede mantener NOT NULL y usar un **placeholder único por fila** (porque `correo` tiene UNIQUE):

1. **En add_asp_aspirantes**, en lugar de `NULL` en correo, usar un valor que nunca sea un correo real y que sea distinto para cada fila, por ejemplo:
   - `'pendiente_' . $id_recom_actual . '@placeholder.interno'`
   Así se cumple NOT NULL y UNIQUE.

2. **En crear_usuario_recomendante**, al inicio, considerar “placeholder” y tratarlo como correo no llenado:
   - Si `$correo` empieza por `pendiente_` y contiene `@placeholder.interno`, considerar que el correo no está lleno: mostrar mensaje de “El correo del recomendante es obligatorio…” y hacer `return` sin crear usuario.

3. En **form_recomendantes** (grid), opcional: en presentación o en evento de carga, mostrar celda vacía cuando `correo` sea ese placeholder, para no mostrar la cadena técnica al usuario.

Esta alternativa implica tocar más código y mantener la convención del placeholder; la solución recomendada sigue siendo permitir NULL.

---

## 4. Resumen

| Qué | Dónde |
|-----|--------|
| Script SQL | `data/sql_recomendantes_correo_nullable.sql` |
| Ejecutar en | Cada BD donde `correo` sea NOT NULL y falle el INSERT (p. ej. producción). |
| Código PHP | `crear_usuario_recomendante`: normalización de `correo` y comprobación `''` o `null` para no crear usuario. |
| add_asp_aspirantes | Sin cambios; sigue insertando `correo = NULL`. |

Referencias: Stack Overflow (NULL vs empty string, UNIQUE con NULL), phpfashion (NULL en MySQL).
