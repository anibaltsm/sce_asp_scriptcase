-- =============================================================================
-- Registrar aplicación en sec_asp_apps para poder asignar permisos por grupo
-- BD: sce_asp
-- Si la app no está en sec_asp_apps, en el módulo de seguridad no aparece
-- el botón Guardar al dar permisos a esa aplicación.
-- =============================================================================

USE sce_asp;

-- Registrar form_asp_requisitos_1 (cambiar app_name si tu aplicación tiene otro nombre)
INSERT IGNORE INTO sec_asp_apps (app_name, app_type, description)
VALUES ('form_asp_requisitos_1', 'form', 'Form Asp Requisitos 1');

-- Comprobar que existe
SELECT * FROM sec_asp_apps WHERE app_name = 'form_asp_requisitos_1';

-- Opcional: dar permisos a un grupo (ej. group_id = 2: acceso + actualización)
-- Ajusta group_id y los Y/N según tu necesidad
-- INSERT INTO sec_asp_groups_apps (group_id, app_name, priv_access, priv_insert, priv_delete, priv_update, priv_export, priv_print)
-- VALUES (2, 'form_asp_requisitos_1', 'Y', 'N', 'N', 'Y', 'N', 'N')
-- ON DUPLICATE KEY UPDATE
--   priv_access = VALUES(priv_access),
--   priv_insert = VALUES(priv_insert),
--   priv_delete = VALUES(priv_delete),
--   priv_update = VALUES(priv_update),
--   priv_export = VALUES(priv_export),
--   priv_print = VALUES(priv_print);
