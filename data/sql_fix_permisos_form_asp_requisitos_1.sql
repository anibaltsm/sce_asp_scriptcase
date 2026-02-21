-- =============================================================================
-- Dejar en orden permisos de form_asp_requisitos_1 (sin NULL)
-- BD: sce_asp
-- Si priv_access, priv_insert, etc. están en NULL, la interfaz de ScriptCase
-- a veces no muestra o no habilita el botón Guardar.
-- =============================================================================

USE sce_asp;

-- 1) Poner valores explícitos Y/N donde estén NULL para form_asp_requisitos_1
--    Ejemplo: acceso solo para grupos 2 (Aspirante), 3 (Administrativo), 4 (Evaluador), 6 (Secretario)
UPDATE sec_asp_groups_apps
SET
  priv_access = COALESCE(priv_access, CASE WHEN group_id IN (2, 3, 4, 6) THEN 'Y' ELSE 'N' END),
  priv_insert = COALESCE(priv_insert, 'N'),
  priv_delete = COALESCE(priv_delete, 'N'),
  priv_update = COALESCE(priv_update, CASE WHEN group_id IN (2, 3, 4, 6) THEN 'Y' ELSE 'N' END),
  priv_export = COALESCE(priv_export, 'N'),
  priv_print  = COALESCE(priv_print,  'N')
WHERE app_name = 'form_asp_requisitos_1';

-- 2) Opcional: quitar .DS_Store de sec_asp_apps (puede romper la pantalla de permisos)
DELETE FROM sec_asp_groups_apps WHERE app_name = '.DS_Store';
DELETE FROM sec_asp_apps WHERE app_name = '.DS_Store';

-- 3) Comprobar resultado
SELECT group_id, app_name, priv_access, priv_insert, priv_delete, priv_update, priv_export, priv_print
FROM sec_asp_groups_apps
WHERE app_name = 'form_asp_requisitos_1'
ORDER BY group_id;
