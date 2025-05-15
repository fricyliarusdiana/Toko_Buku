-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2025 at 06:39 AM
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
-- Database: `db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`) VALUES
(3, 'brey', '$2y$10$3dejviK2sH/2qAdBjgzuLePnIe00Aa0aeKSVwPsSxT/fxdB.VWVse'),
(4, 'admin', '$2y$10$EochjEx60o0FB0xKkr6xPeR3xaIZpEujqiCHp7KFjaM/FHIwovgOi'),
(7, 'admin1', '$2y$10$kqyT/sA/1rXNDDXprcKq/eReonY.2Ei6CN/OuFTfQFOuX5TX2Z4Fa');

-- --------------------------------------------------------

--
-- Table structure for table `detail_pesanan`
--

CREATE TABLE `detail_pesanan` (
  `id_detail` int(11) NOT NULL,
  `id_pesanan` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_pesanan`
--

INSERT INTO `detail_pesanan` (`id_detail`, `id_pesanan`, `id_produk`, `jumlah`, `harga`) VALUES
(24, 15, 17, 1, 90000),
(25, 16, 13, 1, 0),
(26, 16, 14, 1, 0),
(27, 16, 18, 1, 0),
(28, 16, 23, 1, 85000),
(32, 17, 23, 1, 85000),
(33, 18, 31, 1, 70000);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
(1, 'Fiksi'),
(4, 'Politik'),
(5, 'Resep');

-- --------------------------------------------------------

--
-- Table structure for table `keranjang`
--

CREATE TABLE `keranjang` (
  `id_keranjang` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `jumlah` int(11) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `keranjang`
--

INSERT INTO `keranjang` (`id_keranjang`, `id_user`, `id_produk`, `jumlah`, `created_at`) VALUES
(27, 6, 31, 1, '2025-05-15 03:28:30'),
(28, 6, 30, 1, '2025-05-15 03:30:24');

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `alamat` text NOT NULL,
  `metode_pembayaran` varchar(50) NOT NULL,
  `bukti_transfer` varchar(255) DEFAULT NULL,
  `total` int(11) NOT NULL,
  `status` enum('pending','diproses','dikirim','selesai') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id_pesanan`, `id_user`, `alamat`, `metode_pembayaran`, `bukti_transfer`, `total`, `status`, `created_at`) VALUES
(16, 5, 'Jl. Merdeka Barat, No 15.', 'transfer_bank', 'TRF-5-1747272370.jpg', 85000, 'dikirim', '2025-05-15 01:26:10'),
(17, 6, 'Jl. Kp. Sumur, No 17, Jakarta Timur', 'transfer_bank', 'TRF-6-1747273140.jpg', 85000, 'pending', '2025-05-15 01:39:00'),
(18, 6, 'Jl. Kp. Sumur, No 17, Jakarta Timur', 'transfer_bank', 'TRF-6-1747279359.jpg', 70000, 'pending', '2025-05-15 03:22:39');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `gambar` varchar(200) NOT NULL,
  `harga` int(11) NOT NULL,
  `deskripsi` text NOT NULL,
  `stok` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `nama_produk`, `id_kategori`, `gambar`, `harga`, `deskripsi`, `stok`) VALUES
(26, 'Ayah', 1, 'ayah.jpg', 130000, 'Menceritakan perjuangan dan kasih sayang seorang ayah terhadap anaknya, tanpa mengenal ikatan darah.', 170),
(30, 'Perahu Kertas', 1, 'perahu kertas.jpg', 70000, 'Novel yang menceritakan kisah 3 remaja bersahabat', 100),
(31, 'Rahasia Resep', 5, 'resep.jpg', 70000, 'Resep-resep nusantara', 245),
(32, 'Ilmu Politik', 4, 'politik.jpeg', 150000, 'Ilmu politik dasar sebagai pedoman pembelajaran', 490);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(50) NOT NULL,
  `no_telepon` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `nama_lengkap`, `no_telepon`, `alamat`, `created_at`) VALUES
(5, 'Dwi2@yahoo.com', '$2y$10$pK8f82CIkbqsLfh047IEtuJt5EjqWbBj3.z2wQjhLPzxUNL2crdva', 'Dwi Siti', '0812083726', 'Jl. Merdeka Barat, No 15.', '2025-05-14 04:11:09'),
(6, 'Nita45@gmail.com', '$2y$10$1cs4g.Yfni3HXo4lYbyQiOhnrb/J9ldRXcL8zH/.bRQtMbRmaiUje', 'Nita Ghea', '08389281731', 'Jl. Kp. Sumur, No 17, Jakarta Timur', '2025-05-14 13:40:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_pesanan` (`id_pesanan`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`id_keranjang`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_pesanan`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `id_keranjang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id_pesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
