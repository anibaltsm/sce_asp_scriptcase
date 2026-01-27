-- Consulta del grid app_recomendantes
-- Reemplazar {id_asp} por la variable de sesión del aspirante

SELECT 
    ar.id_asp_recom,
    ar.id_asp_FK,
    ar.id_recom_FK,
    r.id_recom,
    r.nombre,
    r.apellido_p,
    r.apellido_m,
    r.correo
FROM asp_recomendantes ar
INNER JOIN recomendantes r ON ar.id_recom_FK = r.id_recom
WHERE ar.id_asp_FK = {id_asp}
ORDER BY ar.id_asp_recom;
