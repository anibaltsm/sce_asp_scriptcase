# Ejemplo de correo al recomendante al crear usuario

Este documento describe **cómo se ve el correo** que recibe el recomendante cuando se le crea usuario por primera vez (método `crear_usuario_recomendante`), y **cuándo no se envía** otro correo.

---

## Cuándo se envía (solo un correo) y cuándo no

- **Se envía un correo** cuando un aspirante agrega al recomendante y el sistema **crea por primera vez** el usuario (insert en `sec_asp_users`). En ese momento el evento va por **un solo** aspirante y **un solo** tipo de documento (el que el aspirante asignó: 1ª carta, 2ª carta, opinión del director, etc.).
- **No se envía otro correo** si:
  - El **correo ya está registrado** en `sec_asp_users` (misma persona agregada por otro aspirante o ya tenía cuenta): solo se asigna el grupo de recomendante y se actualiza el registro; no se envía email.
  - Ya existe **otro recomendante con el mismo correo** (duplicado): se hace MERGE (se redirige a un solo `id_recom` y se elimina el duplicado); no se envía email.
  - El recomendante **ya tiene usuario** (`cc_edit = 0`): no se vuelve a crear ni a enviar correo.

Por tanto, **cada recomendante recibe como máximo un correo** (el de la primera vez que se le crea usuario). Si otro aspirante lo agrega después con el mismo correo, no se le manda un segundo correo.

---

## Asunto

`INECOL. Registro al Subsistema de Aspirantes al Posgrado`

---

## Cuerpo del correo (ejemplo)

Siempre **un** aspirante y **un** documento (el de la guardada que disparó la creación del usuario):

- Estimado(a) **María García López**:
- Por medio del presente le informamos que se ha generado su usuario de acceso al **Subsistema de Aspirantes al Posgrado del INECOL**. Para poder ingresar al sistema es necesario que active su registro mediante el siguiente enlace; puede hacer clic en él o copiar y pegar la dirección en su navegador.
- **Lo ha agregado como recomendante el aspirante Juan Pérez Sánchez** en el proceso de admisión al posgrado del INECOL. Una vez que active su cuenta e inicie sesión, **deberá subir el siguiente documento: 1a Carta de recomendación confidencial (En formato PDF).**
- **Enlace de activación:**  
  `http://posgrados.inecol.mx/sce_asp/app_form_add_users/index.php?a=new_xxxxx...`
- **Sus datos de acceso:**  
  Usuario: `recomendante@ejemplo.com`  
  Contraseña: `(8 caracteres generados)`
- Una vez activada su cuenta, podrá acceder a la ventana principal del Subsistema de Aspirantes al Posgrado del INECOL para iniciar sesión.
- Se le solicita no compartir esta información con terceros. Esta dirección de correo electrónico no recibe respuestas.
- Atentamente, **Instituto de Ecología A.C.** – Sistema de Control Escolar – Posgrado

---

## Origen de los datos en el correo

| Dato en el correo | Origen |
|-------------------|--------|
| Nombre del recomendante | Parámetros del método: `$nombre`, `$apellido_p`, `$apellido_m` |
| Quién lo agregó (un aspirante) | La relación recién guardada en `asp_recomendantes` (orden por `id_asp_recom DESC`, 1 fila) → `aspirantes` (nombres, ap_pat, ap_mat) |
| Qué documento subir (uno) | `asp_recomendantes.num_req` de esa misma fila → `sce.list_req_gral.leyenda` con `cc_carta = 1` |

Si no hay fila en `asp_recomendantes` para ese `id_recom`, el párrafo de “Lo ha agregado…” no se muestra; el resto del correo (activación y datos de acceso) sí se envía.
