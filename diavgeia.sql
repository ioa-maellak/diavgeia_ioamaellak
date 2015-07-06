-- phpMyAdmin SQL Dump
-- version 4.0.10.10
-- http://www.phpmyadmin.net
--
-- Φιλοξενητής: 127.4.12.130:3306
-- Χρόνος δημιουργίας: 06 Ιουλ 2015 στις 09:11:50
-- Έκδοση διακομιστή: 5.5.41
-- Έκδοση PHP: 5.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Βάση: `diavgeia`
--

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `apofaseis`
--

CREATE TABLE IF NOT EXISTS `apofaseis` (
  `ada` varchar(20) CHARACTER SET utf8 NOT NULL,
  `protocolNumber` varchar(30) CHARACTER SET utf8 NOT NULL,
  `subject` varchar(100) CHARACTER SET utf8 NOT NULL,
  `issueDate` bigint(20) NOT NULL,
  `decisionTypeId` varchar(6) CHARACTER SET utf8 NOT NULL,
  `organizationId` bigint(20) NOT NULL,
  `status` varchar(40) CHARACTER SET utf8 NOT NULL,
  `documentChecksum` varchar(40) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`ada`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `apofaseisb21`
--

CREATE TABLE IF NOT EXISTS `apofaseisb21` (
  `ada` varchar(20) NOT NULL,
  `amount` float NOT NULL,
  `sponsorAfm` varchar(20) NOT NULL,
  `sponsorName` varchar(60) NOT NULL,
  PRIMARY KEY (`ada`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Περιορισμοί για άχρηστους πίνακες
--

--
-- Περιορισμοί για πίνακα `apofaseisb21`
--
ALTER TABLE `apofaseisb21`
  ADD CONSTRAINT `apofaseisb21_ibfk_1` FOREIGN KEY (`ada`) REFERENCES `apofaseis` (`ada`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
