# Respaldos de bases de datos SCE

Respaldo completo de las bases de datos **sce**, **sce_asp** y **sce_enbc** (tablas, vistas, rutinas almacenadas, triggers y eventos).

---

## Cómo se hizo el respaldo

Se usó **mysqldump** de XAMPP/LAMPP con las siguientes opciones para incluir todo:

| Opción | Descripción |
|--------|-------------|
| `--routines` | Incluye stored procedures y funciones |
| `--triggers` | Incluye triggers |
| `--events` | Incluye eventos del programador (event scheduler) |
| `--single-transaction` | Consistencia sin bloquear tablas (InnoDB) |
| `--force` | (solo sce_asp) Continúa aunque falle alguna vista; el resto se respalda |

Las **vistas** se incluyen automáticamente en el dump de cada base.

### Comandos usados

```bash
# Directorio de trabajo
cd "/opt/sce_asp_scriptcase/respaldos bd"

# Fecha para nombres únicos (opcional)
FECHA=$(date +%Y%m%d_%H%M%S)

# 1) sce_enbc
/opt/lampp/bin/mysqldump -u root -p515t3ma5 --routines --triggers --events --single-transaction sce_enbc > "sce_enbc_${FECHA}.sql"

# 2) sce_asp (con --force por posibles vistas con definer/referencias a otras BD)
/opt/lampp/bin/mysqldump -u root -p515t3ma5 --routines --triggers --events --single-transaction --force sce_asp > "sce_asp_${FECHA}.sql"

# 3) sce
/opt/lampp/bin/mysqldump -u root -p515t3ma5 --routines --triggers --events --single-transaction sce > "sce_${FECHA}.sql"
```

---

## Cómo restaurar un respaldo

1. Crear la base de datos si no existe (opcional; el dump puede crearla si incluye `CREATE DATABASE`; si no, créala antes):

```bash
/opt/lampp/bin/mysql -u root -p515t3ma5 -e "CREATE DATABASE IF NOT EXISTS sce_enbc;"
/opt/lampp/bin/mysql -u root -p515t3ma5 -e "CREATE DATABASE IF NOT EXISTS sce_asp;"
/opt/lampp/bin/mysql -u root -p515t3ma5 -e "CREATE DATABASE IF NOT EXISTS sce;"
```

2. Restaurar cada archivo `.sql` en su base correspondiente:

```bash
/opt/lampp/bin/mysql -u root -p515t3ma5 sce_enbc < "respaldos bd/sce_enbc_YYYYMMDD_HHMMSS.sql"
/opt/lampp/bin/mysql -u root -p515t3ma5 sce_asp  < "respaldos bd/sce_asp_YYYYMMDD_HHMMSS.sql"
/opt/lampp/bin/mysql -u root -p515t3ma5 sce     < "respaldos bd/sce_YYYYMMDD_HHMMSS.sql"
```

Sustituye el nombre del archivo por el que quieras restaurar.

---

## Requisitos para hacer los respaldos

- **MySQL/MariaDB** accesible con el cliente de LAMPP: `/opt/lampp/bin/mysqldump` y `/opt/lampp/bin/mysql`.
- Usuario con permisos de lectura sobre las tres bases (por ejemplo `root` con la contraseña indicada).
- Espacio en disco suficiente en la carpeta `respaldos bd` (sce suele ser la más grande).

---

## Nota sobre vistas en sce_asp

En algunos entornos, las vistas `pagos` y `pagos_backup_*` pueden dar error al hacer el dump porque referencian tablas de otra base o porque el **DEFINER** de la vista no coincide con el usuario que ejecuta el respaldo. En ese caso:

- Se usó **`--force`** para que el resto de tablas y vistas sí se respalden.
- Si necesitas esas vistas en el respaldo, puedes:
  - Ejecutar el mysqldump con un usuario que tenga acceso a todas las bases referenciadas, o
  - Después de restaurar, recrear esas vistas a mano con `CREATE OR REPLACE VIEW ...` según su definición en el servidor de origen.

---

## Estructura de archivos en esta carpeta

- `sce_YYYYMMDD_HHMMSS.sql` — Respaldo de la base **sce**
- `sce_asp_YYYYMMDD_HHMMSS.sql` — Respaldo de la base **sce_asp**
- `sce_enbc_YYYYMMDD_HHMMSS.sql` — Respaldo de la base **sce_enbc**
- `README.md` — Este archivo (instrucciones de respaldo y restauración)
