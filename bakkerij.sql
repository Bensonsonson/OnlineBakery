-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Machine: 127.0.0.1
-- Genereertijd: 25 mrt 2015 om 20:31
-- Serverversie: 5.5.34
-- PHP-versie: 5.4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databank: `bakkerij`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `bestellingen`
--

CREATE TABLE IF NOT EXISTS `bestellingen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `datum` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Gegevens worden uitgevoerd voor tabel `bestellingen`
--

INSERT INTO `bestellingen` (`id`, `userid`, `datum`) VALUES
(23, 8, '2015-01-31'),
(24, 10, '2015-01-31'),
(25, 11, '2015-02-03');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `bestelregels`
--

CREATE TABLE IF NOT EXISTS `bestelregels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bestellingid` int(11) NOT NULL,
  `productid` int(11) NOT NULL,
  `aantal` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `bestellingid` (`bestellingid`,`productid`),
  KEY `productid` (`productid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=78 ;

--
-- Gegevens worden uitgevoerd voor tabel `bestelregels`
--

INSERT INTO `bestelregels` (`id`, `bestellingid`, `productid`, `aantal`) VALUES
(68, 23, 1, 1),
(69, 23, 3, 1),
(70, 24, 1, 1),
(71, 24, 3, 2),
(72, 24, 4, 3),
(73, 24, 5, 2),
(74, 25, 3, 1),
(75, 25, 2, 1),
(76, 25, 5, 3),
(77, 25, 6, 3);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `producten`
--

CREATE TABLE IF NOT EXISTS `producten` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `naam` varchar(255) NOT NULL,
  `prijs` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Gegevens worden uitgevoerd voor tabel `producten`
--

INSERT INTO `producten` (`id`, `naam`, `prijs`) VALUES
(1, 'volkorenbrood', 170),
(2, 'wit brood', 150),
(3, 'croissant', 80),
(4, 'boterkoek', 100),
(5, 'frangipane', 120),
(6, 'eclair', 130);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `naam` varchar(255) NOT NULL,
  `voornaam` varchar(255) NOT NULL,
  `straat` varchar(255) NOT NULL,
  `huisnummer` varchar(255) NOT NULL,
  `postcode` int(11) NOT NULL,
  `woonplaats` varchar(255) NOT NULL,
  `emailadres` varchar(255) NOT NULL,
  `paswoord` varchar(255) NOT NULL,
  `blocked` tinyint(1) NOT NULL DEFAULT '0',
  `admin` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Gegevens worden uitgevoerd voor tabel `users`
--

INSERT INTO `users` (`id`, `naam`, `voornaam`, `straat`, `huisnummer`, `postcode`, `woonplaats`, `emailadres`, `paswoord`, `blocked`, `admin`) VALUES
(7, 'Van Beek', 'Ben', 'Wasserijstraat', '2-1', 2200, 'Herentals', 'ben_van_beek@hotmail.com', 'f4c5963ac28c9939d12077caf5637dd3dfe5e677', 0, 1),
(8, 'Von Book', 'Bon', 'Wosserostroot', '2-1', 2200, 'Horontols', 'bon_von_book@hotmail.com', '0c3310ae5f5ac0e5c164912108328111ce443619', 0, 0),
(9, 'sdsqdq', 'qdqzdqz', 'qzdqzdqz', 'qdqzdqz', 2200, 'zdqzdqz', 'ben@hotmail.com', '0277dd8abf3d9d62a846d2bb8585de7eeb3d3053', 0, 0),
(10, 'Verheyen', 'Jeff', 'somersstraat', '7b', 2000, 'Antwerpen', 'jverheyen@gmail.com', 'ea1d30d73906602456f6b01e892d7383cb8cc735', 1, 0),
(11, 'Beffanie', 'Vanboninck', 'Neuklaan', '69a', 6666, 'Fuckville', 's@sexmail.com', 'f2b7239aecbfdf5ee8186ca5ed5ac1a405170542', 0, 0);

--
-- Beperkingen voor gedumpte tabellen
--

--
-- Beperkingen voor tabel `bestellingen`
--
ALTER TABLE `bestellingen`
  ADD CONSTRAINT `bestellingen_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `bestelregels`
--
ALTER TABLE `bestelregels`
  ADD CONSTRAINT `bestelregels_ibfk_1` FOREIGN KEY (`bestellingid`) REFERENCES `bestellingen` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bestelregels_ibfk_2` FOREIGN KEY (`productid`) REFERENCES `producten` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
