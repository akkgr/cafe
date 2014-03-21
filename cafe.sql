-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 21, 2014 at 09:34 AM
-- Server version: 5.6.16
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cafe`
--

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `ItemID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `Description` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `Price` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`ItemID`)
) ENGINE=InnoDB  DEFAULT CHARSET=greek AUTO_INCREMENT=25 ;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`ItemID`, `Name`, `Description`, `Price`) VALUES
(1, 'Ελληνικός Μονός ', 'Ροφήματα - Ζεστά - Καφέδες', '2.50'),
(2, 'Ελληνικός Διπλός', 'Ροφήματα - Ζεστά - Καφέδες', '3.50'),
(3, 'Λάτε (Διπλό Εσπρέσσο με φρέσκο γάλα)', 'Ροφήματα - Ζεστά - Καφέδες', '4.50'),
(4, 'Εσπρέσσο', 'Ροφήματα - Ζεστά - Καφέδες', '2.50'),
(5, 'Εσπρέσσο Διπλός', 'Ροφήματα - Ζεστά - Καφέδες', '4.00'),
(6, 'Καπουτσίνο', 'Ροφήματα - Ζεστά - Καφέδες', '3.80'),
(7, 'Καπουτσίνο Διπλός', 'Ροφήματα - Ζεστά - Καφέδες', '5.50'),
(8, 'Καπουτσίνο Σαντιγύ', 'Ροφήματα - Ζεστά - Καφέδες', '6.50'),
(9, 'Γαλλικός', 'Ροφήματα - Ζεστά - Καφέδες', '3.10'),
(10, 'Νες Καφέ', 'Ροφήματα - Ζεστά - Καφέδες', '3.80'),
(11, 'Νες Καφέ Βιενουά', 'Ροφήματα - Ζεστά - Καφέδες', '5.20'),
(12, 'Σοκολάτα', 'Ροφήματα - Ζεστά - Σοκολάτες', '4.00'),
(13, 'Σοκολάτα Βιενουά', 'Ροφήματα - Ζεστά - Σοκολάτες', '5.00'),
(14, 'Τσάι', 'Ροφήματα - Ζεστά - Τέϊον', '3.30'),
(15, 'Τσάι με κονιάκ', 'Ροφήματα - Ζεστά - Τέϊον', '5.50'),
(16, 'Χαμομήλι', 'Ροφήματα - Ζεστά - Χαμομήλιον', '2.80'),
(17, 'Νεραντζάκι', 'Γλυκά - Γλυκά Κουταλιού  - Νεραντζάκι', '6.90'),
(18, 'Φρεντοτσίνο', 'Ροφήματα - Κρύα - Φρεντοτσίνο', '7.00'),
(19, 'Γάλα', '	Ροφήματα - Ζεστά -  Γάλα', '2.80'),
(20, 'Κονιάκ', 'Ποτά - Κονιάκ', '7.35'),
(21, 'dgfsfdg', 'fdgsfdg', '123.00'),
(22, 'rwer', 'wreewr', '2.00'),
(23, 'sdfsadf', 'sdfsdf', '2.00'),
(24, '````ewre', 'e', '3.00');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `OrderID` int(11) NOT NULL AUTO_INCREMENT,
  `ItemID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `OrderDateTime` datetime DEFAULT NULL,
  `Username` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`OrderID`),
  KEY `ItemID_idx` (`ItemID`),
  KEY `Username_idx` (`Username`)
) ENGINE=InnoDB  DEFAULT CHARSET=greek AUTO_INCREMENT=169 ;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`OrderID`, `ItemID`, `Quantity`, `OrderDateTime`, `Username`) VALUES
(1, 1, 2, '2014-02-01 00:00:00', 'waiter1'),
(2, 6, 2, '2014-02-02 00:00:00', 'waiter2'),
(3, 9, 4, '2014-02-03 00:00:00', 'waiter3'),
(4, 10, 4, '2014-03-04 00:00:00', 'waiter1'),
(5, 3, 1, '2014-03-05 00:00:00', 'waiter2'),
(6, 11, 1, '2014-03-05 00:00:00', 'waiter1'),
(7, 7, 3, '2014-03-05 00:00:00', 'waiter2'),
(8, 6, 2, '2014-03-05 00:00:00', 'waiter3'),
(9, 14, 1, '2014-03-05 00:00:00', 'waiter1'),
(10, 15, 3, '2014-03-05 00:00:00', 'waiter3'),
(11, 14, 4, '2014-03-05 00:00:00', 'waiter1'),
(12, 10, 6, '2014-03-06 00:00:00', 'waiter3'),
(13, 10, 2, '2014-03-06 00:00:00', 'waiter2'),
(14, 1, 7, '2014-03-06 00:00:00', 'waiter1'),
(15, 16, 1, '2014-03-06 00:00:00', 'waiter3'),
(16, 16, 1, '2014-03-06 00:00:00', 'waiter2'),
(17, 7, 3, '2014-03-07 00:00:00', 'waiter1'),
(18, 7, 2, '2014-03-07 00:00:00', 'waiter3'),
(19, 6, 2, '2014-03-07 00:00:00', 'waiter1'),
(20, 5, 4, '2014-03-07 00:00:00', 'waiter2'),
(21, 3, 5, '2014-03-07 00:00:00', 'waiter3'),
(22, 4, 5, '2014-03-08 00:00:00', 'waiter2'),
(23, 4, 2, '2014-03-08 00:00:00', 'waiter1'),
(135, 2, 2, '2014-03-09 18:11:01', 'waiter1'),
(139, 4, 2, '2014-03-09 18:55:08', 'waiter1'),
(141, 3, 2, '2014-03-09 18:59:52', 'waiter1'),
(142, 3, 2, '2014-03-09 18:59:52', 'waiter1'),
(143, 9, 1, '2014-03-09 19:40:44', 'waiter1'),
(144, 9, 1, '2014-03-09 19:40:44', 'waiter1'),
(145, 19, 0, '2014-03-09 19:52:25', 'waiter1'),
(146, 19, 0, '2014-03-09 19:52:25', 'waiter1'),
(147, 1, 1, '2014-03-09 19:57:07', 'waiter1'),
(148, 1, 1, '2014-03-09 19:57:07', 'waiter1'),
(153, 5, 1, '2014-03-09 20:12:01', 'waiter2'),
(154, 5, 1, '2014-03-09 20:12:01', 'waiter2'),
(156, 8, 4, '2014-03-09 20:12:35', 'waiter2'),
(163, 20, 2, '2014-03-11 18:07:20', 'waiter1'),
(164, 20, 2, '2014-03-11 18:07:20', 'waiter1'),
(165, 19, 2, '2014-03-11 18:07:29', 'waiter1'),
(166, 19, 2, '2014-03-11 18:07:29', 'waiter1'),
(167, 12, 3, '2014-03-11 18:07:34', 'waiter1'),
(168, 12, 3, '2014-03-11 18:07:34', 'waiter1');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `Username` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `FirstName` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `LastName` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `Password` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `Role` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`Username`)
) ENGINE=InnoDB DEFAULT CHARSET=greek;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`Username`, `FirstName`, `LastName`, `Password`, `Role`) VALUES
('admin', 'Τάσος', 'Κανελλόπουλος', '12345', 'Διαχειριστής'),
('admin2', 'Αντώνης', 'Μακάρας', '12345', 'Διαχειριστής'),
('waiter1', 'Εύα', 'Αντωνίου', '12345', 'Σερβιτόρος'),
('waiter2', 'Γεωργία', 'Παππά', '12345', 'Σερβιτόρος'),
('waiter3', 'Αντώνης', 'Πέτρου', '12345', 'Σερβιτόρος'),
('waiter5', 'Άννα', 'Γκίκα', '12345', 'Σερβιτόρος'),
('waiter7', 'Άννα', 'Λέκκα', '12345', 'Σερβιτόρος');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `ItemID` FOREIGN KEY (`ItemID`) REFERENCES `items` (`ItemID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Username` FOREIGN KEY (`Username`) REFERENCES `users` (`Username`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
