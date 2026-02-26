# Diagrama de flujo: `crear_usuario_recomendante`

Se ejecuta desde `onAfterUpdate` cada vez que un aspirante guarda el formulario de recomendantes.

```mermaid
flowchart TD
    A([onAfterUpdate: aspirante guarda el formulario]) --> B{id_recom vacío?}
    B -- Sí --> Z1([FIN: carga de página, no guardado real])
    B -- No --> C{correo vacío?}
    C -- Sí --> Z2([FIN: sc_error_message al usuario])
    C -- No --> CTX

    CTX["Obtener contexto desde asp_recomendantes\n─────────────────────────────────\nid_asp_FK → nombre del aspirante\nnum_req → leyenda del documento\n(cc_carta = 1 en list_req_gral)"]
    CTX --> D

    D{¿Mismo correo ya existe\nen otro id_recom?\nDuplicado en recomendantes}
    D -- Sí MERGE --> D1["UPDATE asp_recomendantes\n→ id_recom canónico\nDELETE recomendante duplicado\ncommit"]
    D1 --> D2["📧 Correo NOTIFICACIÓN\n'Un aspirante lo ha agregado'\n+ quién lo agregó\n+ qué documento subir\n+ enlace al login"]
    D2 --> Z3([FIN])

    D -- No --> E{cc_edit = 0?\nYa tiene usuario creado}
    E -- Sí --> E1["📧 Correo NOTIFICACIÓN\n'Un aspirante lo ha agregado'\n+ quién lo agregó\n+ qué documento subir\n+ enlace al login"]
    E1 --> Z4([FIN])

    E -- No --> F{¿Login ya existe\nen sec_asp_users?}
    F -- Sí --> F1["INSERT IGNORE grupo 7\nUPDATE recomendantes\nlogin_FK, cc_edit=0\ncommit"]
    F1 --> F2["📧 Correo NOTIFICACIÓN\n'Un aspirante lo ha agregado'\n+ quién lo agregó\n+ qué documento subir\n+ enlace al login"]
    F2 --> Z5([FIN])

    F -- No --> G["NUEVO USUARIO\n─────────────────\nGenerar contraseña 8 chars\nINSERT sec_asp_users active='N'\nINSERT sec_asp_users_groups grupo 7\nUPDATE recomendantes login_FK, cc_edit=0\ncommit\nGenerar código activación\nUPDATE sec_asp_users activation_code"]
    G --> H["📧 Correo BIENVENIDA\n────────────────────────────────\nAsunto: Registro al Subsistema...\n• Contraseña generada\n• Enlace de activación de cuenta\n• Quién lo agregó (aspirante)\n• Qué documento debe subir"]
    H --> Z6([FIN])
```

---

## Diferencia entre los dos tipos de correo

| | Correo **BIENVENIDA** | Correo **NOTIFICACIÓN** |
|---|---|---|
| **Cuándo se envía** | Primera vez que se crea el usuario | Cada vez que un aspirante lo agrega y ya tiene usuario |
| **Asunto** | INECOL. Registro al Subsistema de Aspirantes al Posgrado | INECOL. Un aspirante lo ha agregado como recomendante |
| **Contraseña** | ✅ incluida | ❌ no incluye |
| **Enlace activación** | ✅ incluido | ❌ no incluye |
| **Enlace al login** | ❌ (aún no tiene cuenta activa) | ✅ incluido |
| **Quién lo agregó** | ✅ nombre del aspirante | ✅ nombre del aspirante |
| **Qué documento subir** | ✅ leyenda del requisito | ✅ leyenda del requisito |

---

## Casos en que se envía el correo NOTIFICACIÓN

1. **MERGE** (mismo correo en dos filas de `recomendantes`): se fusionan y se envía notificación al correo canónico.
2. **cc_edit = 0** (ya tenía usuario desde una guardada anterior): solo se notifica.
3. **Login ya existe en `sec_asp_users`** (el correo pertenece a otro rol, ej. aspirante): se asigna grupo y se notifica.

---

## Origen del contexto (aspirante + documento)

| Campo en el correo | Origen en BD |
|---|---|
| Nombre del recomendante | Parámetros del método: `$nombre`, `$apellido_p`, `$apellido_m` |
| Nombre del aspirante | `asp_recomendantes` (último id_asp_recom para este id_recom) → `aspirantes.nombres/ap_pat/ap_mat` |
| Documento a subir | `asp_recomendantes.num_req` → `sce.list_req_gral.leyenda` donde `cc_carta = 1` |

El contexto se obtiene **antes** del bloque MERGE para que la relación en `asp_recomendantes` aún tenga `id_recom_FK = id_recom_nuevo` (antes del UPDATE que lo redirige al canónico).
