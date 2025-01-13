-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 13, 2025 at 02:55 PM
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
-- Database: `cv_builder`
--

-- --------------------------------------------------------

--
-- Table structure for table `educations`
--

CREATE TABLE `educations` (
  `id` int(11) NOT NULL,
  `name_of_institute` varchar(255) NOT NULL,
  `name_of_exam` varchar(255) NOT NULL,
  `institute` varchar(255) DEFAULT NULL,
  `board` varchar(100) DEFAULT NULL,
  `CGPA` float DEFAULT NULL,
  `user_mail` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `educations`
--

INSERT INTO `educations` (`id`, `name_of_institute`, `name_of_exam`, `institute`, `board`, `CGPA`, `user_mail`) VALUES
(48, 'Dhakagggg University', 'Bachelor of Science in Computer Science', 'Faculty of Science', 'Dhaka', 3.8, 'student1@example.com'),
(49, 'Chittagong College', 'Higher Secondary Certificate (HSC)', 'College of Arts and Science', 'Chittagong', 4, 'student2@example.com'),
(50, 'Dhaka Residential Model College', 'Secondary School Certificate (SSC)', NULL, 'Dhaka', 4.5, 'student3@example.com'),
(51, 'Independent University Bangladesh', 'Master of Business Administration (MBA)', 'School of Business', NULL, NULL, 'student4@example.com'),
(61, 'Chittagong collage', 'HSC', 'science', 'chittagong', 4.89, 'admin@gmail.com'),
(62, 'Chittagong Contonment public', 'SSC', 'gggdd', 'ggg', 4.01, 'pyxumerid@mailinator.com'),
(65, 'Premier University', 'BSc', 'Cse', NULL, 3.89, 'admin@gmail.com'),
(66, 'test colloage', 'SSC', 'sc', 'ctg', 5, 'gytyt@mailinator.com');

-- --------------------------------------------------------

--
-- Table structure for table `experience`
--

CREATE TABLE `experience` (
  `id` int(11) NOT NULL,
  `job_title` varchar(255) NOT NULL,
  `employer` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `current_work` tinyint(1) DEFAULT 0,
  `short_description` text DEFAULT NULL,
  `user_email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `experience`
--

INSERT INTO `experience` (`id`, `job_title`, `employer`, `start_date`, `end_date`, `current_work`, `short_description`, `user_email`) VALUES
(7, 'Softwardde Engineer', 'Tech Corp', '2020-01-01', '2022-12-31', 0, 'Developed various web applications.', 'user@example.com'),
(8, 'Pariatur Anim sed l', 'Veritatis qui quae s', '1972-04-10', '2016-01-16', 1, 'Nesciunt cum ullamc', 'nirafak@mailinator.com'),
(9, 'ffff', 'ffff', '2025-01-06', '2025-01-12', 0, 'fff', 'pyxumerid@mailinator.com'),
(11, 'Fronten Deveplopment', 'AFT Soft', '2025-01-01', '2025-01-12', 0, 'test', 'admin@gmail.com'),
(12, 'MERN', 'test', '2025-01-12', NULL, 1, 'TEST', 'admin@gmail.com'),
(13, 'web', 'aft', '2025-01-13', NULL, 1, 'testing', 'gytyt@mailinator.com');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `headings`
--

CREATE TABLE `headings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `profession` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `postal_code` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `headings`
--

INSERT INTO `headings` (`id`, `image`, `first_name`, `surname`, `profession`, `city`, `postal_code`, `country`, `phone`, `email`, `created_at`, `updated_at`) VALUES
(1, NULL, 'John', 'Doe', 'Graphic Designer', 'Los Angeles', '90001', 'USA', '+14155551234', 'john.doe@example.com', '2025-01-11 14:29:14', '2025-01-11 14:29:14'),
(2, NULL, 'John', 'Doe', 'Graphic Designer', 'Los Angeles', '90001', 'USA', '+14155551234', 'johsn.doe@example.com', '2025-01-11 14:58:17', '2025-01-11 14:58:17'),
(3, NULL, 'John', 'Doe', 'Graphic Designer', 'Los Angeles', '90001', 'USA', '+14155551234', 'johswn.doe@example.com', '2025-01-11 15:17:55', '2025-01-11 15:17:55'),
(4, NULL, 'John', 'Doe', 'Graphic Designer', 'Los Angeles', '90001', 'USA', '+14155551234', 'd.doe@example.com', '2025-01-11 15:37:08', '2025-01-11 15:37:08'),
(6, NULL, 'John', 'Doe', 'Graphic Designer', 'Los Angeles', '90001', 'USA', '+14155551234', 'd.dddoe@example.com', '2025-01-11 15:43:21', '2025-01-11 15:43:21'),
(7, NULL, 'John', 'Doe', 'Graphic Designer', 'Los Angeles', '90001', 'USA', '+14155551234', 'd.dddfoe@example.com', '2025-01-11 16:07:10', '2025-01-11 16:07:10'),
(9, NULL, 'John', 'Doe', 'Graphic Designer', 'Los Angeles', '90001', 'USA', '+14155551234', 'd.ddttdfoe@example.com', '2025-01-11 16:11:26', '2025-01-11 16:11:26');

-- --------------------------------------------------------

--
-- Table structure for table `language_proficiency`
--

CREATE TABLE `language_proficiency` (
  `id` int(11) NOT NULL,
  `Language` varchar(100) DEFAULT NULL,
  `Proficiency` varchar(50) DEFAULT NULL,
  `user_email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `language_proficiency`
--

INSERT INTO `language_proficiency` (`id`, `Language`, `Proficiency`, `user_email`) VALUES
(1, 'English', 'Advanced', 'admin@gmail.com'),
(2, 'English', 'Advanced', 'user@example.com'),
(3, 'Spanish', 'Interddddddmediate', 'anotheruser@example.com'),
(4, 'French', 'Beginner', 'thirduser@example.com'),
(5, 'bangla', 'Native', 'admin@gmail.com'),
(6, 'Bangla', 'Native', 'gytyt@mailinator.com'),
(8, 'English', 'Intermediate', 'gytyt@mailinator.com');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2025_01_11_061308_create_headings_table', 2),
(6, '2025_01_11_082108_create_test_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `objective`
--

CREATE TABLE `objective` (
  `id` int(11) NOT NULL,
  `objective` text NOT NULL,
  `user_email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `objective`
--

INSERT INTO `objective` (`id`, `objective`, `user_email`) VALUES
(1, 'Learn fffffffffff Laravel Resource Controllers', 'example@example.com'),
(2, 'Learn fffffffffff Laravel Resource Controllers', 'exampdle@example.com'),
(3, 'Qui at incididunt no', 'wonojyvo@mailinator.com'),
(4, 'As a passionate and detail-oriented web developer, I am eager to apply my expertise in front-end and back-end technologies to create dynamic, user-friendly websites and applications. With experience in HTML, CSS, JavaScript, and frameworks like React and Node.js, I am dedicated to delivering high-quality, responsive solutions.', 'admin@gmail.com'),
(5, 'hello this is test', 'gytyt@mailinator.com');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(17, 'App\\Models\\User', 5, 'auth_token', '1bd77ac30c73668481b8e4f9eceff13091232c75ac21053154a08625b15c90e8', '[\"*\"]', NULL, NULL, '2025-01-10 23:02:25', '2025-01-10 23:02:25'),
(20, 'App\\Models\\User', 5, 'auth_token', 'f99ee0bbd7ad8b9c303a15253eaf460ed19d7364624b80d1a4d8496e255abd51', '[\"*\"]', NULL, NULL, '2025-01-11 04:15:40', '2025-01-11 04:15:40'),
(53, 'App\\Models\\User', 8, 'auth_token', '799a7d4d78cb5f1ebe14fdb3daddf76f8344d5c55394a91929f5240749560a39', '[\"*\"]', NULL, NULL, '2025-01-11 21:59:01', '2025-01-11 21:59:01'),
(65, 'App\\Models\\User', 8, 'auth_token', '142f427f77610f80a97906c29d16f927e4be56d50a830652e531294c85d8f69d', '[\"*\"]', NULL, NULL, '2025-01-12 01:28:26', '2025-01-12 01:28:26'),
(66, 'App\\Models\\User', 12, 'auth_token', '2cddeb1c4c20388e61127361795f6e951413c758cd6d1d8dbf8d5e3e774a9dff', '[\"*\"]', NULL, NULL, '2025-01-12 01:46:43', '2025-01-12 01:46:43'),
(83, 'App\\Models\\User', 8, 'auth_token', '177288690fbd61731bbab042f6bbf7f8e7fd537f471542b13f06d3a413d36c28', '[\"*\"]', NULL, NULL, '2025-01-13 00:18:30', '2025-01-13 00:18:30'),
(86, 'App\\Models\\User', 8, 'auth_token', '6e98068e3a0c8769a1ab8c467c6e64ae28b29cf9756a1fa2d869d45f208c62a5', '[\"*\"]', NULL, NULL, '2025-01-13 01:19:05', '2025-01-13 01:19:05'),
(90, 'App\\Models\\User', 8, 'auth_token', '521bece5d69c68f8fbc36a84dbd2df7f44dfb50a5b6ed907f4a0a72d7a69205b', '[\"*\"]', NULL, NULL, '2025-01-13 11:37:30', '2025-01-13 11:37:30'),
(102, 'App\\Models\\User', 15, 'auth_token', '1a2b3c6d8aeff399b9b117688c652c276a72cc070ab8aaa22ca2bea43971d5ad', '[\"*\"]', NULL, NULL, '2025-01-13 21:22:32', '2025-01-13 21:22:32');

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `id` int(11) NOT NULL,
  `hard_skills` text DEFAULT NULL,
  `soft_skills` text DEFAULT NULL,
  `user_email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`id`, `hard_skills`, `soft_skills`, `user_email`) VALUES
(1, 'PHP, Laravel, JavaScript', 'Teamwork, Communication', 'user@example.com'),
(2, 'React, Laravel, JavaScript', 'Teamwork, Communication', 'user1@example.com'),
(3, 'abc, def, gh', 'abc, def, ghi', 'admin@gmail.com'),
(4, 'kiso pari na, khali phone tipi', 'lokdjfla, jff', 'gytyt@mailinator.com');

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE `test` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  `profession` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `test`
--

INSERT INTO `test` (`id`, `name`, `email`, `created_at`, `updated_at`, `city`, `postal_code`, `profession`, `country`, `phone`, `image`) VALUES
(1, 'John Doe', 'john@example.com', '2025-01-11 16:23:11', '2025-01-11 16:23:11', NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Ira Lang', 'mugew@mailinator.com', '2025-01-11 16:34:26', '2025-01-11 16:34:26', NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'Herman Houston', 'rujov@mailinator.com', '2025-01-11 16:39:09', '2025-01-11 16:39:09', NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'Henry Michael', 'degote@mailinator.com', '2025-01-11 16:41:08', '2025-01-11 16:41:08', NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'Oprah Cline', 'gahym@mailinator.com', '2025-01-11 16:42:38', '2025-01-11 16:42:38', NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'Shad Figueroa', 'pibivudu@mailinator.com', '2025-01-11 16:50:32', '2025-01-11 16:50:32', 'Elit id magnam asp', NULL, NULL, NULL, NULL, NULL),
(7, 'Jorden Heath', 'pirobosok@mailinator.com', '2025-01-11 16:59:33', '2025-01-11 16:59:33', 'Cupidatat ut hic nul', 'Vel perferendis inve', 'Sit dolor quis dolo', 'Consequatur perfere', '+1 (987) 262-3831', NULL),
(8, 'Lee Robles', 'bujikupox@mailinator.com', '2025-01-11 17:04:31', '2025-01-11 17:04:31', 'Quam laboriosam dol', 'Asperiores excepturi', 'Repudiandae libero s', 'Adipisci enim quis q', '+1 (354) 701-5507', NULL),
(9, 'Bree Colon', 'mejatoz@mailinator.com', '2025-01-11 17:13:56', '2025-01-11 17:13:56', 'Maiores omnis dolor', 'Quod deserunt non an', 'Nulla eu placeat il', 'Enim quia dolor comm', '+1 (739) 827-2984', NULL),
(10, 'Jemima Carney', 'juges@mailinator.com', '2025-01-11 17:14:46', '2025-01-11 17:14:46', 'Minim reprehenderit', 'Laborum Vero facili', 'Qui dolore ut id nat', 'Qui culpa voluptate', '+1 (445) 413-7282', 'images/5rXNHO4fWv2hVMDQTqBkCo1VGbn5lExGMAIz7eDV.png'),
(11, 'May', 'dove@mailinator.com', '2025-01-11 17:16:38', '2025-01-11 21:13:57', 'Molestiae necessitat', 'Incididunt impedit f', 'Soluta porro sed dol', 'Et et est', '+1 (454) 678-8649', 'images/HroZHvJ25WOhFMSgwPHGNTsYxnbwKVd14aVrKtkg.png'),
(12, 'Tyler Riddle', 'zytoburyw@mailinator.com', '2025-01-11 17:23:57', '2025-01-11 17:23:57', 'Dicta laborum Eius', 'Est fugit sit proi', 'Laboris dolore aliqu', 'Labore nemo consequa', '+1 (566) 974-1443', NULL),
(13, 'Jarrod Dawson', 'cevu@mailinator.com', '2025-01-11 18:15:51', '2025-01-11 18:15:51', 'Iste qui voluptate u', 'Ad nobis ullam corru', 'Rerum minima perspic', 'Assumenda pariatur', '+1 (966) 951-5974', NULL),
(14, 'Bruce Eaton', 'zexygu@mailinator.com', '2025-01-11 18:16:09', '2025-01-11 18:16:09', 'Sunt nobis sapiente', 'Iste ut animi ipsum', 'Magnam excepteur rer', 'Molestiae rerum ad m', '+1 (414) 931-9338', NULL),
(15, 'May Byrd', 'do54ve@mailinator.com', '2025-01-11 18:28:33', '2025-01-11 18:28:33', 'Molestiae necessitat', 'Incididunt impedit', 'Soluta porro sed dol', 'Et et est dolorem r', '+1 (454) 678-8649', NULL),
(16, 'John Doe', 'johndoe@example.com', '2025-01-11 18:35:41', '2025-01-11 18:35:41', 'New York', '10001', 'Software Engineer', 'USA', '+1234567890', NULL),
(17, 'John Doe', 'johnedoe@example.com', '2025-01-11 18:41:21', '2025-01-11 18:41:21', 'New York', '10001', 'Software Engineer', 'USA', '+1234567890', NULL),
(18, 'John Doe', 'johndossssssssse@example.com', '2025-01-11 18:49:46', '2025-01-11 18:49:46', 'New York', '10001', 'Software Engineer', 'USA', '+1234567890', NULL),
(19, 'John Doe', 'johndosssffsssssse@example.com', '2025-01-11 18:51:07', '2025-01-11 18:51:07', 'New York', '10001', 'Software Engineer', 'USA', '+1234567890', NULL),
(20, 'Johnrr Doe', 'johndosssfffffsssssse@example.com', '2025-01-11 18:54:16', '2025-01-11 18:55:44', 'New York', '10001', 'Software Engineer', 'USA', '+1234567890', NULL),
(21, 'Johnrr Doe', 'johndosggssfffffsssssse@example.com', '2025-01-11 18:55:53', '2025-01-11 18:55:53', 'New York', '10001', 'Software Engineer', 'USA', '+1234567890', NULL),
(22, 'Johnrr Doe', 'johxndosggssfffffsssssse@example.com', '2025-01-11 19:06:55', '2025-01-11 19:06:55', 'New York', '10001', 'Software Engineer', 'USA', '+1234567890', NULL),
(23, 'Kyra', 'kivedusa@mailinator.com', '2025-01-11 19:26:42', '2025-01-11 19:32:08', 'Sit velit dolor do', 'Ad mollit ut', 'Amet eaque molestia', 'Qui modi minima enim', '+1 (361) 248-4142', NULL),
(24, 'Rahim karim', 'admin@gmail.com', '2025-01-11 20:03:00', '2025-01-13 12:12:54', 'Deserunt', '1422', 'Veritatis', 'rendia', '+1 (734) 401-6602', 'images/ksZfDErGHmQGKFhpfDbBiPQp2P527T5gX26C2wJH.jpg'),
(25, 'Lee Hoffman', 'halogi@mailinator.com', '2025-01-12 00:03:50', '2025-01-12 00:03:50', 'Est modi asperiores', 'Doloribus quibusdam', 'Sint obcaecati aut', 'Duis expedita dolor', '+1 (111) 193-1713', 'images/128o1t7vx29BEZCNGjHwiKesX4H4vX6M1eJaZcHD.jpg'),
(26, 'Phoebe Dickson', 'pyxumerid@mailinator.com', '2025-01-12 08:51:17', '2025-01-12 08:51:17', 'Quia sed exercitatio', 'Est in ea eaque vel', 'Dolor et sequi quia', 'Repudiandae velit d', '+1 (295) 685-5292', 'images/I3v11mS76k8OOyQSnZbqxEH2q3ti2mtvRdF7DyVi.jpg'),
(27, 'test karim', 'gytyt@mailinator.com', '2025-01-13 21:23:26', '2025-01-13 21:23:41', 'ctg', '4423', 'web', 'bd', '43434', 'images/wrc7i0IsNCpiGTqtPNy6h66uFgrJoDbDlYXhHRLI.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'John Doe', 'john.doe@example.com', NULL, '$2y$12$uWizD4KBsBDGHKMQpOcaJ.xoNcnSLOdb9AModUVqdi.pBdRRgn4aq', NULL, '2025-01-10 17:19:52', '2025-01-10 17:19:52'),
(2, 'John Doe', 'john.doe1@example.com', NULL, '$2y$12$7i2VNPttYdbvmywMHU28EeY2s0j9hfrDB4T3mGF98dmZ4K8EDYquS', NULL, '2025-01-10 18:13:52', '2025-01-10 18:13:52'),
(3, 'Alika Morgan', 'vozymyri@mailinator.com', NULL, '$2y$12$gupJd9f2ylIZdJ7UMEwsiOotRQNtqIXN1Ri6ZE9j8LcP.6OlsI/Yu', NULL, '2025-01-10 18:26:35', '2025-01-10 18:26:35'),
(4, 'Evan Fischer', 'sagoguti@mailinator.com', NULL, '$2y$12$dkUd8Q8O/dKV2RkaNJl1O.r1f4.JOYJTVPUlSfSil7tXpCByjLV/m', NULL, '2025-01-10 18:27:01', '2025-01-10 18:27:01'),
(5, 'Quin Gamble', 'dove@mailinator.com', NULL, '$2y$12$i3UF6krvYHAihnZ9ldBifeJRF.KwxBtTf6BJHyN4H4lHQc7sQHbWy', NULL, '2025-01-10 18:31:07', '2025-01-10 18:31:07'),
(6, 'Aristotle Saunders', 'halogi@mailinator.com', NULL, '$2y$12$TC4FWAd1P9Jkv.WJoQRwT.UAcG65tRsr.ZkVdtntpx6nko7VmfzGG', NULL, '2025-01-11 17:36:09', '2025-01-11 17:36:09'),
(7, 'Yuri Shelton', 'kivedusa@mailinator.com', NULL, '$2y$12$/f21JF0dOMZO2KrWjENPG.6HkaTRfLVbAA9W1gcueAERd6OWezLqi', NULL, '2025-01-11 19:18:26', '2025-01-11 19:18:26'),
(8, 'May', 'admin@gmail.com', NULL, '$2y$12$esi4DKPZ8BdzpXpTT.FwNuqBPqL/IT8wbN45SvsBMRUg8MZLPUtwa', NULL, '2025-01-11 19:56:59', '2025-01-11 19:56:59'),
(9, 'McKenzie Wagner', 'kawyd@mailinator.com', NULL, '$2y$12$/iKNXX/DTyKfMJ9qywHxPepQgW3AM1zEiV.XbdlZwBfHpuXQKxXI2', NULL, '2025-01-11 21:49:49', '2025-01-11 21:49:49'),
(10, 'Skyler Cleveland', 'sutu@mailinator.com', NULL, '$2y$12$jwQfZV1JjDsP6XKaBpREWuUeCVqrwoyvnQe7fMlKf0hhOFMxsFxPG', NULL, '2025-01-11 23:55:12', '2025-01-11 23:55:12'),
(11, 'Hamilton Livingston', 'sedon@mailinator.com', NULL, '$2y$12$qSQc3wOj0F9SmTN6h1hND.Ps6XyoWrv5qSA/eGnBIn6.rgQ/aq4Bi', NULL, '2025-01-11 23:55:37', '2025-01-11 23:55:37'),
(12, 'Abrar Fahim', 'qozoh@mailinator.com', NULL, '$2y$12$5WSbzye7hjtxCzpJTSggqe7HP5gHjZZVgWfpudGxRC3A7MJP4gZ.i', NULL, '2025-01-12 01:46:36', '2025-01-12 01:46:36'),
(13, 'Ria Cline', 'pyxumerid@mailinator.com', NULL, '$2y$12$Ykq6ELUFXXPJNZPvCO0rtOWbz1JSnk2TISotng8Kc/cgRwWES20oK', NULL, '2025-01-12 08:50:01', '2025-01-12 08:50:01'),
(14, 'Taylor Giles', 'sugatyzex@mailinator.com', NULL, '$2y$12$TdoV7/D6P5Skd9cVYL6kXO6OnCdBS22KCjVm/Z3I93BmfaEdtWq0m', NULL, '2025-01-13 21:22:13', '2025-01-13 21:22:13'),
(15, 'Justina Cash', 'gytyt@mailinator.com', NULL, '$2y$12$bWOe1eX7yPbldxi4QywN0Ow3kB7hYDJnvIlrVrqaRMLIr/s2J31zS', NULL, '2025-01-13 21:22:24', '2025-01-13 21:22:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `educations`
--
ALTER TABLE `educations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `experience`
--
ALTER TABLE `experience`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `headings`
--
ALTER TABLE `headings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `headings_email_unique` (`email`);

--
-- Indexes for table `language_proficiency`
--
ALTER TABLE `language_proficiency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `objective`
--
ALTER TABLE `objective`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `test_email_unique` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `educations`
--
ALTER TABLE `educations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `experience`
--
ALTER TABLE `experience`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `headings`
--
ALTER TABLE `headings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `language_proficiency`
--
ALTER TABLE `language_proficiency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `objective`
--
ALTER TABLE `objective`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `test`
--
ALTER TABLE `test`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
