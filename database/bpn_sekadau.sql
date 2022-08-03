-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.33 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for db_aplikasi
CREATE DATABASE IF NOT EXISTS `db_aplikasi` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `db_aplikasi`;

-- Dumping structure for table db_aplikasi.bukti_pekerjaans
CREATE TABLE IF NOT EXISTS `bukti_pekerjaans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `guest_land_id` bigint(20) unsigned NOT NULL,
  `path` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_aplikasi.bukti_pekerjaans: ~3 rows (approximately)
/*!40000 ALTER TABLE `bukti_pekerjaans` DISABLE KEYS */;
REPLACE INTO `bukti_pekerjaans` (`id`, `guest_land_id`, `path`, `created_at`, `updated_at`) VALUES
	(2, 4, 'foto_bukti/CaOCyIc5U6qjQfonWBuPCXFDeM7OOQ0vR93rp9oo.jpg', '2022-08-01 14:40:05', '2022-08-01 14:40:05'),
	(3, 3, 'foto_bukti/TjabAMxU6SRehIYseTXBFizwOqNtXPVoArGdEsM2.jpg', '2022-08-01 15:30:04', '2022-08-01 15:30:04'),
	(4, 3, 'foto_bukti/bibG2oJNsUhKtaYVyZOqK5vazgs2KVONxzCZU6QS.jpg', '2022-08-01 15:30:04', '2022-08-01 15:30:04');
/*!40000 ALTER TABLE `bukti_pekerjaans` ENABLE KEYS */;

-- Dumping structure for table db_aplikasi.districts
CREATE TABLE IF NOT EXISTS `districts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama_kecamatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `districts_nama_kecamatan_unique` (`nama_kecamatan`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_aplikasi.districts: ~7 rows (approximately)
/*!40000 ALTER TABLE `districts` DISABLE KEYS */;
REPLACE INTO `districts` (`id`, `nama_kecamatan`, `created_at`, `updated_at`) VALUES
	(1, 'Sekadau Hilir', '2022-08-01 13:52:24', '2022-08-01 13:52:24'),
	(2, 'Sekadau Hulu', '2022-08-01 13:52:24', '2022-08-01 13:52:24'),
	(3, 'Nanga taman', '2022-08-01 13:55:03', '2022-08-01 13:55:03'),
	(4, 'Nanga mahap', '2022-08-01 13:55:13', '2022-08-01 13:55:13'),
	(5, 'Belitang', '2022-08-01 13:55:36', '2022-08-01 13:55:36'),
	(6, 'Belitang hilir', '2022-08-01 13:55:44', '2022-08-01 13:55:44'),
	(7, 'Belitang hulu', '2022-08-01 13:55:51', '2022-08-01 13:55:51');
/*!40000 ALTER TABLE `districts` ENABLE KEYS */;

-- Dumping structure for table db_aplikasi.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_aplikasi.failed_jobs: ~0 rows (approximately)
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;

-- Dumping structure for table db_aplikasi.guest_lands
CREATE TABLE IF NOT EXISTS `guest_lands` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `nama_pemilik` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_sertifikat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nib` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Village_id` bigint(20) unsigned NOT NULL,
  `nomor_telpon` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_hak` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `luas_tanah` longtext COLLATE utf8mb4_unicode_ci,
  `koordinat_bidang` longtext COLLATE utf8mb4_unicode_ci,
  `peta_bidang` longtext COLLATE utf8mb4_unicode_ci,
  `status_proses` bigint(20) NOT NULL DEFAULT '0',
  `judul_status_proses` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pendaftaran Berkas',
  `batas_waktu_proses` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `guest_lands_nomor_sertifikat_unique` (`nomor_sertifikat`),
  UNIQUE KEY `guest_lands_nib_unique` (`nib`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_aplikasi.guest_lands: ~2 rows (approximately)
/*!40000 ALTER TABLE `guest_lands` DISABLE KEYS */;
REPLACE INTO `guest_lands` (`id`, `user_id`, `nama_pemilik`, `nomor_sertifikat`, `nib`, `Village_id`, `nomor_telpon`, `nomor_hak`, `luas_tanah`, `koordinat_bidang`, `peta_bidang`, `status_proses`, `judul_status_proses`, `batas_waktu_proses`, `created_at`, `updated_at`) VALUES
	(3, 3, 'Fasifikus Iwan Karantika', '1023124820', '0123', 2, '089302323000', '019230', '100', 'koordinat-bidang/kD4CXEfKXwJL3y1txMsG88fH3ZQnk8elU7ciu6Op.json', 'peta-bidang/2nIu0jSyjAVAihFaaAm95Av5er3MlBC59Oxv6oIc.pdf', 5, 'Pekerjaan Selesai', '2022-08-01', '2022-08-01 14:35:43', '2022-08-01 15:31:34'),
	(4, 4, 'Suparma', '88440042', '0909', 2, '08923023290', '92312093', '100', 'koordinat-bidang/RRdeIRreQJlq9uEkkg1tJZPL5gdLCYmk8JZbcCP0.json', 'peta-bidang/71JCuAqohJ3vHkT6V63XO9qy2iNZ6SPfWqTulLPt.pdf', 5, 'Pekerjaan Selesai', '2022-08-01', '2022-08-01 14:36:31', '2022-08-01 15:31:47');
/*!40000 ALTER TABLE `guest_lands` ENABLE KEYS */;

-- Dumping structure for table db_aplikasi.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_aplikasi.migrations: ~9 rows (approximately)
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
REPLACE INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(19, '2014_10_12_000000_create_users_table', 1),
	(20, '2014_10_12_100000_create_password_resets_table', 1),
	(21, '2019_08_19_000000_create_failed_jobs_table', 1),
	(22, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(23, '2022_06_05_174750_create_guest_lands_table', 1),
	(24, '2022_06_05_204200_create_districts_table', 1),
	(25, '2022_06_05_204202_create_Villages_table', 1),
	(26, '2022_06_09_181157_create_status_pekerjaans_table', 1),
	(27, '2022_06_22_143019_create_bukti_pekerjaans_table', 1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Dumping structure for table db_aplikasi.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_aplikasi.password_resets: ~0 rows (approximately)
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;

-- Dumping structure for table db_aplikasi.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_aplikasi.personal_access_tokens: ~0 rows (approximately)
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;

-- Dumping structure for table db_aplikasi.status_pekerjaans
CREATE TABLE IF NOT EXISTS `status_pekerjaans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `guest_land_id` bigint(20) unsigned NOT NULL,
  `judul_pekerjaan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_pekerjaan` bigint(20) NOT NULL,
  `batas_waktu_pekerjaan` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_aplikasi.status_pekerjaans: ~15 rows (approximately)
/*!40000 ALTER TABLE `status_pekerjaans` DISABLE KEYS */;
REPLACE INTO `status_pekerjaans` (`id`, `guest_land_id`, `judul_pekerjaan`, `status_pekerjaan`, `batas_waktu_pekerjaan`, `created_at`, `updated_at`) VALUES
	(9, 3, 'Pemilihan Petugas', 1, '2022-08-15 14:35:43', '2022-08-01 14:35:43', '2022-08-01 14:35:43'),
	(10, 3, 'Pemilihan Petugas', 1, '2022-08-15 14:35:43', '2022-08-01 14:35:43', '2022-08-01 14:35:43'),
	(11, 4, 'Pemilihan Petugas', 1, '2022-08-15 14:39:13', '2022-08-01 14:39:13', '2022-08-01 14:39:13'),
	(12, 4, 'Pengukuran Bidang Tanah Selesai', 2, '2022-08-15 14:39:13', '2022-08-01 14:40:05', '2022-08-01 14:40:05'),
	(13, 4, 'Pembuatan Peta Selesai', 3, '2022-08-15 14:39:13', '2022-08-01 14:40:27', '2022-08-01 14:40:27'),
	(14, 4, 'Terjadi Kesalahan, Pekerjaan ditinjau ulang', 2, '2022-08-15 14:39:13', '2022-08-01 14:41:47', '2022-08-01 14:41:47'),
	(15, 4, 'Pembuatan Peta Selesai', 3, '2022-08-15 14:39:13', '2022-08-01 14:42:05', '2022-08-01 14:42:05'),
	(16, 4, 'Terjadi Kesalahan, Pekerjaan ditinjau ulang', 2, '2022-08-15 14:39:13', '2022-08-01 14:43:10', '2022-08-01 14:43:10'),
	(17, 4, 'Pembuatan Peta Selesai', 3, '2022-08-15 14:39:13', '2022-08-01 14:43:35', '2022-08-01 14:43:35'),
	(18, 4, 'Pekerjaan ditinjau oleh Koordinator', 4, '2022-08-15 14:39:13', '2022-08-01 14:44:15', '2022-08-01 14:44:15'),
	(19, 3, 'Pengukuran Bidang Tanah Selesai', 2, '2022-08-15 14:35:43', '2022-08-01 15:30:04', '2022-08-01 15:30:04'),
	(20, 3, 'Pembuatan Peta Selesai', 3, '2022-08-15 14:35:43', '2022-08-01 15:30:32', '2022-08-01 15:30:32'),
	(21, 3, 'Pekerjaan ditinjau oleh Koordinator', 4, '2022-08-15 14:35:43', '2022-08-01 15:30:54', '2022-08-01 15:30:54'),
	(22, 3, 'Pekerjaan Selesai', 5, '2022-08-01', '2022-08-01 15:31:34', '2022-08-01 15:31:34'),
	(23, 4, 'Pekerjaan Selesai', 5, '2022-08-01', '2022-08-01 15:31:47', '2022-08-01 15:31:47');
/*!40000 ALTER TABLE `status_pekerjaans` ENABLE KEYS */;

-- Dumping structure for table db_aplikasi.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level` enum('0','1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_aplikasi.users: ~6 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
REPLACE INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `level`, `created_at`, `updated_at`) VALUES
	(1, 'Deris', 'koordinator@example.com', '2022-08-01 13:52:24', '$2y$10$yxga6fs.h4/nBrFwTSmwTuikNCqIclE4E07sHtefBRbURzXBHkrZq', 'TThaiJSIWun1x7fcyGVnU4jNRgTQSp2ohzqe0iqNEutzcJ89ousiCTNyVYPW', '1', '2022-08-01 13:52:24', '2022-08-01 14:16:22'),
	(2, 'Admin', 'admin@example.com', '2022-08-01 13:52:24', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'RShqU7AqPlfbBt2m6JJbojtjztxGWrfDvPrYwgaqVdHA7lacE8R672wdUqUm', '0', '2022-08-01 13:52:24', '2022-08-01 13:52:24'),
	(3, 'Dhimas Hadi Prasetyo, AP', 'dimas@example.com', '2022-08-01 13:52:24', '$2y$10$hDcB4GK1WJdN35/uFtCb7OJzHCgZ5qscOc0qP5xYlTgL93WkyOzlW', 'mskzTtFOUFUIepcYqNV0ahT1NAjwSxsHr6qP8vCMyvWhG9c8uRgPczUccs89', '2', '2022-08-01 13:52:24', '2022-08-01 14:16:00'),
	(4, 'Erick kurniawan', 'erickkurniawan@example.com', '2022-08-01 14:14:13', '$2y$10$vR5/cTM27hHsopa9z4nck.LV7PRTMQuJiYpue5Ohl8NFbSRQU0vCy', 'bHP1iguNNef4v8YvzWliCtsnK0FGWECiTyvBvSPMvasjpQYBmKxooidHyoFq', '2', '2022-08-01 14:14:13', '2022-08-01 14:14:13'),
	(5, 'Admin2', 'admin2@example.com', '2022-08-01 14:17:22', '$2y$10$Vp3SiVTplfkanXp5YFGxOu249F9ql/WAqlgdURTTtjY8WWvbp0SEW', '2Ugq5t9vKJ', '0', '2022-08-01 14:17:22', '2022-08-01 14:17:22'),
	(6, 'Syahrul anwar', 'syahrulanwar@example.com', '2022-08-01 14:18:27', '$2y$10$KQqWq9AL41HAJky9K4CQa.rqG3i17hiO7Wk1HrK3IG2P4SrlyN3Z6', 'j0RnuTLLV9', '2', '2022-08-01 14:18:27', '2022-08-01 14:18:27');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Dumping structure for table db_aplikasi.Villages
CREATE TABLE IF NOT EXISTS `Villages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `district_id` bigint(20) unsigned NOT NULL,
  `nama_desa` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `koordinat_bidang_desa` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Villages_nama_desa_unique` (`nama_desa`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_aplikasi.Villages: ~10 rows (approximately)
/*!40000 ALTER TABLE `Villages` DISABLE KEYS */;
REPLACE INTO `Villages` (`id`, `district_id`, `nama_desa`, `koordinat_bidang_desa`, `created_at`, `updated_at`) VALUES
	(2, 1, 'Tanjung', NULL, '2022-08-01 13:57:13', '2022-08-01 13:57:13'),
	(3, 1, 'Mungguk', NULL, '2022-08-01 13:57:22', '2022-08-01 13:57:22'),
	(4, 1, 'Sungai ringin', NULL, '2022-08-01 13:57:28', '2022-08-01 13:57:28'),
	(7, 1, 'Gonis tekam', NULL, '2022-08-01 13:58:40', '2022-08-01 13:58:40'),
	(9, 1, 'Merapi', NULL, '2022-08-01 13:59:20', '2022-08-01 13:59:20'),
	(10, 1, 'Seberang kapuas', NULL, '2022-08-01 13:59:42', '2022-08-01 13:59:42'),
	(12, 2, 'Cupang gading', NULL, '2022-08-01 14:00:16', '2022-08-01 14:00:16'),
	(13, 2, 'Sungai sambang', NULL, '2022-08-01 14:00:33', '2022-08-01 14:01:07'),
	(14, 2, 'Tinting boyok', NULL, '2022-08-01 14:02:03', '2022-08-01 14:02:03'),
	(17, 3, 'Sungai lawak', NULL, '2022-08-01 14:04:21', '2022-08-01 14:04:21');
/*!40000 ALTER TABLE `Villages` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
