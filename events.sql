-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 19, 2025 at 01:54 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eventease`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `organizer_id` int(11) DEFAULT NULL,
  `allow_registration` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `title`, `description`, `datetime`, `capacity`, `location`, `organizer_id`, `allow_registration`) VALUES
(2, 'Hari Jadi Amir', 'Saya Amirzz', '2025-08-12 19:00:00', 2500, 'Taman Rumbia', 1, 1),
(4, 'Hari jadi Issei', 'sadfasdf', '2024-01-10 19:00:00', 2500, 'Taman Bera', 1, 1),
(5, 'hari lahir issse', 'amir hensem', '2024-11-06 05:00:00', 2500, '12121', 1, 1),
(6, 'Amir', 'asdfda', '2025-07-19 21:30:00', 243, 'Sunway Lagoon', 1, 1),
(7, 'Kill', 'anime', '2025-07-20 09:30:00', 21, 'KLCC', 1, 1),
(8, 'beli nasi', 'harith = ayam\namir = bihun sup\nrahman = nasi kerabu\nissei = bihun sup', '2025-07-18 02:25:00', 5, 'taman vista belimbing', 1, 1),
(9, 'fdsfsd', 'fdsasadf', '2025-07-11 16:40:00', 23, 'KLCC, 156, Jalan Ampang, Kampung Paya, Bukit Bintang, Kuala Lumpur, 50088, Malaysia', 1, 1),
(10, 'dfgdzf', 'gdfgdsfgs', '2025-07-19 09:00:00', 24, 'sdf', 1, 1),
(11, 'amidfaag', 'asdagafgadfga', '2025-07-19 21:30:00', 24, 'Universiti Teknikal Malaysia Melaka (UTeM) Main Campus, Jalan UTEM, Majlis Perbandaran Hang Tuah Jaya, Alor Gajah, Melaka, 76100, Malaysia', 1, 1),
(12, 'afasdg', 'fdgdfgfad', '2025-08-03 05:25:00', 23, 'adsf', 1, 0),
(13, 'Amirdsf', 'Lala\\', '2025-08-10 07:40:00', 2, 'dsaf', 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `organizer_id` (`organizer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`organizer_id`) REFERENCES `organizers` (`organizer_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
