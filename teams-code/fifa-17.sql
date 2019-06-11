-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 11 jun 2019 om 11:07
-- Serverversie: 10.1.37-MariaDB
-- PHP-versie: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fifa-17`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `fields`
--

CREATE TABLE `fields` (
  `id` tinyint(6) NOT NULL,
  `fieldNumber` tinyint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `fields`
--

INSERT INTO `fields` (`id`, `fieldNumber`) VALUES
(36, 1),
(37, 2),
(40, 3),
(41, 4),
(42, 5);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `referee`
--

CREATE TABLE `referee` (
  `id` tinyint(6) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `referee`
--

INSERT INTO `referee` (`id`, `name`) VALUES
(8, 'Raf Schapendonk'),
(9, 'Eyob van Arem'),
(10, 'Xander van Veen');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `schedule`
--

CREATE TABLE `schedule` (
  `id` tinyint(6) NOT NULL,
  `team1` tinyint(6) NOT NULL,
  `team2` tinyint(6) NOT NULL,
  `matchtime` tinyint(2) NOT NULL,
  `breaktime` tinyint(2) NOT NULL,
  `resttime` tinyint(2) NOT NULL,
  `field` tinyint(6) NOT NULL,
  `referee` varchar(255) NOT NULL,
  `team1score` tinyint(6) NOT NULL,
  `team2score` tinyint(6) NOT NULL,
  `hasBeenEdited` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `schedule`
--

INSERT INTO `schedule` (`id`, `team1`, `team2`, `matchtime`, `breaktime`, `resttime`, `field`, `referee`, `team1score`, `team2score`, `hasBeenEdited`) VALUES
(1, 35, 36, 90, 15, 0, 1, '8', 0, 0, 0),
(2, 35, 37, 90, 15, 0, 2, '9', 0, 0, 0),
(3, 35, 38, 90, 15, 0, 3, '10', 0, 0, 0),
(4, 35, 39, 90, 15, 0, 4, '8', 0, 0, 0),
(5, 35, 40, 90, 15, 0, 5, '9', 0, 0, 0),
(6, 36, 37, 90, 15, 0, 1, '10', 0, 0, 0),
(7, 36, 38, 90, 15, 0, 2, '8', 0, 0, 0),
(8, 36, 39, 90, 15, 0, 3, '9', 0, 0, 0),
(9, 36, 40, 90, 15, 0, 4, '10', 0, 0, 0),
(10, 37, 38, 90, 15, 0, 5, '8', 0, 0, 0),
(11, 37, 39, 90, 15, 0, 1, '9', 0, 0, 0),
(12, 37, 40, 90, 15, 0, 2, '10', 0, 0, 0),
(13, 38, 39, 90, 15, 0, 3, '8', 0, 0, 0),
(14, 38, 40, 90, 15, 0, 4, '9', 0, 0, 0),
(15, 39, 40, 90, 15, 0, 5, '10', 0, 0, 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `teams`
--

CREATE TABLE `teams` (
  `id` tinyint(6) NOT NULL,
  `name` varchar(64) NOT NULL,
  `players` varchar(2048) NOT NULL,
  `creator` tinyint(6) NOT NULL,
  `points` tinyint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `teams`
--

INSERT INTO `teams` (`id`, `name`, `players`, `creator`, `points`) VALUES
(35, 'Dragons', '24,32,31,30,36,37,38,39', 24, 0),
(36, 'Serpents', '25,28,40', 25, 0),
(37, 'Vikings', '26,29,43', 26, 0),
(38, 'Ravens', '27,33,34,35', 27, 0),
(39, 'Testerser', '44,47', 44, 0),
(40, 'Testing1', '48,41,42,45,49', 48, 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE `users` (
  `id` int(6) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(64) NOT NULL,
  `username` varchar(64) NOT NULL,
  `teamid` int(6) NOT NULL,
  `admin` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `username`, `teamid`, `admin`) VALUES
(1, 'admin@admin.com', '$2y$10$QuPBnDKlcXp1HTbHqAOEme/PJinH.M0ZUvre/NtUFi/q4HJC71VTW', 'admin', 0, 1),
(24, 'xander.media.klas@gmail.com', '$2y$10$wtPeep5COzfijXbPNs/Pt.GrJIWDtWqfpzHVtXLzTO6wc3A4CVLS6', 'Xander', 35, 0),
(25, 'rik@gmail.com', '$2y$10$7SRTk1aC564UmlHY/3lAcO.19QW/WtmSm65Wdpho5GZ5HOT0cJQP6', 'Rik', 36, 0),
(26, 'kayle@gmail.com', '$2y$10$gYctlXAajUXWpAXAJ8cOK.whFZvQ.RPS5SXZuEDOTdFUfiiRLUrfO', 'Kayle', 37, 0),
(27, 'khaled@gmail.com', '$2y$10$HYSoOyQsUbp2uzpbFFyy..dXPHBdGU3pG29wUeTAplRR1Dof4EXdO', 'Khaled', 38, 0),
(28, 'Esma@gmail.com', '$2y$10$0IzmN42yNe1BaQnvivh6LevAilri8P3ubrtPmVtLpARLzz2Ho9cGC', 'Esma', 36, 0),
(29, 'teun@gmail.com', '$2y$10$LIfesgk0zGzy4CN7esPXDuh82a/SSd9xTYrbk4Fw9YqUY1tTakEHq', 'Teun', 37, 0),
(30, 'test@gmail.com', '$2y$10$3FG3iFPs596fX.rOUndyb.zGV44fpE8q6IyRQCWATk1L1fkWutpKS', 'Test', 35, 0),
(31, 'qwerty@qwerty.com', '$2y$10$gldyuL/4tnIv.iKbKbTUsekRLlwGrL7djZe6sHhKZVmETmYuA5CAG', 'qwerty', 35, 0),
(32, 'testing@gmail.com', '$2y$10$1mFPNfAcxsaIDFmAG4eKy.i36jB0lMmO873KUJoxEdur3OVol9bMa', 'Testing', 35, 0),
(33, 'bartje@gmail.com', '$2y$10$A6SFib3aVJFgDF1UHGxBYexJUIoePbyXBk27q9tkXlg0Bf1t28QFW', 'Bartje', 38, 0),
(34, 'anderegebruiker@gmail.com', '$2y$10$/K/mwHdMi/JJeAIOckVVaOXV2mcRFQmRfqnBsJIHaKuImc3XubNPS', 'Janee', 38, 0),
(35, 'nogiemand@gmail.com', '$2y$10$NnzDxiYAqsL.lNlXBk9zjuPI0JC89V5SHRA64IsKD79CpiHUKN2Yy', 'Tantoe', 38, 0),
(36, 'test1@gmail.com', '$2y$10$K11uCelNazc4wYouimGHCOeurNrFak5N69WPel30ca4gzDW6bUJOm', 'test1', 35, 0),
(37, 'gaming@gmail.com', '$2y$10$hmRrxvCBzAQczDCdClhBW.pE6B77o7dK47KOx5CgvXtMyk0RNNHne', 'Gaming', 35, 0),
(38, 'gaming1@gmail.com', '$2y$10$m24SDdwmgheNG8.R8Xauo.Y1RVpUW4rT5g0zR39fADGiuE4ppc0hW', 'Gaming1', 35, 0),
(39, 'test2@gmail.com', '$2y$10$glkSdvm0qmey.2E0obGbLeRxvwjkXleZkpKsJ5jCudlM7NKG/jDqC', 'Test2', 35, 0),
(40, 'test4@gmail.com', '$2y$10$WCmjtFyi7T3qdyW12yPlFu7MUJFcgFf9dFtAFVJjstLju5nKluh16', 'Test4', 36, 0),
(41, 'test5@gmail.com', '$2y$10$z1eCKiWZ1QXz0SH27D2y3eHo7mNRijT8Zb2ZHwqesj7M7CpupmzmS', 'Test5', 40, 0),
(42, 'test6@gmail.com', '$2y$10$dgMFzAIHPeqiIaIYQKfHz.QrTDXM9s0J94xl0eOvnz6MuunFzLm0i', 'Test6', 40, 0),
(43, 'Test7@gmail.com', '$2y$10$Z1Axfo.sJZOmSL04Xj57UO4nsYzcCRFUVAkQk4uq6WHn/o1Wqx7ay', 'Test7', 37, 0),
(44, 'fds@fds.com', '$2y$10$7BSf/teX.IIC04xCsqRg.ufd4S3qYfkYF/tghJXga2SpHNGPO4g/C', 'fds', 39, 0),
(45, 'gmail@gmail.com', '$2y$10$MxEiffETL5tkAd.6XXIzCe9OkG6sliNhNEF5qo0hiMBRrNztDIQEu', 'Gmail', 40, 0),
(46, 'rikkert@gmail.com', '$2y$10$U3xx76zJp/qcoZGiw.hnue3eEUmWjlTSyvU.aoe0GtCiJUx6e.jMi', 'Rikkert', 0, 0),
(47, 'testvankyan@gmail.com', '$2y$10$7mhV4Q9ammptzLqsicS4sOXqlFDImFHOHQbT14bxYvwgzmgZtJfO6', 'kyan', 39, 0),
(48, 'testing1@gmail.com', '$2y$10$gu6tkbswywYLtRfQmhHpEeL2hFEn/ZHambyl8E85WXWNaGVjc9EmO', 'testing1', 40, 0),
(49, 'testing2@gmail.com', '$2y$10$Zu.dGWeHWYFTgLLbTx0IYekCLkL.ohxPugyFLWtlzM3zYV.feATFy', 'testing2', 40, 0),
(50, 'testing3@gmail.com', '$2y$10$I/Cj49OptmWxF7WkOgRxnejQd9KjJPuMTjdqGkE0nUD0.d5DOniU2', 'testing3', 0, 0);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `fields`
--
ALTER TABLE `fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `referee`
--
ALTER TABLE `referee`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `fields`
--
ALTER TABLE `fields`
  MODIFY `id` tinyint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT voor een tabel `referee`
--
ALTER TABLE `referee`
  MODIFY `id` tinyint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT voor een tabel `schedule`
--
ALTER TABLE `schedule`
  MODIFY `id` tinyint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT voor een tabel `teams`
--
ALTER TABLE `teams`
  MODIFY `id` tinyint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
