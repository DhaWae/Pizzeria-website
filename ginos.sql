-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3308
-- Generation Time: Jan 18, 2024 at 01:26 PM
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
-- Database: `ginos`
--

-- --------------------------------------------------------

--
-- Table structure for table `ginos_user_information`
--

CREATE TABLE `ginos_user_information` (
  `id` int(11) NOT NULL,
  `registration_date` date NOT NULL,
  `first_name` varchar(128) NOT NULL,
  `last_name` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `phone` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ginos_user_information`
--

INSERT INTO `ginos_user_information` (`id`, `registration_date`, `first_name`, `last_name`, `email`, `phone`, `password`) VALUES
(1, '2023-10-04', 'Daniel', 'Karlsson', 'danielkarlsson@gmail.com', '0738328828', '$2y$10$02EmRjycGvAPRtOPTAd27Ot/JYgTFNh1lLqqpv8DtkRsqwfex3lh2'),
(2, '2023-10-04', 'asf', 'asf', 'apsd@gmail.com', 'asf', '$2y$10$wyyEBluDIr/uhkGj0kU4m.bLjLdOQk5xobavCVXxzt7l6rmK9lbc2'),
(3, '2023-10-04', 'je', 'he', 'asde@gmail.com', '932', '$2y$10$hO7Nn5tnSojXlCe8KiVwBelppa1germaLhFxalOPU6AaowA1CRbv2'),
(4, '2023-10-04', 'Jesper', 'Rudegran', 'jesperrudegran@gmail.com', '0738328828', '$2y$10$XXPVQSf6E0FoB/pjB/cv.O8dXLCtGw0M.KTM5qpDtrS9VrFt7ZP8C'),
(5, '2023-10-04', 'a', 'v', 'abc@gmail.com', '2', '$2y$10$o7dLnMQ1MA9kCOu6smN4GOmv2HSH5Few25f4NSqAQEtye2BRc4NI6'),
(6, '2023-10-04', 'iasn', 'iasnd', '1234@gmail.com', '312', '$2y$10$i7R0tLn3x4EfjMpDtUit9OwKGZ7AD3QM/G/1gCfvQqiLeOnWiyxuy'),
(7, '2023-10-04', 'asd', 'asd', 'asd231@gmail.com', '073-832-8828', '$2y$10$1NRbXUMtOqvyUey0BlW/7OUmNgb7RtqNuEF6kLxyf/CI0jyMqJ3/W'),
(8, '2023-10-04', 'Albert', 'Albertsson', 'albert@gmail.com', '0259238828', '$2y$10$38EtCU9IdhwGet8jOA2TGOI4yww5VjLxnoCDtm6UdMCbnfSgPRbQK'),
(9, '2023-10-05', 'Victor', 'Andersson', 'victor.andersson2@proton.me', '070123123123', '$2y$10$dPokyA7hEOw8UrU/qBZlsep.fcMrPppfWU.BbLRcbjSQF6j/OMLSO'),
(10, '2023-10-05', 'Sture', 'Larsson', 'hejhej@gmail.com', '382944892308', '$2y$10$L6o9aUFuvQgG3emEchFEPe7P9mYzONIkIU5xtod8vyHsk.r8aNTC2'),
(11, '2023-10-05', 'Petter', 'Forslund', 'petter@petter.se', '0701234567', '$2y$10$etFMv0zBCxR/h/WzgpmMNuJVRHiZxp0yCfUUlqlIXQj/CjoW8.3tS');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ginos_user_information`
--
ALTER TABLE `ginos_user_information`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ginos_user_information`
--
ALTER TABLE `ginos_user_information`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
