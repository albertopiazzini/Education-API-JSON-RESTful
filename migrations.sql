-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: local
-- Creato il: Mag 02, 2023 alle 10:32
-- Versione del server: 8.0.32
-- Versione PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Owly`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `Courses`
--

CREATE TABLE `Courses` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '',
  `places_available` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dump dei dati per la tabella `Courses`
--

INSERT INTO `Courses` (`id`, `name`, `places_available`) VALUES
(44, 'Full Stack Developer', 100),
(45, 'Front-end Developer', 70),
(47, 'Back-end Developer', 80);

-- --------------------------------------------------------

--
-- Struttura della tabella `CourseSubject`
--

CREATE TABLE `CourseSubject` (
  `id_course_subject` int UNSIGNED NOT NULL,
  `id_course` int UNSIGNED NOT NULL,
  `id_subject` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dump dei dati per la tabella `CourseSubject`
--

INSERT INTO `CourseSubject` (`id_course_subject`, `id_course`, `id_subject`) VALUES
(24, 44, 13),
(27, 44, 14),
(28, 44, 15),
(30, 44, 16),
(34, 44, 17),
(36, 44, 18),
(37, 45, 14),
(38, 45, 15),
(39, 45, 16),
(40, 45, 17),
(41, 47, 13),
(42, 47, 18);

-- --------------------------------------------------------

--
-- Struttura della tabella `Subjects`
--

CREATE TABLE `Subjects` (
  `id_subject` int UNSIGNED NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dump dei dati per la tabella `Subjects`
--

INSERT INTO `Subjects` (`id_subject`, `name`) VALUES
(13, 'php '),
(14, 'javascript'),
(15, 'html'),
(16, 'css'),
(17, 'angualr'),
(18, 'my sql');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `Courses`
--
ALTER TABLE `Courses`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `CourseSubject`
--
ALTER TABLE `CourseSubject`
  ADD PRIMARY KEY (`id_course_subject`),
  ADD KEY `id_course` (`id_course`),
  ADD KEY `id_subject` (`id_subject`);

--
-- Indici per le tabelle `Subjects`
--
ALTER TABLE `Subjects`
  ADD PRIMARY KEY (`id_subject`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `Courses`
--
ALTER TABLE `Courses`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT per la tabella `CourseSubject`
--
ALTER TABLE `CourseSubject`
  MODIFY `id_course_subject` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT per la tabella `Subjects`
--
ALTER TABLE `Subjects`
  MODIFY `id_subject` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `CourseSubject`
--
ALTER TABLE `CourseSubject`
  ADD CONSTRAINT `id_course` FOREIGN KEY (`id_course`) REFERENCES `Courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `id_subject` FOREIGN KEY (`id_subject`) REFERENCES `Subjects` (`id_subject`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
