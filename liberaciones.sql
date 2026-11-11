-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-11-2026 a las 01:43:20
-- Versión del servidor: 10.11.16-MariaDB
-- Versión de PHP: 8.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `liberaciones`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `servicio` varchar(150) NOT NULL,
  `imei` varchar(20) DEFAULT NULL,
  `compania` varchar(100) DEFAULT NULL,
  `costo` decimal(10,2) NOT NULL DEFAULT 0.00,
  `monto` decimal(10,2) NOT NULL DEFAULT 0.00,
  `estado` enum('pendiente','procesando','completado','rechazado') NOT NULL DEFAULT 'pendiente',
  `resultado` varchar(255) DEFAULT 'Procesando',
  `reembolsado` enum('No','Si') DEFAULT 'No',
  `fecha_pedido` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `id_usuario`, `servicio`, `imei`, `compania`, `costo`, `monto`, `estado`, `resultado`, `reembolsado`, `fecha_pedido`) VALUES
(1, 2, '', '108243945710384', 'telcel', 150.00, 0.00, 'completado', 'Codigo: 24689', 'No', '2026-11-10 20:52:05'),
(2, 2, '', '123456789012345', 'atti', 50.00, 0.00, 'rechazado', 'No compatible', 'Si', '2026-11-10 21:41:40'),
(3, 2, '', '134454656576888', 'unefon', 50.00, 0.00, 'completado', 'Codigo: 13682', 'No', '2026-11-10 22:02:21'),
(4, 2, '', '343546767673444', 'movistar', 50.00, 0.00, 'pendiente', 'Procesando', 'No', '2026-11-10 22:09:47');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `correo` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('admin','cliente') DEFAULT 'cliente',
  `saldo` decimal(10,2) DEFAULT 0.00,
  `fecha_registro` timestamp NULL DEFAULT current_timestamp(),
  `token_recuperacion` varchar(255) DEFAULT NULL,
  `expira_token` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellidos`, `telefono`, `correo`, `password`, `rol`, `saldo`, `fecha_registro`, `token_recuperacion`, `expira_token`) VALUES
(1, 'Dimarel', 'Sosa Moreno', '9535404889', 'dimarelsosa40@gmail.com', '$2y$12$t3nXtIeswdW.0lZ/vQeQxu4IoLV2tcwLbhQ948GCXNKVW1U2Q//g6', 'admin', 0.00, '2026-11-10 20:02:57', NULL, NULL),
(2, 'Miguel', 'Reyes Medrano', '1234567890', 'miguelmedrano@gmail.com', '$2y$12$aJgwvjHzEnUGkLGEG5DIdeyPLLyrQ1ZI6xBe55yDc.2BpmJrtqfim', 'cliente', 400.00, '2026-11-10 20:35:30', NULL, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
