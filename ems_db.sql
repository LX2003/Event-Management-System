-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 20, 2025 at 02:40 PM
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
(2, 'Hari Jadi Amir', 'Saya Amirzz', '2025-08-12 19:00:00', 2500, 'Taman Vista Belimbing, Alor Gajah, Melaka, Malaysia', 1, 1),
(8, 'Hari Raya ', 'Aidilfitri', '2025-07-18 02:25:00', 300, 'Universiti Teknikal Malaysia Melaka', 1, 1),
(14, 'Festival UTeM', 'University Festival', '2025-07-21 11:00:00', 3000, 'Universiti Teknikal Malaysia Melaka (UTeM) Main Campus, Jalan UTEM, Majlis Perbandaran Hang Tuah Jaya, Alor Gajah, Melaka, 76100, Malaysia', 1, 1),
(16, 'UTeM Innovation Day 2025', 'UTeM Innovation Day is a flagship event showcasing student and staff innovations, research projects, and startup ideas.\n\n🗓️ Schedule:\n09:00 AM - Opening Ceremony by Vice Chancellor\n09:30 AM - Keynote: \"Smart Cities & IoT\" by Dr. Aina Rashid\n11:00 AM - Innovation Exhibition (Hall B)\n01:00 PM - Networking Lunch (Cafeteria)\n02:30 PM - Panel: \"AI & Ethics in Education\"\n04:00 PM - Award Ceremony for Best Innovations\n05:00 PM - Closing Remarks\n\n🎁 Free merchandise and lunch provided. Open to students, staff, and industry guests.', '2025-09-25 09:00:00', 300, 'Chancellor Hall, UTeM City Campus, Melaka', 1, 1),
(17, 'Career Launchpad 2025 – Job Fair & Resume Clinic', 'Kickstart your career with our annual Career Launchpad featuring top Malaysian employers, internship opportunities, and career development workshops.\n\n🗓️ Event Schedule:\n09:00 AM - Company Booths Open (Main Hall)\n10:30 AM - Resume & LinkedIn Profile Review (Room A2)\n12:00 PM - Lunch Break & Networking Games\n01:30 PM - Talk: \"Nailing Your First Job Interview\" by Shopee HR Team\n03:00 PM - Mock Interview Session (Sign-up Required)\n04:30 PM - Door Gift Distribution & Feedback Collection\n\n✅ Dress code: Formal. Bring printed resumes. Free participation for all students.', '2025-10-10 09:00:00', 250, 'Dewan Kuliah 1, Faculty of Technology Management, UTeM', 1, 1),
(18, 'TechTalk 2024 – Future of AI', 'Join us for a compelling tech talk on the future of Artificial Intelligence in Malaysia.\n\n🗓️ Schedule:\n09:00 AM - Registration & Breakfast\n10:00 AM - Keynote: \"AI in Everyday Life\" by Dr. Noraini Yahya\n11:30 AM - Panel Discussion: \"Balancing Innovation & Privacy\"\n01:00 PM - Networking Lunch\n02:30 PM - Industry Showcase (Microsoft, Petronas, Grab)\n04:00 PM - Closing Remarks\n\n🎓 Open to all students and lecturers. CPD certificate provided upon request.', '2024-10-15 09:00:00', 200, 'Auditorium A, UTeM Main Campus', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `rating` tinyint(4) DEFAULT NULL,
  `comment` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedback_id`, `student_id`, `event_id`, `rating`, `comment`) VALUES
(2, 4, 18, 5, 'good event');

-- --------------------------------------------------------

--
-- Table structure for table `organizers`
--

CREATE TABLE `organizers` (
  `organizer_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `organization` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `organizers`
--

INSERT INTO `organizers` (`organizer_id`, `user_id`, `organization`, `phone`) VALUES
(1, 1, 'PERMATA', '0137529380'),
(2, 5, 'UTeM', '0165369423');

-- --------------------------------------------------------

--
-- Table structure for table `registrations`
--

CREATE TABLE `registrations` (
  `reg_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `status` enum('registered') DEFAULT 'registered'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registrations`
--

INSERT INTO `registrations` (`reg_id`, `student_id`, `event_id`, `status`) VALUES
(9, 4, 2, 'registered'),
(10, 4, 14, 'registered'),
(11, 4, 16, 'registered'),
(12, 4, 17, 'registered'),
(14, 4, 18, 'registered');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `student_number` varchar(50) DEFAULT NULL,
  `course` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `user_id`, `student_number`, `course`) VALUES
(4, 7, 'B032310670', 'BITS');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password_hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password_hash`) VALUES
(1, 'amir123', 'amir123', '$2y$10$wwlf79d9NY8b50dLpBvwx.IRjGWhCqLgL9vUH1rhdLGah/UNHVlYG'),
(5, 'Harith', 'harithsharizal@gmail.com', '$2y$10$iJmoWXaXfxvlP3bNk1kd/ekScVgIWQzPhdk6wnlB2bGxdImRXPJOq'),
(7, 'Amir Lutfi', 'amir123@gmail.com', '$2y$10$8vEUQRnplLeW1xefjzem9upem6A868zpoooTok0XnbIfb8j3Lm3iC');

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
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `organizers`
--
ALTER TABLE `organizers`
  ADD PRIMARY KEY (`organizer_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `registrations`
--
ALTER TABLE `registrations`
  ADD PRIMARY KEY (`reg_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `organizers`
--
ALTER TABLE `organizers`
  MODIFY `organizer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `registrations`
--
ALTER TABLE `registrations`
  MODIFY `reg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`organizer_id`) REFERENCES `organizers` (`organizer_id`) ON DELETE CASCADE;

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `feedback_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE;

--
-- Constraints for table `organizers`
--
ALTER TABLE `organizers`
  ADD CONSTRAINT `organizers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `registrations`
--
ALTER TABLE `registrations`
  ADD CONSTRAINT `registrations_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `registrations_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
