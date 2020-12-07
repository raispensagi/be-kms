-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2020 at 09:41 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.2.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kms_sawit`
--

-- --------------------------------------------------------

--
-- Table structure for table `artikel`
--

CREATE TABLE `artikel` (
  `id` int(10) UNSIGNED NOT NULL,
  `isi` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `artikel`
--

INSERT INTO `artikel` (`id`, `isi`, `foto`, `created_at`, `updated_at`) VALUES
(1, 'Testing', 'Artikel_1_26042020_143941.jpg', '2020-04-26 06:52:05', '2020-04-26 07:39:41'),
(2, 'Testing', 'default.png', '2020-04-26 06:55:15', '2020-04-26 06:55:15'),
(6, 'Testing 1 Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ac ipsum massa. Ut in lorem ac lectus varius tincidunt. Suspendisse ipsum leo, tincidunt aliquet rhoncus ac, rhoncus non elit. Mauris vulputate mi ut nibh mattis, vitae volutpat purus consectetur. Proin eget imperdiet nibh. Ut lacinia, orci sed mollis laoreet, dolor mauris porta justo, eu elementum augue enim quis sapien. In gravida luctus turpis, ac iaculis orci feugiat et. Sed eget bibendum massa. Nam aliquam nulla sollicitudin euismod condimentum. Donec et accumsan orci. Morbi pulvinar egestas lacus sed malesuada. Sed massa est, ultrices id lacus quis, hendrerit pulvinar purus.', 'default.png', '2020-05-14 10:26:13', '2020-05-18 03:42:49'),
(7, 'Testing 2 Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ac ipsum massa. Ut in lorem ac lectus varius tincidunt. Suspendisse ipsum leo, tincidunt aliquet rhoncus ac, rhoncus non elit. Mauris vulputate mi ut nibh mattis, vitae volutpat purus consectetur. Proin eget imperdiet nibh. Ut lacinia, orci sed mollis laoreet, dolor mauris porta justo, eu elementum augue enim quis sapien. In gravida luctus turpis, ac iaculis orci feugiat et. Sed eget bibendum massa. Nam aliquam nulla sollicitudin euismod condimentum. Donec et accumsan orci. Morbi pulvinar egestas lacus sed malesuada. Sed massa est, ultrices id lacus quis, hendrerit pulvinar purus.', 'default.png', '2020-05-15 07:18:37', '2020-05-18 03:39:48'),
(8, 'Testing 3 Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ac ipsum massa. Ut in lorem ac lectus varius tincidunt. Suspendisse ipsum leo, tincidunt aliquet rhoncus ac, rhoncus non elit. Mauris vulputate mi ut nibh mattis, vitae volutpat purus consectetur. Proin eget imperdiet nibh. Ut lacinia, orci sed mollis laoreet, dolor mauris porta justo, eu elementum augue enim quis sapien. In gravida luctus turpis, ac iaculis orci feugiat et. Sed eget bibendum massa. Nam aliquam nulla sollicitudin euismod condimentum. Donec et accumsan orci. Morbi pulvinar egestas lacus sed malesuada. Sed massa est, ultrices id lacus quis, hendrerit pulvinar purus.', 'default.png', '2020-05-19 07:54:30', '2020-05-19 07:54:30'),
(10, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc pretium quam at nibh tempor, sed luctus magna commodo. Curabitur vitae mi varius urna pulvinar lobortis ac nec nisi. Nulla facilisi. Fusce vel molestie diam. Nulla ex mauris, consectetur hendrerit lorem vel, pharetra gravida nisl. Vivamus ultricies cursus purus vitae sodales. Maecenas malesuada, purus et porta scelerisque, lacus mi auctor felis, ac bibendum leo tortor sodales metus.', 'Artikel_10_13062020_152834.jpg', '2020-06-13 08:28:34', '2020-06-13 08:28:34'),
(11, 'Edit Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc pretium quam at nibh tempor, sed luctus magna commodo. Curabitur vitae mi varius urna pulvinar lobortis ac nec nisi. Nulla facilisi. Fusce vel molestie diam. Nulla ex mauris, consectetur hendrerit lorem vel, pharetra gravida nisl. Vivamus ultricies cursus purus vitae sodales. Maecenas malesuada, purus et porta scelerisque, lacus mi auctor felis, ac bibendum leo tortor sodales metus.', 'Artikel_9_13062020_172417.jpg', '2020-06-13 08:27:06', '2020-06-13 10:24:17');

-- --------------------------------------------------------

--
-- Table structure for table `bookmark`
--

CREATE TABLE `bookmark` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `konten_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookmark`
--

INSERT INTO `bookmark` (`id`, `user_id`, `konten_id`, `created_at`, `updated_at`) VALUES
(3, 1, 1, '2020-05-15 07:38:40', '2020-05-15 07:38:40'),
(8, 1, 14, '2020-06-13 10:46:36', '2020-06-13 10:46:36');

-- --------------------------------------------------------

--
-- Table structure for table `edokumen`
--

CREATE TABLE `edokumen` (
  `id` int(10) UNSIGNED NOT NULL,
  `penulis` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `penerbit` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `halaman` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bahasa` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `file` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `edokumen`
--

INSERT INTO `edokumen` (`id`, `penulis`, `tahun`, `penerbit`, `halaman`, `bahasa`, `deskripsi`, `created_at`, `updated_at`, `file`) VALUES
(1, 'John Doe', '2020', 'Pearcing PR', '1111', 'Jawa', 'Lorem Ipsum', '2020-05-19 09:57:22', '2020-05-19 11:02:10', 'EDokumen_1_19052020_180210.jpg'),
(2, 'Fulan Rafi', '2011', 'Exelmedia', '433', 'Indonesia', 'Lorem ipsum dolor sit amet', '2020-06-13 10:18:12', '2020-06-13 10:18:12', 'EDokumen_2_13062020_171812.jpg'),
(3, 'Fulan Rafikih', '2012', 'Exelmedia', '533', 'Indonesia', 'Lorem ipsum dolor sit amet', '2020-06-13 10:19:14', '2020-06-13 10:19:14', 'EDokumen_3_13062020_171914.jpg'),
(4, 'Fulan Rafi', '2011', 'Exelmedia', '433', 'Indonesia', 'Lorem ipsum dolor sit amet', '2020-06-18 00:47:01', '2020-06-18 00:47:01', 'Test file'),
(5, 'Fulan Rafi', '2011', 'Exelmedia', '433', 'Indonesia', 'Lorem ipsum dolor sit amet', '2020-06-18 00:48:28', '2020-06-18 00:56:32', 'batang');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `konten`
--

CREATE TABLE `konten` (
  `id` int(10) UNSIGNED NOT NULL,
  `kategori` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sub_kategori` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipe` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_tipe` int(11) DEFAULT NULL,
  `judul` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_draft` tinyint(1) NOT NULL DEFAULT '0',
  `is_valid` tinyint(1) NOT NULL DEFAULT '0',
  `is_hidden` tinyint(1) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `konten`
--

INSERT INTO `konten` (`id`, `kategori`, `sub_kategori`, `tipe`, `id_tipe`, `judul`, `tanggal`, `is_draft`, `is_valid`, `is_hidden`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Penanaman', 'Bibit', 'Artikel', 1, 'Bibit Unggul', '26 April 2020 14:39:41', 0, 1, 0, 1, '2020-04-26 06:52:05', '2020-05-19 07:40:30'),
(2, 'Penanaman', 'Biji', 'Artikel', 2, 'Biji Murah', '26 April 2020 13:55:15', 0, 1, 0, 1, '2020-04-26 06:55:15', '2020-04-26 06:55:15'),
(3, 'Penanganan', 'Hama', 'Artikel', 6, 'Hama Jahat', '18 May 2020 10:42:49', 0, 1, 0, 1, '2020-05-14 10:26:13', '2020-06-13 12:04:36'),
(4, 'Penanganan', 'Hama', 'Artikel', 7, 'Hama Gulma', '18 May 2020 10:41:01', 1, 0, 0, 1, '2020-05-15 07:18:37', '2020-06-13 12:07:18'),
(5, 'Budidaya', NULL, 'Video', 3, 'Cara Budidaya', '15 May 2020 15:34:49', 0, 1, 0, 1, '2020-05-15 08:34:49', '2020-05-19 07:51:51'),
(6, 'Budidaya', NULL, 'Artikel', 8, 'Budi Berdaya', '19 May 2020 14:54:30', 1, 0, 0, 1, '2020-05-19 07:54:30', '2020-05-19 07:54:30'),
(7, 'Test', NULL, 'Video', 4, 'Assalamu Alaikum', '19 May 2020 16:32:38', 0, 1, 0, 1, '2020-05-19 09:32:38', '2020-05-19 09:32:38'),
(8, 'Test', NULL, 'Video', 5, 'Assalamu Alaikum 2', '19 May 2020 16:34:04', 0, 1, 0, 1, '2020-05-19 09:34:04', '2020-05-28 09:58:20'),
(9, 'Test', NULL, 'Video', 6, 'Test', '19 May 2020 16:49:23', 1, 0, 0, 1, '2020-05-19 09:35:29', '2020-05-28 09:58:20'),
(10, 'Test', 'Testing', 'EDokumen', 1, 'Test A', '19 May 2020 18:02:09', 0, 1, 0, 1, '2020-05-19 09:57:22', '2020-05-19 11:02:09'),
(12, 'Pakan', 'Pohon', 'Artikel', 10, 'Pakan Pohon 2', '13 June 2020 15:28:34', 0, 1, 0, 1, '2020-06-13 08:28:34', '2020-06-13 08:28:34'),
(13, 'Pakan', 'Pohon', 'Video', 7, 'Pakan Pohon 3', '13 June 2020 15:30:54', 1, 0, 0, 1, '2020-06-13 08:30:54', '2020-06-13 08:30:54'),
(14, 'Pakan', 'Pohon', 'Artikel', 11, 'Pakan Pohon 4', '13 June 2020 15:32:14', 0, 1, 0, 1, '2020-06-13 08:32:14', '2020-06-13 08:32:14'),
(15, 'Pakan', 'Pohon', 'EDokumen', 2, 'Pakan Pohon 5', '13 June 2020 17:18:12', 1, 0, 0, 1, '2020-06-13 10:18:12', '2020-06-13 10:18:12'),
(16, 'Pakan', 'Pohon', 'EDokumen', 3, 'Pakan Pohon 6', '13 June 2020 17:19:14', 0, 1, 0, 1, '2020-06-13 10:19:14', '2020-06-13 10:19:14'),
(17, 'Pakan', 'Pohon', 'EDokumen', 4, 'Pakar Pohon', '18 June 2020 07:47:01', 1, 0, 0, 1, '2020-06-18 00:47:01', '2020-06-18 00:47:01'),
(18, 'Pakan', 'Pohon', 'EDokumen', 5, 'Pakar Pohon 2', '18 June 2020 07:56:32', 1, 0, 0, 1, '2020-06-18 00:48:28', '2020-06-18 00:56:32');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(20, '2019_08_19_000000_create_failed_jobs_table', 1),
(21, '2020_04_01_081710_create_petani_pakar', 1),
(22, '2020_04_24_112208_create_admin_validator', 1),
(23, '2020_04_26_122405_create_konten_table', 1),
(24, '2020_04_26_122931_create_artikel_table', 1),
(25, '2020_04_26_122947_create_penulis_table', 1),
(26, '2020_04_26_130938_alter_konten_table', 2),
(27, '2020_05_04_125914_create_video_audio_table', 3),
(28, '2020_05_04_131034_create_e_dokumens_table', 3),
(29, '2020_05_04_172317_create_bookmarks_table', 4),
(30, '2020_05_06_135509_create_notifikasis_table', 4),
(31, '2020_05_06_143138_create_riwayats_table', 5),
(32, '2020_05_11_094436_create_user_table', 5),
(33, '2020_05_11_124635_alter_konten_table_2', 5),
(34, '2020_05_14_121530_alter_user_table', 6),
(39, '2020_05_14_164023_create_validasis_table', 7),
(40, '2020_05_14_170739_create_revisis_table', 7),
(41, '2020_05_15_105953_alter_notifikasi_table', 7),
(42, '2020_05_19_165510_add_file_edokumen', 7),
(43, '2020_05_31_101429_add_notifikasi_user_table', 8);

-- --------------------------------------------------------

--
-- Table structure for table `notifikasi`
--

CREATE TABLE `notifikasi` (
  `id` int(10) UNSIGNED NOT NULL,
  `headline` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tanggal` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifikasi`
--

INSERT INTO `notifikasi` (`id`, `headline`, `isi`, `created_at`, `updated_at`, `tanggal`, `user_id`) VALUES
(5, 'Test 2', 'Testing 2', '2020-06-13 07:48:34', '2020-06-13 07:48:34', '13 June 2020 14:48:34', 4),
(6, 'Testing Notifikasi', 'Hanya test', '2020-06-13 11:28:14', '2020-06-13 11:28:14', '13 June 2020 18:28:14', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifikasi_user`
--

CREATE TABLE `notifikasi_user` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `notifikasi_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifikasi_user`
--

INSERT INTO `notifikasi_user` (`id`, `user_id`, `notifikasi_id`, `created_at`, `updated_at`) VALUES
(16, 1, 5, '2020-06-13 07:48:34', '2020-06-13 07:48:34'),
(17, 3, 5, '2020-06-13 07:48:34', '2020-06-13 07:48:34'),
(19, 5, 5, '2020-06-13 07:48:34', '2020-06-13 07:48:34'),
(20, 6, 5, '2020-06-13 07:48:34', '2020-06-13 07:48:34'),
(21, 7, 5, '2020-06-13 07:48:34', '2020-06-13 07:48:34'),
(22, 8, 5, '2020-06-13 07:48:34', '2020-06-13 07:48:34'),
(23, 9, 5, '2020-06-13 07:48:34', '2020-06-13 07:48:34'),
(24, 10, 5, '2020-06-13 07:48:34', '2020-06-13 07:48:34'),
(25, 11, 5, '2020-06-13 07:48:34', '2020-06-13 07:48:34'),
(26, 1, 6, '2020-06-13 11:28:14', '2020-06-13 11:28:14'),
(27, 3, 6, '2020-06-13 11:28:14', '2020-06-13 11:28:14'),
(28, 4, 6, '2020-06-13 11:28:14', '2020-06-13 11:28:14'),
(29, 5, 6, '2020-06-13 11:28:14', '2020-06-13 11:28:14'),
(30, 6, 6, '2020-06-13 11:28:14', '2020-06-13 11:28:14'),
(31, 7, 6, '2020-06-13 11:28:14', '2020-06-13 11:28:14'),
(32, 8, 6, '2020-06-13 11:28:14', '2020-06-13 11:28:14'),
(33, 9, 6, '2020-06-13 11:28:14', '2020-06-13 11:28:14'),
(34, 10, 6, '2020-06-13 11:28:14', '2020-06-13 11:28:14'),
(35, 11, 6, '2020-06-13 11:28:14', '2020-06-13 11:28:14');

-- --------------------------------------------------------

--
-- Table structure for table `revisi`
--

CREATE TABLE `revisi` (
  `id` int(10) UNSIGNED NOT NULL,
  `komentar` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `konten_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `revisi`
--

INSERT INTO `revisi` (`id`, `komentar`, `tanggal`, `konten_id`, `user_id`, `created_at`, `updated_at`) VALUES
(2, 'Perbaiki lagi judulnya dengan konteks isinya', '13 June 2020 19:07:18', 4, 5, '2020-06-13 12:07:18', '2020-06-13 12:07:18');

-- --------------------------------------------------------

--
-- Table structure for table `riwayat`
--

CREATE TABLE `riwayat` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `konten_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `riwayat`
--

INSERT INTO `riwayat` (`id`, `user_id`, `konten_id`, `created_at`, `updated_at`) VALUES
(5, 1, 3, '2020-05-15 08:45:36', '2020-05-15 08:45:36'),
(6, 1, 5, '2020-05-15 08:45:39', '2020-05-15 08:45:39'),
(7, 6, 3, '2020-05-28 08:58:15', '2020-05-28 08:58:15'),
(10, 6, 1, '2020-06-06 11:57:31', '2020-06-06 11:57:31'),
(13, 1, 4, '2020-06-18 00:47:14', '2020-06-18 00:47:14');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor_telefon` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `peran` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama`, `email`, `nomor_telefon`, `password`, `peran`, `created_at`, `updated_at`) VALUES
(1, 'Alli Babba', 'baba@gmail.com', NULL, '$2y$10$t5lv0BgwCtvUHAzy2.wCDuXSpwv1z75WKFCiEgmzjSim7lCqwBDnS', 'pakar_sawit', '2020-05-12 07:23:43', '2020-06-13 11:32:37'),
(3, 'Baba DuaSatuDua', 'baba212@gmail.com', NULL, '$2y$10$tdSRcWm4JHQePJN/e3XzRO5qIheaZxb/01Nr5ATCR/zaIe6Ugg.mG', 'super_admin', '2020-05-18 02:59:21', '2020-05-18 05:54:15'),
(4, 'Budi Setiawan', 'budi@gmail.com', NULL, '$2y$10$ukFlDjSMqLfH0iYPJf27mey1JbQvIHsc4lvWZMqjvDB97NzE4l/Iy', 'admin', '2020-05-19 07:42:10', '2020-05-19 07:42:10'),
(5, 'Bhudi Setiawan', 'bhudi@gmail.com', NULL, '$2y$10$3BDsN.PxuSlEjv6TJ2QNDOC5cgFqcIVN5obJNiYARDWGBT/VotpVC', 'validator', '2020-05-19 07:44:18', '2020-05-19 07:47:30'),
(6, 'Budhi Setyawan', 'budih@gmail.com', NULL, '$2y$10$/zwob5.u6./IrdP.rIB0OOILcKzxOy6vLDCN4ISBw761FkP/cUKP.', 'petani', '2020-05-20 02:14:38', '2020-05-20 02:14:38'),
(7, 'Fulan Fulana', 'fulan@gmail.com', NULL, '$2y$10$7JvHVhSePzQjuKBLnosuNes9LfiyM369EcMsYVig.iFSOHfAq0Kay', 'petani', '2020-06-13 06:39:37', '2020-06-13 06:39:37'),
(8, 'Fulan Fulani', 'fulani@gmail.com', NULL, '$2y$10$RzSCD8Cqid8s6E4QR8K6XuBmXvgNVIbMQ54TK8w1fg6BWdAeWoOvG', 'pakar_sawit', '2020-06-13 07:02:15', '2020-06-13 07:02:15'),
(9, 'Fulan Fulanu', 'fulanu@gmail.com', NULL, '$2y$10$2hols.IFRxWm/4JIgFNjG..gh6aWKnfSGua77va5XOS1B.AKwRkji', 'validator', '2020-06-13 07:07:24', '2020-06-13 07:07:24'),
(11, 'Fulan Fulano', 'fulano@gmail.com', NULL, '$2y$10$E.ouORq/8icbrVLv5KluJexiHY1KwEHbaPhyt5iu2T8me.5J.tRAG', 'super_admin', '2020-06-13 07:21:42', '2020-06-13 07:21:42'),
(12, 'Fulan Fulian', 'fulian@gmail.com', NULL, '$2y$10$Y0fQ6DhPTr8Tw813XOZ3pevCQwazB/OU.6fpffKs529qLiJnpWzpy', 'admin', '2020-06-13 12:16:38', '2020-06-13 12:16:38'),
(13, 'Fulan Fulane', 'fulane@gmail.com', NULL, '$2y$10$L5QgBDZZiPynigt5DSkA4.i/emmMcBJYCt9qAnd9TGIZGnfVJSt.2', 'admin', '2020-06-13 13:07:40', '2020-06-13 13:07:40');

-- --------------------------------------------------------

--
-- Table structure for table `video_audio`
--

CREATE TABLE `video_audio` (
  `id` int(10) UNSIGNED NOT NULL,
  `isi` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `video_audio` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `video_audio`
--

INSERT INTO `video_audio` (`id`, `isi`, `video_audio`, `created_at`, `updated_at`) VALUES
(3, 'Video 3 Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ac ipsum massa. Ut in lorem ac lectus varius tincidunt. Suspendisse ipsum leo, tincidunt aliquet rhoncus ac, rhoncus non elit. Mauris vulputate mi ut nibh mattis, vitae volutpat purus consectetur. Proin eget imperdiet nibh. Ut lacinia, orci sed mollis laoreet, dolor mauris porta justo, eu elementum augue enim quis sapien. In gravida luctus turpis, ac iaculis orci feugiat et. Sed eget bibendum massa. Nam aliquam nulla sollicitudin euismod condimentum. Donec et accumsan orci. Morbi pulvinar egestas lacus sed malesuada. Sed massa est, ultrices id lacus quis, hendrerit pulvinar purus.', 'default.png', '2020-05-15 08:34:49', '2020-05-15 08:34:49'),
(4, 'Video 4 Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ac ipsum massa. Ut in lorem ac lectus varius tincidunt. Suspendisse ipsum leo, tincidunt aliquet rhoncus ac, rhoncus non elit. Mauris vulputate mi ut nibh mattis, vitae volutpat purus consectetur. Proin eget imperdiet nibh. Ut lacinia, orci sed mollis laoreet, dolor mauris porta justo, eu elementum augue enim quis sapien. In gravida luctus turpis, ac iaculis orci feugiat et. Sed eget bibendum massa. Nam aliquam nulla sollicitudin euismod condimentum. Donec et accumsan orci. Morbi pulvinar egestas lacus sed malesuada. Sed massa est, ultrices id lacus quis, hendrerit pulvinar purus.', 'VideoAudio_4_19052020_163238.jpg', '2020-05-19 09:32:38', '2020-05-19 09:32:38'),
(5, 'Video 5 Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ac ipsum massa. Ut in lorem ac lectus varius tincidunt. Suspendisse ipsum leo, tincidunt aliquet rhoncus ac, rhoncus non elit. Mauris vulputate mi ut nibh mattis, vitae volutpat purus consectetur. Proin eget imperdiet nibh. Ut lacinia, orci sed mollis laoreet, dolor mauris porta justo, eu elementum augue enim quis sapien. In gravida luctus turpis, ac iaculis orci feugiat et. Sed eget bibendum massa. Nam aliquam nulla sollicitudin euismod condimentum. Donec et accumsan orci. Morbi pulvinar egestas lacus sed malesuada. Sed massa est, ultrices id lacus quis, hendrerit pulvinar purus.', 'kcuing', '2020-05-19 09:34:04', '2020-05-19 09:34:04'),
(6, 'Video 6 Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ac ipsum massa. Ut in lorem ac lectus varius tincidunt. Suspendisse ipsum leo, tincidunt aliquet rhoncus ac, rhoncus non elit. Mauris vulputate mi ut nibh mattis, vitae volutpat purus consectetur. Proin eget imperdiet nibh. Ut lacinia, orci sed mollis laoreet, dolor mauris porta justo, eu elementum augue enim quis sapien. In gravida luctus turpis, ac iaculis orci feugiat et. Sed eget bibendum massa. Nam aliquam nulla sollicitudin euismod condimentum. Donec et accumsan orci. Morbi pulvinar egestas lacus sed malesuada. Sed massa est, ultrices id lacus quis, hendrerit pulvinar purus.', 'VideoAudio_6_19052020_164923.jpg', '2020-05-19 09:35:29', '2020-05-19 09:49:23'),
(7, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc pretium quam at nibh tempor, sed luctus magna commodo. Curabitur vitae mi varius urna pulvinar lobortis ac nec nisi. Nulla facilisi. Fusce vel molestie diam. Nulla ex mauris, consectetur hendrerit lorem vel, pharetra gravida nisl. Vivamus ultricies cursus purus vitae sodales. Maecenas malesuada, purus et porta scelerisque, lacus mi auctor felis, ac bibendum leo tortor sodales metus.', 'VideoAudio_7_13062020_153054.jpg', '2020-06-13 08:30:54', '2020-06-13 08:30:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artikel`
--
ALTER TABLE `artikel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookmark`
--
ALTER TABLE `bookmark`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `edokumen`
--
ALTER TABLE `edokumen`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `konten`
--
ALTER TABLE `konten`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifikasi_user`
--
ALTER TABLE `notifikasi_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `revisi`
--
ALTER TABLE `revisi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `riwayat`
--
ALTER TABLE `riwayat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `video_audio`
--
ALTER TABLE `video_audio`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artikel`
--
ALTER TABLE `artikel`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `bookmark`
--
ALTER TABLE `bookmark`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `edokumen`
--
ALTER TABLE `edokumen`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `konten`
--
ALTER TABLE `konten`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `notifikasi_user`
--
ALTER TABLE `notifikasi_user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `revisi`
--
ALTER TABLE `revisi`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `riwayat`
--
ALTER TABLE `riwayat`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `video_audio`
--
ALTER TABLE `video_audio`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
