-- =============================================================================
-- MenuBase: poner priv_access = 'Y' para que el login redirija sin "Usuario no autorizado"
-- Ejecutar en la BD a la que se conecta la app (según config: 127.0.0.1 o 192.168.2.68)
-- =============================================================================
--
-- Grupos (sec_groups): tú eliges a cuáles dar acceso a MenuBase según el rol.
-- Referencia (group_id | descripción          | típico uso):
--   1 = Administrador
--   2 = Estudiante
--   3 = Administrativo INECOL
--   4 = Administrativo Posgrado
--   5 = Aspirante
--   6 = Visitante
--   7 = Academico INECOL
--   8 = Academico Posgrado
--   9 = Publico General
--
-- Para ver cuántos usuarios tiene cada grupo (y decidir):
--   SELECT g.group_id, g.description, COUNT(u.login) AS num_usuarios
--   FROM sec_groups g
--   LEFT JOIN sec_users_groups u ON u.group_id = g.group_id
--   WHERE g.group_id <= 9 GROUP BY g.group_id, g.description;
--
-- Ejemplo: solo administradores y administrativos → IN (1, 3, 4)
-- Ejemplo: todos los que pueden loguearse → IN (1, 2, 3, 4, 5, 6, 7, 8, 9)
-- =============================================================================

USE sce;

-- 1) Estado actual (solo lectura)
SELECT group_id, app_name, priv_access 
FROM sec_groups_apps 
WHERE app_name = 'MenuBase' 
ORDER BY group_id;

-- 2) Actualizar: dar acceso a MenuBase a los group_id que elijas (abajo: todos 1-9)
UPDATE sec_groups_apps 
SET priv_access = 'Y' 
WHERE app_name = 'MenuBase' 
  AND group_id IN (1, 2, 3, 4, 5, 6, 7, 8, 9);

-- 3) Verificar después del UPDATE
SELECT group_id, app_name, priv_access 
FROM sec_groups_apps 
WHERE app_name = 'MenuBase' 
ORDER BY group_id;
