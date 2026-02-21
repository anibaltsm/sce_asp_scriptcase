# Logs y depuración (PHP error_log)

En las apps de ScriptCase se usa **error_log()** de PHP para seguir el flujo y depurar sin afectar la salida. Los mensajes van al log de errores de PHP.

## Dónde está el log (XAMPP en macOS)

```text
/Applications/XAMPP/xamppfiles/logs/php_error_log
```

En otros entornos suele ser el path configurado en `php.ini` como `error_log`.

## Cómo se escribe en el log

En PHP (eventos o métodos de la app):

```php
error_log("form_pagos chg_filename: INICIO id_pago=123");
```

Convención usada en el proyecto: **`nombre_app contexto: mensaje`** para poder filtrar por app o por método.

## Comandos útiles

### Ver logs en tiempo real (una app)

```bash
# form_pagos (incluye chg_filename, agregar_cfdi, etc.)
tail -f /Applications/XAMPP/xamppfiles/logs/php_error_log | grep "form_pagos"

# form_recomendantes
tail -f /Applications/XAMPP/xamppfiles/logs/php_error_log | grep "form_recomendantes"
```

### Últimas líneas y filtrar

```bash
# Últimas 200 líneas del formulario de pagos
tail -200 /Applications/XAMPP/xamppfiles/logs/php_error_log | grep "form_pagos"

# Solo el método chg_filename
tail -200 /Applications/XAMPP/xamppfiles/logs/php_error_log | grep "form_pagos chg_filename"

# Buscar errores PHP (parse, fatal, error)
tail -100 /Applications/XAMPP/xamppfiles/logs/php_error_log | grep -i "parse\|fatal\|error"
```

### Varias apps a la vez

```bash
tail -f /Applications/XAMPP/xamppfiles/logs/php_error_log | grep -E "form_pagos|form_recomendantes"
```

## Qué esperar por app

### form_pagos – método chg_filename

Cuando se sube/guarda un comprobante de pago y se ejecuta el renombrado:

1. `form_pagos chg_filename: INICIO id_pago=... doc_compr_pago=...`
2. `form_pagos chg_filename: num_req=... prefijo_req=... ext=... id_asp=...`
3. `form_pagos chg_filename: rename OK -> [nombre].ext`
4. `form_pagos chg_filename: copy OK -> [nombre].ext en aspirantes`
5. `form_pagos chg_filename: FIN - pagos y asp_requisitos actualizados`

Si no hay archivo o no aplica el flujo:

- `form_pagos chg_filename: SKIP - cont_file o doc_compr_pago vacío`

### form_recomendantes

Detalle de mensajes y flujos en:

- **consulta_ia/GUIA_FORM_RECOMENDANTES.md** (sección de logs, comandos y mensajes esperados).

## Buenas prácticas

- **No usar echo/print ni HTML** en eventos que se ejecutan en AJAX; puede romper la respuesta y mostrar “Output”.
- **Usar error_log()** para depurar; no aparece en pantalla y se revisa en el archivo de log.
- **Prefijo estable** (ej. `form_pagos chg_filename:`) para poder hacer `grep` y entender el flujo rápido.
