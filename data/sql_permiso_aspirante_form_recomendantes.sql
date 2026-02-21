-- =============================================================================
-- Activar ítem "Recomendantes" en el menú del Aspirante
-- BD: sce_asp
-- Si el enlace "Recomendantes" aparece deshabilitado (gris), el grupo Aspirante (2)
-- no tiene priv_access = 'Y' para form_recomendantes en sec_asp_groups_apps.
-- =============================================================================

USE sce_asp;

UPDATE sec_asp_groups_apps
SET priv_access = 'Y',
    priv_insert = COALESCE(priv_insert, 'N'),
    priv_delete = COALESCE(priv_delete, 'N'),
    priv_update = COALESCE(priv_update, 'Y'),
    priv_export = COALESCE(priv_export, 'N'),
    priv_print  = COALESCE(priv_print,  'N')
WHERE group_id = 2 AND app_name IN ('form_recomendantes', 'form_recomendantes_1');

SELECT group_id, app_name, priv_access, priv_insert, priv_update
FROM sec_asp_groups_apps
WHERE group_id = 2 AND app_name IN ('form_recomendantes', 'form_recomendantes_1');
