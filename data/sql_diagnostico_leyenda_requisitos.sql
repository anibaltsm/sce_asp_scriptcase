-- =============================================================================
-- DIAGNÓSTICO: Consulta leyenda para form_asp_requisitos_1 (num_req 01-10)
-- Compara query SIN vs CON filtro id_prog_FK<>9 para ver por qué no se ven bien
-- =============================================================================

-- 1) Asp requisitos del aspirante 1278 (qué num_req tiene cada fila)
SELECT '1. asp_requisitos id_asp_FK=1278' AS paso;
SELECT id_asp_req, id_asp_FK, id_lisreq_FK, num_req, prefijo_requisito, archivo, cc_correcto
FROM sce_asp.asp_requisitos 
WHERE id_asp_FK = 1278 
ORDER BY num_req;

-- 2) Convocatorias activas SIN filtro id_prog_FK (puede incluir EBC id_prog=9)
SELECT '2. convocatorias_posg cc_activa=1 (SIN filtro id_prog)' AS paso;
SELECT id_conv, generacion, cc_activa, id_prog_FK 
FROM sce.convocatorias_posg 
WHERE cc_activa=1;

-- 3) Convocatorias activas CON filtro (excluye id_prog_FK=9)
SELECT '3. convocatorias_posg cc_activa=1 (CON filtro id_prog<>9)' AS paso;
SELECT id_conv, generacion, cc_activa, id_prog_FK 
FROM sce.convocatorias_posg 
WHERE cc_activa=1 AND (id_prog_FK<>9 OR ISNULL(id_prog_FK));

-- 4) list_req_gral: qué requisitos hay para convocatorias SIN filtro (por num_requisito 1-10)
SELECT '4. list_req_gral leyenda SIN filtro id_prog (num_req 1-10)' AS paso;
SELECT lr.num_requisito, lr.leyenda, cp.id_conv, cp.id_prog_FK
FROM sce.list_req_gral lr
INNER JOIN sce.convocatorias_posg cp ON cp.id_conv = lr.id_conv_FK
WHERE cp.cc_activa=1 AND lr.num_requisito BETWEEN 1 AND 10
ORDER BY lr.num_requisito, cp.id_conv;

-- 5) list_req_gral: qué requisitos hay CON filtro id_prog (num_req 1-10)
SELECT '5. list_req_gral leyenda CON filtro id_prog<>9 (num_req 1-10)' AS paso;
SELECT lr.num_requisito, lr.leyenda, cp.id_conv, cp.id_prog_FK
FROM sce.list_req_gral lr
INNER JOIN sce.convocatorias_posg cp ON cp.id_conv = lr.id_conv_FK
WHERE cp.cc_activa=1 
  AND (cp.id_prog_FK<>9 OR ISNULL(cp.id_prog_FK))
  AND lr.num_requisito BETWEEN 1 AND 10
ORDER BY lr.num_requisito;

-- 6) Simula query ACTUAL (sin id_prog): para num_req=1, qué devuelve sc_concat
SELECT '6. Query ACTUAL (sin filtro id_prog) - num_req=1' AS paso;
SELECT CONCAT(' - ', lr.leyenda) AS leyenda_num1
FROM sce.convocatorias_posg cp
INNER JOIN sce.list_req_gral lr ON cp.id_conv = lr.id_conv_FK
WHERE cp.cc_activa=1 AND lr.num_requisito=1;

-- 7) Simula query PROPUESTA (con id_prog): para num_req=1
SELECT '7. Query PROPUESTA (con filtro id_prog<>9) - num_req=1' AS paso;
SELECT CONCAT(' - ', lr.leyenda) AS leyenda_num1
FROM sce.convocatorias_posg cp
INNER JOIN sce.list_req_gral lr ON cp.id_conv = lr.id_conv_FK
WHERE cp.cc_activa=1 
  AND (cp.id_prog_FK<>9 OR ISNULL(cp.id_prog_FK))
  AND lr.num_requisito=1;

-- 8) ¿Hay duplicados o múltiples convocatorias activas? (podría mezclar EBC con posgrado)
SELECT '8. Contar requisitos por num_requisito SIN vs CON filtro' AS paso;
SELECT 
  lr.num_requisito,
  (SELECT COUNT(*) FROM sce.list_req_gral l2 
   INNER JOIN sce.convocatorias_posg c2 ON c2.id_conv = l2.id_conv_FK 
   WHERE c2.cc_activa=1 AND l2.num_requisito=lr.num_requisito) AS total_sin_filtro,
  (SELECT COUNT(*) FROM sce.list_req_gral l2 
   INNER JOIN sce.convocatorias_posg c2 ON c2.id_conv = l2.id_conv_FK 
   WHERE c2.cc_activa=1 AND (c2.id_prog_FK<>9 OR ISNULL(c2.id_prog_FK)) AND l2.num_requisito=lr.num_requisito) AS total_con_filtro
FROM sce.list_req_gral lr
INNER JOIN sce.convocatorias_posg cp ON cp.id_conv = lr.id_conv_FK
WHERE cp.cc_activa=1 AND (cp.id_prog_FK<>9 OR ISNULL(cp.id_prog_FK)) AND lr.num_requisito BETWEEN 1 AND 10
GROUP BY lr.num_requisito
ORDER BY lr.num_requisito;
