# Indice de anexos de evidencia — Paquete IDOR/BOLA ATDT

Cada anexo contiene evidencia primaria verificable. Las referencias del informe principal y los checklists apuntan a estos anexos.

---

## Anexos incluidos

| Anexo | Titulo | Contenido | Formato | Estado | Responsable |
|-------|--------|-----------|---------|--------|-------------|
| A | Arquitectura de autorizacion | Diagrama de flujo login -> permisos -> menu para los 3 sistemas. | Diagrama/PNG | En proceso | [NOMBRE] |
| B | Fragmentos de codigo de autorizacion | Fragmentos sanitizados de `onValidate`, `onValidateSuccess`, `sc_validate_success` y validaciones de sesion. | MD/PDF | En proceso | [NOMBRE] |
| C | Inventario de sistemas y respaldos | Inventario de URLs publicas + estado de respaldos movidos fuera de `htdocs`. | MD/PDF | Actualizado | [NOMBRE] |
| D | Estructura de tablas de seguridad | `DESCRIBE` y conteos agregados por grupo (sin exponer datos sensibles). | MD/PDF | En proceso | [NOMBRE] |
| E | Evidencia operativa minima | Capturas de bloqueo por permisos, login fail + log, y HTTPS activo. | PNG/JPG | Pendiente | Responsable operativo |
| F | Extractos de sc_log | Resumen por accion y ejemplos sanitizados de eventos. | MD/PDF | En proceso | [NOMBRE] |
| G | Configuracion SSL/Apache | Evidencia de HTTPS y modulo de control de trafico cargado. | MD/PDF | En proceso | [NOMBRE] |
| H | Plan de cierre | Plan de acciones y estado de cierre. | MD/PDF | Actualizado | [NOMBRE] |

---

## Anexo B — Minimo recomendado (sanitizado)

Incluir solo fragmentos necesarios (sin rutas absolutas de servidor ni datos sensibles):

1. `scriptcase/apps_sce/app_Login/Eventos/onValidate`
2. `scriptcase/apps_sce/app_Login/Eventos/onValidateSuccess`
3. `scriptcase/apps_sce_asp/App_login/metodos/sc_validate_success`
4. `scriptcase/apps_sce_asp/form_recomendantes/Eventos/onApplicationInit`
5. `scriptcase/apps_sce_asp/App_login/Eventos/onApplicationInit`
6. `scriptcase/apps_sce_asp/App_login/Eventos/onScriptInit`

---

## Anexo C — Inventario de sistemas y respaldos (estado real)

| # | Sistema | URL publica | BD | Usuarios | Grupos | Criticidad | Respaldo movido fuera de htdocs |
|---|---------|-------------|----|---------:|-------:|------------|----------------------------------|
| 1 | SCE | https://posgrados.inecol.mx/sce/ | sce | 2,166 | 11 | Alto | `app_Login_copia`, `app_Login_respaldo`, `app_Login_resp29102024`, `app_form_add_users_respaldo` -> `/opt/sce_asp_scriptcase/respaldos_apps_scriptcase/sce/` |
| 2 | SCE_ASP | https://posgrados.inecol.mx/sce_asp/ | sce_asp | 1,366 | 6 | Alto | `app_form_add_users_correcto`, `app_form_add_users_danado`, `app_form_add_users_respaldo` -> `/opt/sce_asp_scriptcase/respaldos_apps_scriptcase/sce_asp/` |
| 3 | SCE_ENBC | https://posgrados.inecol.mx/sce_enbc/ | sce_enbc | 66 | 4 | Medio | `respaldo_app_enbc_Login`, `app_enbc_form_add_users_eliminar` -> `/opt/sce_asp_scriptcase/respaldos_apps_scriptcase/sce_enbc/` |

### Nota operativa
- Estado actual: respaldos de SCE, SCE_ASP y SCE_ENBC ya movidos fuera de `htdocs` a `/opt/sce_asp_scriptcase/respaldos_apps_scriptcase/` por sistema.

---

## Anexo D — Consultas permitidas (sin exponer datos personales)

```sql
-- Estructura (sin datos)
DESCRIBE sec_[prefix]users;
DESCRIBE sec_[prefix]groups;
DESCRIBE sec_[prefix]groups_apps;
DESCRIBE sec_[prefix]users_groups;

-- Conteos agregados
SELECT g.group_id, g.description, COUNT(ug.login) AS num_users
FROM sec_[prefix]groups g
LEFT JOIN sec_[prefix]users_groups ug ON g.group_id = ug.group_id
GROUP BY g.group_id, g.description;

SELECT action, COUNT(*) AS total
FROM sc_log
GROUP BY action
ORDER BY total DESC;
```

---

## Anexo E — Formato de captura (para responsable operativo)

Ver archivo `CAPTURAS_PENDIENTES_FERNANDO.md`.

**Plantilla obligatoria por captura (copiar/pegar):**

<span style="color:red"><strong>[CAPTURA_ID]</strong></span>  
<span style="color:red"><strong>Titulo:</strong> [Ej. Bloqueo por permisos en SCE]</span>  
<span style="color:red"><strong>Debe verse:</strong> URL completa + usuario/rol de prueba + mensaje de bloqueo o resultado esperado</span>  
<span style="color:red"><strong>Pie de foto:</strong> [Que representa la imagen, por que prueba control de autorizacion y resultado esperado/obtenido]</span>

---

## Anexo G — Configuracion SSL/Apache

Archivos de referencia:
1. `/opt/lampp/etc/extra/httpd-vhosts.conf`
2. `/opt/lampp/etc/extra/httpd-ssl.conf`
3. `/opt/lampp/etc/httpd.conf` (modulos de control cargados)

---

## Anexo H — Plan de cierre

Ver: `05_Plan_Accion/PLAN_ACCION_CIERRE.md`
