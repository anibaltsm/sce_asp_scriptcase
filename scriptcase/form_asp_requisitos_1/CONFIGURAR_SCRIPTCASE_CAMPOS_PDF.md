# Configurar Scriptcase para que el PDF se guarde donde el evento lo busca

## 1. Ruta de documentos de la aplicación

La ruta completa donde debe quedar el PDF es:

`/Applications/Scriptcase/v9-php81/wwwroot/scriptcase/file/doc/cartas/`

En Scriptcase hay que definir la **ruta base** de documentos para que, al sumarle la subcarpeta `cartas/`, coincida con la de arriba.

### Dónde configurarlo

- **Opción A – Proyecto:**  
  **Opciones (Options) → Configuración (Settings) → Sistema (System) → Carpetas del sistema (System Folders)**  
  Ahí suele estar **“Directorio de documentos”** o **“Documents directory”**.  
  Pon la ruta base de documentos, por ejemplo:  
  **`/Applications/Scriptcase/v9-php81/wwwroot/scriptcase/file/doc`**  
  (sin `cartas` al final; `cartas` lo pone el campo con “Subdirectory for local storage”.)

- **Opción B – Aplicación (form):**  
  En **form_asp_requisitos_1**, entra a **Configuración de la aplicación** / **Application Settings** (o **Editar aplicación** y luego pestaña de configuración).  
  Busca **“Ruta de documentos”** / **“Documents path”** / **“File path”** y asígnale la ruta absoluta:  
  **`/Applications/Scriptcase/v9-php81/wwwroot/scriptcase/file/doc`**  
  De nuevo sin `cartas`; el campo ya tiene subdirectorio `cartas/`.

Resultado: los PDF se guardan en  
`/Applications/Scriptcase/v9-php81/wwwroot/scriptcase/file/doc/cartas/`, que es donde el evento OnAfterUpdate busca el archivo.

## 2. Campo “archivo” (Document File Name)

- **Subdirectory for local storage:** déjalo en **`cartas/`** (ya lo tienes).
- **Create Subfolder:** puede quedarse marcado.
- **Increment file:** mejor **desmarcado**.  
  Si está marcado, Scriptcase puede guardar `Constancia_1.pdf` y el nombre en BD puede no coincidir con el del disco; al desmarcar, el nombre del archivo en disco y en BD suelen coincidir y el evento encuentra el PDF.

## Resumen

| Dónde | Qué poner |
|-------|-----------|
| Ruta base de documentos (proyecto o form) | `/Applications/Scriptcase/v9-php81/wwwroot/scriptcase/file/doc` |
| Subdirectory del campo archivo | `cartas/` (ya está) |
| Increment file | Desmarcado |

Después de cambiar la ruta de documentos, regenera la aplicación del form y prueba de nuevo la subida.
