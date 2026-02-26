# Rutas por entorno (referencia para ScriptCase / pegar en servidor)

Este archivo documenta cómo quedan las rutas según el entorno. **El código usa `$_SERVER['DOCUMENT_ROOT']`**, así que no se hardcodea la ruta completa; esto es solo referencia para configurar ScriptCase o el servidor.

---

## Entorno: **PROD (Linux)**

| Variable / Uso | Valor en prod (Linux) |
|----------------|------------------------|
| `DOCUMENT_ROOT` (típico Apache) | `/var/www/html` |
| Proyecto aspirantes (sce_asp) | `/var/www/html/sce_asp/` |
| Proyecto control escolar (sce) | `/var/www/html/sce/` |
| Archivos doc – pagos (origen upload) | `.../html/sce_asp/_lib/file/doc/pagos/[generacion]/` |
| Archivos doc – pagos (grid, destino final) | `.../html/sce/_lib/file/doc/pagos/[generacion]/` |
| Archivos doc – aspirantes | `.../html/sce_asp/_lib/file/doc/aspirantes/[generacion]/[login]/` |
| Archivos doc – cartas | `.../html/sce_asp/_lib/file/doc/cartas/[generacion]/` |

**Ejemplo ruta completa en prod (pagos 2026):**  
`/var/www/html/sce/_lib/file/doc/pagos/2026/`

*Ajustar `DOCUMENT_ROOT` si el servidor usa otra raíz (ej. `/home/usuario/public_html`).*

---

## Uso

- En **prod**: copiar/pegar estas rutas donde ScriptCase pida “Subdirectorio para almacenamiento local” o al revisar logs.
- En **dev** (Mac): ver el mismo archivo en la rama `dev` (rutas XAMPP Mac).
