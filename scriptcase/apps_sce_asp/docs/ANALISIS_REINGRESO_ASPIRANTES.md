# Análisis: Reingreso de aspirantes con cuenta de convocatorias anteriores

**Fecha:** 2025-03-05  
**Contexto:** La jefa propone que los aspirantes que ya tienen cuenta de convocatorias anteriores reutilicen la misma cuenta y que en cada nueva convocatoria se les genere un **nuevo registro de participación**, copiando datos básicos anteriores pero pidiéndoles actualizarlos y confirmarlos según requisitos vigentes (como en otros sistemas de admisión que permiten reaplicar).

---

## 1. Lo que ya está implementado

### 1.1 Login (App_login → sc_validate_success)

Para usuarios con **group_id = 2 (aspirante)** ya existe lógica diferenciada:

- **Si tiene registro en la generación actual**  
  → Se asigna `[id_asp]` y `$_SESSION['id_asp']`, redirección a `menu_aspirante`. Todo correcto.

- **Si NO tiene registro en la generación actual pero SÍ tiene en una anterior**  
  → Se guarda en sesión:
  - `$_SESSION['id_asp_anterior']`
  - `$_SESSION['generacion_anterior']`
  - `$_SESSION['aspirante_reactivar'] = 'SI'`  
  → Redirección a **`form_reactivar_registro`**.

- **Si no tiene ningún registro**  
  → Mensaje de error y exit.

Es decir, el sistema **ya reutiliza la misma cuenta** (mismo login) y ya identifica al reingresante para enviarlo a un flujo de “reactivación”.

### 1.2 Base de datos

- La tabla **`aspirantes`** tiene `login_FK` y `generacion`. No hay restricción UNIQUE(login_FK, generacion); en la práctica ya hay al menos un login con más de un registro (mismo usuario, distintas participaciones). El modelo permite **un registro de aspirante (id_asp) por participación (generación)**.
- **Pagos** (en `sce.pagos`, conexión conn_sce) se asocian por `id_asp_FK`. Cada nueva participación puede tener su propia referencia de pago (nuevo `id_asp`).
- **Requisitos** (`asp_requisitos`) y **recomendantes** (`asp_recomendantes` → `recomendantes`) están ligados a `id_asp`, por lo que cada nueva participación puede tener su propio conjunto.

Conclusión: **tiene sentido** reutilizar la cuenta (mismo login) y crear **un nuevo registro de participación** (nuevo `id_asp`, misma generación activa) por convocatoria, copiando datos básicos y pidiendo actualizar/confirmar.

---

## 1.3 Qué datos se deben actualizar al reaplicar (por generación y requisitos)

Cada **convocatoria (generación)** tiene su propia configuración: la lista de requisitos y documentos obligatorios viene de `sce.list_req_gral` ligada a `convocatorias_posg`. Por eso, al reingresar no se pueden reutilizar tal cual los requisitos ni los documentos del ciclo anterior.

| Qué | Por qué debe actualizarse / confirmarse |
|-----|----------------------------------------|
| **Generación** | El sistema asigna automáticamente la convocatoria **activa** (ej. 2026). El nuevo registro de participación es para esa generación; el aspirante no elige “a qué convocatoria aplico” en el formulario. |
| **Requisitos y documentos obligatorios** | La lista de requisitos (identificación, títulos, cartas, comprobante de pago, etc.) es **por convocatoria**. Si en 2025 había 12 requisitos y en 2026 la convocatoria define 14 o cambia alguno, el aspirante debe cumplir la lista **vigente**. Por eso se crean **nuevos** registros en `asp_requisitos` según la convocatoria actual y el aspirante debe **subir de nuevo** (o confirmar) cada documento según lo que pida la convocatoria actual. No se reutilizan los archivos ni las filas de requisitos del ciclo anterior. |
| **Datos básicos del aspirante** | Nombre, apellidos, email, CURP, dirección, teléfono, programa, línea, datos académicos (licenciatura, maestría), etc. Se **copían** del registro anterior al nuevo `id_asp` como punto de partida, y el sistema debe **pedir que los revise y confirme o actualice** (por si cambiaron domicilio, teléfono, o los requisitos de la nueva convocatoria piden algo distinto). |
| **Recomendantes (cartas)** | Para la nueva participación se crean de nuevo los 3 espacios de recomendantes (vacíos). El aspirante debe **volver a indicar** quiénes serán y los recomendantes deben **subir de nuevo** la carta para esta convocatoria (no se reutilizan las cartas del ciclo anterior). |
| **Pago** | Es **nuevo** por cada proceso: se genera una nueva referencia de pago para la convocatoria vigente y el aspirante paga el derecho al proceso de la generación actual. |

En resumen: **generación** la asigna el sistema; **requisitos y documentos** son los de la convocatoria vigente (subir/confirmar de nuevo); **datos personales y académicos** se copian del ciclo anterior y el aspirante los actualiza o confirma; **recomendantes y pago** son nuevos para esa convocatoria.

---

## 2. Problemas detectados

### 2.1 La aplicación `form_reactivar_registro` no existe en el repositorio

En `App_login/metodos/sc_validate_success` se hace:

```php
$menu = 'form_reactivar_registro';
```

En el repositorio actual **no hay** una aplicación con ese nombre (no aparece en la estructura de `apps_sce_asp`). Si en el entorno de ScriptCase tampoco está creada, el aspirante reingresante recibirá un **error** al intentar entrar (pantalla o enlace inexistente).

**Acción necesaria:** Crear la aplicación `form_reactivar_registro` en ScriptCase o ajustar el nombre en `sc_validate_success` al de la aplicación real que deba atender el flujo de reactivación.

### 2.2 app_form_add_users es solo para usuarios nuevos

- **app_form_add_users** está pensado para **alta de nuevos usuarios** (p. ej. desde enlace de activación `?a=`).
- En `onAfterInsert` se llama a:
  - `add_user_to_group(login)` → INSERT en `sec_asp_users_groups` (grupo 2).
  - `add_asp_aspirantes(login, name, apat, amat, email)` → INSERT nuevo registro en `aspirantes` con generación activa, requisitos, recomendantes y pago en `sce.pagos`.

No se comprueba si el login **ya es aspirante en otra generación**. Si un reingresante llegara a usar esta pantalla de “registro”:

- Podría fallar si `sec_asp_users` o `sec_asp_users_groups` no permiten duplicados (p. ej. PK o UNIQUE).
- O se podría insertar un **segundo** registro en `aspirantes` para la misma generación (mismo login, misma generación), lo que puede generar confusión (dos `id_asp` para el mismo usuario en la misma convocatoria) y problemas con pagos/requisitos.

Los reingresantes **no deberían** usar `app_form_add_users`; deben entrar por **Login** y ser llevados a la pantalla de reactivación (`form_reactivar_registro` o el nombre que se defina).

### 2.3 add_asp_aspirantes no contempla “copiar desde anterior”

El método `add_asp_aspirantes` siempre:

1. Inserta un nuevo registro en `aspirantes` con los datos recibidos (name, apat, amat, email, login, generación activa).
2. Crea requisitos según `list_req_gral` de la convocatoria activa.
3. Crea 3 recomendantes vacíos y los enlaza en `asp_recomendantes`.
4. Crea referencia de pago en `sce.pagos` si no existe para ese `id_asp`.

No hay rama tipo “si es reingresante, tomar datos de `id_asp_anterior`”. Para el flujo que pide la jefa hace falta **o bien**:

- Un método específico de “reactivación” que cree el nuevo `id_asp` copiando datos básicos del anterior (y opcionalmente requisitos/recomendantes según convocatoria actual), **o**
- Reutilizar la misma lógica pero invocada desde `form_reactivar_registro` con datos precargados desde el registro anterior (y requisitos/documentos según convocatoria vigente).

---

## 3. Resumen: ¿tiene sentido lo que propone la jefa?

**Sí.** Es coherente con:

- Un **registro de participación por convocatoria** (un `id_asp` por generación por usuario).
- **Misma cuenta** (mismo login en `sec_asp_users` / `aspirantes.login_FK`).
- **Copiar datos básicos** del ciclo anterior y **pedir actualizar/confirmar** según requisitos y documentos obligatorios vigentes.

Para que no falle en producción hace falta:

1. **Implementar (o localizar) la aplicación `form_reactivar_registro`** a la que ya redirige el login.
2. En esa aplicación:
   - Cargar datos del aspirante anterior (`id_asp_anterior` de sesión).
   - Mostrar formulario con datos básicos precargados para que el usuario los actualice/confirme según requisitos vigentes (generación, documentos obligatorios, etc.).
   - Al confirmar: crear **nuevo** registro en `aspirantes` (nuevo `id_asp`, generación actual), copiando/actualizando datos; crear requisitos y recomendantes para la convocatoria actual; generar referencia de pago para esta participación (nuevo `id_asp`).
3. **No** usar `app_form_add_users` para reingresantes (solo para altas nuevas desde enlace de activación).
4. Opcional: en `app_form_add_users` (o en la pantalla de registro), si se quiere evitar uso indebido, comprobar si el login ya existe en `sec_asp_users` y, si ya es aspirante en otra generación, redirigir al login o a la pantalla de reactivación en lugar de intentar un nuevo registro.

---

## 4. Consulta de BD de apoyo

Para tener panorama de reingresantes y convocatorias:

```bash
/opt/lampp/bin/mysql -u root -p515t3ma5 sce_asp
```

Consultas útiles:

```sql
-- Aspirantes con más de una participación (mismo login, distintas generaciones)
SELECT login_FK, COUNT(*) AS participaciones, GROUP_CONCAT(generacion ORDER BY generacion) AS generaciones
FROM aspirantes
WHERE login_FK IS NOT NULL AND login_FK != ''
GROUP BY login_FK
HAVING COUNT(*) > 1;

-- Estructura de aspirantes (id_asp, generación, login)
SELECT id_asp, generacion, nombres, ap_pat, ap_mat, email, login_FK, fecha_alta
FROM aspirantes
WHERE login_FK = 'correo@ejemplo.com'
ORDER BY generacion DESC;
```

Con esto se puede revisar que no haya duplicados indeseados (mismo login + misma generación) y validar el flujo de reactivación contra datos reales.
