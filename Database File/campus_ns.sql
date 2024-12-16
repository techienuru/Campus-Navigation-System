-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 10, 2024 at 03:06 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `campus_ns`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `email`, `password`, `date_added`) VALUES
(1, 'admin@gmail.com', '1', '2024-10-05 12:04:57');

-- --------------------------------------------------------

--
-- Table structure for table `navigation`
--

CREATE TABLE `navigation` (
  `navigation_id` int(255) NOT NULL,
  `location` int(255) DEFAULT NULL,
  `destination` int(255) DEFAULT NULL,
  `direction` varchar(5000) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `navigation`
--

INSERT INTO `navigation` (`navigation_id`, `location`, `destination`, `direction`, `date_added`) VALUES
(3, NULL, NULL, '1. Step out of Mande Hostel. 2. Turn left and Walk straight for 2 meters and Main Hall back door entrance will be in your front.', '2024-10-11 11:59:42'),
(4, NULL, NULL, 'Step 1', '2024-10-11 20:59:06'),
(5, 11, 13, 'After entering through the Main Gate, proceed straight ahead on the main road. Continue walking or driving along the main road, passing several campus buildings on your left and right. After a short distance, you will reach a roundabout. At the roundabout, go straight through the roundabout (12 oâ€™clock direction). Continue straight on this road untill you see a sign board with a label \"Department of Computer Science\". Take your left and You will see the Department ahead, easily recognizable by its prominent architecture. Proceed towards the Building and you have now reached your destination.', '2024-10-18 07:28:24'),
(6, 11, 12, 'After entering through the Main Gate, proceed straight ahead on the main road. Continue walking or driving along the main road, passing several campus buildings on your left and right. After a short distance, you will reach a roundabout. At the roundabout, take the right exit (3 oâ€™clock direction). Continue straight on this road for short distance and you will see a sign board with a label \"Senate Building\". Take your left and You will see the Senate building ahead, easily recognizable by its prominent architecture. Proceed towards the Building and you have now reached your destination.', '2024-10-18 07:34:02');

-- --------------------------------------------------------

--
-- Table structure for table `places`
--

CREATE TABLE `places` (
  `place_id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `description` varchar(6000) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `places`
--

INSERT INTO `places` (`place_id`, `name`, `image_name`, `description`, `date_added`) VALUES
(11, 'Main Gate', 'NSUK Main gate.jpg', 'The Main Gate of Nasarawa State University, Keffi (NSUK) serves as the primary entrance to the campus. It is a notable landmark that welcomes students, staff, and visitors into the university environment. The gate is well-guarded and monitored for security purposes, ensuring the safety of everyone entering or leaving the campus', '2024-10-18 06:40:40'),
(12, 'Senate Building', 'NSUK Senate Building.jpg', 'The Senate Building of Nasarawa State University, Keffi (NSUK) is the administrative heart of the institution. It houses the offices of the Vice-Chancellor, key administrative departments, and the universityâ€™s governing bodies. The building is central to decision-making processes that shape the direction of the university. With its distinctive architecture and strategic location, the Senate Building symbolizes leadership, governance, and the universityâ€™s commitment to maintaining high academic and administrative standards.', '2024-10-18 06:43:31'),
(13, 'Department of Computer Science', 'NSUK Department of Computer Science.jpg', 'The Computer Science Department at Nasarawa State University, Keffi (NSUK) is a hub of innovation and technological learning. It offers a range of programs designed to equip students with in-demand skills in programming, software development, and data science. The department boasts modern computer labs and experienced faculty members who are committed to nurturing the next generation of tech professionals. With a strong emphasis on research and practical application, the Computer Science Department is dedicated to advancing knowledge in the ever-evolving field of technology.', '2024-10-18 06:45:09'),
(14, 'Old Central Mosque', 'New mssn mosque.jpg', 'The Old Central Mosque at Nasarawa State University, Keffi (NSUK) is an important spiritual landmark for the Muslim community on campus. It provides a serene and peaceful environment for students, staff, and visitors to perform their daily prayers. The mosque, known for its historical significance, has served the NSUK community for many years and continues to be a gathering place for worship, reflection, and community events. Its central location makes it easily accessible to all members of the university community.', '2024-10-18 06:49:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `navigation`
--
ALTER TABLE `navigation`
  ADD PRIMARY KEY (`navigation_id`),
  ADD KEY `fk_navigation_location` (`location`),
  ADD KEY `fk_navigation_destination` (`destination`);

--
-- Indexes for table `places`
--
ALTER TABLE `places`
  ADD PRIMARY KEY (`place_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `navigation`
--
ALTER TABLE `navigation`
  MODIFY `navigation_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `places`
--
ALTER TABLE `places`
  MODIFY `place_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `navigation`
--
ALTER TABLE `navigation`
  ADD CONSTRAINT `fk_navigation_destination` FOREIGN KEY (`destination`) REFERENCES `places` (`place_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_navigation_location` FOREIGN KEY (`location`) REFERENCES `places` (`place_id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
