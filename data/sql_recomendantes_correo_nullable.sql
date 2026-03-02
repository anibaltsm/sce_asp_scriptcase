-- =============================================================================
-- Permitir NULL en recomendantes.correo (solución "Column 'correo' cannot be null")
-- =============================================================================
-- Motivo: En app_form_add_users, al dar de alta un nuevo aspirante se insertan
-- 3 filas en recomendantes con correo=NULL (placeholders); el aspirante llena
-- después los correos en form_recomendantes. La columna estaba NOT NULL y
-- rechazaba ese INSERT.
--
-- Documentación: En MySQL, UNIQUE permite múltiples NULL (cada NULL se considera
-- distinto). Es la práctica estándar usar NULL para "valor no definido aún".
-- Ref: Stack Overflow "MySQL better to insert NULL or empty string";
--      MySQL UNIQUE constraint allows multiple NULLs.
--
-- Ejecutar en el entorno donde aparezca el error (ej. producción):
--   mysql -u root -p sce_asp < data/sql_recomendantes_correo_nullable.sql
-- o desde mysql:
--   SOURCE /ruta/sce_asp_scriptcase/data/sql_recomendantes_correo_nullable.sql;
-- =============================================================================

USE sce_asp;

ALTER TABLE recomendantes
  MODIFY COLUMN `correo` varchar(80) DEFAULT NULL;

-- Opcional: comprobar que quedó nullable
-- SHOW CREATE TABLE recomendantes;
