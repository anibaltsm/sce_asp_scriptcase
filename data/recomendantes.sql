-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-01-2026 a las 20:48:48
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
-- Base de datos: `sce_asp`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recomendantes`
--

CREATE TABLE `recomendantes` (
  `id_recom` int(11) UNSIGNED ZEROFILL NOT NULL,
  `id_persacadposg_FK` int(11) UNSIGNED ZEROFILL DEFAULT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `apellido_p` varchar(80) DEFAULT NULL,
  `apellido_m` varchar(80) DEFAULT NULL,
  `correo` varchar(80) NOT NULL,
  `num_recom` int(1) UNSIGNED ZEROFILL DEFAULT NULL,
  `login_FK` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `recomendantes`
--

INSERT INTO `recomendantes` (`id_recom`, `id_persacadposg_FK`, `nombre`, `apellido_p`, `apellido_m`, `correo`, `num_recom`, `login_FK`) VALUES
(00000000001, 00000000001, 'Carolina', 'Valdespino', 'Quevedo', 'carolina.valdespino@inecol.mx', 1, '0'),
(00000000002, 00000000002, 'Salvador', 'Mandujano', 'Rodríguez', 'salvador.mandujano@inecol.mx', 2, '0'),
(00000000003, NULL, 'Juan', 'Pérez', 'López', 'juan.perez@universidad.mx', 3, '0'),
(00000000004, NULL, 'fernando', 'ram', 'flo', 'fer_chuy05@hotmail.com', 2, 'fe.ram');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `recomendantes`
--
ALTER TABLE `recomendantes`
  ADD PRIMARY KEY (`id_recom`),
  ADD UNIQUE KEY `uk_correo_recom` (`correo`),
  ADD KEY `idx_persacadposg` (`id_persacadposg_FK`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `recomendantes`
--
ALTER TABLE `recomendantes`
  MODIFY `id_recom` int(11) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
