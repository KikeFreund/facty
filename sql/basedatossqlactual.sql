-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-08-2025 a las 23:09:02
-- Versión del servidor: 10.11.10-MariaDB-log
-- Versión de PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `u621081351_facturacion`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contadores`
--

CREATE TABLE `contadores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(11) NOT NULL,
  `apellido` varchar(11) NOT NULL,
  `cedula` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datosFiscales`
--

CREATE TABLE `datosFiscales` (
  `id` int(11) NOT NULL,
  `razonSocial` varchar(100) NOT NULL,
  `rfc` varchar(50) NOT NULL,
  `regimen` int(11) NOT NULL,
  `calle` varchar(20) NOT NULL,
  `numeroExterior` varchar(10) NOT NULL,
  `numeroInterior` varchar(10) NOT NULL,
  `colonia` varchar(50) NOT NULL,
  `municipio` varchar(50) NOT NULL,
  `localidad` varchar(50) DEFAULT NULL,
  `estado` varchar(50) NOT NULL,
  `pais` varchar(50) NOT NULL,
  `codigoPostal` varchar(10) NOT NULL,
  `usoFavorito` int(11) NOT NULL,
  `constancia` varchar(100) DEFAULT NULL,
  `correo` varchar(100) NOT NULL,
  `telefono` varchar(100) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `estatus` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datosPagina`
--

CREATE TABLE `datosPagina` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `color` varchar(50) NOT NULL,
  `logo` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresas`
--

CREATE TABLE `empresas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(11) NOT NULL,
  `direccion` varchar(11) NOT NULL,
  `telefono` varchar(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

CREATE TABLE `facturas` (
  `id` int(11) NOT NULL,
  `ticket_id` varchar(50) DEFAULT NULL,
  `nombre_archivo` varchar(255) DEFAULT NULL,
  `archivo_pdf` varchar(255) DEFAULT NULL,
  `archivo_xml` varchar(255) DEFAULT NULL,
  `creado_en` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `invitaciones`
--

CREATE TABLE `invitaciones` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL COMMENT 'es el usuario que mando el link de invitacion\r\n',
  `usada` int(11) NOT NULL DEFAULT 0 COMMENT '0 es no 1 es si',
  `fecha_generacion` varchar(40) NOT NULL,
  `id_referido` int(11) NOT NULL,
  `mensaje` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metodosPago`
--

CREATE TABLE `metodosPago` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `regimenes`
--

CREATE TABLE `regimenes` (
  `id` int(11) NOT NULL,
  `clave` varchar(11) NOT NULL,
  `nombre` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `regimenesFiscales`
--

CREATE TABLE `regimenesFiscales` (
  `id` int(11) NOT NULL,
  `clave` varchar(5) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `persona_fisica` tinyint(1) NOT NULL,
  `persona_moral` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sesiones`
--

CREATE TABLE `sesiones` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `token` varchar(64) NOT NULL,
  `expiracion` datetime NOT NULL,
  `user_agent` text DEFAULT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `device_id` varchar(100) DEFAULT NULL,
  `estatus` int(11) DEFAULT NULL,
  `creado_en` datetime DEFAULT current_timestamp(),
  `ultima_actividad` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ticket`
--

CREATE TABLE `ticket` (
  `id` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_empresa` int(11) DEFAULT NULL,
  `monto` varchar(20) NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `metodoPago` int(11) NOT NULL,
  `usoCfdi` varchar(10) NOT NULL,
  `numeroTicket` varchar(40) DEFAULT NULL,
  `fecha` varchar(50) NOT NULL,
  `id_datos` int(11) NOT NULL,
  `imagen_ticket` varchar(255) DEFAULT NULL,
  `foto_ticket` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiposUsuarios`
--

CREATE TABLE `tiposUsuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `estatus` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usosCfdi`
--

CREATE TABLE `usosCfdi` (
  `id` int(11) NOT NULL,
  `clave` varchar(4) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `persona_fisica` tinyint(1) NOT NULL,
  `persona_moral` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `tipo` int(11) NOT NULL,
  `fechaRegistro` datetime NOT NULL,
  `fechaCorte` date NOT NULL,
  `estatus` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `contadores`
--
ALTER TABLE `contadores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `datosFiscales`
--
ALTER TABLE `datosFiscales`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `datosPagina`
--
ALTER TABLE `datosPagina`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `empresas`
--
ALTER TABLE `empresas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `invitaciones`
--
ALTER TABLE `invitaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `metodosPago`
--
ALTER TABLE `metodosPago`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `regimenes`
--
ALTER TABLE `regimenes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `regimenesFiscales`
--
ALTER TABLE `regimenesFiscales`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sesiones`
--
ALTER TABLE `sesiones`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `idx_ultima_actividad` (`ultima_actividad`);

--
-- Indices de la tabla `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tiposUsuarios`
--
ALTER TABLE `tiposUsuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usosCfdi`
--
ALTER TABLE `usosCfdi`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `contadores`
--
ALTER TABLE `contadores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `datosFiscales`
--
ALTER TABLE `datosFiscales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `datosPagina`
--
ALTER TABLE `datosPagina`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `empresas`
--
ALTER TABLE `empresas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `facturas`
--
ALTER TABLE `facturas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `invitaciones`
--
ALTER TABLE `invitaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `metodosPago`
--
ALTER TABLE `metodosPago`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `regimenes`
--
ALTER TABLE `regimenes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `regimenesFiscales`
--
ALTER TABLE `regimenesFiscales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sesiones`
--
ALTER TABLE `sesiones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ticket`
--
ALTER TABLE `ticket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tiposUsuarios`
--
ALTER TABLE `tiposUsuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usosCfdi`
--
ALTER TABLE `usosCfdi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
