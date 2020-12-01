-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 28, 2018 at 08:15 PM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `calendar`
--

CREATE TABLE `calendar` (
  `ID` int(11) NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `calendar`
--

INSERT INTO `calendar` (`ID`, `Date`) VALUES
(25, '0000-00-00'),
(26, '0000-00-00'),
(27, '2018-09-26'),
(28, '2018-09-10'),
(29, '2018-09-22');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `ID` int(11) NOT NULL,
  `SubCategory` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `OrdinalNumber` int(11) NOT NULL,
  `Description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`ID`, `SubCategory`, `Name`, `OrdinalNumber`, `Description`) VALUES
(50, 0, 'Zum Beginnen', 2, ''),
(51, 0, 'Zum Ankommen', 3, ''),
(53, 0, 'Zum Geniessen', 4, ''),
(54, 0, 'Zum Schlemmen', 5, ''),
(55, 0, 'Zum Abschied, Sitzenbleiben und Zwischendurch', 6, ''),
(57, 0, 'Zum Begleiten ', 7, ''),
(58, 0, 'Menüs - unsere Verkaufsschlager', 1, ''),
(59, 0, 'Zum Begleiten rot', 8, '');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `ID` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Description` text NOT NULL,
  `Price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`ID`, `Name`, `Description`, `Price`) VALUES
(25, 'Meni 1', 'example', '100.00'),
(26, 'Meni 2', 'example', '99.90');

-- --------------------------------------------------------

--
-- Table structure for table `menu_product`
--

CREATE TABLE `menu_product` (
  `MenuID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `ID` int(11) NOT NULL,
  `CategoryId` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Description` text NOT NULL,
  `Price` decimal(10,2) NOT NULL,
  `Picture` text NOT NULL,
  `OrdinalNumber` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`ID`, `CategoryId`, `Name`, `Description`, `Price`, `Picture`, `OrdinalNumber`) VALUES
(90, 50, 'Chäsfondue', 'mit Speck, Zwiebeln, Knoblauch, \nsowie Brot und Kartoffeln', '0.00', '4a8e2c2b595afd865dbcf385bfd3cd7ad9b3d1be.jpg', 1),
(91, 50, 'Bündnder Fleischplatte', 'zum Teilen geeignet', '29.00', '7537cfb363eb460796b79e884ae3904526ab3bf3.jpg', 2),
(92, 50, 'Weissweinsuppe ', 'mit Croutons', '9.00', '047d635a26fcb44502de98e2df456461c5967299.jpg', 3),
(93, 50, 'Nüsslisalat', 'mit Wildschweinbrust-Speck, Apfel und Baumnüssen ', '16.00', 'f43b6486be7e83954d26ecedfb21bc9c65bf7184.jpg', 4),
(96, 53, 'Chäsfondue', 'mit Eierschwämmli und Tomatenconcasse', '35.00', '4e75777f43b030196ea5978b76265b6b25317cf5.jpg', 1),
(98, 53, 'Mixed pickles', 'Cornichons, Silberzwiebeln und Maiskölbchen\nwird auch gerne geteilt', '4.00', 'd8d03ca9c9846da85b647a0dc11af19997e99f69.jpg', 3),
(99, 53, 'Cherrytomaten und Champignon', 'wird auch gerne geteilt', '4.00', 'a7b6394913d9ab44e302f80a962b3121a9cf84de.jpg', 4),
(100, 53, 'Birnenstücke', 'wird auch gerne geteilt', '4.00', '4c3880afd9f1ee9c9423799b931b7d04effd903e.jpg', 2),
(102, 54, 'Frischer Fruchtsalat', 'Der perfekte Abschluss.', '7.50', '004152d55b85dbb4112202eaaa68b867bac8a1a2.jpg', 1),
(103, 54, 'Zwetschgensorbet', 'Unsere Empfehlung!', '9.50', '520253a3113f7d5cce75ba35ffab5ac144274034.jpg', 3),
(105, 58, 'Chalet-Menü ', 'Unser Klassiker  \nAuswählen, abschicken und um den Rest kümmern wir uns', '30.00', '5e1e2a6c4501b371e27ccd5ef646568bced48ec0.jpg', 3),
(106, 58, 'Chalet-Menü a discretion', 'meist verkaufte Menüvariante bei Gruppen im letzten Jahr.', '30.00', '3e1ce118614e65ad286242a8145ea7faa1c132ae.jpg', 1),
(107, 58, 'Chalet-Menü PLUS', 'Allseits beliebt das Chalet-Menu mit extra viel Fonduchäs, 100g extra pro Person', '65.00', '8ee41f68e9f9828c5e2f9b41d2f69cfc18cb076d.jpg', 2),
(109, 57, 'Epesses la Republique ', 'AOC Lavaux,  Westschweiz', '48.00', '7eb877286edcd48dd1dece602e921d8a61722fa5.jpg', 1),
(110, 57, 'Badener Stadtwein', 'Blanc de Pinot noir', '55.00', 'c5e4d6e49ffff8ef23cae9a7154d3a1f9cb8edbf.jpg', 2),
(113, 57, 'Heida du Valais', 'Grand Metral, Wallis', '65.00', 'ed59e3300aa71f8cf80a3aee5945c8e5eda80ce3.jpg', 3),
(114, 59, 'Epesses la Republique rouge ', 'AOC Lavaux, Westschweiz', '48.00', '0f210c4c6eb0a93fdbd8c997745f0f529d50e3b1.jpg', 3),
(116, 59, 'Syrah du Valais', 'Grsnd Metral, Wallis', '49.00', '39cb830c8457080598cb6403db35357ca43b4cfa.jpg', 1),
(118, 59, 'Badener Stadtwein', 'Pinot noir Holzfassauslese, \nGoldwand, Aargau', '55.00', '0f4a479b7f3adb3c8ee64ba31316d9894578ee78.jpg', 2),
(119, 54, 'Hausgemachtes Tobleronemousse ', 'Zum Teilen fast zu gut', '7.50', 'ece1eb779776ce2faa0e6ca32ec3d094cf50a76c.jpg', 2),
(120, 51, 'Weisser Glühwein ', 'Unsere Empfehlung: Bitte gut gekühlt geniessen. \nAlso die Gäste, nicht der Glühwein. Logisch!', '6.00', 'db2cc79e0d18c5d503e5deca5f504d5e8a72ac27.jpg', 1),
(121, 51, 'Prosecco', 'Der Klassiker', '7.00', '7d7f4afba3dc74b9a93968f7a1db1545a7047a74.jpg', 3),
(122, 51, 'Winter Spritz', 'Webspecial nur hier buchbar für CHF 10 statt CHF 12\nAperol, Prosecco, Mandarinensirup', '10.00', 'ab4086f73e7019f9d561360a1064a5facee13e82.jpg', 2);

-- --------------------------------------------------------

--
-- Table structure for table `product_variant`
--

CREATE TABLE `product_variant` (
  `ID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `Price` decimal(10,2) NOT NULL,
  `ForNumPeople` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `IsDefault` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_variant`
--

INSERT INTO `product_variant` (`ID`, `ProductID`, `Price`, `ForNumPeople`, `Name`, `IsDefault`) VALUES
(96, 90, '0.00', 1, 'Default', 1),
(97, 91, '29.00', 1, 'Default', 1),
(98, 92, '9.00', 1, 'Default', 1),
(99, 93, '16.00', 1, 'Default', 1),
(101, 96, '35.00', 1, 'Default', 1),
(103, 98, '4.00', 1, 'Default', 1),
(104, 99, '4.00', 1, 'Default', 1),
(105, 100, '4.00', 1, 'Default', 1),
(107, 102, '7.50', 1, 'Default', 1),
(108, 103, '9.50', 1, 'Default', 1),
(109, 105, '30.00', 1, 'Default', 1),
(110, 106, '30.00', 1, 'Default', 1),
(111, 107, '65.00', 1, 'Default', 1),
(112, 109, '48.00', 1, 'Default', 1),
(113, 110, '55.00', 1, 'Default', 1),
(116, 113, '65.00', 1, 'Default', 1),
(117, 114, '48.00', 1, 'Default', 1),
(119, 116, '49.00', 1, 'Default', 1),
(121, 118, '55.00', 1, 'Default', 1),
(122, 119, '7.50', 1, 'Default', 1),
(123, 120, '6.00', 1, 'Default', 1),
(124, 121, '7.00', 1, 'Default', 1),
(125, 122, '10.00', 1, 'Default', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `ID` int(11) NOT NULL,
  `UserName` varchar(20) NOT NULL,
  `Password` varchar(200) NOT NULL,
  `ResetToken` text NOT NULL,
  `Email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`ID`, `UserName`, `Password`, `ResetToken`, `Email`) VALUES
(1, 'admin', '$2y$10$YOEtQOdZjLlusAxM5Visg.Ru7d2Qria87ZpDyWIXmuXc/nOPiQn9y', '', 'zvonimir.dujmic@hotmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `calendar`
--
ALTER TABLE `calendar`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `SubCategory` (`SubCategory`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `menu_product`
--
ALTER TABLE `menu_product`
  ADD PRIMARY KEY (`MenuID`,`ProductID`),
  ADD KEY `MeniID` (`MenuID`),
  ADD KEY `ProductID` (`ProductID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `CategoryId` (`CategoryId`);

--
-- Indexes for table `product_variant`
--
ALTER TABLE `product_variant`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `UserName` (`UserName`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `calendar`
--
ALTER TABLE `calendar`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT for table `product_variant`
--
ALTER TABLE `product_variant`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `menu_product`
--
ALTER TABLE `menu_product`
  ADD CONSTRAINT `menu_product_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ID`),
  ADD CONSTRAINT `menu_product_ibfk_2` FOREIGN KEY (`MenuID`) REFERENCES `menu` (`ID`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`CategoryId`) REFERENCES `category` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
