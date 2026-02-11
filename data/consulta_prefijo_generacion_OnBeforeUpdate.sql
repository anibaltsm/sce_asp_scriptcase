-- =============================================================================
-- Consultas para verificar datos usados en form de requisitos (OnBeforeUpdate)
-- Ejecutar: mysql -u root -p sce_asp < consulta_prefijo_generacion_OnBeforeUpdate.sql
-- O por partes con: mysql -u root -p515t3ma5 sce_asp -e "..."
-- =============================================================================

-- 1) Prefijo desde asp_requisitos (registro que se está actualizando)
--    Sustituir 20 por el id_asp_req del formulario
SELECT prefijo_requisito 
FROM asp_requisitos 
WHERE id_asp_req = 20;

-- 2) Mismo registro por id_asp + num_req (por si el form no tiene id_asp_req)
--    Ejemplo: id_asp_FK = 1273, num_req = 10
SELECT id_asp_req, id_asp_FK, num_req, prefijo_requisito, archivo 
FROM asp_requisitos 
WHERE id_asp_FK = 1273 AND num_req = 10;

-- 3) Generación activa desde sce (convocatorias_posg)
--    Ejecutar contra BD sce: mysql -u root -p515t3ma5 sce -e "SELECT ..."
SELECT generacion 
FROM sce.convocatorias_posg 
WHERE cc_activa = 1 
  AND (id_prog_FK <> 9 OR ISNULL(id_prog_FK))
LIMIT 1;

-- 4) Si asp_requisitos no tiene columna prefijo_requisito, agregarla:
-- ALTER TABLE asp_requisitos ADD COLUMN prefijo_requisito VARCHAR(255) DEFAULT NULL;
