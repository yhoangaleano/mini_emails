-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 18-06-2018 a las 15:47:15
-- Versión del servidor: 5.6.35
-- Versión de PHP: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de datos: `mini`
--
CREATE DATABASE IF NOT EXISTS `mini` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `mini`;

DELIMITER $$
--
-- Procedimientos
--
DROP PROCEDURE IF EXISTS `SP_Agregar_Paciente`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_Agregar_Paciente` (IN `p_nombrePaciente` VARCHAR(50), IN `p_apellidoPaciente` VARCHAR(50), IN `p_epsPaciente` VARCHAR(30), IN `p_documentoPaciente` VARCHAR(15))  BEGIN

INSERT INTO `tblPaciente`(
        `idPaciente`,
        `nombrePaciente`,
        `apellidoPaciente`,
        `epsPaciente`,
        `documentoPaciente`,
        `estadoPaciente`
    )
VALUES(
    NULL,
    p_nombrePaciente,
    p_apellidoPaciente,
    p_epsPaciente,
    p_documentoPaciente,
    '1'
);

END$$

DROP PROCEDURE IF EXISTS `SP_CambiarEstado_Paciente`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_CambiarEstado_Paciente` (IN `p_idPaciente` INT(11), IN `p_estadoPaciente` TINYINT(4))  BEGIN

UPDATE  `tblPaciente` SET `estadoPaciente` = p_estadoPaciente
WHERE `idPaciente` = p_idPaciente;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `song`
--

DROP TABLE IF EXISTS `song`;
CREATE TABLE `song` (
  `id` int(11) NOT NULL,
  `artist` text COLLATE utf8_unicode_ci NOT NULL,
  `track` text COLLATE utf8_unicode_ci NOT NULL,
  `link` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `song`
--

INSERT INTO `song` (`id`, `artist`, `track`, `link`) VALUES
(1, 'Rin', 'Ljubav/Beichtstuhl', 'https://www.youtube.com/watch?v=MDHJMirQ5PI'),
(2, 'Jeremih feat. Natasha Mosley', 'F*** U All The Time', 'https://www.youtube.com/watch?v=6-Bq7PCKCJ4'),
(3, 'Nao', 'In the Morning', 'https://www.youtube.com/watch?v=uuocmqLRgOM'),
(4, 'Sofi / Tukker', 'Matadora', 'https://www.youtube.com/watch?v=d6GJeap4Oqo'),
(5, 'Yung Hurn', 'Nein', 'https://www.youtube.com/watch?v=22m5eU6uxeQ'),
(6, 'Rin', 'Error', 'https://www.youtube.com/watch?v=VzajBMa-2P8'),
(7, 'Detachments', 'Circles (Martyn Remix)', 'http://www.youtube.com/watch?v=UzS7Gvn7jJ0'),
(8, 'Survive', 'Hourglass', 'https://www.youtube.com/watch?v=JVOe2oGoHLk'),
(9, 'Big Narstie', 'Hello Hi', 'https://www.youtube.com/watch?v=q10WwZJmPew'),
(10, 'Sleaford Mods', 'Tarantula Deadly Cargo', 'https://www.youtube.com/watch?v=E-gvxxhcS8s'),
(11, 'Mykki Blanco & Woodkid', 'Highschool never ends', 'https://www.youtube.com/watch?v=cNGR4ciDmTA'),
(12, 'Secondcity & Tyler Rowe', 'I Enter', 'https://www.youtube.com/watch?v=vAmDJAxNMi0'),
(13, 'Maxxi Soundsystem', 'Regrets we have no use for (Radio1 Rip)', 'https://soundcloud.com/maxxisoundsystem/maxxi-soundsystem-ft-name-one'),
(14, 'Jamie T', 'Don\'t you find', 'https://www.youtube.com/watch?v=-tmoaFAT108'),
(15, 'Sierra Kid', 'Ein Fan von Dir', 'https://www.youtube.com/watch?v=dfabdmbpQeQ'),
(16, 'SSIO', 'Nullkommaneun', 'https://www.youtube.com/watch?v=Slei8n08Cqk'),
(17, 'Pupkulies & Rebecca', 'ICI', 'https://www.youtube.com/watch?v=60tebPRj_D0'),
(18, 'Color War', 'Shapeshifting', 'https://vimeo.com/111250184'),
(19, 'RÜFÜS', 'Innerbloom', 'https://www.youtube.com/watch?v=IA1liCmUsAM'),
(20, 'RÜFÜS', 'Tonight', 'https://www.youtube.com/watch?v=GCa_TKn9ghI'),
(31, 'Bad Bunny', 'Chambea', 'http://localhost/mini3/songs'),
(32, '<label style=\'color: red\' for=\"textarea\">Text Area</label>', 'Hola', 'http://localhost/mini3/songs'),
(33, '<script>alert(\'Hola\'); </script>', 'yhoan', 'jajaja');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblPaciente`
--

DROP TABLE IF EXISTS `tblPaciente`;
CREATE TABLE `tblPaciente` (
  `idPaciente` int(11) NOT NULL,
  `nombrePaciente` varchar(50) NOT NULL,
  `apellidoPaciente` varchar(50) NOT NULL,
  `epsPaciente` varchar(30) NOT NULL,
  `documentoPaciente` varchar(15) NOT NULL,
  `estadoPaciente` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tblPaciente`
--

INSERT INTO `tblPaciente` (`idPaciente`, `nombrePaciente`, `apellidoPaciente`, `epsPaciente`, `documentoPaciente`, `estadoPaciente`) VALUES
(1, 'Yhoan Andres', 'Galeano Urrea', 'Salud Total', '125267162', 1),
(3, 'dsaf', 'fgdgfd', 'gdfgfd', '787', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `song`
--
ALTER TABLE `song`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `tblPaciente`
--
ALTER TABLE `tblPaciente`
  ADD PRIMARY KEY (`idPaciente`),
  ADD UNIQUE KEY `tblPaciente_documentoPaciente_UNIQUE` (`documentoPaciente`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `song`
--
ALTER TABLE `song`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT de la tabla `tblPaciente`
--
ALTER TABLE `tblPaciente`
  MODIFY `idPaciente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;