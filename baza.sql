-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 06, 2024 at 04:32 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `baza`
--

-- --------------------------------------------------------

--
-- Table structure for table `grupe_zadataka`
--

CREATE TABLE `grupe_zadataka` (
  `id` int(10) UNSIGNED NOT NULL,
  `naziv` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `grupe_zadataka`
--

INSERT INTO `grupe_zadataka` (`id`, `naziv`) VALUES
(1, 'Prva grupa'),
(2, 'Druga grupa'),
(4, 'Prodaja'),
(7, 'HR'),
(13, 'IT sektor'),
(17, 'Marketing'),
(18, 'Nabavka'),
(19, 'Test Admin'),
(21, 'konferencija');

-- --------------------------------------------------------

--
-- Table structure for table `komentari`
--

CREATE TABLE `komentari` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_zadatka` int(10) UNSIGNED NOT NULL,
  `id_korisnika` int(10) UNSIGNED NOT NULL,
  `sadrzaj` varchar(150) NOT NULL,
  `kreirano` timestamp NOT NULL DEFAULT current_timestamp(),
  `izmenjeno` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `komentari`
--

INSERT INTO `komentari` (`id`, `id_zadatka`, `id_korisnika`, `sadrzaj`, `kreirano`, `izmenjeno`) VALUES
(1, 2, 2, 'Inovativan pristup.', '2024-05-26 00:26:39', NULL),
(2, 2, 14, 'super!', '2024-06-02 02:47:04', NULL),
(14, 2, 4, 'test', '2024-06-04 01:54:00', NULL),
(41, 10, 36, 'komentar', '2024-06-04 22:07:46', NULL),
(42, 10, 2, 'test komentar', '2024-06-04 22:07:59', NULL),
(43, 17, 2, 'test', '2024-06-04 16:16:00', NULL),
(44, 17, 1, 'test', '2024-06-04 21:35:00', NULL),
(46, 35, 1, 'Test izmena', '2024-06-05 17:29:00', '2024-06-05 17:33:30'),
(47, 17, 37, 'komentar', '2024-06-06 00:24:00', NULL),
(48, 17, 37, 'test\n', '2024-06-06 00:31:00', NULL),
(50, 14, 2, 'Izmena komentara', '2024-06-06 00:45:00', '2024-06-06 01:03:16'),
(51, 57, 53, 'kom', '2024-06-06 01:06:00', NULL),
(52, 57, 53, 'kom', '2024-06-06 01:06:00', NULL),
(60, 2, 1, 'test', '2024-06-06 01:35:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `korisnici`
--

CREATE TABLE `korisnici` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(80) NOT NULL,
  `ime_prezime` varchar(80) NOT NULL,
  `id_tip_korisnika` tinyint(4) UNSIGNED NOT NULL,
  `broj_telefona` varchar(30) DEFAULT NULL,
  `datum_rodjenja` date DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Nije verifikovan',
  `token` varchar(70) DEFAULT NULL,
  `token_pass` varchar(70) DEFAULT NULL,
  `token_pass_vreme` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `korisnici`
--

INSERT INTO `korisnici` (`id`, `username`, `password`, `email`, `ime_prezime`, `id_tip_korisnika`, `broj_telefona`, `datum_rodjenja`, `status`, `token`, `token_pass`, `token_pass_vreme`) VALUES
(1, 'admin', 'c7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3eab1d80b931dd472634dfac71cd34ebc35d16ab7fb8a90c81f975113d6c7538dc69dd8de9077ec', 'admin@gmail.com', 'Admin', 1, NULL, NULL, 'Verifikovan', NULL, NULL, '2024-06-01 20:36:53'),
(2, 'marko', '9af7108eee30db682ac0b879a40402997031cb424913e1b8df1db64c9eeb06176dffa8d88dccc96f89e9dd28fc71dcde65a048dc194b6b5710d6a6a227cfb1bc', 'marko.markovic@gmail.com', 'Marko Marković', 2, '062333666', '2000-12-15', 'Verifikovan', NULL, NULL, '2024-06-01 20:36:53'),
(3, 'milica', '9af7108eee30db682ac0b879a40402997031cb424913e1b8df1db64c9eeb06176dffa8d88dccc96f89e9dd28fc71dcde65a048dc194b6b5710d6a6a227cfb1bc', 'milica.lazic@gmail.com', 'Milica Lazić', 2, '063888333', '2001-05-28', 'Verifikovan', NULL, NULL, '2024-06-01 20:36:53'),
(4, 'aleksa', '9af7108eee30db682ac0b879a40402997031cb424913e1b8df1db64c9eeb06176dffa8d88dccc96f89e9dd28fc71dcde65a048dc194b6b5710d6a6a227cfb1bc', 'aleksa@gmail.com', 'Aleksa Stanković', 3, '0651212121', '1996-05-29', 'Verifikovan', NULL, NULL, '2024-06-01 20:36:53'),
(14, 'tamara', '9af7108eee30db682ac0b879a40402997031cb424913e1b8df1db64c9eeb06176dffa8d88dccc96f89e9dd28fc71dcde65a048dc194b6b5710d6a6a227cfb1bc', 'tamara@gmail.com', 'Tamara Janković', 3, '0635544665', '1997-02-20', 'Verifikovan', NULL, NULL, '2024-06-01 20:36:53'),
(36, 'sandra', '9af7108eee30db682ac0b879a40402997031cb424913e1b8df1db64c9eeb06176dffa8d88dccc96f89e9dd28fc71dcde65a048dc194b6b5710d6a6a227cfb1bc', 'aleksandramrdjen73@gmail.com', 'Aleksandra Mrdjen', 3, NULL, NULL, 'Verifikovan', '491fc612659f6db23a5320fcff52364fb867746db32594b9139722014c3c20de', NULL, '2024-06-01 20:36:53'),
(37, 'emilija', '9af7108eee30db682ac0b879a40402997031cb424913e1b8df1db64c9eeb06176dffa8d88dccc96f89e9dd28fc71dcde65a048dc194b6b5710d6a6a227cfb1bc', 'emilijastt@gmail.com', 'Emilija Stojković\r\n', 3, NULL, NULL, 'Verifikovan', 'ecab8d63467f6eb40c949dbb15278d4a74fe43244762f2bd11797a61ac1e3eee', NULL, '2024-06-01 20:36:53'),
(41, 'tatjana', '9af7108eee30db682ac0b879a40402997031cb424913e1b8df1db64c9eeb06176dffa8d88dccc96f89e9dd28fc71dcde65a048dc194b6b5710d6a6a227cfb1bc', 'tatjana@tanja.com', 'Tatjana Ristić', 2, NULL, NULL, 'Verifikovan', NULL, NULL, NULL),
(53, 'kristina', '5b722b307fce6c944905d132691d5e4a2214b7fe92b738920eb3fce3a90420a19511c3010a0e7712b054daef5b57bad59ecbd93b3280f210578f547f4aed4d25', 'kristina@gmail.com', 'Kristina Teofilović', 3, '0638383333', '2001-05-28', 'Verifikovan', '1036b3e42765008957f5eec0810c53846f73fe01bce62892a6270219c41451da', 'adf16a5520b8872370e453ebd844cb1159cb6cf1f8568f820de29f10a9fb928d', '2024-06-06 02:18:06');

-- --------------------------------------------------------

--
-- Table structure for table `tipovi_korisnika`
--

CREATE TABLE `tipovi_korisnika` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `naziv` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tipovi_korisnika`
--

INSERT INTO `tipovi_korisnika` (`id`, `naziv`) VALUES
(1, 'Administrator'),
(4, 'Gost'),
(7, 'Gosti'),
(3, 'Izvrsilac'),
(2, 'Rukovodilac odeljenja');

-- --------------------------------------------------------

--
-- Table structure for table `zadaci`
--

CREATE TABLE `zadaci` (
  `id` int(10) UNSIGNED NOT NULL,
  `naslov` varchar(191) NOT NULL,
  `opis` varchar(1000) NOT NULL,
  `lista_izvrsioca` varchar(100) NOT NULL,
  `rukovodilac` varchar(100) NOT NULL,
  `rok_izvrsenja` datetime NOT NULL,
  `prioritet` int(10) NOT NULL,
  `id_grupe` int(10) UNSIGNED NOT NULL,
  `fajl` varchar(300) NOT NULL,
  `status` varchar(9) NOT NULL DEFAULT 'nezavršen'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `zadaci`
--

INSERT INTO `zadaci` (`id`, `naslov`, `opis`, `lista_izvrsioca`, `rukovodilac`, `rok_izvrsenja`, `prioritet`, `id_grupe`, `fajl`, `status`) VALUES
(2, 'Dizajn za stranicu', 'dizajn za početnu stranicu projekta', '4', '3', '2024-05-30 23:32:13', 10, 1, 'files/Politika-kvaliteta.pdf', 'završen'),
(10, 'Test zadatak', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Eget felis eget nunc lobortis. Facilisis volutpat est velit egestas. Scelerisque mauris pellentesque pulvinar pellentesque habitant morbi tristique senectus. Lectus urna duis convallis convallis tellus id interdum velit laoreet. Lorem ipsum dolor sit amet consectetur adipiscing elit ut aliquam. Leo in vitae turpis massa sed elementum. Quam viverra orci sagittis eu. Hac habi', '4,36', '2', '2024-06-05 20:28:00', 5, 1, 'files/NTP_ElevatorPitch (1).pdf', 'završen'),
(14, 'Majice', 'majice', '37', '2', '2024-06-29 16:22:03', 8, 18, 'files/3.png', 'otkazan'),
(17, 'Trening praktikanata', 'Trening na Zlatiboru', '14,37', '2', '2024-08-08 07:08:00', 6, 7, 'files/test.jpg', 'završen'),
(35, 'Takmičenje košarka', 'Takmičenje 3x3 disciplina', '37', '2', '2024-06-08 01:18:00', 7, 4, 'files/4.jpg', 'završen'),
(57, 'Projekat PPP2', 'ppp2', '53', '2', '2024-06-08 02:52:00', 8, 13, 'files/0.jpg', 'nezavršen');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `grupe_zadataka`
--
ALTER TABLE `grupe_zadataka`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `komentari`
--
ALTER TABLE `komentari`
  ADD PRIMARY KEY (`id`),
  ADD KEY `un_id_zadatka` (`id_zadatka`),
  ADD KEY `un_id_korisnika` (`id_korisnika`) USING BTREE;

--
-- Indexes for table `korisnici`
--
ALTER TABLE `korisnici`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `un_username` (`username`),
  ADD UNIQUE KEY `un_email` (`email`),
  ADD KEY `id_uloga` (`id_tip_korisnika`);

--
-- Indexes for table `tipovi_korisnika`
--
ALTER TABLE `tipovi_korisnika`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `un_naziv` (`naziv`);

--
-- Indexes for table `zadaci`
--
ALTER TABLE `zadaci`
  ADD PRIMARY KEY (`id`),
  ADD KEY `un_id_grupe` (`id_grupe`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `grupe_zadataka`
--
ALTER TABLE `grupe_zadataka`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `komentari`
--
ALTER TABLE `komentari`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `korisnici`
--
ALTER TABLE `korisnici`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `tipovi_korisnika`
--
ALTER TABLE `tipovi_korisnika`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `zadaci`
--
ALTER TABLE `zadaci`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `komentari`
--
ALTER TABLE `komentari`
  ADD CONSTRAINT `komentari_ibfk_1` FOREIGN KEY (`id_korisnika`) REFERENCES `korisnici` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `komentari_ibfk_2` FOREIGN KEY (`id_zadatka`) REFERENCES `zadaci` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `korisnici`
--
ALTER TABLE `korisnici`
  ADD CONSTRAINT `korisnici_ibfk_1` FOREIGN KEY (`id_tip_korisnika`) REFERENCES `tipovi_korisnika` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `zadaci`
--
ALTER TABLE `zadaci`
  ADD CONSTRAINT `zadaci_ibfk_1` FOREIGN KEY (`id_grupe`) REFERENCES `grupe_zadataka` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
