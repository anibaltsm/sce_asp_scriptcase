# Ruta de cartas – form_asp_requisitos_1

Una sola carpeta: donde Scriptcase guarda el PDF y donde se renombra (no se copia a otro sitio).

- **Desarrollo (Scriptcase en macOS):** `/Applications/Scriptcase/v9-php81/wwwroot/scriptcase/file/doc/cartas/`
- **Producción (Windows):** `C:/Program Files/NetMake/v9-php81/wwwroot/scriptcase/file/doc/cartas/`

En Scriptcase, el campo del PDF debe estar configurado para guardar en esa misma carpeta. El evento solo renombra el archivo ahí; si ya existe uno con el nombre nuevo, lo reemplaza.
