# Rutas por entorno (referencia para ScriptCase / pegar en servidor)

Este archivo documenta cómo quedan las rutas según el entorno. **El código usa `$_SERVER['DOCUMENT_ROOT']`**, así que no se hardcodea la ruta completa; esto es solo referencia para configurar ScriptCase o el servidor.

---

## Entorno: **DEV (mac)**

| Variable / Uso | Valor en dev (Mac) |
|----------------|--------------------|
| `DOCUMENT_ROOT` (típico XAMPP) | `/Applications/XAMPP/xamppfiles/htdocs` |
| Proyecto aspirantes (sce_asp) | `/Applications/XAMPP/xamppfiles/htdocs/sce_asp/` |
| Proyecto control escolar (sce) | `/Applications/XAMPP/xamppfiles/htdocs/sce/` |
| Archivos doc – pagos (origen upload) | `.../htdocs/sce_asp/_lib/file/doc/pagos/[generacion]/` |
| Archivos doc – pagos (grid, destino final) | `.../htdocs/sce/_lib/file/doc/pagos/[generacion]/` |
| Archivos doc – aspirantes | `.../htdocs/sce_asp/_lib/file/doc/aspirantes/[generacion]/[login]/` |
| Archivos doc – cartas | `.../htdocs/sce_asp/_lib/file/doc/cartas/[generacion]/` |

**Ejemplo ruta completa en dev (pagos 2026):**  
`/Applications/XAMPP/xamppfiles/htdocs/sce/_lib/file/doc/pagos/2026/`

---

## Uso

- En **dev**: copiar/pegar estas rutas donde ScriptCase pida “Subdirectorio para almacenamiento local” o al revisar logs.
- En **prod**: ver el mismo archivo en la rama `prod` (rutas Linux).
