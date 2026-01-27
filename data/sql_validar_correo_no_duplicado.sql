-- Validación beforeInsert: correo no repetido para el mismo aspirante
-- Si total > 0, "Este recomendante ya está asignado"
-- Usar sc_sql_injection para id_asp y correo

SELECT COUNT(*) AS total 
FROM asp_recomendantes ar 
INNER JOIN recomendantes r ON ar.id_recom_FK = r.id_recom
WHERE ar.id_asp_FK = {id_asp} 
  AND r.correo = {correo};
