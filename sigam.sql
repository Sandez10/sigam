-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-07-2025 a las 21:03:35
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sigam`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro`
--

CREATE TABLE `registro` (
  `id_registros` int(255) NOT NULL,
  `log` varchar(150) DEFAULT NULL,
  `num_logia` int(150) DEFAULT NULL,
  `nombre` varchar(150) DEFAULT NULL,
  `estado` varchar(100) DEFAULT NULL,
  `grado` varchar(100) DEFAULT NULL,
  `capitas` int(150) DEFAULT NULL,
  `iniciacion` int(150) DEFAULT NULL,
  `exaltacion` int(150) DEFAULT NULL,
  `trimestre` varchar(100) DEFAULT NULL,
  `seguro_,as` int(150) DEFAULT NULL,
  `aumento_salario` int(150) DEFAULT NULL,
  `afiliacion` int(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `usrId` int(11) NOT NULL,
  `usr` varchar(50) NOT NULL,
  `clave` varchar(255) NOT NULL,
  `estado` enum('Activo','No Activo') NOT NULL DEFAULT 'Activo',
  `rol` varchar(50) NOT NULL DEFAULT 'usuario',
  `password_reset_required` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`usrId`, `usr`, `clave`, `estado`, `rol`, `password_reset_required`) VALUES
(2, 'admin', '$2y$10$zKc9VclwbU2P5YAnW6qPxefUbLaKpQO1ESMfZ3IfovEmlBqqGTRp6', 'Activo', 'admin', 0),
(3, 'admon', '2f8d5b5d34234eb11836575637bb652af54881bdb385a50398fefec3261d765d', 'Activo', 'usuario', 0),
(4, 'administrador', '$2y$10$PttXwmupngxYNmlKUlBaSeqa.s.afFg/MAOZPDMhciXYM4nzqGMbK', 'Activo', 'admin', 0),
(5, 'noadmin', '$2y$10$A.Qv7zcM37AzCq/snr/kCehXZJf0JerdAfsXeHLxDOb3.47QPPBBK', 'Activo', 'usuario', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `registro`
--
ALTER TABLE `registro`
  ADD PRIMARY KEY (`id_registros`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`usrId`),
  ADD UNIQUE KEY `usr` (`usr`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `registro`
--
ALTER TABLE `registro`
  MODIFY `id_registros` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `usrId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
