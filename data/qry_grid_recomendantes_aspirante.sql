-- Consulta para el grid grid_recomendantes_aspirante
-- Fuente: asp_recomendantes + JOIN recomendantes
-- Filtro: id_asp_FK = {id_asp} (sesión del aspirante)
-- Usar en ScriptCase como "Consulta" del grid.

SELECT 
    ar.id_asp_recom,
    ar.id_asp_FK,
    ar.id_recom_FK,
    ar.num_req,
    CONCAT(r.nombre, ' ', r.apellido_p, ' ', IFNULL(r.apellido_m, '')) AS nombre_completo,
    r.nombre,
    r.apellido_p,
    r.apellido_m,
    r.correo
FROM asp_recomendantes ar
INNER JOIN recomendantes r ON r.id_recom = ar.id_recom_FK
WHERE ar.id_asp_FK = {id_asp}
ORDER BY ar.id_asp_recom;
