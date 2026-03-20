-- Crear referencia de pago para Simón Marín Builes (simon.marin@posgrado.ecologia.edu.mx)
-- id_asp = 1282, mismo flujo que add_asp_aspirantes PASO 4
-- Referencia: INECOLPA0002 + id_asp + "00" = INECOLPA0002128200
-- Ejecutar: mysql -u root -p sce < restore_pago_simon_marin.sql

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
    1282,
    'Simón  Marín  Builes',
    'Derecho al proceso de seleccion 2026',
    1250,
    'INECOLPA0002128200',
    NULL,
    NULL,
    'simon.marin@posgrado.ecologia.edu.mx',
    NOW(),
    '127.0.0.1'
WHERE NOT EXISTS (
    SELECT 1 FROM pagos WHERE id_asp_FK = 1282 AND group_id_FK = '5'
);
