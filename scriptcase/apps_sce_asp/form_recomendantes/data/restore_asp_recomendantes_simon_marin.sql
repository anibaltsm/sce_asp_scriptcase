-- Restaurar asp_recomendantes para Simón Marín Builes (simon.marin@posgrado.ecologia.edu.mx)
-- id_asp = 1282
-- Recomendante 1: id_recom 37 (num_req 10)
-- Recomendante 2: id_recom 38 - j.cepedad@uniandes.edu.co (num_req 11)
-- Recomendante 3: id_recom 39 - sonia.gallina@inecol.mx (num_req 13)
-- Ejecutar: mysql -u root -p sce_asp < restore_asp_recomendantes_simon_marin.sql

USE sce_asp;

INSERT INTO asp_recomendantes (id_asp_FK, id_recom_FK, num_req) VALUES
(1282, 37, 10),
(1282, 38, 11),
(1282, 39, 13);
