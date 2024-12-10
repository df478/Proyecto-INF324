-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-12-2024 a las 01:45:03
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
-- Base de datos: `auditoriainterna`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `flujoauditoria`
--

CREATE TABLE `flujoauditoria` (
  `Flujo` int(11) DEFAULT NULL,
  `Proceso` varchar(255) DEFAULT NULL,
  `Siguiente` varchar(255) DEFAULT NULL,
  `Tipo` varchar(50) DEFAULT NULL,
  `Rol` varchar(255) DEFAULT NULL,
  `Pantalla` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `flujoauditoria`
--

INSERT INTO `flujoauditoria` (`Flujo`, `Proceso`, `Siguiente`, `Tipo`, `Rol`, `Pantalla`) VALUES
(1, 'Establecer Objetivos del Desempeño', 'Definir Objetivos de Auditoría(KPI)', 'Proceso', 'Auditoría Interna', 'Objetivo'),
(1, 'Definir Objetivos de Auditoría(KPI)', 'Evaluación del Control Interno', 'Proceso', 'Auditoría Interna', 'KPI'),
(1, 'Evaluación del Control Interno', '¿Hay Debilidades en el Control Interno?', 'Proceso', 'Control Interno', 'Control'),
(1, '¿Hay Debilidades en el Control Interno?', 'Registrar Recomendaciones (Sí) / Gestión de Riesgos (No)', 'Condicional', 'Control Interno', 'ControlDecision'),
(1, 'Registrar Recomendaciones', '¿Hay Debilidades en el Control Interno?', 'Proceso', 'Control Interno', 'ControlAccion'),
(1, 'Gestión de Riesgos', '¿Existen Riesgos Significativos?', 'Proceso', 'Gestión de Riesgos', 'Riesgo'),
(1, '¿Existen Riesgos Significativos?', 'Acciones de Mitigación (Sí) / Cumplimiento de Normas (No)', 'Condicional', 'Gestión de Riesgos', 'RiesgoDecision'),
(1, 'Acciones de Mitigación de Riesgos', '¿Existen Riesgos Significativos?', 'Proceso', 'Gestión de Riesgos', 'RiesgoAccion'),
(1, 'Cumplimiento de Normas', '¿Cumple con Normas y Regulaciones?', 'Proceso', 'Cumplimiento', 'Norma'),
(1, '¿Cumple con Normas y Regulaciones?', 'Acciones Correctivas (No) / Eficiencia Operativa (Sí)', 'Condicional', 'Cumplimiento', 'NormaDesicion'),
(1, 'Acciones Correctivas', '¿Cumple con Normas y Regulaciones?', 'Proceso', 'Cumplimiento', 'NormaAccion'),
(1, 'Eficiencia Operativa', '¿Es Eficiente la Operación?', 'Proceso', 'Operaciones', 'Eficiencia'),
(1, '¿Es Eficiente la Operación?', 'Propuestas de Mejora (No) / Medición de Desempeño (Sí)', 'Condicional', 'Operaciones', 'EficienciaDecision'),
(1, 'Propuestas de Mejora Operativa', '¿Es Eficiente la Operación?', 'Proceso', 'Operaciones', 'EficienciaAccion'),
(1, 'Medición del Desempeño', '¿Se Cumplen los Objetivos del Desempeño?', 'Proceso', 'Planeación Estratégica', 'Desempeño'),
(1, '¿Se Cumplen los Objetivos del Desempeño?', 'Recomendaciones de Mejora (No) / Elaboración de Informes (Sí)', 'Condicional', 'Planeación Estratégica', 'DesempeñoDesicion'),
(1, 'Recomendaciones para Mejorar Desempeño', '¿Se Cumplen los Objetivos del Desempeño?', 'Proceso', 'Planeación Estratégica', 'DesempeñoAccion'),
(1, 'Elaboración de Informes', 'Fin', 'Proceso', 'Planeación Estratégica', 'Informe'),
(2, 'Seguimiento de Recomendaciones', 'Resolución de observaciones y recomendaciones', 'Proceso', 'Auditoría Interna', 'InformeAccion'),
(2, 'Resolución de observaciones y recomendaciones', 'Cierre de Auditoría', 'Proceso', 'Auditoría Interna', 'Observaciones'),
(2, 'Cierre de Auditoría', 'Fin', 'Proceso', 'Auditoría Interna', 'Cierre');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seguimiento`
--

CREATE TABLE `seguimiento` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,  -- Nueva columna ID
  `nrotramite` INT(11) NOT NULL,
  `flujo` INT(11) DEFAULT NULL,
  `proceso` VARCHAR(255) DEFAULT NULL,
  `usuario` VARCHAR(255) DEFAULT NULL,
  `fecha_inicio` DATE DEFAULT NULL,
  `fecha_fin` DATE DEFAULT NULL,
  PRIMARY KEY (`id`)  -- Establecer la columna 'id' como clave primaria
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcado de datos para la tabla `seguimiento`
INSERT INTO `seguimiento` (`nrotramite`, `flujo`, `proceso`, `usuario`, `fecha_inicio`, `fecha_fin`) VALUES
(1001, 1, 'Establecer Objetivos del Desempeño', 'jmartinez', '2024-01-04', '2024-01-05'),
(1001, 1, 'Definir Objetivos de Auditoría(KPI)', 'drobles', '2024-01-05', '2024-03-03'),
(1001, 1, 'Evaluación del Control Interno', 'aperez', '2024-03-03', '2024-03-12'),
(1001, 1, '¿Hay Debilidades en el Control Interno?', 'aperez', '2024-03-12', '2024-03-24'),
(1001, 1, 'Registrar Recomendaciones', 'aperez', '2024-03-24', '2024-04-07'),
(1001, 1, '¿Hay Debilidades en el Control Interno?', 'aperez', '2024-04-07', '2024-04-12'),
(1001, 1, 'Gestión de Riesgos', 'mgracia', '2024-04-12', '2024-05-10'),
(1001, 1, '¿Existen Riesgos Significativos?', 'mgracia', '2024-05-10', '2024-05-17'),
(1001, 1, 'Acciones de Mitigación de Riesgos', 'mlopez', '2024-05-17', '2024-06-19'),
(1001, 1, '¿Existen Riesgos Significativos?', 'mgracia', '2024-06-19', '2024-06-23'),
(1001, 1, 'Cumplimiento de Normas', 'gfernandez', '2024-06-23', '2024-06-30'),
(1001, 1, '¿Cumple con Normas y Regulaciones?', 'gfernandez', '2024-06-30', '2024-07-04'),
(1001, 1, 'Acciones Correctivas', 'kquintero', '2024-07-04', '2024-08-08'),
(1001, 1, '¿Cumple con Normas y Regulaciones?', 'gfernandez', '2024-08-08', '2024-09-13'),
(1001, 1, 'Acciones Correctivas', 'kquintero', '2024-09-13', '2024-09-29'),
(1001, 1, 'Eficiencia Operativa', 'csalinas', '2024-09-29', '2024-10-06'),
(1001, 1, '¿Es Eficiente la Operación?', 'csalinas', '2024-10-06', '2024-10-18'),
(1001, 1, 'Propuestas de Mejora Operativa', 'csalinas', '2024-10-18', '2024-11-02'),
(1001, 1, 'Medición del Desempeño', 'lrodriguez', '2024-11-02', '2024-11-03'),
(1001, 1, '¿Se Cumplen los Objetivos del Desempeño?', 'lrodriguez', '2024-11-03', '2024-11-09'),
(1001, 1, 'Elaboración de Informes', 'vsoto', '2024-11-09', '2024-11-10'),
(1002, 2, 'Seguimiento de Recomendaciones', 'jmartinez', '2024-11-11', '2024-11-12'),
(1002, 2, 'Resolución de observaciones y recomendaciones', 'jmartinez', '2024-11-12', '2024-11-20'),
(1002, 2, 'Cierre de Auditoría', 'jmartinez', '2024-11-20', '2024-11-30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `usuario` varchar(255) DEFAULT NULL,
  `clave` varchar(255) DEFAULT NULL,
  `rol` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `usuario`, `clave`, `rol`) VALUES
(1, 'jmartinez', 'jm2023#@', 'Auditoría Interna'),
(2, 'lrodriguez', 'lr1234!', 'Planeación Estratégica'),
(3, 'aperez', 'apz456$', 'Control Interno'),
(4, 'mgracia', 'mg789*', 'Gestión de Riesgos'),
(5, 'gfernandez', 'gf1010&', 'Cumplimiento'),
(6, 'csalinas', 'cs2024~', 'Operaciones'),
(7, 'drobles', 'dr5678+', 'Auditoría Interna'),
(8, 'mlopez', 'ml333@#', 'Gestión de Riesgos'),
(9, 'kquintero', 'kq91234!', 'Cumplimiento'),
(10, 'vsoto', 'vsotp@1', 'Planeación Estratégica');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
