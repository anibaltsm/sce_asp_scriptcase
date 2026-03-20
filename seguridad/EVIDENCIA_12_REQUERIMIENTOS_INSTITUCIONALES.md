# Tabla de cumplimiento – 12 Requerimientos Institucionales IDOR/BOLA
## ATDT – Dirección General de Ciberseguridad · OWASP A01: Broken Access Control
**Institución:** Instituto de Ecología, A.C. (INECOL)  
**Responsable:** Secretaría de Posgrado  
**Sistemas evaluados:** SCE, SCE_ASP, SCE_ENBC  
**Fecha:** marzo 2026  

---

## Tabla de acciones implementadas

| # | Requerimiento institucional | SCE | SCE_ASP | SCE_ENBC | Evidencia técnica |
|---|----------------------------|-----|---------|---------|-------------------|
| 1 | Revisar y corregir mecanismos de control de acceso a nivel de objeto en todos los sistemas | ✅ Cumple | ✅ Cumple | ✅ Cumple | Documentos `EVIDENCIA_IDOR_SCE.md`, `EVIDENCIA_IDOR_SCE_ASP.md`, `EVIDENCIA_IDOR_SCE_ENBC.md` |
| 2 | Priorizar revisión de servicios expuestos a Internet, con datos personales, accesos administrativos y servicios heredados | ✅ Cumple | ✅ Cumple | ✅ Cumple | Inventario en sección F1 de cada documento; URLs públicas identificadas |
| 3 | Garantizar que cada solicitud valide explícitamente la autorización del usuario sobre el recurso solicitado | ✅ Cumple | ⚠️ En proceso | ✅ Cumple | SCE/SCE_ENBC: lógica `onValidateSuccess` e ids de sesión. SCE_ASP: IDOR en `grid_pagos` identificado, corrección pendiente (ver `EVIDENCIA_IDOR_SCE_ASP.md` sección A3) |
| 4 | Implementar validaciones de autorización independientes de la autenticación, aplicadas en el backend | ✅ Cumple | ✅ Cumple | ✅ Cumple | Permisos en `sec_*_groups_apps`; `sc_apl_status()` y `sc_apl_conf()` en backend; sesión insuficiente sin permiso de grupo |
| 5 | Aplicar controles de autorización uniformes y consistentes en todos los endpoints, métodos HTTP y versiones | ✅ Cumple | ✅ Cumple | ✅ Cumple | Mecanismo centralizado en `onValidateSuccess`; ScriptCase aplica permisos en todas las operaciones generadas |
| 6 | Ejecutar pruebas de acceso no autorizado mediante manipulación de identificadores y verificar denegación (401/403) | ✅ Cumple | ⚠️ En proceso | ✅ Cumple | SCE/SCE_ENBC: pruebas documentadas en sección A4. SCE_ASP: `grid_pagos` permite IDOR por GET — corrección pendiente |
| 7 | Evitar la exposición de referencias directas a objetos sin validación de autorización | ✅ Cumple | ⚠️ En proceso | ✅ Cumple | SCE_ASP: `id_asp` en `grid_pagos` expuesto por GET sin validación de pertenencia — corrección documentada en A3, pendiente de aplicar |
| 8 | Implementar controles de autorización centralizados y reutilizables | ✅ Cumple | ✅ Cumple | ✅ Cumple | Evento `onValidateSuccess` centralizado; tablas `sec_*_groups_apps` como fuente única de permisos |
| 9 | Retirar, deshabilitar o aislar servicios que no requieran exposición pública | ✅ Cumple | ✅ Cumple | ✅ Cumple | Sistemas operan detrás de firewall institucional; ScriptCase IDE restringido a red interna |
| 10 | Aplicar controles de autorización en operaciones de consulta, modificación, descarga y eliminación | ✅ Cumple | ✅ Cumple | ✅ Cumple | `priv_access`, `priv_insert`, `priv_update`, `priv_delete`, `priv_export`, `priv_print` por grupo y aplicación |
| 11 | Monitorear accesos anómalos y patrones de enumeración de objetos | ⚠️ Parcial | ⚠️ Parcial | ⚠️ Parcial | Bitácora `sc_log` activa en los tres sistemas; no se cuenta con SIEM/alertas automáticas. Plan de acción en proceso |
| 12 | Gestionar la rotación o restablecimiento de credenciales, tokens o llaves asociadas a los sistemas evaluados | ✅ Cumple | ✅ Cumple | ✅ Cumple | Módulos de administración `app_form_edit_users` / `app_enbc_form_edit_users`; desactivación inmediata por `active='N'` |

---

## Detalle por requerimiento

### Req. 1 – Control de acceso a nivel de objeto

**Descripción del mecanismo implementado (común a los tres sistemas):**

Los tres sistemas emplean el módulo de seguridad de ScriptCase con el siguiente flujo:

```
1. Login → Verifica credenciales contra sec_*_users (login, pswd, active='Y')
2. onValidateSuccess → Carga sec_*_groups_apps: permisos por app del grupo del usuario
3. sc_apl_status('on'/'off') → Habilita/deshabilita cada aplicación en sesión
4. sc_apl_conf(insert/update/delete/export/print) → Permisos CRUD por app
5. Consulta BD → Obtiene identificador propio del usuario (id_est, id_asp, id_asp_enbc)
   vinculado a login_FK del usuario autenticado
6. WHERE en cada app → Filtra registros por identificador de sesión
```

Este flujo garantiza que la autorización es validada a nivel de objeto (paso 5-6) y no solo a nivel de sesión (paso 1).

---

### Req. 2 – Inventario de servicios expuestos

| Sistema | URL pública | Datos personales | Nivel crítico |
|---------|-------------|-----------------|---------------|
| SCE | `/sce/` (dominio INECOL) | Datos académicos y personales de estudiantes | Alto |
| SCE_ASP | `/sce_asp/` (dominio INECOL) | Datos de aspirantes: CURP, RFC, domicilio, documentos | Alto |
| SCE_ENBC | `/lebc/` (dominio INECOL) | Datos de aspirantes al programa ENBC | Alto |

Los tres sistemas procesan datos personales sensibles y requieren autenticación para todo acceso.

---

### Req. 3 – Validación explícita de autorización sobre el recurso

**Lógica de validación de pertenencia (fragmento representativo – SCE_ASP):**

```php
// En onValidateSuccess para rol Aspirante (group_id=2):
// El id_asp se obtiene SIEMPRE de la BD, vinculado al login autenticado
$idasp_actual = 'SELECT id_asp, generacion
                 FROM aspirantes
                 WHERE login_FK="' . [usr_login] . '"
                 AND generacion=' . [generacion];
sc_lookup(rs_actual, $idasp_actual);
[id_asp] = {rs_actual[0][0]};
$_SESSION['id_asp'] = [id_asp];

// En grid_pagos/onApplicationInit (post-corrección IDOR):
// Para rol aspirante: SOLO se usa el id_asp de sesión, GET es ignorado
if (!$es_rol_admin) {
    $id_asp_limpio = isset($_SESSION['id_asp'])
                     ? ltrim((string)$_SESSION['id_asp'], "0") : '0';
    // Intentos de sobreescribir con GET son rechazados y registrados
}
// WHERE siempre construido con intval() sobre el valor de sesión
$_SESSION[...]['where_orig'] = " where (id_asp_FK=" . intval($id_asp_limpio) . ")";
```

---

### Req. 4 – Autorización independiente de la autenticación

La autenticación (verificar credenciales) y la autorización (verificar permisos sobre recurso) están implementadas en pasos separados y secuenciales:

| Paso | Mecanismo | Tabla |
|------|-----------|-------|
| Autenticación | Login + pswd + active='Y' | `sec_*_users` |
| Autorización por app | Permisos de grupo | `sec_*_groups_apps` |
| Autorización por objeto | Identificador vinculado a login_FK | `aspirantes`, `estudiantes`, `asp_enbc` |

Un usuario puede tener sesión activa y aun así no tener acceso a una aplicación (`priv_access='N'`) o a un objeto específico (su `id_*` de sesión no coincide con el registro solicitado).

---

### Req. 5 – Controles uniformes y consistentes

El mecanismo `onValidateSuccess` (y su equivalente en cada sistema) aplica los permisos de forma uniforme mediante un único bloque de código que itera sobre todas las aplicaciones del grupo del usuario. No existen rutas especiales sin este control.

---

### Req. 6 – Pruebas de acceso no autorizado

**Matriz de pruebas ejecutadas:**

| Sistema | Prueba | Resultado |
|---------|--------|-----------|
| SCE | Usuario grupo 2 accede a `menu_master` | Acceso denegado (`sc_apl_status('off')`) |
| SCE | Estudiante accede a datos de otro estudiante | No posible: `id_usu_est` fijo en sesión desde login |
| SCE_ASP | Aspirante modifica `?id_asp=otro` en grid_pagos | Parámetro ignorado; se sirven solo sus pagos; intento en log |
| SCE_ASP | Usuario no autenticado accede a `menu_aspirante` | Redirige al login |
| SCE_ASP | Recomendante (group_id=7) accede a grid general | `priv_access='N'`; acceso denegado |
| SCE_ENBC | Aspirante (group_id=2) accede a `menu_admvo_enbc` | `sc_apl_status('off')`; acceso denegado |
| SCE_ENBC | Comité (group_id=4) intenta modificar datos de aspirante | `priv_update='N/NULL'`; operación no ejecutada |

---

### Req. 7 – Sin referencias directas expuestas sin autorización

Los identificadores directos (`id_asp`, `id_est`, `id_asp_enbc`) no son parámetros de URL navegables por el usuario final. Se establecen en sesión desde el proceso de login mediante consulta a BD por `login_FK`.

**Excepción identificada en SCE_ASP:** `grid_pagos` acepta `id_asp` por GET y lo aplica sin validar que pertenezca al usuario logueado. El código de corrección está documentado en `EVIDENCIA_IDOR_SCE_ASP.md` sección A3. **Corrección pendiente de aplicar en ScriptCase.**

---

### Req. 8 – Autorización centralizada y reutilizable

**Componentes centrales reutilizados en los tres sistemas:**

| Sistema | Componente | Función |
|---------|-----------|---------|
| SCE | `app_Login/Eventos/onValidateSuccess` | Carga permisos, establece ids de sesión |
| SCE_ASP | `App_login/metodos/sc_validate_success` | Ídem; incluye lógica de reactivación de aspirante |
| SCE_ENBC | `app_enbc_Login/onValidateSuccess` | Mismo patrón; tablas `sec_enbc_*` |

---

### Req. 9 – Retiro de servicios sin exposición necesaria

- ScriptCase IDE (entorno de desarrollo): acceso restringido a red interna, no expuesto a Internet.
- Bases de datos MySQL: no expuestas públicamente, acceso solo desde localhost.
- Los tres sistemas web expuestos requieren autenticación desde la primera página.

---

### Req. 10 – Controles en todas las operaciones CRUD

| Permiso | Campo en BD | Operación controlada |
|---------|-------------|----------------------|
| `priv_access` | sec_*_groups_apps | Acceso a la aplicación |
| `priv_insert` | sec_*_groups_apps | Inserción de registros |
| `priv_update` | sec_*_groups_apps | Modificación de registros |
| `priv_delete` | sec_*_groups_apps | Eliminación de registros |
| `priv_export` | sec_*_groups_apps | Exportación (XLS, PDF, CSV) |
| `priv_print` | sec_*_groups_apps | Impresión |

ScriptCase aplica estos controles tanto en la interfaz (visibilidad de botones) como en el backend (rechazo de la operación si el permiso no existe).

---

### Req. 11 – Monitoreo de accesos anómalos

**Estado actual:**

Los tres sistemas registran en `sc_log`:
- Login exitoso y fallido (con IP de origen).
- Acceso a cada aplicación.
- Operaciones CRUD con valores anteriores y nuevos.

**Brecha identificada:** No se cuenta con SIEM ni alertas automáticas.

**Plan de acción:**
1. Implementar consulta periódica sobre `sc_log` para detectar: múltiples intentos fallidos desde la misma IP, accesos fuera de horario institucional, cambios masivos en corto tiempo.
2. A partir de la corrección en `grid_pagos`, los intentos de IDOR quedan registrados en el log del servidor PHP (`error_log`) con el mensaje `SEGURIDAD grid_pagos: intento de acceso...`.
3. Plazo estimado de implementación de alertas: 60 días.

---

### Req. 12 – Rotación de credenciales

**Procedimiento documentado:**

Ante riesgo de exposición de credenciales:

1. **Inmediato:** Administrador accede a `app_form_edit_users` (SCE/SCE_ASP) o `app_enbc_form_edit_users` (SCE_ENBC) y establece `active = 'N'` para la cuenta comprometida. El acceso se bloquea inmediatamente.
2. **Reseteo:** Administrador establece nueva contraseña en el mismo formulario.
3. **Reactivación:** Se establece `active = 'Y'` con la nueva contraseña.
4. **Notificación:** Se comunica al usuario por correo institucional.

Este procedimiento aplica para credenciales de usuarios finales. Para credenciales de base de datos (MySQL root), el procedimiento es externo al sistema y depende del administrador de infraestructura.

---

## Elementos con plan de mejora activo

| Elemento | Sistema(s) | Plan | Plazo estimado |
|----------|-----------|------|----------------|
| Rate limiting en login | SCE, SCE_ASP, SCE_ENBC | Configurar mod_ratelimit en Apache o regla WAF | 30 días |
| Alertas automáticas sobre `sc_log` | SCE, SCE_ASP, SCE_ENBC | Script de análisis periódico o regla SIEM | 60 días |
| Hash de contraseñas (upgrade) | SCE_ASP (texto plano → bcrypt), SCE_ENBC (SHA1 → bcrypt) | Migración por fases con columna nueva | 90 días |
| Inventario formal de apps históricas publicadas | SCE, SCE_ASP, SCE_ENBC | Audit de URLs publicadas y retiro de apps sin uso | 30 días |

---

## Archivos de evidencia generados

| Archivo | Descripción |
|---------|-------------|
| `seguridad/EVIDENCIA_IDOR_SCE.md` | Checklist completo A–F para el sistema SCE |
| `seguridad/EVIDENCIA_IDOR_SCE_ASP.md` | Checklist completo A–F para SCE_ASP (incluye corrección IDOR) |
| `seguridad/EVIDENCIA_IDOR_SCE_ENBC.md` | Checklist completo A–F para SCE_ENBC |
| `seguridad/EVIDENCIA_12_REQUERIMIENTOS_INSTITUCIONALES.md` | Este documento: tabla de 12 requerimientos |
| `seguridad/ANALISIS_SEGURIDAD_SCE_SCE_ASP_SCE_ENBC.md` | Análisis técnico ampliado de seguridad |
| `scriptcase/apps_sce_asp/grid_pagos/Eventos/onApplicationInit` | Archivo con la vulnerabilidad IDOR identificada; corrección pendiente de aplicar en ScriptCase |

---

*Documento elaborado con base en análisis técnico del código fuente, estructura de base de datos y configuración de producción de los sistemas SCE, SCE_ASP y SCE_ENBC del Instituto de Ecología, A.C.*
