-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Gegenereerd op: 19 feb 2025 om 12:05
-- Serverversie: 9.0.1
-- PHP-versie: 8.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jamin_a`
--

DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `spGetAllLeveranciers`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spGetAllLeveranciers` ()   BEGIN
    SELECT 
        l.Id,
        l.Naam,
        l.Contactpersoon,
        l.Leveranciernummer,
        l.Mobiel,
        COUNT(DISTINCT ppa.ProductId) AS AantalProducten
    FROM 
        Leverancier l
    LEFT JOIN 
        ProductPerLeverancier ppa ON l.Id = ppa.LeverancierId
    GROUP BY 
        l.Id, l.Naam, l.Contactpersoon, l.Leveranciernummer, l.Mobiel
    ORDER BY 
        AantalProducten DESC;
END$$

DROP PROCEDURE IF EXISTS `spGetGeleverdeProducten`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spGetGeleverdeProducten` (IN `leverancierId` INT)   BEGIN
    SELECT 
        p.Id,
        p.Naam,
        p.Barcode,
        m.VerpakkingsEenheid,
        m.AantalAanwezig,
        MAX(pl.DatumLevering) AS DatumLaatsteLevering
    FROM 
        Product p
    JOIN 
        ProductPerLeverancier pl ON p.Id = pl.ProductId
    JOIN 
        Magazijn m ON p.Id = m.ProductId
    WHERE 
        pl.LeverancierId = leverancierId
    GROUP BY 
        p.Id, p.Naam, p.Barcode, m.VerpakkingsEenheid, m.AantalAanwezig
    ORDER BY 
        m.AantalAanwezig DESC;
END$$

DROP PROCEDURE IF EXISTS `spReadMagazijnProduct`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spReadMagazijnProduct` ()   BEGIN
    SELECT 
        p.Barcode,
        p.Naam,
        m.VerpakkingsEenheid,
        m.AantalAanwezig,
        p.Id AS ProductId
    FROM 
        Magazijn m
    JOIN 
        Product p ON m.ProductId = p.Id
    ORDER BY p.Barcode ASC;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `allergeen`
--

DROP TABLE IF EXISTS `allergeen`;
CREATE TABLE IF NOT EXISTS `allergeen` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `Naam` varchar(50) NOT NULL,
  `Omschrijving` varchar(255) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `allergeen`
--

INSERT INTO `allergeen` (`Id`, `Naam`, `Omschrijving`) VALUES
(1, 'Gluten', 'Dit product bevat gluten'),
(2, 'Gelatine', 'Dit product bevat gelatine'),
(3, 'AZO-Kleurstof', 'Dit product bevat AZO-kleurstoffen'),
(4, 'Lactose', 'Dit product bevat lactose'),
(5, 'Soja', 'Dit product bevat soja');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `contact`
--

DROP TABLE IF EXISTS `contact`;
CREATE TABLE IF NOT EXISTS `contact` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `Straat` varchar(255) DEFAULT NULL,
  `Huisnummer` varchar(10) DEFAULT NULL,
  `Postcode` varchar(6) DEFAULT NULL,
  `Stad` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `contact`
--

INSERT INTO `contact` (`Id`, `Straat`, `Huisnummer`, `Postcode`, `Stad`) VALUES
(1, 'Van Gilslaan', '34', '1045CB', 'Hilvarenbeek'),
(2, 'Den Dolderpad', '2', '1067RC', 'Utrecht'),
(3, 'Fredo Raalteweg', '257', '1236OP', 'Nijmegen'),
(4, 'Bertrand Russellhof', '21', '2034AP', 'Den Haag'),
(5, 'Leon van Bonstraat', '213', '145XC', 'Lunteren'),
(6, 'Bea van Lingenlaan', '234', '2197FG', 'Sint Pancras');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `country`
--

DROP TABLE IF EXISTS `country`;
CREATE TABLE IF NOT EXISTS `country` (
  `Id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `Name` varchar(250) NOT NULL,
  `CapitalCity` varchar(250) NOT NULL,
  `Continent` varchar(250) NOT NULL,
  `Population` int UNSIGNED NOT NULL,
  `Zipcode` varchar(6) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Name` (`Name`,`CapitalCity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `leverancier`
--

DROP TABLE IF EXISTS `leverancier`;
CREATE TABLE IF NOT EXISTS `leverancier` (
  `Id` smallint UNSIGNED NOT NULL AUTO_INCREMENT,
  `Naam` varchar(60) NOT NULL,
  `Contactpersoon` varchar(60) NOT NULL,
  `Leveranciernummer` varchar(11) NOT NULL,
  `Mobiel` varchar(15) NOT NULL,
  `ContactId` int DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `ContactId` (`ContactId`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `leverancier`
--

INSERT INTO `leverancier` (`Id`, `Naam`, `Contactpersoon`, `Leveranciernummer`, `Mobiel`, `ContactId`) VALUES
(1, 'Venco', 'Bert van Linge', 'L1029384719', '06-28493827', 1),
(2, 'Astra Sweets', 'Jasper del Monte', 'L1029284315', '06-39398734', 2),
(3, 'Haribo', 'Sven Stalman', 'L1029324748', '06-24383291', 3),
(4, 'Basset', 'Joyce Stelterberg', 'L1023845773', '06-48293823', 4),
(5, 'De Bron', 'Remco Veenstra', 'L1023857736', '06-34291234', 5),
(6, 'Quality Street', 'Johan Nooij', 'L1029234586', '06-23458456', 6),
(7, 'Hom Ken Food', 'Hom Ken', 'L1029234599', '06-23458477', NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `magazijn`
--

DROP TABLE IF EXISTS `magazijn`;
CREATE TABLE IF NOT EXISTS `magazijn` (
  `Id` mediumint UNSIGNED NOT NULL AUTO_INCREMENT,
  `ProductId` mediumint UNSIGNED NOT NULL,
  `VerpakkingsEenheid` decimal(4,1) NOT NULL,
  `AantalAanwezig` smallint UNSIGNED NOT NULL,
  `IsActief` bit(1) NOT NULL DEFAULT b'1',
  `Opmerkingen` varchar(255) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) NOT NULL,
  `DatumGewijzigd` datetime(6) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `ProductId` (`ProductId`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `magazijn`
--

INSERT INTO `magazijn` (`Id`, `ProductId`, `VerpakkingsEenheid`, `AantalAanwezig`, `IsActief`, `Opmerkingen`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, 1, '5.0', 65535, b'1', NULL, '2024-12-05 16:18:16.031808', '2030-02-22 00:00:00.000000'),
(2, 2, '2.5', 400, b'1', NULL, '2024-12-05 16:18:16.031851', '2024-12-05 16:18:16.031851'),
(3, 3, '5.0', 5001, b'1', NULL, '2024-12-05 16:18:16.031870', '2006-05-05 00:00:00.000000'),
(4, 4, '1.0', 1000, b'1', NULL, '2024-12-05 16:18:16.031878', '2013-02-13 00:00:00.000000'),
(5, 5, '3.0', 234, b'1', NULL, '2024-12-05 16:18:16.031885', '2024-12-05 16:18:16.031886'),
(6, 6, '2.0', 345, b'1', NULL, '2024-12-05 16:18:16.031892', '2024-12-05 16:18:16.031892'),
(7, 7, '1.0', 1350, b'1', NULL, '2024-12-05 16:18:16.031899', '2205-02-01 00:00:00.000000'),
(8, 8, '10.0', 233, b'1', NULL, '2024-12-05 16:18:16.031906', '2024-12-05 16:18:16.031906'),
(9, 9, '2.5', 123, b'1', NULL, '2024-12-05 16:18:16.031913', '2024-12-05 16:18:16.031913'),
(11, 11, '2.0', 582, b'1', NULL, '2024-12-05 16:18:16.031927', '2013-05-20 00:00:00.000000'),
(12, 12, '1.0', 967, b'1', NULL, '2024-12-05 16:18:16.031935', '2013-05-23 00:00:00.000000'),
(13, 13, '5.0', 20, b'1', NULL, '2024-12-05 16:18:16.031942', '2024-12-05 16:18:16.031942');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `Id` mediumint UNSIGNED NOT NULL AUTO_INCREMENT,
  `Naam` varchar(255) NOT NULL,
  `Barcode` varchar(13) NOT NULL,
  `Verpakkingseenheid` varchar(100) NOT NULL,
  `IsActief` bit(1) NOT NULL DEFAULT b'1',
  `Opmerkingen` varchar(255) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) NOT NULL,
  `DatumGewijzigd` datetime(6) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `product`
--

INSERT INTO `product` (`Id`, `Naam`, `Barcode`, `Verpakkingseenheid`, `IsActief`, `Opmerkingen`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, 'Mintnopjes', '8719587231278', 'Stuk', b'1', NULL, '2024-12-05 16:18:15.894188', '2024-12-05 16:18:15.894189'),
(2, 'Schoolkrijt', '8719587326713', 'Stuk', b'1', NULL, '2024-12-05 16:18:15.894223', '2024-12-05 16:18:15.894223'),
(3, 'Honingdrop', '8719587327836', 'Stuk', b'1', NULL, '2024-12-05 16:18:15.894237', '2024-12-05 16:18:15.894238'),
(4, 'Zure Beren', '8719587321441', 'Stuk', b'1', NULL, '2024-12-05 16:18:15.894242', '2024-12-05 16:18:15.894242'),
(5, 'Cola Flesjes', '8719587321237', 'Stuk', b'1', NULL, '2024-12-05 16:18:15.894245', '2024-12-05 16:18:15.894245'),
(6, 'Turtles', '8719587322245', 'Stuk', b'1', NULL, '2024-12-05 16:18:15.894249', '2024-12-05 16:18:15.894249'),
(7, 'Witte Muizen', '8719587328256', 'Stuk', b'1', NULL, '2024-12-05 16:18:15.894252', '2024-12-05 16:18:15.894252'),
(8, 'Reuzen Slangen', '8719587325641', 'Stuk', b'1', NULL, '2024-12-05 16:18:15.894255', '2024-12-05 16:18:15.894255'),
(9, 'Zoute Rijen', '8719587322739', 'Stuk', b'1', NULL, '2024-12-05 16:18:15.894259', '2024-12-05 16:18:15.894259'),
(11, 'Drop Munten', '8719587322345', 'Stuk', b'1', NULL, '2024-12-05 16:18:15.894266', '2024-12-05 16:18:15.894266'),
(12, 'Kruis Drop', '8719587322265', 'Stuk', b'1', NULL, '2024-12-05 16:18:15.894269', '2024-12-05 16:18:15.894269'),
(13, 'Zoute Ruitjes', '8719587323256', 'Stuk', b'1', NULL, '2024-12-05 16:18:15.894272', '2024-12-05 16:18:15.894272');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `productperallergeen`
--

DROP TABLE IF EXISTS `productperallergeen`;
CREATE TABLE IF NOT EXISTS `productperallergeen` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `ProductId` int NOT NULL,
  `AllergeenId` int NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `AllergeenId` (`AllergeenId`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `productperallergeen`
--

INSERT INTO `productperallergeen` (`Id`, `ProductId`, `AllergeenId`) VALUES
(1, 1, 2),
(2, 1, 1),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 9, 2),
(7, 9, 5),
(8, 10, 2),
(9, 12, 4),
(10, 13, 1),
(11, 13, 4),
(12, 13, 5);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `productperleverancier`
--

DROP TABLE IF EXISTS `productperleverancier`;
CREATE TABLE IF NOT EXISTS `productperleverancier` (
  `ProductId` int NOT NULL,
  `LeverancierId` smallint UNSIGNED NOT NULL,
  PRIMARY KEY (`ProductId`,`LeverancierId`),
  KEY `LeverancierId` (`LeverancierId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `leverancier`
--
ALTER TABLE `leverancier`
  ADD CONSTRAINT `leverancier_ibfk_1` FOREIGN KEY (`ContactId`) REFERENCES `contact` (`Id`) ON DELETE SET NULL;

--
-- Beperkingen voor tabel `magazijn`
--
ALTER TABLE `magazijn`
  ADD CONSTRAINT `magazijn_ibfk_1` FOREIGN KEY (`ProductId`) REFERENCES `product` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `productperallergeen`
--
ALTER TABLE `productperallergeen`
  ADD CONSTRAINT `productperallergeen_ibfk_1` FOREIGN KEY (`AllergeenId`) REFERENCES `allergeen` (`Id`);

--
-- Beperkingen voor tabel `productperleverancier`
--
ALTER TABLE `productperleverancier`
  ADD CONSTRAINT `productperleverancier_ibfk_1` FOREIGN KEY (`LeverancierId`) REFERENCES `leverancier` (`Id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
