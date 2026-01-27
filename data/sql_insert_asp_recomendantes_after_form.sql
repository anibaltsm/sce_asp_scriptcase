-- afterInsert del form: enlazar nuevo recomendante con aspirante
-- id_recom = LAST_INSERT_ID() tras INSERT en recomendantes
-- num_req = COUNT(*) + 1 (1, 2 o 3)

INSERT INTO asp_recomendantes (id_asp_FK, id_recom_FK, num_req)
VALUES ({id_asp}, {id_recom}, {num_req});
