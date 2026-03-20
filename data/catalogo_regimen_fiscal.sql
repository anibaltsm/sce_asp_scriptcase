-- Catálogo de régimen fiscal (SAT) y relación con facturas
-- Base de datos: sce
-- Ejecutar: /opt/lampp/bin/mysql -u root -p515t3ma5 sce < data/catalogo_regimen_fiscal.sql

-- =============================================================================
-- 1. Tabla catálogo de régimen fiscal (códigos oficiales SAT)
-- =============================================================================
-- Se usa c_RegimenFiscal como PK: es el código oficial del SAT, evita un id extra
-- y permite relacionar facturas solo guardando ese código.

DROP TABLE IF EXISTS `catalogo_regimen_fiscal`;

CREATE TABLE `catalogo_regimen_fiscal` (
  `c_RegimenFiscal` smallint(3) unsigned NOT NULL COMMENT 'Código régimen fiscal SAT',
  `Descripcion` varchar(255) NOT NULL COMMENT 'Descripción del régimen',
  PRIMARY KEY (`c_RegimenFiscal`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci
COMMENT='Catálogo de regímenes fiscales SAT (CFDI)';

-- Datos según catálogo SAT (imagen proporcionada)
INSERT INTO `catalogo_regimen_fiscal` (`c_RegimenFiscal`, `Descripcion`) VALUES
(601, 'General de Ley Personas Morales'),
(603, 'Personas Morales con Fines no Lucrativos'),
(605, 'Sueldos y Salarios e Ingresos Asimilados a Salarios'),
(606, 'Arrendamiento'),
(607, 'Régimen de Enajenación o Adquisición de Bienes'),
(608, 'Demás ingresos'),
(609, 'Consolidación'),
(610, 'Residentes en el Extranjero sin Establecimiento Permanente en México'),
(611, 'Ingresos por Dividendos (socios y accionistas)'),
(612, 'Personas Físicas con Actividades Empresariales y Profesionales'),
(614, 'Ingresos por intereses'),
(615, 'Régimen de los ingresos por obtención de premios'),
(616, 'Sin obligaciones fiscales'),
(620, 'Sociedades Cooperativas de Producción que optan por diferir sus ingresos'),
(621, 'Incorporación Fiscal'),
(622, 'Actividades Agrícolas, Ganaderas, Silvícolas y Pesqueras'),
(623, 'Opcional para Grupos de Sociedades'),
(624, 'Coordinados'),
(628, 'Hidrocarburos'),
(629, 'De los Regímenes Fiscales Preferentes y de las Empresas Multinacionales'),
(630, 'Enajenación de acciones en bolsa de valores');

-- =============================================================================
-- 2. Relación en tabla facturas: columna id_regimen_fiscal (FK al catálogo)
-- =============================================================================
-- En facturas solo se guarda el código del régimen fiscal (c_RegimenFiscal).
-- Así se relaciona con el catálogo y se evita duplicar la descripción.
-- NULL = no definido aún (compatible con registros existentes).

ALTER TABLE `facturas`
  ADD COLUMN `id_regimen_fiscal` smallint(3) unsigned DEFAULT NULL
    COMMENT 'Régimen fiscal SAT (FK a catalogo_regimen_fiscal.c_RegimenFiscal)'
  AFTER `entidad`;

-- Índice para búsquedas y futura FK si facturas pasa a InnoDB
ALTER TABLE `facturas`
  ADD INDEX `idx_facturas_regimen_fiscal` (`id_regimen_fiscal`);

-- Opcional: si en el futuro facturas usa InnoDB, descomentar para FK real:
-- ALTER TABLE `facturas`
--   ADD CONSTRAINT `fk_facturas_regimen_fiscal`
--   FOREIGN KEY (`id_regimen_fiscal`) REFERENCES `catalogo_regimen_fiscal` (`c_RegimenFiscal`)
--   ON DELETE SET NULL ON UPDATE CASCADE;
