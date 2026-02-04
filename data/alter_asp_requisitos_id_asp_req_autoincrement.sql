-- =============================================================================
-- ALTER asp_requisitos: id_asp_req como AUTO_INCREMENT y PRIMARY KEY
-- Base de datos: sce_asp
-- Ejecutar: mysql -u root -p sce_asp < alter_asp_requisitos_id_asp_req_autoincrement.sql
-- =============================================================================
-- Si ya existe PRIMARY KEY en otra columna, descomentar y ejecutar primero:
-- ALTER TABLE asp_requisitos DROP PRIMARY KEY;
-- Si hay filas con id_asp_req NULL, hay que asignarles valor antes (o borrarlas).
-- =============================================================================

ALTER TABLE asp_requisitos
  MODIFY COLUMN id_asp_req INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  ADD PRIMARY KEY (id_asp_req);
