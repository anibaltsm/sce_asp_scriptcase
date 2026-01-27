-- Sincronizar recomendantes y asp_recomendantes con los SQL dump
-- Ejecutar: mysql -u root -p sce_asp < sync_recomendantes_bd.sql
-- Si login_FK ya existe en recomendantes, comentar o saltar el ALTER.

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET NAMES utf8mb4;

START TRANSACTION;

-- --------------------------------------------------------
-- 1. RECOMENDANTES: añadir login_FK
-- --------------------------------------------------------
ALTER TABLE recomendantes
  ADD COLUMN login_FK VARCHAR(255) NOT NULL DEFAULT '0' AFTER num_recom;

UPDATE recomendantes SET login_FK = '0' WHERE id_recom IN (1, 2, 3);

INSERT IGNORE INTO recomendantes (id_recom, id_persacadposg_FK, nombre, apellido_p, apellido_m, correo, num_recom, login_FK)
VALUES (4, NULL, 'fernando', 'ram', 'flo', 'fer_chuy05@hotmail.com', 2, 'fe.ram');

-- --------------------------------------------------------
-- 2. ASP_RECOMENDANTES: num_req y id_recom_FK según dump
-- --------------------------------------------------------
UPDATE asp_recomendantes SET num_req = 10  WHERE id_asp_recom IN (1, 4, 5);
UPDATE asp_recomendantes SET num_req = NULL WHERE id_asp_recom IN (2, 3);
UPDATE asp_recomendantes SET num_req = 11  WHERE id_asp_recom = 6;

UPDATE asp_recomendantes SET id_recom_FK = 4 WHERE id_asp_recom = 6;

COMMIT;
