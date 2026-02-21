-- =============================================================================
-- form_asp_requisitos_1: que se vea el botón Guardar (grupo RECOMENDANTE = 7)
-- BD: sce_asp
-- =============================================================================
-- ANTES DE EJECUTAR: correr sql_diagnostico_form_asp_requisitos_1.sql para ver
-- el estado actual en sec_asp_apps y sec_asp_groups_apps.
--
-- Este script:
-- 1) Asegura que la app esté en sec_asp_apps con app_type = 'form'.
-- 2) Da permisos al grupo 7 (Recomendante) para que al abrir el form vean el Guardar.
-- =============================================================================

USE sce_asp;

-- 1) Asegurar que la app esté en sec_asp_apps con app_type = 'form'
--    (necesario para que en Grupos/Aplicaciones aparezca el Guardar)
INSERT IGNORE INTO sec_asp_apps (app_name, app_type, description)
VALUES ('form_asp_requisitos_1', 'form', 'Form Asp Requisitos 1');

UPDATE sec_asp_apps
SET app_type = 'form',
    description = COALESCE(NULLIF(TRIM(description), ''), 'Form Asp Requisitos 1')
WHERE app_name = 'form_asp_requisitos_1';

-- 2) Permisos para el grupo RECOMENDANTE (group_id = 7): que vean el botón Guardar
INSERT INTO sec_asp_groups_apps (group_id, app_name, priv_access, priv_insert, priv_delete, priv_update, priv_export, priv_print)
VALUES (7, 'form_asp_requisitos_1', 'Y', 'Y', 'N', 'Y', 'N', 'N')
ON DUPLICATE KEY UPDATE
  priv_access = 'Y',
  priv_insert = 'Y',
  priv_update = 'Y',
  priv_delete = 'N',
  priv_export = 'N',
  priv_print  = 'N';

-- Comprobar resultado
SELECT 'sec_asp_apps' AS tabla, app_name, app_type, description
FROM sec_asp_apps WHERE app_name = 'form_asp_requisitos_1';

SELECT 'sec_asp_groups_apps (grupo 7 = Recomendante)' AS tabla, group_id, app_name, priv_access, priv_insert, priv_update
FROM sec_asp_groups_apps WHERE app_name = 'form_asp_requisitos_1' AND group_id = 7;
