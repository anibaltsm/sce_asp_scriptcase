-- =============================================================================
-- DIAGNÓSTICO: form_asp_requisitos_1 y grupo Recomendante (solo lectura, no inserta nada)
-- BD: sce_asp
-- Ejecutar PRIMERO para ver el estado actual antes de aplicar cualquier corrección.
-- =============================================================================

USE sce_asp;

-- 1) Grupos existentes (el de Recomendantes suele ser group_id = 7)
SELECT '1. Grupos (sec_asp_groups)' AS paso;
SELECT group_id, description FROM sec_asp_groups ORDER BY group_id;

-- 2) ¿Existe form_asp_requisitos_1 en sec_asp_apps? (si no existe o app_type vacío, no se ve Guardar en pantalla de permisos)
SELECT '2. App form_asp_requisitos_1 en sec_asp_apps' AS paso;
SELECT app_name, app_type, description
FROM sec_asp_apps
WHERE app_name = 'form_asp_requisitos_1';
-- Si no sale ninguna fila → la app no está registrada.
-- Si app_type está NULL o '' → en Grupos/Aplicaciones no aparece el botón Guardar para esa fila.

-- 3) Permisos actuales de form_asp_requisitos_1 por grupo (quién tiene acceso y actualización)
SELECT '3. Permisos por grupo para form_asp_requisitos_1 (sec_asp_groups_apps)' AS paso;
SELECT g.group_id, g.description, a.app_name,
       a.priv_access, a.priv_insert, a.priv_delete, a.priv_update, a.priv_export, a.priv_print
FROM sec_asp_groups g
LEFT JOIN sec_asp_groups_apps a ON a.group_id = g.group_id AND a.app_name = 'form_asp_requisitos_1'
ORDER BY g.group_id;
-- Si para group_id=7 (Recomendante) no hay fila, o priv_access/priv_update son 'N' o NULL,
-- el usuario Recomendante no verá el botón Guardar al abrir el form.

-- 4) Solo grupo Recomendante (7) y esta app
SELECT '4. Solo grupo 7 (Recomendante) y form_asp_requisitos_1' AS paso;
SELECT group_id, app_name, priv_access, priv_insert, priv_delete, priv_update, priv_export, priv_print
FROM sec_asp_groups_apps
WHERE app_name = 'form_asp_requisitos_1' AND group_id = 7;
-- Vacío = no hay permiso para Recomendante. Para ver el Guardar hace falta priv_access='Y' y priv_update='Y'.
