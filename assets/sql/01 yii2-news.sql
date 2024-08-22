-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 22, 2024 at 04:22 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `yii2_news`
--

-- --------------------------------------------------------

--
-- Table structure for table `tx_article`
--

CREATE TABLE `tx_article` (
                              `id` int(11) NOT NULL,
                              `office_id` int(11) DEFAULT NULL,
                              `article_category_id` int(11) DEFAULT NULL,
                              `author_id` int(11) DEFAULT NULL,
                              `title` varchar(200) DEFAULT NULL,
                              `cover` varchar(300) DEFAULT NULL,
                              `url` varchar(300) DEFAULT NULL,
                              `content` longtext DEFAULT NULL,
                              `description` longtext DEFAULT NULL,
                              `tags` text DEFAULT NULL,
                              `publish_status` int(11) DEFAULT NULL,
                              `pinned_status` int(11) DEFAULT NULL,
                              `view_counter` int(11) DEFAULT NULL,
                              `rating` float DEFAULT NULL,
                              `date_issued` date DEFAULT NULL,
                              `created_at` datetime DEFAULT NULL,
                              `updated_at` datetime DEFAULT NULL,
                              `created_by` int(11) DEFAULT NULL,
                              `updated_by` int(11) DEFAULT NULL,
                              `is_deleted` int(11) DEFAULT NULL,
                              `deleted_at` datetime DEFAULT NULL,
                              `deleted_by` int(11) DEFAULT NULL,
                              `verlock` bigint(20) DEFAULT NULL,
                              `uuid` varchar(36) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tx_article_category`
--

CREATE TABLE `tx_article_category` (
                                       `id` int(11) NOT NULL,
                                       `office_id` int(11) DEFAULT NULL,
                                       `title` varchar(100) DEFAULT NULL,
                                       `label` varchar(20) DEFAULT NULL,
                                       `sequence` int(11) DEFAULT NULL,
                                       `description` text DEFAULT NULL,
                                       `time_line` int(11) DEFAULT NULL,
                                       `created_at` datetime DEFAULT NULL,
                                       `updated_at` datetime DEFAULT NULL,
                                       `created_by` int(11) DEFAULT NULL,
                                       `updated_by` int(11) DEFAULT NULL,
                                       `is_deleted` int(11) DEFAULT NULL,
                                       `deleted_at` datetime DEFAULT NULL,
                                       `deleted_by` int(11) DEFAULT NULL,
                                       `verlock` bigint(20) DEFAULT NULL,
                                       `uuid` varchar(36) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tx_asset`
--

CREATE TABLE `tx_asset` (
                            `id` int(11) NOT NULL,
                            `office_id` int(11) DEFAULT NULL,
                            `is_visible` int(11) DEFAULT NULL,
                            `asset_type` int(11) DEFAULT NULL,
                            `asset_group` int(11) DEFAULT NULL,
                            `asset_category_id` int(11) DEFAULT NULL,
                            `title` varchar(200) DEFAULT NULL,
                            `date_issued` date DEFAULT NULL,
                            `asset_name` varchar(100) DEFAULT NULL,
                            `asset_url` varchar(500) DEFAULT NULL,
                            `size` int(11) DEFAULT NULL,
                            `mime_type` varchar(100) DEFAULT NULL,
                            `view_counter` int(11) DEFAULT NULL,
                            `download_counter` int(11) DEFAULT NULL,
                            `description` text DEFAULT NULL,
                            `created_at` datetime DEFAULT NULL,
                            `updated_at` datetime DEFAULT NULL,
                            `created_by` int(11) DEFAULT NULL,
                            `updated_by` int(11) DEFAULT NULL,
                            `is_deleted` int(11) DEFAULT NULL,
                            `deleted_at` datetime DEFAULT NULL,
                            `deleted_by` int(11) DEFAULT NULL,
                            `verlock` bigint(20) DEFAULT NULL,
                            `uuid` varchar(36) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tx_asset_category`
--

CREATE TABLE `tx_asset_category` (
                                     `id` int(11) NOT NULL,
                                     `office_id` int(11) DEFAULT NULL,
                                     `title` varchar(200) DEFAULT NULL,
                                     `sequence` int(11) DEFAULT NULL,
                                     `description` text DEFAULT NULL,
                                     `created_at` datetime DEFAULT NULL,
                                     `updated_at` datetime DEFAULT NULL,
                                     `created_by` int(11) DEFAULT NULL,
                                     `updated_by` int(11) DEFAULT NULL,
                                     `is_deleted` int(11) DEFAULT NULL,
                                     `deleted_at` datetime DEFAULT NULL,
                                     `deleted_by` int(11) DEFAULT NULL,
                                     `verlock` bigint(20) DEFAULT NULL,
                                     `uuid` varchar(36) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tx_author`
--

CREATE TABLE `tx_author` (
                             `id` int(11) NOT NULL,
                             `office_id` int(11) DEFAULT NULL,
                             `user_id` int(11) DEFAULT NULL,
                             `title` varchar(100) DEFAULT NULL,
                             `phone_number` varchar(50) DEFAULT NULL,
                             `email` varchar(100) DEFAULT NULL,
                             `file_name` varchar(100) DEFAULT NULL,
                             `address` tinytext DEFAULT NULL,
                             `description` text DEFAULT NULL,
                             `created_at` datetime DEFAULT NULL,
                             `updated_at` datetime DEFAULT NULL,
                             `created_by` int(11) DEFAULT NULL,
                             `updated_by` int(11) DEFAULT NULL,
                             `is_deleted` int(11) DEFAULT NULL,
                             `deleted_at` datetime DEFAULT NULL,
                             `deleted_by` int(11) DEFAULT NULL,
                             `verlock` bigint(20) DEFAULT NULL,
                             `uuid` varchar(36) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tx_author`
--

INSERT INTO `tx_author` (`id`, `office_id`, `user_id`, `title`, `phone_number`, `email`, `file_name`, `address`, `description`, `created_at`, `updated_at`, `created_by`, `updated_by`, `is_deleted`, `deleted_at`, `deleted_by`, `verlock`, `uuid`) VALUES
    (1, NULL, NULL, 'Admin', '', 'hubunganinternasional.id@gmail.com', 'qqWkyzDJaNIAC7uPjV4E4B12Ul0J9R7c.jpg', '', '', '2018-06-12 15:43:58', '2019-08-14 10:34:00', 1, 1, NULL, NULL, NULL, 3, '');

-- --------------------------------------------------------

--
-- Table structure for table `tx_author_media`
--

CREATE TABLE `tx_author_media` (
                                   `id` int(11) NOT NULL,
                                   `office_id` int(11) DEFAULT NULL,
                                   `author_id` int(11) DEFAULT NULL,
                                   `media_type` int(11) DEFAULT NULL,
                                   `title` varchar(100) DEFAULT NULL,
                                   `description` longtext DEFAULT NULL,
                                   `created_at` datetime DEFAULT NULL,
                                   `updated_at` datetime DEFAULT NULL,
                                   `created_by` int(11) DEFAULT NULL,
                                   `updated_by` int(11) DEFAULT NULL,
                                   `is_deleted` int(11) DEFAULT NULL,
                                   `deleted_at` datetime DEFAULT NULL,
                                   `deleted_by` int(11) DEFAULT NULL,
                                   `verlock` bigint(20) DEFAULT NULL,
                                   `uuid` varchar(36) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tx_auth_assignment`
--

CREATE TABLE `tx_auth_assignment` (
                                      `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
                                      `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
                                      `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tx_auth_assignment`
--

INSERT INTO `tx_auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
    ('admin', '1', 1724335957);

-- --------------------------------------------------------

--
-- Table structure for table `tx_auth_item`
--

CREATE TABLE `tx_auth_item` (
                                `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
                                `type` smallint(6) NOT NULL,
                                `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
                                `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
                                `data` blob DEFAULT NULL,
                                `created_at` int(11) DEFAULT NULL,
                                `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tx_auth_item`
--

INSERT INTO `tx_auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
                                                                                                                ('admin', 1, 'Admin', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('create-article', 2, 'Create Article', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('create-articlecategory', 2, 'Create Article Category', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('create-asset', 2, 'Create Asset', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('create-assetcategory', 2, 'Create Asset Category', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('create-author', 2, 'Create Author', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('create-authormedia', 2, 'Create Author Media', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('create-employment', 2, 'Create Employment', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('create-event', 2, 'Create Event', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('create-master', 2, 'Create Master', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('create-office', 2, 'Create Office', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('create-officemedia', 2, 'Create Office Media', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('create-page', 2, 'Create Page', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('create-profile', 2, 'Create Profile', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('create-quote', 2, 'Create Quote', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('create-staff', 2, 'Create Staff', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('create-staffmedia', 2, 'Create Staff Media', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('create-transaction', 2, 'Create Transaction', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('create-user-owner', 2, 'Create User Owner', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('create-user-regular', 2, 'Create User Regular', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('delete-article', 2, 'Delete Article', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('delete-articlecategory', 2, 'Delete Article Category', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('delete-asset', 2, 'Delete Asset', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('delete-assetcategory', 2, 'Delete Asset Category', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('delete-author', 2, 'Delete Author', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('delete-authormedia', 2, 'Delete Author Media', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('delete-employment', 2, 'Delete Employment', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('delete-event', 2, 'Delete Event', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('delete-master', 2, 'Delete Master', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('delete-office', 2, 'Delete Office', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('delete-officemedia', 2, 'Delete Office Media', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('delete-page', 2, 'Delete Page', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('delete-profile', 2, 'Delete Profile', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('delete-quote', 2, 'Delete Quote', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('delete-staff', 2, 'Delete Staff', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('delete-staffmedia', 2, 'Delete Staff Media', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('delete-transaction', 2, 'Delete Transaction', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('guest', 1, 'Guest', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('index-article', 2, 'Index Article', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('index-articlecategory', 2, 'Index Article Category', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('index-asset', 2, 'Index Asset', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('index-assetcategory', 2, 'Index Asset Category', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('index-author', 2, 'Index Author', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('index-authormedia', 2, 'Index Author Media', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('index-employment', 2, 'Index Employment', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('index-event', 2, 'Index Event', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('index-master', 2, 'Index Master', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('index-office', 2, 'Index Office', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('index-officemedia', 2, 'Index Office Media', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('index-page', 2, 'Index Page', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('index-profile', 2, 'Index Profile', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('index-quote', 2, 'Index Quote', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('index-staff', 2, 'Index Staff', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('index-staffmedia', 2, 'Index Staff Media', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('index-transaction', 2, 'Index Transaction', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('regular', 1, 'Reguler', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('report-article', 2, 'Report Article', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('report-articlecategory', 2, 'Report Article Category', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('report-asset', 2, 'Report Asset', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('report-assetcategory', 2, 'Report Asset Category', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('report-master', 2, 'Report Master', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('report-transaction', 2, 'Report Transaction', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('update-article', 2, 'Update Article', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('update-articlecategory', 2, 'Update Archive Category', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('update-asset', 2, 'Update Asset', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('update-assetcategory', 2, 'Update Asset Category', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('update-author', 2, 'Update Author', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('update-authormedia', 2, 'Update Author Media', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('update-employment', 2, 'Update Employment', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('update-event', 2, 'Update Event', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('update-master', 2, 'Update Master', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('update-office', 2, 'Update Office', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('update-officemedia', 2, 'Update Office Media', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('update-page', 2, 'Update Page', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('update-profile', 2, 'Update Profile', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('update-quote', 2, 'Update Quote', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('update-staff', 2, 'Update Staff', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('update-staffmedia', 2, 'Update Staff Media', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('update-transaction', 2, 'Update Transaction', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('view-article', 2, 'View Article', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('view-articlecategory', 2, 'View Article Category', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('view-asset', 2, 'View Asset', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('view-assetcategory', 2, 'View Asset Category', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('view-author', 2, 'View Author', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('view-authormedia', 2, 'View Author Media', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('view-employment', 2, 'View Employment', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('view-event', 2, 'View Event', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('view-master', 2, 'View Master', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('view-office', 2, 'View Office', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('view-officemedia', 2, 'View Office Media', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('view-page', 2, 'View Page', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('view-profile', 2, 'View Profile', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('view-quote', 2, 'View Quote', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('view-staff', 2, 'View Staff', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('view-staffmedia', 2, 'View Staff Media', NULL, NULL, 1724335957, 1724335957),
                                                                                                                ('view-transaction', 2, 'View Transaction', NULL, NULL, 1724335957, 1724335957);

-- --------------------------------------------------------

--
-- Table structure for table `tx_auth_item_child`
--

CREATE TABLE `tx_auth_item_child` (
                                      `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
                                      `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tx_auth_item_child`
--

INSERT INTO `tx_auth_item_child` (`parent`, `child`) VALUES
                                                         ('admin', 'create-master'),
                                                         ('admin', 'create-transaction'),
                                                         ('admin', 'create-user-owner'),
                                                         ('admin', 'delete-master'),
                                                         ('admin', 'delete-transaction'),
                                                         ('admin', 'index-master'),
                                                         ('admin', 'index-transaction'),
                                                         ('admin', 'report-master'),
                                                         ('admin', 'report-transaction'),
                                                         ('admin', 'update-master'),
                                                         ('admin', 'update-transaction'),
                                                         ('admin', 'view-master'),
                                                         ('admin', 'view-transaction'),
                                                         ('create-master', 'create-articlecategory'),
                                                         ('create-master', 'create-assetcategory'),
                                                         ('create-master', 'create-author'),
                                                         ('create-master', 'create-authormedia'),
                                                         ('create-master', 'create-employment'),
                                                         ('create-master', 'create-event'),
                                                         ('create-master', 'create-office'),
                                                         ('create-master', 'create-officemedia'),
                                                         ('create-master', 'create-page'),
                                                         ('create-master', 'create-profile'),
                                                         ('create-master', 'create-quote'),
                                                         ('create-master', 'create-staff'),
                                                         ('create-master', 'create-staffmedia'),
                                                         ('create-transaction', 'create-article'),
                                                         ('create-transaction', 'create-asset'),
                                                         ('delete-master', 'delete-articlecategory'),
                                                         ('delete-master', 'delete-assetcategory'),
                                                         ('delete-master', 'delete-author'),
                                                         ('delete-master', 'delete-authormedia'),
                                                         ('delete-master', 'delete-employment'),
                                                         ('delete-master', 'delete-event'),
                                                         ('delete-master', 'delete-office'),
                                                         ('delete-master', 'delete-officemedia'),
                                                         ('delete-master', 'delete-page'),
                                                         ('delete-master', 'delete-profile'),
                                                         ('delete-master', 'delete-quote'),
                                                         ('delete-master', 'delete-staff'),
                                                         ('delete-master', 'delete-staffmedia'),
                                                         ('delete-transaction', 'delete-article'),
                                                         ('delete-transaction', 'delete-asset'),
                                                         ('guest', 'index-article'),
                                                         ('guest', 'index-asset'),
                                                         ('guest', 'view-article'),
                                                         ('guest', 'view-asset'),
                                                         ('index-master', 'index-articlecategory'),
                                                         ('index-master', 'index-assetcategory'),
                                                         ('index-master', 'index-author'),
                                                         ('index-master', 'index-authormedia'),
                                                         ('index-master', 'index-employment'),
                                                         ('index-master', 'index-event'),
                                                         ('index-master', 'index-office'),
                                                         ('index-master', 'index-officemedia'),
                                                         ('index-master', 'index-page'),
                                                         ('index-master', 'index-profile'),
                                                         ('index-master', 'index-quote'),
                                                         ('index-master', 'index-staff'),
                                                         ('index-master', 'index-staffmedia'),
                                                         ('index-transaction', 'create-user-regular'),
                                                         ('index-transaction', 'index-article'),
                                                         ('index-transaction', 'index-asset'),
                                                         ('regular', 'create-transaction'),
                                                         ('regular', 'delete-transaction'),
                                                         ('regular', 'index-transaction'),
                                                         ('regular', 'report-transaction'),
                                                         ('regular', 'update-profile'),
                                                         ('regular', 'update-transaction'),
                                                         ('regular', 'view-profile'),
                                                         ('regular', 'view-transaction'),
                                                         ('report-master', 'report-articlecategory'),
                                                         ('report-master', 'report-assetcategory'),
                                                         ('update-master', 'update-articlecategory'),
                                                         ('update-master', 'update-assetcategory'),
                                                         ('update-master', 'update-author'),
                                                         ('update-master', 'update-authormedia'),
                                                         ('update-master', 'update-employment'),
                                                         ('update-master', 'update-event'),
                                                         ('update-master', 'update-office'),
                                                         ('update-master', 'update-officemedia'),
                                                         ('update-master', 'update-page'),
                                                         ('update-master', 'update-profile'),
                                                         ('update-master', 'update-quote'),
                                                         ('update-master', 'update-staff'),
                                                         ('update-master', 'update-staffmedia'),
                                                         ('update-transaction', 'update-article'),
                                                         ('update-transaction', 'update-asset'),
                                                         ('view-master', 'view-articlecategory'),
                                                         ('view-master', 'view-assetcategory'),
                                                         ('view-master', 'view-author'),
                                                         ('view-master', 'view-authormedia'),
                                                         ('view-master', 'view-employment'),
                                                         ('view-master', 'view-event'),
                                                         ('view-master', 'view-office'),
                                                         ('view-master', 'view-officemedia'),
                                                         ('view-master', 'view-page'),
                                                         ('view-master', 'view-profile'),
                                                         ('view-master', 'view-quote'),
                                                         ('view-master', 'view-staff'),
                                                         ('view-master', 'view-staffmedia'),
                                                         ('view-transaction', 'view-article'),
                                                         ('view-transaction', 'view-asset');

-- --------------------------------------------------------

--
-- Table structure for table `tx_auth_rule`
--

CREATE TABLE `tx_auth_rule` (
                                `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
                                `data` blob DEFAULT NULL,
                                `created_at` int(11) DEFAULT NULL,
                                `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tx_counter`
--

CREATE TABLE `tx_counter` (
                              `id` varchar(8) NOT NULL,
                              `office_id` int(11) DEFAULT NULL,
                              `counter` int(11) DEFAULT NULL,
                              `created_at` datetime DEFAULT NULL,
                              `updated_at` datetime DEFAULT NULL,
                              `created_by` int(11) DEFAULT NULL,
                              `updated_by` int(11) DEFAULT NULL,
                              `is_deleted` int(11) DEFAULT NULL,
                              `deleted_at` datetime DEFAULT NULL,
                              `deleted_by` int(11) DEFAULT NULL,
                              `verlock` bigint(20) DEFAULT NULL,
                              `uuid` varchar(36) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tx_dashblock`
--

CREATE TABLE `tx_dashblock` (
                                `id` int(11) UNSIGNED NOT NULL,
                                `title` varchar(255) NOT NULL DEFAULT '',
                                `actions` text DEFAULT NULL,
                                `weight` int(11) UNSIGNED NOT NULL DEFAULT 0,
                                `status` tinyint(4) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tx_employment`
--

CREATE TABLE `tx_employment` (
                                 `id` int(11) NOT NULL,
                                 `office_id` int(11) DEFAULT NULL,
                                 `title` varchar(100) DEFAULT NULL,
                                 `description` text DEFAULT NULL,
                                 `sequence` tinyint(4) DEFAULT NULL,
                                 `created_at` datetime DEFAULT NULL,
                                 `updated_at` datetime DEFAULT NULL,
                                 `created_by` int(11) DEFAULT NULL,
                                 `updated_by` int(11) DEFAULT NULL,
                                 `is_deleted` int(11) DEFAULT NULL,
                                 `deleted_at` datetime DEFAULT NULL,
                                 `deleted_by` int(11) DEFAULT NULL,
                                 `verlock` bigint(20) DEFAULT NULL,
                                 `uuid` varchar(36) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tx_employment`
--

INSERT INTO `tx_employment` (`id`, `office_id`, `title`, `description`, `sequence`, `created_at`, `updated_at`, `created_by`, `updated_by`, `is_deleted`, `deleted_at`, `deleted_by`, `verlock`, `uuid`) VALUES
    (2, 1, 'Developer', '', 1, '2015-09-01 20:38:25', '2020-08-14 14:46:07', 1, 1, NULL, NULL, NULL, 4, '');

-- --------------------------------------------------------

--
-- Table structure for table `tx_event`
--

CREATE TABLE `tx_event` (
                            `id` int(11) NOT NULL,
                            `office_id` int(11) DEFAULT NULL,
                            `title` varchar(200) DEFAULT NULL,
                            `date_start` datetime DEFAULT NULL,
                            `date_end` datetime DEFAULT NULL,
                            `location` tinytext DEFAULT NULL,
                            `content` text DEFAULT NULL,
                            `view_counter` int(11) DEFAULT NULL,
                            `description` text DEFAULT NULL,
                            `is_active` tinyint(1) DEFAULT NULL,
                            `created_at` datetime DEFAULT NULL,
                            `updated_at` datetime DEFAULT NULL,
                            `created_by` int(11) DEFAULT NULL,
                            `updated_by` int(11) DEFAULT NULL,
                            `is_deleted` int(11) DEFAULT NULL,
                            `deleted_at` datetime DEFAULT NULL,
                            `deleted_by` int(11) DEFAULT NULL,
                            `verlock` bigint(20) DEFAULT NULL,
                            `uuid` varchar(36) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tx_migration`
--

CREATE TABLE `tx_migration` (
                                `version` varchar(180) NOT NULL,
                                `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tx_migration`
--

INSERT INTO `tx_migration` (`version`, `apply_time`) VALUES
                                                         ('Da\\User\\Migration\\m000000_000001_create_user_table', 1507740966),
                                                         ('Da\\User\\Migration\\m000000_000002_create_profile_table', 1507740968),
                                                         ('Da\\User\\Migration\\m000000_000003_create_social_account_table', 1507740970),
                                                         ('Da\\User\\Migration\\m000000_000004_create_token_table', 1507740972),
                                                         ('Da\\User\\Migration\\m000000_000005_add_last_login_at', 1507740973),
                                                         ('Da\\User\\Migration\\m000000_000006_add_two_factor_fields', 1514392155),
                                                         ('m140506_102106_rbac_init', 1507741269),
                                                         ('m170907_052038_rbac_add_index_on_auth_assignment_user_id', 1514392156);

-- --------------------------------------------------------

--
-- Table structure for table `tx_office`
--

CREATE TABLE `tx_office` (
                             `id` int(11) NOT NULL,
                             `unique_id` varchar(15) DEFAULT NULL,
                             `title` varchar(100) DEFAULT NULL,
                             `phone_number` varchar(100) DEFAULT NULL,
                             `fax_number` varchar(100) DEFAULT NULL,
                             `email` varchar(100) DEFAULT NULL,
                             `web` varchar(100) DEFAULT NULL,
                             `address` varchar(100) DEFAULT NULL,
                             `latitude` varchar(100) DEFAULT NULL,
                             `longitude` varchar(100) DEFAULT NULL,
                             `description` tinytext DEFAULT NULL,
                             `created_at` datetime DEFAULT NULL,
                             `updated_at` datetime DEFAULT NULL,
                             `created_by` int(11) DEFAULT NULL,
                             `updated_by` int(11) DEFAULT NULL,
                             `is_deleted` int(11) DEFAULT NULL,
                             `deleted_at` datetime DEFAULT NULL,
                             `deleted_by` int(11) DEFAULT NULL,
                             `verlock` bigint(20) DEFAULT NULL,
                             `uuid` varchar(36) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tx_office`
--

INSERT INTO `tx_office` (`id`, `unique_id`, `title`, `phone_number`, `fax_number`, `email`, `web`, `address`, `latitude`, `longitude`, `description`, `created_at`, `updated_at`, `created_by`, `updated_by`, `is_deleted`, `deleted_at`, `deleted_by`, `verlock`, `uuid`) VALUES
    (1, '66a1250c9bdb4', 'Hubungan Internasional', '081226993704', '45635345', 'hubunganinternasional.id@gmail.com', 'hubunganinternasional.id', 'Bantul, Yogyakarta', '', '', '-', '2015-05-02 10:17:07', '2024-07-24 23:02:59', 1, 1, 0, NULL, NULL, 14, '');

-- --------------------------------------------------------

--
-- Table structure for table `tx_office_media`
--

CREATE TABLE `tx_office_media` (
                                   `id` int(11) NOT NULL,
                                   `office_id` int(11) DEFAULT NULL,
                                   `media_type` int(11) DEFAULT NULL,
                                   `title` varchar(100) DEFAULT NULL,
                                   `description` longtext DEFAULT NULL,
                                   `created_at` datetime DEFAULT NULL,
                                   `updated_at` datetime DEFAULT NULL,
                                   `created_by` int(11) DEFAULT NULL,
                                   `updated_by` int(11) DEFAULT NULL,
                                   `is_deleted` int(11) DEFAULT NULL,
                                   `deleted_at` datetime DEFAULT NULL,
                                   `deleted_by` int(11) DEFAULT NULL,
                                   `verlock` bigint(20) DEFAULT NULL,
                                   `uuid` varchar(36) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tx_office_media`
--

INSERT INTO `tx_office_media` (`id`, `office_id`, `media_type`, `title`, `description`, `created_at`, `updated_at`, `created_by`, `updated_by`, `is_deleted`, `deleted_at`, `deleted_by`, `verlock`, `uuid`) VALUES
                                                                                                                                                                                                                 (2, 1, 12, 'Kubernate', 'https://kubernetes.io/docs/concepts/overview/', '2024-07-22 21:41:05', '2024-07-22 21:41:05', 1, 1, NULL, NULL, NULL, 0, '6bf3b00e483811efbe97c858c0b7f92f'),
                                                                                                                                                                                                                 (3, 1, 11, 'fa-brands fa-facebook', '', '2024-07-22 21:43:38', '2024-07-22 21:43:38', 1, 1, NULL, NULL, NULL, 0, 'c6e6bbca483811efbe97c858c0b7f92f');

-- --------------------------------------------------------

--
-- Table structure for table `tx_page`
--

CREATE TABLE `tx_page` (
                           `id` int(11) NOT NULL,
                           `page_type` int(11) DEFAULT NULL,
                           `title` varchar(100) DEFAULT NULL,
                           `content` text DEFAULT NULL,
                           `description` tinytext DEFAULT NULL,
                           `created_at` datetime DEFAULT NULL,
                           `updated_at` datetime DEFAULT NULL,
                           `created_by` int(11) DEFAULT NULL,
                           `updated_by` int(11) DEFAULT NULL,
                           `is_deleted` int(11) DEFAULT NULL,
                           `deleted_at` datetime DEFAULT NULL,
                           `deleted_by` int(11) DEFAULT NULL,
                           `verlock` bigint(20) DEFAULT NULL,
                           `uuid` varchar(36) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tx_page`
--

INSERT INTO `tx_page` (`id`, `page_type`, `title`, `content`, `description`, `created_at`, `updated_at`, `created_by`, `updated_by`, `is_deleted`, `deleted_at`, `deleted_by`, `verlock`, `uuid`) VALUES
                                                                                                                                                                                                      (1, 2, 'Logo 1', '<p><img style=\"width: 103px;\" src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGcAAAAnCAYAAAASGVaVAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA3hpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMDY3IDc5LjE1Nzc0NywgMjAxNS8wMy8zMC0yMzo0MDo0MiAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDo3YTJkN2YzYS0xNGQxLTQyODQtYmYwZC00MGUxZTJkMjNjOGYiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6ODcxNjQ4RjBEMDI5MTFFNjhFOUZCNTlCN0ZERTdEREIiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6ODcxNjQ4RUZEMDI5MTFFNjhFOUZCNTlCN0ZERTdEREIiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTUgKE1hY2ludG9zaCkiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDo3YTJkN2YzYS0xNGQxLTQyODQtYmYwZC00MGUxZTJkMjNjOGYiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6N2EyZDdmM2EtMTRkMS00Mjg0LWJmMGQtNDBlMWUyZDIzYzhm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\" data-filename=\"logo-1.png\"><br></p>', 'Logo 1 - Bagian Atas Kiri', '2018-01-08 21:47:15', '2024-08-18 15:55:56', 1, 1, NULL, NULL, NULL, 0, ''),
                                                                                                                                                                                                      (2, 2, 'Logo 2', '<p><img style=\"width: 200px;\" src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMgAAAAnCAYAAABKSgfJAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyhpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMDE0IDc5LjE1Njc5NywgMjAxNC8wOC8yMC0wOTo1MzowMiAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTQgKE1hY2ludG9zaCkiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6MERFMUI5RERGNTlGMTFFNDk4QTZDQjA2OEIzQTJBRUUiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6MERFMUI5REVGNTlGMTFFNDk4QTZDQjA2OEIzQTJBRUUiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDowREUxQjlEQkY1OUYxMUU0OThBNkNCMDY4QjNBMkFFRSIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDowREUxQjlEQ0Y1OUYxMUU0OThBNkNCMDY4QjNBMkFFRSIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PoaoddcAAA6SSURBVHja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\" data-filename=\"logo-14.png\"><br></p>', 'Logo 2 - Bagian Bawah Kiri', '2018-01-08 21:47:15', '2024-08-18 15:55:41', 1, 1, NULL, NULL, NULL, 0, ''),
                                                                                                                                                                                                      (3, 2, 'Logo Report 1', 'b3MYTwJeYCkb4IUmLrPkjcePntzALUBi.png', 'Logo 1 - Bagian Atas Kiri', '2018-01-08 21:47:15', '2018-01-08 21:47:15', 1, 1, NULL, NULL, NULL, 0, ''),
                                                                                                                                                                                                      (4, 2, 'Logo Report 2', 'q8Z7e_TqQrBwU8URdcZ4I7t62u3-EHCm.png', 'NA', '2018-01-08 21:47:15', '2018-01-08 21:47:15', 1, 1, NULL, NULL, NULL, 0, ''),
                                                                                                                                                                                                      (11, 1, 'SEO Description', '<p>seo description here testing<br></p>', 'SEO Description', '2018-01-08 21:47:15', '2024-08-18 16:11:04', 1, 1, NULL, NULL, NULL, 1, ''),
                                                                                                                                                                                                      (12, 1, 'SEO Keyword', '<p>seo, keyword, for, my, site<br></p>', 'SEO Keyword', '2018-01-08 21:47:15', '2024-08-18 16:11:20', 1, 1, NULL, NULL, NULL, 1, ''),
                                                                                                                                                                                                      (21, 1, 'About', 'VD6pJHgk7ikBhHW6gmW59mfrWLQhjpFx.png', 'Donec id elit y DESCRIPTION.', '2017-12-02 22:33:55', '2017-12-02 22:39:25', 1, 1, NULL, NULL, NULL, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `tx_profile`
--

CREATE TABLE `tx_profile` (
                              `user_id` int(11) NOT NULL,
                              `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
                              `public_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
                              `gravatar_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
                              `gravatar_id` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
                              `location` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
                              `website` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
                              `timezone` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
                              `bio` text COLLATE utf8_unicode_ci DEFAULT NULL,
                              `file_name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tx_profile`
--

INSERT INTO `tx_profile` (`user_id`, `name`, `public_email`, `gravatar_email`, `gravatar_id`, `location`, `website`, `timezone`, `bio`, `file_name`) VALUES
    (1, 'Nanta Es', 'ombakrinai@gmail.com', '', 'd41d8cd98f00b204e9800998ecf8427e', 'Lhokseumawe', 'https://escyber.com/', NULL, '-', '');

-- --------------------------------------------------------

--
-- Table structure for table `tx_quote`
--

CREATE TABLE `tx_quote` (
                            `id` int(11) NOT NULL,
                            `title` varchar(100) DEFAULT NULL,
                            `content` text DEFAULT NULL,
                            `source` varchar(100) DEFAULT NULL,
                            `file_name` varchar(200) DEFAULT NULL,
                            `description` text DEFAULT NULL,
                            `created_at` datetime DEFAULT NULL,
                            `updated_at` datetime DEFAULT NULL,
                            `created_by` int(11) DEFAULT NULL,
                            `updated_by` int(11) DEFAULT NULL,
                            `is_deleted` int(11) DEFAULT NULL,
                            `deleted_at` datetime DEFAULT NULL,
                            `deleted_by` int(11) DEFAULT NULL,
                            `verlock` bigint(20) DEFAULT NULL,
                            `uuid` varchar(36) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tx_session`
--

CREATE TABLE `tx_session` (
                              `id` char(32) NOT NULL,
                              `expire` int(11) DEFAULT NULL,
                              `data` longblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tx_session`
--

INSERT INTO `tx_session` (`id`, `expire`, `data`) VALUES
                                                      ('0qmlr3iph45nl8cst2fmtvmfm2', 1723382163, 0x5f5f666c6173687c613a303a7b7d5f5f69647c693a313b5f5f617574684b65797c733a33323a226530656538647744706c4c5661476c4b475a74654d5371507031696b4a46516d223b),
                                                      ('0vonnia33auapusrtms0of5c8m', 1723478368, 0x5f5f666c6173687c613a303a7b7d5f5f72657475726e55726c7c733a34323a22687474703a2f2f6c6f63616c686f73742f6170702f796969322d6573637962657231332f61646d696e2f223b5f5f69647c693a313b5f5f617574684b65797c733a33323a226530656538647744706c4c5661476c4b475a74654d5371507031696b4a46516d223b),
                                                      ('cr4nm3fap25lutl3rjuoqdko9d', 1724051742, 0x5f5f666c6173687c613a303a7b7d5f5f69647c693a313b5f5f617574684b65797c733a33323a226530656538647744706c4c5661476c4b475a74654d5371507031696b4a46516d223b),
                                                      ('et40u8ui35oc136spej8od45as', 1723369406, 0x5f5f666c6173687c613a303a7b7d),
                                                      ('lq9fhof7mbjrnvcefcep1rob1b', 1723994741, 0x5f5f666c6173687c613a303a7b7d5f5f72657475726e55726c7c733a34323a22687474703a2f2f6c6f63616c686f73742f6170702f796969322d6573637962657231332f61646d696e2f223b5f5f69647c693a313b5f5f617574684b65797c733a33323a226530656538647744706c4c5661476c4b475a74654d5371507031696b4a46516d223b),
                                                      ('qterljtbj60pp5j8hih5voegje', 1724337615, 0x5f5f666c6173687c613a303a7b7d);

-- --------------------------------------------------------

--
-- Table structure for table `tx_social_account`
--

CREATE TABLE `tx_social_account` (
                                     `id` int(11) NOT NULL,
                                     `user_id` int(11) DEFAULT NULL,
                                     `provider` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                                     `client_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                                     `code` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
                                     `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
                                     `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
                                     `data` text COLLATE utf8_unicode_ci DEFAULT NULL,
                                     `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tx_staff`
--

CREATE TABLE `tx_staff` (
                            `id` int(11) NOT NULL,
                            `office_id` int(11) DEFAULT NULL,
                            `user_id` int(11) DEFAULT NULL,
                            `employment_id` int(11) DEFAULT NULL,
                            `title` varchar(100) DEFAULT NULL,
                            `initial` varchar(10) NOT NULL,
                            `identity_number` varchar(100) DEFAULT NULL,
                            `phone_number` varchar(50) DEFAULT NULL,
                            `gender_status` int(11) DEFAULT NULL,
                            `active_status` int(11) DEFAULT NULL,
                            `address` tinytext DEFAULT NULL,
                            `file_name` varchar(200) DEFAULT NULL,
                            `email` varchar(100) DEFAULT NULL,
                            `google_plus` varchar(100) DEFAULT NULL,
                            `instagram` varchar(100) DEFAULT NULL,
                            `facebook` varchar(100) DEFAULT NULL,
                            `twitter` varchar(100) DEFAULT NULL,
                            `description` tinytext DEFAULT NULL,
                            `created_at` datetime DEFAULT NULL,
                            `updated_at` datetime DEFAULT NULL,
                            `created_by` int(11) DEFAULT NULL,
                            `updated_by` int(11) DEFAULT NULL,
                            `is_deleted` int(11) DEFAULT NULL,
                            `deleted_at` datetime DEFAULT NULL,
                            `deleted_by` int(11) DEFAULT NULL,
                            `verlock` bigint(20) DEFAULT NULL,
                            `uuid` varchar(36) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tx_staff`
--

INSERT INTO `tx_staff` (`id`, `office_id`, `user_id`, `employment_id`, `title`, `initial`, `identity_number`, `phone_number`, `gender_status`, `active_status`, `address`, `file_name`, `email`, `google_plus`, `instagram`, `facebook`, `twitter`, `description`, `created_at`, `updated_at`, `created_by`, `updated_by`, `is_deleted`, `deleted_at`, `deleted_by`, `verlock`, `uuid`) VALUES
    (1, 1, 1, 2, 'Randhi Satria, S.IP., M.A', 'R.S', '', '324234', 1, 1, '', '66a3df381d8ab.jpg', 'ransatriastaff.uns.ac.id', '', '', '', '', 'Dosen Hubungan Internasional Fakultas Ilmu Sosial dan Ilmu Politik Universitas Sebelas Maret Surakarta', '2020-08-14 14:43:54', '2024-07-27 00:39:07', 1, 1, 0, NULL, NULL, 14, '');

-- --------------------------------------------------------

--
-- Table structure for table `tx_staff_media`
--

CREATE TABLE `tx_staff_media` (
                                  `id` int(11) NOT NULL,
                                  `office_id` int(11) DEFAULT NULL,
                                  `staff_id` int(11) DEFAULT NULL,
                                  `media_type` int(11) DEFAULT NULL,
                                  `title` varchar(100) DEFAULT NULL,
                                  `description` longtext DEFAULT NULL,
                                  `created_at` datetime DEFAULT NULL,
                                  `updated_at` datetime DEFAULT NULL,
                                  `created_by` int(11) DEFAULT NULL,
                                  `updated_by` int(11) DEFAULT NULL,
                                  `is_deleted` int(11) DEFAULT NULL,
                                  `deleted_at` datetime DEFAULT NULL,
                                  `deleted_by` int(11) DEFAULT NULL,
                                  `verlock` bigint(20) DEFAULT NULL,
                                  `uuid` varchar(36) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tx_tag`
--

CREATE TABLE `tx_tag` (
                          `id` int(11) NOT NULL,
                          `tag_name` varchar(150) NOT NULL,
                          `frequency` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tx_token`
--

CREATE TABLE `tx_token` (
                            `user_id` int(11) DEFAULT NULL,
                            `code` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
                            `type` smallint(6) NOT NULL,
                            `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tx_token`
--

INSERT INTO `tx_token` (`user_id`, `code`, `type`, `created_at`) VALUES
    (1, 'XxnfcSJhSl93g2OskP24qV-XBKvNS9bj', 0, 1507741399);

-- --------------------------------------------------------

--
-- Table structure for table `tx_user`
--

CREATE TABLE `tx_user` (
                           `id` int(11) NOT NULL,
                           `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                           `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                           `password_hash` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
                           `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
                           `unconfirmed_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
                           `registration_ip` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
                           `flags` int(11) NOT NULL DEFAULT 0,
                           `confirmed_at` int(11) DEFAULT NULL,
                           `blocked_at` int(11) DEFAULT NULL,
                           `updated_at` int(11) NOT NULL,
                           `created_at` int(11) NOT NULL,
                           `last_login_at` int(11) DEFAULT NULL,
                           `auth_tf_key` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
                           `auth_tf_enabled` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tx_user`
--

INSERT INTO `tx_user` (`id`, `username`, `email`, `password_hash`, `auth_key`, `unconfirmed_email`, `registration_ip`, `flags`, `confirmed_at`, `blocked_at`, `updated_at`, `created_at`, `last_login_at`, `auth_tf_key`, `auth_tf_enabled`) VALUES
    (1, 'admin', 'ombakrinai@gmail.com', '$2y$10$oD129/e5PjrTkIV1yiR3AuOc2/XAOXLWgKPfb8svo8BdBA4PUsw3G', 'e0ee8dwDplLVaGlKGZteMSqPp1ikJFQm', NULL, '::1', 0, 1598256482, NULL, 1507741399, 1507741399, 1724050297, NULL, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tx_article`
--
ALTER TABLE `tx_article`
    ADD PRIMARY KEY (`id`),
    ADD KEY `FK_tx_article_author` (`author_id`),
    ADD KEY `FK_tx_article_category` (`article_category_id`),
    ADD KEY `FK_tx_article_publish` (`publish_status`),
    ADD KEY `FK_tx_article_pinned` (`pinned_status`),
    ADD KEY `FK_tx_article_office` (`office_id`);

--
-- Indexes for table `tx_article_category`
--
ALTER TABLE `tx_article_category`
    ADD PRIMARY KEY (`id`),
    ADD KEY `FK_tx_category_time_line` (`time_line`),
    ADD KEY `FK_tx_article_category_office` (`office_id`);

--
-- Indexes for table `tx_asset`
--
ALTER TABLE `tx_asset`
    ADD PRIMARY KEY (`id`),
    ADD KEY `FK_tx_asset_category` (`asset_category_id`),
    ADD KEY `FK_tx_asset_office` (`office_id`);

--
-- Indexes for table `tx_asset_category`
--
ALTER TABLE `tx_asset_category`
    ADD PRIMARY KEY (`id`),
    ADD KEY `FK_tx_asset_category_office` (`office_id`);

--
-- Indexes for table `tx_author`
--
ALTER TABLE `tx_author`
    ADD PRIMARY KEY (`id`),
    ADD KEY `FK_tx_author_user` (`user_id`),
    ADD KEY `FK_tx_author_office` (`office_id`);

--
-- Indexes for table `tx_author_media`
--
ALTER TABLE `tx_author_media`
    ADD PRIMARY KEY (`id`),
    ADD KEY `FK_tx_author_media_office` (`office_id`),
    ADD KEY `FK_tx_author_media_author` (`author_id`);

--
-- Indexes for table `tx_auth_assignment`
--
ALTER TABLE `tx_auth_assignment`
    ADD PRIMARY KEY (`item_name`,`user_id`),
    ADD KEY `auth_assignment_user_id_idx` (`user_id`);

--
-- Indexes for table `tx_auth_item`
--
ALTER TABLE `tx_auth_item`
    ADD PRIMARY KEY (`name`),
    ADD KEY `rule_name` (`rule_name`),
    ADD KEY `idx-auth_item-type` (`type`);

--
-- Indexes for table `tx_auth_item_child`
--
ALTER TABLE `tx_auth_item_child`
    ADD PRIMARY KEY (`parent`,`child`),
    ADD KEY `child` (`child`);

--
-- Indexes for table `tx_auth_rule`
--
ALTER TABLE `tx_auth_rule`
    ADD PRIMARY KEY (`name`);

--
-- Indexes for table `tx_counter`
--
ALTER TABLE `tx_counter`
    ADD PRIMARY KEY (`id`),
    ADD KEY `FK_tx_counter_office` (`office_id`);

--
-- Indexes for table `tx_dashblock`
--
ALTER TABLE `tx_dashblock`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tx_employment`
--
ALTER TABLE `tx_employment`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `job_title_name_UNIQUE` (`title`),
    ADD KEY `FK_tx_employment_office` (`office_id`);

--
-- Indexes for table `tx_event`
--
ALTER TABLE `tx_event`
    ADD PRIMARY KEY (`id`),
    ADD KEY `FK_tx_event_office` (`office_id`);

--
-- Indexes for table `tx_migration`
--
ALTER TABLE `tx_migration`
    ADD PRIMARY KEY (`version`);

--
-- Indexes for table `tx_office`
--
ALTER TABLE `tx_office`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tx_office_media`
--
ALTER TABLE `tx_office_media`
    ADD PRIMARY KEY (`id`),
    ADD KEY `FK_tx_office_media_office` (`office_id`);

--
-- Indexes for table `tx_page`
--
ALTER TABLE `tx_page`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tx_profile`
--
ALTER TABLE `tx_profile`
    ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `tx_quote`
--
ALTER TABLE `tx_quote`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tx_session`
--
ALTER TABLE `tx_session`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tx_social_account`
--
ALTER TABLE `tx_social_account`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `idx_social_account_provider_client_id` (`provider`,`client_id`),
    ADD UNIQUE KEY `idx_social_account_code` (`code`),
    ADD KEY `fk_social_account_user` (`user_id`);

--
-- Indexes for table `tx_staff`
--
ALTER TABLE `tx_staff`
    ADD PRIMARY KEY (`id`),
    ADD KEY `FK_tx_staff_gender` (`gender_status`),
    ADD KEY `FK_tx_staff_role` (`employment_id`),
    ADD KEY `FK_tx_staff_user` (`user_id`),
    ADD KEY `FK_tx_staff_office` (`office_id`);

--
-- Indexes for table `tx_staff_media`
--
ALTER TABLE `tx_staff_media`
    ADD PRIMARY KEY (`id`),
    ADD KEY `FK_tx_staff_media_office` (`office_id`),
    ADD KEY `FK_tx_staff_media_author` (`staff_id`);

--
-- Indexes for table `tx_tag`
--
ALTER TABLE `tx_tag`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tx_token`
--
ALTER TABLE `tx_token`
    ADD UNIQUE KEY `idx_token_user_id_code_type` (`user_id`,`code`,`type`);

--
-- Indexes for table `tx_user`
--
ALTER TABLE `tx_user`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `idx_user_username` (`username`),
    ADD UNIQUE KEY `idx_user_email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tx_article`
--
ALTER TABLE `tx_article`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tx_article_category`
--
ALTER TABLE `tx_article_category`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tx_asset`
--
ALTER TABLE `tx_asset`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tx_asset_category`
--
ALTER TABLE `tx_asset_category`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tx_author`
--
ALTER TABLE `tx_author`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tx_author_media`
--
ALTER TABLE `tx_author_media`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tx_dashblock`
--
ALTER TABLE `tx_dashblock`
    MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tx_employment`
--
ALTER TABLE `tx_employment`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tx_event`
--
ALTER TABLE `tx_event`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tx_office`
--
ALTER TABLE `tx_office`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tx_office_media`
--
ALTER TABLE `tx_office_media`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tx_profile`
--
ALTER TABLE `tx_profile`
    MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tx_quote`
--
ALTER TABLE `tx_quote`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tx_social_account`
--
ALTER TABLE `tx_social_account`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tx_staff`
--
ALTER TABLE `tx_staff`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tx_staff_media`
--
ALTER TABLE `tx_staff_media`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tx_tag`
--
ALTER TABLE `tx_tag`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tx_user`
--
ALTER TABLE `tx_user`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tx_article`
--
ALTER TABLE `tx_article`
    ADD CONSTRAINT `FK_tx_article_author` FOREIGN KEY (`author_id`) REFERENCES `tx_author` (`id`),
    ADD CONSTRAINT `FK_tx_article_category` FOREIGN KEY (`article_category_id`) REFERENCES `tx_article_category` (`id`),
    ADD CONSTRAINT `FK_tx_article_office` FOREIGN KEY (`office_id`) REFERENCES `tx_office` (`id`);

--
-- Constraints for table `tx_article_category`
--
ALTER TABLE `tx_article_category`
    ADD CONSTRAINT `FK_tx_article_category_office` FOREIGN KEY (`office_id`) REFERENCES `tx_office` (`id`);

--
-- Constraints for table `tx_asset`
--
ALTER TABLE `tx_asset`
    ADD CONSTRAINT `FK_tx_asset_category` FOREIGN KEY (`asset_category_id`) REFERENCES `tx_asset_category` (`id`),
    ADD CONSTRAINT `FK_tx_asset_office` FOREIGN KEY (`office_id`) REFERENCES `tx_office` (`id`);

--
-- Constraints for table `tx_asset_category`
--
ALTER TABLE `tx_asset_category`
    ADD CONSTRAINT `FK_tx_asset_category_office` FOREIGN KEY (`office_id`) REFERENCES `tx_office` (`id`);

--
-- Constraints for table `tx_author`
--
ALTER TABLE `tx_author`
    ADD CONSTRAINT `FK_tx_author_office` FOREIGN KEY (`office_id`) REFERENCES `tx_office` (`id`),
    ADD CONSTRAINT `FK_tx_author_user` FOREIGN KEY (`user_id`) REFERENCES `tx_user` (`id`);

--
-- Constraints for table `tx_author_media`
--
ALTER TABLE `tx_author_media`
    ADD CONSTRAINT `FK_tx_author_media_author` FOREIGN KEY (`author_id`) REFERENCES `tx_author` (`id`),
    ADD CONSTRAINT `FK_tx_author_media_office` FOREIGN KEY (`office_id`) REFERENCES `tx_office` (`id`);

--
-- Constraints for table `tx_auth_assignment`
--
ALTER TABLE `tx_auth_assignment`
    ADD CONSTRAINT `tx_auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `tx_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tx_auth_item`
--
ALTER TABLE `tx_auth_item`
    ADD CONSTRAINT `tx_auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `tx_auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tx_auth_item_child`
--
ALTER TABLE `tx_auth_item_child`
    ADD CONSTRAINT `tx_auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `tx_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `tx_auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `tx_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tx_counter`
--
ALTER TABLE `tx_counter`
    ADD CONSTRAINT `FK_tx_counter_office` FOREIGN KEY (`office_id`) REFERENCES `tx_office` (`id`);

--
-- Constraints for table `tx_employment`
--
ALTER TABLE `tx_employment`
    ADD CONSTRAINT `FK_tx_employment_office` FOREIGN KEY (`office_id`) REFERENCES `tx_office` (`id`);

--
-- Constraints for table `tx_event`
--
ALTER TABLE `tx_event`
    ADD CONSTRAINT `FK_tx_event_office` FOREIGN KEY (`office_id`) REFERENCES `tx_office` (`id`);

--
-- Constraints for table `tx_office_media`
--
ALTER TABLE `tx_office_media`
    ADD CONSTRAINT `FK_tx_office_media_office` FOREIGN KEY (`office_id`) REFERENCES `tx_office` (`id`);

--
-- Constraints for table `tx_profile`
--
ALTER TABLE `tx_profile`
    ADD CONSTRAINT `fk_profile_user` FOREIGN KEY (`user_id`) REFERENCES `tx_user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tx_social_account`
--
ALTER TABLE `tx_social_account`
    ADD CONSTRAINT `fk_social_account_user` FOREIGN KEY (`user_id`) REFERENCES `tx_user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tx_staff`
--
ALTER TABLE `tx_staff`
    ADD CONSTRAINT `FK_tx_staff_employment` FOREIGN KEY (`employment_id`) REFERENCES `tx_employment` (`id`),
    ADD CONSTRAINT `FK_tx_staff_office` FOREIGN KEY (`office_id`) REFERENCES `tx_office` (`id`),
    ADD CONSTRAINT `FK_tx_staff_user` FOREIGN KEY (`user_id`) REFERENCES `tx_user` (`id`);

--
-- Constraints for table `tx_staff_media`
--
ALTER TABLE `tx_staff_media`
    ADD CONSTRAINT `FK_tx_staff_media_author` FOREIGN KEY (`staff_id`) REFERENCES `tx_staff` (`id`),
    ADD CONSTRAINT `FK_tx_staff_media_office` FOREIGN KEY (`office_id`) REFERENCES `tx_office` (`id`);

--
-- Constraints for table `tx_token`
--
ALTER TABLE `tx_token`
    ADD CONSTRAINT `fk_token_user` FOREIGN KEY (`user_id`) REFERENCES `tx_user` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
