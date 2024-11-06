-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2023 at 01:25 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotel`
--

-- --------------------------------------------------------

--
-- Table structure for table `dhoma`
--

CREATE TABLE `dhoma` (
  `roomID` int(11) NOT NULL,
  `roomNo` int(11) NOT NULL,
  `type` varchar(60) NOT NULL,
  `beds` int(11) NOT NULL,
  `capacity` int(11) NOT NULL,
  `price` decimal(7,2) NOT NULL,
  `internet` enum('yes','no') NOT NULL,
  `balcony` enum('yes','no') NOT NULL,
  `floor` int(11) NOT NULL,
  `pets` enum('yes','no') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dhoma`
--

INSERT INTO `dhoma` (`roomID`, `roomNo`, `type`, `beds`, `capacity`, `price`, `internet`, `balcony`, `floor`, `pets`) VALUES
(1, 1, 'Standard', 1, 3, '15000.00', 'yes', 'no', 2, 'no'),
(2, 1, 'Standard', 1, 3, '15000.00', 'yes', 'no', 2, 'no'),
(3, 1, 'Standard', 1, 3, '15000.00', 'yes', 'no', 3, 'no'),
(4, 1, 'Standard', 1, 3, '15000.00', 'yes', 'no', 3, 'no'),
(5, 1, 'Standard', 1, 3, '15000.00', 'yes', 'no', 4, 'no'),
(6, 2, 'Family', 3, 5, '22000.00', 'yes', 'yes', 3, 'yes'),
(7, 2, 'Family', 3, 5, '22000.00', 'yes', 'yes', 4, 'yes'),
(8, 2, 'Family', 3, 5, '22000.00', 'yes', 'yes', 2, 'yes'),
(9, 2, 'Family', 3, 5, '22000.00', 'yes', 'yes', 3, 'yes'),
(11, 1, 'Single', 1, 1, '8000.00', 'yes', 'no', 3, 'no'),
(12, 1, 'Single', 1, 1, '8000.00', 'yes', 'no', 4, 'no'),
(13, 1, 'Single', 1, 1, '8000.00', 'yes', 'no', 2, 'no'),
(14, 1, 'Single', 1, 1, '8000.00', 'yes', 'no', 4, 'no'),
(15, 1, 'Single', 1, 1, '8000.00', 'yes', 'no', 4, 'no'),
(17, 1, 'Couples', 1, 2, '13000.00', 'yes', 'yes', 2, 'no'),
(18, 1, 'Couples', 1, 2, '13000.00', 'yes', 'yes', 2, 'no'),
(19, 1, 'Couples', 1, 2, '13000.00', 'yes', 'yes', 3, 'no'),
(20, 1, 'Couples', 1, 2, '13000.00', 'yes', 'yes', 3, 'no'),
(21, 1, 'Couples', 1, 2, '13000.00', 'yes', 'yes', 4, 'no'),
(22, 2, 'Suite', 4, 7, '30000.00', 'yes', 'yes', 5, 'yes'),
(23, 2, 'Suite', 4, 7, '30000.00', 'yes', 'yes', 5, 'yes'),
(24, 3, 'Presidential Suite', 5, 10, '40000.00', 'yes', 'yes', 6, 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `dhoma_foto`
--

CREATE TABLE `dhoma_foto` (
  `photoID` int(11) NOT NULL,
  `roomID` int(11) NOT NULL,
  `photo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dhoma_foto`
--

INSERT INTO `dhoma_foto` (`photoID`, `roomID`, `photo`) VALUES
(1, 1, 'roomImages/standard1.jpg'),
(2, 2, 'roomImages/st2.jpg'),
(3, 3, 'roomImages/st3.jpg'),
(4, 4, 'roomImages/st4.jpg'),
(5, 5, 'roomImages/st5.jpg'),
(6, 6, 'roomImages/family1.jpg'),
(7, 7, 'roomImages/fm2.jpg'),
(8, 8, 'roomImages/fm3.jpg'),
(9, 9, 'roomImages/fm4.jpg'),
(11, 11, 'roomImages/single4.jpg'),
(12, 12, 'roomImages/single6.jpg'),
(13, 13, 'includes/IMG-6460ceda80e3b8.59177703.jpg'),
(14, 14, 'roomImages/single5.jpg'),
(15, 15, 'roomImages/single3.jpg'),
(16, 17, 'roomImages/couples1.jpg'),
(17, 18, 'roomImages/couples2.jpg'),
(18, 19, 'roomImages/couples3.jpg'),
(19, 20, 'roomImages/couples4.jpg'),
(20, 21, 'roomImages/couples5.jpg'),
(21, 22, 'roomImages/suite1.jpg'),
(22, 23, 'roomImages/suite2.jpg'),
(23, 24, 'roomImages/presidentialsuite1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `eventID` int(11) NOT NULL,
  `description` longtext NOT NULL,
  `Title` varchar(60) DEFAULT NULL,
  `image` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`eventID`, `description`, `Title`, `image`) VALUES
(1, 'Play tennis year-round, rain or shine on the only indoor air-conditioned courts in Tirana. We regularly host tournaments and events throughout the year on our professional court. Ball machine rental and tennis instruction are available.', 'Tennis', 'includes/tenis.png'),
(2, 'Stay fit on the go at our fully equipped athletic center, located on the first floor of our hotel. You will have access to Treadmills & ellipticals, Recumbent bikes, Weight machines, Functional training, Resistance training and certified personal trainers.', 'Gym', 'includes/gym.png'),
(3, 'Dive in our outdoor swimming pool and enjoy pure tranquility and relaxation. We have created a calming and comfortable environment where you can revive your spirit, awaken your senses and rejuvenate your body and mind.', 'Swimming', 'includes/pool.png'),
(4, 'Enjoy a quick breakfast, a cup of coffee, a latte and much more. Taste, hear, see, feel the rhythm and excite your palate with mouth-watering dishes and the wide assortment of cocktails, wine, and beer our bar and restaurant has to offer.', 'Dining & Drinks', 'includes/bar.png');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `pic_id` int(11) NOT NULL,
  `photo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`pic_id`, `photo`) VALUES
(1, 'includes/hotel1.png'),
(2, 'includes/hotel2.png'),
(3, 'includes/hotel5.png'),
(4, 'includes/hotel4.png'),
(5, 'includes/hotel3.png');

-- --------------------------------------------------------

--
-- Table structure for table `inactive_staf`
--

CREATE TABLE `inactive_staf` (
  `id` int(11) NOT NULL,
  `emer` varchar(30) NOT NULL,
  `mbiemer` varchar(30) NOT NULL,
  `email` varchar(200) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `profile_pic` text DEFAULT 'default.jpg',
  `pass` varchar(255) NOT NULL,
  `roli` enum('admin','user') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `klient`
--

CREATE TABLE `klient` (
  `clientID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `tel` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `klient`
--

INSERT INTO `klient` (`clientID`, `name`, `lname`, `tel`, `email`) VALUES
(6, 'Test', 'Test', '0698166171', 'test@gmail.com'),
(8, 'Eneida', 'Koçi', '1234567890', 'eneida.koci@gmail.com'),
(9, 'Eneida', 'Koçi', '0692994008', 'K.eneida@yahoo.com'),
(10, 'Elio', 'Shehu', '0698166171', 'elio@gmail.com'),
(11, 'Egli', 'Tafa', '0691239875', 'egli@gmail.com'),
(12, 'Gerald', 'Metohu', '12353467', 'geri@gmail.com'),
(13, 'Julvina', 'Beqo', '0698166171', 'julvinabeqo02@gmail.com'),
(14, 'Eno', 'test', '46546466', 'arlinda.profi@fshn.edu.al'),
(16, 'Enola', 'Selimi', '0692994008', 'enolaselimi@gmail.com'),
(17, 'hahah', 'lalalal', '12353467', 'elioshehu15@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `rezervim`
--

CREATE TABLE `rezervim` (
  `resID` int(11) NOT NULL,
  `roomID` int(11) NOT NULL,
  `clientID` int(11) NOT NULL,
  `resDate` date NOT NULL,
  `checkIn` date NOT NULL,
  `checkOut` date DEFAULT NULL,
  `guests` int(11) NOT NULL,
  `price` decimal(7,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rezervim`
--

INSERT INTO `rezervim` (`resID`, `roomID`, `clientID`, `resDate`, `checkIn`, `checkOut`, `guests`, `price`) VALUES
(26, 7, 17, '2023-05-27', '2023-05-29', '2023-05-30', 1, '22000.00'),
(27, 2, 8, '2023-05-27', '2023-07-12', '2023-07-13', 2, '15000.00'),
(28, 8, 16, '2023-05-27', '2023-06-13', '2023-06-14', 1, '22000.00'),
(29, 24, 8, '2023-05-27', '2023-05-29', '2023-05-31', 3, '80000.00'),
(30, 17, 16, '2023-05-27', '2023-05-30', '2023-05-31', 5, '13000.00'),
(31, 12, 17, '2023-05-27', '2023-05-30', '2023-05-31', 1, '8000.00');

-- --------------------------------------------------------

--
-- Table structure for table `staf`
--

CREATE TABLE `staf` (
  `staffID` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `tel` varchar(20) DEFAULT NULL,
  `roli` enum('user','admin') NOT NULL,
  `profile_pic` text DEFAULT NULL,
  `exp_date` varchar(250) NOT NULL,
  `reset_link_token` varchar(255) NOT NULL,
  `google_id` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `staf`
--

INSERT INTO `staf` (`staffID`, `fname`, `lname`, `email`, `pass`, `tel`, `roli`, `profile_pic`, `exp_date`, `reset_link_token`, `google_id`) VALUES
(2, 'admin', 'admin', 'admin@gmail.com', 'c7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3eab1d80b931dd472634dfac71cd34ebc35d16ab7fb8a90c81f975113d6c7538dc69dd8de9077ec', '0691234567', 'admin', 'default.jpg', '', '', ''),
(10, 'Egli', 'Tafa', 'egli@gmail.com', '80fb12ad1ff4cbbb82d761957492e85cda98d13ef98a83dddb22a9e4432c27de07241cd3e6b00ab71a4847212c415f3134d972ec5bfc82dcaa45e8d17c6cde2c', '0691239875', 'user', 'IMG-6436d1833fa900.96403475.jpg', '', '', ''),
(14, 'Enola', 'Selimi', 'enolaselimi@gmail.com', '84ed978fcfaa5f4d83f5f0d0515915f93bd9e09252ede4fc40f9a14c29c42bb9e1e45ecbd6b7cafcb3182408cea020073b55e8d66c6e0987e56dc80c09931446', '0692994008', 'user', 'IMG-6471d256ab3c66.11146585.jpg', '', '', ''),
(16, 'Eneida', 'Koçi', 'K.eneida@yahoo.com', '0349aaed678bd9cdace4f48888723bf4ac514b8c54cefe150e24ea3b1b82e90aef783333f0eeae7f65ef15a2a58542ee83abbc530260ef4c37dc2fb7b43e7dcf', '0692994008', 'user', 'IMG-643d90a81f2bf2.44729958.png', '', '', ''),
(17, 'Elio', 'Shehu', 'elio@gmail.com', '1b966c06c51ba42dc86ce92a94308fbb268f1b991a165e8ed637f75af6a4d6a842d481fed17cabf7d184417d19baf297014e83a314a91f65f6fd812fb864eb18', '0698166171', 'user', 'IMG-643d911b4e8482.62741571.jpg', '', '', ''),
(18, 'Gerald', 'Metohu', 'geri@gmail.com', 'b6da81302aa62c63cc7683f0a06cdb2e2e63a1423f1cfcdcf3fef876d3c3110aa21e4b6ae44de0cf8209a1f16709481dee35d43d0e90793eabf808a6e236006a', '12353467', 'user', 'IMG-643d91b26eb0e5.82062461.png', '', '', ''),
(47, 'Enola', 'Selimi', 'enola.selimi@fshnstudent.info', '', NULL, 'user', 'https://lh3.googleusercontent.com/a/AAcHTtf0RPbc5vv1SeYzhhYVY-6CHNdwzqKXu6sKWxxr=s96-c', '', '', '103568975617529476584');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dhoma`
--
ALTER TABLE `dhoma`
  ADD PRIMARY KEY (`roomID`);

--
-- Indexes for table `dhoma_foto`
--
ALTER TABLE `dhoma_foto`
  ADD PRIMARY KEY (`photoID`),
  ADD KEY `dhome_foto_FK` (`roomID`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`eventID`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`pic_id`);

--
-- Indexes for table `inactive_staf`
--
ALTER TABLE `inactive_staf`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `klient`
--
ALTER TABLE `klient`
  ADD PRIMARY KEY (`clientID`);

--
-- Indexes for table `rezervim`
--
ALTER TABLE `rezervim`
  ADD PRIMARY KEY (`resID`),
  ADD KEY `res_klient_FK` (`clientID`),
  ADD KEY `res_dhoma_FK` (`roomID`);

--
-- Indexes for table `staf`
--
ALTER TABLE `staf`
  ADD PRIMARY KEY (`staffID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dhoma`
--
ALTER TABLE `dhoma`
  MODIFY `roomID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `dhoma_foto`
--
ALTER TABLE `dhoma_foto`
  MODIFY `photoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `eventID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `pic_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `inactive_staf`
--
ALTER TABLE `inactive_staf`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `klient`
--
ALTER TABLE `klient`
  MODIFY `clientID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `rezervim`
--
ALTER TABLE `rezervim`
  MODIFY `resID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `staf`
--
ALTER TABLE `staf`
  MODIFY `staffID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dhoma_foto`
--
ALTER TABLE `dhoma_foto`
  ADD CONSTRAINT `dhome_foto_FK` FOREIGN KEY (`roomID`) REFERENCES `dhoma` (`roomID`) ON DELETE CASCADE;

--
-- Constraints for table `rezervim`
--
ALTER TABLE `rezervim`
  ADD CONSTRAINT `res_dhoma_FK` FOREIGN KEY (`roomID`) REFERENCES `dhoma` (`roomID`) ON DELETE CASCADE,
  ADD CONSTRAINT `res_klient_FK` FOREIGN KEY (`clientID`) REFERENCES `klient` (`clientID`) ON DELETE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
