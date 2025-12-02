-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-11-2025 a las 11:15:41
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
-- Base de datos: `sigea`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aeronaves`
--

CREATE TABLE `aeronaves` (
  `id` int(11) NOT NULL,
  `modelo` varchar(50) DEFAULT NULL,
  `matricula` varchar(20) DEFAULT NULL,
  `horas_vuelo` int(11) DEFAULT 0,
  `estado` enum('Operativa','En Mantenimiento','Fuera de Servicio') DEFAULT 'Operativa',
  `capacidad` int(11) DEFAULT 100
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `aeronaves`
--

INSERT INTO `aeronaves` (`id`, `modelo`, `matricula`, `horas_vuelo`, `estado`, `capacidad`) VALUES
(1, 'f_17', '2019', 0, 'En Mantenimiento', 100),
(2, 'f_17', '2019', 0, 'Operativa', 120);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `chat`
--

CREATE TABLE `chat` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `mensaje` text DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `canal` enum('global','operaciones','mantenimiento','pilotos','privado') DEFAULT 'global'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `destinos`
--

CREATE TABLE `destinos` (
  `id` int(11) NOT NULL,
  `pais` varchar(100) NOT NULL,
  `ciudad` varchar(100) NOT NULL,
  `codigo` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `destinos`
--

INSERT INTO `destinos` (`id`, `pais`, `ciudad`, `codigo`) VALUES
(1, 'Perú', 'Lima', 'LIM'),
(2, 'Argentina', 'Buenos Aires', 'EZE'),
(3, 'Estados Unidos', 'Miami', 'MIA'),
(4, 'España', 'Madrid', 'MAD'),
(5, 'México', 'Ciudad de México', 'MEX');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `disponibilidades_empleado`
--

CREATE TABLE `disponibilidades_empleado` (
  `id` int(11) NOT NULL,
  `empleado_id` int(11) NOT NULL,
  `inicio` datetime NOT NULL,
  `fin` datetime NOT NULL,
  `tipo` enum('ocupado','descanso') NOT NULL,
  `referencia_tipo` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `documento` varchar(20) DEFAULT NULL,
  `rol` enum('Piloto','Tripulacion','Mantenimiento','Operaciones','Administrador') DEFAULT NULL,
  `certificaciones` text DEFAULT NULL,
  `idiomas` text DEFAULT NULL,
  `disponible` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id`, `nombre`, `documento`, `rol`, `certificaciones`, `idiomas`, `disponible`) VALUES
(1, 'keilor', '12567834', 'Mantenimiento', 'junior 2021', 'español', 1),
(2, 'keilor', '12567834', 'Operaciones', 'ninguno', 'nada', 1),
(3, 'axel', '17117027', 'Piloto', 'ninguno', 'español, ingles, portugues', 1),
(4, 'pablo', '12567834', 'Tripulacion', 'aerolineas s.a', 'aleman', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `incidencias`
--

CREATE TABLE `incidencias` (
  `id` int(11) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `reportado_por` int(11) DEFAULT NULL,
  `estado` enum('Abierto','En Proceso','Cerrado') DEFAULT 'Abierto',
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pasajeros`
--

CREATE TABLE `pasajeros` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `documento` varchar(50) DEFAULT NULL,
  `email` varchar(120) DEFAULT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  `pass` varchar(255) DEFAULT NULL,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

CREATE TABLE `reservas` (
  `id` int(11) NOT NULL,
  `vuelo_id` int(11) NOT NULL,
  `pasajero_id` int(11) NOT NULL,
  `asiento` varchar(10) DEFAULT NULL,
  `fecha_reserva` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` enum('Reservada','Cancelada') DEFAULT 'Reservada'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) DEFAULT NULL,
  `pass` varchar(255) DEFAULT NULL,
  `rol` enum('AdminMaster','Administrador','Operaciones','Mantenimiento','Piloto','Tripulacion') DEFAULT NULL,
  `empleado_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `pass`, `rol`, `empleado_id`) VALUES
(2, 'admin', '240be518fabd2724ddb6f04eeb1da5967448d7e831c08c8fa822809f74c720a9', 'AdminMaster', NULL),
(3, 'admin2', 'e2bfc3e51824f7035928204ade44b77cdcf2846b82ddfb93d5a5a7f6c76e048e', 'AdminMaster', NULL),
(4, 'brian', '$2y$10$/HN.mab1c8ofBF.WugMW3eLxdN4JVqV/beBg2Fcj8fGcrll9f9s/W', 'Administrador', NULL),
(5, 'key', '$2y$10$Y5lxV/GyIPNZVgICNJ.YJusgn4XrbNf3fDWBZeTA5JxV.i4UAVpSq', 'Operaciones', 2),
(7, 'axel', '$2y$10$AeNkt3Whiz2vP3j7L0blw.qCpVViV0561YrohkPEEkTA2HhjpbmDe', 'Piloto', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vuelos`
--

CREATE TABLE `vuelos` (
  `id` int(11) NOT NULL,
  `numero` varchar(10) DEFAULT NULL,
  `origen` varchar(50) DEFAULT NULL,
  `destino` varchar(50) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `aeronave_id` int(11) DEFAULT NULL,
  `piloto_id` int(11) DEFAULT NULL,
  `tripulacion_id` int(11) DEFAULT NULL,
  `estado` enum('Programado','En Vuelo','Retrasado','Finalizado','Cancelado') DEFAULT 'Programado',
  `fecha_inicio` datetime DEFAULT NULL,
  `fecha_fin` datetime DEFAULT NULL,
  `duracion_horas` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vuelos`
--

INSERT INTO `vuelos` (`id`, `numero`, `origen`, `destino`, `fecha`, `aeronave_id`, `piloto_id`, `tripulacion_id`, `estado`, `fecha_inicio`, `fecha_fin`, `duracion_horas`) VALUES
(1, '1001', 'argentina', 'bahamas', '2025-11-30 13:41:00', 2, 3, 4, 'Programado', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vuelos_personal`
--

CREATE TABLE `vuelos_personal` (
  `id` int(11) NOT NULL,
  `vuelo_id` int(11) NOT NULL,
  `empleado_id` int(11) NOT NULL,
  `rol_en_vuelo` varchar(50) DEFAULT 'Tripulacion'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `aeronaves`
--
ALTER TABLE `aeronaves`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `destinos`
--
ALTER TABLE `destinos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `disponibilidades_empleado`
--
ALTER TABLE `disponibilidades_empleado`
  ADD PRIMARY KEY (`id`),
  ADD KEY `empleado_id` (`empleado_id`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `incidencias`
--
ALTER TABLE `incidencias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pasajeros`
--
ALTER TABLE `pasajeros`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_pasajeros_email` (`email`);

--
-- Indices de la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pasajero_id` (`pasajero_id`),
  ADD KEY `idx_reservas_vuelo` (`vuelo_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`),
  ADD KEY `empleado_id` (`empleado_id`);

--
-- Indices de la tabla `vuelos`
--
ALTER TABLE `vuelos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aeronave_id` (`aeronave_id`),
  ADD KEY `piloto_id` (`piloto_id`),
  ADD KEY `tripulacion_id` (`tripulacion_id`),
  ADD KEY `idx_vuelo_fecha` (`fecha_inicio`);

--
-- Indices de la tabla `vuelos_personal`
--
ALTER TABLE `vuelos_personal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vuelo_id` (`vuelo_id`),
  ADD KEY `empleado_id` (`empleado_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `aeronaves`
--
ALTER TABLE `aeronaves`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `chat`
--
ALTER TABLE `chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `destinos`
--
ALTER TABLE `destinos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `disponibilidades_empleado`
--
ALTER TABLE `disponibilidades_empleado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `incidencias`
--
ALTER TABLE `incidencias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pasajeros`
--
ALTER TABLE `pasajeros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `vuelos`
--
ALTER TABLE `vuelos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `vuelos_personal`
--
ALTER TABLE `vuelos_personal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `disponibilidades_empleado`
--
ALTER TABLE `disponibilidades_empleado`
  ADD CONSTRAINT `disponibilidades_empleado_ibfk_1` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `reservas_ibfk_1` FOREIGN KEY (`vuelo_id`) REFERENCES `vuelos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservas_ibfk_2` FOREIGN KEY (`pasajero_id`) REFERENCES `pasajeros` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `vuelos`
--
ALTER TABLE `vuelos`
  ADD CONSTRAINT `vuelos_ibfk_1` FOREIGN KEY (`aeronave_id`) REFERENCES `aeronaves` (`id`),
  ADD CONSTRAINT `vuelos_ibfk_2` FOREIGN KEY (`piloto_id`) REFERENCES `empleados` (`id`),
  ADD CONSTRAINT `vuelos_ibfk_3` FOREIGN KEY (`tripulacion_id`) REFERENCES `empleados` (`id`);

--
-- Filtros para la tabla `vuelos_personal`
--
ALTER TABLE `vuelos_personal`
  ADD CONSTRAINT `vuelos_personal_ibfk_1` FOREIGN KEY (`vuelo_id`) REFERENCES `vuelos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `vuelos_personal_ibfk_2` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
