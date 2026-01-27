-- INSERT en asp_recomendantes (usar desde onAfterInsert de form_recomendante)
-- Reemplazar {id_asp} por variable de sesión del aspirante.
-- Reemplazar <id_recom_insertado> por LAST_INSERT_ID() o el id_recom del nuevo recomendante.

INSERT INTO asp_recomendantes (id_asp_FK, id_recom_FK, num_req)
VALUES ({id_asp}, <id_recom_insertado>, NULL);
