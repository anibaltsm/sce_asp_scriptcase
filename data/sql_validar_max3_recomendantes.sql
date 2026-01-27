-- Validación beforeInsert: máximo 3 recomendantes por aspirante
-- Si total >= 3, mostrar error y cancelar

SELECT COUNT(*) AS total 
FROM asp_recomendantes 
WHERE id_asp_FK = {id_asp};
