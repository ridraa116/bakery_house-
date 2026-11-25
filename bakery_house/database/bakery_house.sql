-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 04, 2025 at 12:06 PM
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
-- Database: `bakery_house`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `username`, `password`) VALUES
(11, 'ridra', '$2y$10$R4CS4Or1mZM43rHDp.3Ou.3W2qVi02H2I2hImmMGjQwxmrmnGaGGa'),
(12, 'qwerty', '$2y$10$ynVtKkPXhKAy7F5zEbuva.RoyAZvdSeJ09XecdLmIi5a16L0hvCRm');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `no_transaksi` int(11) NOT NULL,
  `id` int(11) DEFAULT NULL,
  `id_prod` int(11) DEFAULT NULL,
  `nama_prod` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `jumlah` int(11) DEFAULT 1,
  `metode` varchar(50) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `no_hp` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`no_transaksi`, `id`, `id_prod`, `nama_prod`, `price`, `gambar`, `jumlah`, `metode`, `alamat`, `no_hp`) VALUES
(6, 5, NULL, 'Cupcake Buah Segar - “Fruit Garden Cupcakes”', 60000.00, 'prod5.jpg', 1, 'COD', '11', NULL),
(7, 6, NULL, 'Cupcake Buah Segar - “Fruit Garden Cupcakes”', 50000.00, 'prod5.jpg', 2, 'COD', 'qwqw', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id_prod` int(11) NOT NULL,
  `nama_prod` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `sold` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id_prod`, `nama_prod`, `price`, `deskripsi`, `gambar`, `sold`) VALUES
(2, 'Mochi Ice Cream Box - “Mochi Me Happy”', 60000.00, 'Varian rasa: Strawberry Milk, Chocolate Crunch, dan Bubblegum Cream.\nIsian: Es krim lembut yang dibalut mochi kenyal khas Jepang.\nDilengkapi saus celup: vanilla dan choco dip.', 'prod1.jpg', 10),
(3, 'Puding Mini Premium - “ChocoLuxe Pudding Bites”', 45000.00, 'Puding kombinasi rasa vanilla, coklat, dan mocca.\nTopping: Oreo, Choco Chip, dan mini cookies.\nCocok untuk hampers atau snack box elegan.', 'prod2.jpg', 1),
(4, 'Donat Glaze Warna-warni - “Donat Ceria”', 35000.00, 'Donat lembut, fresh made setiap hari.\nTopping: Choco Cheese, Red Velvet Crumble, Vanilla Oreo, Sprinkle Ungu, dan Kacang Cokelat.\nTanpa pengawet, bisa request varian.', 'prod3.jpg', 0),
(5, 'Rainbow Slice Cake - “Slice of Joy”', 90000.00, 'Rasa: Taro, Matcha, Mango, Red Velvet, Strawberry, dan Vanilla.\nDekorasi: Whipped cream, buah segar, dan edible flower.\nPas untuk ulang tahun, arisan, atau bingkisan spesial.', 'prod4.jpg', 0),
(6, 'Cupcake Buah Segar - “Fruit Garden Cupcakes”', 50000.00, 'Base cupcake: vanilla dan cokelat.\r\nFrosting: Cream cheese dan choco swirl.\r\nTopping: Buah segar (stroberi, kiwi, blueberry, golden berry).\r\nManisnya pas, segarnya nyata!', 'prod5.jpg', 17);

-- --------------------------------------------------------

--
-- Table structure for table `seller`
--

CREATE TABLE `seller` (
  `id_seller` int(11) NOT NULL,
  `username_seller` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seller`
--

INSERT INTO `seller` (`id_seller`, `username_seller`, `password`) VALUES
(4, '12', '$2y$10$xMcScXMla0IdGVBikBnHRu/YxKZ4le2OqXx6V7qPrVymXvA0HhLPO'),
(5, 'rw', '$2y$10$799EdxeF71/1XZSvKfI0Be4othMSnoisV/0eP5SQaRdD0lGMf178i');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`no_transaksi`),
  ADD KEY `id` (`id`),
  ADD KEY `id_prod` (`id_prod`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id_prod`),
  ADD UNIQUE KEY `nama_prod` (`nama_prod`);

--
-- Indexes for table `seller`
--
ALTER TABLE `seller`
  ADD PRIMARY KEY (`id_seller`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `no_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id_prod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `seller`
--
ALTER TABLE `seller`
  MODIFY `id_seller` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`id_prod`) REFERENCES `products` (`id_prod`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
