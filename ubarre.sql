-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 18-09-2025 a las 04:09:44
-- Versión del servidor: 10.11.10-MariaDB
-- Versión de PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `u379047759_ubarre`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clases`
--

CREATE TABLE `clases` (
  `id` int(11) NOT NULL,
  `id_coach` int(11) NOT NULL,
  `hora_inicio` varchar(200) NOT NULL,
  `hora_fin` varchar(200) NOT NULL,
  `aforo` int(11) NOT NULL,
  `reservados` int(11) NOT NULL DEFAULT 0,
  `id_disciplina` int(11) NOT NULL,
  `estatus` varchar(2) DEFAULT '1',
  `fecha` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `coaches`
--

CREATE TABLE `coaches` (
  `id` int(11) NOT NULL,
  `nombre_coach` varchar(255) NOT NULL,
  `descripcion_coach` text NOT NULL,
  `id_disciplina` int(11) DEFAULT NULL,
  `activo` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `coaches`
--

INSERT INTO `coaches` (`id`, `nombre_coach`, `descripcion_coach`, `id_disciplina`, `activo`, `fecha`) VALUES
(1, 'Karyna', 'Soy el tipo de entrenadora que quiere que disfrutes cada segundo del reto. Me gusta mantenerte activa, conectada y motivada. Mis clases son dinámicas, con ritmo y buena energía. Quiero que sientas el poder de tu cuerpo en movimiento y salgas sabiendo que diste lo mejor de ti, sin presiones, pero con intención.', 1, 1, '2025-09-18 03:32:27'),
(2, 'Viry', 'Para mí, Barre es una forma de reconectar. En mis clases me enfoco en que te sientas segura, cómoda y acompañada. Cuido mucho la postura, la alineación y los detalles que hacen la diferencia. Mi intención es que vivas el ejercicio como un espacio de autocuidado, donde entrenas con amor y sin prisa.', 1, 1, '2025-09-18 03:32:52');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `creditos_vencidos`
--

CREATE TABLE `creditos_vencidos` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `creditos_vencidos` varchar(200) DEFAULT NULL,
  `fecha_vencimiento` datetime NOT NULL,
  `fecha_procesado` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `disciplinas`
--

CREATE TABLE `disciplinas` (
  `id` int(11) NOT NULL,
  `nombre_disciplina` varchar(255) NOT NULL,
  `descripcion_disciplina` text NOT NULL,
  `subdescripcion_texto1` varchar(20) DEFAULT NULL,
  `subdescripcion_texto2` varchar(20) DEFAULT NULL,
  `subdescripcion_texto3` varchar(20) DEFAULT NULL,
  `activo` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `disciplinas`
--

INSERT INTO `disciplinas` (`id`, `nombre_disciplina`, `descripcion_disciplina`, `subdescripcion_texto1`, `subdescripcion_texto2`, `subdescripcion_texto3`, `activo`, `fecha`) VALUES
(1, 'POWER BARRE', 'El barre es un entrenamiento que combina ballet, pilates y ejercicios de fuerza, usando una barra para tonificar músculos, mejorar la postura y aumentar la flexibilidad. Es de bajo impacto y muy efectivo para esculpir el cuerpo. ', 'Fuerza', 'Estilo', 'Flexibilidad', 1, '2025-09-18 03:29:23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `egr`
--

CREATE TABLE `egr` (
  `id` int(11) NOT NULL,
  `fecha` varchar(220) NOT NULL,
  `concepto` varchar(220) NOT NULL,
  `tipo` varchar(220) NOT NULL,
  `monto` varchar(220) NOT NULL,
  `fechaRegistro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paquetes`
--

CREATE TABLE `paquetes` (
  `id` int(11) NOT NULL,
  `clases` varchar(255) DEFAULT NULL,
  `costo` varchar(255) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `vigencia` varchar(100) DEFAULT NULL,
  `invitados` varchar(255) DEFAULT NULL,
  `persona` varchar(2) DEFAULT NULL,
  `descuento` varchar(200) DEFAULT NULL,
  `finalizadsc` varchar(200) DEFAULT NULL,
  `smoothies` int(10) NOT NULL,
  `total_smoothies` varchar(10) NOT NULL,
  `ilimitado` varchar(2) NOT NULL DEFAULT '0',
  `fecha` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `paquetes`
--

INSERT INTO `paquetes` (`id`, `clases`, `costo`, `nombre`, `vigencia`, `invitados`, `persona`, `descuento`, `finalizadsc`, `smoothies`, `total_smoothies`, `ilimitado`, `fecha`) VALUES
(1, '1', '100', 'MUESTRA', '1', '0', '1', NULL, NULL, 0, '0', '0', '2025-09-18 03:51:46'),
(2, '1', '180', 'SUELTA', '1', '0', '1', NULL, NULL, 0, '', '0', '2025-09-18 03:58:59'),
(3, '4', '680', 'BASIC 4', '30', '0', '1', NULL, NULL, 0, '0', '0', '2025-09-18 03:59:38'),
(4, '8', '1320', 'BASIC 8', '30', '0', '1', NULL, NULL, 0, '', '0', '2025-09-18 04:00:01'),
(5, '12', '1920', 'BASIC 12', '30', '0', '1', NULL, NULL, 0, '', '0', '2025-09-18 04:00:26'),
(6, 'Ilimitado', '2800', 'BASIC FULL', '30', '0', '1', NULL, NULL, 0, '', '1', '2025-09-18 04:00:51'),
(7, '4', '960', 'SMOOTHIE 4', '30', '0', '1', NULL, NULL, 1, '4', '0', '2025-09-18 04:01:29'),
(8, '8', '1840', 'SMOOTHIE 8', '30', '0', '1', NULL, NULL, 1, '8', '0', '2025-09-18 04:01:57'),
(9, '12', '2700', 'SMOOTHIE 12', '30', '0', '1', NULL, NULL, 1, '12', '0', '2025-09-18 04:02:22'),
(10, 'Ilimitado', '3500', 'FULL SMOOTHIE', '30', '0', '1', NULL, NULL, 1, '12', '1', '2025-09-18 04:03:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservaciones`
--

CREATE TABLE `reservaciones` (
  `id` int(11) NOT NULL,
  `clase` varchar(255) DEFAULT NULL,
  `idClase` varchar(255) DEFAULT NULL,
  `alumno` varchar(255) DEFAULT NULL,
  `dura` varchar(255) DEFAULT NULL,
  `instructor` varchar(255) DEFAULT NULL,
  `idInstructor` varchar(2) DEFAULT NULL,
  `invitado` varchar(255) DEFAULT '0',
  `activo` varchar(255) DEFAULT NULL,
  `asiste` varchar(20) DEFAULT NULL,
  `sabor` varchar(100) NOT NULL,
  `momento` varchar(220) NOT NULL,
  `inicio` datetime DEFAULT NULL,
  `fin` datetime DEFAULT NULL,
  `fechaReserva` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `smoothies`
--

CREATE TABLE `smoothies` (
  `id` int(10) UNSIGNED NOT NULL,
  `sabor` varchar(100) NOT NULL,
  `descrip` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `smoothies`
--

INSERT INTO `smoothies` (`id`, `sabor`, `descrip`) VALUES
(20, 'MAGO MATCHA', 'LECHE + MANGO + PROTEÍNA + MATCHA VAINILLA'),
(21, 'PLÁTANO CHOCOLATE', 'LECHE + PLÁTANO + NIBS DE CACAO + CREMA DE CACAHUATE + PROTEÍNA DE CACAO'),
(22, 'MOKA', 'LECHE + PLÁTANO + CAFÉ + PROTEÍNA + MOKA'),
(23, 'FRESA', 'LECHE + FRESA CONGELADA + YOGURT GRIEGO + CANELA + PROTEÍNA DE VAINILLA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transacciones`
--

CREATE TABLE `transacciones` (
  `id` int(11) NOT NULL,
  `user` varchar(255) DEFAULT NULL,
  `monto` varchar(255) DEFAULT NULL,
  `creditos` varchar(255) DEFAULT NULL,
  `numero` varchar(255) DEFAULT NULL,
  `metodo` varchar(255) DEFAULT NULL,
  `idpago` varchar(255) DEFAULT NULL,
  `mrecibido` varchar(255) DEFAULT NULL,
  `fecha` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `iduser` varchar(255) DEFAULT NULL,
  `tipoUser` varchar(10) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `apellido` varchar(255) DEFAULT NULL,
  `mail` varchar(255) DEFAULT NULL,
  `numero` varchar(255) DEFAULT NULL,
  `pass` varchar(32) DEFAULT NULL,
  `fecha_nacimiento` varchar(220) DEFAULT NULL,
  `total_smoothies` varchar(10) NOT NULL,
  `credit` varchar(255) DEFAULT NULL,
  `ilimitado` int(11) DEFAULT NULL,
  `venceCredit` varchar(20) DEFAULT NULL,
  `fechaCredit` varchar(100) DEFAULT NULL,
  `maxInvitados` varchar(10) DEFAULT NULL,
  `claseBienvenida` varchar(2) DEFAULT NULL,
  `tlogin` varchar(6) DEFAULT NULL,
  `dlogin` varchar(100) DEFAULT NULL,
  `statu` varchar(255) DEFAULT NULL,
  `idpago` varchar(255) DEFAULT NULL,
  `montoPagado` varchar(255) DEFAULT NULL,
  `customer_id` varchar(255) DEFAULT NULL,
  `activo` varchar(255) DEFAULT NULL,
  `fecha` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `iduser`, `tipoUser`, `nombre`, `apellido`, `mail`, `numero`, `pass`, `fecha_nacimiento`, `total_smoothies`, `credit`, `ilimitado`, `venceCredit`, `fechaCredit`, `maxInvitados`, `claseBienvenida`, `tlogin`, `dlogin`, `statu`, `idpago`, `montoPagado`, `customer_id`, `activo`, `fecha`) VALUES
(1, NULL, '3', 'Karyna', 'ubarre', 'karyna@ubarre.com.mx', '123456789', 'ubarre101', '', '', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-18 03:25:24'),
(2, NULL, '3', 'Viry', 'ubarre', 'viry@ubarre.com.mx', '1234567891', 'ubarre101', '', '', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-18 03:26:01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_cards`
--

CREATE TABLE `user_cards` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `customer_id` varchar(255) NOT NULL,
  `card_id` varchar(255) DEFAULT NULL,
  `last_four_digits` varchar(4) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `card_type` varchar(20) NOT NULL COMMENT 'credit, debit, etc',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clases`
--
ALTER TABLE `clases`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `coaches`
--
ALTER TABLE `coaches`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `creditos_vencidos`
--
ALTER TABLE `creditos_vencidos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `disciplinas`
--
ALTER TABLE `disciplinas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `egr`
--
ALTER TABLE `egr`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `paquetes`
--
ALTER TABLE `paquetes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `reservaciones`
--
ALTER TABLE `reservaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `smoothies`
--
ALTER TABLE `smoothies`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `transacciones`
--
ALTER TABLE `transacciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `user_cards`
--
ALTER TABLE `user_cards`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clases`
--
ALTER TABLE `clases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `coaches`
--
ALTER TABLE `coaches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `creditos_vencidos`
--
ALTER TABLE `creditos_vencidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `disciplinas`
--
ALTER TABLE `disciplinas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `egr`
--
ALTER TABLE `egr`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `paquetes`
--
ALTER TABLE `paquetes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `reservaciones`
--
ALTER TABLE `reservaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `smoothies`
--
ALTER TABLE `smoothies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `transacciones`
--
ALTER TABLE `transacciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `user_cards`
--
ALTER TABLE `user_cards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
