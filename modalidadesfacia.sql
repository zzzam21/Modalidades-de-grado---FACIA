-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-08-2026 a las 21:38:44
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
-- Base de datos: `modalidadesfacia`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modalities`
--

CREATE TABLE `modalities` (
  `modality_ID` int(11) NOT NULL,
  `program_ID` int(11) NOT NULL,
  `id_type_mod` int(11) NOT NULL,
  `name_modalitie` text NOT NULL,
  `status` varchar(50) NOT NULL,
  `goal` text NOT NULL,
  `date_approved` date NOT NULL,
  `date_end` date NOT NULL,
  `date_sustentacion` datetime DEFAULT NULL,
  `duration` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modalitie_student`
--

CREATE TABLE `modalitie_student` (
  `modality_ID` int(11) NOT NULL,
  `student_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modalitie_teacher`
--

CREATE TABLE `modalitie_teacher` (
  `modality_ID` int(11) NOT NULL,
  `teacher_ID` int(11) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `programs`
--

CREATE TABLE `programs` (
  `program_ID` int(11) NOT NULL,
  `program_name` varchar(50) NOT NULL,
  `sede` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `programs`
--

INSERT INTO `programs` (`program_ID`, `program_name`, `sede`) VALUES
(30, 'Ingeniería Ambiental', 'Tumaco'),
(31, 'Ingeniería Agronomica', 'Pasto'),
(89, 'Ingeniería Ambiental', 'Pasto'),
(108, 'Ingeniería Agroforestal', 'Pasto'),
(136, 'Ingeniería Ambiental', 'Tuquerres'),
(170, 'Ingeniería Agronomica', 'Tumaco'),
(171, 'Ingeniería Agronomica', 'Tuquerres'),
(182, 'Ingeniería Agroforestal', 'Tumaco');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `students`
--

CREATE TABLE `students` (
  `student_ID` int(11) NOT NULL,
  `code` int(11) NOT NULL,
  `program_ID` int(11) NOT NULL,
  `name_student` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `teachers`
--

CREATE TABLE `teachers` (
  `teacher_ID` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `teachers`
--

INSERT INTO `teachers` (`teacher_ID`, `name`) VALUES
(139, 'Yenny Narváez'),
(140, 'Pedro Alexander Velásquez'),
(141, 'Andrea Milena Calpa Juaginoy'),
(142, 'Carlos Betancourth'),
(143, 'Claudia Quiroz'),
(144, 'Jairo Mosquera Guerrero'),
(145, 'Wilmer Vicente Ortega Portillo'),
(146, 'David Esteban Duarte Alvarado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `type_modalities`
--

CREATE TABLE `type_modalities` (
  `id_type_mod` int(11) NOT NULL,
  `type_name` varchar(50) NOT NULL,
  `type_modalitie` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `type_modalities`
--

INSERT INTO `type_modalities` (`id_type_mod`, `type_name`, `type_modalitie`) VALUES
(1, 'Trabajo de Investigación', 'Investigación'),
(2, 'Articulo Cientifico', 'Investigación'),
(3, 'Participación en Grupos de Investigación', 'Investigación'),
(4, 'Diplomado', 'Profundización'),
(5, 'Créditos en Cursos de Postgrado', 'Profundización'),
(6, 'Pasantia Empresarial', 'Interacción social'),
(7, 'Proyectos Comunitarios', 'Interacción social'),
(8, 'Estancias Académicas', 'Interacción social');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `passwordu` varchar(100) NOT NULL,
  `rol` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `passwordu`, `rol`) VALUES
(1, 'Samuel Salazar', 'jonas01311@gmail.com', '$2y$10$ANusvz.NWbf4HO5Az.lgFuPkciAqvcSXTkQ8KVLQ5l/DfvblhFk/O', 'Administrador'),
(2, 'Agronomía', 'agronomia@udenar.edu.co', '$2y$10$Tr3kHFN5DgUm5apcdRUrTuvXVRu/F5i6sDrLsqO7NrLyRpzEGaVu.', 'Administrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_program`
--

CREATE TABLE `users_program` (
  `program_ID` int(11) NOT NULL,
  `user_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users_program`
--

INSERT INTO `users_program` (`program_ID`, `user_ID`) VALUES
(108, 2),
(171, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `modalities`
--
ALTER TABLE `modalities`
  ADD PRIMARY KEY (`modality_ID`),
  ADD KEY `program_ID` (`program_ID`),
  ADD KEY `id_type_mod` (`id_type_mod`);

--
-- Indices de la tabla `modalitie_student`
--
ALTER TABLE `modalitie_student`
  ADD PRIMARY KEY (`modality_ID`,`student_ID`),
  ADD KEY `student_ID` (`student_ID`);

--
-- Indices de la tabla `modalitie_teacher`
--
ALTER TABLE `modalitie_teacher`
  ADD PRIMARY KEY (`modality_ID`,`teacher_ID`),
  ADD KEY `teacher_ID` (`teacher_ID`);

--
-- Indices de la tabla `programs`
--
ALTER TABLE `programs`
  ADD PRIMARY KEY (`program_ID`);

--
-- Indices de la tabla `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_ID`),
  ADD KEY `program_ID` (`program_ID`);

--
-- Indices de la tabla `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`teacher_ID`);

--
-- Indices de la tabla `type_modalities`
--
ALTER TABLE `type_modalities`
  ADD PRIMARY KEY (`id_type_mod`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users_program`
--
ALTER TABLE `users_program`
  ADD PRIMARY KEY (`program_ID`,`user_ID`),
  ADD KEY `user_ID` (`user_ID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `modalities`
--
ALTER TABLE `modalities`
  MODIFY `modality_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT de la tabla `teachers`
--
ALTER TABLE `teachers`
  MODIFY `teacher_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=147;

--
-- AUTO_INCREMENT de la tabla `type_modalities`
--
ALTER TABLE `type_modalities`
  MODIFY `id_type_mod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `modalities`
--
ALTER TABLE `modalities`
  ADD CONSTRAINT `modalities_ibfk_1` FOREIGN KEY (`program_ID`) REFERENCES `programs` (`program_ID`),
  ADD CONSTRAINT `modalities_ibfk_2` FOREIGN KEY (`id_type_mod`) REFERENCES `type_modalities` (`id_type_mod`);

--
-- Filtros para la tabla `modalitie_student`
--
ALTER TABLE `modalitie_student`
  ADD CONSTRAINT `modalitie_student_ibfk_1` FOREIGN KEY (`modality_ID`) REFERENCES `modalities` (`modality_ID`),
  ADD CONSTRAINT `modalitie_student_ibfk_2` FOREIGN KEY (`student_ID`) REFERENCES `students` (`student_ID`);

--
-- Filtros para la tabla `modalitie_teacher`
--
ALTER TABLE `modalitie_teacher`
  ADD CONSTRAINT `modalitie_teacher_ibfk_1` FOREIGN KEY (`modality_ID`) REFERENCES `modalities` (`modality_ID`),
  ADD CONSTRAINT `modalitie_teacher_ibfk_2` FOREIGN KEY (`teacher_ID`) REFERENCES `teachers` (`teacher_ID`);

--
-- Filtros para la tabla `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`program_ID`) REFERENCES `programs` (`program_ID`);

--
-- Filtros para la tabla `users_program`
--
ALTER TABLE `users_program`
  ADD CONSTRAINT `users_program_ibfk_1` FOREIGN KEY (`user_ID`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `users_program_ibfk_2` FOREIGN KEY (`program_ID`) REFERENCES `programs` (`program_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
