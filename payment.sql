/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : payment

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2026-06-13 06:06:21
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `cache`
-- ----------------------------
DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of cache
-- ----------------------------

-- ----------------------------
-- Table structure for `cache_locks`
-- ----------------------------
DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of cache_locks
-- ----------------------------

-- ----------------------------
-- Table structure for `failed_jobs`
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for `job_batches`
-- ----------------------------
DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of job_batches
-- ----------------------------

-- ----------------------------
-- Table structure for `jobs`
-- ----------------------------
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of jobs
-- ----------------------------

-- ----------------------------
-- Table structure for `migrations`
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES ('1', '0001_01_01_000000_create_users_table', '1');
INSERT INTO `migrations` VALUES ('2', '0001_01_01_000001_create_cache_table', '1');
INSERT INTO `migrations` VALUES ('3', '0001_01_01_000002_create_jobs_table', '1');
INSERT INTO `migrations` VALUES ('4', '2026_06_08_000005_add_role_country_currency_to_users_table', '2');
INSERT INTO `migrations` VALUES ('5', '2026_06_08_000006_create_payment_requests_table', '2');
INSERT INTO `migrations` VALUES ('6', '2026_06_13_052648_create_personal_access_tokens_table', '2');
INSERT INTO `migrations` VALUES ('7', '2026_06_13_074228_create_oauth_auth_codes_table', '3');
INSERT INTO `migrations` VALUES ('8', '2026_06_13_074229_create_oauth_access_tokens_table', '3');
INSERT INTO `migrations` VALUES ('9', '2026_06_13_074230_create_oauth_refresh_tokens_table', '3');
INSERT INTO `migrations` VALUES ('10', '2026_06_13_074231_create_oauth_clients_table', '3');
INSERT INTO `migrations` VALUES ('11', '2026_06_13_074232_create_oauth_device_codes_table', '3');

-- ----------------------------
-- Table structure for `oauth_access_tokens`
-- ----------------------------
DROP TABLE IF EXISTS `oauth_access_tokens`;
CREATE TABLE `oauth_access_tokens` (
  `id` char(80) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `client_id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_access_tokens_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of oauth_access_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for `oauth_auth_codes`
-- ----------------------------
DROP TABLE IF EXISTS `oauth_auth_codes`;
CREATE TABLE `oauth_auth_codes` (
  `id` char(80) NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `client_id` char(36) NOT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_auth_codes_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of oauth_auth_codes
-- ----------------------------

-- ----------------------------
-- Table structure for `oauth_clients`
-- ----------------------------
DROP TABLE IF EXISTS `oauth_clients`;
CREATE TABLE `oauth_clients` (
  `id` char(36) NOT NULL,
  `owner_type` varchar(255) DEFAULT NULL,
  `owner_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `secret` varchar(255) DEFAULT NULL,
  `provider` varchar(255) DEFAULT NULL,
  `redirect_uris` text NOT NULL,
  `grant_types` text NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_clients_owner_type_owner_id_index` (`owner_type`,`owner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of oauth_clients
-- ----------------------------

-- ----------------------------
-- Table structure for `oauth_device_codes`
-- ----------------------------
DROP TABLE IF EXISTS `oauth_device_codes`;
CREATE TABLE `oauth_device_codes` (
  `id` char(80) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `client_id` char(36) NOT NULL,
  `user_code` char(8) NOT NULL,
  `scopes` text NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `user_approved_at` datetime DEFAULT NULL,
  `last_polled_at` datetime DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `oauth_device_codes_user_code_unique` (`user_code`),
  KEY `oauth_device_codes_user_id_index` (`user_id`),
  KEY `oauth_device_codes_client_id_index` (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of oauth_device_codes
-- ----------------------------

-- ----------------------------
-- Table structure for `oauth_refresh_tokens`
-- ----------------------------
DROP TABLE IF EXISTS `oauth_refresh_tokens`;
CREATE TABLE `oauth_refresh_tokens` (
  `id` char(80) NOT NULL,
  `access_token_id` char(80) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of oauth_refresh_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for `password_reset_tokens`
-- ----------------------------
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of password_reset_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for `payment_requests`
-- ----------------------------
DROP TABLE IF EXISTS `payment_requests`;
CREATE TABLE `payment_requests` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `currency` varchar(3) NOT NULL,
  `exchange_rate` decimal(15,6) NOT NULL,
  `amount_eur` decimal(15,2) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `exchange_rate_source` varchar(255) DEFAULT NULL,
  `exchange_rate_timestamp` timestamp NULL DEFAULT NULL,
  `approved_by` bigint(20) unsigned DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payment_requests_user_id_foreign` (`user_id`),
  KEY `payment_requests_approved_by_foreign` (`approved_by`),
  CONSTRAINT `payment_requests_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `payment_requests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of payment_requests
-- ----------------------------
INSERT INTO `payment_requests` VALUES ('1', '8', '100.00', 'USD', '1.160000', '86.21', 'Office supplies', 'pending', 'https://api.exchangerate-api.com/v4/latest/EUR', '2026-06-13 06:43:16', null, null, '2026-06-13 06:43:17', '2026-06-13 06:43:17');

-- ----------------------------
-- Table structure for `personal_access_tokens`
-- ----------------------------
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  KEY `personal_access_tokens_expires_at_index` (`expires_at`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of personal_access_tokens
-- ----------------------------
INSERT INTO `personal_access_tokens` VALUES ('1', 'App\\Models\\User', '1', 'api-token', '054909920cff7ed5750fd4f4dac6fb23b65ac257ced56b2cdab6e3f642e1ed9b', '[\"*\"]', null, null, '2026-06-13 06:18:07', '2026-06-13 06:18:07');
INSERT INTO `personal_access_tokens` VALUES ('2', 'App\\Models\\User', '7', 'api-token', '2c648be7bbd58332a29c2bb282134c209e21c7869ef0498d2b37f55855b6a2c6', '[\"*\"]', null, null, '2026-06-13 06:21:14', '2026-06-13 06:21:14');
INSERT INTO `personal_access_tokens` VALUES ('3', 'App\\Models\\User', '8', 'api-token', '46dd973d3486fee9a250b6333f985019b2efa71137823a1177bc3302ab210c7b', '[\"*\"]', null, null, '2026-06-13 06:24:50', '2026-06-13 06:24:50');
INSERT INTO `personal_access_tokens` VALUES ('4', 'App\\Models\\User', '8', 'api-token', '3db10e236e6c7463a3d7c03804c838ce55fd7a92f0c9342a808f576394ca0ceb', '[\"*\"]', null, null, '2026-06-13 06:27:32', '2026-06-13 06:27:32');
INSERT INTO `personal_access_tokens` VALUES ('5', 'App\\Models\\User', '8', 'api-token', '23cb71234597a1bb9cfc208cafbefbdf1e27b9c41f8d1d8b9a78730c1bad8507', '[\"*\"]', null, null, '2026-06-13 06:29:11', '2026-06-13 06:29:11');
INSERT INTO `personal_access_tokens` VALUES ('6', 'App\\Models\\User', '8', 'api-token', 'ce249451836303123a017666f6b6cce1de877c76c30dcbb380d8bdef1f698e34', '[\"*\"]', null, null, '2026-06-13 06:29:57', '2026-06-13 06:29:57');
INSERT INTO `personal_access_tokens` VALUES ('7', 'App\\Models\\User', '8', 'api-token', '0da2af5cbd824d8904b33f51af763080bbd3e45be6e4844f6870091090563d6b', '[\"*\"]', '2026-06-13 06:47:52', null, '2026-06-13 06:31:04', '2026-06-13 06:47:52');

-- ----------------------------
-- Table structure for `sessions`
-- ----------------------------
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of sessions
-- ----------------------------

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'employee',
  `country` varchar(255) DEFAULT NULL,
  `currency` varchar(3) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'Ana Silva', 'ana@empresa.com', null, '$2y$12$RljnMWchlh5nw6zYhjlEA.mtvsFHDlHrXoL9bq77SpYJA56N/THA6', 'employee', 'Portugal', 'EUR', null, '2026-06-13 05:31:03', '2026-06-13 05:31:03');
INSERT INTO `users` VALUES ('2', 'John Smith', 'john@empresa.com', null, '$2y$12$wD8HDh1/eT7f8LW31t9MT.Tzvj9mUw9H/u94Om/iMNISpPvvJPrSu', 'employee', 'United Kingdom', 'GBP', null, '2026-06-13 05:31:04', '2026-06-13 05:31:04');
INSERT INTO `users` VALUES ('3', 'Maria Garcia', 'maria@empresa.com', null, '$2y$12$kz4V6O/ruoFN4Jx3zBM/xe8EoNdzjwF6wY9tmMgmNFyXtYzltjwGS', 'employee', 'Spain', 'EUR', null, '2026-06-13 05:31:04', '2026-06-13 05:31:04');
INSERT INTO `users` VALUES ('4', 'Takashi Yamamoto', 'takashi@empresa.com', null, '$2y$12$iqDisN5asl/Tam2DBO3e3O.D8EAO.B0e9OCXUH7ukUTwx633CQfaW', 'employee', 'Japan', 'JPY', null, '2026-06-13 05:31:04', '2026-06-13 05:31:04');
INSERT INTO `users` VALUES ('5', 'Sarah Johnson', 'sarah@empresa.com', null, '$2y$12$I2rNzU9QmCblRmA.5Sctt.NSHoR68UUev5DNTAq73bYmmJEdOqovu', 'employee', 'United States', 'USD', null, '2026-06-13 05:31:05', '2026-06-13 05:31:05');
INSERT INTO `users` VALUES ('6', 'Carlos Mendes', 'carlos@empresa.com', null, '$2y$12$UTHMQNudiE1UpzUEXTLPBe//2Arem5FIyRvW38xvtx337hWq8qn/O', 'employee', 'Brazil', 'BRL', null, '2026-06-13 05:31:05', '2026-06-13 05:31:05');
INSERT INTO `users` VALUES ('7', 'Finance Team', 'finance@empresa.com', null, '$2y$12$2479.JWEnMt2ZU2Cr6mjgetQYJS.I4/KvU5d1BbMFDR8r0RWxnxpi', 'finance', 'Portugal', 'EUR', null, '2026-06-13 05:31:05', '2026-06-13 05:31:05');
INSERT INTO `users` VALUES ('8', 'John', 'john@test.com', null, '$2y$12$2479.JWEnMt2ZU2Cr6mjgetQYJS.I4/KvU5d1BbMFDR8r0RWxnxpi', 'employee', 'Brazil', 'BRL', null, '2026-06-13 06:27:32', '2026-06-13 06:27:32');
