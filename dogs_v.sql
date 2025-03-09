-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 09, 2025 at 05:23 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dogs_v`
--

-- --------------------------------------------------------

--
-- Table structure for table `activitylogs`
--

CREATE TABLE `activitylogs` (
  `LogID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `Action` varchar(255) DEFAULT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activitylogs`
--

INSERT INTO `activitylogs` (`LogID`, `UserID`, `Action`, `Timestamp`) VALUES
(1, 4, 'ลบข้อมูลสุนัข: ลาบาdoor (ID: 14)', '2025-03-08 11:37:17'),
(2, 4, 'เพิ่มข้อมูลสุนัข: หฟกหฟก (โกลเด้น รีทรีฟเวอร์ (Golden Retriever))', '2025-03-08 11:38:00'),
(3, 4, 'เพิ่มข้อมูลสุนัข: asd (โกลเด้น รีทรีฟเวอร์ (Golden Retriever))', '2025-03-08 12:13:53'),
(4, 4, 'เพิ่มข้อมูลสุนัข: asd (โกลเด้น รีทรีฟเวอร์ (Golden Retriever))', '2025-03-08 12:13:58'),
(5, 4, 'เพิ่มข้อมูลสุนัข: asd (โกลเด้น รีทรีฟเวอร์ (Golden Retriever))', '2025-03-08 12:14:01'),
(6, 4, 'เพิ่มข้อมูลสุนัข: asd (โกลเด้น รีทรีฟเวอร์ (Golden Retriever))', '2025-03-08 12:14:05'),
(7, 4, 'เพิ่มข้อมูลสุนัข: 21321 (ลาบราดอร์ รีทรีฟเวอร์ (Labrador Retriever))', '2025-03-08 12:15:44'),
(8, 4, 'แก้ไขข้อมูลสุนัข ID: 12 (ชิบ)', '2025-03-08 12:34:58'),
(9, 4, 'แก้ไขข้อมูลสุนัข ID: 12 (ชิบ)', '2025-03-08 12:35:02'),
(10, 4, 'แก้ไขข้อมูลสุนัข ID: 12 (ชิบ)', '2025-03-08 12:35:30'),
(11, 4, 'แก้ไขข้อมูลสุนัข ID: 12 (ชิบ)', '2025-03-08 12:39:05'),
(12, 4, 'แก้ไขข้อมูลสุนัข ID: 12 (ชิบ)', '2025-03-08 12:39:22'),
(13, 4, 'แก้ไขข้อมูลสุนัข ID: 12 (ชิบ)', '2025-03-08 12:41:34'),
(14, 4, 'แก้ไขข้อมูลสุนัข ID: 12 (ชิบ)', '2025-03-08 12:45:16'),
(15, 4, 'แก้ไขข้อมูลสุนัข ID: 29 (ชิชิ)', '2025-03-08 12:51:41'),
(16, 4, 'แก้ไขข้อมูลสุนัข ID: 31 (asd)', '2025-03-08 12:56:18'),
(17, 4, 'แก้ไขข้อมูลสุนัข ID: 33 (ลาบาdoor)', '2025-03-08 13:12:58'),
(18, 8, 'แก้ไขข้อมูลสุนัข ID: 34 (นาชิ)', '2025-03-08 13:44:47'),
(19, 8, 'แก้ไขข้อมูลสุนัข ID: 35 (ลาบาdoor)', '2025-03-08 14:05:49'),
(20, 8, 'แก้ไขข้อมูลสุนัข ID: 36 (nine)', '2025-03-08 14:06:22'),
(21, 8, 'แก้ไขข้อมูลสุนัข ID: 36 (nine)', '2025-03-08 14:06:28'),
(22, 8, 'แก้ไขข้อมูลสุนัข ID: 36 (nine)', '2025-03-08 14:07:48'),
(23, 4, 'แก้ไขข้อมูลสุนัข ID: 37 (ลาบาdoor)', '2025-03-09 03:09:34'),
(24, 9, 'แก้ไขข้อมูลสุนัข ID: 39 (นะ)', '2025-03-09 04:12:11');

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `AppointmentID` int(11) NOT NULL,
  `DogID` int(11) DEFAULT NULL,
  `VaccineID` int(11) DEFAULT NULL,
  `AppointmentDate` date DEFAULT NULL,
  `Status` enum('pending','completed') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`AppointmentID`, `DogID`, `VaccineID`, `AppointmentDate`, `Status`) VALUES
(10, 40, 18, '2025-03-10', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `dogs`
--

CREATE TABLE `dogs` (
  `DogID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Breed` varchar(100) DEFAULT NULL,
  `Age` int(11) DEFAULT NULL,
  `OwnerName` varchar(100) DEFAULT NULL,
  `ImagePath` varchar(255) DEFAULT NULL,
  `OwnerPhone` varchar(15) DEFAULT NULL,
  `Phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dogs`
--

INSERT INTO `dogs` (`DogID`, `Name`, `Breed`, `Age`, `OwnerName`, `ImagePath`, `OwnerPhone`, `Phone`) VALUES
(40, 'นะ', 'ลาบราดอร์ รีทรีฟเวอร์ (Labrador Retriever)', 2, 'NINE', 'uploads/RobloxScreenShot20231018_173700523.png', '0820326213', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `NotificationID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Message` text NOT NULL,
  `Status` enum('Unread','Read') DEFAULT 'Unread',
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `ReportID` int(11) NOT NULL,
  `ReportName` varchar(100) DEFAULT NULL,
  `GeneratedDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Role` enum('admin','user') DEFAULT 'user',
  `ResetToken` varchar(255) DEFAULT NULL,
  `ResetTokenExpire` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Password`, `Email`, `Role`, `ResetToken`, `ResetTokenExpire`) VALUES
(1, '650112230019', '$2y$10$wJNdxlGYEqbAWO/as/HvBu.r1C34qNWRl/r8mYGXYs1GEmm0gGgQC', 'phuriphat8993@gmail.com', 'user', NULL, NULL),
(2, '11', '$2y$10$VpFjGSPVEVRuWjzh53wnE.bgdHd99jlrcDr..jkARIWzKsWf0tm8a', 'phuriphatkhamchai909@gmail.com', 'user', NULL, NULL),
(3, '650112230019', '$2y$10$GOGkhq.SDVj7WR9guOJ3be.wLmMBy0S4Fg7I2Dvah7GJJXZPnt.fG', '650112230019@bru.ac.th', 'user', NULL, NULL),
(4, 'lilnine', '$2y$10$BlyCT9QYAKXiQyk08hTF9uHlxh.OTcce4jyQWENOJyus5QsXl5p9G', 'opqqqgta2@gmail.com', 'user', '094fed144680b9ea2f4b50ee8e22648e46430e53d4b3ade8966cfd4b83d12a6c040702236a7c1264d60857dcf819fa84e134', '2025-03-08 21:33:19'),
(5, 'lilnine', '$2y$10$WjF3oeW4Eeff8B5Lt8Z0kOA1WdbvDu3vgAJDRZXH2tTPMWKbJEaEy', 'opqqqgta2@gmail.com', 'user', '094fed144680b9ea2f4b50ee8e22648e46430e53d4b3ade8966cfd4b83d12a6c040702236a7c1264d60857dcf819fa84e134', '2025-03-08 21:33:19'),
(6, 'n', '$2y$10$Tna.s/vMTPbbOVAbqSW4qO3QX33nlj1CMQ5X.hUV6ZQTdYTQf4.AS', '650112230002@bru.acth', 'user', NULL, NULL),
(7, 'lilnine', '$2y$10$Tna.s/vMTPbbOVAbqSW4qO3QX33nlj1CMQ5X.hUV6ZQTdYTQf4.AS', '650112230002@bru.acth', 'user', NULL, NULL),
(8, '23', '$2y$10$Tna.s/vMTPbbOVAbqSW4qO3QX33nlj1CMQ5X.hUV6ZQTdYTQf4.AS', '650112230002@bru.acth', 'user', NULL, NULL),
(9, 'Sa', '$2y$10$Tna.s/vMTPbbOVAbqSW4qO3QX33nlj1CMQ5X.hUV6ZQTdYTQf4.AS', '650112230002@bru.acth', 'user', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vaccinationrecords`
--

CREATE TABLE `vaccinationrecords` (
  `RecordID` int(11) NOT NULL,
  `DogID` int(11) DEFAULT NULL,
  `VaccineID` int(11) DEFAULT NULL,
  `VaccinationDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vaccinationrecords`
--

INSERT INTO `vaccinationrecords` (`RecordID`, `DogID`, `VaccineID`, `VaccinationDate`) VALUES
(24, 40, 18, '2025-03-09');

-- --------------------------------------------------------

--
-- Table structure for table `vaccination_appointments`
--

CREATE TABLE `vaccination_appointments` (
  `AppointmentID` int(11) NOT NULL,
  `DogID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `VaccineID` int(11) NOT NULL,
  `AppointmentDate` date NOT NULL,
  `Status` enum('รอฉีด','ฉีดแล้ว','ยกเลิก') DEFAULT 'รอฉีด',
  `Notes` text DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vaccination_schedule`
--

CREATE TABLE `vaccination_schedule` (
  `EventID` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Description` text DEFAULT NULL,
  `EventDate` date NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `CalendarEventID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vaccines`
--

CREATE TABLE `vaccines` (
  `VaccineID` int(11) NOT NULL,
  `VaccineName` varchar(100) NOT NULL,
  `Description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vaccines`
--

INSERT INTO `vaccines` (`VaccineID`, `VaccineName`, `Description`) VALUES
(17, 'วัคซีนพิษสุนัขบ้า', ''),
(18, 'วัคซีนพิษสุนัขบ้า', 'dsadsa');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activitylogs`
--
ALTER TABLE `activitylogs`
  ADD PRIMARY KEY (`LogID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`AppointmentID`),
  ADD KEY `VaccineID` (`VaccineID`),
  ADD KEY `appointments_ibfk_1` (`DogID`);

--
-- Indexes for table `dogs`
--
ALTER TABLE `dogs`
  ADD PRIMARY KEY (`DogID`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`NotificationID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`ReportID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `vaccinationrecords`
--
ALTER TABLE `vaccinationrecords`
  ADD PRIMARY KEY (`RecordID`),
  ADD KEY `DogID` (`DogID`),
  ADD KEY `VaccineID` (`VaccineID`);

--
-- Indexes for table `vaccination_appointments`
--
ALTER TABLE `vaccination_appointments`
  ADD PRIMARY KEY (`AppointmentID`),
  ADD KEY `DogID` (`DogID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `VaccineID` (`VaccineID`);

--
-- Indexes for table `vaccination_schedule`
--
ALTER TABLE `vaccination_schedule`
  ADD PRIMARY KEY (`EventID`);

--
-- Indexes for table `vaccines`
--
ALTER TABLE `vaccines`
  ADD PRIMARY KEY (`VaccineID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activitylogs`
--
ALTER TABLE `activitylogs`
  MODIFY `LogID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `AppointmentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `dogs`
--
ALTER TABLE `dogs`
  MODIFY `DogID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `NotificationID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `ReportID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `vaccinationrecords`
--
ALTER TABLE `vaccinationrecords`
  MODIFY `RecordID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `vaccination_appointments`
--
ALTER TABLE `vaccination_appointments`
  MODIFY `AppointmentID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vaccination_schedule`
--
ALTER TABLE `vaccination_schedule`
  MODIFY `EventID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vaccines`
--
ALTER TABLE `vaccines`
  MODIFY `VaccineID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activitylogs`
--
ALTER TABLE `activitylogs`
  ADD CONSTRAINT `activitylogs_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`DogID`) REFERENCES `dogs` (`DogID`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`VaccineID`) REFERENCES `vaccines` (`VaccineID`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE;

--
-- Constraints for table `vaccinationrecords`
--
ALTER TABLE `vaccinationrecords`
  ADD CONSTRAINT `vaccinationrecords_ibfk_1` FOREIGN KEY (`DogID`) REFERENCES `dogs` (`DogID`),
  ADD CONSTRAINT `vaccinationrecords_ibfk_2` FOREIGN KEY (`VaccineID`) REFERENCES `vaccines` (`VaccineID`);

--
-- Constraints for table `vaccination_appointments`
--
ALTER TABLE `vaccination_appointments`
  ADD CONSTRAINT `vaccination_appointments_ibfk_1` FOREIGN KEY (`DogID`) REFERENCES `dogs` (`DogID`) ON DELETE CASCADE,
  ADD CONSTRAINT `vaccination_appointments_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE,
  ADD CONSTRAINT `vaccination_appointments_ibfk_3` FOREIGN KEY (`VaccineID`) REFERENCES `vaccines` (`VaccineID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
