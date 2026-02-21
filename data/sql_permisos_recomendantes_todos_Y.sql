-- =============================================================================
-- Dar todos los permisos (Sí = Y) a las apps de recomendantes para el grupo 7 (Recomendante)
-- BD: sce_asp
-- =============================================================================

USE sce_asp;

-- 1) Poner app_type donde esté vacío (para que el botón Guardar funcione en Grupos/Aplicaciones)
UPDATE sec_asp_apps SET app_type = 'form',  description = COALESCE(NULLIF(TRIM(description), ''), 'Form Agregar Recomendante')     WHERE app_name = 'form_agregar_recomendante';
UPDATE sec_asp_apps SET app_type = 'form',  description = COALESCE(NULLIF(TRIM(description), ''), 'Form Asp Recomendantes respaldo') WHERE app_name = 'form_asp_recomendantes_respaldo';
UPDATE sec_asp_apps SET app_type = 'cons',  description = COALESCE(NULLIF(TRIM(description), ''), 'Grid Aspirante Recomendantes')    WHERE app_name = 'grid_aspirante_recomendantes';
UPDATE sec_asp_apps SET app_type = 'menu',  description = COALESCE(NULLIF(TRIM(description), ''), 'Menu Recomendantes')               WHERE app_name = 'Menu_Recomendantes';

-- 2) Grupo 7 = Recomendante: todos los permisos en Y para estas 8 apps
INSERT INTO sec_asp_groups_apps (group_id, app_name, priv_access, priv_insert, priv_delete, priv_update, priv_export, priv_print)
VALUES
  (7, 'form_agregar_recomendante',       'Y', 'Y', 'Y', 'Y', 'Y', 'Y'),
  (7, 'form_asp_recomendantes',          'Y', 'Y', 'Y', 'Y', 'Y', 'Y'),
  (7, 'form_asp_recomendantes_respaldo', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y'),
  (7, 'form_recomendantes',              'Y', 'Y', 'Y', 'Y', 'Y', 'Y'),
  (7, 'form_recomendantes_1',            'Y', 'Y', 'Y', 'Y', 'Y', 'Y'),
  (7, 'grid_aspirante_recomendantes',    'Y', 'Y', 'Y', 'Y', 'Y', 'Y'),
  (7, 'grid_asp_recomendantes',          'Y', 'Y', 'Y', 'Y', 'Y', 'Y'),
  (7, 'Menu_Recomendantes',              'Y', 'Y', 'Y', 'Y', 'Y', 'Y')
ON DUPLICATE KEY UPDATE
  priv_access = 'Y',
  priv_insert = 'Y',
  priv_delete = 'Y',
  priv_update = 'Y',
  priv_export = 'Y',
  priv_print  = 'Y';

-- 3) Comprobar
SELECT group_id, app_name, priv_access, priv_insert, priv_delete, priv_update, priv_export, priv_print
FROM sec_asp_groups_apps
WHERE group_id = 7 AND app_name IN (
  'form_agregar_recomendante', 'form_asp_recomendantes', 'form_asp_recomendantes_respaldo',
  'form_recomendantes', 'form_recomendantes_1', 'grid_aspirante_recomendantes',
  'grid_asp_recomendantes', 'Menu_Recomendantes'
)
ORDER BY app_name;
