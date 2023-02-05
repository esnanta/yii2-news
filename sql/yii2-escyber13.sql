/*
SQLyog Ultimate v12.5.1 (64 bit)
MySQL - 10.4.22-MariaDB : Database - yii2-escyber13
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`yii2-escyber13` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `yii2-escyber13`;

/*Table structure for table `tx_album` */

DROP TABLE IF EXISTS `tx_album`;

CREATE TABLE `tx_album` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `album_type` int(11) DEFAULT NULL,
  `cover` varchar(500) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` int(11) DEFAULT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `album_name_UNIQUE` (`title`),
  KEY `FK_tx_album_type` (`album_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `tx_album` */

/*Table structure for table `tx_archive` */

DROP TABLE IF EXISTS `tx_archive`;

CREATE TABLE `tx_archive` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `is_visible` int(11) DEFAULT NULL,
  `archive_type` int(11) DEFAULT NULL,
  `archive_category_id` int(11) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `date_issued` int(11) DEFAULT NULL,
  `file_name` varchar(200) DEFAULT NULL,
  `archive_url` varchar(500) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `mime_type` varchar(100) DEFAULT NULL,
  `view_counter` int(11) DEFAULT NULL,
  `download_counter` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` int(11) DEFAULT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tx_archive_category` (`archive_category_id`),
  CONSTRAINT `FK_tx_archive_category` FOREIGN KEY (`archive_category_id`) REFERENCES `tx_archive_category` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `tx_archive` */

insert  into `tx_archive`(`id`,`is_visible`,`archive_type`,`archive_category_id`,`title`,`date_issued`,`file_name`,`archive_url`,`size`,`mime_type`,`view_counter`,`download_counter`,`description`,`created_at`,`updated_at`,`created_by`,`updated_by`,`is_deleted`,`deleted_at`,`deleted_by`,`verlock`) values 
(1,2,2,1,'Template Opini',1597390756,'sA9CMQGWN_JbpSHqt2lsIrMLkc9Cxfl6.docx',NULL,NULL,NULL,NULL,92,'<p>Template untuk opini pada web hubunganinternasional.id</p>\r\n',1597390756,1639283087,1,1,0,NULL,NULL,95);

/*Table structure for table `tx_archive_category` */

DROP TABLE IF EXISTS `tx_archive_category`;

CREATE TABLE `tx_archive_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) DEFAULT NULL,
  `sequence` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` int(11) DEFAULT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tx_archive_category` */

insert  into `tx_archive_category`(`id`,`title`,`sequence`,`description`,`created_at`,`updated_at`,`created_by`,`updated_by`,`is_deleted`,`deleted_at`,`deleted_by`,`verlock`) values 
(1,'Umum',NULL,'-',2147483647,2147483647,1,1,NULL,NULL,NULL,0);

/*Table structure for table `tx_auth_assignment` */

DROP TABLE IF EXISTS `tx_auth_assignment`;

CREATE TABLE `tx_auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `auth_assignment_user_id_idx` (`user_id`),
  CONSTRAINT `tx_auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `tx_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `tx_auth_assignment` */

insert  into `tx_auth_assignment`(`item_name`,`user_id`,`created_at`) values 
('admin','1',1639282558);

/*Table structure for table `tx_auth_item` */

DROP TABLE IF EXISTS `tx_auth_item`;

CREATE TABLE `tx_auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `tx_auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `tx_auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `tx_auth_item` */

insert  into `tx_auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values 
('admin',1,'Admin',NULL,NULL,1639282558,1639282558),
('create-album',2,'Create Album',NULL,NULL,1639282558,1639282558),
('create-archive',2,'Create Archive',NULL,NULL,1639282558,1639282558),
('create-author',2,'Create Author',NULL,NULL,1639282558,1639282558),
('create-blog',2,'Create Blog',NULL,NULL,1639282558,1639282558),
('create-category',2,'Create Category',NULL,NULL,1639282558,1639282558),
('create-employment',2,'Create Employment',NULL,NULL,1639282558,1639282558),
('create-event',2,'Create Event',NULL,NULL,1639282558,1639282558),
('create-master',2,'Create Master',NULL,NULL,1639282558,1639282558),
('create-office',2,'Create Office',NULL,NULL,1639282558,1639282558),
('create-page',2,'Create Page',NULL,NULL,1639282558,1639282558),
('create-page-type',2,'Create Page Type',NULL,NULL,1639282558,1639282558),
('create-photo',2,'Create Photo',NULL,NULL,1639282558,1639282558),
('create-profile',2,'Create Profile',NULL,NULL,1639282558,1639282558),
('create-quote',2,'Create Quote',NULL,NULL,1639282558,1639282558),
('create-staff',2,'Create Staff',NULL,NULL,1639282558,1639282558),
('create-subscriber',2,'Create Subscriber',NULL,NULL,1639282558,1639282558),
('create-theme',2,'Create Theme',NULL,NULL,1639282558,1639282558),
('create-transaction',2,'Create Transaction',NULL,NULL,1639282558,1639282558),
('delete-album',2,'Delete Album',NULL,NULL,1639282558,1639282558),
('delete-archive',2,'Delete Archive',NULL,NULL,1639282558,1639282558),
('delete-author',2,'Delete Author',NULL,NULL,1639282558,1639282558),
('delete-blog',2,'Delete Blog',NULL,NULL,1639282558,1639282558),
('delete-category',2,'Delete Category',NULL,NULL,1639282558,1639282558),
('delete-employment',2,'Delete Employment',NULL,NULL,1639282558,1639282558),
('delete-event',2,'Delete Event',NULL,NULL,1639282558,1639282558),
('delete-master',2,'Delete Master',NULL,NULL,1639282558,1639282558),
('delete-office',2,'Delete Office',NULL,NULL,1639282558,1639282558),
('delete-page',2,'Delete Page',NULL,NULL,1639282558,1639282558),
('delete-page-type',2,'Delete Page Type',NULL,NULL,1639282558,1639282558),
('delete-photo',2,'Delete Photo',NULL,NULL,1639282558,1639282558),
('delete-profile',2,'Delete Profile',NULL,NULL,1639282558,1639282558),
('delete-quote',2,'Delete Quote',NULL,NULL,1639282558,1639282558),
('delete-staff',2,'Delete Staff',NULL,NULL,1639282558,1639282558),
('delete-subscriber',2,'Delete Subscriber',NULL,NULL,1639282558,1639282558),
('delete-theme',2,'Delete Theme',NULL,NULL,1639282558,1639282558),
('delete-transaction',2,'Delete Transaction',NULL,NULL,1639282558,1639282558),
('guest',1,'Guest',NULL,NULL,1639282558,1639282558),
('index-album',2,'Index Album',NULL,NULL,1639282558,1639282558),
('index-archive',2,'Index Archive',NULL,NULL,1639282558,1639282558),
('index-author',2,'Index Author',NULL,NULL,1639282558,1639282558),
('index-blog',2,'Index Blog',NULL,NULL,1639282558,1639282558),
('index-category',2,'Index Category',NULL,NULL,1639282558,1639282558),
('index-employment',2,'Index Employment',NULL,NULL,1639282558,1639282558),
('index-event',2,'Index Event',NULL,NULL,1639282558,1639282558),
('index-master',2,'Index Master',NULL,NULL,1639282558,1639282558),
('index-office',2,'Index Office',NULL,NULL,1639282558,1639282558),
('index-page',2,'Index Page',NULL,NULL,1639282558,1639282558),
('index-page-type',2,'Index Page Type',NULL,NULL,1639282558,1639282558),
('index-photo',2,'Index Photo',NULL,NULL,1639282558,1639282558),
('index-profile',2,'Index Profile',NULL,NULL,1639282558,1639282558),
('index-quote',2,'Index Quote',NULL,NULL,1639282558,1639282558),
('index-staff',2,'Index Staff',NULL,NULL,1639282558,1639282558),
('index-subscriber',2,'Index Subscriber',NULL,NULL,1639282558,1639282558),
('index-theme',2,'Index Theme',NULL,NULL,1639282558,1639282558),
('index-transaction',2,'Index Transaction',NULL,NULL,1639282558,1639282558),
('reguler',1,'Reguler',NULL,NULL,1639282558,1639282558),
('report-archive',2,'Report Archive',NULL,NULL,1639282558,1639282558),
('report-master',2,'Report Master',NULL,NULL,1639282558,1639282558),
('report-transaction',2,'Report Transaction',NULL,NULL,1639282558,1639282558),
('update-album',2,'Update Album',NULL,NULL,1639282558,1639282558),
('update-archive',2,'Update Archive',NULL,NULL,1639282558,1639282558),
('update-author',2,'Update Author',NULL,NULL,1639282558,1639282558),
('update-blog',2,'Update Blog',NULL,NULL,1639282558,1639282558),
('update-category',2,'Update Category',NULL,NULL,1639282558,1639282558),
('update-employment',2,'Update Employment',NULL,NULL,1639282558,1639282558),
('update-event',2,'Update Event',NULL,NULL,1639282558,1639282558),
('update-master',2,'Update Master',NULL,NULL,1639282558,1639282558),
('update-office',2,'Update Office',NULL,NULL,1639282558,1639282558),
('update-page',2,'Update Page',NULL,NULL,1639282558,1639282558),
('update-page-type',2,'Update Page Type',NULL,NULL,1639282558,1639282558),
('update-photo',2,'Update Photo',NULL,NULL,1639282558,1639282558),
('update-profile',2,'Update Profile',NULL,NULL,1639282558,1639282558),
('update-quote',2,'Update Quote',NULL,NULL,1639282558,1639282558),
('update-staff',2,'Update Staff',NULL,NULL,1639282558,1639282558),
('update-subscriber',2,'Update Subscriber',NULL,NULL,1639282558,1639282558),
('update-theme',2,'Update Theme',NULL,NULL,1639282558,1639282558),
('update-transaction',2,'Update Transaction',NULL,NULL,1639282558,1639282558),
('view-album',2,'View Album',NULL,NULL,1639282558,1639282558),
('view-archive',2,'View Archive',NULL,NULL,1639282558,1639282558),
('view-author',2,'View Author',NULL,NULL,1639282558,1639282558),
('view-blog',2,'View Blog',NULL,NULL,1639282558,1639282558),
('view-category',2,'View Category',NULL,NULL,1639282558,1639282558),
('view-employment',2,'View Employment',NULL,NULL,1639282558,1639282558),
('view-event',2,'View Event',NULL,NULL,1639282558,1639282558),
('view-master',2,'View Master',NULL,NULL,1639282558,1639282558),
('view-office',2,'View Office',NULL,NULL,1639282558,1639282558),
('view-page',2,'View Page',NULL,NULL,1639282558,1639282558),
('view-page-type',2,'View Page Type',NULL,NULL,1639282558,1639282558),
('view-photo',2,'View Photo',NULL,NULL,1639282558,1639282558),
('view-profile',2,'View Profile',NULL,NULL,1639282558,1639282558),
('view-quote',2,'View Quote',NULL,NULL,1639282558,1639282558),
('view-staff',2,'View Staff',NULL,NULL,1639282558,1639282558),
('view-subscriber',2,'View Subscriber',NULL,NULL,1639282558,1639282558),
('view-theme',2,'View Theme',NULL,NULL,1639282558,1639282558),
('view-transaction',2,'View Transaction',NULL,NULL,1639282558,1639282558);

/*Table structure for table `tx_auth_item_child` */

DROP TABLE IF EXISTS `tx_auth_item_child`;

CREATE TABLE `tx_auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `tx_auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `tx_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tx_auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `tx_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `tx_auth_item_child` */

insert  into `tx_auth_item_child`(`parent`,`child`) values 
('admin','create-master'),
('admin','create-transaction'),
('admin','delete-master'),
('admin','delete-transaction'),
('admin','index-master'),
('admin','index-transaction'),
('admin','report-master'),
('admin','report-transaction'),
('admin','update-master'),
('admin','update-transaction'),
('admin','view-master'),
('admin','view-transaction'),
('create-master','create-album'),
('create-master','create-author'),
('create-master','create-category'),
('create-master','create-employment'),
('create-master','create-event'),
('create-master','create-office'),
('create-master','create-page'),
('create-master','create-page-type'),
('create-master','create-photo'),
('create-master','create-profile'),
('create-master','create-quote'),
('create-master','create-staff'),
('create-master','create-subscriber'),
('create-master','create-theme'),
('create-transaction','create-archive'),
('create-transaction','create-blog'),
('create-transaction','create-photo'),
('delete-master','delete-album'),
('delete-master','delete-author'),
('delete-master','delete-category'),
('delete-master','delete-employment'),
('delete-master','delete-event'),
('delete-master','delete-office'),
('delete-master','delete-page'),
('delete-master','delete-page-type'),
('delete-master','delete-photo'),
('delete-master','delete-profile'),
('delete-master','delete-quote'),
('delete-master','delete-staff'),
('delete-master','delete-subscriber'),
('delete-master','delete-theme'),
('delete-transaction','delete-archive'),
('delete-transaction','delete-blog'),
('delete-transaction','delete-photo'),
('guest','index-archive'),
('guest','view-archive'),
('index-master','index-album'),
('index-master','index-author'),
('index-master','index-category'),
('index-master','index-employment'),
('index-master','index-event'),
('index-master','index-office'),
('index-master','index-page'),
('index-master','index-page-type'),
('index-master','index-photo'),
('index-master','index-profile'),
('index-master','index-quote'),
('index-master','index-staff'),
('index-master','index-subscriber'),
('index-master','index-theme'),
('index-transaction','index-archive'),
('index-transaction','index-blog'),
('index-transaction','index-photo'),
('reguler','create-transaction'),
('reguler','delete-transaction'),
('reguler','index-transaction'),
('reguler','report-transaction'),
('reguler','update-profile'),
('reguler','update-transaction'),
('reguler','view-profile'),
('reguler','view-transaction'),
('report-transaction','report-archive'),
('update-master','update-album'),
('update-master','update-author'),
('update-master','update-category'),
('update-master','update-employment'),
('update-master','update-event'),
('update-master','update-office'),
('update-master','update-page'),
('update-master','update-page-type'),
('update-master','update-photo'),
('update-master','update-profile'),
('update-master','update-quote'),
('update-master','update-staff'),
('update-master','update-subscriber'),
('update-master','update-theme'),
('update-transaction','update-archive'),
('update-transaction','update-blog'),
('update-transaction','update-photo'),
('view-master','view-album'),
('view-master','view-author'),
('view-master','view-category'),
('view-master','view-employment'),
('view-master','view-event'),
('view-master','view-office'),
('view-master','view-page'),
('view-master','view-page-type'),
('view-master','view-photo'),
('view-master','view-profile'),
('view-master','view-quote'),
('view-master','view-staff'),
('view-master','view-subscriber'),
('view-master','view-theme'),
('view-transaction','view-archive'),
('view-transaction','view-blog'),
('view-transaction','view-photo');

/*Table structure for table `tx_auth_rule` */

DROP TABLE IF EXISTS `tx_auth_rule`;

CREATE TABLE `tx_auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `tx_auth_rule` */

/*Table structure for table `tx_author` */

DROP TABLE IF EXISTS `tx_author`;

CREATE TABLE `tx_author` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `phone_number` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `google_plus` varchar(100) DEFAULT NULL,
  `instagram` varchar(100) DEFAULT NULL,
  `facebook` varchar(100) DEFAULT NULL,
  `twitter` varchar(100) DEFAULT NULL,
  `file_name` varchar(100) DEFAULT NULL,
  `address` tinytext DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` int(11) DEFAULT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tx_author_user` (`user_id`),
  CONSTRAINT `FK_tx_author_user` FOREIGN KEY (`user_id`) REFERENCES `tx_user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `tx_author` */

insert  into `tx_author`(`id`,`user_id`,`title`,`phone_number`,`email`,`google_plus`,`instagram`,`facebook`,`twitter`,`file_name`,`address`,`description`,`created_at`,`updated_at`,`created_by`,`updated_by`,`is_deleted`,`deleted_at`,`deleted_by`,`verlock`) values 
(1,NULL,'Admin','','hubunganinternasional.id@gmail.com','','','','','qqWkyzDJaNIAC7uPjV4E4B12Ul0J9R7c.jpg','','',1528793038,1565753640,1,1,NULL,NULL,NULL,3),
(2,NULL,'Randhi Satria','','ranbandit@gmail.com','','','','','STLe5rbKQFypLX8zWK-gbOzjjnZ6kniY.jpg','','',1530505946,1551278645,1,1,NULL,NULL,NULL,9);

/*Table structure for table `tx_blog` */

DROP TABLE IF EXISTS `tx_blog`;

CREATE TABLE `tx_blog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `author_id` int(11) DEFAULT NULL,
  `title` varchar(150) NOT NULL,
  `cover` varchar(300) DEFAULT NULL,
  `url` varchar(300) DEFAULT NULL,
  `content` longtext NOT NULL,
  `description` longtext DEFAULT NULL,
  `tags` text DEFAULT NULL,
  `month_period` varchar(6) DEFAULT NULL,
  `publish_status` int(11) NOT NULL,
  `pinned_status` int(11) DEFAULT NULL,
  `view_counter` int(11) DEFAULT NULL,
  `rating` float DEFAULT NULL,
  `date_issued` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` int(11) DEFAULT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tx_blog_author` (`author_id`),
  KEY `FK_tx_blog_category` (`category_id`),
  KEY `FK_tx_blog_publish` (`publish_status`),
  KEY `FK_tx_blog_pinned` (`pinned_status`),
  CONSTRAINT `FK_tx_blog_author` FOREIGN KEY (`author_id`) REFERENCES `tx_author` (`id`),
  CONSTRAINT `FK_tx_blog_category` FOREIGN KEY (`category_id`) REFERENCES `tx_category` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `tx_blog` */

/*Table structure for table `tx_category` */

DROP TABLE IF EXISTS `tx_category`;

CREATE TABLE `tx_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `label` varchar(20) DEFAULT NULL,
  `sequence` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `time_line` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` int(11) DEFAULT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `category_name_UNIQUE` (`title`),
  KEY `FK_tx_category_time_line` (`time_line`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

/*Data for the table `tx_category` */

insert  into `tx_category`(`id`,`title`,`label`,`sequence`,`description`,`time_line`,`created_at`,`updated_at`,`created_by`,`updated_by`,`is_deleted`,`deleted_at`,`deleted_by`,`verlock`) values 
(22,'Serba-Serbi','darkred',2,'Pada kolom ini akan memuat informasi-informasi penting terkait Hubungan Internasional. Rencananya kolom ini akan memuat beberapa informasi penting yang sekiranya berkaitan dengan Hubungan Internasional seperti:\r\n\r\na.	Agenda Mahasiswa Hubungan Internasional\r\nSeperti diketahui bahwasanya mahasiswa hubungan interansional memiliki keaktifan dalam menjalin komunikasi antar sesame mahasiswa. Hal ini dapat dilihat dari forum yang mereka miliki yaitu Forum Komunikasi Mahasiswa Hubungan Internasional Indonesia atau yang biasa disingkat dengan (FKMHII). Forum ini tiap tahunnya rutin mengadakan pertemuan mahasiswa yang dikenal dengan Pertemuan Nasional Mahasiswa Hubungan Internasional se-Indonesia (PNMHII) dengan mengambil tempat berbeda tiap tahunnya. kolom ini juga dapat menjadi sarana untuk mempromosikan agenda mahasiswa dari masing-masing kampus seperti misalnya lomba debat antar mahasiswa HI, simulasi sidang Model United Nations (MUN) ataupun agenda mahasiswa lainnya.\r\n\r\nTeknis pemberian informasi terkait informasi event adalah sebagai berikut:\r\n	Informan memberikan data dari event yang akan diadakan seperti tanggal, lokasi, registrasi dll.\r\n	Event memiliki konten yang berkaitan dengan hubungan internasional\r\n\r\nb.	Agenda dosen Hubungan Interansional\r\nPada kolom ini lebih ditujukan untuk agenda-agenda dosen hubungan Internasional seperti pertemuan Asosiasi Ilmu Hubungan Internasional Indonesia (AIHII) yang rutin diadakan setiap tahunnya dengan mengambil lokasi yang berbeda. Kolom ini juga dapat digunakan untuk informasi seminar-seminar yang bertaraf nasional maupun internasional ataupun general lecture.\r\nTeknis pemberian informasi terkait informasi event adalah sebagai berikut:\r\n	Informan memberikan data dari event yang akan diadakan seperti tanggal, lokasi, registrasi dll.\r\n	Event memiliki konten yang berkaitan dengan hubungan internasional\r\n\r\nc.	Info Prodi Hubungan Internasional di Indonesia\r\nKolom ini berusaha untuk memberikan informasi penting tentang Studi Hubungan Internasional di Indonesia seperti misalnya jumlah prodi S1, S2 dan S3 Hubungan internasional yang ada di Indonesia, kemudian informasi tentang jurnal Hubungan Internasional dengan level nasional terakreditasi di Indonesia (ada berapa jumlahnya, nama jurnalnya, universitasnya dan CPnya). ',1,1522216848,1603128657,1,1,0,NULL,NULL,10),
(23,'Artikel','darkred',3,'Kolom ini khusus untuk HI Bro, HI Sis, Hi Sir dan Hi Maam yang ingin berbagi cerita tentang perjalanan ke luar negeri untuk memberikan gambaran terhadap para pembaca. Kolom ini dapat berisi profil dari Hi Bro, Hi Sis, Hi Sir atau HI Maam ataupun liputan perjalanan ke luar negeri dari HI temans sekalian, ataupun liputan mengikuti event-event tertentu dalam hubungan internasional seperti sidang antar bangsa ataupun hal lain yang berkaitan',1,1522217012,1603128683,1,1,0,NULL,NULL,5),
(24,'Buku','darkred',4,'Kolom ini berisikan materi-materi yang disampaikan dalam mata kuliah HI. tulisan bisa terdiri dari teori-teori dasar yang tujuannya adalah memberikan pengetahuan dasar kepada pembaca ataupun kajian-kajian yang sifatnya lebih intensif lagi',1,1531662771,1603167703,1,1,0,NULL,NULL,4),
(25,'Opini','darkred',5,'Tema untuk rubrik opini terdiri dari tiga. Pertama, opini dengan tema Hubungan Internasional. Kedua, opini tentang dunia pendidikan di Indonesia. Ketiga, opini tentang dinamika perkuliahan. \r\n\r\nide dan gagasan dalam rubrik ini wajib merupakan milik dari si penulis dan belum pernah dipublish di manapun\r\n\r\ntulisan dalam rubrik opini terdiri dari 800-1000 kata\r\n\r\npenulis bertanggung jawab penuh pada konten yang dituliskan dalam opininya tersebut',1,1563977490,1603128690,1,1,0,NULL,NULL,2);

/*Table structure for table `tx_counter` */

DROP TABLE IF EXISTS `tx_counter`;

CREATE TABLE `tx_counter` (
  `id` varchar(8) NOT NULL,
  `counter` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` int(11) DEFAULT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `tx_counter` */

insert  into `tx_counter`(`id`,`counter`,`created_at`,`updated_at`,`created_by`,`updated_by`,`is_deleted`,`deleted_at`,`deleted_by`,`verlock`) values 
('MBA16',7,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),
('MBA17',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),
('REG16',9,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0);

/*Table structure for table `tx_dashblock` */

DROP TABLE IF EXISTS `tx_dashblock`;

CREATE TABLE `tx_dashblock` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `actions` text DEFAULT NULL,
  `weight` int(11) unsigned NOT NULL DEFAULT 0,
  `status` tinyint(4) unsigned NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `tx_dashblock` */

/*Table structure for table `tx_employment` */

DROP TABLE IF EXISTS `tx_employment`;

CREATE TABLE `tx_employment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `sequence` tinyint(4) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` int(11) DEFAULT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `job_title_name_UNIQUE` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `tx_employment` */

insert  into `tx_employment`(`id`,`title`,`description`,`sequence`,`created_at`,`updated_at`,`created_by`,`updated_by`,`is_deleted`,`deleted_at`,`deleted_by`,`verlock`) values 
(2,'Developer','',1,1441114705,1597391167,1,1,NULL,NULL,NULL,4),
(3,'Editor','',2,1597335353,1597389221,1,1,NULL,NULL,NULL,12),
(4,'Reviewer','',3,1597335542,1597389210,1,1,NULL,NULL,NULL,8),
(6,'Teknik Informatika','',4,1597389192,1597389192,1,1,NULL,NULL,NULL,0);

/*Table structure for table `tx_event` */

DROP TABLE IF EXISTS `tx_event`;

CREATE TABLE `tx_event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) DEFAULT NULL,
  `date_start` int(11) DEFAULT NULL,
  `date_end` int(11) DEFAULT NULL,
  `location` tinytext DEFAULT NULL,
  `content` text DEFAULT NULL,
  `view_counter` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` int(11) DEFAULT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `tx_event` */

/*Table structure for table `tx_migration` */

DROP TABLE IF EXISTS `tx_migration`;

CREATE TABLE `tx_migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tx_migration` */

insert  into `tx_migration`(`version`,`apply_time`) values 
('Da\\User\\Migration\\m000000_000001_create_user_table',1507740966),
('Da\\User\\Migration\\m000000_000002_create_profile_table',1507740968),
('Da\\User\\Migration\\m000000_000003_create_social_account_table',1507740970),
('Da\\User\\Migration\\m000000_000004_create_token_table',1507740972),
('Da\\User\\Migration\\m000000_000005_add_last_login_at',1507740973),
('Da\\User\\Migration\\m000000_000006_add_two_factor_fields',1514392155),
('m140506_102106_rbac_init',1507741269),
('m170907_052038_rbac_add_index_on_auth_assignment_user_id',1514392156);

/*Table structure for table `tx_note` */

DROP TABLE IF EXISTS `tx_note`;

CREATE TABLE `tx_note` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `note_type_id` int(11) DEFAULT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `date_issued` int(11) DEFAULT NULL,
  `date_due` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` int(11) DEFAULT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tx_note_note_type` (`note_type_id`),
  KEY `FK_tx_note_staff` (`staff_id`),
  CONSTRAINT `FK_tx_note_staff` FOREIGN KEY (`staff_id`) REFERENCES `tx_staff` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tx_note` */

/*Table structure for table `tx_note_type` */

DROP TABLE IF EXISTS `tx_note_type`;

CREATE TABLE `tx_note_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `description` tinytext DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` int(11) DEFAULT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tx_note_type` */

/*Table structure for table `tx_office` */

DROP TABLE IF EXISTS `tx_office`;

CREATE TABLE `tx_office` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(5) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `phone_number` varchar(100) DEFAULT NULL,
  `fax_number` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `web` varchar(100) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `latitude` varchar(100) DEFAULT NULL,
  `longitude` varchar(100) DEFAULT NULL,
  `facebook` varchar(100) DEFAULT NULL,
  `google_plus` varchar(100) DEFAULT NULL,
  `instagram` varchar(100) DEFAULT NULL,
  `twitter` varchar(100) DEFAULT NULL,
  `description` tinytext DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` int(11) DEFAULT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `tx_office` */

insert  into `tx_office`(`id`,`token`,`title`,`phone_number`,`fax_number`,`email`,`web`,`address`,`latitude`,`longitude`,`facebook`,`google_plus`,`instagram`,`twitter`,`description`,`created_at`,`updated_at`,`created_by`,`updated_by`,`is_deleted`,`deleted_at`,`deleted_by`,`verlock`) values 
(1,'3456','Hubungan Internasional','081226993704','45635345','hubunganinternasional.id@gmail.com','hubunganinternasional.id','Bantul, Yogyakarta','','',NULL,NULL,NULL,NULL,'-',1430536627,1612708313,1,1,0,NULL,NULL,11);

/*Table structure for table `tx_page` */

DROP TABLE IF EXISTS `tx_page`;

CREATE TABLE `tx_page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_type_id` int(11) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `sequence` int(11) DEFAULT NULL,
  `description` tinytext DEFAULT NULL,
  `content` text DEFAULT NULL,
  `view_counter` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` int(11) DEFAULT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tx_page_page_type` (`page_type_id`),
  CONSTRAINT `FK_tx_page_page_type` FOREIGN KEY (`page_type_id`) REFERENCES `tx_page_type` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tx_page` */

/*Table structure for table `tx_page_type` */

DROP TABLE IF EXISTS `tx_page_type`;

CREATE TABLE `tx_page_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `sequence` int(11) DEFAULT NULL,
  `description` tinytext DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` int(11) DEFAULT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `tx_page_type` */

insert  into `tx_page_type`(`id`,`title`,`sequence`,`description`,`created_at`,`updated_at`,`created_by`,`updated_by`,`is_deleted`,`deleted_at`,`deleted_by`,`verlock`) values 
(1,'Umum',0,'-',1515915159,1515915159,1,1,NULL,NULL,NULL,0);

/*Table structure for table `tx_photo` */

DROP TABLE IF EXISTS `tx_photo`;

CREATE TABLE `tx_photo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `album_id` int(11) NOT NULL,
  `title` varchar(200) DEFAULT NULL,
  `file_name` varchar(200) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `url` varchar(500) DEFAULT NULL,
  `thumb` varchar(500) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `mime_type` varchar(20) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` int(11) DEFAULT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tx_photo_album` (`album_id`),
  CONSTRAINT `FK_tx_photo_album` FOREIGN KEY (`album_id`) REFERENCES `tx_album` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `tx_photo` */

/*Table structure for table `tx_profile` */

DROP TABLE IF EXISTS `tx_profile`;

CREATE TABLE `tx_profile` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `public_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gravatar_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gravatar_id` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `timezone` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  CONSTRAINT `fk_profile_user` FOREIGN KEY (`user_id`) REFERENCES `tx_user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `tx_profile` */

insert  into `tx_profile`(`user_id`,`name`,`public_email`,`gravatar_email`,`gravatar_id`,`location`,`website`,`timezone`,`bio`,`file_name`) values 
(1,'Nanta Es','ombakrinai@gmail.com','','d41d8cd98f00b204e9800998ecf8427e','Lhokseumawe','https://escyber.com/',NULL,'-',''),
(2,'Arif Darmawan','areefdn@gmail.com','','d41d8cd98f00b204e9800998ecf8427e','','',NULL,'',NULL);

/*Table structure for table `tx_quote` */

DROP TABLE IF EXISTS `tx_quote`;

CREATE TABLE `tx_quote` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `source` varchar(100) DEFAULT NULL,
  `file_name` varchar(200) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` int(11) DEFAULT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `tx_quote` */

/*Table structure for table `tx_session` */

DROP TABLE IF EXISTS `tx_session`;

CREATE TABLE `tx_session` (
  `id` char(32) NOT NULL,
  `expire` int(11) DEFAULT NULL,
  `data` longblob DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `tx_session` */

insert  into `tx_session`(`id`,`expire`,`data`) values 
('3t1tf58u3lunutsj7qgc3r5bi0',1548695669,'__flash|a:0:{}__returnUrl|s:12:\"/main/admin/\";'),
('7cpci685marr7lrd1n3s7tnfn5',1548647964,'__flash|a:0:{}__returnUrl|s:55:\"/main/uploads/content//uploads/web/img5985a8c7b0133.jpg\";'),
('irjmnn0m1t54h1ibarj6ndpfa4',1548771355,'__flash|a:0:{}__returnUrl|s:12:\"/main/admin/\";'),
('jf0bbc1i9pbgaeifpcjchp8uu0',1548697141,'__flash|a:0:{}__returnUrl|s:12:\"/main/admin/\";'),
('nf0uo3mprh87tkjo8akn57dl31',1548516734,'__flash|a:0:{}__returnUrl|s:12:\"/main/admin/\";'),
('o50mk6fuk8lvq65ihefl1baqu1',1548432564,'__flash|a:0:{}__returnUrl|s:12:\"/main/admin/\";');

/*Table structure for table `tx_site_link` */

DROP TABLE IF EXISTS `tx_site_link`;

CREATE TABLE `tx_site_link` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `url` varchar(200) DEFAULT NULL,
  `sequence` int(11) DEFAULT NULL,
  `description` tinytext DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` int(11) DEFAULT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tx_site_link` */

insert  into `tx_site_link`(`id`,`title`,`url`,`sequence`,`description`,`created_at`,`created_by`,`updated_at`,`updated_by`,`is_deleted`,`deleted_at`,`deleted_by`,`verlock`) values 
(1,'Kementerian Luar Negeri Republik Indonesia','https://kemlu.go.id/portal/id',1,'-',1594652692,1,1603167340,1,NULL,NULL,NULL,1),
(2,'Asosiasi Ilmu Hubungan Internasional Indonesia','http://aihii.or.id/',2,'-',1594652930,1,1603167383,1,NULL,NULL,NULL,1),
(3,'E-International Relations','https://www.e-ir.info/',3,'-',1594652967,1,1603388393,1,NULL,NULL,NULL,4),
(4,'-','',4,'',1594652992,1,1603167645,1,NULL,NULL,NULL,2),
(5,'-','',5,'-',1594653057,1,1603167664,1,NULL,NULL,NULL,1);

/*Table structure for table `tx_social_account` */

DROP TABLE IF EXISTS `tx_social_account`;

CREATE TABLE `tx_social_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `client_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_social_account_provider_client_id` (`provider`,`client_id`),
  UNIQUE KEY `idx_social_account_code` (`code`),
  KEY `fk_social_account_user` (`user_id`),
  CONSTRAINT `fk_social_account_user` FOREIGN KEY (`user_id`) REFERENCES `tx_user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `tx_social_account` */

/*Table structure for table `tx_staff` */

DROP TABLE IF EXISTS `tx_staff`;

CREATE TABLE `tx_staff` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` int(11) DEFAULT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tx_staff_gender` (`gender_status`),
  KEY `FK_tx_staff_role` (`employment_id`),
  CONSTRAINT `FK_tx_staff_employment` FOREIGN KEY (`employment_id`) REFERENCES `tx_employment` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `tx_staff` */

insert  into `tx_staff`(`id`,`employment_id`,`title`,`initial`,`identity_number`,`phone_number`,`gender_status`,`active_status`,`address`,`file_name`,`email`,`google_plus`,`instagram`,`facebook`,`twitter`,`description`,`created_at`,`updated_at`,`created_by`,`updated_by`,`is_deleted`,`deleted_at`,`deleted_by`,`verlock`) values 
(1,2,'Randhi Satria, S.IP., M.A','R.S','','',1,1,'','62cda453c51e9.png','ransatriastaff.uns.ac.id','','','','','Dosen Hubungan Internasional Fakultas Ilmu Sosial dan Ilmu Politik Universitas Sebelas Maret Surakarta',1597391034,1657644120,1,1,0,NULL,NULL,8);

/*Table structure for table `tx_tag` */

DROP TABLE IF EXISTS `tx_tag`;

CREATE TABLE `tx_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag_name` varchar(150) NOT NULL,
  `frequency` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `tx_tag` */

/*Table structure for table `tx_theme` */

DROP TABLE IF EXISTS `tx_theme`;

CREATE TABLE `tx_theme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `description` tinytext DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` int(11) DEFAULT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title_UNIQUE` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `tx_theme` */

insert  into `tx_theme`(`id`,`title`,`description`,`verlock`,`created_at`,`updated_at`,`created_by`,`updated_by`,`is_deleted`,`deleted_at`,`deleted_by`) values 
(1,'Global','Dipakai di semua halaman',0,1512226913,1512226962,1,1,NULL,NULL,NULL),
(3,'Blog19','Unify V 1.9.6\r\nStart Code 200',1,1512226913,1512226962,1,1,NULL,NULL,NULL);

/*Table structure for table `tx_theme_detail` */

DROP TABLE IF EXISTS `tx_theme_detail`;

CREATE TABLE `tx_theme_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `theme_id` int(11) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `token` varchar(5) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `file_name` varchar(200) DEFAULT NULL,
  `description` tinytext DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` int(11) DEFAULT NULL,
  `deleted_at` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `layout_code_UNIQUE` (`token`),
  KEY `FK_tx_content_theme` (`theme_id`),
  CONSTRAINT `FK_tx_theme_detail_theme` FOREIGN KEY (`theme_id`) REFERENCES `tx_theme` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

/*Data for the table `tx_theme_detail` */

insert  into `tx_theme_detail`(`id`,`theme_id`,`title`,`token`,`content`,`file_name`,`description`,`created_at`,`updated_at`,`created_by`,`updated_by`,`is_deleted`,`deleted_at`,`deleted_by`,`verlock`) values 
(1,1,'Logo 1','001','b3MYTwJeYCkb4IUmLrPkjcePntzALUBi.png',NULL,'Logo 1 - Bagian Atas Kiri',1515422835,1515422835,1,1,NULL,NULL,NULL,0),
(2,1,'Logo 2','002','q8Z7e_TqQrBwU8URdcZ4I7t62u3-EHCm.png',NULL,'Logo 2 - Bagian Bawah Kiri',1515422835,1515422835,1,1,NULL,NULL,NULL,0),
(3,1,'Profile','005','/uploads/web/img5985a8c7b0133.jpg',NULL,'0',1515422835,1515422835,1,1,NULL,NULL,NULL,0),
(4,1,'Deskripsi Bawah','006','',NULL,'-',1515422835,1515422835,1,1,NULL,NULL,NULL,0),
(5,1,'Footer Links','007','<ul>\r\n	<li><a href=\"http://www.escyber.com\">www.escyber.com</a></li>\r\n</ul>\r\n',NULL,NULL,1515422835,1515422835,1,1,NULL,NULL,NULL,0),
(6,1,'TERMS','008','CONTENT OF TERM',NULL,'DESCRIPTION OF TERM.',1512228835,1512229165,1,1,NULL,NULL,NULL,0),
(7,1,'ABOUT','009','CONTENT OF ABOUT',NULL,'DESCRIPTION OF ABOUT.',1512228835,1512229165,1,1,NULL,NULL,NULL,0),
(8,1,'SEO Description','011',NULL,NULL,'SEO Description',1515422835,1515422835,1,1,NULL,NULL,NULL,0),
(9,1,'SEO Keyword','012',NULL,NULL,'SEO Keyword',1515422835,1515422835,1,1,NULL,NULL,NULL,0),
(10,1,'Logo Report 1','016','b3MYTwJeYCkb4IUmLrPkjcePntzALUBi.png',NULL,'Logo 1 - Bagian Atas Kiri',1515422835,1515422835,1,1,NULL,NULL,NULL,0),
(11,1,'Logo Report 2','017','q8Z7e_TqQrBwU8URdcZ4I7t62u3-EHCm.png',NULL,'NA',1515422835,1515422835,1,1,NULL,NULL,NULL,0),
(12,1,'Deskripsi Report','018','q8Z7e_TqQrBwU8URdcZ4I7t62u3-EHCm.png',NULL,'DESKRIPSI',1515422835,1515422835,1,1,NULL,NULL,NULL,0),
(13,1,'Facebook','021','<i class=\"fa fa-facebook\"></i>',NULL,NULL,1515422835,1515422835,1,1,NULL,NULL,NULL,0),
(14,1,'Skype','022','<i class=\"fa fa-skype\"></i>',NULL,NULL,1515422835,1515422835,1,1,NULL,NULL,NULL,0),
(15,1,'Google Plus','023','<i class=\"fa fa-google-plus\"></i>',NULL,NULL,1515422835,1515422835,1,1,NULL,NULL,NULL,0),
(16,1,'Linkedin','024','<i class=\"fa fa-linkedin\"></i>',NULL,NULL,1515422835,1515422835,1,1,NULL,NULL,NULL,0),
(17,1,'Pinterest','025','<i class=\"fa fa-pinterest\"></i>',NULL,NULL,1515422835,1515422835,1,1,NULL,NULL,NULL,0),
(18,1,'Twitter','026','<i class=\"fa fa-twitter\"></i>',NULL,NULL,1515422835,1515422835,1,1,NULL,NULL,NULL,0),
(19,1,'Dribbble','027','<i class=\"fa fa-dribbble\"></i>',NULL,NULL,1515422835,1515422835,1,1,NULL,NULL,NULL,0),
(20,3,'Tentang JHI','200','VD6pJHgk7ikBhHW6gmW59mfrWLQhjpFx.png',NULL,'Donec id elit y DESCRIPTION.',1512228835,1512229165,1,1,NULL,NULL,NULL,0);

/*Table structure for table `tx_token` */

DROP TABLE IF EXISTS `tx_token`;

CREATE TABLE `tx_token` (
  `user_id` int(11) DEFAULT NULL,
  `code` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `created_at` int(11) NOT NULL,
  UNIQUE KEY `idx_token_user_id_code_type` (`user_id`,`code`,`type`),
  CONSTRAINT `fk_token_user` FOREIGN KEY (`user_id`) REFERENCES `tx_user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `tx_token` */

insert  into `tx_token`(`user_id`,`code`,`type`,`created_at`) values 
(1,'XxnfcSJhSl93g2OskP24qV-XBKvNS9bj',0,1507741399);

/*Table structure for table `tx_user` */

DROP TABLE IF EXISTS `tx_user`;

CREATE TABLE `tx_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `auth_tf_enabled` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_user_username` (`username`),
  UNIQUE KEY `idx_user_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `tx_user` */

insert  into `tx_user`(`id`,`username`,`email`,`password_hash`,`auth_key`,`unconfirmed_email`,`registration_ip`,`flags`,`confirmed_at`,`blocked_at`,`updated_at`,`created_at`,`last_login_at`,`auth_tf_key`,`auth_tf_enabled`) values 
(1,'admin','ombakrinai@gmail.com','$2y$10$oD129/e5PjrTkIV1yiR3AuOc2/XAOXLWgKPfb8svo8BdBA4PUsw3G','e0ee8dwDplLVaGlKGZteMSqPp1ikJFQm',NULL,'::1',0,1598256482,NULL,1507741399,1507741399,1657867542,NULL,0),
(2,'editor','areefdn@gmail.com','$2y$12$FJ0ssgq6I0ryhyz8Lgsfi.0W0oMyNy9jTKfWrrtjjuAZz.KCIqqGS','8fSErSWVUb6VZ19X7WEZPg9KlQZp93w5',NULL,'103.23.224.166',0,1598256482,NULL,1598256588,1598256482,1598256776,NULL,0);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
