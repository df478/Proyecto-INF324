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
(1, 'Inicio', 'Establecer Objetivos del Desempeño', 'Proceso', 'Auditoría Interna', 'Login'),
(1, 'Establecer Objetivos del Desempeño', 'Definir Objetivos de Auditoría(KPI)', 'Proceso', 'Auditoría Interna', 'Objetivo'),
(1, 'Definir Objetivos de Auditoría(KPI)', 'Evaluación del Control Interno', 'Proceso', 'Control Interno', 'KPI'),
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
(1, 'Elaboración de Informes', '¿Se Aceptan las Recomendaciones?', 'Proceso', 'Planeación Estratégica', 'Informe'),
(1, '¿Se Aceptan las Recomendaciones?', 'Seguimiento de Recomendaciones (No) / Cierre de Auditoría (Sí)', 'Condicional', 'Auditoría Interna', 'InformeDesicion'),
(1, 'Seguimiento de Recomendaciones', '¿Se Aceptan las Recomendaciones?', 'Proceso', 'Auditoría Interna', 'InformeAccion'),
(1, 'Cierre de Auditoría', 'Fin', 'Proceso', 'Auditoría Interna', 'Cierre'),
(1, 'Fin', '-', 'Proceso', 'Auditoría Interna', 'Logout'),
(1, 'Cierre de Auditoría', 'Resolución de observaciones y recomendaciones', 'Proceso', 'Auditoría Interna', 'Observaciones'),
(1, 'Resolución de observaciones y recomendaciones', 'Establecer Objetivos del Desempeño', 'Proceso', 'Auditoría Interna', 'Retroalimentación');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seguimiento`
--

CREATE TABLE `seguimiento` (
  `nrotramite` int(11) NOT NULL,
  `flujo` int(11) DEFAULT NULL,
  `proceso` varchar(255) DEFAULT NULL,
  `usuario` varchar(255) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `seguimiento`
--

INSERT INTO `seguimiento` (`nrotramite`, `flujo`, `proceso`, `usuario`, `fecha_inicio`, `fecha_fin`) VALUES
(1001, 1, 'Establecer Objetivos del Desempeño', 'jmartinez', '2024-01-04', '2024-01-05'),
(1002, 1, 'Definir Objetivos de Auditoría(KPI)', 'drobles', '2024-01-05', '2024-03-03'),
(1003, 1, 'Evaluación del Control Interno', 'aperez', '2024-03-03', '2024-03-12'),
(1004, 1, '¿Hay Debilidades en el Control Interno?', 'aperez', '2024-03-12', '2024-03-24'),
(1005, 1, 'Registrar Recomendaciones', 'aperez', '2024-03-24', '2024-04-07'),
(1006, 1, '¿Hay Debilidades en el Control Interno?', 'aperez', '2024-04-07', '2024-04-12'),
(1007, 1, 'Gestión de Riesgos', 'mgracia', '2024-04-12', '2024-05-10'),
(1008, 1, '¿Existen Riesgos Significativos?', 'mgracia', '2024-05-10', '2024-05-17'),
(1009, 1, 'Acciones de Mitigación de Riesgos', 'mlopez', '2024-05-17', '2024-06-19'),
(1010, 1, '¿Existen Riesgos Significativos?', 'mgracia', '2024-06-19', '2024-06-23'),
(1011, 1, 'Cumplimiento de Normas', 'gfernandez', '2024-06-23', '2024-06-30'),
(1012, 1, '¿Cumple con Normas y Regulaciones?', 'gfernandez', '2024-06-30', '2024-07-04'),
(1013, 1, 'Acciones Correctivas', 'kquintero', '2024-07-04', '2024-08-08'),
(1014, 1, '¿Cumple con Normas y Regulaciones?', 'gfernandez', '2024-08-08', '2024-09-13'),
(1015, 1, 'Acciones Correctivas', 'kquintero', '2024-09-13', '2024-09-29'),
(1016, 1, 'Eficiencia Operativa', 'csalinas', '2024-09-29', '2024-10-06'),
(1017, 1, '¿Es Eficiente la Operación?', 'csalinas', '2024-10-06', '2024-10-18'),
(1018, 1, 'Propuestas de Mejora Operativa', 'csalinas', '2024-10-18', '2024-11-02'),
(1019, 1, 'Medición del Desempeño', 'lrodriguez', '2024-11-02', '2024-11-03'),
(1020, 1, '¿Se Cumplen los Objetivos del Desempeño?', 'lrodriguez', '2024-11-03', '2024-11-09'),
(1021, 1, 'Elaboración de Informes', 'vsoto', '2024-11-09', '2024-11-10'),
(1022, 1, '¿Se Aceptan las Recomendaciones?', 'jmartinez', '2024-11-10', '2024-11-11'),
(1023, 1, 'Cierre de Auditoría', 'jmartinez', '2024-11-11', '2024-11-12'),
(1024, 1, 'Resolución de observaciones y recomendaciones', 'drobles', '2024-11-12', '2024-11-20');

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
-- Indices de la tabla `seguimiento`
--
ALTER TABLE `seguimiento`
  ADD PRIMARY KEY (`nrotramite`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
