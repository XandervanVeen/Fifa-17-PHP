-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 08 mei 2019 om 12:33
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
-- Tabelstructuur voor tabel `teams`
--

CREATE TABLE `teams` (
  `id` tinyint(6) NOT NULL,
  `name` varchar(64) NOT NULL,
  `players` varchar(2048) NOT NULL,
  `creator` tinyint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `teams`
--

INSERT INTO `teams` (`id`, `name`, `players`, `creator`) VALUES
(4, 'Mandems', 'Pieter,Reno,Rik', 2),
(5, 'wat een naam', 'naam1,naam2,naam3', 2),
(6, 'Gamers', 'Dirk,Jan,Michiel', 1),
(9, 'YeeYee', 'Yeet,Yote,Yate', 7),
(12, 'Test', 'test,test,test', 1),
(13, 'Testing', 'Ja,nee,allebij', 8),
(14, 'Knapen', 'knaap1,knaap2,knaap3', 9);

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
(1, 'admin@admin.com', '$2y$10$1zycYz.lpio6na5YmoDDIOa5uSXB2OwPWxio6wrSP0nWPPVRW7JVe', 'admin', 0, 1),
(2, 'xander.media.klas@gmail.com', '$2y$10$YMOGWScoa55AOH6wPqJiIee5VCWv3YmsuznDrHL6fXsR7jTzEEJWa', 'Xander van Veen', 0, 0),
(3, 'test@gmail.com', '$2y$10$BIIlHvh7I9KsMdBL.5goIeFfF/t/8ydKOVmhO2WXRdMM/c6BqbwFK', 'Testuser', 0, 0),
(4, 'D261471@edu.rocwb.nl', '$2y$10$n5.k2BQ2839oxIIFimG/g.S46DEGuAkExMUKxt/GbS7v2nc.P7rzW', 'D261471', 0, 0),
(5, 'khalid@gmail.com', '$2y$10$ISa9YG9/mEIuSoc.e3fHwepSSRwro9d9qUhXru1X8sug4RWghWjIq', 'Khalid', 0, 0),
(6, 'reno@reno.nl', '$2y$10$CkUResPudmSZlLjD8mofwuiaod1ADGlxfvC5Lz9UEPjGjh.X0D.26', 'Reno', 0, 0),
(7, 'sova@live.nl', '$2y$10$XX.V3fgxBUDhBBFk3ERRQ.OXaApGjvgqCmjiFNynoLurb.huRhbYu', 'soof', 0, 0),
(8, 'testing@gmail.com', '$2y$10$lkVHlJmKOOxAph6hAsHUbeoKXMM7T1Rstp.x69h35rub.vCNHt9fO', 'Testing', 0, 0),
(9, 'reno@gmail.com', '$2y$10$bd6B8r.HQw6zrYZg8w3VBuGv9ysh80JRe3qifEN3o./ikCB3sx47C', 'Reno', 0, 0);

--
-- Indexen voor geëxporteerde tabellen
--

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
-- AUTO_INCREMENT voor een tabel `teams`
--
ALTER TABLE `teams`
  MODIFY `id` tinyint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
