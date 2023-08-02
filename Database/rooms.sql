-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Gazdă: 127.0.0.1
-- Timp de generare: aug. 02, 2023 la 04:43 PM
-- Versiune server: 10.4.27-MariaDB
-- Versiune PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Bază de date: `hotelbooking`
--

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `rooms`
--

CREATE TABLE `rooms` (
  `RoomID` int(11) NOT NULL,
  `HotelID` int(11) NOT NULL,
  `RoomNumber` varchar(10) NOT NULL,
  `Type` varchar(100) NOT NULL,
  `Price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `rooms`
--

INSERT INTO `rooms` (`RoomID`, `HotelID`, `RoomNumber`, `Type`, `Price`) VALUES
(1, 1, '101', 'Standard', '100.00'),
(2, 1, '102', 'Standard', '100.00'),
(3, 1, '201', 'Deluxe', '150.00'),
(4, 2, '201', 'Standard', '120.00'),
(5, 2, '202', 'Deluxe', '180.00'),
(6, 3, '301', 'Standard', '110.00'),
(7, 3, '302', 'Deluxe', '160.00');

--
-- Indexuri pentru tabele eliminate
--

--
-- Indexuri pentru tabele `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`RoomID`),
  ADD KEY `FK_Rooms_Hotels` (`HotelID`);

--
-- AUTO_INCREMENT pentru tabele eliminate
--

--
-- AUTO_INCREMENT pentru tabele `rooms`
--
ALTER TABLE `rooms`
  MODIFY `RoomID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constrângeri pentru tabele eliminate
--

--
-- Constrângeri pentru tabele `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `FK_Rooms_Hotels` FOREIGN KEY (`HotelID`) REFERENCES `hotels` (`HotelID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
