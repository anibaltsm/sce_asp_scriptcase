-- =============================================================================
-- Corregir form_recomendantes_1 para que permita guardar en Grupos/Aplicaciones
-- BD: sce_asp
--
-- DIFERENCIA ENCONTRADA:
-- - form_asp_recomendantes (SÍ deja guardar): app_type = 'form' en sec_asp_apps
-- - form_recomendantes_1 (NO deja guardar): app_type = '' (vacío) en sec_asp_apps
-- ScriptCase usa app_type para tratar la fila como aplicación editable.
-- =============================================================================

USE sce_asp;

-- 1) Poner app_type y description como en la que sí funciona (form_asp_recomendantes)
UPDATE sec_asp_apps
SET app_type = 'form',
    description = COALESCE(NULLIF(description, ''), 'Form Recomendantes (aspirante)')
WHERE app_name IN ('form_recomendantes_1', 'form_recomendantes');

-- 2) Asegurar que los permisos en sec_asp_groups_apps sean Y/N (no vacíos)
UPDATE sec_asp_groups_apps
SET priv_access = COALESCE(NULLIF(TRIM(priv_access), ''), 'N'),
    priv_insert = COALESCE(NULLIF(TRIM(priv_insert), ''), 'N'),
    priv_delete = COALESCE(NULLIF(TRIM(priv_delete), ''), 'N'),
    priv_update = COALESCE(NULLIF(TRIM(priv_update), ''), 'N'),
    priv_export = COALESCE(NULLIF(TRIM(priv_export), ''), 'N'),
    priv_print  = COALESCE(NULLIF(TRIM(priv_print),  ''), 'N')
WHERE app_name = 'form_recomendantes_1';

-- 3) Comprobar
SELECT app_name, app_type, description FROM sec_asp_apps
WHERE app_name IN ('form_asp_recomendantes', 'form_recomendantes_1', 'form_recomendantes')
ORDER BY app_name;

SELECT group_id, app_name, priv_access, priv_insert, priv_delete, priv_update, priv_export, priv_print
FROM sec_asp_groups_apps WHERE app_name = 'form_recomendantes_1';
