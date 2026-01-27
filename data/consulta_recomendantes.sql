-- Consulta que relaciona las tablas recomendantes y asp_recomendantes
-- Muestra la información completa de los recomendantes y su relación con los aspirantes

SELECT 
    -- Información del recomendante
    r.id_recom,
    r.nombre,
    r.apellido_p,
    r.apellido_m,
    CONCAT(r.nombre, ' ', r.apellido_p, ' ', IFNULL(r.apellido_m, '')) AS nombre_completo,
    r.correo,
    r.num_recom,
    r.id_persacadposg_FK,
    r.login_FK AS login_recomendante,
    
    -- Información de la relación con aspirantes
    ar.id_asp_recom,
    ar.id_asp_FK,
    ar.num_req,
    ar.id_recom_FK
    
FROM 
    recomendantes r
LEFT JOIN 
    asp_recomendantes ar ON r.id_recom = ar.id_recom_FK
ORDER BY 
    r.id_recom, ar.id_asp_FK;

-- Consulta alternativa: Solo recomendantes que tienen relación con aspirantes
SELECT 
    r.id_recom,
    r.nombre,
    r.apellido_p,
    r.apellido_m,
    CONCAT(r.nombre, ' ', r.apellido_p, ' ', IFNULL(r.apellido_m, '')) AS nombre_completo,
    r.correo,
    r.num_recom,
    ar.id_asp_FK,
    ar.num_req,
    COUNT(ar.id_asp_FK) AS total_aspirantes
FROM 
    recomendantes r
INNER JOIN 
    asp_recomendantes ar ON r.id_recom = ar.id_recom_FK
GROUP BY 
    r.id_recom, r.nombre, r.apellido_p, r.apellido_m, r.correo, r.num_recom, ar.id_asp_FK, ar.num_req
ORDER BY 
    r.id_recom;

-- Consulta resumen: Total de aspirantes por recomendante
SELECT 
    r.id_recom,
    CONCAT(r.nombre, ' ', r.apellido_p, ' ', IFNULL(r.apellido_m, '')) AS nombre_completo,
    r.correo,
    COUNT(DISTINCT ar.id_asp_FK) AS total_aspirantes_asociados,
    COUNT(ar.id_asp_recom) AS total_relaciones
FROM 
    recomendantes r
LEFT JOIN 
    asp_recomendantes ar ON r.id_recom = ar.id_recom_FK
GROUP BY 
    r.id_recom, r.nombre, r.apellido_p, r.apellido_m, r.correo
ORDER BY 
    total_aspirantes_asociados DESC, r.id_recom;
