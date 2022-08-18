-- --------------------------------------------------------
-- Host:                         10.10.0.67
-- Server version:               5.7.38-0ubuntu0.18.04.1 - (Ubuntu)
-- Server OS:                    Linux
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for silab
CREATE DATABASE IF NOT EXISTS `silab` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `silab`;

-- Dumping structure for table silab.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table silab.failed_jobs: ~0 rows (approximately)
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;

-- Dumping structure for table silab.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table silab.migrations: ~12 rows (approximately)
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(5, '2022_04_12_045912_add_googleid_avatar_role_to_users_table', 1),
	(6, '2022_04_14_023042_create_permission_tables', 2),
	(8, '2022_04_14_055432_create_staff_table', 3),
	(10, '2022_04_20_033342_tabel_jurusan_prodi_m_k_semester', 4),
	(11, '2022_05_24_040544_pengajuan', 5),
	(12, '2022_05_31_065909_add_column_tahun_ajaran', 6),
	(13, '2022_07_03_021650_detail_usulan_kebutuhan', 7),
	(14, '2022_07_03_024144_add_fk_detail_usulan_kebutuhan', 8);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Dumping structure for table silab.model_has_permissions
CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table silab.model_has_permissions: ~0 rows (approximately)
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;

-- Dumping structure for table silab.model_has_roles
CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table silab.model_has_roles: ~86 rows (approximately)
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
	(1, 'App\\Models\\User', 1),
	(2, 'App\\Models\\User', 4),
	(2, 'App\\Models\\User', 5),
	(2, 'App\\Models\\User', 6),
	(2, 'App\\Models\\User', 7),
	(2, 'App\\Models\\User', 8),
	(2, 'App\\Models\\User', 9),
	(2, 'App\\Models\\User', 10),
	(2, 'App\\Models\\User', 11),
	(2, 'App\\Models\\User', 12),
	(2, 'App\\Models\\User', 13),
	(2, 'App\\Models\\User', 14),
	(2, 'App\\Models\\User', 15),
	(2, 'App\\Models\\User', 16),
	(2, 'App\\Models\\User', 17),
	(2, 'App\\Models\\User', 18),
	(2, 'App\\Models\\User', 19),
	(2, 'App\\Models\\User', 20),
	(2, 'App\\Models\\User', 21),
	(2, 'App\\Models\\User', 22),
	(2, 'App\\Models\\User', 23),
	(2, 'App\\Models\\User', 24),
	(2, 'App\\Models\\User', 25),
	(2, 'App\\Models\\User', 26),
	(2, 'App\\Models\\User', 27),
	(2, 'App\\Models\\User', 28),
	(2, 'App\\Models\\User', 29),
	(2, 'App\\Models\\User', 30),
	(2, 'App\\Models\\User', 31),
	(2, 'App\\Models\\User', 32),
	(2, 'App\\Models\\User', 33),
	(2, 'App\\Models\\User', 34),
	(2, 'App\\Models\\User', 35),
	(2, 'App\\Models\\User', 36),
	(2, 'App\\Models\\User', 37),
	(2, 'App\\Models\\User', 38),
	(2, 'App\\Models\\User', 39),
	(2, 'App\\Models\\User', 40),
	(2, 'App\\Models\\User', 41),
	(2, 'App\\Models\\User', 42),
	(2, 'App\\Models\\User', 43),
	(2, 'App\\Models\\User', 44),
	(2, 'App\\Models\\User', 45),
	(2, 'App\\Models\\User', 46),
	(2, 'App\\Models\\User', 47),
	(2, 'App\\Models\\User', 48),
	(2, 'App\\Models\\User', 49),
	(2, 'App\\Models\\User', 50),
	(2, 'App\\Models\\User', 51),
	(2, 'App\\Models\\User', 52),
	(2, 'App\\Models\\User', 53),
	(2, 'App\\Models\\User', 54),
	(2, 'App\\Models\\User', 55),
	(2, 'App\\Models\\User', 56),
	(2, 'App\\Models\\User', 57),
	(2, 'App\\Models\\User', 58),
	(2, 'App\\Models\\User', 59),
	(2, 'App\\Models\\User', 60),
	(2, 'App\\Models\\User', 61),
	(2, 'App\\Models\\User', 62),
	(2, 'App\\Models\\User', 63),
	(2, 'App\\Models\\User', 64),
	(2, 'App\\Models\\User', 65),
	(2, 'App\\Models\\User', 66),
	(2, 'App\\Models\\User', 67),
	(2, 'App\\Models\\User', 68),
	(2, 'App\\Models\\User', 69),
	(2, 'App\\Models\\User', 70),
	(2, 'App\\Models\\User', 71),
	(2, 'App\\Models\\User', 72),
	(2, 'App\\Models\\User', 73),
	(2, 'App\\Models\\User', 74),
	(2, 'App\\Models\\User', 75),
	(2, 'App\\Models\\User', 76),
	(2, 'App\\Models\\User', 77),
	(2, 'App\\Models\\User', 78),
	(2, 'App\\Models\\User', 79),
	(2, 'App\\Models\\User', 80),
	(2, 'App\\Models\\User', 81),
	(2, 'App\\Models\\User', 82),
	(2, 'App\\Models\\User', 83),
	(2, 'App\\Models\\User', 84),
	(2, 'App\\Models\\User', 85),
	(2, 'App\\Models\\User', 86),
	(2, 'App\\Models\\User', 87),
	(2, 'App\\Models\\User', 88);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;

-- Dumping structure for table silab.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table silab.password_resets: ~0 rows (approximately)
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;

-- Dumping structure for table silab.permissions
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table silab.permissions: ~54 rows (approximately)
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
	(1, 'staff-list', 'web', '2022-04-18 05:21:55', '2022-04-18 05:51:25'),
	(2, 'staff-create', 'web', '2022-04-18 05:21:55', '2022-04-18 05:50:39'),
	(3, 'staff-edit', 'web', '2022-04-18 05:21:55', '2022-04-18 05:21:55'),
	(4, 'staff-delete', 'web', '2022-04-18 05:21:55', '2022-04-18 05:21:55'),
	(7, 'jurusan-list', 'web', '2022-04-25 01:42:33', '2022-04-25 01:42:33'),
	(8, 'jurusan-create', 'web', '2022-04-25 01:42:33', '2022-04-25 01:42:33'),
	(9, 'jurusan-edit', 'web', '2022-04-25 01:42:33', '2022-04-25 01:42:33'),
	(10, 'jurusan-delete', 'web', '2022-04-25 01:42:33', '2022-04-25 01:42:33'),
	(11, 'all-staff-list', 'web', '2022-04-26 04:05:53', '2022-04-26 04:05:53'),
	(12, 'set-staff-role', 'web', '2022-04-26 04:05:53', '2022-04-26 04:05:53'),
	(13, 'matakuliah-list', 'web', '2022-04-26 05:29:08', '2022-04-26 05:29:08'),
	(14, 'matakuliah-create', 'web', '2022-04-26 05:29:08', '2022-04-26 05:29:08'),
	(15, 'matakuliah-edit', 'web', '2022-04-26 05:29:08', '2022-04-26 05:29:08'),
	(16, 'matakuliah-delete', 'web', '2022-04-26 05:29:08', '2022-04-26 05:29:08'),
	(17, 'prodi-list', 'web', '2022-05-01 09:19:01', '2022-05-01 09:19:01'),
	(18, 'prodi-create', 'web', '2022-05-01 09:19:01', '2022-05-01 09:19:01'),
	(19, 'prodi-edit', 'web', '2022-05-01 09:19:01', '2022-05-01 09:19:01'),
	(20, 'prodi-delete', 'web', '2022-05-01 09:19:02', '2022-05-01 09:19:02'),
	(21, 'semester-list', 'web', '2022-05-10 04:23:37', '2022-05-10 04:23:37'),
	(22, 'semester-create', 'web', '2022-05-10 04:23:37', '2022-05-10 04:23:37'),
	(23, 'semester-edit', 'web', '2022-05-10 04:23:37', '2022-05-10 04:23:37'),
	(24, 'semester-delete', 'web', '2022-05-10 04:23:37', '2022-05-10 04:23:37'),
	(25, 'setmatakuliah-list', 'web', '2022-05-12 02:55:57', '2022-05-12 02:55:57'),
	(26, 'setmatakuliah-create', 'web', '2022-05-12 02:55:57', '2022-05-12 02:55:57'),
	(27, 'setpengampu-list', 'web', '2022-05-12 05:35:57', '2022-05-12 05:35:57'),
	(28, 'setpengampu-create', 'web', '2022-05-12 05:35:57', '2022-05-12 05:35:57'),
	(29, 'permission-list', 'web', '2022-05-13 07:54:48', '2022-05-13 07:54:48'),
	(30, 'permission-create', 'web', '2022-05-13 07:54:48', '2022-05-13 07:54:48'),
	(31, 'permission-edit', 'web', '2022-05-13 07:54:48', '2022-05-13 07:54:48'),
	(32, 'permission-delete', 'web', '2022-05-13 07:54:48', '2022-05-13 07:54:48'),
	(33, 'role-list', 'web', '2022-05-13 07:54:48', '2022-05-13 07:54:48'),
	(34, 'role-create', 'web', '2022-05-13 07:54:48', '2022-05-13 07:54:48'),
	(35, 'role-edit', 'web', '2022-05-13 07:54:48', '2022-05-13 07:54:48'),
	(36, 'role-delete', 'web', '2022-05-13 07:54:48', '2022-05-13 07:54:48'),
	(37, 'pengajuan-alat-bahan-list', 'web', '2022-05-17 11:18:33', '2022-06-17 05:47:18'),
	(38, 'tahunajaran-list', 'web', '2022-05-31 04:00:18', '2022-05-31 04:00:18'),
	(39, 'tahunajaran-create', 'web', '2022-05-31 04:00:18', '2022-05-31 04:00:18'),
	(40, 'tahunajaran-edit', 'web', '2022-05-31 04:00:18', '2022-05-31 04:00:18'),
	(41, 'tahunajaran-delete', 'web', '2022-05-31 04:00:18', '2022-05-31 04:00:18'),
	(42, 'minggu-list', 'web', '2022-06-01 08:20:55', '2022-06-01 08:20:55'),
	(43, 'minggu-create', 'web', '2022-06-01 08:20:55', '2022-06-01 08:20:55'),
	(44, 'minggu-edit', 'web', '2022-06-01 08:20:56', '2022-06-01 08:20:56'),
	(45, 'minggu-delete', 'web', '2022-06-01 08:20:56', '2022-06-01 08:20:56'),
	(46, 'pengajuan-alat-bahan-create', 'web', '2022-06-17 03:24:14', '2022-06-17 03:24:14'),
	(47, 'pengajuan-alat-bahan-edit', 'web', '2022-06-17 03:24:14', '2022-06-17 03:24:14'),
	(48, 'pengajuan-alat-bahan-delete', 'web', '2022-06-17 03:24:15', '2022-06-17 03:24:15'),
	(49, 'satuan-list', 'web', '2022-06-20 04:20:01', '2022-06-20 04:20:01'),
	(50, 'satuan-create', 'web', '2022-06-20 04:20:01', '2022-06-20 04:20:01'),
	(51, 'satuan-edit', 'web', '2022-06-20 04:20:01', '2022-06-20 04:20:01'),
	(52, 'satuan-delete', 'web', '2022-06-20 04:20:01', '2022-06-20 04:20:01'),
	(53, 'barang-list', 'web', '2022-06-22 02:54:26', '2022-06-22 02:54:26'),
	(54, 'barang-create', 'web', '2022-06-22 02:54:26', '2022-06-22 02:54:26'),
	(55, 'barang-edit', 'web', '2022-06-22 02:54:26', '2022-06-22 02:54:26'),
	(56, 'barang-delete', 'web', '2022-06-22 02:54:26', '2022-06-22 02:54:26');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;

-- Dumping structure for table silab.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table silab.personal_access_tokens: ~0 rows (approximately)
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;

-- Dumping structure for table silab.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table silab.roles: ~3 rows (approximately)
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
	(1, 'Administrator', 'web', '2022-04-17 16:05:58', '2022-04-17 16:05:58'),
	(2, 'Koordinator Matakuliah', 'web', '2022-05-13 02:35:01', '2022-05-13 02:35:01');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;

-- Dumping structure for table silab.role_has_permissions
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table silab.role_has_permissions: ~56 rows (approximately)
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
	(1, 1),
	(2, 1),
	(3, 1),
	(4, 1),
	(7, 1),
	(8, 1),
	(9, 1),
	(10, 1),
	(11, 1),
	(12, 1),
	(13, 1),
	(14, 1),
	(15, 1),
	(16, 1),
	(17, 1),
	(18, 1),
	(19, 1),
	(20, 1),
	(21, 1),
	(22, 1),
	(23, 1),
	(24, 1),
	(25, 1),
	(26, 1),
	(27, 1),
	(28, 1),
	(29, 1),
	(30, 1),
	(31, 1),
	(32, 1),
	(33, 1),
	(34, 1),
	(35, 1),
	(36, 1),
	(38, 1),
	(39, 1),
	(40, 1),
	(41, 1),
	(42, 1),
	(43, 1),
	(44, 1),
	(45, 1),
	(49, 1),
	(50, 1),
	(51, 1),
	(52, 1),
	(53, 1),
	(54, 1),
	(55, 1),
	(56, 1),
	(3, 2),
	(25, 2),
	(27, 2),
	(37, 2),
	(46, 2),
	(47, 2);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;

-- Dumping structure for table silab.td_satuan
CREATE TABLE IF NOT EXISTS `td_satuan` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `qty` int(10) unsigned DEFAULT NULL,
  `tm_satuan_id` smallint(5) unsigned DEFAULT NULL,
  `tm_barang_id` int(10) unsigned DEFAULT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `td_satuan_user_id_foreign` (`user_id`),
  KEY `td_satuan_tm_satuan_id_foreign` (`tm_satuan_id`),
  KEY `td_satuan_tm_barang_id_foreign` (`tm_barang_id`),
  CONSTRAINT `td_satuan_tm_barang_id_foreign` FOREIGN KEY (`tm_barang_id`) REFERENCES `tm_barang` (`id`) ON DELETE SET NULL,
  CONSTRAINT `td_satuan_tm_satuan_id_foreign` FOREIGN KEY (`tm_satuan_id`) REFERENCES `tm_satuan` (`id`) ON DELETE SET NULL,
  CONSTRAINT `td_satuan_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table silab.td_satuan: ~12 rows (approximately)
/*!40000 ALTER TABLE `td_satuan` DISABLE KEYS */;
INSERT INTO `td_satuan` (`id`, `qty`, `tm_satuan_id`, `tm_barang_id`, `user_id`, `created_at`, `updated_at`) VALUES
	(1, 450, 2, 1, 1, '2022-06-30 15:28:01', '2022-07-01 08:43:46'),
	(2, 2500, 3, 1, 1, '2022-06-30 15:28:01', '2022-06-30 15:28:01'),
	(7, 500, 2, 2, 1, '2022-07-02 04:35:02', '2022-07-02 04:35:02'),
	(11, 500, 2, 3, 1, '2022-07-02 04:50:28', '2022-07-02 04:57:50'),
	(12, 500, 2, 4, 1, '2022-07-02 04:54:16', '2022-07-02 04:54:16'),
	(13, 2500, 3, 4, 1, '2022-07-02 04:54:16', '2022-07-02 04:55:13'),
	(14, 1345, 2, NULL, 1, '2022-07-02 04:58:46', '2022-07-02 04:58:46'),
	(15, 24000, 3, NULL, 1, '2022-07-02 04:58:46', '2022-07-02 04:58:46'),
	(16, 12, 5, 12, 1, '2022-07-02 14:25:53', '2022-07-02 14:25:53'),
	(17, 12, 5, 13, 1, '2022-07-02 14:26:42', '2022-07-02 14:26:42'),
	(18, 12, 5, 14, 1, '2022-07-02 14:29:45', '2022-07-02 14:29:45'),
	(19, 12, 5, 15, 1, '2022-07-02 14:31:13', '2022-07-02 14:31:13');
/*!40000 ALTER TABLE `td_satuan` ENABLE KEYS */;

-- Dumping structure for table silab.tm_barang
CREATE TABLE IF NOT EXISTS `tm_barang` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama_barang` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `spesifikasi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `tm_satuan_id` smallint(5) unsigned DEFAULT NULL,
  `tm_jenis_barang_id` tinyint(3) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `qty` int(10) unsigned DEFAULT NULL,
  `kode_barang` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tm_barang_user_id_foreign` (`user_id`),
  KEY `tm_barang_tm_satuan_id_foreign` (`tm_satuan_id`),
  KEY `tm_barang_tm_jenis_barang_id_foreign` (`tm_jenis_barang_id`),
  CONSTRAINT `tm_barang_tm_jenis_barang_id_foreign` FOREIGN KEY (`tm_jenis_barang_id`) REFERENCES `tm_jenis_barang` (`id`) ON DELETE SET NULL,
  CONSTRAINT `tm_barang_tm_satuan_id_foreign` FOREIGN KEY (`tm_satuan_id`) REFERENCES `tm_satuan` (`id`) ON DELETE SET NULL,
  CONSTRAINT `tm_barang_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table silab.tm_barang: ~14 rows (approximately)
/*!40000 ALTER TABLE `tm_barang` DISABLE KEYS */;
INSERT INTO `tm_barang` (`id`, `nama_barang`, `spesifikasi`, `keterangan`, `user_id`, `tm_satuan_id`, `tm_jenis_barang_id`, `created_at`, `updated_at`, `qty`, `kode_barang`) VALUES
	(1, 'Kertas HVS A4 80Gr', NULL, NULL, 1, 1, 2, '2022-06-30 15:28:01', '2022-07-02 04:35:44', NULL, NULL),
	(2, 'Kertas HVS A4 70Gr', NULL, NULL, 1, 1, 2, '2022-07-02 04:35:02', '2022-07-02 04:35:02', NULL, NULL),
	(3, 'Kertas HVS F4 70Gr', NULL, NULL, 1, 1, 2, '2022-07-02 04:40:20', '2022-07-02 04:58:00', NULL, NULL),
	(4, 'Kertas HVS F4 80Gr', NULL, NULL, 1, 1, 2, '2022-07-02 04:54:16', '2022-07-02 04:57:16', NULL, NULL),
	(7, 'Sticky Note 653 (39mm X 51mm)', NULL, NULL, 1, 4, 1, '2022-07-02 14:10:15', '2022-07-02 14:10:15', NULL, NULL),
	(8, 'Sticky Note 654 (76mm X 77mm)', NULL, NULL, 1, 4, 2, '2022-07-02 14:11:06', '2022-07-02 14:11:06', NULL, NULL),
	(9, 'Sticky Note 655 (77mm X 127mm)', NULL, NULL, 1, 4, 2, '2022-07-02 14:11:54', '2022-07-02 14:11:54', NULL, NULL),
	(10, 'Sticky Note 656 (77mm X 51mm)', NULL, NULL, 1, 4, 2, '2022-07-02 14:12:49', '2022-07-02 14:12:49', NULL, NULL),
	(11, 'Sticky Note 657 (77mm X 102mm)', NULL, NULL, 1, 4, 2, '2022-07-02 14:19:28', '2022-07-02 14:19:28', NULL, NULL),
	(12, 'Snowman White Board BG (hitam)', NULL, NULL, 1, 4, 2, '2022-07-02 14:25:52', '2022-07-02 14:25:52', NULL, NULL),
	(13, 'Snowman White Board BG (Biru)', NULL, NULL, 1, 4, 2, '2022-07-02 14:26:41', '2022-07-02 14:28:38', NULL, NULL),
	(14, 'Snowman White Board BG (Hijau)', NULL, NULL, 1, 4, 2, '2022-07-02 14:29:45', '2022-07-02 14:30:16', NULL, NULL),
	(15, 'Snowman White Board BG (Merah)', NULL, NULL, 1, 4, 2, '2022-07-02 14:31:12', '2022-07-02 14:31:12', NULL, NULL),
	(16, 'Kertas Manila Putih A1', NULL, NULL, 1, 1, 2, '2022-07-02 14:36:09', '2022-07-02 14:36:09', NULL, NULL);
/*!40000 ALTER TABLE `tm_barang` ENABLE KEYS */;

-- Dumping structure for table silab.tm_jenis_barang
CREATE TABLE IF NOT EXISTS `tm_jenis_barang` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `jenis_barang` varchar(8) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table silab.tm_jenis_barang: ~2 rows (approximately)
/*!40000 ALTER TABLE `tm_jenis_barang` DISABLE KEYS */;
INSERT INTO `tm_jenis_barang` (`id`, `jenis_barang`, `created_at`, `updated_at`) VALUES
	(1, 'Alat', '2022-06-20 15:02:30', '2022-06-20 15:02:30'),
	(2, 'Bahan', '2022-06-20 15:02:43', '2022-06-20 15:02:43');
/*!40000 ALTER TABLE `tm_jenis_barang` ENABLE KEYS */;

-- Dumping structure for table silab.tm_jurusan
CREATE TABLE IF NOT EXISTS `tm_jurusan` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `kode` varchar(8) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jurusan` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tm_jurusan_user_id_foreign` (`user_id`),
  CONSTRAINT `tm_jurusan_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table silab.tm_jurusan: ~8 rows (approximately)
/*!40000 ALTER TABLE `tm_jurusan` DISABLE KEYS */;
INSERT INTO `tm_jurusan` (`id`, `kode`, `jurusan`, `user_id`, `created_at`, `updated_at`) VALUES
	(4, 'PL17.3.1', 'Jurusan Produksi Pertanian', 1, '2022-05-10 03:49:52', '2022-05-12 01:40:33'),
	(5, 'PL17.3.2', 'Jurusan Teknologi Pertanian', 1, '2022-05-10 04:00:45', '2022-05-10 04:00:45'),
	(6, 'PL17.3.3', 'Jurusan Peternakan', 1, '2022-05-10 04:03:21', '2022-05-10 04:03:21'),
	(7, 'PL17.3.4', 'Jurusan Manajemen Agribisnis', 1, '2022-05-10 04:05:11', '2022-05-10 04:05:11'),
	(8, 'PL17.3.5', 'Jurusan Teknologi Informasi', 1, '2022-05-10 04:05:41', '2022-05-10 04:05:41'),
	(9, 'PL17.3.6', 'Jurusan Bahasa Komunikasi Dan Pariwisata', 1, '2022-05-10 04:18:43', '2022-05-10 04:18:43'),
	(10, 'PL17.3.7', 'Jurusan Kesehatan', 1, '2022-05-10 04:19:08', '2022-05-10 04:19:08'),
	(11, 'PL17.3.8', 'Jurusan Teknik', 1, '2022-05-10 04:19:31', '2022-05-10 04:19:31');
/*!40000 ALTER TABLE `tm_jurusan` ENABLE KEYS */;

-- Dumping structure for table silab.tm_matakuliah
CREATE TABLE IF NOT EXISTS `tm_matakuliah` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `kode` varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `matakuliah` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_aktif` tinyint(1) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tm_matakuliah_user_id_foreign` (`user_id`),
  CONSTRAINT `tm_matakuliah_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=112 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table silab.tm_matakuliah: ~110 rows (approximately)
/*!40000 ALTER TABLE `tm_matakuliah` DISABLE KEYS */;
INSERT INTO `tm_matakuliah` (`id`, `kode`, `matakuliah`, `is_aktif`, `user_id`, `created_at`, `updated_at`) VALUES
	(2, 'MIF120701', 'Bahasa Indonesia', 1, 1, '2022-05-11 08:53:23', '2022-05-12 01:12:03'),
	(3, 'MIF120702', 'Kewarganegaraan', 1, 1, '2022-05-11 08:53:23', '2022-05-11 08:53:23'),
	(4, 'MIF120703', 'Intermediate English', 1, 1, '2022-05-11 08:53:23', '2022-05-11 08:53:23'),
	(5, 'MIF120704', 'Pemrograman Berorientasi Objek', 1, 1, '2022-05-11 08:53:23', '2022-05-11 08:53:23'),
	(6, 'MIF120705', 'Desain Web', 1, 1, '2022-05-11 08:53:23', '2022-05-11 08:53:23'),
	(7, 'MIF120706', 'Analisis Dan Desain Sistem Informasi', 1, 1, '2022-05-11 08:53:23', '2022-05-11 08:53:23'),
	(8, 'MIF120707', 'Workshop Pengembangan Aplikasi', 1, 1, '2022-05-11 08:53:23', '2022-05-11 08:53:23'),
	(9, 'MIF120708', 'Workshop Manajemen Basisdata', 1, 1, '2022-05-11 08:53:23', '2022-05-11 08:53:23'),
	(10, 'MIF120703', 'Praktik Intermediate English', 1, 1, '2022-05-11 08:53:24', '2022-05-11 08:53:24'),
	(11, 'MIF140701', 'Teknik Penulisan Ilmiah', 1, 1, '2022-05-11 08:55:51', '2022-05-11 08:55:51'),
	(12, 'MIF140702', 'Data Mining', 1, 1, '2022-05-11 08:55:51', '2022-05-11 08:55:51'),
	(13, 'MIF140703', 'Pemrograman Mobile', 1, 1, '2022-05-11 08:55:51', '2022-05-11 08:55:51'),
	(14, 'MIF140704', 'Interpersonal Skill', 1, 1, '2022-05-11 08:55:51', '2022-05-11 08:55:51'),
	(15, 'MIF140705', 'Agroinformatika', 1, 1, '2022-05-11 08:55:51', '2022-05-11 08:55:51'),
	(16, 'MIF140706', 'Customer Relationship Management', 1, 1, '2022-05-11 08:55:51', '2022-05-11 08:55:51'),
	(17, 'MIF140707', 'Workshop Progressive Web Apps', 1, 1, '2022-05-11 08:55:51', '2022-05-11 08:55:51'),
	(18, 'MIF140708', 'Workshop Basisdata Lanjut', 1, 1, '2022-05-11 08:55:51', '2022-05-11 08:55:51'),
	(19, 'MIF160701', 'Bisnis Jasa Informatika', 1, 1, '2022-05-11 08:56:43', '2022-05-11 08:56:43'),
	(20, 'MIF160702', 'Manajemen Proyek Sistem Informasi', 1, 1, '2022-05-11 08:56:43', '2022-05-11 08:56:43'),
	(21, 'MIF160703', 'Tugas Akhir', 1, 1, '2022-05-11 08:56:43', '2022-05-11 08:56:43'),
	(22, 'MIF110701', 'Agama', 1, 1, '2022-05-11 09:04:32', '2022-05-11 09:04:32'),
	(23, 'MIF110702', 'Pancasila', 1, 1, '2022-05-11 09:04:32', '2022-05-11 09:04:32'),
	(24, 'MIF110703', 'Basic English', 1, 1, '2022-05-11 09:04:32', '2022-05-11 09:04:32'),
	(25, 'MIF110704', 'Algoritma Pemrograman', 1, 1, '2022-05-11 09:04:32', '2022-05-11 09:04:32'),
	(26, 'MIF110705', 'Dasar Manajemen', 1, 1, '2022-05-11 09:04:32', '2022-05-11 09:04:32'),
	(27, 'MIF110706', 'Basis Data', 1, 1, '2022-05-11 09:04:32', '2022-05-11 09:04:32'),
	(28, 'MIF110707', 'Statistika Terapan', 1, 1, '2022-05-11 09:04:32', '2022-05-11 09:04:32'),
	(29, 'MIF110708', 'Workshop Basis Data Relational', 1, 1, '2022-05-11 09:04:32', '2022-05-11 09:04:32'),
	(30, 'MIF110709', 'Workshop Pemrograman Dasar', 1, 1, '2022-05-11 09:04:32', '2022-05-11 09:04:32'),
	(31, 'MIF110703', 'Praktik Basic English', 1, 1, '2022-05-11 09:04:32', '2022-05-11 09:04:32'),
	(32, 'MIF130701', 'Kewirausahaan', 1, 1, '2022-05-11 09:07:45', '2022-05-11 09:07:45'),
	(33, 'MIF130702', 'Sistem Informasi Geografis', 1, 1, '2022-05-11 09:07:45', '2022-05-11 09:07:45'),
	(34, 'MIF130703', 'Manajemen Operasional', 1, 1, '2022-05-11 09:07:45', '2022-05-11 09:07:45'),
	(35, 'MIF130704', 'Kecerdasan Bisnis Terapan', 1, 1, '2022-05-11 09:07:45', '2022-05-11 09:07:45'),
	(36, 'MIF130705', 'Komunikasi Visual', 1, 1, '2022-05-11 09:07:45', '2022-05-11 09:07:45'),
	(37, 'MIF130706', 'Literasi Digital', 1, 1, '2022-05-11 09:07:45', '2022-05-11 09:07:45'),
	(38, 'MIF130707', 'Workshop Sistem Informasi', 1, 1, '2022-05-11 09:07:45', '2022-05-11 09:07:45'),
	(39, 'MIF130708', 'Workshop Visualisasi Data', 1, 1, '2022-05-11 09:07:45', '2022-05-11 09:07:45'),
	(40, 'MIF150701', 'Magang', 1, 1, '2022-05-11 09:08:08', '2022-05-11 09:08:08'),
	(41, 'TKK150701', 'Magang', 1, 1, '2022-05-11 09:08:36', '2022-05-11 09:08:36'),
	(42, 'TKK130701', 'Sistem Pertanian Digital', 1, 1, '2022-05-11 09:10:23', '2022-05-11 09:10:23'),
	(43, 'TKK130702', 'Manajemen Basis Data', 1, 1, '2022-05-11 09:10:23', '2022-05-11 09:10:23'),
	(44, 'TKK130703', 'Routing Dan Switching', 1, 1, '2022-05-11 09:10:23', '2022-05-11 09:10:23'),
	(45, 'TKK130704', 'Keamanan Jaringan', 1, 1, '2022-05-11 09:10:23', '2022-05-11 09:10:23'),
	(46, 'TKK130705', 'Mikrokomputer', 1, 1, '2022-05-11 09:10:23', '2022-05-11 09:10:23'),
	(47, 'TKK130706', 'Workshop Sistem Tertanam', 1, 1, '2022-05-11 09:10:23', '2022-05-11 09:10:23'),
	(48, 'TKK130707', 'Workshop Jaringan Wan', 1, 1, '2022-05-11 09:10:23', '2022-05-11 09:10:23'),
	(49, 'TKK130708', 'Workshop Aplikasi Mobile', 1, 1, '2022-05-11 09:10:23', '2022-05-11 09:10:23'),
	(50, 'TKK110701', 'Agama', 1, 1, '2022-05-11 09:13:12', '2022-05-11 09:13:12'),
	(51, 'TKK110702', 'Pancasila', 1, 1, '2022-05-11 09:13:12', '2022-05-11 09:13:12'),
	(52, 'TKK110703', 'Basic English', 1, 1, '2022-05-11 09:13:12', '2022-05-11 09:13:12'),
	(53, 'TKK110704', 'Literasi Digital', 1, 1, '2022-05-11 09:13:12', '2022-05-11 09:13:12'),
	(54, 'TKK110705', 'Logika Dan Algoritma Pemrograman', 1, 1, '2022-05-11 09:13:12', '2022-05-11 09:13:12'),
	(55, 'TKK110706', 'Sistem Operasi', 1, 1, '2022-05-11 09:13:12', '2022-05-11 09:13:12'),
	(56, 'TKK110707', 'Workshop Administrasi Sistem', 1, 1, '2022-05-11 09:13:12', '2022-05-11 09:13:12'),
	(57, 'TKK110708', 'Workshop Pemrograman Dasar', 1, 1, '2022-05-11 09:13:12', '2022-05-11 09:13:12'),
	(58, 'TKK110703', 'Praktik Basic English', 1, 1, '2022-05-11 09:13:12', '2022-05-11 09:13:12'),
	(59, 'TKK120701', 'Bahasa Indonesia', 1, 1, '2022-05-11 09:18:39', '2022-05-11 09:18:39'),
	(60, 'TKK120702', 'Kewarganegaraan', 1, 1, '2022-05-11 09:18:39', '2022-05-11 09:18:39'),
	(61, 'TKK120703', 'Intermediate English', 1, 1, '2022-05-11 09:18:39', '2022-05-11 09:18:39'),
	(62, 'TKK120704', 'Sistem Kontrol Elektronik', 1, 1, '2022-05-11 09:18:39', '2022-05-11 09:18:39'),
	(63, 'TKK120705', 'Jaringan Komputer', 1, 1, '2022-05-11 09:18:39', '2022-05-11 09:18:39'),
	(64, 'TKK120706', 'Workshop Infrastruktur Jaringan Komputer', 1, 1, '2022-05-11 09:18:39', '2022-05-11 09:18:39'),
	(65, 'TKK120707', 'Workshop Pemrograman Web', 1, 1, '2022-05-11 09:18:39', '2022-05-11 09:18:39'),
	(66, 'TKK120708', 'Workshop Elektronika Terapan', 1, 1, '2022-05-11 09:18:39', '2022-05-11 09:18:39'),
	(67, 'TKK120703', 'Praktik Intermediate English', 1, 1, '2022-05-11 09:18:39', '2022-05-11 09:18:39'),
	(68, 'TKK140701', 'Teknik Penulisan Ilmiah', 1, 1, '2022-05-11 09:21:13', '2022-05-11 09:21:13'),
	(69, 'TKK140702', 'Interpersonal Skill', 1, 1, '2022-05-11 09:21:13', '2022-05-11 09:21:13'),
	(70, 'TKK140703', 'Komputasi Awan', 1, 1, '2022-05-11 09:21:13', '2022-05-11 09:21:13'),
	(71, 'TKK140704', 'Jaringan Berbasis Software', 1, 1, '2022-05-11 09:21:13', '2022-05-11 09:21:13'),
	(72, 'TKK140705', 'Sistem Otomasi', 1, 1, '2022-05-11 09:21:13', '2022-05-11 09:21:13'),
	(73, 'TKK140706', 'Internet Of Things', 1, 1, '2022-05-11 09:21:13', '2022-05-11 09:21:13'),
	(74, 'TKK140707', 'Workshop Komputasi Awan', 1, 1, '2022-05-11 09:21:13', '2022-05-11 09:21:13'),
	(75, 'TKK140708', 'Workshop Sistem Komputer Kontrol', 1, 1, '2022-05-11 09:21:13', '2022-05-11 09:21:13'),
	(76, 'TKK160701', 'Kewirausahaan', 1, 1, '2022-05-11 09:22:20', '2022-05-11 09:22:20'),
	(77, 'TKK160702', 'Tugas Akhir', 1, 1, '2022-05-11 09:22:20', '2022-05-11 09:22:20'),
	(78, 'TIF120701', 'Bahasa Indonesia', 1, 1, '2022-05-11 09:25:14', '2022-05-11 09:25:14'),
	(79, 'TIF120702', 'Kewarganegaraan', 1, 1, '2022-05-11 09:25:14', '2022-05-11 09:25:14'),
	(80, 'TIF120703', 'Intermediate English', 1, 1, '2022-05-11 09:25:14', '2022-05-11 09:25:14'),
	(81, 'TIF120704', 'Interaksi Manusia Dan Komputer', 1, 1, '2022-05-11 09:25:14', '2022-05-11 09:25:14'),
	(82, 'TIF120705', 'Sistem Aplikasi Berbasis Obyek', 1, 1, '2022-05-11 09:25:14', '2022-05-11 09:25:14'),
	(83, 'TIF120706', 'Perencanaan Proyek Perangkat Lunak', 1, 1, '2022-05-11 09:25:14', '2022-05-11 09:25:14'),
	(84, 'TIF120707', 'Workshop Sistem Informasi Berbasis Desktop', 1, 1, '2022-05-11 09:25:14', '2022-05-11 09:25:14'),
	(85, 'TIF120708', 'Workshop Manajemen Proyek', 1, 1, '2022-05-11 09:25:14', '2022-05-11 09:25:14'),
	(86, 'TIF120703', 'Praktik Intermediate English', 1, 1, '2022-05-11 09:25:14', '2022-05-11 09:25:14'),
	(87, 'TIF140701', 'Literasi Digital', 1, 1, '2022-05-11 09:27:07', '2022-05-11 09:27:07'),
	(88, 'TIF140702', 'Kewirausahaan', 1, 1, '2022-05-11 09:27:07', '2022-05-11 09:27:07'),
	(89, 'TIF140703', 'Manajemen Kualitas Perangkat Lunak', 1, 1, '2022-05-11 09:27:07', '2022-05-11 09:27:07'),
	(90, 'TIF140704', 'Perawatan Perangkat Lunak', 1, 1, '2022-05-11 09:27:07', '2022-05-11 09:27:07'),
	(91, 'TIF140705', 'Pengujian Perangkat Lunak', 1, 1, '2022-05-11 09:27:07', '2022-05-11 09:27:07'),
	(92, 'TIF140706', 'Workshop Sistem Informasi Web Framework', 1, 1, '2022-05-11 09:27:07', '2022-05-11 09:27:07'),
	(93, 'TIF140707', 'Workshop Mobile Applications Framework', 1, 1, '2022-05-11 09:27:07', '2022-05-11 09:27:07'),
	(94, 'TIF130701', 'Interpersonal Skill', 1, 1, '2022-05-11 09:29:27', '2022-05-11 09:29:27'),
	(95, 'TIF160701', 'Teknik Penulisan Ilmiah', 1, 1, '2022-05-11 09:29:27', '2022-05-11 09:29:27'),
	(96, 'TIF160703', 'Tren Teknologi', 1, 1, '2022-05-11 09:29:27', '2022-05-11 09:29:27'),
	(97, 'TIF160704', 'Data Warehouse', 1, 1, '2022-05-11 09:29:27', '2022-05-11 09:29:27'),
	(98, 'TIF160705', 'Workshop Developer Operational', 1, 1, '2022-05-11 09:29:27', '2022-05-11 09:29:27'),
	(99, 'TIF160706', 'Workshop Tata Kelola Teknologi Informasi', 1, 1, '2022-05-11 09:29:27', '2022-05-11 09:29:27'),
	(100, 'TIF160707', 'Workshop Proyek Sistem Informasi', 1, 1, '2022-05-11 09:29:27', '2022-05-11 09:29:27'),
	(101, 'TIF130701', 'Interpersonel Skill', 1, 1, '2022-05-11 09:34:33', '2022-05-11 09:34:33'),
	(102, 'TIF140701', 'Literasi Digital', 1, 1, '2022-05-11 09:34:33', '2022-05-11 09:34:33'),
	(103, 'TIF180701', 'Skripsi', 1, 1, '2022-05-11 09:34:33', '2022-05-11 09:34:33'),
	(104, 'TIF170701', 'Magang', 1, 1, '2022-05-11 09:37:09', '2022-05-11 09:37:09'),
	(105, 'TIF150701', 'Aplikasi Sistem Tertanam', 1, 1, '2022-05-11 09:39:20', '2022-05-11 09:39:20'),
	(106, 'TIF150702', 'Sistem Cerdas', 1, 1, '2022-05-11 09:39:20', '2022-05-11 09:39:20'),
	(107, 'TIF150703', 'Agroinformatika', 1, 1, '2022-05-11 09:39:20', '2022-05-11 09:39:20'),
	(108, 'TIF150704', 'Multimedia Permainan', 1, 1, '2022-05-11 09:39:20', '2022-05-11 09:39:20'),
	(109, 'TIF150705', 'Workshop Pengolahan Citra Dan Vision', 1, 1, '2022-05-11 09:39:20', '2022-05-11 09:39:20'),
	(110, 'TIF150706', 'Workshop Sistem Tertanam', 1, 1, '2022-05-11 09:39:20', '2022-05-11 09:39:20'),
	(111, 'TIF150707', 'Workshop Sistem Cerdas', 1, 1, '2022-05-11 09:39:20', '2022-05-11 09:39:20');
/*!40000 ALTER TABLE `tm_matakuliah` ENABLE KEYS */;

-- Dumping structure for table silab.tm_minggu
CREATE TABLE IF NOT EXISTS `tm_minggu` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `minggu_ke` tinyint(3) unsigned NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `tm_tahun_ajaran_id` tinyint(3) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tm_minggu_tm_tahun_ajaran_id_foreign` (`tm_tahun_ajaran_id`),
  CONSTRAINT `tm_minggu_tm_tahun_ajaran_id_foreign` FOREIGN KEY (`tm_tahun_ajaran_id`) REFERENCES `tm_tahun_ajaran` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table silab.tm_minggu: ~16 rows (approximately)
/*!40000 ALTER TABLE `tm_minggu` DISABLE KEYS */;
INSERT INTO `tm_minggu` (`id`, `minggu_ke`, `start_date`, `end_date`, `tm_tahun_ajaran_id`, `created_at`, `updated_at`, `keterangan`) VALUES
	(3, 1, '2022-02-07', '2022-02-12', 6, '2022-06-01 15:08:20', '2022-07-03 01:29:10', NULL),
	(4, 2, '2022-03-14', '2022-03-19', 6, '2022-06-10 06:29:43', '2022-07-03 01:29:43', NULL),
	(5, 3, '2022-03-21', '2022-03-26', 6, '2022-07-03 01:30:17', '2022-07-03 01:30:17', NULL),
	(6, 4, '2022-03-28', '2022-04-02', 6, '2022-07-03 01:31:04', '2022-07-03 01:31:04', NULL),
	(7, 5, '2022-04-04', '2022-04-09', 6, '2022-07-03 01:32:08', '2022-07-03 01:32:08', NULL),
	(8, 6, '2022-04-11', '2022-04-16', 6, '2022-07-03 01:32:32', '2022-07-03 01:32:32', NULL),
	(9, 7, '2022-04-18', '2022-04-23', 6, '2022-07-03 01:33:07', '2022-07-03 01:33:07', NULL),
	(10, 8, '2022-04-25', '2022-04-30', 6, '2022-07-03 01:33:32', '2022-07-03 01:33:32', NULL),
	(11, 9, '2022-05-02', '2022-05-07', 6, '2022-07-03 01:33:54', '2022-07-03 01:33:54', NULL),
	(12, 10, '2022-05-09', '2022-05-14', 6, '2022-07-03 01:34:17', '2022-07-03 01:34:17', NULL),
	(13, 11, '2022-05-16', '2022-05-21', 6, '2022-07-03 01:34:40', '2022-07-03 01:34:40', NULL),
	(14, 12, '2022-05-23', '2022-05-28', 6, '2022-07-03 01:35:04', '2022-07-03 01:35:04', NULL),
	(15, 13, '2022-05-30', '2022-06-04', 6, '2022-07-03 01:35:30', '2022-07-03 01:35:30', NULL),
	(16, 14, '2022-06-06', '2022-06-11', 6, '2022-07-03 01:35:55', '2022-07-03 01:35:55', NULL),
	(17, 15, '2022-06-13', '2022-06-18', 6, '2022-07-03 01:36:33', '2022-07-03 01:36:33', NULL),
	(18, 16, '2022-06-20', '2022-06-25', 6, '2022-07-03 01:36:53', '2022-07-03 01:36:53', NULL);
/*!40000 ALTER TABLE `tm_minggu` ENABLE KEYS */;

-- Dumping structure for table silab.tm_program_studi
CREATE TABLE IF NOT EXISTS `tm_program_studi` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `kode` varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `program_studi` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tm_jurusan_id` tinyint(3) unsigned NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tm_program_studi_tm_jurusan_id_foreign` (`tm_jurusan_id`),
  KEY `tm_program_studi_user_id_foreign` (`user_id`),
  CONSTRAINT `tm_program_studi_tm_jurusan_id_foreign` FOREIGN KEY (`tm_jurusan_id`) REFERENCES `tm_jurusan` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tm_program_studi_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table silab.tm_program_studi: ~3 rows (approximately)
/*!40000 ALTER TABLE `tm_program_studi` DISABLE KEYS */;
INSERT INTO `tm_program_studi` (`id`, `kode`, `program_studi`, `tm_jurusan_id`, `user_id`, `created_at`, `updated_at`) VALUES
	(3, 'PL17.3.5.1', 'Manajemen Informatika', 8, 1, '2022-05-10 04:20:48', '2022-05-10 04:20:48'),
	(4, 'PL17.3.5.2', 'Teknik Komputer', 8, 1, '2022-05-10 04:21:06', '2022-05-10 04:21:06'),
	(5, 'PL17.3.5.3', 'Teknik Informatika', 8, 1, '2022-05-10 04:21:49', '2022-05-10 04:21:49');
/*!40000 ALTER TABLE `tm_program_studi` ENABLE KEYS */;

-- Dumping structure for table silab.tm_satuan
CREATE TABLE IF NOT EXISTS `tm_satuan` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `satuan` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tm_satuan_user_id_foreign` (`user_id`),
  CONSTRAINT `tm_satuan_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table silab.tm_satuan: ~5 rows (approximately)
/*!40000 ALTER TABLE `tm_satuan` DISABLE KEYS */;
INSERT INTO `tm_satuan` (`id`, `satuan`, `user_id`, `created_at`, `updated_at`) VALUES
	(1, 'Lembar', 1, '2022-06-20 07:04:16', '2022-07-01 08:28:01'),
	(2, 'Rim', 1, '2022-06-20 07:50:48', '2022-06-20 07:50:48'),
	(3, 'Dus', 1, '2022-06-30 14:48:25', '2022-06-30 14:48:25'),
	(4, 'pcs', 1, '2022-07-02 14:07:49', '2022-07-02 14:07:49'),
	(5, 'pack', 1, '2022-07-02 14:08:18', '2022-07-02 14:08:18');
/*!40000 ALTER TABLE `tm_satuan` ENABLE KEYS */;

-- Dumping structure for table silab.tm_semester
CREATE TABLE IF NOT EXISTS `tm_semester` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `semester` tinyint(3) unsigned NOT NULL,
  `is_genap` tinyint(1) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tm_tahun_ajaran_id` tinyint(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tm_semester_user_id_foreign` (`user_id`),
  KEY `tm_semester_tm_tahun_ajaran_id_foreign` (`tm_tahun_ajaran_id`),
  CONSTRAINT `tm_semester_tm_tahun_ajaran_id_foreign` FOREIGN KEY (`tm_tahun_ajaran_id`) REFERENCES `tm_tahun_ajaran` (`id`) ON DELETE SET NULL,
  CONSTRAINT `tm_semester_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table silab.tm_semester: ~16 rows (approximately)
/*!40000 ALTER TABLE `tm_semester` DISABLE KEYS */;
INSERT INTO `tm_semester` (`id`, `semester`, `is_genap`, `user_id`, `created_at`, `updated_at`, `tm_tahun_ajaran_id`) VALUES
	(1, 1, 0, 1, '2022-05-10 08:48:20', '2022-05-31 04:21:04', 3),
	(2, 2, 1, 1, '2022-05-10 08:48:42', '2022-05-10 08:48:42', 4),
	(3, 3, 0, 1, '2022-05-10 08:48:52', '2022-05-10 08:48:52', 3),
	(4, 4, 1, 1, '2022-05-10 08:49:01', '2022-05-10 08:49:01', 4),
	(5, 5, 0, 1, '2022-05-10 08:49:11', '2022-05-10 08:49:11', 3),
	(6, 6, 1, 1, '2022-05-10 08:49:21', '2022-05-10 08:49:21', 4),
	(7, 7, 0, 1, '2022-05-10 08:49:31', '2022-05-10 08:49:31', 3),
	(8, 8, 1, 1, '2022-05-10 08:49:44', '2022-05-10 08:49:44', 4),
	(9, 1, 0, 1, '2022-05-11 08:38:18', '2022-05-11 08:38:18', 5),
	(10, 2, 1, 1, '2022-05-11 08:38:27', '2022-05-11 08:38:27', 6),
	(11, 3, 0, 1, '2022-05-11 08:38:36', '2022-05-11 08:38:36', 5),
	(12, 4, 1, 1, '2022-07-02 15:14:22', '2022-07-02 15:14:22', 6),
	(13, 5, 0, 1, '2022-05-11 08:38:57', '2022-05-11 08:38:57', 5),
	(14, 6, 1, 1, '2022-05-11 08:39:13', '2022-05-11 08:39:13', 6),
	(15, 7, 0, 1, '2022-05-11 08:39:29', '2022-05-11 08:39:29', 5),
	(16, 8, 1, 1, '2022-05-11 08:39:56', '2022-05-31 08:06:46', 6);
/*!40000 ALTER TABLE `tm_semester` ENABLE KEYS */;

-- Dumping structure for table silab.tm_staff
CREATE TABLE IF NOT EXISTS `tm_staff` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kode` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_hp` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_aktif` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table silab.tm_staff: ~87 rows (approximately)
/*!40000 ALTER TABLE `tm_staff` DISABLE KEYS */;
INSERT INTO `tm_staff` (`id`, `kode`, `nama`, `email`, `no_hp`, `foto`, `is_aktif`, `created_at`, `updated_at`) VALUES
	(1, '198911092013041001', 'Novianto Hadi Raharjo', 'novianto_hadi@polije.ac.id', '08980403048', 'r6TRMMa920220426040050.jpg', 1, '2022-04-20 11:39:14', '2022-05-13 03:44:14'),
	(2, NULL, 'test', 'test@gmail.com', NULL, NULL, 0, '2022-04-26 05:13:44', '2022-05-13 02:32:52'),
	(4, NULL, 'Alwan Abdurahman', 'alwan_abdurahman@gmail.com', NULL, NULL, 1, '2021-07-08 10:42:25', '2021-07-08 10:46:00'),
	(5, NULL, 'Luluk Cahyo Wiyono', 'luluk_cahyo_wiyono@gmail.com', NULL, NULL, 1, '2021-07-08 10:43:24', '2021-07-08 10:46:18'),
	(6, NULL, 'Husin', 'husin@gmail.com', NULL, '6X4lNfWs20210719021041.png', 1, '2021-07-08 10:47:01', '2021-07-19 02:10:41'),
	(7, NULL, 'Intan Sulistyaningrum Sakkinah', 'intan_sulistyaningrum_sakkinah@gmail.com', NULL, '5QYqMiAn20210719022755.png', 1, '2021-07-08 10:58:25', '2021-07-19 02:27:55'),
	(8, NULL, 'Syamsul Arifin', 'syamsul_arifin@polije.ac.id', NULL, '2uNfVhzW20210719020707.png', 1, '2021-07-08 11:00:05', '2021-08-13 14:53:30'),
	(9, NULL, 'Didit Rahmat Hartadi', 'didit_rahmat_hartadi@gmail.com', NULL, 'EfHffpHt20210719020908.png', 1, '2021-07-08 11:01:37', '2021-07-19 02:09:08'),
	(10, NULL, 'Nanik Anita Mukhlisoh', 'nanik_anita_mukhlisoh@gmail.com', NULL, 'vymahzc120210719022733.png', 1, '2021-07-08 11:03:08', '2021-07-19 02:27:33'),
	(11, NULL, 'Hendra Yufit Riskiawan', 'hendra_yufit_riskiawan@gmail.com', NULL, 'VXCUZWhW20210719015928.png', 1, '2021-07-08 11:03:50', '2021-07-19 01:59:28'),
	(12, NULL, 'Mukhamad Angga Gumilang', 'mukhamad_angga_gumilang@gmail.com', NULL, 'Sb8Nbt8a20210719022608.png', 1, '2021-07-08 11:05:43', '2021-07-19 02:26:08'),
	(13, NULL, 'Ika Widiastuti', 'ika_widiastuti@gmail.com', NULL, 'XxeK4Hav20210719020736.png', 1, '2021-07-08 11:07:00', '2021-07-19 02:07:36'),
	(14, NULL, 'Ratih Ayuninghemi', 'ratih_ayuninghemi@gmail.com', NULL, 'ZfQZ5M4820210719022145.png', 1, '2021-07-08 11:07:59', '2021-07-19 02:21:45'),
	(15, NULL, 'Ely Mulyadi', 'ely_mulyadi@gmail.com', NULL, 'GYQz2NuO20210719020503.png', 1, '2021-07-08 11:08:54', '2021-07-19 02:05:03'),
	(16, NULL, 'Bakhtiyar Hadi Prakoso', 'bakhtiyar_hadi_prakoso@gmail.com', NULL, NULL, 1, '2021-07-08 11:10:34', '2021-07-08 11:10:34'),
	(17, NULL, 'Choirul Huda', 'choirul_huda@gmail.com', NULL, 'IJvQnjri20210719023112.png', 1, '2021-07-08 11:11:26', '2021-07-19 02:31:12'),
	(18, NULL, 'Surateno', 'surateno@gmail.com', NULL, 'm4TKxLtG20210719021217.jpg', 1, '2021-07-08 11:12:16', '2021-07-19 02:12:17'),
	(19, NULL, 'Dia Bitari Mei Yuana', 'dia_bitari@polije.ac.id', NULL, 'VDTugQk720210719023028.png', 1, '2021-07-11 05:51:07', '2021-07-19 02:30:28'),
	(20, NULL, 'Faisal Lutfi Afriansyah', 'faisal_lutfi@polije.ac.id', NULL, 'SYjG2pTW20210719020527.png', 1, '2021-07-11 05:52:02', '2021-07-19 02:05:27'),
	(21, NULL, 'Taufiq Rizaldi', 'taufiq_rizaldi@polije.ac.id', NULL, 'zGPsamBP20210719021026.png', 1, '2021-07-11 05:52:49', '2021-07-19 02:10:26'),
	(22, NULL, 'Arvita Agus Kurniasari', 'arvita_agus@polije.ac.id', NULL, 'hCHgy6Dh20210719022825.png', 1, '2021-07-11 05:53:32', '2021-07-19 02:28:25'),
	(23, NULL, 'I GEDE WIRYAWAN', 'i_gede_wiryawan@polije.ac.id', NULL, 'tDxdJtKQ20210719022526.png', 1, '2021-07-11 05:54:55', '2021-07-19 02:25:26'),
	(24, NULL, 'Pramuditha Shinta Dewi Puspitasari', 'pramuditha_shinta@polije.ac.id', NULL, '6y2CYu2220210719021145.png', 1, '2021-07-11 05:56:05', '2021-07-19 02:11:45'),
	(25, NULL, 'MUHAMMAD YUNUS', 'muhammad_yunus@polije.ac.id', NULL, NULL, 1, '2021-07-11 05:56:43', '2021-07-11 05:56:43'),
	(26, NULL, 'Dwi Putro Sarwo Setyohadi', 'dwi_putro@polije.ac.id', NULL, '0vjWJlXw20210719020840.png', 1, '2021-07-11 05:57:32', '2021-07-19 02:08:40'),
	(27, NULL, 'Hermawan Arief P', 'hermawan_arief@polije.ac.id', NULL, 'KbcHjmwC20210719021010.png', 1, '2021-07-11 05:58:20', '2021-07-19 02:10:10'),
	(28, NULL, 'Lukie Perdanasari', 'lukie_perdanasari@polije.ac.id', NULL, 'Jl076awv20210719022810.png', 1, '2021-07-11 05:59:10', '2021-07-19 02:28:10'),
	(29, NULL, 'Wahyu Kurnia Dewanto', 'wahyu_kurnia@polije.ac.id', NULL, 'DpyoRB2420210719015831.jpg', 1, '2021-07-11 06:09:05', '2021-07-19 01:58:31'),
	(30, NULL, 'Moch.Munih Dian W', 'moch.munih_dian@polije.ac.id', NULL, '0dqNAJRW20210719022021.png', 1, '2021-07-11 06:09:41', '2021-07-19 02:20:21'),
	(31, NULL, 'Agus Hariyanto', 'agus_hariyanto@polije.ac.id', NULL, 'qP7YKjSi20210719021239.png', 1, '2021-07-11 06:11:58', '2021-07-19 02:12:39'),
	(32, NULL, 'Denny Wijanarko', 'denny_wijanarko@polije.ac.id', NULL, 'dnEkUU9720210719021455.png', 1, '2021-07-11 06:12:28', '2021-07-19 02:14:55'),
	(33, NULL, 'Yogiswara', 'yogiswara@polije.ac.id', NULL, 'nRl44FyN20210719021533.png', 1, '2021-07-11 06:13:15', '2021-07-19 02:15:33'),
	(34, NULL, 'Bekti Maryuni Susanto', 'bekti_maryuni@polije.ac.id', NULL, 'w1Nq6Ya520210719021651.png', 1, '2021-07-11 06:14:11', '2021-07-19 02:16:51'),
	(35, NULL, 'Putri Santika', 'putri_santika@polije.ac.id', NULL, NULL, 1, '2021-07-11 06:14:43', '2021-07-11 06:14:43'),
	(36, NULL, 'Beni Widiawan', 'beni_widiawan@polije.ac.id', NULL, '6WAZDznS20210719021513.png', 1, '2021-07-11 06:16:55', '2021-07-19 02:15:13'),
	(37, NULL, 'Agus Purwadi', 'agus_purwadi@polije.ac.id', NULL, 'URbuiSJV20210719021635.png', 1, '2021-07-11 06:17:24', '2021-07-19 02:16:35'),
	(38, NULL, 'Syamsiar Kautsar', 'syamsiar_kautsar@polije.ac.id', NULL, NULL, 1, '2021-07-11 06:18:00', '2021-07-11 06:18:00'),
	(39, NULL, 'Victor Phoa', 'victor_phoa@polije.ac.id', NULL, 'nr8U8ECG20210719021710.png', 1, '2021-07-11 06:18:47', '2021-07-19 02:17:10'),
	(40, NULL, 'Hariyono Rakhmad', 'hariyono_rakhmad@polije.ac.id', NULL, 'KoE5Iss120210719021437.png', 1, '2021-07-11 06:19:17', '2021-07-19 02:14:37'),
	(41, NULL, 'Shabrina Choirunnisa', 'shabrina_choirunnisa@polije.ac.id', NULL, 'RnC0rUjh20210719022850.png', 1, '2021-07-11 06:25:54', '2021-07-19 02:28:50'),
	(42, NULL, 'Lalitya Nindita Sahenda', 'lalitya_nindita@polije.ac.id', NULL, 'BFmdWXv320210719021732.png', 1, '2021-07-11 06:26:38', '2021-07-19 02:17:32'),
	(43, NULL, 'Zainul Hakim', 'zainul_hakim@polije.ac.id', NULL, NULL, 1, '2021-07-11 06:32:28', '2021-07-11 06:32:28'),
	(44, NULL, 'R. Agus Sariono', 'r_agus_sariono@polije.ac.id', NULL, NULL, 1, '2021-07-11 06:33:03', '2021-07-11 06:33:03'),
	(45, NULL, 'GULLIT TORNADO TAUFAN', 'gullit_tornado@polije.ac.id', NULL, NULL, 1, '2021-07-11 06:33:43', '2021-07-11 06:33:43'),
	(46, NULL, 'Ghanesya Hari Murti', 'ghanesya_hari@polije.ac.id', NULL, NULL, 1, '2021-07-11 06:34:18', '2021-07-11 06:34:18'),
	(47, NULL, 'Adi Heru Utomo', 'adi_heru@polije.ac.id', NULL, 'HhuNd4Dy20210719021939.png', 1, '2021-07-11 06:35:20', '2021-07-19 02:19:39'),
	(48, NULL, 'Zilvanhisna Emka Fitri', 'zilvanhisna_emka@polije.ac.id', NULL, 'cahHS1ga20210719022433.png', 1, '2021-07-11 06:36:01', '2021-07-19 02:24:33'),
	(49, NULL, 'Aji Seto Arifianto', 'aji_seto@polije.ac.id', NULL, 'zuIxbsSU20210719020311.jpg', 1, '2021-07-11 06:36:52', '2021-07-19 02:03:11'),
	(50, NULL, 'Denny Trias Utomo', 'denny_trias@polije.ac.id', NULL, 'Dw5ZaVgM20210719023006.png', 1, '2021-07-11 06:37:41', '2021-07-19 02:30:06'),
	(51, NULL, 'Prawidya Destarianto', 'prawidya_destarianto@polije.ac.id', NULL, 'tKHS4dSD20210719021955.jpg', 1, '2021-07-11 06:38:14', '2021-07-19 02:19:55'),
	(52, NULL, 'Bety Etikasari', 'bety_etikasari@polije.ac.id', NULL, 'qNjtb0SF20210711071927.png', 1, '2021-07-11 06:38:52', '2021-07-11 07:19:27'),
	(53, NULL, 'Nugroho Setyo Wibowo', 'nugroho_setyo@polije.ac.id', NULL, 'Yq9qF6nt20210719021918.jpg', 1, '2021-07-11 06:39:25', '2021-07-19 02:19:18'),
	(54, NULL, 'Lukman Hakim', 'lukman_hakim@polije.ac.id', NULL, 'WF9MWFbX20210719023055.png', 1, '2021-07-11 06:40:18', '2021-07-19 02:30:55'),
	(55, NULL, 'Rizki Febrian Pramudita', 'rizki_febrian@polije.ac.id', NULL, NULL, 1, '2021-07-11 06:44:04', '2021-07-11 06:44:04'),
	(56, NULL, 'Elly Antika', 'elly_antika@polije.ac.id', NULL, 'uG8sXp3w20210719022201.png', 1, '2021-07-11 06:44:34', '2021-07-19 02:22:01'),
	(57, NULL, 'Mudafiq Riyan Pratama', 'mudafiq_riyan@polije.ac.id', NULL, NULL, 1, '2021-07-11 06:45:12', '2021-07-11 06:45:12'),
	(58, NULL, 'Ery Setiyawan Jullev Atmaji', 'ery_setiyawan@polije.ac.id', NULL, 'Dc5jVTi420210719022456.png', 1, '2021-07-11 06:45:45', '2021-07-19 02:24:56'),
	(59, NULL, 'Khafidurrohman Agustianto', 'khafidurrohman_agustianto@polije.ac.id', NULL, 'yW1kJsNR20210719022355.png', 1, '2021-07-11 06:46:40', '2021-07-19 02:23:55'),
	(60, NULL, 'Trismayanti Dwi Puspitasari', 'trismayanti_dwi@polije.ac.id', NULL, 'wibnrr1c20210719022416.png', 1, '2021-07-11 06:47:13', '2021-07-19 02:24:16'),
	(61, NULL, 'Andri Permana Wicaksono', 'andri_permana@polije.ac.id', NULL, NULL, 1, '2021-07-11 06:47:53', '2021-07-11 06:47:53'),
	(62, NULL, 'Jumiatun', 'jumiatun@polije.ac.id', NULL, NULL, 1, '2021-07-11 06:53:54', '2021-07-11 06:53:54'),
	(63, NULL, 'I Putu Dody Lesmana', 'i_putu_dody@polije.ac.id', NULL, 'GiuND4QQ20210719022226.png', 1, '2021-07-11 06:57:14', '2021-07-19 02:22:26'),
	(64, NULL, 'Adriadi Novawan', 'adriadi_novawan@polije.ac.id', NULL, NULL, 1, '2021-07-11 07:04:10', '2021-07-11 07:04:10'),
	(65, NULL, 'Ahmad Basri Saifur Rahman', 'ahmad_basri@polije.ac.id', NULL, NULL, 1, '2021-07-11 07:08:51', '2021-07-11 07:08:51'),
	(66, NULL, 'Degita Danur Suharsono', 'degita_danur@polije.ac.id', NULL, NULL, 1, '2021-07-11 07:09:24', '2021-07-11 07:09:24'),
	(67, NULL, 'Alfi Hidayatu Miqawati', 'alfi_hidayatu@polije.ac.id', NULL, NULL, 1, '2021-07-11 07:10:00', '2021-07-11 07:10:00'),
	(68, NULL, 'Renata Kenanga Rinda', 'renata_kenanga@polije.ac.id', NULL, NULL, 1, '2021-07-15 21:44:09', '2021-07-15 21:44:09'),
	(69, NULL, 'Enik Rukiati', 'enik_rukiati@polije.ac.id', NULL, NULL, 1, '2021-07-15 21:53:06', '2021-07-15 21:53:06'),
	(70, NULL, 'Vigo Dewangga', 'vigo_dewangga@polije.ac.id', NULL, NULL, 1, '2022-01-26 21:55:12', '2022-01-26 21:55:12'),
	(71, NULL, 'Geri Barnas Saputra', 'geri_barnas@polije.ac.id', NULL, NULL, 1, '2022-01-26 21:56:17', '2022-01-26 21:56:17'),
	(72, NULL, 'Sunoko Setyawan', 'sunoko_setyawan@polije.ac.id', NULL, NULL, 1, '2022-01-27 10:10:18', '2022-01-27 10:10:18'),
	(73, NULL, 'Estin Roso Pristiwaningsih', 'estin_roso@polije.ac.id', NULL, NULL, 1, '2022-01-27 10:11:26', '2022-01-27 10:11:26'),
	(74, NULL, 'Rhama Wisnu Wardhana', 'rhama_wisnu@polije.ac.id', NULL, NULL, 1, '2022-01-27 12:37:04', '2022-01-27 12:37:04'),
	(75, NULL, 'Dyah Aju Hermawati', 'dyah_ajuh@polije.ac.id', NULL, NULL, 1, '2022-01-27 12:42:21', '2022-01-27 12:42:21'),
	(76, NULL, 'Ruqoyah Yulia Hasanah Dhomiri', 'ruqoyah_yuliah@polije.ac.id', NULL, NULL, 1, '2022-01-27 12:43:02', '2022-01-27 12:43:02'),
	(77, NULL, 'Adi Sucipto', 'adi_sucipto@polije.ac.id', NULL, NULL, 1, '2022-01-27 12:52:06', '2022-01-27 12:52:06'),
	(78, NULL, 'Sholihah Ayu Wulandari', 'sholihah_ayuw@polije.ac.id', NULL, NULL, 1, '2022-01-27 12:53:58', '2022-01-27 12:53:58'),
	(79, NULL, 'Ikrima Halimatus Sa\'diyah', 'ikrima_halimatuss@polije.ac.id', NULL, NULL, 1, '2022-01-27 12:55:03', '2022-01-27 12:55:03'),
	(80, NULL, 'Suwardi (LB)', 'suwardilb@polije.ac.id', NULL, NULL, 1, '2022-01-27 12:57:39', '2022-01-27 12:57:39'),
	(81, NULL, 'Wajihudin', 'wajihudin@polije.ac.id', NULL, NULL, 1, '2022-01-27 12:58:10', '2022-01-27 12:58:10'),
	(82, NULL, 'Suyik Binarkaheni', 'suyik_binarkaheni@polije.ac.id', NULL, NULL, 1, '2022-01-27 12:59:06', '2022-01-27 12:59:06'),
	(83, NULL, 'Mochammad Rifki Ulil Albaab', 'mrifki_ulil_albaab@polije.ac.id', NULL, NULL, 1, '2022-01-27 13:00:05', '2022-01-27 13:00:05'),
	(84, NULL, 'Suparto (Kampus Bondowoso)', 'suparto_bws@polije.ac.id', NULL, NULL, 1, '2022-01-27 13:05:03', '2022-01-27 13:05:03'),
	(85, NULL, 'Suyitno', 'suyitno@polije.ac.id', NULL, NULL, 1, '2022-01-27 13:08:19', '2022-01-27 13:08:19'),
	(86, NULL, 'Asmunir', 'asmunir@polije.ac.id', NULL, NULL, 1, '2022-01-27 13:08:50', '2022-01-27 13:08:50'),
	(87, NULL, 'Asep Samsudin', 'asep_samsudin@polije.ac.id', NULL, NULL, 1, '2022-01-27 13:10:56', '2022-01-27 13:10:56'),
	(88, NULL, 'Ratri Handayani', 'ratri_handayani@polije.ac.id', NULL, NULL, 1, '2022-01-27 15:37:22', '2022-01-27 15:37:22');
/*!40000 ALTER TABLE `tm_staff` ENABLE KEYS */;

-- Dumping structure for table silab.tm_tahun_ajaran
CREATE TABLE IF NOT EXISTS `tm_tahun_ajaran` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `tahun_ajaran` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_genap` tinyint(3) unsigned DEFAULT NULL,
  `is_aktif` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table silab.tm_tahun_ajaran: ~4 rows (approximately)
/*!40000 ALTER TABLE `tm_tahun_ajaran` DISABLE KEYS */;
INSERT INTO `tm_tahun_ajaran` (`id`, `tahun_ajaran`, `created_at`, `updated_at`, `is_genap`, `is_aktif`) VALUES
	(3, '2020/2021', '2022-07-03 07:39:03', '2022-07-03 07:39:04', 0, 0),
	(4, '2020/2021', '2022-05-31 04:33:26', '2022-05-31 04:33:26', 1, 1),
	(5, '2022/2023', '2022-05-31 04:33:38', '2022-06-01 14:53:01', 0, 0),
	(6, '2022/2023', '2022-07-03 07:42:45', '2022-07-03 07:42:45', 1, 0);
/*!40000 ALTER TABLE `tm_tahun_ajaran` ENABLE KEYS */;

-- Dumping structure for table silab.tr_matakuliah_dosen
CREATE TABLE IF NOT EXISTS `tr_matakuliah_dosen` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tr_matakuliah_semester_prodi_id` int(10) unsigned DEFAULT NULL,
  `tm_staff_id` int(10) unsigned DEFAULT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tr_matakuliah_dosen_tr_matakuliah_semester_prodi_id_foreign` (`tr_matakuliah_semester_prodi_id`),
  KEY `tr_matakuliah_dosen_tm_staff_id_foreign` (`tm_staff_id`),
  KEY `tr_matakuliah_dosen_user_id_foreign` (`user_id`),
  CONSTRAINT `tr_matakuliah_dosen_tm_staff_id_foreign` FOREIGN KEY (`tm_staff_id`) REFERENCES `tm_staff` (`id`) ON DELETE SET NULL,
  CONSTRAINT `tr_matakuliah_dosen_tr_matakuliah_semester_prodi_id_foreign` FOREIGN KEY (`tr_matakuliah_semester_prodi_id`) REFERENCES `tr_matakuliah_semester_prodi` (`id`) ON DELETE SET NULL,
  CONSTRAINT `tr_matakuliah_dosen_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table silab.tr_matakuliah_dosen: ~13 rows (approximately)
/*!40000 ALTER TABLE `tr_matakuliah_dosen` DISABLE KEYS */;
INSERT INTO `tr_matakuliah_dosen` (`id`, `tr_matakuliah_semester_prodi_id`, `tm_staff_id`, `user_id`, `created_at`, `updated_at`) VALUES
	(11, 1, 43, NULL, '2022-05-13 02:48:36', '2022-05-13 02:48:36'),
	(12, 2, 4, NULL, '2022-05-13 02:48:36', '2022-05-13 02:48:36'),
	(13, 3, 68, NULL, '2022-05-13 02:48:36', '2022-05-13 02:48:36'),
	(14, 4, 13, NULL, '2022-05-13 02:48:36', '2022-05-13 02:48:36'),
	(15, 5, 29, NULL, '2022-05-13 02:48:36', '2022-05-13 02:48:36'),
	(16, 6, 11, NULL, '2022-05-13 02:48:36', '2022-05-13 02:48:36'),
	(17, 7, 6, NULL, '2022-05-13 02:48:36', '2022-05-13 02:48:36'),
	(18, 8, 8, NULL, '2022-05-13 02:48:36', '2022-05-13 02:48:36'),
	(19, 9, 20, NULL, '2022-05-13 02:48:36', '2022-05-13 02:48:36'),
	(20, 10, 68, NULL, '2022-05-13 02:48:36', '2022-05-13 02:48:36'),
	(21, 12, 5, NULL, '2022-05-13 03:35:37', '2022-05-13 03:35:37'),
	(22, 13, 70, NULL, '2022-05-13 03:41:01', '2022-05-13 03:41:01'),
	(23, 14, 8, NULL, '2022-05-13 03:42:48', '2022-05-13 03:42:48');
/*!40000 ALTER TABLE `tr_matakuliah_dosen` ENABLE KEYS */;

-- Dumping structure for table silab.tr_matakuliah_semester_prodi
CREATE TABLE IF NOT EXISTS `tr_matakuliah_semester_prodi` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tm_program_studi_id` smallint(5) unsigned DEFAULT NULL,
  `tm_semester_id` smallint(5) unsigned DEFAULT NULL,
  `tm_matakuliah_id` smallint(5) unsigned DEFAULT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `jumlah_golongan` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tr_matakuliah_semester_prodi_tm_matakuliah_id_foreign` (`tm_matakuliah_id`),
  KEY `tr_matakuliah_semester_prodi_tm_program_studi_id_foreign` (`tm_program_studi_id`),
  KEY `tr_matakuliah_semester_prodi_tm_semester_id_foreign` (`tm_semester_id`),
  KEY `tr_matakuliah_semester_prodi_user_id_foreign` (`user_id`),
  CONSTRAINT `tr_matakuliah_semester_prodi_tm_matakuliah_id_foreign` FOREIGN KEY (`tm_matakuliah_id`) REFERENCES `tm_matakuliah` (`id`) ON DELETE SET NULL,
  CONSTRAINT `tr_matakuliah_semester_prodi_tm_program_studi_id_foreign` FOREIGN KEY (`tm_program_studi_id`) REFERENCES `tm_program_studi` (`id`) ON DELETE SET NULL,
  CONSTRAINT `tr_matakuliah_semester_prodi_tm_semester_id_foreign` FOREIGN KEY (`tm_semester_id`) REFERENCES `tm_semester` (`id`) ON DELETE SET NULL,
  CONSTRAINT `tr_matakuliah_semester_prodi_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table silab.tr_matakuliah_semester_prodi: ~19 rows (approximately)
/*!40000 ALTER TABLE `tr_matakuliah_semester_prodi` DISABLE KEYS */;
INSERT INTO `tr_matakuliah_semester_prodi` (`id`, `tm_program_studi_id`, `tm_semester_id`, `tm_matakuliah_id`, `user_id`, `created_at`, `updated_at`, `jumlah_golongan`) VALUES
	(1, 3, 1, 22, 1, '2022-05-12 03:32:05', '2022-05-12 03:32:05', 0),
	(2, 3, 1, 23, 1, '2022-05-12 03:32:05', '2022-05-12 03:32:05', 0),
	(3, 3, 1, 24, 1, '2022-05-12 03:32:05', '2022-05-12 03:32:05', 0),
	(4, 3, 1, 25, 1, '2022-05-12 03:32:05', '2022-05-12 03:32:05', 0),
	(5, 3, 1, 26, 1, '2022-05-12 03:32:05', '2022-05-12 03:32:05', 0),
	(6, 3, 1, 27, 1, '2022-05-12 03:32:05', '2022-05-12 03:32:05', 0),
	(7, 3, 1, 28, 1, '2022-05-12 03:32:05', '2022-05-12 03:32:05', 0),
	(8, 3, 1, 29, 1, '2022-05-12 03:32:05', '2022-05-12 03:32:05', 0),
	(9, 3, 1, 30, 1, '2022-05-12 03:32:05', '2022-05-12 03:32:05', 0),
	(10, 3, 1, 31, 1, '2022-05-12 03:32:05', '2022-05-12 03:32:05', 0),
	(11, 3, 2, 2, 1, '2022-05-12 03:35:29', '2022-05-12 03:35:29', 0),
	(12, 3, 2, 3, 1, '2022-05-12 03:35:29', '2022-05-12 03:35:29', 0),
	(13, 3, 2, 4, 1, '2022-05-12 03:35:29', '2022-05-12 03:35:29', 0),
	(14, 3, 2, 5, 1, '2022-05-12 03:35:29', '2022-05-12 03:35:29', 0),
	(15, 3, 2, 6, 1, '2022-05-12 03:35:29', '2022-05-12 03:35:29', 0),
	(16, 3, 2, 7, 1, '2022-05-12 03:35:29', '2022-05-12 03:35:29', 0),
	(17, 3, 2, 8, 1, '2022-05-12 03:35:29', '2022-05-12 03:35:29', 0),
	(18, 3, 2, 9, 1, '2022-05-12 03:35:29', '2022-05-12 03:35:29', 0),
	(19, 3, 2, 10, 1, '2022-05-12 03:35:29', '2022-05-12 03:35:29', 0);
/*!40000 ALTER TABLE `tr_matakuliah_semester_prodi` ENABLE KEYS */;

-- Dumping structure for table silab.tr_usulan_kebutuhan
CREATE TABLE IF NOT EXISTS `tr_usulan_kebutuhan` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `acara_praktek` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jml_kel` tinyint(3) unsigned NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(3) unsigned NOT NULL COMMENT '1 => pengajuan, 2 =>review tim bahan, 3 => cetak tim bahan, 4 => acc ',
  `tm_minggu_id` tinyint(3) unsigned DEFAULT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `tr_matakuliah_dosen_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tr_usulan_kebutuhan_user_id_foreign` (`user_id`),
  KEY `tr_usulan_kebutuhan_tm_minggu_id_foreign` (`tm_minggu_id`),
  KEY `tr_usulan_kebutuhan_tr_matakuliah_dosen_id_foreign` (`tr_matakuliah_dosen_id`),
  CONSTRAINT `tr_usulan_kebutuhan_tm_minggu_id_foreign` FOREIGN KEY (`tm_minggu_id`) REFERENCES `tm_minggu` (`id`) ON DELETE SET NULL,
  CONSTRAINT `tr_usulan_kebutuhan_tr_matakuliah_dosen_id_foreign` FOREIGN KEY (`tr_matakuliah_dosen_id`) REFERENCES `tr_matakuliah_dosen` (`id`) ON DELETE SET NULL,
  CONSTRAINT `tr_usulan_kebutuhan_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table silab.tr_usulan_kebutuhan: ~0 rows (approximately)
/*!40000 ALTER TABLE `tr_usulan_kebutuhan` DISABLE KEYS */;
/*!40000 ALTER TABLE `tr_usulan_kebutuhan` ENABLE KEYS */;

-- Dumping structure for table silab.tr_usulan_kebutuhan_detail
CREATE TABLE IF NOT EXISTS `tr_usulan_kebutuhan_detail` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `keb_kel` tinyint(3) unsigned NOT NULL,
  `total_keb` int(10) unsigned NOT NULL,
  `keb_acc` int(10) unsigned NOT NULL,
  `tm_barang_id` int(10) unsigned DEFAULT NULL,
  `td_satuan_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tr_usulan_kebutuhan_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tr_usulan_kebutuhan_detail_tm_barang_id_foreign` (`tm_barang_id`),
  KEY `tr_usulan_kebutuhan_detail_td_satuan_id_foreign` (`td_satuan_id`),
  KEY `tr_usulan_kebutuhan_detail_tr_usulan_kebutuhan_id_foreign` (`tr_usulan_kebutuhan_id`),
  CONSTRAINT `tr_usulan_kebutuhan_detail_td_satuan_id_foreign` FOREIGN KEY (`td_satuan_id`) REFERENCES `td_satuan` (`id`) ON DELETE SET NULL,
  CONSTRAINT `tr_usulan_kebutuhan_detail_tm_barang_id_foreign` FOREIGN KEY (`tm_barang_id`) REFERENCES `tm_barang` (`id`) ON DELETE SET NULL,
  CONSTRAINT `tr_usulan_kebutuhan_detail_tr_usulan_kebutuhan_id_foreign` FOREIGN KEY (`tr_usulan_kebutuhan_id`) REFERENCES `tr_usulan_kebutuhan` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table silab.tr_usulan_kebutuhan_detail: ~0 rows (approximately)
/*!40000 ALTER TABLE `tr_usulan_kebutuhan_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `tr_usulan_kebutuhan_detail` ENABLE KEYS */;

-- Dumping structure for table silab.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `google_id` text COLLATE utf8mb4_unicode_ci,
  `avatar` text COLLATE utf8mb4_unicode_ci,
  `role` int(10) unsigned DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_aktif` tinyint(3) unsigned NOT NULL,
  `tm_staff_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table silab.users: ~87 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `google_id`, `avatar`, `role`, `remember_token`, `created_at`, `updated_at`, `is_aktif`, `tm_staff_id`) VALUES
	(1, 'Novianto Hadi Raharjo', 'novianto_hadi@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', '111653895186654901674', 'https://lh3.googleusercontent.com/a/AATXAJyzTyyE0oNgCt9JJiv_gO6CSoMbMO-kw7z6hmPW=s96-c', NULL, NULL, '2022-04-14 02:03:40', '2022-05-13 03:44:14', 1, 1),
	(3, 'test', 'test@gmail.com', NULL, '$2y$10$U39G9fX/LwAgS.54Fb0xZOJnfSSuncVQva9RENECJeYQanOGlyPo2', NULL, NULL, NULL, NULL, '2022-04-26 05:13:45', '2022-04-26 05:13:45', 1, 2),
	(4, 'Alwan Abdurahman', 'alwan_abdurahman@gmail.com', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 4),
	(5, 'Luluk Cahyo Wiyono', 'luluk_cahyo_wiyono@gmail.com', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 5),
	(6, 'Husin', 'husin@gmail.com', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 6),
	(7, 'Intan Sulistyaningrum Sakkinah', 'intan_sulistyaningrum_sakkinah@gmail.com', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 7),
	(8, 'Syamsul Arifin', 'syamsul_arifin@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 8),
	(9, 'Didit Rahmat Hartadi', 'didit_rahmat_hartadi@gmail.com', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 9),
	(10, 'Nanik Anita Mukhlisoh', 'nanik_anita_mukhlisoh@gmail.com', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 10),
	(11, 'Hendra Yufit Riskiawan', 'hendra_yufit_riskiawan@gmail.com', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 11),
	(12, 'Mukhamad Angga Gumilang', 'mukhamad_angga_gumilang@gmail.com', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 12),
	(13, 'Ika Widiastuti', 'ika_widiastuti@gmail.com', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 13),
	(14, 'Ratih Ayuninghemi', 'ratih_ayuninghemi@gmail.com', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 14),
	(15, 'Ely Mulyadi', 'ely_mulyadi@gmail.com', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 15),
	(16, 'Bakhtiyar Hadi Prakoso', 'bakhtiyar_hadi_prakoso@gmail.com', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 16),
	(17, 'Choirul Huda', 'choirul_huda@gmail.com', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 17),
	(18, 'Surateno', 'surateno@gmail.com', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 18),
	(19, 'Dia Bitari Mei Yuana', 'dia_bitari@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 19),
	(20, 'Faisal Lutfi Afriansyah', 'faisal_lutfi@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 20),
	(21, 'Taufiq Rizaldi', 'taufiq_rizaldi@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 21),
	(22, 'Arvita Agus Kurniasari', 'arvita_agus@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 22),
	(23, 'I GEDE WIRYAWAN', 'i_gede_wiryawan@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 23),
	(24, 'Pramuditha Shinta Dewi Puspitasari', 'pramuditha_shinta@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 24),
	(25, 'MUHAMMAD YUNUS', 'muhammad_yunus@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 25),
	(26, 'Dwi Putro Sarwo Setyohadi', 'dwi_putro@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 26),
	(27, 'Hermawan Arief P', 'hermawan_arief@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 27),
	(28, 'Lukie Perdanasari', 'lukie_perdanasari@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 28),
	(29, 'Wahyu Kurnia Dewanto', 'wahyu_kurnia@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 29),
	(30, 'Moch.Munih Dian W', 'moch.munih_dian@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 30),
	(31, 'Agus Hariyanto', 'agus_hariyanto@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 31),
	(32, 'Denny Wijanarko', 'denny_wijanarko@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 32),
	(33, 'Yogiswara', 'yogiswara@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 33),
	(34, 'Bekti Maryuni Susanto', 'bekti_maryuni@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 34),
	(35, 'Putri Santika', 'putri_santika@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 35),
	(36, 'Beni Widiawan', 'beni_widiawan@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 36),
	(37, 'Agus Purwadi', 'agus_purwadi@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 37),
	(38, 'Syamsiar Kautsar', 'syamsiar_kautsar@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 38),
	(39, 'Victor Phoa', 'victor_phoa@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 39),
	(40, 'Hariyono Rakhmad', 'hariyono_rakhmad@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 40),
	(41, 'Shabrina Choirunnisa', 'shabrina_choirunnisa@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 41),
	(42, 'Lalitya Nindita Sahenda', 'lalitya_nindita@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 42),
	(43, 'Zainul Hakim', 'zainul_hakim@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 43),
	(44, 'R. Agus Sariono', 'r_agus_sariono@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 44),
	(45, 'GULLIT TORNADO TAUFAN', 'gullit_tornado@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 45),
	(46, 'Ghanesya Hari Murti', 'ghanesya_hari@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 46),
	(47, 'Adi Heru Utomo', 'adi_heru@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 47),
	(48, 'Zilvanhisna Emka Fitri', 'zilvanhisna_emka@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 48),
	(49, 'Aji Seto Arifianto', 'aji_seto@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 49),
	(50, 'Denny Trias Utomo', 'denny_trias@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 50),
	(51, 'Prawidya Destarianto', 'prawidya_destarianto@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 51),
	(52, 'Bety Etikasari', 'bety_etikasari@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 52),
	(53, 'Nugroho Setyo Wibowo', 'nugroho_setyo@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 53),
	(54, 'Lukman Hakim', 'lukman_hakim@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 54),
	(55, 'Rizki Febrian Pramudita', 'rizki_febrian@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 55),
	(56, 'Elly Antika', 'elly_antika@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 56),
	(57, 'Mudafiq Riyan Pratama', 'mudafiq_riyan@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 57),
	(58, 'Ery Setiyawan Jullev Atmaji', 'ery_setiyawan@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 58),
	(59, 'Khafidurrohman Agustianto', 'khafidurrohman_agustianto@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 59),
	(60, 'Trismayanti Dwi Puspitasari', 'trismayanti_dwi@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 60),
	(61, 'Andri Permana Wicaksono', 'andri_permana@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 61),
	(62, 'Jumiatun', 'jumiatun@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 62),
	(63, 'I Putu Dody Lesmana', 'i_putu_dody@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 63),
	(64, 'Adriadi Novawan', 'adriadi_novawan@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 64),
	(65, 'Ahmad Basri Saifur Rahman', 'ahmad_basri@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 65),
	(66, 'Degita Danur Suharsono', 'degita_danur@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 66),
	(67, 'Alfi Hidayatu Miqawati', 'alfi_hidayatu@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 67),
	(68, 'Renata Kenanga Rinda', 'renata_kenanga@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 68),
	(69, 'Enik Rukiati', 'enik_rukiati@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 69),
	(70, 'Vigo Dewangga', 'vigo_dewangga@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 70),
	(71, 'Geri Barnas Saputra', 'geri_barnas@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 71),
	(72, 'Sunoko Setyawan', 'sunoko_setyawan@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 72),
	(73, 'Estin Roso Pristiwaningsih', 'estin_roso@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 73),
	(74, 'Rhama Wisnu Wardhana', 'rhama_wisnu@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 74),
	(75, 'Dyah Aju Hermawati', 'dyah_ajuh@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 75),
	(76, 'Ruqoyah Yulia Hasanah Dhomiri', 'ruqoyah_yuliah@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 76),
	(77, 'Adi Sucipto', 'adi_sucipto@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 77),
	(78, 'Sholihah Ayu Wulandari', 'sholihah_ayuw@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 78),
	(79, 'Ikrima Halimatus Sa\'diyah', 'ikrima_halimatuss@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 79),
	(80, 'Suwardi (LB)', 'suwardilb@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 80),
	(81, 'Wajihudin', 'wajihudin@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 81),
	(82, 'Suyik Binarkaheni', 'suyik_binarkaheni@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 82),
	(83, 'Mochammad Rifki Ulil Albaab', 'mrifki_ulil_albaab@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 83),
	(84, 'Suparto (Kampus Bondowoso)', 'suparto_bws@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 84),
	(85, 'Suyitno', 'suyitno@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 85),
	(86, 'Asmunir', 'asmunir@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 86),
	(87, 'Asep Samsudin', 'asep_samsudin@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 87),
	(88, 'Ratri Handayani', 'ratri_handayani@polije.ac.id', NULL, '$2y$10$ms3YIDyl5zD0ekY9GvqiJ.ZyxdNcvsYcwBjgnnSh679NmqEKRoDsa', NULL, NULL, NULL, NULL, NULL, NULL, 1, 88);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Dumping structure for view silab.vExistMK
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `vExistMK` (
	`tm_tahun_ajaran_id` TINYINT(3) UNSIGNED NOT NULL,
	`tahun_ajaran` VARCHAR(10) NULL COLLATE 'utf8mb4_unicode_ci',
	`is_genap` TINYINT(3) UNSIGNED NULL,
	`is_aktif` TINYINT(4) NULL,
	`tm_semester_id` SMALLINT(5) UNSIGNED NOT NULL,
	`semester` TINYINT(3) UNSIGNED NOT NULL,
	`tr_matakuliah_semester_prodi_id` INT(10) UNSIGNED NOT NULL,
	`tm_program_studi_id` SMALLINT(5) UNSIGNED NULL,
	`tm_matakuliah_id` SMALLINT(5) UNSIGNED NULL,
	`matakuliah` VARCHAR(64) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`kode` VARCHAR(12) NULL COLLATE 'utf8mb4_unicode_ci',
	`jumlah_golongan` TINYINT(3) UNSIGNED NOT NULL,
	`tr_matakuliah_dosen_id` INT(10) UNSIGNED NOT NULL,
	`tm_staff_id` INT(10) UNSIGNED NULL,
	`nama` VARCHAR(64) NOT NULL COLLATE 'utf8mb4_unicode_ci'
) ENGINE=MyISAM;

-- Dumping structure for view silab.vNotExistMK
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `vNotExistMK` (
	`tm_tahun_ajaran_id` TINYINT(3) UNSIGNED NOT NULL,
	`tahun_ajaran` VARCHAR(10) NULL COLLATE 'utf8mb4_unicode_ci',
	`is_genap` TINYINT(3) UNSIGNED NULL,
	`is_aktif` TINYINT(4) NULL,
	`tm_semester_id` SMALLINT(5) UNSIGNED NOT NULL,
	`semester` TINYINT(3) UNSIGNED NOT NULL,
	`tr_matakuliah_semester_prodi_id` INT(10) UNSIGNED NOT NULL,
	`tm_program_studi_id` SMALLINT(5) UNSIGNED NULL,
	`tm_matakuliah_id` SMALLINT(5) UNSIGNED NULL,
	`matakuliah` VARCHAR(64) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`kode` VARCHAR(12) NULL COLLATE 'utf8mb4_unicode_ci',
	`jumlah_golongan` TINYINT(3) UNSIGNED NOT NULL,
	`tr_matakuliah_dosen_id` INT(10) UNSIGNED NOT NULL,
	`tm_staff_id` INT(10) UNSIGNED NULL,
	`nama` VARCHAR(64) NOT NULL COLLATE 'utf8mb4_unicode_ci'
) ENGINE=MyISAM;

-- Dumping structure for view silab.vExistMK
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `vExistMK`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vExistMK` AS select `a`.`id` AS `tm_tahun_ajaran_id`,`a`.`tahun_ajaran` AS `tahun_ajaran`,`a`.`is_genap` AS `is_genap`,`a`.`is_aktif` AS `is_aktif`,`b`.`id` AS `tm_semester_id`,`b`.`semester` AS `semester`,`c`.`id` AS `tr_matakuliah_semester_prodi_id`,`c`.`tm_program_studi_id` AS `tm_program_studi_id`,`c`.`tm_matakuliah_id` AS `tm_matakuliah_id`,`e`.`matakuliah` AS `matakuliah`,`e`.`kode` AS `kode`,`c`.`jumlah_golongan` AS `jumlah_golongan`,`d`.`id` AS `tr_matakuliah_dosen_id`,`d`.`tm_staff_id` AS `tm_staff_id`,`f`.`nama` AS `nama` from (((((`tm_tahun_ajaran` `a` join `tm_semester` `b`) join `tr_matakuliah_semester_prodi` `c`) join `tr_matakuliah_dosen` `d`) join `tm_matakuliah` `e`) join `tm_staff` `f`) where ((`a`.`id` = `b`.`tm_tahun_ajaran_id`) and (`b`.`id` = `c`.`tm_semester_id`) and (`c`.`id` = `d`.`tr_matakuliah_semester_prodi_id`) and (`a`.`is_aktif` = 1) and (`c`.`tm_matakuliah_id` = `e`.`id`) and (`d`.`tm_staff_id` = `f`.`id`));

-- Dumping structure for view silab.vNotExistMK
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `vNotExistMK`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vNotExistMK` AS select `a`.`id` AS `tm_tahun_ajaran_id`,`a`.`tahun_ajaran` AS `tahun_ajaran`,`a`.`is_genap` AS `is_genap`,`a`.`is_aktif` AS `is_aktif`,`b`.`id` AS `tm_semester_id`,`b`.`semester` AS `semester`,`c`.`id` AS `tr_matakuliah_semester_prodi_id`,`c`.`tm_program_studi_id` AS `tm_program_studi_id`,`c`.`tm_matakuliah_id` AS `tm_matakuliah_id`,`e`.`matakuliah` AS `matakuliah`,`e`.`kode` AS `kode`,`c`.`jumlah_golongan` AS `jumlah_golongan`,`d`.`id` AS `tr_matakuliah_dosen_id`,`d`.`tm_staff_id` AS `tm_staff_id`,`f`.`nama` AS `nama` from (((((`tm_tahun_ajaran` `a` join `tm_semester` `b`) join `tr_matakuliah_semester_prodi` `c`) join `tr_matakuliah_dosen` `d`) join `tm_matakuliah` `e`) join `tm_staff` `f`) where ((`a`.`id` = `b`.`tm_tahun_ajaran_id`) and (`b`.`id` = `c`.`tm_semester_id`) and (`c`.`id` = `d`.`tr_matakuliah_semester_prodi_id`) and (`a`.`is_aktif` = 0) and (`c`.`tm_matakuliah_id` = `e`.`id`) and (`d`.`tm_staff_id` = `f`.`id`));

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
