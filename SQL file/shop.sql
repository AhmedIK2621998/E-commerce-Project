-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 18, 2020 at 11:33 PM
-- Server version: 10.1.29-MariaDB
-- PHP Version: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Ordering` int(11) NOT NULL,
  `Visibility` tinyint(4) DEFAULT '0',
  `Allow_Comment` tinyint(4) NOT NULL DEFAULT '0',
  `Allow_Ads` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`ID`, `Name`, `Description`, `Ordering`, `Visibility`, `Allow_Comment`, `Allow_Ads`) VALUES
(1, 'Software', 'All Software Devices', 1, 0, 0, 0),
(2, 'Clothing', 'All Clothing Here In This Categroy', 2, 1, 1, 1),
(3, 'Cars', 'That contain All Car Marka', 3, 1, 0, 1),
(4, 'Houses', 'All Houses Here', 4, 0, 1, 0),
(5, 'Computer', 'Very Good Computer', 5, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `c_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `status` tinyint(4) NOT NULL,
  `comment_date` date NOT NULL,
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`c_id`, `comment`, `status`, `comment_date`, `item_id`, `user_id`) VALUES
(1, 'Good Car In Worled', 1, '2020-03-17', 8, 1),
(3, 'Very Good Toys', 0, '2020-03-11', 4, 5),
(38, 'That Is Good Play', 0, '2020-03-18', 3, 7);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `Item_ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Price` varchar(255) NOT NULL,
  `Add_Date` date NOT NULL,
  `Countery_Made` varchar(255) NOT NULL,
  `Image` varchar(255) NOT NULL,
  `Status` varchar(255) NOT NULL,
  `Rating` smallint(6) NOT NULL,
  `Approve` tinyint(4) NOT NULL DEFAULT '0',
  `Cat_ID` int(11) NOT NULL,
  `Member_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`Item_ID`, `Name`, `Description`, `Price`, `Add_Date`, `Countery_Made`, `Image`, `Status`, `Rating`, `Approve`, `Cat_ID`, `Member_ID`) VALUES
(1, 'Ganship Battel', 'Good Game', '$80', '2020-03-17', 'Germany', '', '3', 0, 1, 1, 1),
(3, 'PlayStation 2020', 'PlayStaion 2020 Games', '$200', '2020-03-17', 'Egypt', '', '1', 0, 1, 1, 7),
(4, 'Toyes', 'This Is Toy For Kids', '$200', '2020-03-17', 'Egypt', '', '1', 0, 1, 1, 7),
(5, 'dresses', 'Kind Of Clothing', '$35', '2020-03-17', 'USA', '', '1', 0, 1, 2, 2),
(6, 'Dresses', 'Another Dresses for Wear', '$40', '2020-03-17', 'USA', '', '1', 0, 1, 2, 6),
(7, 'Chervorleat Car', 'Good Car In My Opinon', '$8000', '2020-03-17', 'Germany', '', '2', 0, 1, 3, 3),
(8, 'BMW Car', 'Good Car In World', '$90000', '2020-03-17', 'Germany', '', '1', 0, 1, 3, 7),
(9, 'Jaket', 'Very Good Clothes', '$200', '2020-03-17', 'Egypt', '', '1', 0, 1, 2, 7),
(10, 'Mouse', 'Good Magic Mouse', '25', '2020-03-17', 'Egypt', '', '1', 0, 1, 1, 7),
(15, 'private', 'PlayStaion 2020 Games', '50', '2020-03-17', 'USA', '', '3', 0, 1, 5, 7),
(16, 'Mobile', 'Mobile Samsung', '200', '2020-03-18', 'USA', '', '1', 0, 1, 1, 7),
(17, 'PlayStation1 2020', 'PlayStaion 2020 Games', '32', '2020-03-18', 'USA', '', '2', 0, 1, 1, 7),
(19, '12323', '232323233232', '32323', '2020-03-18', '3232323', '', '0', 0, 1, 5, 7),
(20, 'My Item', 'My New Item Description', '52', '2020-03-18', 'America', '', '1', 0, 1, 1, 7),
(22, 'szdsd', 'sdcsdcsdcvsdvcsdvcsdv', '765', '2020-03-19', 'America', '', '3', 0, 0, 4, 7);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL COMMENT 'To Identify User',
  `UserName` varchar(255) NOT NULL COMMENT 'Username To Login',
  `Password` varchar(255) NOT NULL COMMENT 'Password To Login',
  `Email` varchar(255) NOT NULL,
  `FullName` varchar(255) NOT NULL,
  `GroupID` int(11) NOT NULL DEFAULT '0' COMMENT 'Identify User Group',
  `TrustStatus` int(11) NOT NULL DEFAULT '0' COMMENT 'seller Rank',
  `RegStatus` int(11) NOT NULL DEFAULT '0' COMMENT 'User Approval',
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `UserName`, `Password`, `Email`, `FullName`, `GroupID`, `TrustStatus`, `RegStatus`, `Date`) VALUES
(1, 'Ahmed', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'ahmed@gmail.com', 'Ahmed Ibrahim', 1, 1, 1, '2020-03-17'),
(2, 'Zahraa', '601f1889667efaebb33b8c12572835da3f027f78', 'zahraa@gmail.com', 'Zahraa Fergany', 0, 0, 1, '2020-03-17'),
(3, 'Mossab', '444528fc68f99ea0f4fe027cb6cbd262f2a707fe', 'mosab@gmail.com', 'Mossab Ramadan', 0, 0, 1, '2020-03-17'),
(5, 'Mahmoud', 'e9f268e6911282197b71251e9b85cfd0e0bbf5bc', 'mahmoud@gmail.com', 'Mahmoud Abdelganey', 0, 0, 1, '2020-03-17'),
(6, 'Doaa', 'b2ee60370ad57d9bc3877e9024c507ab99303a64', 'doaa@gmail.com', 'Doaa Ibrahim', 0, 0, 1, '2020-03-17'),
(7, 'Khaled', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'khaled@yahoo.com', 'Khaled Mohamed', 0, 0, 1, '2020-03-17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`c_id`),
  ADD KEY `items_comment` (`item_id`),
  ADD KEY `comment_user` (`user_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`Item_ID`),
  ADD KEY `member_1` (`Member_ID`),
  ADD KEY `cat_1` (`Cat_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `UserName` (`UserName`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `Item_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'To Identify User', AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comment_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `items_comment` FOREIGN KEY (`item_id`) REFERENCES `items` (`Item_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `cat_1` FOREIGN KEY (`Cat_ID`) REFERENCES `categories` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `member_1` FOREIGN KEY (`Member_ID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
