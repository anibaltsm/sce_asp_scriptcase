-- Campo de control para bloquear edición una vez creado el usuario de acceso (cartas).
-- cc_edit = 1/Y → se puede editar; 0/N → ya se creó usuario, no editar.
--
-- EJECUTADO: Se cambió el nombre de cc_edit_recom a cc_edit
-- Comando ejecutado:
--   ALTER TABLE recomendantes 
--   CHANGE COLUMN cc_edit_recom cc_edit 
--   TINYINT(1) NOT NULL DEFAULT 1 
--   COMMENT 'Y/1=editable, N/0=usuario creado para cartas, no editar';

-- Si necesitas crear la columna desde cero:
-- ALTER TABLE recomendantes
--   ADD COLUMN cc_edit TINYINT(1) NOT NULL DEFAULT 1
--   COMMENT 'Y/1=editable, N/0=usuario creado para cartas, no editar'
--   AFTER login_FK;

-- Opcional: marcar como no editables los que ya tienen usuario en grupo 7
-- UPDATE recomendantes r
-- INNER JOIN sec_asp_users_groups sg ON sg.login = r.login_FK AND sg.group_id = 7
-- SET r.cc_edit = 0;
