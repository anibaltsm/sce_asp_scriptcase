# Restaurar referencia de pago (sce.pagos)

Cuando un aspirante fue creado pero **no se generó la referencia de pago** en `sce.pagos` (por fallo en el flujo de `add_asp_aspirantes` o porque el registro se perdió), se puede regenerar la referencia con estos scripts.

---

## Formato de la referencia

Igual que en **add_asp_aspirantes** (PASO 4):

- **Prefijo:** `INECOLPA0002`
- **id_asp** sin ceros a la izquierda (ej. 1282, 1301)
- Si `id_asp` tiene ≤ 3 dígitos, se rellena con ceros a la izquierda (1 → 000, 2 → 00, 3 → 0)
- **Sufijo:** `00`

Ejemplos:

| id_asp | Referencia          |
|--------|---------------------|
| 1      | INECOLPA0002000100  |
| 1282   | INECOLPA0002128200  |
| 1301   | INECOLPA0002130100  |

---

## Opción 1: Script automático (recomendado)

El script **obtiene los datos del aspirante** por `id_asp` e **inserta** el pago en `sce.pagos` si no existe.

```bash
cd /opt/sce_asp_scriptcase/scriptcase/apps_sce_asp/form_recomendantes/data
./restore_referencia_pago.sh 1301
```

- **Parámetro:** `id_asp` (ej. 1301, 1282).
- Usa por defecto `mysql` con usuario `root` y contraseña en variable `MYSQL_PWD` o en el propio script (editable).
- Lee de `sce_asp.aspirantes`: nombre completo y `login_FK`.
- Lee de `sce.convocatorias_posg`: generación activa para el concepto.
- Inserta en `sce.pagos` solo si **no existe** ya un pago para ese `id_asp` y `group_id_FK = '5'`.

Ver en el script las variables `MYSQL_CMD` y contraseña para adaptarlas a tu entorno.

---

## Opción 2: Scripts SQL fijos

Hay scripts SQL que insertan un pago concreto (por si quieres repetir el mismo caso sin script bash):

| Archivo                         | id_asp | Referencia          |
|---------------------------------|--------|----------------------|
| `restore_pago_simon_marin.sql`  | 1282   | INECOLPA0002128200   |
| `restore_pago_id_asp_1301.sql`  | 1301   | INECOLPA0002130100   |

**Uso:**

```bash
/opt/lampp/bin/mysql -u root -p sce < restore_pago_simon_marin.sql
# o
/opt/lampp/bin/mysql -u root -p sce < restore_pago_id_asp_1301.sql
```

Solo insertan si no existe ya un pago para ese aspirante y `group_id_FK = '5'`.

---

## Tabla afectada: sce.pagos

- **Base de datos:** `sce` (no `sce_asp`).
- **group_id_FK:** `'5'` (proceso de selección).
- **Concepto:** `Derecho al proceso de seleccion {generacion}` (ej. 2026).
- **Monto:** 1250.

Otras columnas del INSERT: `nombre_interesado`, `referencia`, `login_insert`, `fecha_alta`, `ip_alta`; el resto en NULL.

---

## Restaurar también asp_recomendantes

Si además faltan los **recomendantes** del aspirante, está el script:

- `restore_asp_recomendantes_simon_marin.sql` — restaura los 3 vínculos en `asp_recomendantes` para id_asp 1282.

Ejecutar contra la base **sce_asp**:

```bash
/opt/lampp/bin/mysql -u root -p sce_asp < restore_asp_recomendantes_simon_marin.sql
```

Para otro id_asp habría que generar los INSERT correspondientes (id_asp, id_recom, num_req 10/11/13) según los recomendantes en `recomendantes`.
