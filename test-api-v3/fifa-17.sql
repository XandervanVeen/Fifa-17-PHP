-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 13 mei 2019 om 12:19
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
(1, 'Dragons', 'Dirk,Jan,Michiel', 1),
(2, 'Serpents', 'Rik,Reno,Kyan', 2),
(3, 'Ravens', 'test,test,test', 3),
(4, 'Ja', 'test,test,test', 4),
(5, '261471', 'test,test,test', 5),
(6, 'test4', 'test,test,test', 9),
(7, 'Test5', 'test,test,test', 10),
(8, 'Test6', 'test,test,test', 11),
(9, 'Peters', 'Peter1,Peter2,Peter3', 12),
(11, 'Rikkerts', 'Rik1,Rik2,Rik4', 13),
(14, 'Teamja', 'ja,ja,ja', 2);

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
(2, 'xander.media.klas@gmail.com', '$2y$10$.qxIcHj2ldaCY7TRX0p89OwFDhOguSn76Cw.bvfidmyHhw83WjLra', 'Xander', 0, 0),
(3, 'test@gmail.com', '$2y$10$Ubv5sbBaUmXUhJbRYZCAIeTy1wrBDaJnOdRSRkw1U8tdbU.N5g9h2', 'test', 0, 0),
(4, 'ja@gmail.com', '$2y$10$RRLzqNfFHkrlJlmAL787C.fjamEEM/YZBjIOBWnKl921xtwR9H4C6', 'Ja', 0, 0),
(5, 'D261471@edu.rocwb.nl', '$2y$10$vfBs4SgjEIvCr15/kmS/o.eAF5t2l0Sheyt6rIy7fC4Rjhhcu2rcu', 'Xander van Veen', 0, 0),
(6, 'test1@gmail.com', '$2y$10$0nOSMeO/zMZi/KQlWsAt7.t1HbB3nMeCKwOPkOdaqlZLsOxlU6Gfe', 'test1', 0, 0),
(7, 'test2@gmail.com', '$2y$10$iXlPI.rDUeMiMPsXrpmZbuDi.3.ZTCLvhe1qtBxUlUx9fIY9K3fLW', 'Test2', 0, 0),
(8, 'test3@gmail.com', '$2y$10$re39lj3zre5GInrCQtImVOxECm5rhL1Hl7Y2dCbeiPTGtfgLWLSZy', 'Test3', 0, 0),
(9, 'test4@gmail.com', '$2y$10$JjYuRwcmHl8YErehevbxpOWUn0Egxp/IkH2kTGXAe97HQsCG7Ek3K', 'Test4', 0, 0),
(10, 'test5@gmail.com', '$2y$10$pELLM0ZbVG7Q1woetSKSzua0MbDnIDInhZrIO0eQd8HGV2znc3HRi', 'Test5', 0, 0),
(11, 'test6@gmail.com', '$2y$10$RZsbxa94UyJpCWOoachJCO/b9CUccNdo64JLGbu8fN9eI3WClezda', 'Test6', 0, 0),
(12, 'pieter@gmail.com', '$2y$10$q8nDvR3TaN7ai4iHsfjq3eOZ2TU7E/38S7lyI5RH9AxofKd.wJf92', 'Pieter', 0, 0),
(13, 'rik@gmail.com', '$2y$10$B5hzBswyPjKv9uKWzCA4CO36Ndx7lU7Lx/8QnFoJcDYr/Eugc.p0C', 'R&iacute;k', 0, 0),
(14, 'fifa@gmail.com', '$2y$10$hfc2cutNG.MsugWZllOBC.rKUQKMko2mebmQfNY20mdeo5TIbq25C', 'Fifa17', 0, 0);

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
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
