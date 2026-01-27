-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-01-2026 a las 20:48:24
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
-- Estructura de tabla para la tabla `asp_recomendantes`
--

CREATE TABLE `asp_recomendantes` (
  `id_asp_recom` int(11) UNSIGNED ZEROFILL NOT NULL,
  `id_asp_FK` int(11) UNSIGNED ZEROFILL NOT NULL,
  `num_req` int(10) UNSIGNED ZEROFILL DEFAULT NULL,
  `id_recom_FK` int(11) UNSIGNED ZEROFILL NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `asp_recomendantes`
--

INSERT INTO `asp_recomendantes` (`id_asp_recom`, `id_asp_FK`, `num_req`, `id_recom_FK`) VALUES
(00000000001, 00000001222, 0000000010, 00000000001),
(00000000002, 00000001222, NULL, 00000000002),
(00000000003, 00000001222, NULL, 00000000003),
(00000000004, 00000001223, 0000000010, 00000000001),
(00000000005, 00000001223, 0000000010, 00000000002),
(00000000006, 00000001223, 0000000011, 00000000004);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asp_recomendantes`
--
ALTER TABLE `asp_recomendantes`
  ADD PRIMARY KEY (`id_asp_recom`),
  ADD UNIQUE KEY `uk_asp_recom` (`id_asp_FK`,`id_recom_FK`),
  ADD KEY `idx_asp` (`id_asp_FK`),
  ADD KEY `idx_recom` (`id_recom_FK`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asp_recomendantes`
--
ALTER TABLE `asp_recomendantes`
  MODIFY `id_asp_recom` int(11) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
