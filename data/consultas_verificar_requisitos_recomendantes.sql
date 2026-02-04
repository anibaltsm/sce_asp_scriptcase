-- =============================================================================
-- CONSULTAS PARA VERIFICAR REQUISITOS (cc_carta) Y RECOMENDANTES
-- Ejecutar en MySQL según la BD indicada.
-- =============================================================================

-- 1) Requisitos activos con cc_carta (BD: sce)
-- Muestra qué devuelve la consulta que usa add_asp_aspirantes para insertar asp_requisitos
SELECT list_req_gral.id_lisreq, list_req_gral.num_requisito, list_req_gral.cc_mostrar_usu, list_req_gral.cc_carta
FROM sce.list_req_gral
INNER JOIN sce.convocatorias_posg ON convocatorias_posg.id_conv = list_req_gral.id_conv_FK
WHERE sce.convocatorias_posg.cc_activa = 1
  AND (sce.convocatorias_posg.id_prog_FK <> 9 OR ISNULL(sce.convocatorias_posg.id_prog_FK))
ORDER BY list_req_gral.num_requisito ASC;

-- 2) Estructura list_req_gral (sce) – incluye cc_carta
-- DESCRIBE sce.list_req_gral;

-- 3) Estructura asp_requisitos (sce_asp) – incluye cc_carta
-- DESCRIBE sce_asp.asp_requisitos;

-- 4) Tabla recomendantes (sce_asp) – nombre, apellido_p, apellido_m, correo, num_recom, login_FK
SELECT * FROM sce_asp.recomendantes ORDER BY id_recom DESC LIMIT 10;

-- 5) Tabla asp_recomendantes (sce_asp) – enlace aspirante ↔ recomendante
SELECT ar.id_asp_recom, ar.id_asp_FK, ar.id_recom_FK, ar.num_req,
       r.nombre, r.apellido_p, r.apellido_m, r.correo
FROM sce_asp.asp_recomendantes ar
INNER JOIN sce_asp.recomendantes r ON r.id_recom = ar.id_recom_FK
ORDER BY ar.id_asp_FK, ar.num_req
LIMIT 20;

-- 6) Recomendantes de un aspirante por id_asp (reemplazar 1222 por el id_asp)
-- SELECT ar.num_req, r.nombre, r.apellido_p, r.apellido_m, r.correo
-- FROM sce_asp.asp_recomendantes ar
-- INNER JOIN sce_asp.recomendantes r ON r.id_recom = ar.id_recom_FK
-- WHERE ar.id_asp_FK = 1222
-- ORDER BY ar.num_req;
