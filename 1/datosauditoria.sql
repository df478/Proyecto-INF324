-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-12-2024 a las 21:55:06
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
-- Base de datos: `datosauditoria`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auditoriainterna`
--

CREATE TABLE `auditoriainterna` (
  `id` int(11) NOT NULL,
  `nrotramite` int(11) NOT NULL,
  `EstablecerObjetivosDesempeno` varchar(255) DEFAULT NULL,
  `DefinirObjetivosAuditoria` varchar(255) DEFAULT NULL,
  `SeAceptanRecomendaciones` tinyint(1) DEFAULT NULL,
  `SeguimientoRecomendaciones` varchar(255) DEFAULT NULL,
  `CierreAuditoria` tinyint(1) DEFAULT NULL,
  `ResolucionObservacionesRecomendaciones` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `auditoriainterna`
--

INSERT INTO `auditoriainterna` (`id`, `nrotramite`, `EstablecerObjetivosDesempeno`, `DefinirObjetivosAuditoria`, `SeAceptanRecomendaciones`, `SeguimientoRecomendaciones`, `CierreAuditoria`, `ResolucionObservacionesRecomendaciones`) VALUES
(1, 1001, 'Definición de objetivos estratégicos y de desempeño para la auditoría interna', 'Establecimiento de indicadores clave de desempeño (KPI) para evaluar la efectividad de la auditoría', 1, NULL, 1, 'Observaciones resueltas y recomendaciones implementadas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `controlinterno`
--

CREATE TABLE `controlinterno` (
  `id` int(11) NOT NULL,
  `nrotramite` int(11) NOT NULL,
  `EvaluacionControlInterno` varchar(255) DEFAULT NULL,
  `HayDebilidadesControlInterno` tinyint(1) DEFAULT NULL,
  `RegistrarRecomendaciones` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `controlinterno`
--

INSERT INTO `controlinterno` (`id`, `nrotramite`, `EvaluacionControlInterno`, `HayDebilidadesControlInterno`, `RegistrarRecomendaciones`) VALUES
(1, 1001, 'Evaluación del Control Interno', 0, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cumplimiento`
--

CREATE TABLE `cumplimiento` (
  `id` int(11) NOT NULL,
  `nrotramite` int(11) NOT NULL,
  `CumplimientoDeNormas` varchar(255) DEFAULT NULL,
  `CumpleConNormasYRegulaciones` tinyint(1) DEFAULT NULL,
  `AccionesCorrectivas` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cumplimiento`
--

INSERT INTO `cumplimiento` (`id`, `nrotramite`, `CumplimientoDeNormas`, `CumpleConNormasYRegulaciones`, `AccionesCorrectivas`) VALUES
(1, 1001, 'Revisión y actualización de las políticas internas y entrenamiento en ética corporativa', 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gestionriesgos`
--

CREATE TABLE `gestionriesgos` (
  `id` int(11) NOT NULL,
  `nrotramite` int(11) NOT NULL,
  `GestionDeRiesgos` varchar(255) DEFAULT NULL,
  `ExistenRiesgosSignificativos` tinyint(1) DEFAULT NULL,
  `AccionesMitigacionRiesgos` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `gestionriesgos`
--

INSERT INTO `gestionriesgos` (`id`, `nrotramite`, `GestionDeRiesgos`, `ExistenRiesgosSignificativos`, `AccionesMitigacionRiesgos`) VALUES
(1, 1001, 'Identificación y análisis de riesgos en el proceso de auditoría', 0, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `operaciones`
--

CREATE TABLE `operaciones` (
  `id` int(11) NOT NULL,
  `nrotramite` int(11) NOT NULL,
  `EficienciaOperativa` varchar(255) DEFAULT NULL,
  `EsEficienteLaOperacion` tinyint(1) DEFAULT NULL,
  `PropuestasDeMejoraOperativa` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `operaciones`
--

INSERT INTO `operaciones` (`id`, `nrotramite`, `EficienciaOperativa`, `EsEficienteLaOperacion`, `PropuestasDeMejoraOperativa`) VALUES
(1, 1001, 'Rediseño de procesos para optimizar tiempos de respuesta y reducir costos operativos', 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `planeacionestrategica`
--

CREATE TABLE `planeacionestrategica` (
  `id` int(11) NOT NULL,
  `nrotramite` int(11) NOT NULL,
  `MedicionDelDesempeno` varchar(255) DEFAULT NULL,
  `SeCumplenLosObjetivosDelDesempeno` tinyint(1) DEFAULT NULL,
  `RecomendacionesParaMejorarDesempeno` varchar(255) DEFAULT NULL,
  `ElaboracionDeInformes` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `planeacionestrategica`
--

INSERT INTO `planeacionestrategica` (`id`, `nrotramite`, `MedicionDelDesempeno`, `SeCumplenLosObjetivosDelDesempeno`, `RecomendacionesParaMejorarDesempeno`, `ElaboracionDeInformes`) VALUES
(1, 1001, 'Evaluación del desempeño organizacional basado en KPIs y objetivos estratégicos', 1, NULL, 'Elaboración de informe final con análisis de desempeño y recomendaciones de mejora');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `auditoriainterna`
--
ALTER TABLE `auditoriainterna`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nrotramite` (`nrotramite`);

--
-- Indices de la tabla `controlinterno`
--
ALTER TABLE `controlinterno`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nrotramite` (`nrotramite`);

--
-- Indices de la tabla `cumplimiento`
--
ALTER TABLE `cumplimiento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nrotramite` (`nrotramite`);

--
-- Indices de la tabla `gestionriesgos`
--
ALTER TABLE `gestionriesgos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nrotramite` (`nrotramite`);

--
-- Indices de la tabla `operaciones`
--
ALTER TABLE `operaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nrotramite` (`nrotramite`);

--
-- Indices de la tabla `planeacionestrategica`
--
ALTER TABLE `planeacionestrategica`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nrotramite` (`nrotramite`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `auditoriainterna`
--
ALTER TABLE `auditoriainterna`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `controlinterno`
--
ALTER TABLE `controlinterno`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `cumplimiento`
--
ALTER TABLE `cumplimiento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `gestionriesgos`
--
ALTER TABLE `gestionriesgos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `operaciones`
--
ALTER TABLE `operaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `planeacionestrategica`
--
ALTER TABLE `planeacionestrategica`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
