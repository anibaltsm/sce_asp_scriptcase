-- Crear referencia de pago para id_asp 1301 (fer_chuy05+13@hotmail.com)
-- Mismo flujo que add_asp_aspirantes PASO 4
-- Referencia: INECOLPA0002 + id_asp + "00" = INECOLPA0002130100
-- Ejecutar: mysql -u root -p sce < restore_pago_id_asp_1301.sql

USE sce;

-- Solo insertar si no existe ya un pago para este aspirante con group_id 5
INSERT INTO pagos (
    group_id_FK,
    id_asp_FK,
    nombre_interesado,
    concepto,
    monto,
    referencia,
    doc_csf,
    fecha_pago,
    login_insert,
    fecha_alta,
    ip_alta
)
SELECT
    '5',
    1301,
    'fernando2 234 123',
    'Derecho al proceso de seleccion 2026',
    1250,
    'INECOLPA0002130100',
    NULL,
    NULL,
    'fer_chuy05+13@hotmail.com',
    NOW(),
    '127.0.0.1'
WHERE NOT EXISTS (
    SELECT 1 FROM pagos WHERE id_asp_FK = 1301 AND group_id_FK = '5'
);
