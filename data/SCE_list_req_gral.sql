-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-01-2026 a las 20:45:23
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sce`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `list_req_gral`
--

CREATE TABLE `list_req_gral` (
  `id_lisreq` int(11) UNSIGNED ZEROFILL NOT NULL COMMENT 'Identificador de lista de requisitos general',
  `id_conv_FK` int(11) UNSIGNED ZEROFILL DEFAULT NULL COMMENT 'Identificador de convocatoria a la que pertenece',
  `tipo_tramite` varchar(50) DEFAULT NULL COMMENT 'Tipo de tramite (ingreso, solicitud de documento, egreso, etc.)',
  `tipo_usuario` varchar(50) DEFAULT NULL COMMENT 'Tipo de usuario',
  `num_requisito` int(11) UNSIGNED ZEROFILL DEFAULT NULL COMMENT 'Nombre del requisito solicitado',
  `leyenda` varchar(255) DEFAULT NULL COMMENT 'Descripci',
  `formato` varchar(3) DEFAULT NULL COMMENT 'Indica si es un archivo en PDF, JPG o el tipo de archivo',
  `cc_carta` tinyint(1) NOT NULL,
  `cc_mostrar_usu` int(1) DEFAULT NULL COMMENT 'Campo de control que indica si este campo se deber',
  `cc_mostrar_cap` int(1) DEFAULT NULL COMMENT 'Campo de control que indica si este campo se deber',
  `leyenda_cap` varchar(255) DEFAULT NULL COMMENT 'Leyenda simplificada para mostrar al CAP',
  `cc_aplic_od` int(1) DEFAULT NULL COMMENT 'Campo de control que indica si el requisito aplica opci',
  `cc_aplic_dc` int(1) DEFAULT NULL COMMENT 'Campo de control que indica si el requisito aplica a doctorado',
  `cc_aplic_mc` int(1) DEFAULT NULL COMMENT 'Campo de control que indica si el requisito aplica a maestr',
  `cc_pago` int(1) DEFAULT NULL COMMENT 'Campo de control que indica si el requisito es un pago',
  `foto_persona` int(1) DEFAULT NULL COMMENT 'Campo de control que indica si el requisito es una foto',
  `ingresa_admvo` int(1) DEFAULT NULL,
  `ingresa_cap` int(1) DEFAULT NULL,
  `ingresa_dt` int(1) DEFAULT NULL,
  `ingresa_est` int(1) DEFAULT NULL,
  `ingresa_asp` int(1) DEFAULT NULL,
  `ingresa_vis` int(1) DEFAULT NULL,
  `ingresa_profcord` int(1) DEFAULT NULL,
  `ingresa_externo` int(1) DEFAULT NULL,
  `ingresa_acad` int(1) DEFAULT NULL,
  `notas` varchar(255) DEFAULT NULL COMMENT 'Notas que deben ver el equipo de revision',
  `login_insert` varchar(32) DEFAULT NULL COMMENT 'Usuario que da de alta el registro',
  `fecha_alta` datetime DEFAULT NULL COMMENT 'Fecha de alta del registro',
  `ip_alta` varchar(255) DEFAULT NULL,
  `login_last` varchar(32) DEFAULT NULL COMMENT 'Usuario que actualiza el registro por ├║ltima vez',
  `fecha_ult_act` datetime DEFAULT NULL COMMENT 'Fecha de ├║ltima actualizaci├│n',
  `ip_last` varchar(255) DEFAULT NULL,
  `prefijo_requisito` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='Lista de requisitos generales';

--
-- Volcado de datos para la tabla `list_req_gral`
--

INSERT INTO `list_req_gral` (`id_lisreq`, `id_conv_FK`, `tipo_tramite`, `tipo_usuario`, `num_requisito`, `leyenda`, `formato`, `cc_carta`, `cc_mostrar_usu`, `cc_mostrar_cap`, `leyenda_cap`, `cc_aplic_od`, `cc_aplic_dc`, `cc_aplic_mc`, `cc_pago`, `foto_persona`, `ingresa_admvo`, `ingresa_cap`, `ingresa_dt`, `ingresa_est`, `ingresa_asp`, `ingresa_vis`, `ingresa_profcord`, `ingresa_externo`, `ingresa_acad`, `notas`, `login_insert`, `fecha_alta`, `ip_alta`, `login_last`, `fecha_ult_act`, `ip_last`, `prefijo_requisito`) VALUES
(00000000001, 00000000001, '1', '5', 00000000003, 'Carta de apoyo del Tutor Academico', '1', 0, 0, 0, 'Carta compromiso tutor', 0, 0, 0, 0, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'req1'),
(00000000002, 00000000001, '1', '5', 00000000004, 'Certificado de estudios profesionales con promedio', '1', 0, 0, 0, 'Certificado de estudios profesionales', 0, 0, 0, 0, 0, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'req2'),
(00000000003, 00000000001, '1', '5', 00000000005, 'Acta de nacimiento del aspirante', '1', 0, 0, 0, 'Acta de nacimiento', 0, 0, 0, 0, 0, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'req3'),
(00000000004, 00000000001, '1', '5', 00000000006, 'Fotograf├¡a', '2', 0, 1, 1, 'Fotograf├¡a', 1, 1, 1, 0, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(00000000005, 00000000001, '1', '5', 00000000007, 'Certificado del dominio de la lengua inglesa', '1', 0, 1, 1, '', 0, 1, 1, 0, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(00000000006, 00000000001, '1', '5', 00000000008, 'Carta de recomendaci├│n', '1', 0, 0, 1, 'Carta de recomendaci├│n', 1, 1, 1, 0, 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(00000000007, 00000000001, '1', '5', 00000000009, 'Recibo de pago de derecho al proceso de selecci├│n', '1', 0, 1, 0, 'Recibo de pago', 0, 1, 1, 1, 0, 1, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(00000000010, 00000000004, '1', '5', 00000000001, 'Carta de solicitud de admisi├│n (En formato PDF)', '1', 0, 1, 1, 'Solicitud de admisi├│n', 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', 'admin', '2019-11-25 19:16:52', '10.0.71.112', '', NULL, '', NULL),
(00000000026, 00000000004, '1', '5', 00000000015, '2a Carta de recomendaci├│n confidencial (En formato PDF)', '1', 0, 0, 1, '2a Carta de recomendaci├│n confidencial', 1, 1, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, '', 'admin', '2020-01-06 18:30:42', '10.0.71.44', '', NULL, '', NULL),
(00000000013, 00000000004, '1', '5', 00000000002, 'Carta compromiso de un investigador para dirigir el proyecto de tesis (En formato PDF)', '1', 0, 1, 1, 'Carta compromiso direcci├│n de tesis', 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', 'admin', '2020-01-06 16:53:26', '10.0.71.44', 'admin', '2020-01-06 16:54:56', '10.0.71.44', NULL),
(00000000014, 00000000004, '1', '5', 00000000003, 'Carta compromiso de un tutor acad├®mico (En formato PDF)', '1', 0, 1, 1, 'Carta compromiso de tutor', 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 'S├¡, si el Director de Tesis es externo al\nINECOL', 'admin', '2020-01-06 16:57:01', '10.0.71.44', 'admin', '2020-01-06 17:05:22', '10.0.71.44', NULL),
(00000000015, 00000000004, '1', '5', 00000000004, 'Certificado total de estudios profesionales (En formato PDF)', '1', 0, 1, 0, 'Certificado total de estudios profesionales', 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', 'admin', '2020-01-06 16:59:27', '10.0.71.44', '', NULL, '', NULL),
(00000000016, 00000000004, '1', '5', 00000000005, 'CURP o acta de nacimiento (En formato PDF)', '1', 0, 1, 1, 'CURP o acta de nacimiento', 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', 'admin', '2020-01-06 16:59:57', '10.0.71.44', '', NULL, '', NULL),
(00000000017, 00000000004, '1', '5', 00000000006, 'Curriculum vitae (En formato PDF)', '1', 0, 1, 1, 'Curriculum vitae', 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', 'admin', '2020-01-06 17:00:35', '10.0.71.44', '', NULL, '', NULL),
(00000000018, 00000000004, '1', '5', 00000000007, 'Resultados del Examen EXANI III (En formato PDF)', '1', 0, 1, 1, 'Resultados del Examen EXANI III', 0, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', 'admin', '2020-01-06 17:01:24', '10.0.71.44', 'admin', '2020-01-06 17:03:45', '10.0.71.44', NULL),
(00000000019, 00000000004, '1', '5', 00000000008, 'Fotograf├¡a digitalizada en formato JPG, tama├▒o infantil, a color, fondo blanco, no mayor a 150 kb retrato de frente, abarcando hombro y cabeza. Hombres sin barba. Mujeres descubrir orejas.', '1', 0, 1, 1, 'Fotograf├¡a digitalizada', 1, 1, 1, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', 'admin', '2020-01-06 17:01:50', '10.0.71.44', '', NULL, '', NULL),
(00000000020, 00000000004, '1', '5', 00000000009, 'Identificaci├│n oficial vigente (En formato PDF)', '1', 0, 1, 1, 'Identificaci├│n oficial vigente', 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', 'admin', '2020-01-06 17:02:15', '10.0.71.44', '', NULL, '', NULL),
(00000000021, 00000000004, '1', '5', 00000000010, 'Recibo de pago de derecho al proceso de selecci├│n (En formato PDF)', '1', 0, 1, 1, 'Recibo de pago de derecho al proceso de selecci├│n', 0, 1, 1, 1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', 'admin', '2020-01-06 17:02:36', '10.0.71.44', 'admin', '2020-01-06 17:03:27', '10.0.71.44', NULL),
(00000000022, 00000000004, '1', '5', 00000000011, 'Anteproyecto de tesis (En formato PDF)', '1', 0, 1, 1, 'Anteproyecto de tesis', 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', 'admin', '2020-01-06 17:04:34', '10.0.71.44', '', NULL, '', NULL),
(00000000023, 00000000004, '1', '5', 00000000012, 'Certificado del dominio de la lengua inglesa (TOEFL e IELTS) (En formato PDF)', '1', 0, 1, 1, 'Certificado del dominio de la lengua inglesa (TOFEL e IELTS)', 0, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', 'admin', '2020-01-06 17:05:03', '10.0.71.44', '', NULL, '', NULL),
(00000000024, 00000000004, '1', '5', 00000000013, 'T├¡tulo, C├®dula o acta de examen profesional (En formato PDF)', '1', 0, 1, 1, 'T├¡tulo, C├®dula o acta de examen profesional', 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', 'admin', '2020-01-06 17:05:59', '10.0.71.44', '', NULL, '', NULL),
(00000000025, 00000000004, '1', '5', 00000000014, '1a Carta de recomendaci├│n confidencial (En formato PDF)', '1', 0, 0, 1, '1a Cartas de recomendaci├│n confidenciales', 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', 'admin', '2020-01-06 17:06:22', '10.0.71.44', 'admin', '2020-01-06 18:29:58', '10.0.71.44', NULL),
(00000000028, 00000000004, '1', '5', 00000000016, '3a Carta de recomendaci├│n confidencial (En formato PDF)', '1', 0, 0, 1, '3a Carta de recomendaci├│n confidencial', 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, '', 'admin', '2020-01-06 18:32:17', '10.0.71.44', '', NULL, '', NULL),
(00000000029, 00000000004, '1', '5', 00000000017, 'Formato de inscripci├│n', '1', 0, 0, 0, 'Formato de inscripci├│n', 1, 1, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 'admin', NULL, NULL, NULL, NULL, NULL, NULL),
(00000000030, 00000000004, '1', '5', 00000000018, 'Carta dedicaci├│n exclusiva', '1', 0, 0, 0, 'Carta dedicaci├│n exclusiva', 1, 1, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 'admin', NULL, NULL, NULL, NULL, NULL, NULL),
(00000000031, 00000000004, '1', '5', 00000000019, 'Constancia m├®dica', '1', 0, 0, 0, 'Constancia m├®dica', 1, 1, 1, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(00000000032, 00000000005, '1', '5', 00000000001, 'Carta de solicitud de admisi├│n (En formato PDF)', '1', 0, 1, 1, 'Carta de solicitud de admisi├│n', 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', 'bertha.ulloa', '2020-11-27 20:14:45', '187.191.42.228', '', NULL, '', NULL),
(00000000033, 00000000005, '1', '5', 00000000003, 'Carta compromiso de un tutor acad├®mico (En formato PDF)', '1', 0, 1, 1, 'Carta compromiso de tutor', 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', 'monica.enriquez', '2020-12-01 17:53:38', '187.191.42.228', 'monica.enriquez', '2020-12-08 20:38:11', '187.191.42.228', NULL),
(00000000034, 00000000005, '1', '5', 00000000002, 'Carta compromiso de un investigador para dirigir el proyecto de tesis (En formato PDF)', '1', 0, 1, 1, 'Carta compromiso direcci├│n de tesis', 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', 'monica.enriquez', '2020-12-08 20:31:19', '187.191.42.228', '', NULL, '', NULL),
(00000000035, 00000000005, '1', '5', 00000000004, 'Certificado total de estudios profesionales (En formato PDF)', '1', 0, 1, 1, 'Certificado total de estudios profesionales', 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', 'monica.enriquez', '2020-12-08 20:37:56', '187.191.42.228', '', NULL, '', NULL),
(00000000036, 00000000005, '1', '5', 00000000005, 'CURP o Acta de nacimiento (En formato PDF)', '1', 0, 1, 0, 'CURP o Acta de nacimiento', 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', 'monica.enriquez', '2020-12-08 20:38:56', '187.191.42.228', '', NULL, '', NULL),
(00000000037, 00000000005, '1', '5', 00000000006, 'Curriculum vitae (En formato PDF)', '1', 0, 1, 1, 'Curriculum vitae', 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', 'monica.enriquez', '2020-12-08 20:39:41', '187.191.42.228', '', NULL, '', NULL),
(00000000038, 00000000005, '1', '5', 00000000008, 'Identificaci├│n oficial vigente (En formato PDF)', '1', 0, 1, 1, 'Identificaci├│n oficial vigente', 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', 'monica.enriquez', '2020-12-08 20:41:46', '187.191.42.228', 'monica.enriquez', '2020-12-08 20:44:49', '187.191.42.228', NULL),
(00000000039, 00000000005, '1', '5', 00000000009, 'Recibo de pago de derecho al proceso de selecci├│n (En formato PDF)', '1', 0, 1, 0, 'Recibo de pago de derecho al proceso de selecci├│n', 0, 1, 1, 1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', 'monica.enriquez', '2020-12-08 20:42:31', '187.191.42.228', 'monica.enriquez', '2020-12-08 20:53:40', '187.191.42.228', NULL),
(00000000040, 00000000005, '1', '5', 00000000010, 'T├¡tulo, C├®dula o acta de examen profesional (En formato PDF)', '1', 0, 1, 1, 'T├¡tulo, C├®dula o acta de examen profesional', 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', 'monica.enriquez', '2020-12-08 20:43:51', '187.191.42.228', 'monica.enriquez', '2020-12-08 20:45:29', '187.191.42.228', NULL),
(00000000041, 00000000005, '1', '5', 00000000011, 'Anteproyecto de tesis (En formato PDF)', '1', 0, 1, 1, 'Anteproyecto de tesis', 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', 'monica.enriquez', '2020-12-08 20:46:18', '187.191.42.228', '', NULL, '', NULL),
(00000000042, 00000000005, '1', '5', 00000000012, 'Resultados del Examen EXANI III (En formato PDF)', '1', 0, 1, 1, 'Resultados del Examen EXANI III', 0, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', 'monica.enriquez', '2020-12-08 20:48:09', '187.191.42.228', 'monica.enriquez', '2020-12-08 20:53:57', '187.191.42.228', NULL),
(00000000043, 00000000005, '1', '5', 00000000013, 'Certificado del dominio de la lengua inglesa (TOEFL e IELTS) (En formato PDF)', '1', 0, 1, 1, 'Certificado del dominio de la lengua inglesa (TOFEL e IELTS)', 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', 'monica.enriquez', '2020-12-08 20:49:01', '187.191.42.228', '', NULL, '', NULL),
(00000000044, 00000000005, '1', '5', 00000000014, '1a Carta de recomendaci├│n confidencial (En formato PDF)', '1', 0, 0, 1, '1a Carta de recomendaci├│n confidencial', 1, 1, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, '', 'monica.enriquez', '2020-12-08 20:50:07', '187.191.42.228', '', NULL, '', NULL),
(00000000045, 00000000005, '1', '5', 00000000015, '2a Carta de recomendaci├│n confidencial (En formato PDF)', '1', 0, 0, 1, '2a Carta de recomendaci├│n confidencial', 1, 1, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, '', 'monica.enriquez', '2020-12-08 20:50:46', '187.191.42.228', '', NULL, '', NULL),
(00000000046, 00000000005, '1', '5', 00000000016, '3a Carta de recomendaci├│n confidencial (En formato PDF)', '1', 0, 0, 1, '3a Carta de recomendaci├│n confidencial', 1, 1, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, '', 'monica.enriquez', '2020-12-08 20:52:52', '187.191.42.228', '', NULL, '', NULL),
(00000000047, 00000000006, '1', '5', 00000000001, 'Carta de solicitud de admisi├│n (En formato PDF)', '1', 0, 1, 1, 'Carta de solicitud de admisi├│n', 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', 'bertha.ulloa', '2020-11-27 20:14:45', '187.191.42.228', '', NULL, '', NULL),
(00000000048, 00000000006, '1', '5', 00000000003, 'Carta compromiso de un tutor acad├®mico (En formato PDF)', '1', 0, 1, 1, 'Carta compromiso de tutor', 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', 'monica.enriquez', '2020-12-01 17:53:38', '187.191.42.228', 'monica.enriquez', '2020-12-08 20:38:11', '187.191.42.228', NULL),
(00000000049, 00000000006, '1', '5', 00000000002, 'Carta compromiso de un investigador para dirigir el proyecto de tesis (En formato PDF)', '1', 0, 1, 1, 'Carta compromiso direcci├│n de tesis', 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', 'monica.enriquez', '2020-12-08 20:31:19', '187.191.42.228', '', NULL, '', NULL),
(00000000050, 00000000006, '1', '5', 00000000004, 'Certificado total de estudios profesionales (En formato PDF)', '1', 0, 1, 1, 'Certificado total de estudios profesionales', 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', 'monica.enriquez', '2020-12-08 20:37:56', '187.191.42.228', '', NULL, '', NULL),
(00000000051, 00000000006, '1', '5', 00000000005, 'CURP o acta de nacimiento (En formato PDF)', '1', 0, 1, 0, 'CURP o acta de nacimiento', 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', 'monica.enriquez', '2020-12-08 20:38:56', '187.191.42.228', '', NULL, '', NULL),
(00000000052, 00000000006, '1', '5', 00000000006, 'Curriculum vitae (En formato PDF)', '1', 0, 1, 1, 'Curriculum vitae', 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', 'monica.enriquez', '2020-12-08 20:39:41', '187.191.42.228', '', NULL, '', NULL),
(00000000053, 00000000006, '1', '5', 00000000008, 'Identificaci├│n oficial vigente (En formato PDF)', '1', 0, 1, 1, 'Identificaci├│n oficial vigente', 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', 'monica.enriquez', '2020-12-08 20:41:46', '187.191.42.228', 'monica.enriquez', '2020-12-08 20:44:49', '187.191.42.228', NULL),
(00000000054, 00000000006, '1', '5', 00000000009, 'Recibo de pago de derecho al proceso de selecci├│n (En formato PDF)', '1', 0, 1, 0, 'Recibo de pago de derecho al proceso de selecci├│n', 0, 1, 1, 1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', 'monica.enriquez', '2020-12-08 20:42:31', '187.191.42.228', 'monica.enriquez', '2020-12-08 20:53:40', '187.191.42.228', NULL),
(00000000055, 00000000006, '1', '5', 00000000010, 'T├¡tulo, C├®dula o acta de examen profesional (En formato PDF)', '1', 0, 1, 1, 'T├¡tulo, C├®dula o acta de examen profesional', 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', 'monica.enriquez', '2020-12-08 20:43:51', '187.191.42.228', 'monica.enriquez', '2020-12-08 20:45:29', '187.191.42.228', NULL),
(00000000056, 00000000006, '1', '5', 00000000011, 'Anteproyecto de tesis (En formato PDF)', '1', 0, 1, 1, 'Anteproyecto de tesis', 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', 'monica.enriquez', '2020-12-08 20:46:18', '187.191.42.228', '', NULL, '', NULL),
(00000000057, 00000000006, '1', '5', 00000000012, 'Resultados del Examen EXANI III (En formato PDF)', '1', 0, 1, 1, 'Resultados del Examen EXANI III', 0, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', 'monica.enriquez', '2020-12-08 20:48:09', '187.191.42.228', 'monica.enriquez', '2020-12-08 20:53:57', '187.191.42.228', NULL),
(00000000058, 00000000006, '1', '5', 00000000013, 'Certificado del dominio de la lengua inglesa (TOEFL e IELTS) (En formato PDF)', '1', 0, 1, 1, 'Certificado del dominio de la lengua inglesa (TOFEL e IELTS)', 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', 'monica.enriquez', '2020-12-08 20:49:01', '187.191.42.228', '', NULL, '', NULL),
(00000000059, 00000000006, '1', '5', 00000000014, '1a Carta de recomendaci├│n confidencial (En formato PDF)', '1', 0, 0, 1, '1a Carta de recomendaci├│n confidencial', 1, 1, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, '', 'monica.enriquez', '2020-12-08 20:50:07', '187.191.42.228', '', NULL, '', NULL),
(00000000060, 00000000006, '1', '5', 00000000015, '2a Carta de recomendaci├│n confidencial (En formato PDF)', '1', 0, 0, 1, '2a Carta de recomendaci├│n confidencial', 1, 1, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, '', 'monica.enriquez', '2020-12-08 20:50:46', '187.191.42.228', '', NULL, '', NULL),
(00000000061, 00000000006, '1', '5', 00000000016, '3a Carta de recomendaci├│n confidencial (En formato PDF)', '1', 0, 0, 1, '3a Carta de recomendaci├│n confidencial', 1, 1, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, '', 'monica.enriquez', '2020-12-08 20:52:52', '187.191.42.228', '', NULL, '', NULL),
(00000000062, 00000000007, '1', '5', 00000000001, 'Carta de solicitud de admisi├│n (En formato PDF)', '1', 0, 1, 1, 'Carta de solicitud de admisi├│n', 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', 'monica.enriquez', '2022-12-26 00:00:00', NULL, '', NULL, '', NULL),
(00000000063, 00000000007, '1', '5', 00000000002, 'Carta compromiso de un tutor acad├®mico (En formato PDF)', '1', 0, 1, 1, 'Carta compromiso de tutor', 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', 'monica.enriquez', '2022-12-26 00:00:00', NULL, NULL, NULL, NULL, NULL),
(00000000064, 00000000007, '1', '5', 00000000003, 'Certificado total de estudios profesionales (En formato PDF)', '1', 0, 1, 0, 'Certificado total de estudios profesionales', 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', 'monica.enriquez', '2022-12-26 00:00:00', NULL, '', NULL, '', NULL),
(00000000065, 00000000007, '1', '5', 00000000004, 'CURP o acta de nacimiento (En formato PDF)', '1', 0, 1, 0, 'CURP o acta de nacimiento', 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', 'monica.enriquez', '2022-12-26 00:00:00', NULL, '', NULL, '', NULL),
(00000000078, 00000000008, '1', '5', 00000000002, 'Carta compromiso de un tutor acad├®mico (En formato PDF)', '1', 0, 1, 1, 'Carta compromiso de tutor', 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', 'monica.enriquez', '2024-01-08 08:51:07', '201.141.111.252', '', NULL, '', NULL),
(00000000066, 00000000007, '1', '5', 00000000005, 'Curriculum vitae (En formato PDF)', '1', 0, 1, 1, 'Curriculum vitae', 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', 'monica.enriquez', '2022-12-26 00:00:00', NULL, '', NULL, '', NULL),
(00000000067, 00000000007, '1', '5', 00000000006, 'Identificaci├│n oficial vigente (En formato PDF)', '1', 0, 1, 1, 'Identificaci├│n oficial vigente', 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', 'monica.enriquez', '2022-12-26 00:00:00', NULL, '', NULL, '', NULL),
(00000000068, 00000000007, '1', '5', 00000000007, 'Recibo de pago de derecho al proceso de selecci├│n (En formato PDF)', '1', 0, 1, 1, 'Recibo de pago de derecho al proceso de selecci├│n', 1, 1, 1, 1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', 'monica.enriquez', '2022-12-26 00:00:00', NULL, NULL, NULL, NULL, NULL),
(00000000069, 00000000007, '1', '5', 00000000008, 'T├¡tulo, C├®dula o acta de examen profesional (En formato PDF)', '1', 0, 1, 1, 'T├¡tulo, C├®dula o acta de examen profesional', 0, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', 'monica.enriquez', '2022-12-26 00:00:00', NULL, NULL, NULL, NULL, NULL),
(00000000077, 00000000008, '1', '5', 00000000001, 'Carta de solicitud de admisi├│n (En formato PDF)', '1', 0, 1, 1, 'Carta de solicitud de admisi├│n', 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', 'monica.enriquez', '2024-01-08 08:50:00', '201.141.111.252', '', NULL, '', NULL),
(00000000070, 00000000007, '1', '5', 00000000009, 'Anteproyecto de tesis (En formato PDF)', '1', 0, 1, 1, 'Anteproyecto de tesis', 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', 'monica.enriquez', '2022-12-26 00:00:00', NULL, NULL, NULL, NULL, NULL),
(00000000071, 00000000007, '1', '5', 00000000010, '1a Carta de recomendaci├│n confidencial (En formato PDF)', '1', 1, 0, 1, '1a Carta de recomendaci├│n confidencial', 1, 1, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, '', 'monica.enriquez', '2022-12-26 00:00:00', NULL, '', NULL, '', NULL),
(00000000072, 00000000007, '1', '5', 00000000011, '2a Carta de recomendaci├│n confidencial (En formato PDF)', '1', 0, 0, 1, '2a Carta de recomendaci├│n confidencial', 1, 1, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, '', 'monica.enriquez', '2022-12-26 00:00:00', NULL, NULL, NULL, NULL, NULL),
(00000000073, 00000000007, '1', '5', 00000000012, '3a Carta de recomendaci├│n confidencial (En formato PDF)', '1', 0, 0, 1, '3a Carta de recomendaci├│n confidencial', 1, 1, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, '', 'monica.enriquez', '2022-12-26 00:00:00', NULL, '', NULL, '', NULL),
(00000000074, 00000000007, '1', '5', 00000000013, '4a Carta de recomendaci├│n confidencial (En formato PDF)', '1', 0, 0, 1, '4a Carta de recomendaci├│n confidencial', 1, 1, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, '', 'monica.enriquez', '2022-12-26 00:00:00', NULL, '', NULL, '', NULL),
(00000000075, 00000000007, '1', '5', 00000000014, '5a Carta de recomendaci├│n confidencial (En formato PDF)', '1', 0, 0, 1, '5a Carta de recomendaci├│n confidencial', 1, 1, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, '', 'monica.enriquez', '2022-12-26 00:00:00', NULL, '', NULL, '', NULL),
(00000000079, 00000000008, '1', '5', 00000000003, 'Certificado total de estudios profesionales (En formato PDF)', '1', 0, 1, 1, 'Certificado total de estudios profesionales', 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', 'monica.enriquez', '2024-01-08 08:52:10', '201.141.111.252', 'monica.enriquez', '2024-01-08 08:54:16', '201.141.111.252', NULL),
(00000000080, 00000000008, '1', '5', 00000000004, 'CURP o acta de nacimiento (En formato PDF)', '1', 0, 1, 0, 'CURP o acta de nacimiento', 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', 'monica.enriquez', '2024-01-08 08:53:08', '201.141.111.252', '', NULL, '', NULL),
(00000000081, 00000000008, '1', '5', 00000000005, 'Curriculum vitae (En formato PDF)', '1', 0, 1, 1, 'Curriculum vitae', 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', 'monica.enriquez', '2024-01-08 08:54:04', '201.141.111.252', '', NULL, '', NULL),
(00000000082, 00000000008, '1', '5', 00000000006, 'Identificaci├│n oficial vigente (En formato PDF)', '1', 0, 1, 0, 'Identificaci├│n oficial vigente', 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', 'monica.enriquez', '2024-01-08 08:55:29', '201.141.111.252', '', NULL, '', NULL),
(00000000083, 00000000008, '1', '5', 00000000007, 'Recibo de pago de derecho al proceso de selecci├│n (En formato PDF)', '1', 0, 1, 0, 'Recibo de pago de derecho al proceso de selecci├│n', 0, 0, 0, 1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', 'monica.enriquez', '2024-01-08 08:57:03', '201.141.111.252', 'monica.enriquez', '2024-01-08 08:58:44', '201.141.111.252', NULL),
(00000000084, 00000000008, '1', '5', 00000000008, 'T├¡tulo, C├®dula o acta de examen profesional (En formato PDF)', '1', 0, 1, 1, 'T├¡tulo, C├®dula o acta de examen profesional', 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', 'monica.enriquez', '2024-01-08 08:58:08', '201.141.111.252', '', NULL, '', NULL),
(00000000085, 00000000008, '1', '5', 00000000009, '1a Carta de recomendaci├│n confidencial (En formato PDF)', '1', 0, 0, 1, '1a Carta de recomendaci├│n confidencial', 1, 1, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, '', 'monica.enriquez', '2024-01-08 09:03:36', '201.141.111.252', 'monica.enriquez', '2024-01-08 09:06:45', '201.141.111.252', NULL),
(00000000086, 00000000008, '1', '5', 00000000010, '2a Carta de recomendaci├│n confidencial (En formato PDF)', '1', 1, 0, 1, '2a Carta de recomendaci├│n confidencial', 1, 1, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, '', 'monica.enriquez', '2024-01-08 09:04:24', '201.141.111.252', 'monica.enriquez', '2024-01-08 09:06:33', '201.141.111.252', NULL),
(00000000087, 00000000008, '1', '5', 00000000011, 'Anteproyecto de tesis (En formato PDF)', '1', 0, 1, 1, 'Anteproyecto de tesis', 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', 'monica.enriquez', '2024-01-08 09:05:13', '201.141.111.252', '', NULL, '', NULL),
(00000000088, 00000000008, '1', '5', 00000000012, 'Carta de opini├│n del director anterior en el formato establecido (En formato PDF)', '1', 0, 0, 0, 'Carta de opini├│n del director', 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, '', 'monica.enriquez', '2024-01-08 09:06:12', '201.141.111.252', 'monica.enriquez', '2024-01-08 09:07:03', '201.141.111.252', NULL),
(00000000089, 00000000008, '1', '5', 00000000013, 'Carta de opini├│n del 2o director anterior en el formato establecido (En formato PDF)', '1', 0, 0, 1, 'Carta de opini├│n del 2o director', 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, '', 'monica.enriquez', '2024-03-12 12:19:51', '10.0.73.104', '', NULL, '', NULL),
(00000000090, 00000000009, '1', '5', 00000000001, 'Carta postulaci├│n por parte de la instituci├│n u organizaci├│n proponente', '1', 0, 1, 1, '1. Carta de postulaci├│n', 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', 'monica.enriquez', '2024-09-25 15:33:01', '189.203.85.33', 'monica.enriquez', '2024-09-25 16:09:54', '189.203.85.33', 'car_postulacion'),
(00000000091, 00000000009, '1', '5', 00000000002, 'Carta de solicitud de admisi├│n exponiendo motivos y experiencia', '1', 0, 1, 1, '2. Carta de solicitud de admisi├│n exponiendo motivos y experiencia', 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', 'monica.enriquez', '2024-09-25 15:33:47', '189.203.85.33', '', NULL, '', 'car_solicitud'),
(00000000092, 00000000009, '1', '5', 00000000003, 'Carta compromiso de un investigador o investigadora del INECOL para dirigir el Plan de Acci├│n Territorial (PAT).', '1', 0, 1, 1, '3. Carta compromiso investigador o investigadora', 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', 'monica.enriquez', '2024-09-25 16:12:46', '189.203.85.33', '', NULL, '', 'cart_compromiso'),
(00000000093, 00000000009, '1', '5', 00000000004, 'Propuesta del proyecto de Plan de Acci├│n Territorial', '1', 0, 1, 1, '4. PAT', 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', '[usr_login]', '2024-09-25 16:41:46', '189.203.85.33', '', NULL, '', 'pat'),
(00000000094, 00000000009, '1', '5', 00000000005, 'Certificado total de estudios de licenciatura', '1', 0, 1, 0, '5. Certificado', 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', '[usr_login]', '2024-09-25 16:42:37', '189.203.85.33', '', NULL, '', 'certificado'),
(00000000095, 00000000009, '1', '5', 00000000006, 'Acta de nacimiento', '1', 0, 1, 0, '6. Acta de nacimiento', 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', '[usr_login]', '2024-09-25 16:43:12', '189.203.85.33', '', NULL, '', 'acta_nac'),
(00000000096, 00000000009, '1', '5', 00000000007, 'Curriculum vitae con documentos probatorios, acreditando experiencia en el ├ímbito costero.', '1', 0, 1, 1, '7. CV', 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', '[usr_login]', '2024-09-25 16:44:32', '189.203.85.33', '', NULL, '', 'cv'),
(00000000102, 00000000009, '1', '5', 00000000008, 'Fotograf├¡a (no cargar aqu├¡, solo arriba, es para revisi├│n)', '2', 0, 1, 0, 'Fotograf├¡a', 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', 'usr_login', '2024-10-07 10:03:22', '10.0.120.33', '[usr_login]', '2024-10-11 10:25:47', '187.188.227.204', 'foto'),
(00000000103, 00000000009, '1', '5', 00000000009, 'Identificaci├│n oficial vigente (Credencial de elector o Pasaporte vigente)', '1', 0, 1, 0, 'Identificaci├│n oficial vigente', 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', 'usr_login', '2024-10-07 10:08:41', '10.0.120.33', '', NULL, '', 'ident'),
(00000000104, 00000000009, '1', '5', 00000000010, 'T├¡tulo y acta de examen de licenciatura', '1', 0, 1, 0, 'T├¡tulo y acta de examen de licenciatura', 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', 'usr_login', '2024-10-07 10:11:21', '10.0.120.33', '', NULL, '', 'tit_act'),
(00000000105, 00000000009, '1', '5', 00000000011, 'C├®dula profesional', '1', 0, 1, 0, 'C├®dula profesional', 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', 'usr_login', '2024-10-07 10:12:28', '10.0.120.33', '', NULL, '', 'cedprof'),
(00000000106, 00000000009, '1', '5', 00000000012, 'Certificado m├®dico (aquellos seleccionados deber├ín presentar adicionalmente este documentos)', '1', 0, 0, 0, 'Certificado m├®dico', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', 'ingrid.aguilar', '2024-10-07 10:22:23', '10.0.120.33', '', NULL, '', 'cert_med'),
(00000000107, 00000000010, '1', '5', 00000000001, 'Carta de solicitud de admisi├│n (En formato PDF)', '1', 0, 1, 1, 'Carta de solicitud de admisi├│n', 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', '[usr_login]', '2024-12-03 14:39:57', '10.0.120.33', '', NULL, '', NULL),
(00000000108, 00000000010, '1', '5', 00000000002, 'Carta compromiso de un acad├®mico o acad├®mica para dirigir el Proyecto de Tesis (En formato PDF)', '1', 0, 1, 1, 'Carta compromiso de un acad├®mico o acad├®mica para dirigir el Proyecto de Tesis', 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', '[usr_login]', '2024-12-03 15:05:12', '10.0.120.33', '', NULL, '', NULL),
(00000000109, 00000000010, '1', '5', 00000000003, 'Certificado total de estudios profesionales (En formato PDF)', '1', 0, 1, 1, 'Certificado total de estudios profesionales', 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', '[usr_login]', '2024-12-03 15:06:34', '10.0.120.33', '', NULL, '', NULL),
(00000000110, 00000000010, '1', '5', 00000000004, 'CURP o acta de nacimiento (En formato PDF)', '1', 0, 1, 1, 'CURP o acta de nacimiento', 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', '[usr_login]', '2024-12-03 15:07:31', '10.0.120.33', '', NULL, '', NULL),
(00000000111, 00000000010, '1', '5', 00000000005, 'Curr├¡culum Vitae (En formato PDF)', '1', 0, 1, 1, 'Curr├¡culum Vitae ', 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', '[usr_login]', '2024-12-03 15:08:32', '10.0.120.33', '', NULL, '', NULL),
(00000000112, 00000000010, '1', '5', 00000000006, 'Fotograf├¡a digitalizada (En formato JPG)', '2', 0, 1, 1, 'Fotograf├¡a digitalizada', 1, 1, 1, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', '[usr_login]', '2024-12-03 15:10:43', '10.0.120.33', '[usr_login]', '2025-01-28 09:00:16', '187.189.216.229', NULL),
(00000000113, 00000000010, '1', '5', 00000000007, 'Identificaci├│n oficial vigente (En formato PDF)', '1', 0, 1, 1, 'Identificaci├│n oficial vigente', 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', '[usr_login]', '2024-12-03 15:11:48', '10.0.120.33', '', NULL, '', NULL),
(00000000114, 00000000010, '1', '5', 00000000008, 'Comprobante de pago de derecho al proceso de selecci├│n (En formato PDF)', '1', 0, 1, 1, 'Comprobante de pago de derecho al proceso de selecci├│n', 1, 1, 1, 1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', '[usr_login]', '2024-12-03 15:12:56', '10.0.120.33', '[usr_login]', '2025-01-28 08:59:56', '187.189.216.229', NULL),
(00000000115, 00000000010, '1', '5', 00000000009, 'T├¡tulo, c├®dula o acta de examen profesional (En formato PDF)', '1', 0, 1, 1, 'T├¡tulo, c├®dula o acta de examen profesional', 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', '[usr_login]', '2024-12-03 15:16:00', '10.0.120.33', '', NULL, '', NULL),
(00000000116, 00000000010, '1', '5', 00000000010, '1a Carta de recomendaci├│n confidencial (En formato PDF)', '1', 1, 0, 1, 'Carta de recomendaci├│n oficial', 1, 1, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, '', '[usr_login]', '2024-12-04 08:10:40', '10.0.120.33', '[usr_login]', '2025-01-28 09:50:37', '10.0.120.33', NULL),
(00000000117, 00000000010, '1', '5', 00000000011, '2a Carta de recomendaci├│n confidencial (En formato PDF)', '1', 1, 0, 1, '2a Carta de recomendaci├│n confidencial ', 1, 1, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, '', '[usr_login]', '2024-12-04 08:12:59', '10.0.120.33', '[usr_login]', '2025-01-28 09:50:43', '10.0.120.33', NULL),
(00000000118, 00000000010, '1', '5', 00000000012, 'Anteproyecto de tesis (En formato PDF)', '1', 0, 1, 1, 'Anteproyecto de tesis ', 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', '[usr_login]', '2024-12-04 08:14:34', '10.0.120.33', '[usr_login]', '2024-12-04 08:15:04', '10.0.120.33', NULL),
(00000000119, 00000000010, '1', '5', 00000000013, 'Carta de opini├│n del director o directora de tesis de maestr├¡a (En formato PDF)', '1', 0, 0, 1, 'Carta de opini├│n del director o directora de tesis de maestr├¡a', 1, 1, 1, 0, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, '', '[usr_login]', '2024-12-04 08:16:42', '10.0.120.33', '[usr_login]', '2025-01-28 09:50:50', '10.0.120.33', NULL),
(00000000120, 00000000010, '1', '5', 00000000014, 'Certificado del dominio de la lengua inglesa (En formato PDF)', '1', 0, 1, 1, 'Certificado del dominio de la lengua inglesa', 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', '[usr_login]', '2024-12-04 08:18:21', '10.0.120.33', '', NULL, '', NULL),
(00000000121, 00000000010, '1', '5', 00000000015, 'Reporte individual del examen EXANI III del CENEVAL (En formato PDF)', '1', 0, 1, 1, 'Reporte individual del examen EXANI III del CENEVAL', 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', '[usr_login]', '2024-12-04 08:19:34', '10.0.120.33', '', NULL, '', NULL),
(00000000124, 00000000011, '1', '5', 00000000001, 'Carta postulaci├│n por parte de la instituci├│n u organizaci├│n proponente', '1', 0, 1, 1, '1. Carta de postulaci├│n', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', 'monica.enriquez', '2025-01-31 09:45:37', '10.0.112.206', 'ingrid.aguilar', '2025-01-31 09:52:27', '10.0.112.176', 'car_postulacion'),
(00000000125, 00000000011, '1', '5', 00000000002, 'Carta de solicitud de admisi├│n exponiendo motivos y experiencia', '1', 0, 1, 1, '2. Carta de solicitud de admisi├│n exponiendo motivos y experiencia', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', 'ingrid.aguilar', '2025-01-31 09:49:09', '10.0.112.176', 'ingrid.aguilar', '2025-01-31 09:53:03', '10.0.112.176', 'car_solicitud'),
(00000000126, 00000000009, '1', '5', 00000000003, 'Carta compromiso de un investigador o investigadora del INECOL para dirigir el Plan de Acci├│n Territorial (PAT)', '1', 0, 1, 1, '3. Carta compromiso investigador o investigadora', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', 'ingrid.aguilar', '2025-01-31 09:58:41', '10.0.112.176', '', NULL, '', 'cart_compromiso'),
(00000000127, 00000000011, '1', '5', 00000000003, 'Carta compromiso de un investigador o investigadora del INECOL para dirigir el Plan de Acci├│n Territorial (PAT).', '1', 0, 1, 1, '3. Carta compromiso investigador o investigadora', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', 'ingrid.aguilar', '2025-01-31 09:59:32', '10.0.112.176', 'ingrid.aguilar', '2025-01-31 10:00:26', '10.0.112.176', 'cart_compromiso'),
(00000000128, 00000000011, '1', '5', 00000000004, 'Propuesta del proyecto de Plan de Acci├│n Territorial', '1', 0, 1, 1, '4. PAT', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', 'ingrid.aguilar', '2025-01-31 10:01:33', '10.0.112.176', 'ingrid.aguilar', '2025-01-31 10:01:57', '10.0.112.176', 'pat'),
(00000000129, 00000000011, '1', '5', 00000000005, 'Certificado total de estudios de licenciatura', '1', 0, 1, 0, '5. Certificado', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', 'ingrid.aguilar', '2025-01-31 10:03:52', '10.0.112.176', 'ingrid.aguilar', '2025-01-31 10:12:06', '10.0.112.176', 'certificado'),
(00000000130, 00000000011, '1', '5', 00000000006, 'Acta de nacimiento', '1', 0, 1, 0, '6. Acta de nacimiento', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', 'ingrid.aguilar', '2025-01-31 10:05:00', '10.0.112.176', 'ingrid.aguilar', '2025-01-31 10:12:13', '10.0.112.176', 'acta_nac'),
(00000000131, 00000000011, '1', '5', 00000000007, 'Curriculum vitae con documentos probatorios, acreditando experiencia en el ├ímbito costero.', '1', 0, 1, 1, '7. CV', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', 'ingrid.aguilar', '2025-01-31 10:05:35', '10.0.112.176', '', NULL, '', 'cv'),
(00000000132, 00000000011, '1', '5', 00000000008, 'Fotograf├¡a (no cargar aqu├¡, solo arriba, es para revisi├│n)', '1', 0, 1, 0, '8. Fotograf├¡a', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', 'ingrid.aguilar', '2025-01-31 10:06:11', '10.0.112.176', 'ingrid.aguilar', '2025-01-31 10:12:33', '10.0.112.176', 'foto'),
(00000000133, 00000000011, '1', '5', 00000000009, 'Identificaci├│n oficial vigente (Credencial de elector o Pasaporte vigente)', '1', 0, 1, 0, '9. Identificaci├│n oficial vigente', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', 'ingrid.aguilar', '2025-01-31 10:06:48', '10.0.112.176', 'ingrid.aguilar', '2025-01-31 10:12:45', '10.0.112.176', 'ident'),
(00000000134, 00000000011, '1', '5', 00000000010, 'T├¡tulo y acta de examen de licenciatura', '1', 0, 1, 0, '10. T├¡tulo y acta de examen de licenciatura', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', 'ingrid.aguilar', '2025-01-31 10:07:33', '10.0.112.176', 'ingrid.aguilar', '2025-01-31 10:12:52', '10.0.112.176', 'tit_act'),
(00000000135, 00000000011, '1', '5', 00000000011, 'C├®dula profesional', '1', 0, 1, 0, '11. C├®dula profesional', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', 'ingrid.aguilar', '2025-01-31 10:08:52', '10.0.112.176', 'ingrid.aguilar', '2025-01-31 10:12:59', '10.0.112.176', 'cedprof'),
(00000000136, 00000000011, '1', '5', 00000000012, 'Certificado m├®dico (aquellos seleccionados deber├ín presentar adicionalmente este documentos)', '1', 0, 0, 0, '12. Certificado m├®dico', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', 'ingrid.aguilar', '2025-01-31 10:09:25', '10.0.112.176', 'ingrid.aguilar', '2025-01-31 10:13:20', '10.0.112.176', 'cert_med');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `list_req_gral`
--
ALTER TABLE `list_req_gral`
  ADD PRIMARY KEY (`id_lisreq`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `list_req_gral`
--
ALTER TABLE `list_req_gral`
  MODIFY `id_lisreq` int(11) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'Identificador de lista de requisitos general', AUTO_INCREMENT=139;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
