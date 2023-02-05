/*
SQLyog Ultimate v11.33 (64 bit)
MySQL - 10.1.21-MariaDB : Database - yii2tvlangsa
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`yii2tvlangsa` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `yii2tvlangsa`;

/*Table structure for table `tx_account` */

DROP TABLE IF EXISTS `tx_account`;

CREATE TABLE `tx_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_type_id` int(11) DEFAULT NULL,
  `token` varchar(10) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `description` tinytext,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `token_UNIQUE` (`token`),
  KEY `FK_tx_account_type` (`account_type_id`),
  CONSTRAINT `FK_tx_account_type` FOREIGN KEY (`account_type_id`) REFERENCES `tx_account_type` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

/*Data for the table `tx_account` */

insert  into `tx_account`(`id`,`account_type_id`,`token`,`title`,`description`,`create_time`,`update_time`,`create_by`,`update_by`,`verlock`) values (6,14,'2202','Pembelian/Pembayaran Alat-Alat Tulis Kantor','NULL',1430722688,1486439888,1,1,0),(7,16,'53200','Biaya Iklan/Advertensi','-',1430722775,1430722775,1,1,0),(8,14,'2212','Biaya Operasional Kantor','NULL',1430722814,1486440023,1,1,0),(9,17,'54800','Biaya Telepon','-',1430722849,1430722849,1,1,0),(10,17,'54900','Biaya Listrik','-',1430722881,1430722881,1,1,0),(11,17,'55200','Biaya Gaji Karyawan','NULL',1430722921,1430722921,1,1,0),(12,14,'2340','Pembelian/Pembayaran alat Broadcast ','NULL',1485766293,1485766293,1,1,0),(13,17,'2120','Pembelian/Pembayaran Alat Instalasi ke Rumah (IKR)','NULL',1486440156,1486440156,1,1,0),(14,17,'2140','Pembelian/Pembayaran Alat/Equipment Jaringan','NULL',1486440233,1486440233,1,1,0),(15,16,'3300','Peneluaran Pembayaran Pinjaman','NULL',1486440428,1486440428,1,1,0),(16,14,'3750','Pengeluaran / Pinjaman  Karyawan','NULL',1490413942,1490413942,1,1,0),(17,17,'3751','Pengeluaran Pribadi Direktur','NULL',1490413981,1490413981,1,1,0),(18,17,'2345','Pembelian/ Pembayaran Alat Equipment Head End/ Central Studio','NULL',1490414319,1490414319,1,1,0),(19,17,'2112','Pembelian/Pembayaran Barang Tool Teknisi','NULL',1490414407,1490414407,1,1,0),(20,17,'2230','Pembelian/Pembayaran Barang Kepentingan/Fasilitas Kantor','NULL',1490414487,1490414487,1,1,0),(21,14,'3210','Pengeluaran/Pembayaran Upah Tenaga Kerja','NULL',1490414894,1490414894,1,1,0),(22,17,'3550','Pengeluaran/Pembayaran Biaya Tak Terduga/ Entertainment','NULL',1490414979,1490414979,1,1,0),(23,17,'3340','Pengeluaran/Pembayaran Upah Kebutuhan Produksi','NULL',1490415090,1490415090,1,1,0),(24,17,'2220','Pembelian/Pembayaran Biaya Promosi Dan Material Promosi','NULL',1490415155,1490415155,1,1,0),(25,14,'3900','Pembayaran Pajak/ Iuran Lainnya Yang bersifat Tetap Sesuai Penghasilan','NULL',1490415217,1490415217,1,1,0),(26,20,'1751','Penambahan Saldo Bank untuk Kepentingan/Pengeluaran Pribadi Direktur','NULL',1495419243,1495419243,3,3,0),(27,20,'1750','Penambahan Saldo Untuk Pembayaran/Pengeluaran Operasional Kantor','NULL',1495419296,1495419389,3,3,0),(28,14,'1505','PENERIMAAN BIAYA IKLAN (BROADCAST)','NULL',1501741252,1501741252,1,1,0);

/*Table structure for table `tx_account_payable` */

DROP TABLE IF EXISTS `tx_account_payable`;

CREATE TABLE `tx_account_payable` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) DEFAULT NULL,
  `date_issued` int(11) DEFAULT NULL,
  `title` varchar(10) DEFAULT NULL,
  `month_period` varchar(6) DEFAULT NULL,
  `description` text,
  `claim` decimal(18,2) DEFAULT NULL,
  `surcharge` decimal(18,2) DEFAULT NULL,
  `penalty` decimal(18,2) DEFAULT NULL,
  `total` decimal(18,2) DEFAULT NULL,
  `discount` decimal(18,2) DEFAULT NULL,
  `payment` decimal(18,2) DEFAULT NULL,
  `balance` decimal(18,2) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tx_account_payable_staff` (`staff_id`),
  CONSTRAINT `FK_tx_account_payable_staff` FOREIGN KEY (`staff_id`) REFERENCES `tx_staff` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tx_account_payable` */

/*Table structure for table `tx_account_payable_detail` */

DROP TABLE IF EXISTS `tx_account_payable_detail`;

CREATE TABLE `tx_account_payable_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_payable_id` int(11) DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  `invoice` varchar(20) DEFAULT NULL,
  `amount` decimal(18,2) DEFAULT NULL,
  `description` tinytext,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tx_account_payable_detail_payable` (`account_payable_id`),
  KEY `FK_tx_account_payable_detail_account` (`account_id`),
  CONSTRAINT `FK_tx_account_payable_detail_account` FOREIGN KEY (`account_id`) REFERENCES `tx_account` (`id`),
  CONSTRAINT `FK_tx_account_payable_detail_payable` FOREIGN KEY (`account_payable_id`) REFERENCES `tx_account_payable` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tx_account_payable_detail` */

/*Table structure for table `tx_account_receivable` */

DROP TABLE IF EXISTS `tx_account_receivable`;

CREATE TABLE `tx_account_receivable` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) DEFAULT NULL,
  `date_issued` int(11) DEFAULT NULL,
  `title` varchar(10) DEFAULT NULL,
  `month_period` varchar(6) DEFAULT NULL,
  `description` text,
  `claim` decimal(18,2) DEFAULT NULL,
  `surcharge` decimal(18,2) DEFAULT NULL,
  `penalty` decimal(18,2) DEFAULT NULL,
  `total` decimal(18,2) DEFAULT NULL,
  `discount` decimal(18,2) DEFAULT NULL,
  `payment` decimal(18,2) DEFAULT NULL,
  `balance` decimal(18,2) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tx_account_receivable_staff` (`staff_id`),
  CONSTRAINT `FK_tx_account_receivable_staff` FOREIGN KEY (`staff_id`) REFERENCES `tx_staff` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tx_account_receivable` */

/*Table structure for table `tx_account_receivable_detail` */

DROP TABLE IF EXISTS `tx_account_receivable_detail`;

CREATE TABLE `tx_account_receivable_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_receivable_id` int(11) DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  `invoice` varchar(20) DEFAULT NULL,
  `amount` decimal(18,2) DEFAULT NULL,
  `description` tinytext,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tx_account_receivable_detail_parent` (`account_receivable_id`),
  KEY `FK_tx_account_receivable_detail_account` (`account_id`),
  CONSTRAINT `FK_tx_account_receivable_detail_account` FOREIGN KEY (`account_id`) REFERENCES `tx_account` (`id`),
  CONSTRAINT `FK_tx_account_receivable_detail_parent` FOREIGN KEY (`account_receivable_id`) REFERENCES `tx_account_receivable` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tx_account_receivable_detail` */

/*Table structure for table `tx_account_type` */

DROP TABLE IF EXISTS `tx_account_type`;

CREATE TABLE `tx_account_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(10) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `description` tinytext,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `token_UNIQUE` (`token`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

/*Data for the table `tx_account_type` */

insert  into `tx_account_type`(`id`,`token`,`title`,`description`,`create_time`,`update_time`,`create_by`,`update_by`,`verlock`) values (14,'E-002','Biaya Administrasi dan Umum','NULL',1430714517,1430714771,1,1,0),(15,'E-003','Biaya Penjualan','NULL',1430714517,1430714776,1,1,0),(16,'E-004','Biaya Lain-lain','NULL',1430714517,1430714782,1,1,0),(17,'E-005','Biaya Operasional','NULL',1430714517,1430714787,1,1,0),(18,'1751','Penambahan Saldo Bank untuk Kepentingan/ Pengeluaran Pribadi Direktur','NULL',1491896984,1491896984,1,1,0),(19,'1750','Penambahan Saldo Untuk Pembayaran/Pengeluaran Operasional kantor','NULL',1491897065,1491897065,1,1,0),(20,'C-001','PENAMBAHAN SALDO DARI REKENING BNI KANTOR','NULL',1495419158,1495419158,3,3,0);

/*Table structure for table `tx_album` */

DROP TABLE IF EXISTS `tx_album`;

CREATE TABLE `tx_album` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `album_type` int(11) DEFAULT NULL,
  `cover` varchar(500) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `description` text,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `album_name_UNIQUE` (`title`),
  KEY `FK_tx_album_type` (`album_type`),
  CONSTRAINT `FK_tx_album_type` FOREIGN KEY (`album_type`) REFERENCES `tx_lookup` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `tx_album` */

/*Table structure for table `tx_archive` */

DROP TABLE IF EXISTS `tx_archive`;

CREATE TABLE `tx_archive` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) DEFAULT NULL,
  `file_name` varchar(200) DEFAULT NULL,
  `archive_url` varchar(500) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `mime_type` varchar(100) DEFAULT NULL,
  `description` text,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `tx_archive` */

/*Table structure for table `tx_area` */

DROP TABLE IF EXISTS `tx_area`;

CREATE TABLE `tx_area` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `description` tinytext,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tx_area` */

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

insert  into `tx_auth_assignment`(`item_name`,`user_id`,`created_at`) values ('admin','1',1525706685),('reguler','2',1525706693),('reguler','3',1525706717),('reguler','4',1525706724),('reguler','5',1525706731),('reguler','6',1525706738),('reguler','7',1525706745),('reguler','8',1525706751);

/*Table structure for table `tx_auth_item` */

DROP TABLE IF EXISTS `tx_auth_item`;

CREATE TABLE `tx_auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `tx_auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `tx_auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `tx_auth_item` */

insert  into `tx_auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values ('admin',1,'Admin',NULL,NULL,1525111156,1526405928),('create-account',2,'Create Account',NULL,NULL,1525111726,1525111726),('create-account-payable',2,'Create Account Payable',NULL,NULL,1525111809,1525111809),('create-account-receivable',2,'Create Account Receivable',NULL,NULL,1525112019,1525112019),('create-account-type',2,'Create Account Type',NULL,NULL,1525112105,1525112105),('create-album',2,'Create Album',NULL,NULL,1525112170,1525112170),('create-archive',2,'Create Archive',NULL,NULL,1525112240,1525112240),('create-area',2,'Create Area',NULL,NULL,1525112794,1525112794),('create-author',2,'Create Author',NULL,NULL,1525112864,1525112864),('create-billing',2,'Create Billing',NULL,NULL,1525112920,1525112920),('create-blog',2,'Create Blog',NULL,NULL,1525113195,1525113195),('create-category',2,'Create Category',NULL,NULL,1525113263,1525113263),('create-collector',2,'Create Collector',NULL,NULL,1525113391,1525113391),('create-comment',2,'Create Comment',NULL,NULL,1525113480,1525113480),('create-content',2,'Create Content',NULL,NULL,1525113611,1525113611),('create-counter',2,'Create Counter',NULL,NULL,1525113702,1525113702),('create-customer',2,'Create Customer',NULL,NULL,1525114083,1525114083),('create-employment',2,'Create Employment',NULL,NULL,1525114143,1525114143),('create-enrolment',2,'Create Enrolment',NULL,NULL,1525114249,1525114249),('create-event',2,'Create Event',NULL,NULL,1525114307,1525114307),('create-gmap',2,'Create Gmap',NULL,NULL,1525114359,1525114359),('create-lookup',2,'Create Lookup',NULL,NULL,1525114426,1525114426),('create-master',2,'Create Master',NULL,NULL,1525111352,1525706951),('create-network',2,'Create Network',NULL,NULL,1525114483,1527702346),('create-note',2,'Create Note',NULL,NULL,1525114571,1525114571),('create-note-type',2,'Create Note Type',NULL,NULL,1525114618,1525114618),('create-office',2,'Create Office',NULL,NULL,1525114785,1525114785),('create-outlet',2,'Create Outlet',NULL,NULL,1525114923,1525114923),('create-page',2,'Create Page',NULL,NULL,1525115256,1525115256),('create-page-type',2,'Create Page Type',NULL,NULL,1525115369,1525115369),('create-photo',2,'Create Photo',NULL,NULL,1525115444,1525115444),('create-profile',2,'Create Profile',NULL,NULL,1525115646,1525115646),('create-quote',2,'Create Quote',NULL,NULL,1525115830,1525115830),('create-receivable',2,'Create Receivable',NULL,NULL,1525115986,1525115986),('create-service',2,'Create Service',NULL,NULL,1525116103,1525116103),('create-service-type',2,'Create Service Type',NULL,NULL,1525116167,1525116167),('create-staff',2,'Create Staff',NULL,NULL,1525116345,1525116345),('create-theme',2,'Create Theme',NULL,NULL,1525116399,1525116399),('create-transaction',2,'Create Transaction',NULL,NULL,1525111443,1525708656),('create-validity',2,'Create Validity',NULL,NULL,1525116447,1525116447),('create-validity-detail',2,'Create Validity Detail',NULL,NULL,1525116527,1525116527),('create-village',2,'Create Village',NULL,NULL,1525116591,1525116591),('delete-account',2,'Delete Account',NULL,NULL,1525153707,1525153707),('delete-account-payable',2,'Delete Account Payable',NULL,NULL,1525153722,1525153722),('delete-account-receivable',2,'Delete Account Receivable',NULL,NULL,1525153736,1525153736),('delete-account-type',2,'Delete Account Type',NULL,NULL,1525153749,1525153749),('delete-album',2,'Delete Album',NULL,NULL,1525153758,1525153758),('delete-archive',2,'Delete Archive',NULL,NULL,1525153771,1525153771),('delete-area',2,'Delete Area',NULL,NULL,1525153797,1525153797),('delete-author',2,'Delete Author',NULL,NULL,1525153807,1525153807),('delete-billing',2,'Delete Billing',NULL,NULL,1525153822,1525153822),('delete-blog',2,'Delete Blog',NULL,NULL,1525153830,1525153830),('delete-category',2,'Delete Category',NULL,NULL,1525153839,1525153839),('delete-collector',2,'Delete Collector',NULL,NULL,1525153850,1525153850),('delete-comment',2,'Delete Comment',NULL,NULL,1525153889,1525153889),('delete-content',2,'Delete Content',NULL,NULL,1525153904,1525153904),('delete-counter',2,'Delete Counter',NULL,NULL,1525153914,1525153914),('delete-customer',2,'Delete Customer',NULL,NULL,1525153925,1525153925),('delete-employment',2,'Delete Employment',NULL,NULL,1525153950,1525153950),('delete-enrolment',2,'Delete Enrolment',NULL,NULL,1525153962,1525153962),('delete-event',2,'Delete Event',NULL,NULL,1525153973,1525153973),('delete-gmap',2,'Delete Gmap',NULL,NULL,1525153983,1525153983),('delete-lookup',2,'Delete Lookup',NULL,NULL,1525153993,1525153993),('delete-master',2,'Delete Master',NULL,NULL,1526405744,1526405744),('delete-network',2,'Delete Network',NULL,NULL,1525154001,1527702358),('delete-note',2,'Delete Note',NULL,NULL,1525154022,1525154022),('delete-note-type',2,'Delete Note Type',NULL,NULL,1525154034,1525154034),('delete-office',2,'Delete Office',NULL,NULL,1525154049,1525154049),('delete-outlet',2,'Delete Outlet',NULL,NULL,1525154060,1525154060),('delete-page',2,'Delete Page',NULL,NULL,1525154071,1525154071),('delete-page-type',2,'Delete Page Type',NULL,NULL,1525154082,1525154082),('delete-photo',2,'Delete Photo',NULL,NULL,1525154095,1525154095),('delete-profile',2,'Delete Profile',NULL,NULL,1525154138,1525154138),('delete-quote',2,'Delete Quote',NULL,NULL,1525154160,1525154160),('delete-receivable',2,'Delete Receivable',NULL,NULL,1525154171,1525154171),('delete-service',2,'Delete Service',NULL,NULL,1525154182,1525154182),('delete-service-type',2,'Delete Service Type',NULL,NULL,1525154199,1525154199),('delete-staff',2,'Delete Staff',NULL,NULL,1525154207,1525154207),('delete-theme',2,'Delete Theme',NULL,NULL,1525154216,1525154216),('delete-transaction',2,'Delete Transaction',NULL,NULL,1526405894,1526405894),('delete-validity',2,'Delete Validity',NULL,NULL,1525154225,1525154225),('delete-validity-detail',2,'Delete Validity Detail',NULL,NULL,1525154246,1525154246),('delete-village',2,'Delete Village',NULL,NULL,1525154254,1525154254),('guest',1,'Guest',NULL,NULL,1525111243,1525111243),('index-account',2,'Index Account',NULL,NULL,1525111759,1525111759),('index-account-payable',2,'Index Account Payable',NULL,NULL,1525111853,1525111853),('index-account-receivable',2,'Index Account Receivable',NULL,NULL,1525112066,1525112066),('index-account-type',2,'Index Account Type',NULL,NULL,1525112130,1525112130),('index-album',2,'Index Album',NULL,NULL,1525112192,1525112192),('index-archive',2,'Index Archive',NULL,NULL,1525112266,1525112266),('index-area',2,'Index Area',NULL,NULL,1525112811,1525112811),('index-author',2,'Index Author',NULL,NULL,1525112885,1525112885),('index-billing',2,'Index Billing',NULL,NULL,1525112937,1525112937),('index-blog',2,'Index Blog',NULL,NULL,1525113213,1525113213),('index-category',2,'Index Category',NULL,NULL,1525113320,1525113320),('index-collector',2,'Index Collector',NULL,NULL,1525113414,1525113414),('index-comment',2,'Index Comment',NULL,NULL,1525113507,1525113507),('index-content',2,'Index Content',NULL,NULL,1525113655,1525113655),('index-counter',2,'Index Counter',NULL,NULL,1525113722,1525113722),('index-customer',2,'Index Customer',NULL,NULL,1525114106,1525114106),('index-employment',2,'Index Employment',NULL,NULL,1525114172,1525114172),('index-enrolment',2,'Index Enrolment',NULL,NULL,1525114271,1525114271),('index-event',2,'Index Event',NULL,NULL,1525114327,1525114327),('index-gmap',2,'Index Gmap',NULL,NULL,1525114378,1525114378),('index-lookup',2,'Index Lookup',NULL,NULL,1525114457,1525114457),('index-master',2,'Index Master',NULL,NULL,1525111392,1525707732),('index-network',2,'Index Network',NULL,NULL,1525114501,1527702362),('index-note',2,'Index Note',NULL,NULL,1525114587,1525114587),('index-note-type',2,'Index Note Type',NULL,NULL,1525114639,1525114639),('index-office',2,'Index Office',NULL,NULL,1525114804,1525114804),('index-outlet',2,'Index Outlet',NULL,NULL,1525114942,1525114942),('index-page',2,'Index Page',NULL,NULL,1525115285,1525115285),('index-page-type',2,'Index Page Type',NULL,NULL,1525115403,1525115403),('index-photo',2,'Index Photo',NULL,NULL,1525115463,1525115463),('index-profile',2,'Index Profile',NULL,NULL,1525115676,1525115676),('index-quote',2,'Index Quote',NULL,NULL,1525115861,1525115861),('index-receivable',2,'Index Receivable',NULL,NULL,1525116021,1525116021),('index-service',2,'Index Service',NULL,NULL,1525116130,1525116130),('index-service-type',2,'Index Service Type',NULL,NULL,1525116240,1525116240),('index-staff',2,'Index Staff',NULL,NULL,1525116370,1525116370),('index-theme',2,'Index Theme',NULL,NULL,1525116417,1525116417),('index-transaction',2,'Index Transaction',NULL,NULL,1525111654,1525708731),('index-validity',2,'Index Validity',NULL,NULL,1525116495,1525116495),('index-validity-detail',2,'Index Validity Detail',NULL,NULL,1525116559,1525116559),('index-village',2,'Index Village',NULL,NULL,1525116634,1525116634),('reguler',1,'Reguler',NULL,NULL,1525111308,1525709299),('update-account',2,'Update Account',NULL,NULL,1525111743,1525111743),('update-account-payable',2,'Update Account Payable',NULL,NULL,1525111832,1525111832),('update-account-receivable',2,'Update Account Receivable',NULL,NULL,1525112047,1525112047),('update-account-type',2,'Update Account Type',NULL,NULL,1525112119,1525112119),('update-album',2,'Update Album',NULL,NULL,1525112182,1525112182),('update-archive',2,'Update Archive',NULL,NULL,1525112255,1525112255),('update-area',2,'Update Area',NULL,NULL,1525112802,1525112802),('update-author',2,'Update Author',NULL,NULL,1525112875,1525112875),('update-billing',2,'Update Billing',NULL,NULL,1525112928,1525112928),('update-blog',2,'Update Blog',NULL,NULL,1525113204,1525113204),('update-category',2,'Update Category',NULL,NULL,1525113305,1525113305),('update-collector',2,'Update Collector',NULL,NULL,1525113401,1525113401),('update-comment',2,'Update Comment',NULL,NULL,1525113489,1525113489),('update-content',2,'Update Content',NULL,NULL,1525113629,1525113629),('update-counter',2,'Update Counter',NULL,NULL,1525113711,1525113711),('update-customer',2,'Update Customer',NULL,NULL,1525114092,1525114092),('update-employment',2,'Update Employment',NULL,NULL,1525114162,1525114162),('update-enrolment',2,'Update Enrolment',NULL,NULL,1525114261,1525114261),('update-event',2,'Update Event',NULL,NULL,1525114318,1525114318),('update-gmap',2,'Update Gmap',NULL,NULL,1525114367,1525114367),('update-lookup',2,'Update Lookup',NULL,NULL,1525114443,1525114443),('update-master',2,'Update Master',NULL,NULL,1525111371,1525708461),('update-network',2,'Update Network',NULL,NULL,1525114491,1527702367),('update-note',2,'Update Note',NULL,NULL,1525114578,1525114578),('update-note-type',2,'Update Note Type',NULL,NULL,1525114627,1525114627),('update-office',2,'Update Office',NULL,NULL,1525114795,1525114795),('update-outlet',2,'Update Outlet',NULL,NULL,1525114932,1525114932),('update-page',2,'Update Page',NULL,NULL,1525115272,1525115272),('update-page-type',2,'Update Page Type',NULL,NULL,1525115381,1525115381),('update-photo',2,'Update Photo',NULL,NULL,1525115455,1525115455),('update-profile',2,'Update Profile',NULL,NULL,1525115663,1525115663),('update-quote',2,'Update Quote',NULL,NULL,1525115841,1525115841),('update-receivable',2,'Update Receivable',NULL,NULL,1525115999,1525115999),('update-service',2,'Update Service',NULL,NULL,1525116112,1525116112),('update-service-type',2,'Update Service Type',NULL,NULL,1525116202,1525116202),('update-staff',2,'Update Staff',NULL,NULL,1525116357,1525116357),('update-theme',2,'Update Theme',NULL,NULL,1525116407,1525116407),('update-transaction',2,'Update Transaction',NULL,NULL,1525111466,1525708864),('update-validity',2,'Update Validity',NULL,NULL,1525116455,1525116455),('update-validity-detail',2,'Update Validity Detail',NULL,NULL,1525116540,1525116540),('update-village',2,'Update Village',NULL,NULL,1525116601,1525116601),('view-account',2,'View Account',NULL,NULL,1525111777,1525111777),('view-account-payable',2,'View Account Payable',NULL,NULL,1525111990,1525111990),('view-account-receivable',2,'View Account Receivable',NULL,NULL,1525112081,1525112081),('view-account-type',2,'View Account Type',NULL,NULL,1525112143,1525112143),('view-album',2,'View Album',NULL,NULL,1525112203,1525112203),('view-archive',2,'View Archive',NULL,NULL,1525112279,1525112279),('view-area',2,'View Area',NULL,NULL,1525112821,1525112821),('view-author',2,'View Author',NULL,NULL,1525112895,1525112895),('view-billing',2,'View Billing',NULL,NULL,1525112950,1525112950),('view-blog',2,'View Blog',NULL,NULL,1525113226,1525113226),('view-category',2,'View Category',NULL,NULL,1525113361,1525113361),('view-collector',2,'View Collector',NULL,NULL,1525113426,1525113426),('view-comment',2,'View Comment',NULL,NULL,1525113585,1525113585),('view-content',2,'View Content',NULL,NULL,1525113664,1525113664),('view-counter',2,'View Counter',NULL,NULL,1525113733,1525113733),('view-customer',2,'View Customer',NULL,NULL,1525114116,1525114116),('view-employment',2,'View Employment',NULL,NULL,1525114182,1525114182),('view-enrolment',2,'View Enrolment',NULL,NULL,1525114282,1525114282),('view-event',2,'View Event',NULL,NULL,1525114336,1525114336),('view-gmap',2,'View Gmap',NULL,NULL,1525114385,1525114385),('view-lookup',2,'View Lookup',NULL,NULL,1525114466,1525114466),('view-master',2,'View Master',NULL,NULL,1525111409,1525708563),('view-network',2,'View Network',NULL,NULL,1525114537,1527702371),('view-note',2,'View Note',NULL,NULL,1525114595,1525114595),('view-note-type',2,'View Note Type',NULL,NULL,1525114652,1525114652),('view-office',2,'View Office',NULL,NULL,1525114815,1525114815),('view-outlet',2,'View Outlet',NULL,NULL,1525114953,1525114953),('view-page',2,'View Page',NULL,NULL,1525115305,1525115305),('view-page-type',2,'View Page Type',NULL,NULL,1525115415,1525115415),('view-photo',2,'View Photo',NULL,NULL,1525115472,1525115472),('view-profile',2,'View Profile',NULL,NULL,1525115691,1525115691),('view-quote',2,'View Quote',NULL,NULL,1525115868,1525115868),('view-receivable',2,'View Receivable',NULL,NULL,1525116068,1525116068),('view-service',2,'View Service',NULL,NULL,1525116141,1525116141),('view-service-type',2,'View Service Type',NULL,NULL,1525116255,1525116255),('view-staff',2,'View Staff',NULL,NULL,1525116379,1525116379),('view-theme',2,'View Theme',NULL,NULL,1525116425,1525116425),('view-transaction',2,'View Transaction',NULL,NULL,1525111702,1525708947),('view-validity',2,'View Validity',NULL,NULL,1525116504,1525116504),('view-validity-detail',2,'View Validity Detail',NULL,NULL,1525116572,1525116572),('view-village',2,'View Village',NULL,NULL,1525116641,1525116641);

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

insert  into `tx_auth_item_child`(`parent`,`child`) values ('admin','create-account'),('admin','create-account-payable'),('admin','create-account-receivable'),('admin','create-account-type'),('admin','create-album'),('admin','create-archive'),('admin','create-area'),('admin','create-author'),('admin','create-billing'),('admin','create-blog'),('admin','create-category'),('admin','create-collector'),('admin','create-comment'),('admin','create-content'),('admin','create-counter'),('admin','create-customer'),('admin','create-employment'),('admin','create-enrolment'),('admin','create-event'),('admin','create-gmap'),('admin','create-lookup'),('admin','create-master'),('admin','create-network'),('admin','create-note'),('admin','create-note-type'),('admin','create-office'),('admin','create-outlet'),('admin','create-page'),('admin','create-page-type'),('admin','create-photo'),('admin','create-profile'),('admin','create-quote'),('admin','create-receivable'),('admin','create-service'),('admin','create-service-type'),('admin','create-staff'),('admin','create-theme'),('admin','create-transaction'),('admin','create-validity'),('admin','create-validity-detail'),('admin','create-village'),('admin','delete-account'),('admin','delete-account-payable'),('admin','delete-account-receivable'),('admin','delete-account-type'),('admin','delete-album'),('admin','delete-archive'),('admin','delete-area'),('admin','delete-author'),('admin','delete-billing'),('admin','delete-blog'),('admin','delete-category'),('admin','delete-collector'),('admin','delete-comment'),('admin','delete-content'),('admin','delete-counter'),('admin','delete-customer'),('admin','delete-employment'),('admin','delete-enrolment'),('admin','delete-event'),('admin','delete-gmap'),('admin','delete-lookup'),('admin','delete-master'),('admin','delete-network'),('admin','delete-note'),('admin','delete-note-type'),('admin','delete-office'),('admin','delete-outlet'),('admin','delete-page'),('admin','delete-page-type'),('admin','delete-photo'),('admin','delete-profile'),('admin','delete-quote'),('admin','delete-receivable'),('admin','delete-service'),('admin','delete-service-type'),('admin','delete-staff'),('admin','delete-theme'),('admin','delete-transaction'),('admin','delete-validity'),('admin','delete-validity-detail'),('admin','delete-village'),('admin','guest'),('admin','index-account'),('admin','index-account-payable'),('admin','index-account-receivable'),('admin','index-account-type'),('admin','index-album'),('admin','index-archive'),('admin','index-area'),('admin','index-author'),('admin','index-billing'),('admin','index-blog'),('admin','index-category'),('admin','index-collector'),('admin','index-comment'),('admin','index-content'),('admin','index-counter'),('admin','index-customer'),('admin','index-employment'),('admin','index-enrolment'),('admin','index-event'),('admin','index-gmap'),('admin','index-lookup'),('admin','index-master'),('admin','index-network'),('admin','index-note'),('admin','index-note-type'),('admin','index-office'),('admin','index-outlet'),('admin','index-page'),('admin','index-page-type'),('admin','index-photo'),('admin','index-profile'),('admin','index-quote'),('admin','index-receivable'),('admin','index-service'),('admin','index-service-type'),('admin','index-staff'),('admin','index-theme'),('admin','index-transaction'),('admin','index-validity'),('admin','index-validity-detail'),('admin','index-village'),('admin','reguler'),('admin','update-account'),('admin','update-account-payable'),('admin','update-account-receivable'),('admin','update-account-type'),('admin','update-album'),('admin','update-archive'),('admin','update-area'),('admin','update-author'),('admin','update-billing'),('admin','update-blog'),('admin','update-category'),('admin','update-collector'),('admin','update-comment'),('admin','update-content'),('admin','update-counter'),('admin','update-customer'),('admin','update-employment'),('admin','update-enrolment'),('admin','update-event'),('admin','update-gmap'),('admin','update-lookup'),('admin','update-master'),('admin','update-network'),('admin','update-note'),('admin','update-note-type'),('admin','update-office'),('admin','update-outlet'),('admin','update-page'),('admin','update-page-type'),('admin','update-photo'),('admin','update-profile'),('admin','update-quote'),('admin','update-receivable'),('admin','update-service'),('admin','update-service-type'),('admin','update-staff'),('admin','update-theme'),('admin','update-transaction'),('admin','update-validity'),('admin','update-validity-detail'),('admin','update-village'),('admin','view-account'),('admin','view-account-payable'),('admin','view-account-receivable'),('admin','view-account-type'),('admin','view-album'),('admin','view-archive'),('admin','view-area'),('admin','view-author'),('admin','view-billing'),('admin','view-blog'),('admin','view-category'),('admin','view-collector'),('admin','view-comment'),('admin','view-content'),('admin','view-counter'),('admin','view-customer'),('admin','view-employment'),('admin','view-enrolment'),('admin','view-event'),('admin','view-gmap'),('admin','view-lookup'),('admin','view-master'),('admin','view-network'),('admin','view-note'),('admin','view-note-type'),('admin','view-office'),('admin','view-outlet'),('admin','view-page'),('admin','view-page-type'),('admin','view-photo'),('admin','view-profile'),('admin','view-quote'),('admin','view-receivable'),('admin','view-service'),('admin','view-service-type'),('admin','view-staff'),('admin','view-theme'),('admin','view-transaction'),('admin','view-validity'),('admin','view-validity-detail'),('admin','view-village'),('create-master','create-account'),('create-master','create-account-type'),('create-master','create-album'),('create-master','create-archive'),('create-master','create-area'),('create-master','create-author'),('create-master','create-blog'),('create-master','create-category'),('create-master','create-collector'),('create-master','create-customer'),('create-master','create-employment'),('create-master','create-enrolment'),('create-master','create-event'),('create-master','create-gmap'),('create-master','create-network'),('create-master','create-note'),('create-master','create-note-type'),('create-master','create-photo'),('create-master','create-quote'),('create-master','create-service-type'),('create-master','create-staff'),('create-master','create-village'),('create-transaction','create-account-payable'),('create-transaction','create-account-receivable'),('create-transaction','create-billing'),('create-transaction','create-outlet'),('create-transaction','create-receivable'),('create-transaction','create-service'),('create-transaction','create-validity'),('create-transaction','create-validity-detail'),('delete-master','delete-account'),('delete-master','delete-account-type'),('delete-master','delete-album'),('delete-master','delete-archive'),('delete-master','delete-area'),('delete-master','delete-author'),('delete-master','delete-blog'),('delete-master','delete-category'),('delete-master','delete-collector'),('delete-master','delete-customer'),('delete-master','delete-employment'),('delete-master','delete-enrolment'),('delete-master','delete-event'),('delete-master','delete-gmap'),('delete-master','delete-network'),('delete-master','delete-note'),('delete-master','delete-note-type'),('delete-master','delete-photo'),('delete-master','delete-quote'),('delete-master','delete-service-type'),('delete-master','delete-staff'),('delete-master','delete-village'),('delete-transaction','delete-account-payable'),('delete-transaction','delete-account-receivable'),('delete-transaction','delete-billing'),('delete-transaction','delete-outlet'),('delete-transaction','delete-receivable'),('delete-transaction','delete-service'),('delete-transaction','delete-validity'),('delete-transaction','delete-validity-detail'),('index-master','index-account'),('index-master','index-account-type'),('index-master','index-album'),('index-master','index-archive'),('index-master','index-area'),('index-master','index-author'),('index-master','index-blog'),('index-master','index-category'),('index-master','index-collector'),('index-master','index-comment'),('index-master','index-content'),('index-master','index-customer'),('index-master','index-employment'),('index-master','index-enrolment'),('index-master','index-event'),('index-master','index-gmap'),('index-master','index-network'),('index-master','index-note'),('index-master','index-note-type'),('index-master','index-page'),('index-master','index-page-type'),('index-master','index-photo'),('index-master','index-quote'),('index-master','index-service-type'),('index-master','index-staff'),('index-master','index-village'),('index-transaction','index-account-payable'),('index-transaction','index-account-receivable'),('index-transaction','index-billing'),('index-transaction','index-outlet'),('index-transaction','index-receivable'),('index-transaction','index-service'),('index-transaction','index-validity'),('index-transaction','index-validity-detail'),('reguler','create-master'),('reguler','create-transaction'),('reguler','index-master'),('reguler','index-transaction'),('reguler','update-master'),('reguler','update-transaction'),('reguler','view-master'),('reguler','view-transaction'),('update-master','update-account'),('update-master','update-account-type'),('update-master','update-album'),('update-master','update-archive'),('update-master','update-area'),('update-master','update-author'),('update-master','update-blog'),('update-master','update-category'),('update-master','update-collector'),('update-master','update-content'),('update-master','update-customer'),('update-master','update-employment'),('update-master','update-enrolment'),('update-master','update-event'),('update-master','update-gmap'),('update-master','update-network'),('update-master','update-note'),('update-master','update-note-type'),('update-master','update-office'),('update-master','update-page'),('update-master','update-page-type'),('update-master','update-photo'),('update-master','update-profile'),('update-master','update-quote'),('update-master','update-service-type'),('update-master','update-staff'),('update-master','update-village'),('update-transaction','update-account-payable'),('update-transaction','update-account-receivable'),('update-transaction','update-billing'),('update-transaction','update-outlet'),('update-transaction','update-receivable'),('update-transaction','update-service'),('update-transaction','update-validity'),('update-transaction','update-validity-detail'),('view-master','view-account'),('view-master','view-account-type'),('view-master','view-album'),('view-master','view-archive'),('view-master','view-area'),('view-master','view-author'),('view-master','view-blog'),('view-master','view-category'),('view-master','view-collector'),('view-master','view-comment'),('view-master','view-content'),('view-master','view-counter'),('view-master','view-customer'),('view-master','view-employment'),('view-master','view-enrolment'),('view-master','view-event'),('view-master','view-gmap'),('view-master','view-lookup'),('view-master','view-network'),('view-master','view-note'),('view-master','view-note-type'),('view-master','view-office'),('view-master','view-page'),('view-master','view-page-type'),('view-master','view-photo'),('view-master','view-profile'),('view-master','view-quote'),('view-master','view-service-type'),('view-master','view-staff'),('view-master','view-theme'),('view-master','view-village'),('view-transaction','view-account-payable'),('view-transaction','view-account-receivable'),('view-transaction','view-billing'),('view-transaction','view-outlet'),('view-transaction','view-receivable'),('view-transaction','view-service'),('view-transaction','view-validity'),('view-transaction','view-validity-detail');

/*Table structure for table `tx_auth_rule` */

DROP TABLE IF EXISTS `tx_auth_rule`;

CREATE TABLE `tx_auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `tx_auth_rule` */

/*Table structure for table `tx_author` */

DROP TABLE IF EXISTS `tx_author`;

CREATE TABLE `tx_author` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `phone_number` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `google_plus` varchar(100) DEFAULT NULL,
  `instagram` varchar(100) DEFAULT NULL,
  `facebook` varchar(100) DEFAULT NULL,
  `twitter` varchar(100) DEFAULT NULL,
  `file_name` varchar(100) DEFAULT NULL,
  `address` tinytext,
  `description` tinytext,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `tx_author` */

insert  into `tx_author`(`id`,`title`,`phone_number`,`email`,`google_plus`,`instagram`,`facebook`,`twitter`,`file_name`,`address`,`description`,`create_time`,`update_time`,`create_by`,`update_by`,`verlock`) values (1,'Test',NULL,NULL,NULL,NULL,NULL,NULL,'nJ3DnDfHyKTR3l6p9z6wd1I3Q3YQtAaP.png',NULL,'okedeh',1507215791,1507215791,1,1,0),(2,'Antonio',NULL,NULL,NULL,NULL,NULL,NULL,'dXAdOH6RlpBeGj894VuEIV822R7ZW0i5.png',NULL,'Partikelir',1510843683,1510843683,1,1,NULL);

/*Table structure for table `tx_billing` */

DROP TABLE IF EXISTS `tx_billing`;

CREATE TABLE `tx_billing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL,
  `title` varchar(10) DEFAULT NULL,
  `invoice` varchar(10) DEFAULT NULL,
  `amount` decimal(18,2) DEFAULT NULL,
  `date_issued` int(11) DEFAULT NULL,
  `date_due` int(11) DEFAULT NULL,
  `month_period` varchar(6) DEFAULT NULL,
  `billing_type` int(11) DEFAULT NULL,
  `payment_status` int(11) DEFAULT NULL,
  `description` tinytext,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tx_billing_customer` (`customer_id`),
  KEY `FK_tx_billing_type_lookup` (`billing_type`),
  KEY `FK_tx_billing_payment_lookup` (`payment_status`),
  CONSTRAINT `FK_tx_billing_customer` FOREIGN KEY (`customer_id`) REFERENCES `tx_customer` (`id`),
  CONSTRAINT `FK_tx_billing_payment_lookup` FOREIGN KEY (`payment_status`) REFERENCES `tx_lookup` (`id`),
  CONSTRAINT `FK_tx_billing_type_lookup` FOREIGN KEY (`billing_type`) REFERENCES `tx_lookup` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tx_billing` */

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
  `description` longtext,
  `tags` text,
  `publish_status` int(11) NOT NULL,
  `pinned_status` int(11) DEFAULT NULL,
  `view_counter` int(11) DEFAULT NULL,
  `rating` float DEFAULT NULL,
  `date_issued` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tx_blog_author` (`author_id`),
  KEY `FK_tx_blog_category` (`category_id`),
  KEY `FK_tx_blog_publish` (`publish_status`),
  KEY `FK_tx_blog_pinned` (`pinned_status`),
  CONSTRAINT `FK_tx_blog_author` FOREIGN KEY (`author_id`) REFERENCES `tx_author` (`id`),
  CONSTRAINT `FK_tx_blog_category` FOREIGN KEY (`category_id`) REFERENCES `tx_category` (`id`),
  CONSTRAINT `FK_tx_blog_pinned` FOREIGN KEY (`pinned_status`) REFERENCES `tx_lookup` (`id`),
  CONSTRAINT `FK_tx_blog_publish` FOREIGN KEY (`publish_status`) REFERENCES `tx_lookup` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

/*Data for the table `tx_blog` */

insert  into `tx_blog`(`id`,`category_id`,`author_id`,`title`,`cover`,`url`,`content`,`description`,`tags`,`publish_status`,`pinned_status`,`view_counter`,`rating`,`date_issued`,`create_time`,`update_time`,`create_by`,`update_by`,`verlock`) values (6,1,1,'Malas Gerak, Salah Satu Penyebab Kematian Terbanyak di Dunia',NULL,NULL,'<p><img alt=\"\" src=\"http://assets.kompas.com/crop/0x304:1000x970/750x500/data/photo/2017/11/16/2642850916.jpg\" /></p>\r\n\r\n<p><strong>KOMPAS.com</strong> &mdash; Anda mungkin sedang membaca tulisan ini sambil bersantai di tempat duduk atau sambil tiduran di kasur. Mungkin Anda juga sudah duduk atau tiduran sejak beberapa jam lalu. Cobalah untuk mengingat-ingat, kapan Anda bangkit dari tempat duduk dan melakukan aktivitas fisik tertentu?</p>\r\n\r\n<p>Jika Anda kesulitan mengingatnya, bisa jadi Anda adalah salah satu dari ratusan juta penduduk dunia yang menjalani gaya hidup sedentari atau yang sering juga disebut <a href=\"https://hellosehat.com/hidup-sehat/fakta-unik/bahaya-malas-gerak/\" rel=\"nofollow\" target=\"_blank\">malas gerak</a> (mager).&nbsp;&nbsp;</p>\r\n\r\n<p>Gaya hidup sedentari adalah pola perilaku manusia yang minim aktivitas atau gerakan fisik. Biasanya mereka yang menjalani gaya hidup sedentari adalah pekerja kantoran yang hampir sepanjang hari duduk di balik meja kerja.</p>\r\n\r\n<p>Perjalanan menuju kantor dari rumah pun biasanya ditempuh dengan kendaraan umum atau pribadi yang berarti juga duduk sepanjang jalan. Sesampainya di rumah setelah bekerja seharian, banyak pekerja kantoran yang langsung beristirahat di sofa, kasur, atau kursi malas untuk melepas lelah.</p>\r\n\r\n<p>Belum lagi jika Anda sering memanfaatkan layanan pembelian barang, makanan, atau jasa secara <em>online</em>, pesanan langsung diantar ke depan pintu rumah.</p>\r\n\r\n<p>Baca juga: <a href=\"http://lifestyle.kompas.com/read/2017/09/06/053000420/tips-mulai-aktif-bagi-yang-tak-pernah-olahraga\" target=\"_blank\">Tips Mulai Aktif bagi yang Tak Pernah Olahraga</a></p>\r\n\r\n<p>Selain itu, banyak orang saat ini memilih untuk mengakses layanan perbankan <em>online</em>, misalnya untuk transfer uang atau membayar tagihan. Sementara pada zaman dahulu, orang harus berjalan keluar rumah untuk menyelesaikan berbagai urusan tersebut.</p>\r\n\r\n<p>Inilah yang menyebabkan generasi muda sering dicap sebagai orang-orang yang malas gerak.</p>\r\n\r\n<p>Malas gerak adalah kebiasaan yang perlu diubah. Namun, bagi beberapa orang kebiasaan tersebut sudah menjadi bagian dari rutinitas harian sehingga mereka terlanjur merasa nyaman.</p>\r\n\r\n<p>Anda mungkin memang tak akan merasakan langsung risiko dari gaya hidup sedentari. Dampak dari gaya hidup sedentari baru akan mulai terasa bertahun-tahun setelah Anda terbiasa menjalani rutinitas tersebut.</p>\r\n\r\n<p><img alt=\"\" src=\"http://assets.kompas.com/crop/0x0:1000x667/750x500/data/photo/2017/11/16/558893226.jpg\" /></p>\r\n\r\n<p>Menurut Badan Kesehatan Dunia atau WHO, gaya hidup sedentari adalah salah satu dari 10 penyebab kematian terbanyak di dunia. Selain itu, data yang dilaporkan oleh European Prospective Investigation into Cancer and Nutrition (EPIC) pada tahun 2008 menunjukkan bahwa kematian akibat kebiasaan malas gerak jumlahnya dua kali lebih banyak dibandingkan kematian karena obesitas.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Baca juga: <a href=\"http://lifestyle.kompas.com/read/2017/08/29/061500120/11-trik-untuk-memaksakan-diri-hidup-aktif\" target=\"_blank\">11 Trik untuk Memaksakan Diri Hidup Aktif</a></p>\r\n\r\n<p>Jika gaya hidup sedentari diikuti dengan pola makan yang tidak seimbang dan kebiasaan tidak sehat seperti merokok atau minum alkohol, Anda pun berisiko mengalami lebih banyak masalah kesehatan.</p>\r\n\r\n<p>Walau kadang tidak disadari, kebanyakan duduk seharian dan kurang bergerak berdampak secara langsung pada kesehatan. Berikut adalah berbagai risiko yang harus diperhatikan jika Anda termasuk orang yang malas gerak.</p>\r\n\r\n<p><strong>1. Konsentrasi menurun</strong></p>\r\n\r\n<p>Ketika seseorang bekerja sambil duduk, tulang belakang akan jadi tegang karena terlalu lama membungkuk atau melengkung. Oleh karenanya, paru-paru tidak akan mendapatkan ruang untuk mengembang cukup besar.</p>\r\n\r\n<p>Jika paru-paru terimpit, seluruh tubuh akan menerima kadar oksigen yang lebih sedikit, apalagi karena sirkulasi juga akan terganggu kalau tidak cukup bergerak. Kurangnya oksigen yang diterima otak bisa menyebabkan turunnya konsentrasi. Bekerja pun jadi lebih sulit dan tidak fokus.</p>\r\n\r\n<p><strong>2. Meningkatkan risiko stroke dan serangan jantung</strong></p>\r\n\r\n<p>Sebuah studi yang dilakukan oleh Aerobics Research Center di Amerika Serikat menunjukkan bahwa aktivitas fisik mampu mengurangi risiko stroke pada pria hingga sebesar 60 persen.</p>\r\n\r\n<p>Penelitian lain yang diterbitkan dalam Nurses&rsquo; Health Study membuktikan bahwa wanita yang cukup bergerak atau beraktivitas fisik memiliki peluang terhindar dari stroke dan serangan jantung sebesar 50%.</p>\r\n\r\n<p>Maka, orang yang terlalu sering duduk bekerja atau bermalas-malasan di depan layar komputer memiliki risiko cukup besar mengalami stroke.</p>\r\n\r\n<p>Baca juga: <a href=\"http://lifestyle.kompas.com/read/2017/10/02/105255320/jaga-kesehatan-stroke-bisa-terjadi-sejak-usia-20an\" target=\"_blank\">Jaga Kesehatan, Stroke Bisa Terjadi Sejak Usia 20an</a></p>\r\n\r\n<p><strong>3. Gangguan fungsi kognitif</strong></p>\r\n\r\n<p>Mereka yang menjalani gaya hidup sedentari atau malas gerak cenderung lebih mudah mengalami berbagai gangguan fungsi kognitif dalam jangka panjang. Kurangnya aktivitas fisik menyebabkan fungsi otak menurun.</p>\r\n\r\n<p>Aktivitas fisik mampu merangsang aliran darah yang penuh oksigen menuju otak serta memperbaiki sel dan jaringan otak yang mulai rusak. Bergerak dan berolahraga juga akan menumbuhkan berbagai sel saraf baru dalam otak. Hal ini membuat otak semakin tajam dan daya ingat semakin kuat.</p>\r\n\r\n<p><strong>4. Menyebabkan resistensi insulin</strong></p>\r\n\r\n<p>Kalau Anda menghabiskan kira-kira 70 persen dari waktu seharian dengan duduk dan tiduran, Anda berisiko mengalami resistensi insulin. Kondisi ini menyebabkan meningkatnya kadar gula dalam darah sehingga peluang terserang diabetes pun meningkat.</p>\r\n\r\n<p>Apalagi, biasanya sambil duduk atau tiduran, orang-orang cenderung mencari camilan yang kurang sehat. Camilan tersebut bisa jadi mengandung gula yang sangat tinggi, misalnya es krim, permen, cokelat, atau minuman kemasan yang manis.</p>\r\n\r\n<p><strong>5. Memicu osteoporosis</strong></p>\r\n\r\n<p>Tubuh manusia sudah dirancang sedemikian rupa untuk terus bergerak secara aktif agar bisa bertahan diri. Otot dan tulang harus dilatih setiap hari agar tetap sehat dan kuat. Kebiasaan malas gerak akan membuat tubuh kehilangan massa otot. Kepadatan tulang juga akan berkurang drastis.</p>\r\n\r\n<p>Jika dibiarkan, kondisi tersebut akan mengarah pada osteoporosis. Akibatnya, menjalani aktivitas sehari-hari pun jadi lebih sulit karena Anda semakin lemas dan cepat lelah.</p>\r\n\r\n<p><strong>Cara mudah memaksa tubuh untuk bergerak lebih banyak</strong></p>\r\n\r\n<p><strong><img alt=\"\" src=\"http://assets.kompas.com/crop/0x39:1000x706/750x500/data/photo/2017/11/16/2565730869.jpg\" style=\"height:500px; width:750px\" /></strong></p>\r\n\r\n<p>Anda bisa menghindari risiko-risiko yang diakibatkan oleh kebiasaan malas gerak dengan cara meningkatkan aktivitas fisik sehari-hari. Simak berbagai trik supaya Anda tetap bisa memenuhi kebutuhan gerak tubuh setiap hari meskipun Anda harus bekerja di hadapan layar komputer.</p>\r\n\r\n<ul>\r\n	<li>Cari <em>standing desk</em> atau meja yang cukup tinggi supaya Anda bisa bekerja sambil berdiri jika sudah kelamaan duduk di kursi</li>\r\n</ul>\r\n\r\n<ul>\r\n	<li>Sambil mencari ide atau inspirasi saat bekerja, Anda bisa berjalan kaki mengitari gedung kantor atau di sekitar meja kerja Anda selama beberapa menit</li>\r\n</ul>\r\n\r\n<ul>\r\n	<li>Jika Anda naik kendaraan umum seperti kereta atau bus, usahakan untuk berdiri daripada duduk sepanjang perjalanan</li>\r\n</ul>\r\n\r\n<ul>\r\n	<li>Parkir kendaraan atau turun dari kendaraan umum di perhentian yang lebih jauh dari biasanya, lalu berjalan kakilah menuju kantor</li>\r\n</ul>\r\n\r\n<ul>\r\n	<li>Daripada memesan barang-barang di toko online, pergilah dan berburu barang-barang yang Anda cari di pusat perbelanjaan</li>\r\n</ul>\r\n\r\n<ul>\r\n	<li>Sempatkan untuk berolahraga selama satu jam setiap hari, baik di pagi hari atau sepulang kerja</li>\r\n</ul>\r\n\r\n<ul>\r\n	<li>Membersihkan rumah bisa menjadi aktivitas fisik yang cukup berat, misalnya menyapu, mengepel lantai, atau mencuci pakaian dengan tangan</li>\r\n</ul>\r\n','-','essay, test, ada, yaa',7,2,NULL,NULL,NULL,1510671566,1510842311,1,1,6),(7,2,1,'Dirut PLN: Penyederhanaan Listrik Belum Final',NULL,NULL,'<p><img alt=\"\" src=\"http://assets.kompas.com/crop/38x0:971x622/750x500/data/photo/2017/07/17/1195167867.jpg\" /></p>\r\n\r\n<p><strong>JAKARTA, KOMPAS.com</strong> - <a href=\"http://indeks.kompas.com/tag/PLN\" target=\"_blank\">PLN</a> mengumumkan bahwa perubahan golongan tarif <a href=\"http://indeks.kompas.com/tag/listrik\" target=\"_blank\">listrik</a> tidak wajib dilakukan pelanggan. Rencananya perubahan dari golongan tarif 1.200 VA, 2.200 VA, 3.300 VA dan 4.400 VA menjadi 5.500 VA itu hanya diberikan jika pelanggan mengajukan permintaan.</p>\r\n\r\n<p>&quot;Soal penyederhanaan tarif, masih ada yg dalam bahasan, belum diputuskan. Kalau disetujui kemungkinan tahun depan,&quot; ucap Direktur Utama PLN, Sofyan Basir dalam konferensi pers di Grand Hyatt Jakarta, Kamis (16/11/2017).</p>\r\n\r\n<p>Dia mengatakan, rencana perubahan tersebut digodok demi kepentingan pelanggan sendiri. Terutama agar pelanggan yang ingin menaikkan golongan tarif listrik tidak harus mengeluarkan biaya besar.</p>\r\n\r\n<p>Misalnya dari 1.300 VA mau dilebihkan sedikit 1.500 VA untuk bisa nambah AC atau kulkas, tidak perlu lagi membayar biaya tambahan mahal. Daya yang mencapai 5.500 VA itu justru berlebih dan bisa digunakan atau tidak digunakan, sesuai kebutuhan.</p>\r\n\r\n<p><em><strong>Baca juga: <a href=\"http://ekonomi.kompas.com/read/2017/11/14/223300926/penyederhanaan-golongan-listrik-jonan-minta-pln-survei-masyarakat\" target=\"_blank\">Penyederhanaan Golongan Listrik, Jonan Minta PLN Survei Masyarakat</a></strong></em></p>\r\n\r\n<p>&quot;Karena ganti golongan kan mahal, kadang-kadang ada calonya lagi. Kalau dengan rencana ini, perubahan bisa dilakukan tanpa biaya, tarif tidak ada kenaikan apapun, abodemen tetap. Tidak ada formula baru atau pemakaian minimal,&quot; imbuhnya.</p>\r\n\r\n<p>Sebelumnya, sempat disebutkan bahwa PLN berencana menghapus golongan tarif 900 VA (non-subsidi), 1.300 VA, 2.200 VA, 3.300 VA menjadi 4.400 VA. Rencana itu kemudian dikoreksi dengan rencana berikutnya untuk hanya menghapus golongan tarif 1.300 VA, 2.200 VA, 3.300 VA, dan 4.400 VA menjadi 5.500 VA.</p>\r\n\r\n<p>Perubahan ke golongan tarif yang lebih besar itu dijanjikan tidak akan memungut biaya tambahan, tak ada kenaikan tarif, serta tak ada perubahan abodemen.</p>\r\n\r\n<p><em><strong>Baca juga: <a href=\"http://ekonomi.kompas.com/read/2017/11/14/192644626/jonan-peningkatan-daya-listrik-enggak-ada-biaya-apa-apa\" target=\"_blank\">Jonan: Peningkatan Daya Listrik, Enggak Ada Biaya Apa-apa</a></strong></em></p>\r\n',' PLN mengumumkan bahwa perubahan golongan tarif listrik tidak wajib dilakukan pelanggan. Rencananya perubahan dari golongan tarif 1.200 VA, 2.200 VA, 3.300 VA dan 4.400 VA menjadi 5.500 VA itu hanya diberikan jika pelanggan mengajukan permintaan. ','berita',7,2,NULL,NULL,NULL,1510842746,1510842746,1,1,0),(8,2,1,'Masuk Tunisia Pakai Paspor Bosnia, Agen Mossad Bunuh Teknisi Hamas',NULL,NULL,'<p><img alt=\"\" src=\"http://assets.kompas.com/crop/3x2:797x531/750x500/data/photo/2017/11/16/1165351200.jpg\" /></p>\r\n\r\n<p><strong>BEIRUT, KOMPAS.com</strong> - Kelompok <a href=\"http://indeks.kompas.com/tag/Hamas\" target=\"_blank\">Hamas</a>, Kamis (16/11/2017), menuduh mata-mata <a href=\"http://indeks.kompas.com/tag/Israel\" target=\"_blank\">Israel </a>menggunakan paspor Bosnia untuk memasuki <a href=\"http://indeks.kompas.com/tag/Tunisia\" target=\"_blank\">Tunisia</a> dan membunuh salah seorang pakar drone kelompok itu.</p>\r\n\r\n<p>Insinyur asal Tunisia Mohamed Zaouari ditembak mati di mobilnya pada Desember 2016 oleh orang tak dikenal. Saat itu, Hamas langsung menuduh Israel sebagai pelaku pembunuhan tersebut.</p>\r\n\r\n<p>Dalam konferensi pers di Beirut, Lebanon, tokoh senior Hamas Mohamed Nazzal kembali menggaungkan tuduhan kepada Israel itu.</p>\r\n\r\n<p>Dia mengatakan, hasil investigasi menunjukkan sejumlah agen dinas rahasia Isrel, <a href=\"http://indeks.kompas.com/tag/Mossad\" target=\"_blank\">Mossad</a> telah bekerja di Tunisia selama beberapa bulan.</p>\r\n\r\n<p><strong>Baca juga : <a href=\"http://internasional.kompas.com/read/2017/10/25/19135671/dituduh-jadi-mata-mata-mossad-dokter-di-iran-diganjar-hukuman-mati\" target=\"_blank\">Dituduh Jadi Mata-mata Mossad, Dokter di Iran Diganjar Hukuman Mati</a> </strong></p>\r\n\r\n<p>Mereka menggunakan berbagai penyamaran termasuk menjadi seornag wartawan asing agar bisa mendekati Zaouari.</p>\r\n\r\n<p>Namun, dua agen yang bertugas sebagai eksekutor memasiki Tunisia dengan menggunakan paspor Bosnia beberapa hari sebelum pembunuhan itu terjadi.</p>\r\n\r\n<p>Juru bicara Kemenlu Israel Emmanuel Nahshon tak mau mengomentari tuduhan Hamas itu. Israel juga tak berkomentar terkait pembunuhan Zaouari.</p>\r\n\r\n<p>Zaouari (49) dibunuh saat sedang berada di mobilnya di luar kediamannya di kota terbesar kedua Tunisia, Sfax pada 15 Desember 2016.</p>\r\n\r\n<p>Zaouari adalah seorang teknisi dan pakar drone yang sudah lama bekerja untuk Hamas, kelompok yang menguasai Jalur Gaza.</p>\r\n\r\n<p>Israel pernah dihujani kritik setelah agen-agen rahasianya menggunakan paspor Inggris, Irlandia, dan Australia untuk membunuh seorang pemimpin Hamas di Uni Emirat Arab pada 2010.</p>\r\n\r\n<p>Insiden pembunuhan pemimpin Hamas itu berujung pengusiran sejumlah diplomat Israel di Inggris, Irlandia, dan Australia.</p>\r\n\r\n<p><strong>Baca juga : <a href=\"http://internasional.kompas.com/read/2017/06/28/10275221/mossad.galang.dana.untuk.dapatkan.teknik.mata-mata.terbaru\" target=\"_blank\">Mossad Galang Dana untuk Dapatkan Teknik Mata-Mata Terbaru</a> </strong></p>\r\n','Kelompok Hamas, Kamis (16/11/2017), menuduh mata-mata Israel menggunakan paspor Bosnia untuk memasuki Tunisia dan membunuh salah seorang pakar drone kelompok itu.','internasional',7,2,NULL,NULL,NULL,1510842956,1510842956,1,1,0),(9,1,2,'Prisia Nasution: Aku Akan Selalu Nyaman dengan Film ',NULL,NULL,'<p><img alt=\"\" src=\"http://assets.kompas.com/crop/0x163:774x679/750x500/data/photo/2017/11/16/2781584412.jpg\" /></p>\r\n\r\n<p><strong>JAKARTA, KOMPAS.com</strong> - Menjajal seni peran di panggung teater agaknya belum bisa melunturkan kecintaan artis peran <a href=\"http://indeks.kompas.com/tag/Prisia-Nasution\" target=\"_blank\">Prisia Nasution</a> terhadap dunia film.</p>\r\n\r\n<p>&quot;Kalau nyaman ya akan selalu nyaman sama film, karena itu yang saya kenal pertama,&quot; ucap Prisia saat jumpa pers pertunjukan <em>Kepada Gema</em> di kawasan Kemang, Jakarta Selatan, Kamis (16/11/2017).</p>\r\n\r\n<p>Sebagai informasi, perempuan yang akrab disapa Phia itu diketahui tengah terlibat dalam pertunjukan teater <em>Kepada Gema</em> yang akan digelar di Gedung Graha Bhakti, Taman Ismail Marzuki, Jakarta Pusat pada 25-26 November 2017 mendatang.</p>\r\n\r\n<p>Baca juga : <a href=\"http://entertainment.kompas.com/read/2017/11/16/201401810/kepada-gema-bikin-prisia-nasution-gali-trauma-masa-lalu\" target=\"_blank\">Kepada Gema, Bikin Prisia Nasution Gali Trauma Masa Lalu</a></p>\r\n\r\n<p>Phia merasa tertantang untuk memainkan lakon di atas panggung pertunjukan teater agar ia bisa terbuka dengan orang-orang baru.</p>\r\n\r\n<p>&quot;Dulu tuh selalu nge-<em>challenge</em> diriku sendiri untuk teater, karena saya kalau <em>ketemu</em> sama orang baru enggak bisa se-<em>open</em> sama orang yang <em>ketemu</em> sudah lama,&quot; ucapnya.</p>\r\n\r\n<p>Bintang film <em>Rectorverso</em> itu juga menjelaskan perbedaan yang dia rasakan saat berakting di atas panggung dan di depan kamera.</p>\r\n\r\n<p>&quot;Kalau di film kan sudah keluarga sebelum mereka bisa ngambil gambar saya. Kalau teater penonton baru, mata-mata baru,&quot; tutur Phia menjelaskan.</p>\r\n\r\n<p>&quot;Kalau begini, sedikit bisa di-<em>judge</em> secara instan, kalau film kan, kitanya sudah ke mana dulu mereka baru nge-<em>judge macem-macem</em> ya <em>bodo amat</em>. Kalau di sini panggung energinya beda,&quot; imbuhnya.</p>\r\n','Menjajal seni peran di panggung teater agaknya belum bisa melunturkan kecintaan artis peran Prisia Nasution terhadap dunia film.','artis',7,2,2,NULL,NULL,1510843791,1514305931,1,NULL,2),(10,1,1,'Harapan Baru Masa Depan Perekonomian Indonesia Ada di Ekonomi Kreatif',NULL,NULL,'<p><img alt=\"\" src=\"http://assets.kompas.com/crop/0x0:780x390/780x390/data/photo/2017/11/16/2646227475.jpg\" /></p>\r\n\r\n<p>Indonesia memiliki kekuatan baru untuk membangun perekonomian. Bukan lagi komoditas alam mentah, ekonomi Kreatif karya anak bangsa menunjukkan geliatnya hingga kekancah internasional.</p>\r\n\r\n<p>Badan Ekonomi Kreatif (Bekraf) kini telah membidangi 16 sub-sektor ekonomi kreatif, yakni <em>fashion</em>, film dan animasi, kuliner, kriya, seni rupa, seni pertunjukan, seni musik, arsitektur, desain komunikasi visual, desain produk, pengembang aplikasi dan <em>games</em>, televisi dan radio, serta fotografi.</p>\r\n\r\n<p>Bekraf pun mencatat kontribusi ekonomi Kreatif terhadap PDB Indonesia terus meningkat. Hingga tahun 2015, nilainya mencapai Rp 852 triliun atau naik 8,6 persen dibandingkan tahun sebelumnya. Dari jumlah tersebut, kontribusi terbesar disumbangkan oleh sub-sektor kuliner sebesar 41,69 persen, sementara fashion dan kriya menyumbang 18,15 persen dan 15,70 persen.</p>\r\n\r\n<p>Industri film dan music masing-masing berkontribusi sebesar 10,28 persen dan 7,62 persen. Sementara industry <em>game</em>turut menyumbang 6,68 persen menyusul seni/arsitektur di 6,62 persen.</p>\r\n\r\n<p>Kondisi ini pun ditanggapi dengan optimis oleh Kepala Bekraf Triawan Munaf. Ia berharap di masa depan, perekonomian Indonesia tidak hanya bergantung pada kekayaan alamnya saja. Tak hanya itu, Bekraf pun terus mendorong kesadaran akan pentingnya sector ekonomi kreatif.</p>\r\n\r\n<p>&ldquo;<em>Fashion</em>, kuliner, dan<em> crafts</em> (kerajinan tangan) itu sudah besar, dan kami mau akselerasi. Ada juga lainnya yang menjadi prioritas untuk dikembangkan, yakni games, aplikasi, musik, dan film,&rdquo; tutur Triawan dalam diskusi Forum Merdeka Barat 9 di Kantor Staf Presiden, Selasa (17/10/2017).</p>\r\n\r\n<p><img alt=\"\" src=\"http://assets.kompas.com/crop/0x0:780x390/780x390/data/photo/2017/11/16/606069701.jpg\" /></p>\r\n\r\n<p>Salah satu langkah yang diambil untuk memuluskan jalan ekonomi kreatif Indonesia menembus pasar internasional adalah dengan menggunakan jejaring internasional melalui duta besar Indonesia. Sebagai perwakilan Indonesia di negara lain, para duta besar didorong untuk mempromosikan ekonomi Kreatif tanah air. Misalnya dengan melancarkan Diplomasi Soto, Kopi, danTenun. Dengan demikian, diharapkan ekonomi Kreatif mampu menjadi <em>soft power</em> Indonesia di pasar global.</p>\r\n\r\n<p>Masa depan ekonomi kreatif Indonesia pun kini berada di genggaman para generasi muda. Nama-nama besar seperti Dian Pelangi, Barli Asmara, dan Vivi Zubedi telah berhasil menembus&nbsp;dunia <em>fashion</em>iternasional dengan memamerkan karya mereka di New York Fashion Week pada 7 September 2017 lalu. Ini adalah bukti bahwa kearifan local tanah air bias diterima dunia jika dikemas secara kreatif dan modern.</p>\r\n\r\n<p>Presiden Joko Widodo pun menyambut positif pertumbuhan industri ekonomi kreatif. Pada Hari Sumpah Pemuda 28 Oktober lalu, istana mengundang sejumlah perwakilan anak muda dari industri ekonomi kreatif. Salah satu yang menarik perhatian Presiden jokowi adalah merek sepatu lokal Exodos57 yang memadukan desain sepatu modern dengan kain tradisional. Tak hanya di Hari Sumpah Pemuda, pada kesempatan lain pun ia menyatakan dukungannya terhadap industri ekonomi kreatif.</p>\r\n\r\n<p>&quot;Sebab, apa pun industri kreatif itu telah menjadi kekuatan kita. Jika industri kreatif digarap secara baik, anak-anak muda diberi ruang kreatif untuk berinovasi dan berkreativitas, bisa untuk dibawa ke luar,&quot; kata Presiden Jokowi di festival musik We The Fest di JIExpo Kemayoran, Jakarta Pusat, Jumat (11/8/2017) lalu.&nbsp;</p>\r\n\r\n<p>Belajar dari Korea Selatan yang telah sukses membawa demam K-Pop kekancah internasional, masih banyak hal yang menjadi pekerjaan rumah ekonomi kreatif Indonesia. Meskipun industry ekonomi Kreatif terus berkembang, ekosistem bisnis dan investasi serta infrastruktur penunjang di Indonesia masih perlu ditingkatkan.&nbsp; Dengan kreativitas tanpa batas, ekonomi kreatif Indonesia diyakini&nbsp; mampu menjadi masa depan baru perekonomian nasional.</p>\r\n','Indonesia memiliki kekuatan baru untuk membangun perekonomian. Bukan lagi komoditas alam mentah, ekonomi Kreatif karya anak bangsa menunjukkan geliatnya hingga kekancah internasional.','berita, ekonomi, advertorial',7,2,NULL,NULL,NULL,1510844084,1510844084,1,1,0),(11,1,2,'NASA Ciptakan Alat Peramal Banjir, Begini Cara Kerjanya',NULL,NULL,'<p><img alt=\"\" src=\"http://assets.kompas.com/crop/316x0:925x406/750x500/data/photo/2017/05/20/103588139.jpg\" /></p>\r\n\r\n<p><strong>KOMPAS.com</strong>&nbsp;-- Tidak bisa dimungkiri, perubahan iklim adalah masalah terbesar manusia pada saat ini. Selain menyebabkan berbagai fenomena cuaca yang menghancurkan, suhu yang terus meningkat juga mencairkan lapisan es di kutub.</p>\r\n\r\n<p>Namun tahukah Anda, apa yang akan terjadi bila lapisan es di Greenland dan <a href=\"http://indeks.kompas.com/tag/Antartika\" target=\"_blank\">Antartika</a> mencair? <a href=\"http://indeks.kompas.com/tag/kota\" target=\"_blank\">Kota</a> mana saja yang akan tenggelam karena <a href=\"http://indeks.kompas.com/tag/banjir\" target=\"_blank\">banjir</a>?</p>\r\n\r\n<p>Baru-baru ini, <a href=\"http://indeks.kompas.com/tag/NASA\" target=\"_blank\">NASA</a> mengumumkan penemuan terbarunya, yakni alat peramal banjir bila es mencair.</p>\r\n\r\n<p>Para ilmuwan di Laboratorium Propulsi Jet NASA di California menjelaskan bahwa alat tersebut akan memberi gambaran umum tentang kondisi lapisan <a href=\"http://indeks.kompas.com/tag/gletser\" target=\"_blank\">gletser</a> dan lapisan es yang penting untuk <a href=\"http://indeks.kompas.com/tag/kota\" target=\"_blank\">kota</a> Anda.</p>\r\n\r\n<p><strong>Baca juga:&nbsp;<a href=\"http://sains.kompas.com/read/2017/11/15/170700623/titik-arus-panas-di-antartika-terdeteksi-ilmuwan-apa-dampaknya-\" target=\"_blank\">Titik Arus Panas di Antartika Terdeteksi Ilmuwan, Apa Dampaknya?</a></strong></p>\r\n\r\n<p>Penelitian yang dimuat di <a href=\"http://advances.sciencemag.org/content/3/11/e1700537\" rel=\"nofollow\" target=\"_blank\"><em>Science Advances</em></a> tersebut cukup mendapat perhatian besar karena memberikan pandangan baru untuk para pelaksana negara yang mengambil kebijakan publik.</p>\r\n\r\n<p>Salah satu ilmuwan senior dari NASA, Dr Erik Ivins, yang dikutip oleh&nbsp;<em>BBC,&nbsp;</em>Kamis (16/11/2017), mengatakan, saat ini kota-kota dan negara-negara berusaha membangun rencana untuk mengurangi banjir, mereka harus berpikir 100 tahun ke depan dan mereka ingin menilai risiko dengan cara yang sama seperti yang dilakukan oleh perusahaan asuransi.</p>\r\n\r\n<p>&quot;Alat baru ini memberi jalan bagi mereka untuk mengetahui lapisan es mana yang rawan mencair dan menenggelamkan kota mereka,&quot; imbuhnya.</p>\r\n\r\n<p><strong>Mekanisme alat</strong></p>\r\n\r\n<p>Seorang ilmuwan lainnya, Dr Eric Larour, berkata bahwa ada tiga hal kunci untuk mengetahui pola perubahaan permukaan air laut di seluruh dunia, yang digunakan dalam alat ini.</p>\r\n\r\n<p><strong>Baca juga</strong>:&nbsp;<a href=\"http://sains.kompas.com/read/2016/05/18/18262061/menurut.hasil.studi.jakarta.bakal.terancam.banjir.besar.pada.2060\" target=\"_blank\"><strong>Menurut Hasil Studi, Jakarta Bakal Terancam Banjir Besar pada 2060</strong></a></p>\r\n\r\n<p>Salah satunya adalah gravitasi. &quot;Lapisan es ini adalah massa besar yang memiliki daya tarik di laut. Saat es menyusut, daya tarik itu berkurang - dan laut akan menjauh dari massa itu,&quot; kata Larour.</p>\r\n\r\n<p>Dengan tidak adanya lapisan es yang menekan, tanah yang sebelumnya berada di bawah lapisan es akan mengembang ke atas.</p>\r\n\r\n<p>Pengaruh ketiga adalah rotasi bumi.</p>\r\n\r\n<p>&quot;Anda bisa membayangkan bumi seperti gasing. Saat berputar-putar, ia juga bergerak ke kiri dan kanan sehingga massa yang ada di permukaannya juga ikut berubah. Pola ini mendistribusikan ulang air di sekitar bumi,&quot; katanya.</p>\r\n\r\n<p><strong>Baca juga:&nbsp;<a href=\"http://sains.kompas.com/read/2017/05/20/155152123/perubahan.iklim.bikin.antartika.hijau.lagi.seperti.zaman.purba\" target=\"_blank\">Perubahan Iklim Bikin Antartika Hijau Lagi seperti Zaman Purba</a></strong></p>\r\n\r\n<p>Dengan menggunakan ketiga faktor di atas, para peneliti NASA membangun alat yang akan meramalkan banjir di berbagai kota.</p>\r\n\r\n<p>Berikut adalah alat peramal banjir yang dikembangkan oleh NASA:&nbsp;<a href=\"https://vesl.jpl.nasa.gov/research/sea-level/slr-gfm/\" rel=\"nofollow\" target=\"_blank\">https://vesl.jpl.nasa.gov/research/sea-level/slr-gfm/</a></p>\r\n','Tidak bisa dimungkiri, perubahan iklim adalah masalah terbesar manusia pada saat ini. Selain menyebabkan berbagai fenomena cuaca yang menghancurkan, suhu yang terus meningkat juga mencairkan lapisan es di kutub.','nasa, banjir, kota',7,2,NULL,NULL,NULL,1510844462,1510844462,1,1,0),(12,2,2,'NASA Selesai Uji Coba Sistem Pelacak Asteroid Berbahaya',NULL,NULL,'<p><img alt=\"\" src=\"http://assets.kompas.com/crop/0x31:1000x697/750x500/data/photo/2017/07/29/2702975324.jpg\" /></p>\r\n\r\n<p><strong>KOMPAS.com</strong> - Bahaya <a href=\"http://indeks.kompas.com/tag/asteroid\" target=\"_blank\">asteroid</a> terhadap bumi sudah sejak lama diperkirakan oleh para ilmuwan. Kekhawatiran inilah yang membuat <a href=\"http://indeks.kompas.com/tag/NASA\" target=\"_blank\">NASA</a>, badan antariksa Amerika Serikat, terus mengembangkan berbagai penelitian pencegahan.</p>\r\n\r\n<p>Kali ini, para ilmuwan NASA memimpin astronom dari berbagai negara dalam latihan internasional pertama yang menguji kemampuan untuk melacak asteroid berbahaya.</p>\r\n\r\n<p>Tujuan mereka adalah untuk &quot;memulihkan, melacak, dan mengkarakterisasi asteroid asli sebagai pemicu potensial&quot;, menurut siaran pers NASA yang dikutip dari <em>Futurism</em>, Senin (6/11/2017).</p>\r\n\r\n<p>Meski tubrukan asteroid ke bumi tidak akan menjadi &quot; <a href=\"http://indeks.kompas.com/tag/kiamat\" target=\"_blank\">kiamat</a>&quot; bagi umat manusia, tetapi hal ini pasti akan menyebabkan kerusakan yang besar. Untuk itulah, NASA mengembangkan cara untuk mendeteksi dan menangkal asteroid berbahaya, serta melatih ilmuwan untuk melakukan hal sama.</p>\r\n\r\n<p><strong>Baca juga: <a href=\"http://sains.kompas.com/read/2017/11/02/191943423/asteroid-alien-mendekati-kita-dan-ini-yang-terjadi-jika-hantam-jakarta\" target=\"_blank\">Asteroid Alien Mendekati Kita dan Ini yang Terjadi jika Hantam Jakarta</a> </strong></p>\r\n\r\n<p>Setelah berbulan-bulan merencanakan latihan tersebut, pada Juli 2017 yang lalu para astronom di European Southern Observatory&#39;s Very Large Telescope melihat asteroid TC4 2012. <a href=\"http://indeks.kompas.com/tag/asteroid\" target=\"_blank\">Asteroid</a> ini adalah asteroid kecil reflektif yang berada di jalur lintasan dekat dengan bumi.</p>\r\n\r\n<p>Para ilmuwan kemudian memilih TC4 sebagai latihan mereka sehingga proyek ini disebut <em>&quot;T</em>C4 Observation Campaign&quot;.</p>\r\n\r\n<p>Saat TC4 mendekati bumi, para ilmuwan bekerja sama untuk menganalisis ukuran asteroid, komposisi, dan lintasannya. Mereka juga memastikan saluran komunikasi internasional tersedia untuk pembagian informasi yang cepat dan efektif.</p>\r\n\r\n<p>&quot;Kampanye TC4 2012 merupakan kesempatan yang luar biasa bagi para peneliti untuk menunjukkan kesediaan dan kesiapan untuk berpartisipasi dalam kerja sama internasional dalam menangani potensi bahaya terhadap bumi,&quot; kata Boris Shustov, direktur sains untuk institut astronomi di Russian Academy of Science.</p>\r\n\r\n<p><strong>Baca juga:&nbsp;<a href=\"http://sains.kompas.com/read/2017/09/22/081000323/terungkap-inilah-rencana-penyelamatan-bumi-dari-serangan-asteroid\" target=\"_blank\">Terungkap, Inilah Rencana Penyelamatan Bumi dari Serangan Asteroid</a></strong></p>\r\n\r\n<p>Pengamatan para astronom memungkinkan mereka untuk memastikan bahwa TC4 tidak akan mempengaruhi bumi dalam orbit masa depannya. Selain itu, mereka juga dapat menentukan posisi asteroid serta perilaku berputar dan berjatuhannya.</p>\r\n\r\n<p>Hasil akhir latihan muncul pada bulan Oktober 2017 ketika TC4 melakukan perlintasan terdekatnya dengan bumi, melewati 43.780 kilimeter di atas kepala kita.</p>\r\n\r\n<p>NASA mengambil proyek ini sebagai kesempatan untuk menguji jalur komunikasi di dalam pemerintahan Amerika Serikat dan melalui cabang eksekutifnya.</p>\r\n\r\n<p>Simulasi darurat tentang dampak nyata ini memungkinkan komunitas astronomi untuk &quot;lebih siap sekarang dalam menghadapi ancaman asteroid yang berpotensi bahaya&quot;, kata Michael Kelley, pemimpin latihan TC4 di markas besar NASA di Washington.</p>\r\n','Bahaya asteroid terhadap bumi sudah sejak lama diperkirakan oleh para ilmuwan. Kekhawatiran inilah yang membuat NASA, badan antariksa Amerika Serikat, terus mengembangkan berbagai penelitian pencegahan.','nasa, kiamat, asteroid',7,2,NULL,NULL,NULL,1510844594,1510844594,1,1,0),(13,1,1,'Dengan Alat Ciptaan Siswa SMA Ini, Tuna Netra Bisa Mendengar Warna',NULL,NULL,'<p><img alt=\"\" src=\"http://assets.kompas.com/crop/0x68:1000x735/750x500/data/photo/2017/10/25/391143623.jpeg\" /></p>\r\n\r\n<p><strong>JAKARTA, KOMPAS.com &ndash;-</strong> Punya kemampuan mengetahui keindahan kombinasi <a href=\"http://indeks.kompas.com/tag/warna\" target=\"_blank\">warna</a> menjadi kelebihan tersendiri yang patut disyukuri. Pengidap buta warna atau <a href=\"http://indeks.kompas.com/tag/tuna-netra\" target=\"_blank\">tuna netra</a>, misalnya, tak dapat mengetahui warna-warni alam maupun menikmati lukisan.</p>\r\n\r\n<p>Di balik kurangnya penglihatan, mereka biasanya memilki sensitivitas terhadap suara yang jauh lebih baik. Kelebihan ini dapat dialihkan untuk mengetahui warna melalui suara.</p>\r\n\r\n<p>Jane Carolyne Hantanto, siswa kelas XII SMAK Penabur Gading Serpong, Jakarta, membuat alat yang mampu mengonversi warna menjadi gelombang suara. Bukan melihat, tuna netra dan buta warna dapat mengetahui warna dengan &lsquo;mendengarkan warna&rsquo;.</p>\r\n\r\n<p>Baca juga : <a href=\"http://sains.kompas.com/read/2017/07/27/081100223/tidak-punya-tanah-untuk-bertanam-plastik-pun-jadi\" target=\"_blank\">Tidak Punya Tanah untuk Bertanam? Plastik pun Jadi</a></p>\r\n\r\n<p>&ldquo;Perbedaan warna menghasilkan perbedaan gelombang yang ditangkap dan bunyi yang dihasilkan melalui speaker,&rdquo; kata Jane saat memamerkan penelitiannnya di Indonesia Science Expo (ISE) 2017 yang diadakan oleh Lembaga Imu Pengetahuan Indonesia (LIPI) di Balai Kartini, Jakarta, Selasa (24/10/2017).</p>\r\n\r\n<p>Penelitian Jane berangkat dari pengalaman kakak kelasnya yang gagal dalam ujian kimia. Saat itu, seniornya harus mampu membedakan warna larutan kimia.</p>\r\n\r\n<p>Alat buatan Jane bukanlah yang pertama. Sebelumnya mahasiswa Universitas Cornell, Deyu Liu dan Kevin Lin, telah membuat alat yang mengubah warna menjadi suara. Alat mereka mampu mengenali dan mengubah sembilan warna menjadi suara.</p>\r\n\r\n<p>Jane mengklaim alat buatannya mampu mengenal lebih banyak warna. <a href=\"http://indeks.kompas.com/tag/warna\" target=\"_blank\">Warna</a> merah muda, merah tua, dan merah tidak dijadikan satu suara seperti pada buatan Deyu dan Kevin.</p>\r\n\r\n<p>Baca juga : <a href=\"http://sains.kompas.com/read/2017/08/31/090600623/indonesia-raih-7-medali-di-ajang-ieso-ke-11\" target=\"_blank\">Indonesia Raih 7 Medali di Ajang IESO ke-11</a></p>\r\n\r\n<p>&ldquo;Secara teori, dari alatnya itu bisa membedakan 16 juta warna. Jadi akan terbentuk 16 juta suara,&rdquo; kata Jane.</p>\r\n\r\n<p>Alat konversi suara buatan Jane terdiri dari arduino, LED RGB, fototransistor, pengeras suara, dan baterai yang dirangkai ke dalam satu kotak kecil.</p>\r\n\r\n<p>Pertama, LED RGB diarahkan kepada bidang berwarna. Ketiga warna dasar &ndash;merah, hijau, biru&ndash; ini berkedip bergantian dalam kecepatan 1 milimeter per detik sehingga terlihat ketiga warna berkedip bersamaan.</p>\r\n\r\n<p>Kemudian, intensitas pantulan warna dari LED RGB akan dihitung oleh fototransistor dan dianalisis. Hasilnya masuk ke dalam arduino untuk memodulasi gelombang. Lalu, pengeras suara mengeluarkan suara yang berbeda dari setiap warna yang dipantulkan.</p>\r\n\r\n<p>&ldquo;Jadi nanti bukan lihat lukisan tapi dia mendengarkan lukisan. (Tapi) visualisasinya harus benar-benar hebat. Misalkan suaranya sama, sama, sama, beda. Nah ketika beda berarti ada garis. Memang butuh latihan ekstra ya, apalagi kalau gambarnya sudah kompleks,&rdquo; kata Jane.</p>\r\n\r\n<p>Dalam membuat alat itu, Jane dibantu oleh guru fisika dan pembimbing LIPI Dr. Esa Prakasa M. T. Prosesnya memakan waktu sekitar delapan bulan, dari Februari hingga September 2017. Bulan Oktober digunakan untuk penyelesaian akhir.</p>\r\n\r\n<p>Kemampuan alat tersebut diujikan kepada teman sekolahnya. Dari dua puluh warna, delapan warna berhasil dijawab dengan benar.</p>\r\n\r\n<p>&ldquo;Harapannya, tuna netra bisa membedakan warna. Khsususnya yang buta warna dan hanya bisa lihat hitam dan putih. Untuk ke depannya, orang disabilitas warna bisa melukis atau masuk ke jurusan yang mengharuskan menggunakan warna, mendesain sesuatu dengan warna,&rdquo; kata Jane.</p>\r\n','Punya kemampuan mengetahui keindahan kombinasi warna menjadi kelebihan tersendiri yang patut disyukuri. Pengidap buta warna atau tuna netra, misalnya, tak dapat mengetahui warna-warni alam maupun menikmati lukisan.','inovasi, tunanetra, warna',7,2,NULL,NULL,NULL,1510845531,1510845531,1,1,0),(14,2,1,'BBPJN VI Uji Coba Metode “Slurry Seal” Guna Mencegah Kerusakan Jalan',NULL,NULL,'<p><img alt=\"\" src=\"http://assets.kompas.com/crop/0x0:780x390/780x390/data/photo/2017/11/16/3221219796.jpg\" /></p>\r\n\r\n<p>Penanganan infrastruktur jalan selalu dilakukan sepanjang tahun. Baik pembangunan jalan baru,&nbsp; hingga pemeliharaan jalan yang sudah terbangun dari kerusakan. Rabu (15/11/2017) lalu, di wilayah kerja Balai Besar Pelaksana Jalan Nasional (BBPJN) VI, tepatnya di ruas Ciamis-Batas Jawa Tengah dilakukan uji coba penerapan lapisan <em>slurry seal </em>pada aspal sebagai&nbsp; langkah pencegahan kerusakan jalan.</p>\r\n\r\n<p>Mewakili Kepala BBPJN VI, Atyanto, Kepala&nbsp; Bidang Preservasi dan Peralatan 2 BBPJN VI, Edison Rombe&nbsp; mengatakan bahwa seluruh balai telah diimbau untuk lebih banyak melakukan pendekatan preventif pada kerusakan jalan dibandingkan melakukan pemeliharaan berkala. Menurutnya ada beberapa metode preventif kerusakan jalan,&nbsp; salah satunya adalah penggunaan <em>slurry seal</em>.</p>\r\n\r\n<p>&ldquo;Jadi <em>slurry seal</em> ini adalah salah satu langkah kita untuk menjaga kondisi jalan baik dan sedang kita buat agar bisa bertahan lebih lama sehingga kita bisa melakukan efesiensi di tempat itu. Jadi <em>slurry seal</em> ini merupakan kegiatan mempertahankan kondisi jalan,&rdquo; katanya.</p>\r\n\r\n<p>Hal tersebut diamini oleh Kepala Satuan Kerja Pelaksana Jalan Nasional 2 Jawa Barat,&nbsp; Wahyu Budi Wiyono. Budi mengatakan, pihaknya akan melakukan uji coba penerapan lapisan <em>slurry seal</em> di tiga ruas yang berada di wilayah kewenangannya, yaitu Ciamis-Batas Jateng,&nbsp; Lingkar Cianjur, dan Jampang Kulon &ndash; Surade &nbsp;&ndash; Tegal Beleud.&nbsp;</p>\r\n\r\n<p>Menurutnya tiga ruas itu dipilih karena mewakili tiga volume lalu lintas yang berbeda. &ldquo;Di ruas uji coba kali ini&nbsp; lalu lintasnya padat, kita memakai tipe tiga. Di lingkar Cianjur lalinnya sedang namun kita juga akan memakai tipe tiga. Nanti kita lihat kondisinya juga di Jampang Kulon dengan lalin rendah. Jadi ada tiga tipe <em>slurry seal</em> untuk tiga volume lalin yang berbeda juga,&rdquo; pungkasnya.</p>\r\n\r\n<p>Penggunaan <em>slurry seal</em> sebenarnya sudah cukup umum. <em>Slurry seal</em> tercatat sudah pernah digunakan&nbsp; di jalur Pantura, Jogja, Bantul, dan Cilacap. &ldquo;Sementara di Lintas Selatan Jabar ini&nbsp; baru pertama kali,&rdquo; kata Budi.</p>\r\n\r\n<p>Budi mengatakan pemilihan metode <em>slurry seal</em> ini memiliki beberapa keuntungan karena ini lebih murah dan lebih cepat pengaplikasiannya dibanding metode preventif yang ada.&nbsp; Dengan <em>Slurry Seal</em> penghematan biaya 50-75 persen lebih&nbsp; murah dari satu lapis aspal. 40-50 ribu per meter persegi, dengan umur rencana 1 tahun.</p>\r\n\r\n<p>Pada saat uji coba tadi, digunakan model <em>slurry seal</em> standar yang membutuhkan pengerjaan 3-4 jam hingga lalin dibuka penuh kembali. &ldquo;Kalau menggunakan <em>quick setting</em>, lalin sudah bisa kita buka dalam 2 jam. Saat ini yang dipakai <em>setting</em> biasa,&rdquo; imbuhnya.</p>\r\n\r\n<p>Namun <em>slurry seal </em>hanya bisa diterapkan di kondisi cuaca kering dan untuk kondisi jalan mantap. &ldquo;Jadi <em>slurry seal</em> untuk mempertahankan kemantapan jalan. kalau jalannya sudah terjadi deformasi perlu diolah dulu, sampai di patching baru kita beri <em>slurry seal</em> diatasnya,&rdquo;&nbsp; kata Budi.</p>\r\n\r\n<p><img alt=\"\" src=\"http://assets.kompas.com/crop/0x0:780x390/780x390/data/photo/2017/11/16/2879635497.jpg\" /></p>\r\n\r\n<p>Lebih jauh Budi akan mengidentifikasi kebutuhan preventif disetiap&nbsp; 2-3 kilometer dari 800 kilometer jalan di wilayah kerjanya. Adapun wilayah kerjanya yaitu ruas Nagrek-Batas Jateng,&nbsp; Pantai Selatan Jabar mulai dari Pangandaran &ndash; Cidaun &ndash; Jampang Kulon &ndash; Pelabuhan Ratu ke&nbsp; Utara ke Cianjur &ndash; Batas Raja Mandala, ke arah Benda di Barat.</p>\r\n\r\n<p>Ditemui di tempat yang sama, Pejabat Pembuat Komitmen Ruas Ciamis-Batas Jateng dan Banjar-Pangandaran, Kadimin menegaskan di ruasnya tersebut memang sudah terdapat jalan dengan permukaan aspal yang&nbsp; lepas butir dan atau retak rambut.&nbsp;</p>\r\n\r\n<p>Namun ia mengatakan jalan masih dalam kondisi mantap atau tidak rusak. &ldquo;Dalam uji coba ini, kita akan amati hasilnya, jika bagus, tahun&nbsp; depan ruas yang kondisi nya sama akan kita beri <em>slurry seal</em> agar umurnya lebih panjang,&rdquo; ujarnya.</p>\r\n\r\n<p>Menurut Kadimin dari segi pembiayaan,penggunaan&nbsp; <em>slurry seal</em> jauh lebih murah daripada melakukan pemeliharaan jalan dengan satu lapis&nbsp; AC WC. &ldquo;Program preventif ini perlu digalakkan.&nbsp; Jangan <em>layer</em> aspal&nbsp; dulu untuk jalan yang masih bagus. Kita disarankan untuk memakai program preventif seperti <em>slurry seal</em>&nbsp; ini,&rdquo;ujarnya.</p>\r\n\r\n<p>Dari Ciamis-Batas Jateng&nbsp; ada sekitar 5 kilometer jalan yang&nbsp; memiliki kondisi yang&nbsp; sama. Jika hasil&nbsp; uji coba ini memuaskan, 5 kilometer jalan&nbsp; itu akan diberikan <em>slurry seal</em>.&nbsp; Sementara untuk ruas Banjar &ndash; Pangandaran &nbsp;belum bisa diterapkan karena&nbsp; lebar jalannya masih 6 meter.</p>\r\n\r\n<p>Maka itu penerapan <em>slurry seal</em> diutamakan di jalur utama yang lebarnya sudah 7 meter.&nbsp; Pasalnya selama proses penerapan <em>slurry seal</em> akan diberlakukan buka tutup jalan yang pasti menimbulkan antrian kendaraan cukup panjang.&nbsp;</p>\r\n\r\n<p>Pengaplikasian <em>slurry seal</em> pun tidak&nbsp; membutuhkan&nbsp; banyak alat, hanya satu buah truk <em>scan road</em> untuk mencampur dan menghampar bubur aspal.&nbsp; Di bak truk tersebut material agregat, emulsi, air, semen, dan aditif dicampur kemudian dihamparkan ke permukaan jalan.</p>\r\n\r\n<p>Proses pengaplikasian <em>slurry seal</em> &nbsp;pada 500 meter bidang jalan bisa dilakukan dalam 30 menit. S<em>urry seal</em> terdiri dari tiga jenis campuran tergantung dari kerusakan jalan yang dihadapi. Makin parah kerusakan pori jalannya makin banyak volume adukan&nbsp; materialnya yang digunakan.</p>\r\n\r\n<p><strong>Kondisi Jalan Nasional di Wilayah PJN 2 Jawa Barat</strong></p>\r\n\r\n<p>Seusai melakukan uji coba slurry seal di ruas Ciamis-Batas Jateng&nbsp; KM 125, Kasatker PJN Wilayah 2 Jawa Barat, &nbsp;BBPJN VI, Wahyu Budi Wiyono &nbsp;menjelaskan kondisi Jalan Nasional&nbsp; di wilayahnya secara umum.</p>\r\n\r\n<p>Di wilayah Kesatkeran PJN 2 Jabar terdapat 8 PPK&nbsp; untuk sekitar 800 kilometer jalan nasional yang terdiri dari Nagrek &ndash; Batas Jateng,&nbsp; Pantai Selatan Jabar, mulai dari Pangandaran-Cidaun-Jampang Kulon-Pelabuhan Ratu, ke&nbsp; Utara ke Cianjur-Batas Raja Mandala, ke arah Benda di Barat.</p>\r\n\r\n<p>Menurut Budi, sempat terjadi keterlambatan penanganan <em>long segmen</em> sehingga&nbsp; sempat terdapat 11.000 lubang jalan. Selain itu masih banyak lebar jalan yang belum berstandar jalan nasional, yaitu 7 meter, sehingga menghasilkan efek <em>bottle&nbsp; neck</em>. Terutama di daerah Pantai Selatan Jawa Barat, Pangandaran, Jampang Kulon, Pelabuhan Ratu, dan Cibadak.</p>\r\n\r\n<p>&ldquo;Padahal daerah selatan ini mendukung jalur wisata. Mulai dari Ciwidey, Pangandaran, Pelabuhan Ratu, dan&nbsp; Ciletung, dan Pantai Selatan Jawa Barat sepanjang&nbsp; 500 kilometer.&nbsp; Jadi kalau ditempuh butuh waktu sehari semalam dari Pangandaran ke Pelabuhan Ratu,&rdquo; ujar Budi. Meski begitu,Budi tetap lega karena fungsionalitas jalan sudah tercapai.&nbsp;</p>\r\n\r\n<p><img alt=\"\" src=\"http://assets.kompas.com/crop/0x0:780x390/780x390/data/photo/2017/11/16/2107291696.jpg\" /></p>\r\n\r\n<p>Permasalahan lainnya adalah longsoran badan jalan karena ketika dilebarkan tidak dibuat drainase, seperti di wilayah &nbsp;&nbsp;Sukabumi dan Cianjur. Di kedua wilayah tersebut masyarakat juga menggunakan bahu jalan untuk berdagang sehingga menutup&nbsp; drainase.</p>\r\n\r\n<p>&ldquo;Kami mengharapkan dukungan dari pemda terkait pedagang kaki lima ini. Kami kesulitan untuk menertibakannya. jika terjadi longsor akibat tidak ada&nbsp; drainase&nbsp; mengakibatkan dana perbaikan yang lebih besar pula,&rdquo; jelas&nbsp; Budi.</p>\r\n\r\n<p>Pada Tahun 2017 PJN 2 Jabar dipercaya mengelola anggaran sebesar Rp 450 miliar yang dipakai untuk pelebaran dan rekonstruksi&nbsp; jalan. &nbsp;Tahun 2018 PJN Wilayah 2 Jabar akan mendapatkan tambahan ruas Soreang, akses Waduk Jatigede, dan Cikijing - Batas Jateng.</p>\r\n\r\n<p>&ldquo;Akan mendapat dana Rp 500 milia di 2018. Jadi nanti akan ada hampir 1.000 kilometer, setelah ditambah 3 ruas baru, yang berada di PJN 2 Jabar,&rdquo; kata Budi.</p>\r\n\r\n<p>Sementara untuk jembatan, menurut Budi, saat ini dalam kondisi yang memprihatinkan karena peralihan status jalan kabupaten menjadi provinsi kemudian jalan nasional hanya dalam konteks administrasi saja. Sedangkan kondisi struktur jembatannya masih di bawah standar jalan nasional. Karena jembatan di ruas jalan nasional seyogyanya harus bisa dilewati kendaraan kecil dan besar.</p>\r\n\r\n<p>Untuk penanganannya ada beberapa titik jembatan yang dilakukan pemeliharaan berkala, &nbsp;bahkan lakukan&nbsp; penggantian seperti&nbsp; Jembatan Cibaruyan. Menurut Budi, banyak jembatan di wilayah kerjanya yang sudah tua karena dibangun pada tahun&nbsp; 1980-an. &ldquo;Kita juga membutuhkan beberapa duplikasi jembatan. Kami juga&nbsp; memerlukan beberapa duplikasi jembatan tetapi untuk tahun 2018 kami diminta&nbsp; agar menjaga jembatan yang ada untuk fungsional dulu,&rdquo; katanya.</p>\r\n','Penanganan infrastruktur jalan selalu dilakukan sepanjang tahun. Baik pembangunan jalan baru,  hingga pemeliharaan jalan yang sudah terbangun dari kerusakan. ','infrastruktur, advertorial',7,2,NULL,NULL,NULL,1510845732,1510845732,1,1,0),(15,1,2,'Hampir Tiga Hari di Bawah Reruntuhan, Bayi Iran Ditemukan Selamat',NULL,NULL,'<p><img alt=\"\" src=\"http://assets.kompas.com/crop/0x7:781x528/750x500/data/photo/2017/11/16/1663452091.png\" /></p>\r\n\r\n<p><strong>TEHERAN, KOMPAS.com -</strong> Tim penyelamat berhasil mengeluarkan seorang bayi yang ditemukan masih hidup di bawah reruntuhan bangunan pasca-gempa di perbatasan Iran dengan Irak.</p>\r\n\r\n<p>Bayi itu ditemukan pada Rabu (15/11/2017) pagi di antara reruntuhan bangunan di kota Sarpol-e Zahab, atau dua setengah hari usai terjadinya gempa berkekuatan 7,3 skala richter yang menewaskan lebih dari 400 jiwa.</p>\r\n\r\n<p>Sebuah foto yang menampilkan bayi yang selamat itu tengah tersenyum langsung menyebar dengan cepat melalui media sosial di antara warga Iran.</p>\r\n\r\n<p><strong>Baca juga:</strong> <a href=\"http://internasional.kompas.com/read/2017/11/14/12013461/korban-selamat-gempa-iran-irak-sudah-dua-malam-tidur-tanpa-atap\" target=\"_blank\">Korban Selamat Gempa Iran-Irak Sudah Dua Malam Tidur Tanpa Atap</a></p>\r\n\r\n<p>Warga pun menyebut bayi tersebut sebagai sebuah keajaiban dan memberi harapan usai terjadinya tragedi.</p>\r\n\r\n<p>Dilansir dari <em>The Independent</em>, upaya penyelamatan terus dilakukan untuk mencari para korban selamat hingga Kamis (16/11/2017).</p>\r\n\r\n<p>Namun semakin hari makin sedikit korban selamat yang bisa ditemukan dalam keadaan selamat.</p>\r\n\r\n<p>Di kota mayoritas Kurdi di Sarpol-e Zahab, salah satu yang paling terdampak, rumah sakit lapangan merawat korban luka.</p>\r\n\r\n<p>Tenda didirikan bagi lebih dari 70.000 warga yang kehilangan tempat tinggal berlindung dari cuaca dingin.</p>\r\n\r\n<p>Para korban masih memerlukan bantuan untuk tempat berlindung, selimut, pakaian anak-anak, obat-obatan dan tempat menyimpan air minum.</p>\r\n\r\n<p>Baca juga : <a href=\"http://internasional.kompas.com/read/2017/11/14/07573511/gempa-iran-irak-jumlah-korban-tewas-tembus-445-dan-7000-luka-luka\" target=\"_blank\">Gempa Iran-Irak: Jumlah Korban Tewas Tembus 445 dan 7.000 Luka-luka</a></p>\r\n','Tim penyelamat berhasil mengeluarkan seorang bayi yang ditemukan masih hidup di bawah reruntuhan bangunan pasca-gempa di perbatasan Iran dengan Irak.','gempa, internasional',7,2,NULL,NULL,NULL,1510845879,1510845879,1,1,0),(16,21,2,'Pengganti Indra Sjafri Sudah Disiapkan PSSI',NULL,NULL,'<p><img alt=\"\" src=\"https://assets-a1.bolasport.com/assets/new_uploaded/images/medium_380bab4e5caaf5ce8b845570928992fc.jpg\" /></p>\r\n\r\n<p><strong><strong>BOLASPORT.COM - Ketua Umum PSSI, Edy Rahmayadi, sudah menyiapkan pengganti Indra Sjafri sebagai pelatih timnas U-19 Indonesia.</strong></strong></p>\r\n\r\n<p>Namun Edy tidak mau memberitahukan siapa pelatih yang akan menggantikan <a href=\"http://bolasport.com/tag/indra-sjafri\">Indra Sjafri</a>.</p>\r\n\r\n<p>Edy hanya mengatakan nasib <a href=\"http://bolasport.com/tag/indra-sjafri\">Indra Sjafri</a> sudah di ujung kaki.</p>\r\n\r\n<p>Hal itu sesuai dengan kegagalan Timnas U-19 di Piala AFF U-18 dan Kualifikasi Piala Asia U-19 beberapa waktu lalu.</p>\r\n\r\n<p>Ucapan Edy lebih memandang terkait perfoma timnas Italia yang gagal melaju ke Piala Dunia 2018 di bawah asuhan Giampiero Ventura.</p>\r\n\r\n<p><strong>(Baca Juga: <a href=\"https://superball.bolasport.com/read/timnas/timnas-u22/184357-ungkapan-m-arfan-usai-jalani-debut-bersama-timnas-u23-indonesia\">Ungkapan M Arfan Usai Jalani Debut Bersama Timnas U-23 Indonesia</a>)</strong></p>\r\n\r\n<p>Menurut Edy, federasi sepak bola Italia saja berani memecat pelatih yang sudah gagal membawa Gli Azzuri ke Rusia.</p>\r\n\r\n<p>&quot;Kalau menurut anda, <a href=\"http://bolasport.com/tag/indra-sjafri\">Indra Sjafri</a> masih cocok apa tidak?,&quot; kata Edy selepas pertandingan Timnas U-23 Indonesia kontra Timnas U-23 Suriah di Stadion Wibawa Mukti, Cikarang, Jawa Barat, Kamis (16/11/2017).</p>\r\n\r\n<p>&quot;Italia saja sudah langsung dipecat itu. Nasib dia bukan lagi di ujung tanduk tapi di ujung kaki,&quot; ucap Edy menambahkan.</p>\r\n','Ketua Umum PSSI, Edy Rahmayadi, sudah menyiapkan pengganti Indra Sjafri sebagai pelatih timnas U-19 Indonesia.','timnas',7,2,NULL,NULL,NULL,1510846682,1510846682,1,1,0),(17,21,2,'China Open 2017 - Indonesia Punya 3 Wakil pada Perempat Final',NULL,NULL,'<p><img alt=\"\" src=\"https://assets-a1.bolasport.com/assets/new_uploaded/images/medium_bb74a293fcd809d00364ee30371efa7b.jpg\" /></p>\r\n\r\n<p><strong>Indonesia dipastikan mempunyai tiga wakil pada babak perempat final turnamen China Open 2017 setelah pasangan ganda campuran Tontowi Ahmad/Liliyana Natsir meraih kemenangan pada babak kedua.</strong></p>\r\n\r\n<p>Tontowi/Liliyana yang berstatus juara bertahan menjaga peluang meraih titel setelah menundukkan wakil Jerman, Mark Lamsfuss/Isabel Herttrich, 21-13, 18-21, 21-11, di Haixia Olympic Sports Center, Fuzhou, China, Kamis (16/11/2017).</p>\r\n\r\n<p>Mereka menyusul jejak dua pasangan ganda putra nasional, Marcus Fernaldi Gideon/Kevin Sanjaya Sukamuljo dan Mohammad Ahsan/Rian Agung Saputro, yang sudah lebih dulu menggenggam tiket putaran delapan besar.</p>\r\n\r\n<p><strong>(Baca juga: <a href=\"https://www.bolasport.com/read/olimpik/bulu-tangkis/short.bolasport.com/MiNZq\" target=\"_blank\">China Open 2017 - Jonatan Christie: Seandainya Saya Lebih Tenang...</a>)</strong></p>\r\n\r\n<p>Sementara itu, pebulu tangkis tunggal putra <a href=\"http://bolasport.com/tag/jonatan-christie\">Jonatan Christie</a> gagal melangkah jauh setelah dikalahkan Ng Ka Long Angus (Hong Kong) melalui permainan dua gim.</p>\r\n\r\n<p>Hasil tersebut menjadi anti-klimaks dari performa apik Jonatan saat mengalahkan pemain papan atas dunia sekaligus wakil tuan rumah, Lin Dan, pada babak kesatu.</p>\r\n\r\n<p><strong>(Baca juga: <a href=\"https://www.bolasport.com/read/olimpik/bulu-tangkis/short.bolasport.com/349yB\" target=\"_blank\">China Open 2017 - Terhenti di Babak Kedua, Siapa Sangka Jonatan Christie dan Anthony Ginting Punya 3 Kesamaan Ini</a>)</strong></p>\r\n\r\n<p>Berikut hasil lengkap pertandingan wakil Indonesia pada babak kedua <a href=\"http://bolasport.com/tag/china-open\">China Open</a> 2017.</p>\r\n\r\n<p>Ganda putra</p>\r\n\r\n<p><strong>Marcus Fernaldi Gideon/Kevin Sanjaya Sukamuljo (1)</strong> vs Lee Jhe-Huei/Lee Yang (TPE): 29-27, 21-18</p>\r\n\r\n<p><strong>Mohammad Ahsan/Rian Agung Saputro</strong> vs Kim Astrup/Anders Skaarup Rasmussen (DEN): 23-21, 19-21, 21-11</p>\r\n\r\n<p>Tunggal putra</p>\r\n\r\n<p><a href=\"http://bolasport.com/tag/jonatan-christie\">Jonatan Christie</a> vs <strong>Ng Ka Long Angus (HKG)</strong>: 15-21, 18-21</p>\r\n\r\n<p>Ganda campuran</p>\r\n\r\n<p><strong><a href=\"http://bolasport.com/tag/tontowi-ahmad\">Tontowi Ahmad</a>/<a href=\"http://bolasport.com/tag/liliyana-natsir\">Liliyana Natsir</a> (2)</strong> vs Mark Lamsfuss/Isabel Herttrich (GER) 21-13, 18-21, 21-11</p>\r\n','Indonesia dipastikan mempunyai tiga wakil pada babak perempat final turnamen China Open 2017 setelah pasangan ganda campuran Tontowi Ahmad/Liliyana Natsir meraih kemenangan pada babak kedua.','bulutangkis, olahraga',7,2,NULL,NULL,NULL,1510846759,1510846759,1,1,0),(18,16,2,'Timnas Italia Mencari Sosok Thor',NULL,NULL,'<p><img alt=\"\" src=\"https://assets-a1.bolasport.com/assets/new_uploaded/images/medium_1409ea760d3755915e9baaafe733693e.jpg\" /></p>\r\n\r\n<p>Ragnarok dalam mitologi norse berarti <em>The Doom of the Gods</em> alias kejatuhan para dewa.</p>\r\n\r\n<p>Momen yang mengakhiri siklus kemistisan atau kedewaan mereka. Kosmos hancur dan pada akhirnya dilahirkan kembali.</p>\r\n\r\n<p>Bagi yang belum menonton film <a href=\"http://bolasport.com/tag/thor\">Thor</a>: Ragnarok, ada baiknya langsung lompat ke tujuh paragraf selanjutnya karena mengandung <em>spoiler</em>.</p>\r\n\r\n<p>Sekali lagi, <em>spoiler alert</em>!</p>\r\n\r\n<p>Dalam film <a href=\"http://bolasport.com/tag/thor\">Thor</a>: Ragnarok, Marvel memodifikasi mitologi tersebut. Odin ternyata punya anak lain bernama Hela.</p>\r\n\r\n<p>Hela adalah dewi kematian yang merupakan anak pertama Odin.</p>\r\n\r\n<p>Hela selama ini disembunyikan karena terlalu ambisius dan berbahaya, bahkan <a href=\"http://bolasport.com/tag/thor\">Thor</a> dan Loki tak tahu keberadaan sang kakak.</p>\r\n\r\n<p><strong>(Baca Juga: <a href=\"https://www.bolasport.com/read/ole/timnas/217624-timnas-indonesia-bakal-hadapi-peserta-piala-dunia-2018-di-stadion-utama-gelora-bung-karno\" target=\"_blank\">Timnas Indonesia Bakal Hadapi Peserta Piala Dunia 2018 di Stadion Utama Gelora Bung Karno</a>)</strong></p>\r\n\r\n<p>Hela mengambil alih kendali Asgard dan sembari mencoba mencari Heimdall, pemegang kunci Bitfrost, agar dirinya bisa mengarungi angkasa demi menguasai delapan realms lain, termasuk midgard alias bumi.</p>\r\n\r\n<p><a href=\"http://bolasport.com/tag/thor\">Thor</a> ingin mencegah hal tersebut dan akhirnya harus berhadapan dengan Hela.</p>\r\n\r\n<p>Satu-satunya cara agar Hela musnah adalah dengan menghancurkan Asgard karena Hela menyerap kekuatan yang dimiliki Asgard.</p>\r\n\r\n<p>Asgard pun hancur yang berarti Ragnarok telah terjadi.</p>\r\n\r\n<p>Dari Asgardian tersisa yang berhasil menyelamatkan diri, <a href=\"http://bolasport.com/tag/thor\">Thor</a> mencoba membangun ulang kejayaan Asgard.</p>\r\n\r\n<p>Rasanya terdengar serupa dengan timnas <a href=\"http://bolasport.com/tag/italia\">Italia</a> yang saat ini sedang dalam titik terendah setelah gagal ke Piala Dunia untuk pertama kalinya sejak 1958.</p>\r\n\r\n<p><strong>(Baca Juga: <a href=\"https://www.bolasport.com/read/ole/liga-1/218059-serius-hadapi-musim-depan-bhayangkara-jalani-pramusim-di-china\" target=\"_blank\">Serius Hadapi Musim Depan, Bhayangkara Jalani Pramusim di China</a>)</strong></p>\r\n\r\n<p><strong><img alt=\"\" src=\"https://assets-a1.bolasport.com/assets/new_uploaded/images/medium_8202504f04f96475d20589d1c7b5ff28.jpg\" /></strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Media <a href=\"http://bolasport.com/tag/italia\">Italia</a> sampai menyebut terjadi apocalypse, kiamat, alias ragnarok.</p>\r\n\r\n<p>Seperti ragnarok, sejumlah &quot;dewa&quot; dalam timnas <a href=\"http://bolasport.com/tag/italia\">Italia</a> memutuskan pensiun dari timnas karena kiamat ini.</p>\r\n','Mumpung masih terasa euforia film \"Thor: Ragnarok\", saya ingin mengaitkan makna ragnarok dengan kejadian yang baru saja menimpa sepak bola Italia.','italia, olahraga',7,2,NULL,NULL,NULL,1510846904,1510846904,1,1,0),(19,2,1,'Honda PCX Hibrida dan Listrik Sudah Finalisasi',NULL,NULL,'<p><img alt=\"\" src=\"http://assets.kompas.com/crop/0x0:900x600/750x500/data/photo/2017/11/16/2651945755.jpg\" /></p>\r\n\r\n<p><strong>Bandung, KompasOtomotif </strong>&ndash; Pengembangan Honda PCX berteknologi hibrida dan listrik, sudah masuk tahap finalisasi. Sebelum dijual di Indonesia, rencananya generasi baru skutik maxi itu bakal diproduksi dan dijual di Jepang terlebih dahulu.</p>\r\n\r\n<p>PCX hibrida dan listrik pertama kali diperkenalkan di Tokyo Motor Show (TMS) yang dibuka pada bulan lalu. Teknologi listrik bisa jadi dianggap lumrah, namun yang bikin heboh adalah hibrida pada PCX, sebab dipercaya selama ini belum ada motor produksi massal seperti itu di dunia.</p>\r\n\r\n<p>&ldquo;Yang dipajang di TMS itu adalah produk global dan &lsquo;setiap&rsquo; negara akan memproduksinya. Sekarang tinggal harganya berapa. Kedua produk itu akan ada di Jepang dan diproduksi di Indonesia dan sekarang sudah masuk finalisasi,&rdquo; ucap Thomas Wijaya, Direktur Pemasaran Astra Honda Motor (AHM), di Bandung, Rabu (15/11/2017).</p>\r\n\r\n<p>Sudah diketahui sebelumnya, AHM berencana memproduksi PCX hibrida dan listrik pada tahun depan. Namun, selain mengungkap kata &ldquo;finalisasi&rdquo;, Thomas tidak mau mengomentari banyak soal hal itu.</p>\r\n\r\n<p>Baca:&nbsp;<a href=\"http://otomotif.kompas.com/read/2017/11/13/072200315/honda-mau-pcx-jadi-motor-hibrida-pertama-di-indonesia\" target=\"_blank\">Honda Mau PCX Jadi Motor Hibrida Pertama di Indonesia</a></p>\r\n\r\n<p>Pihak AHM sudah menyatakan sebelumnya ingin PCX menjadi model hibrida pertama di Indonesia. Teknologi itu jadi modal serius buat menantang pesaingnya, Yamaha NMAX.</p>\r\n','Pengembangan Honda PCX berteknologi hibrida dan listrik, sudah masuk tahap finalisasi.','honda, kendaraan',7,2,NULL,NULL,NULL,1510847017,1510847017,1,1,0),(20,2,2,'Marquez Akui Sempat Remehkan Dovizioso',NULL,NULL,'<p><img alt=\"\" src=\"http://assets.kompas.com/crop/0x0:798x532/750x500/data/photo/2017/10/21/2151542078.jpg\" /></p>\r\n\r\n<p><strong>Valencia, KompasOtomotif &ndash; </strong>Musim <a href=\"http://indeks.kompas.com/tag/MotoGP\" target=\"_blank\">MotoGP</a> 2017 sudah selesai dan pebalap muda Honda <a href=\"http://indeks.kompas.com/tag/Marc-Marquez\" target=\"_blank\">Marc Marquez</a>, berhasil menjadi jawara dunia. Terlepas dari soal juara, ada cerita lain yang jadi catatan pebalap Spanyol itu musim ini, yaitu terkait rivalnya Andrea Dovizioso.</p>\r\n\r\n<p>Marquez menyebut kalau dirinya sempat meremehkan dan tak pernah membayangkan, kalau Dovizioso akan menjadi rival beratnya di ajang balap bergengsi ini. Ini menjadi pesan sendiri bagi Marquez untuk selalu berhati-hati.</p>\r\n\r\n<p>&quot;Tahun ini, ketika orang-orang bertanya kepada saya, siapa lawan yang paling berbahaya, saya selalu mengatakan Maverick Vinales, Dani Pedrosa, Valentino Rossi, dan mungkin Jorge Lorenzo, tapi saya tidak pernah mengatakan Dovizioso,&quot; ujar Marquez mengutip <em><a href=\"https://www.motorsport.com/motogp/news/marquez-admits-he-underestimated-dovizioso-978984/\" rel=\"nofollow\" target=\"_blank\">Motorsport.com</a></em>, Kamis (16/11/2017).</p>\r\n\r\n<p><img alt=\"\" src=\"http://assets.kompas.com/crop/0x0:1000x667/750x500/data/photo/2017/06/11/1104602163.jpg\" /></p>\r\n\r\n<p>Baca juga : <a href=\"http://otomotif.kompas.com/read/2017/11/16/110200815/marquez-tercepat-di-hari-kedua-tes-pramusim-di-valencia\" target=\"_blank\">Marquez Tercepat di Hari Kedua Tes Pramusim di Valencia</a></p>\r\n\r\n<p>&quot;Ini adalah sesuatu yang saya pelajari tahun ini, harus berhati-hati dan mencoba memperhatikan semua orang. Pada awal musim ini sepertinya Maverick adalah pemain tercepat, tapi yang ternyata paling konsisten dan lengkap untuk memperebutkan gelar adalah Dovi, dan sangat menyenangkan berkompetisi dengannya,&quot; ucap Marquez.</p>\r\n\r\n<p>Meski bersaing di trek, Marquez menyebutkan dirinya dan Dovizioso memiliki hubungan baik.</p>\r\n\r\n<p>&quot;Dia adalah teman di paddock. Walaupun saat kami berada di trek, tidak ada yang namanya teman di mana kerap beradu <em>fairing</em>, beradu siku, dan berkompetisi 100 persen. Namun di luar itu kami tetap saling menghormati,&rdquo; kata Marquez.</p>\r\n\r\n<p>&quot;Dovizioso sebenarnya layak juga berada di tempat saya sebagai juara, karena dia melakukan musim ini dengan luar biasa,&quot; kata pebalap berusia 24 tahun tersebut.</p>\r\n','Musim MotoGP 2017 sudah selesai dan pebalap muda Honda Marc Marquez, berhasil menjadi jawara dunia. ','motogp, otomotif',7,2,NULL,NULL,NULL,1510847098,1510847098,1,1,0);

/*Table structure for table `tx_category` */

DROP TABLE IF EXISTS `tx_category`;

CREATE TABLE `tx_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `label` varchar(20) DEFAULT NULL,
  `sequence` int(11) DEFAULT NULL,
  `description` text,
  `time_line` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `category_name_UNIQUE` (`title`),
  KEY `FK_tx_category_time_line` (`time_line`),
  CONSTRAINT `FK_tx_category_time_line` FOREIGN KEY (`time_line`) REFERENCES `tx_lookup` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

/*Data for the table `tx_category` */

insert  into `tx_category`(`id`,`title`,`label`,`sequence`,`description`,`time_line`,`create_time`,`update_time`,`create_by`,`update_by`,`verlock`) values (1,'Informasi','Blue',0,'oke deh test 1 3 4',NULL,NULL,1507048416,NULL,1,0),(2,'Warta Sekolah',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,0),(3,'Mukaddimah',NULL,2,NULL,NULL,NULL,NULL,NULL,NULL,0),(11,'Essay',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,0),(12,'Puisi',NULL,2,NULL,NULL,NULL,NULL,NULL,NULL,0),(13,'Cerita',NULL,3,NULL,NULL,NULL,NULL,NULL,NULL,0),(14,'Drama',NULL,4,NULL,NULL,NULL,NULL,NULL,NULL,0),(15,'Wawancara',NULL,5,NULL,NULL,NULL,NULL,NULL,NULL,0),(16,'Jurnal',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,0),(21,'Olah Raga',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,0);

/*Table structure for table `tx_collector` */

DROP TABLE IF EXISTS `tx_collector`;

CREATE TABLE `tx_collector` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `area_id` int(11) DEFAULT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `description` tinytext,
  `create_time` int(11) DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `verlock` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tx_collector_staff` (`staff_id`),
  KEY `FK_tx_collector_area` (`area_id`),
  CONSTRAINT `FK_tx_collector_area` FOREIGN KEY (`area_id`) REFERENCES `tx_area` (`id`),
  CONSTRAINT `FK_tx_collector_staff` FOREIGN KEY (`staff_id`) REFERENCES `tx_staff` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tx_collector` */

/*Table structure for table `tx_comment` */

DROP TABLE IF EXISTS `tx_comment`;

CREATE TABLE `tx_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `blog_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL COMMENT 'author',
  `author` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `content` text NOT NULL,
  `publish_status` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tx_comment_content` (`blog_id`),
  KEY `FK_tx_comment_lookup` (`publish_status`),
  CONSTRAINT `FK_tx_comment_blog` FOREIGN KEY (`blog_id`) REFERENCES `tx_blog` (`id`),
  CONSTRAINT `FK_tx_comment_publish` FOREIGN KEY (`publish_status`) REFERENCES `tx_lookup` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `tx_comment` */

/*Table structure for table `tx_content` */

DROP TABLE IF EXISTS `tx_content`;

CREATE TABLE `tx_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `theme_id` int(11) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `token` varchar(5) DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `label` varchar(100) DEFAULT NULL,
  `file_name` varchar(300) DEFAULT NULL,
  `content` text,
  `description` tinytext,
  `verlock` bigint(20) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `layout_code_UNIQUE` (`token`),
  KEY `FK_tx_content_theme` (`theme_id`),
  CONSTRAINT `FK_tx_content_theme` FOREIGN KEY (`theme_id`) REFERENCES `tx_theme` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=latin1;

/*Data for the table `tx_content` */

insert  into `tx_content`(`id`,`theme_id`,`title`,`token`,`icon`,`label`,`file_name`,`content`,`description`,`verlock`,`create_time`,`update_time`,`create_by`,`update_by`) values (1,1,'Logo 1','001','','','S2EiYDhgeGNIN1WtmRyRGmeClQE0hq3q.jpg','','Logo 1',0,NULL,NULL,NULL,NULL),(2,1,'Logo 2','002',NULL,NULL,'-',NULL,'Logo 2',0,NULL,NULL,NULL,NULL),(3,1,'SEO Description','011',NULL,NULL,'-',NULL,'SEO Description',0,NULL,NULL,NULL,NULL),(4,1,'SEO Keyword','012',NULL,NULL,'-',NULL,'SEO Keyword',0,NULL,NULL,NULL,NULL),(5,2,'Main Image','100','','','-','','Home Slider - transparent2.png null',0,NULL,NULL,NULL,NULL),(6,2,'Button','101','','','-','<p>Launch</p>\r\n','Home Slider - LAYER NR. 1',0,NULL,NULL,NULL,NULL),(7,2,'Image 900 x 600','102','','','MuDjkdesMw_NhJi7MlEeuNloPV4yv4Ze.jpg','','Home Slider - LAYER NR. 2',0,NULL,NULL,NULL,NULL),(8,2,'Projects','107','','','-','<p>PROJECTS</p>\r\n','Home Slider - LAYER NR. 7',0,NULL,NULL,NULL,NULL),(9,2,'The beauty of nature','108','','','-','<p>The beauty of nature is hidden in details.</p>\r\n','Home Slider - LAYER NR. 8',0,NULL,NULL,NULL,NULL),(11,2,'Creative ideas','154','<i class=\"icon-education-141 u-line-icon-pro\"></i>','','-','<p>We strive to embrace and drive change in our industry which allows us to keep our clients relevant.</p>\r\n','About - Icon Block',1,NULL,1512488959,NULL,1),(12,2,'What people say','155','','','-','<p>What people say</p>\r\n','About - Team Container',0,NULL,NULL,NULL,NULL),(13,2,'Daniel Ramirez','156','','Designer','rXkUUvURGmaj3Och0Q_NIKS3ZIavgpJI.jpg','<p>I am an ambitious workaholic, but apart from that, pretty simple person. Understanding who you are and what you want is my strategy for your brand. I am always figuring out ways to capture your vision, so people can get on board.</p>\r\n','About - Team Container',1,NULL,1512485848,NULL,1),(14,2,'Projects','103','','','-','<p>PROJECTS</p>\r\n','Home Slider - LAYER NR. 3',0,NULL,NULL,NULL,NULL),(15,2,'The force of nature.','104','','','-','<p>The force of nature felt in waves crashing.</p>\r\n','Home Slider - LAYER NR. 4',0,NULL,NULL,NULL,NULL),(16,2,'Image 900 x 600','105','','','UFS1w_FTWSHCdZ0LF-pFDzH9y4QEQQen.jpg','','Home Slider - LAYER NR. 5',0,NULL,NULL,NULL,NULL),(18,2,'We Are Unify','151','','','-','<p>We are <strong>Unify </strong>a creative studio focusing on culture, luxury, editorial &amp; art. Somewhere between sophistication and simplicity.</p>\r\n','About - Promo Block',0,NULL,NULL,NULL,NULL),(19,2,'Extensive documentation','152','<i class=\"icon-education-087 u-line-icon-pro\"></i>','','-','<p>We strive to embrace and drive change in our industry which allows us to keep our clients relevant.</p>\r\n','About - Icon Block',1,NULL,1512488795,NULL,1),(21,2,'Button','106','','','/uploads/web/img59382f536bc44.jpg','<p>Launch</p>\r\n','Home Slider - LAYER NR. 6',0,NULL,NULL,NULL,NULL),(22,2,'Modern design','153','<i class=\"icon-education-035 u-line-icon-pro\"></i>','','/uploads/web/img59382ff6324fb.jpg','<p>We strive to embrace and drive change in our industry which allows us to keep our clients relevant.</p>\r\n','About - Icon Block',1,NULL,1512488903,NULL,1),(23,2,'Sara Anderson','157','','Developer','k6VKVBaGEmUdLvkDv2CbY_QzdAbonb5P.jpg','<p>I am an ambitious workaholic, but apart from that, pretty simple person. Understanding who you are and what you want is my strategy for your brand. I am always figuring out ways to capture your vision, so people can get on board.</p>\r\n','About - Team Container	',1,NULL,1512485875,NULL,1),(24,2,'Popularised','158','','','KGuWYJPokN8Gp_FeCsKep4KkWemvQIa9.jpg','<p>Ipsum passages</p>\r\n','About - Gallery',1,NULL,1512486818,NULL,1),(25,2,'Dictumst','159','','','2NvZDMzXkEhN02D1ksc0PEydqikydjKt.jpg','<p>Habitasse platea</p>\r\n','About - Gallery	',1,NULL,1512486843,NULL,1),(26,2,'Simply dummy','160','','','WtHssA_0uqlb7QFcYojVzIxH-3rIdzCo.jpg','<p>Electronic typesetting</p>\r\n','About - Gallery',1,NULL,1512486849,NULL,1),(32,1,'Deskripsi Bawah','006','','','-','','-',0,NULL,NULL,NULL,NULL),(39,1,'Footer Links','007',NULL,NULL,'-','<ul>\r\n	<li><a href=\"http://www.escyber.com\">www.escyber.com</a></li>\r\n</ul>\r\n',NULL,0,NULL,NULL,NULL,NULL),(40,1,'Facebook','021','<i class=\"fa fa-facebook\"></i>',NULL,'-',NULL,NULL,0,NULL,NULL,NULL,NULL),(41,1,'Skype','022','<i class=\"fa fa-skype\"></i>',NULL,'-',NULL,NULL,0,NULL,NULL,NULL,NULL),(42,1,'Google Plus','023','<i class=\"fa fa-google-plus\"></i>',NULL,'-',NULL,NULL,0,NULL,NULL,NULL,NULL),(43,1,'Linkedin','024','<i class=\"fa fa-linkedin\"></i>',NULL,'-',NULL,NULL,0,NULL,NULL,NULL,NULL),(44,1,'Pinterest','025','<i class=\"fa fa-pinterest\"></i>',NULL,'-',NULL,NULL,0,NULL,NULL,NULL,NULL),(45,1,'Twitter','026','<i class=\"fa fa-twitter\"></i>',NULL,'-',NULL,NULL,0,NULL,NULL,NULL,NULL),(46,1,'Dribbble','027','<i class=\"fa fa-dribbble\"></i>',NULL,'-',NULL,NULL,0,NULL,NULL,NULL,NULL),(47,1,'Profile','005',NULL,NULL,'/uploads/web/img5985a8c7b0133.jpg',NULL,'-',0,NULL,NULL,NULL,NULL),(48,2,'Terms & Conditions','131','','',NULL,'<p><span style=\"background-color:#ffffff; color:#555555; font-family:&quot;Open Sans&quot;,Helvetica,Arial,sans-serif; font-size:14px\">This is where we sit down, grab a cup of coffee and dial in the details. Understanding the task at hand and ironing out the wrinkles is key. Now that we&#39;ve aligned the details, it&#39;s time to get things mapped out and organized. This part is really crucial in keeping the project in line to completion.</span></p>\r\n','Terms',0,NULL,NULL,NULL,NULL),(49,2,'License','132','','',NULL,'<p style=\"text-align:start\">This is where we sit down, grab a cup of coffee and dial in the details. Understanding the task at hand and ironing out the wrinkles is key. Now that we&#39;ve aligned the details, it&#39;s time to get things mapped out and organized. This part is really crucial in keeping the project in line to completion.</p>\r\n\r\n<p style=\"text-align:start\">Whether through commerce or just an experience to tell your brand&#39;s story, the time has come to start using development languages that fit your projects needs. Now that your brand is all dressed up and ready to party, it&#39;s time to release it to the world. By the way, let&#39;s celebrate already. We get it, you&#39;re busy and it&#39;s important that someone keeps up with marketing and driving people to your brand. We&#39;ve got you covered.</p>\r\n','Terms',0,NULL,NULL,NULL,NULL),(50,2,'Ownership','133','','',NULL,'<p style=\"text-align:start\">This is where we sit down, grab a cup of coffee and dial in the details. Understanding the task at hand and ironing out the wrinkles is key. Now that we&#39;ve aligned the details, it&#39;s time to get things mapped out and organized. This part is really crucial in keeping the project in line to completion.</p>\r\n\r\n<p style=\"text-align:start\">Whether through commerce or just an experience to tell your brand&#39;s story, the time has come to start using development languages that fit your projects needs. Now that your brand is all dressed up and ready to party, it&#39;s time to release it to the world. By the way, let&#39;s celebrate already. We get it, you&#39;re busy and it&#39;s important that someone keeps up with marketing and driving people to your brand. We&#39;ve got you covered.</p>\r\n','Terms',0,NULL,NULL,NULL,NULL),(51,2,'Usage','134','','',NULL,'<p style=\"text-align:start\">This is where we sit down, grab a cup of coffee and dial in the details. Understanding the task at hand and ironing out the wrinkles is key. Now that we&#39;ve aligned the details, it&#39;s time to get things mapped out and organized. This part is really crucial in keeping the project in line to completion.</p>\r\n\r\n<p style=\"text-align:start\">Whether through commerce or just an experience to tell your brand&#39;s story, the time has come to start using development languages that fit your projects needs. Now that your brand is all dressed up and ready to party, it&#39;s time to release it to the world. By the way, let&#39;s celebrate already. We get it, you&#39;re busy and it&#39;s important that someone keeps up with marketing and driving people to your brand. We&#39;ve got you covered.</p>\r\n\r\n<p>&nbsp;</p>\r\n','Terms',0,NULL,NULL,NULL,NULL),(52,2,'Refunds','135','','',NULL,'<p style=\"text-align:start\">This is where we sit down, grab a cup of coffee and dial in the details. Understanding the task at hand and ironing out the wrinkles is key. Now that we&#39;ve aligned the details, it&#39;s time to get things mapped out and organized. This part is really crucial in keeping the project in line to completion.</p>\r\n\r\n<p style=\"text-align:start\">Whether through commerce or just an experience to tell your brand&#39;s story, the time has come to start using development languages that fit your projects needs. Now that your brand is all dressed up and ready to party, it&#39;s time to release it to the world. By the way, let&#39;s celebrate already. We get it, you&#39;re busy and it&#39;s important that someone keeps up with marketing and driving people to your brand. We&#39;ve got you covered.</p>\r\n','Terms',0,NULL,NULL,NULL,NULL),(53,2,'We Are Unify Agency','109','','Buy Full Version','ZgCcknjckEKZ87PayT4nNDq-BgrNjDLj.png','<p>Unify&nbsp;<strong>creative</strong>&nbsp;technology company providing key digital services. Focused on helping our clients to build a&nbsp;<strong>successful</strong>&nbsp;business on web and mobile.</p>\r\n\r\n<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#39;t look even slightly believable.</p>\r\n','Home',0,NULL,NULL,NULL,NULL),(54,2,'Focused on Product','110','','Buy Full Version','85Z23__sXkgHbp9JonYCDZRmSCnxm9ke.png','<p>Unify&nbsp;<strong>creative</strong>&nbsp;technology company providing key digital services. Focused on helping our clients to build a&nbsp;<strong>successful</strong>&nbsp;business on web and mobile.</p>\r\n\r\n<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#39;t look even slightly believable.</p>\r\n','Home',0,NULL,NULL,NULL,NULL),(55,2,'Solution For Web','111','','Buy Full Version','knqeCtptDJEc0qJE3ySFOIowikA7sVMm.png','<p>Unify&nbsp;<strong>creative</strong>&nbsp;technology company providing key digital services. Focused on helping our clients to build a&nbsp;<strong>successful</strong>&nbsp;business on web and mobile.</p>\r\n\r\n<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#39;t look even slightly believable.</p>\r\n','Home',0,NULL,NULL,NULL,NULL),(56,2,'Our Vision and Mission','112','','Buy Full Version','xhhgeTZGb57JWiJ7GnPTbgErXO0rPvg6.png','<p>Unify&nbsp;<strong>creative</strong>&nbsp;technology company providing key digital services. Focused on helping our clients to build a&nbsp;<strong>successful</strong>&nbsp;business on web and mobile.</p>\r\n\r\n<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#39;t look even slightly believable.</p>\r\n','Home',0,NULL,NULL,NULL,NULL),(57,2,'Variations of Passages','113','','Buy Full Version','pDmI6yDsWVKFaH3cpGE99wEJ0gmrri2d.png','<p>Unify&nbsp;<strong>creative</strong>&nbsp;technology company providing key digital services. Focused on helping our clients to build a&nbsp;<strong>successful</strong>&nbsp;business on web and mobile.</p>\r\n\r\n<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#39;t look even slightly believable.</p>\r\n','Home',0,NULL,NULL,NULL,NULL),(58,2,'Key Digital Services','114','','Buy Full Version','ljK0AIuJJafnZ-YqMs2xqdc2XtVKcIzT.png','<p>Unify&nbsp;<strong>creative</strong>&nbsp;technology company providing key digital services. Focused on helping our clients to build a&nbsp;<strong>successful</strong>&nbsp;business on web and mobile.</p>\r\n\r\n<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#39;t look even slightly believable.</p>\r\n','Home',0,NULL,NULL,NULL,NULL),(59,2,'Invest To Us','115','<i class=\"icon-finance-226 u-line-icon-pro\"></i>','',NULL,'<p>We strive to embrace and drive change in our industry which allows us to keep our clients relevant.</p>\r\n','Home - Icon Block',0,NULL,NULL,NULL,NULL),(60,2,'Increase Income','116','<i class=\"icon-finance-196 u-line-icon-pro\"></i>','',NULL,'<p>We strive to embrace and drive change in our industry which allows us to keep our clients relevant.</p>\r\n','Home - Icon Block',0,NULL,NULL,NULL,NULL),(61,2,'Collect Cash','117','<i class=\"icon-finance-147 u-line-icon-pro\"></i>','',NULL,'<p>We strive to embrace and drive change in our industry which allows us to keep our clients relevant.</p>\r\n','Home - Icon Block',0,NULL,NULL,NULL,NULL);

/*Table structure for table `tx_counter` */

DROP TABLE IF EXISTS `tx_counter`;

CREATE TABLE `tx_counter` (
  `id` varchar(8) NOT NULL,
  `counter` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `tx_counter` */

/*Table structure for table `tx_customer` */

DROP TABLE IF EXISTS `tx_customer`;

CREATE TABLE `tx_customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `area_id` int(11) DEFAULT NULL,
  `village_id` int(11) DEFAULT NULL,
  `customer_number` varchar(10) DEFAULT NULL,
  `identity_number` varchar(50) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `gender_lookup` int(11) DEFAULT NULL,
  `address` tinytext,
  `phone` varchar(50) DEFAULT NULL,
  `date_issued` int(11) DEFAULT NULL,
  `description` tinytext,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `customer_number_UNIQUE` (`customer_number`),
  KEY `FK_tx_customer_area` (`area_id`),
  KEY `FK_tx_customer_gender_lookup` (`gender_lookup`),
  KEY `FK_tx_customer_village` (`village_id`),
  CONSTRAINT `FK_tx_customer_area` FOREIGN KEY (`area_id`) REFERENCES `tx_area` (`id`),
  CONSTRAINT `FK_tx_customer_gender_lookup` FOREIGN KEY (`gender_lookup`) REFERENCES `tx_lookup` (`id`),
  CONSTRAINT `FK_tx_customer_village` FOREIGN KEY (`village_id`) REFERENCES `tx_village` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tx_customer` */

/*Table structure for table `tx_dashblock` */

DROP TABLE IF EXISTS `tx_dashblock`;

CREATE TABLE `tx_dashblock` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `actions` text,
  `weight` int(11) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(4) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `tx_dashblock` */

/*Table structure for table `tx_employment` */

DROP TABLE IF EXISTS `tx_employment`;

CREATE TABLE `tx_employment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `description` text,
  `sequence` tinyint(4) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `job_title_name_UNIQUE` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `tx_employment` */

insert  into `tx_employment`(`id`,`title`,`description`,`sequence`,`create_time`,`update_time`,`create_by`,`update_by`,`verlock`) values (2,'Administrasi','-',NULL,1441114705,1441114705,1,NULL,0),(3,'Guru','-',NULL,1441114738,1441114738,1,NULL,0),(4,'Siswa','-',NULL,1441638718,1441638718,1,NULL,0);

/*Table structure for table `tx_enrolment` */

DROP TABLE IF EXISTS `tx_enrolment`;

CREATE TABLE `tx_enrolment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `network_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `title` varchar(10) DEFAULT NULL,
  `date_effective` int(11) DEFAULT NULL,
  `billing_cycle` varchar(2) DEFAULT NULL,
  `month_period` varchar(6) DEFAULT NULL,
  `description` tinytext,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `customer_id_UNIQUE` (`customer_id`),
  UNIQUE KEY `title_UNIQUE` (`title`),
  KEY `FK_tx_enrolment_node` (`network_id`),
  CONSTRAINT `FK_tx_enrolment_customer` FOREIGN KEY (`customer_id`) REFERENCES `tx_customer` (`id`),
  CONSTRAINT `FK_tx_enrolment_network` FOREIGN KEY (`network_id`) REFERENCES `tx_network` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tx_enrolment` */

/*Table structure for table `tx_event` */

DROP TABLE IF EXISTS `tx_event`;

CREATE TABLE `tx_event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) DEFAULT NULL,
  `date_start` int(11) DEFAULT NULL,
  `date_end` int(11) DEFAULT NULL,
  `location` tinytext,
  `description` text,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `tx_event` */

insert  into `tx_event`(`id`,`title`,`date_start`,`date_end`,`location`,`description`,`create_time`,`update_time`,`create_by`,`update_by`,`verlock`) values (1,'test',1510441200,1511650800,'yaaa','okreee',1507263342,1507270281,1,1,0),(2,'wtert',1506895200,1506981600,'5','asdfasdf',1507271106,1507271539,1,1,0);

/*Table structure for table `tx_gmap` */

DROP TABLE IF EXISTS `tx_gmap`;

CREATE TABLE `tx_gmap` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL,
  `latitude` varchar(30) DEFAULT NULL,
  `longitude` varchar(30) DEFAULT NULL,
  `description` tinytext,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tx_gmap_customer` (`customer_id`),
  CONSTRAINT `FK_tx_gmap_customer` FOREIGN KEY (`customer_id`) REFERENCES `tx_customer` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tx_gmap` */

/*Table structure for table `tx_gmap_detail` */

DROP TABLE IF EXISTS `tx_gmap_detail`;

CREATE TABLE `tx_gmap_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gmap_id` int(11) DEFAULT NULL,
  `latitude` varchar(30) DEFAULT NULL,
  `longitude` varchar(30) DEFAULT NULL,
  `description` tinytext,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tx_gmap_detail_gmap` (`gmap_id`),
  CONSTRAINT `FK_tx_gmap_detail_gmap` FOREIGN KEY (`gmap_id`) REFERENCES `tx_gmap` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tx_gmap_detail` */

/*Table structure for table `tx_import_attribute` */

DROP TABLE IF EXISTS `tx_import_attribute`;

CREATE TABLE `tx_import_attribute` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `import_data_id` int(11) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL COMMENT 'column title',
  `column_index` int(11) DEFAULT NULL,
  `conversion` int(11) DEFAULT NULL,
  `description` tinytext,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tx_import_attribute_import` (`import_data_id`),
  CONSTRAINT `FK_tx_import_attribute_import` FOREIGN KEY (`import_data_id`) REFERENCES `tx_import_data` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=286 DEFAULT CHARSET=latin1;

/*Data for the table `tx_import_attribute` */

insert  into `tx_import_attribute`(`id`,`import_data_id`,`title`,`column_index`,`conversion`,`description`,`create_time`,`update_time`,`create_by`,`update_by`,`verlock`) values (15,3,'id',0,1,'',1514568693,1534772662,1,1,10),(16,3,'title',1,1,'',1514568693,1534772662,1,1,10),(17,3,'description',2,1,'',1514568693,1534772662,1,1,10),(18,3,'create_time',3,1,'',1514568693,1534772662,1,1,10),(19,3,'update_time',4,1,'',1514568693,1534772662,1,1,10),(20,3,'create_by',5,1,'',1514568693,1534772662,1,1,10),(21,3,'update_by',6,1,'',1514568693,1534772662,1,1,10),(22,4,'id',0,1,'',1514707687,1534772726,1,1,21),(23,4,'area_id',2,1,'',1514707687,1534772726,1,1,21),(25,4,'customer_number',3,5,'',1514707941,1534772726,1,1,20),(26,4,'identity_number',4,1,'',1514707941,1534772726,1,1,20),(27,4,'title',5,1,'',1514707941,1534772726,1,1,20),(28,4,'gender_lookup',6,4,'',1514707941,1534772726,1,1,20),(29,4,'address',8,1,'',1514707941,1534772726,1,1,20),(30,4,'phone',10,1,'',1514707941,1534772726,1,1,20),(31,4,'date_issued',11,1,'',1514707941,1534772726,1,1,20),(33,4,'description',9,1,'',1514707941,1534772726,1,1,20),(34,4,'create_time',13,1,'',1514707941,1534772726,1,1,20),(35,4,'update_time',14,1,'',1514707941,1534772726,1,1,20),(36,4,'create_by',15,1,'',1514707941,1534772726,1,1,20),(37,4,'update_by',16,1,'',1514707941,1534772726,1,1,20),(38,5,'id',0,1,'',1514824776,1534772667,1,1,8),(39,5,'employment_id',1,1,'',1514824776,1534772667,1,1,8),(40,5,'title',3,1,'',1514824776,1534772667,1,1,8),(41,5,'identity_number',2,1,'',1514824776,1534772667,1,1,8),(42,5,'phone_number',4,1,'',1514824776,1534772667,1,1,8),(43,5,'gender_lookup',5,4,'',1514824776,1534772667,1,1,8),(44,5,'address',6,1,'',1514824776,1534772667,1,1,8),(45,5,'description',7,1,'',1514824776,1534772667,1,1,8),(46,5,'create_time',10,1,'',1514824776,1534772667,1,1,8),(47,5,'update_time',11,1,'',1514824776,1534772667,1,1,8),(48,5,'create_by',12,1,'',1514824776,1534772667,1,1,8),(49,5,'update_by',13,1,'',1514824923,1534772667,1,1,7),(50,6,'network_id',1,1,'',1515262993,1534772807,1,1,11),(51,6,'customer_id',0,1,'',1515262993,1534772807,1,1,11),(52,6,'title',3,5,'customer_number',1515262993,1534772807,1,1,11),(53,6,'billing_cycle',12,8,'',1515262993,1534772807,1,1,11),(54,6,'create_time',13,1,'',1515262993,1534772807,1,1,11),(55,6,'update_time',14,1,'',1515262993,1534772807,1,1,11),(56,6,'create_by',15,1,'',1515262993,1534772807,1,1,11),(57,6,'update_by',16,1,'',1515262994,1534772807,1,1,11),(58,7,'id',0,1,'',1515267255,1534773147,1,1,31),(59,7,'customer_id',1,1,'',1515267255,1534773147,1,1,31),(60,7,'staff_id',2,1,'',1515267255,1534773147,1,1,31),(61,7,'title',3,6,'source : invoice',1515267255,1534773147,1,1,31),(62,7,'invoice',4,6,'source : installation number',1515267255,1534773147,1,1,31),(63,7,'date_issued',7,1,'',1515267255,1534773147,1,1,31),(64,7,'billing_status',10,4,'',1515267255,1534773147,1,1,31),(65,7,'month_period',11,1,'',1515267255,1534773147,1,1,31),(66,7,'claim',9,1,'',1515267255,1534773147,1,1,31),(67,7,'create_time',13,1,'',1515267255,1534773147,1,1,31),(68,7,'update_time',14,1,'',1515267255,1534773147,1,1,31),(69,7,'create_by',15,1,'',1515267255,1534773147,1,1,31),(70,7,'update_by',16,1,'',1515267255,1534773147,1,1,31),(71,8,'id',0,1,'',1515425270,1534773530,1,1,8),(73,8,'outlet_id',2,1,'',1515425270,1534773530,1,1,8),(74,8,'assembly_cost',4,1,'',1515425270,1534773530,1,1,8),(75,8,'monthly_bill',5,1,'',1515425270,1534773530,1,1,8),(76,8,'device_type',6,4,'',1515425270,1534773530,1,1,8),(77,8,'device_status',7,4,'',1515425270,1534773530,1,1,8),(78,8,'description',3,3,'date_activation',1515425270,1534773530,1,1,8),(79,8,'create_time',9,1,'',1515425270,1534773530,1,1,8),(80,8,'update_time',10,1,'',1515425270,1534773530,1,1,8),(81,8,'create_by',11,1,'',1515425270,1534773530,1,1,8),(82,8,'update_by',12,1,'',1515425270,1534773530,1,1,8),(83,7,'date_assembly',6,1,'',1515425653,1534773147,1,1,30),(84,7,'assembly_type',5,4,'installation type',1515425653,1534773147,1,1,30),(85,9,'id',0,1,'',1515682006,1534773978,1,1,31),(86,9,'customer_id',1,1,'',1515682006,1534773978,1,1,31),(87,9,'title',2,6,'invoice',1515682006,1534773978,1,1,31),(88,9,'invoice',3,6,'reference',1515682006,1534773978,1,1,31),(89,9,'amount',4,1,'',1515682006,1534773978,1,1,31),(90,9,'date_issued',5,1,'',1515682006,1534773978,1,1,31),(91,9,'date_due',6,1,'',1515682006,1534773978,1,1,31),(92,9,'month_period',7,1,'',1515682006,1534773978,1,1,31),(93,9,'billing_type',8,4,'',1515682006,1534773978,1,1,31),(94,9,'payment_status',9,4,'',1515682006,1534773978,1,1,31),(96,9,'create_time',11,1,'',1515682006,1534773978,1,1,31),(97,9,'update_time',12,1,'',1515682006,1534773978,1,1,31),(98,9,'create_by',13,1,'',1515682006,1534773978,1,1,31),(99,9,'update_by',14,1,'',1515682006,1534773978,1,1,31),(115,6,'date_effective',11,1,'date issued',1517678255,1534772807,1,1,7),(116,8,'customer_id',1,1,'',1517757268,1534773530,1,1,5),(117,11,'id',0,1,'',1518332181,1534772570,1,1,3),(118,11,'token',1,1,'',1518332181,1534772570,1,1,3),(119,11,'title',3,1,'',1518332182,1534772570,1,1,3),(120,11,'description',4,1,'',1518332182,1534772570,1,1,3),(121,11,'create_time',5,1,'',1518332182,1534772570,1,1,3),(122,11,'update_time',6,1,'',1518332182,1534772571,1,1,3),(123,11,'create_by',7,1,'',1518332182,1534772571,1,1,3),(124,11,'update_by',8,1,'',1518332182,1534772571,1,1,3),(125,12,'id',0,1,'',1518333760,1534772657,1,1,7),(126,12,'title',1,1,'',1518333760,1534772657,1,1,7),(127,12,'description',2,1,'',1518333760,1534772657,1,1,7),(128,12,'create_time',3,1,'',1518333760,1534772657,1,1,7),(129,12,'update_time',4,1,'',1518333760,1534772657,1,1,7),(130,12,'create_by',5,1,'',1518333760,1534772657,1,1,7),(131,12,'update_by',6,1,'',1518333760,1534772657,1,1,7),(132,13,'id',0,1,'',1518340027,1534773910,1,1,13),(133,13,'validity_id',5,9,'base on month period ',1518340028,1534773910,1,1,13),(134,13,'customer_id',1,1,'',1518340028,1534773910,1,1,13),(135,13,'title',2,1,'',1518340028,1534773910,1,1,13),(136,13,'device_status',7,4,'',1518340028,1534773910,1,1,13),(137,13,'billing_status',8,4,'',1518340028,1534773910,1,1,13),(138,13,'date_due',4,1,'',1518340028,1534773910,1,1,13),(139,13,'amount',3,1,'',1518340028,1534773910,1,1,13),(140,13,'month_period',5,1,'',1518340028,1534773910,1,1,13),(141,13,'description',6,1,'',1518340028,1534773910,1,1,13),(142,13,'create_time',9,1,'',1518340028,1534773910,1,1,13),(143,13,'update_time',10,1,'',1518340028,1534773910,1,1,13),(144,13,'create_by',11,1,'',1518340028,1534773910,1,1,13),(145,13,'update_by',12,1,'',1518340028,1534773910,1,1,13),(146,14,'id',0,1,'',1518446851,1534772878,1,1,2),(147,14,'customer_id',1,1,'',1518446852,1534772878,1,1,2),(148,14,'latitude',2,1,'',1518446852,1534772878,1,1,2),(149,14,'longitude',3,1,'',1518446852,1534772878,1,1,2),(150,14,'description',4,1,'',1518446852,1534772878,1,1,2),(151,14,'create_time',5,1,'',1518446852,1534772878,1,1,2),(152,14,'create_by',6,1,'',1518446852,1534772878,1,1,2),(153,14,'update_time',7,1,'',1518446852,1534772878,1,1,2),(154,14,'update_by',8,1,'',1518446852,1534772878,1,1,2),(155,15,'id',0,1,'',1518447096,1534772887,1,1,2),(156,15,'gmap_id',1,1,'',1518447096,1534772887,1,1,2),(157,15,'latitude',2,1,'',1518447096,1534772888,1,1,2),(158,15,'longitude',3,1,'',1518447096,1534772888,1,1,2),(159,15,'description',4,1,'',1518447096,1534772888,1,1,2),(160,15,'create_time',5,1,'',1518447096,1534772888,1,1,2),(161,15,'update_time',6,1,'',1518447096,1534772888,1,1,2),(162,15,'create_by',7,1,'',1518447096,1534772888,1,1,2),(163,15,'update_by',8,1,'',1518447096,1534772888,1,1,2),(164,16,'id',0,1,'',1518449305,1534774016,1,1,8),(165,16,'customer_id',2,1,'',1518449305,1534774016,1,1,8),(166,16,'staff_id',3,1,'',1518449306,1534774016,1,1,8),(167,16,'title',1,1,'invoice',1518449306,1534774016,1,1,8),(168,16,'invoice',4,6,'receivable_number',1518449306,1534774016,1,1,8),(169,16,'date_issued',5,1,'',1518449306,1534774016,1,1,8),(170,16,'month_period',6,1,'',1518449306,1534774016,1,1,8),(171,16,'description',7,1,'',1518449306,1534774016,1,1,8),(172,16,'claim',8,1,'',1518449306,1534774016,1,1,8),(173,16,'surcharge',9,1,'',1518449306,1534774016,1,1,8),(174,16,'penalty',10,1,'',1518449306,1534774016,1,1,8),(175,16,'total',11,1,'',1518449306,1534774017,1,1,8),(176,16,'discount',13,1,'',1518449306,1534774017,1,1,8),(177,16,'payment',14,1,'',1518449306,1534774017,1,1,8),(178,16,'balance',15,1,'',1518449306,1534774017,1,1,8),(179,16,'create_time',16,1,'',1518449306,1534774017,1,1,8),(180,16,'update_time',17,1,'',1518449306,1534774017,1,1,8),(181,16,'create_by',18,1,'',1518449306,1534774017,1,1,8),(182,16,'update_by',19,1,'',1518449306,1534774017,1,1,8),(183,17,'id',0,1,'',1518449591,1534774027,1,1,2),(184,17,'receivable_id',1,1,'',1518449591,1534774027,1,1,2),(186,17,'billing_id',2,1,'',1518449591,1534774027,1,1,2),(188,17,'date_due',4,1,'',1518449591,1534774027,1,1,2),(189,17,'overdue',5,1,'',1518449591,1534774027,1,1,2),(190,17,'overdue_status',6,4,'',1518449591,1534774027,1,1,2),(192,17,'claim',7,1,'',1518449591,1534774027,1,1,2),(193,17,'total',7,1,'',1518449591,1534774027,1,1,2),(194,17,'payment',8,1,'',1518449591,1534774027,1,1,2),(195,17,'balance',9,1,'',1518449591,1534774027,1,1,2),(200,18,'id',0,1,'',1518450192,1534774066,1,1,8),(201,18,'customer_id',1,1,'',1518450192,1534774066,1,1,8),(202,18,'staff_id',5,1,'',1518450192,1534774066,1,1,8),(203,18,'title',2,1,'',1518450192,1534774066,1,1,8),(204,18,'invoice',2,1,'',1518450192,1534774066,1,1,8),(205,18,'date_issued',3,1,'',1518450192,1534774066,1,1,8),(206,18,'description',6,1,'',1518450192,1534774066,1,1,8),(207,18,'create_time',7,1,'',1518450192,1534774066,1,1,8),(208,18,'update_time',4,1,'date effective',1518450192,1534774066,1,1,8),(209,18,'create_by',9,1,'',1518450192,1534774066,1,1,8),(210,18,'update_by',10,1,'',1518450192,1534774066,1,1,8),(211,19,'id',0,1,'',1518450363,1534774081,1,1,6),(212,19,'service_id',1,1,'',1518450363,1534774081,1,1,6),(213,19,'outlet_detail_id',2,1,'',1518450363,1534774081,1,1,6),(214,19,'service_type_id',3,10,'',1518450363,1534774081,1,1,6),(215,19,'device_status',3,11,'',1518450363,1534774081,1,1,6),(221,20,'id',0,1,'',1518616825,1534772953,1,1,4),(222,20,'staff_id',2,1,'',1518616825,1534772953,1,1,4),(223,20,'date_issued',3,1,'',1518616825,1534772953,1,1,4),(224,20,'title',1,6,'',1518616825,1534772953,1,1,4),(225,20,'month_period',4,1,'',1518616825,1534772953,1,1,4),(226,20,'description',5,1,'',1518616825,1534772953,1,1,4),(227,20,'claim',6,1,'',1518616825,1534772953,1,1,4),(228,20,'surcharge',7,1,'',1518616825,1534772953,1,1,4),(229,20,'penalty',8,1,'',1518616825,1534772953,1,1,4),(230,20,'total',9,1,'',1518616825,1534772953,1,1,4),(231,20,'discount',10,1,'',1518616826,1534772953,1,1,4),(232,20,'payment',11,1,'',1518616826,1534772953,1,1,4),(233,20,'balance',12,1,'',1518616826,1534772953,1,1,4),(234,20,'create_time',13,1,'',1518616826,1534772953,1,1,4),(235,20,'create_by',14,1,'',1518616826,1534772953,1,1,4),(236,20,'update_time',15,1,'',1518616826,1534772953,1,1,4),(237,20,'update_by',16,1,'',1518616826,1534772953,1,1,4),(238,21,'id',0,1,'',1518616968,1534772955,1,1,6),(239,21,'account_payable_id',1,1,'',1518616968,1534772955,1,1,6),(240,21,'account_id',2,1,'',1518616968,1534772955,1,1,6),(241,21,'invoice',3,1,'',1518616968,1534772955,1,1,6),(242,21,'amount',4,1,'',1518616968,1534772955,1,1,6),(248,22,'id',0,1,'',1518617193,1534773008,1,1,2),(249,22,'staff_id',1,1,'',1518617193,1534773008,1,1,2),(250,22,'date_issued',3,1,'',1518617193,1534773008,1,1,2),(251,22,'title',2,1,'',1518617193,1534773008,1,1,2),(252,22,'month_period',4,1,'',1518617193,1534773008,1,1,2),(253,22,'description',5,1,'',1518617193,1534773008,1,1,2),(254,22,'claim',6,1,'',1518617193,1534773008,1,1,2),(255,22,'surcharge',7,1,'',1518617193,1534773008,1,1,2),(256,22,'penalty',8,1,'',1518617193,1534773008,1,1,2),(257,22,'total',9,1,'',1518617193,1534773008,1,1,2),(258,22,'discount',10,1,'',1518617193,1534773008,1,1,2),(259,22,'payment',11,1,'',1518617193,1534773008,1,1,2),(260,22,'balance',12,1,'',1518617193,1534773008,1,1,2),(261,22,'create_time',13,1,'',1518617193,1534773008,1,1,2),(262,22,'update_time',14,1,'',1518617193,1534773008,1,1,2),(263,22,'create_by',15,1,'',1518617193,1534773008,1,1,2),(264,22,'update_by',16,1,'',1518617193,1534773008,1,1,2),(265,23,'id',0,1,'',1518617340,1534773013,1,1,2),(266,23,'account_receivable_id',1,1,'',1518617340,1534773013,1,1,2),(267,23,'account_id',2,1,'',1518617341,1534773013,1,1,2),(268,23,'invoice',3,1,'',1518617341,1534773013,1,1,2),(269,23,'amount',4,1,'',1518617341,1534773013,1,1,2),(275,24,'id',0,1,'',1518617474,1534772613,1,1,3),(276,24,'account_type_id',1,1,'',1518617474,1534772613,1,1,3),(277,24,'token',2,1,'',1518617474,1534772613,1,1,3),(278,24,'title',3,1,'',1518617474,1534772613,1,1,3),(279,24,'description',6,1,'',1518617474,1534772613,1,1,3),(280,24,'create_time',7,1,'',1518617474,1534772613,1,1,3),(281,24,'update_time',8,1,'',1518617474,1534772613,1,1,3),(282,24,'create_by',9,1,'',1518617474,1534772613,1,1,3),(283,24,'update_by',10,1,'',1518617474,1534772613,1,1,3),(284,6,'month_period',11,12,'from date issued = date effective',1526664762,1534772807,1,1,4),(285,18,'month_period',4,12,'date effective',1526664871,1534774066,1,1,2);

/*Table structure for table `tx_import_data` */

DROP TABLE IF EXISTS `tx_import_data`;

CREATE TABLE `tx_import_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `modul_type` int(11) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `row_start` int(11) DEFAULT NULL,
  `row_end` int(11) DEFAULT NULL,
  `file_name` varchar(100) DEFAULT NULL,
  `description` tinytext,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

/*Data for the table `tx_import_data` */

insert  into `tx_import_data`(`id`,`modul_type`,`title`,`row_start`,`row_end`,`file_name`,`description`,`create_time`,`update_time`,`create_by`,`update_by`,`verlock`) values (3,10,'node.xlsx',1,5000,'XvXwMlIGRMNTDTszCa9Xa0PtlBBtBdJ8.xlsx','-',1514568693,1534772683,1,1,19),(4,12,'customer - enrolment.xlsx',1,20,'D1tsZF2vHKfkUTYAEXLkiFqU21p-jYOY.xlsx','update customer set area_id = 1 where area_id is null',1514707687,1534772738,1,1,28),(5,11,'staff.xlsx',1,5000,'dcdkr7Xb2LVGngk618_7zCupyHY8Digq.xlsx','-',1514824776,1534772692,1,1,15),(6,13,'customer - enrolment.xlsx',1,20,'rVjhlbonrmkNUv8mx4N2vGqduSDdS49h.xlsx','-',1515262993,1534772814,1,1,20),(7,25,'outlet.xlsx',1,20,'UBb3vq7-98zyKTAASKbL1qDOv7uZZFjz.xlsx','UPDATE tx_installation SET staff_id = 1 WHERE staff_id IS NULL OR staff_id = 0;',1515267255,1534773499,1,1,49),(8,26,'outlet detail.xlsx',1,20,'gHcYRyDpMB2J3w0YVzbhm8Y_c7jT6HSg.xlsx','file outlet.xlsx',1515425270,1534773672,1,1,16),(9,29,'billing-000.xlsx',1,20,'r0flCB_nfhaVu99Fr2RWA5dEaUeQZ8n6.xlsx','data 1- 20000\r\ndata 20001- 40000\r\ndata 40001- 60000\r\ndata 60001- 90000',1515682006,1534773987,1,1,42),(11,1,'account type.xlsx',1,5000,'4ngAcw86N9KCchUzUDxIvLQvvEMFEHWs.xlsx','',1518332181,1534772588,1,1,6),(12,5,'area.xlsx',1,5000,'06ttA6H_o2Xdv-5p7Z2eQ0TC_bfHlMOT.xlsx','tambah area : (ID = 1, Nama Area = NA)',1518333760,1534772672,1,1,16),(13,28,'validity detail.xlsx',1,20,'p8Sy5BFIsz03NEAvv2JVjvKlmsOT0Dd3.xlsx','data 1- 5000\r\ndata 5001 - 10000\r\ndata 10001- 15000\r\ndata 15001- 20000',1518340027,1534773919,1,1,18),(14,15,'gmap.xlsx',1,20,'ASOYBHEMDqTczD86Odr5LtxaL-yZCs83.xlsx','',1518446851,1534772894,1,1,5),(15,16,'gmap detail - waypoint.xlsx',1,20,'YUsYhubFneg6Oy2kjzGMC9MKZ85MLeVs.xlsx','',1518447096,1534772901,1,1,5),(16,30,'receivable-000.xlsx',1,20,'3cb4bYQm0kml5UxWQWXOQO2w1mJTm9sS.xlsx','-',1518449305,1534774032,1,1,12),(17,31,'receivable detail-000.xlsx',1,20,'kKOCoF5lPdBbFdkt-ZyypcZlKYNSwhHO.xlsx','',1518449591,1534774044,1,1,5),(18,32,'service.xlsx',1,20,'CDPk9Yc300lw9KK69Y_a69cyeHRWF_C0.xlsx','UPDATE tx_service SET staff_id = 1 WHERE staff_id IS NULL OR staff_id = 0;',1518450192,1534774075,1,1,14),(19,33,'service detail.xlsx',1,5000,'TKSa1Z6rM1Ua9T2IDaMVVtPN72lQQZHV.xlsx','ambil date effective nya dari master service, bagian update_time',1518450363,1534774081,1,1,10),(20,21,'account payable.xlsx',1,20,'Tt9ihf0dJB6Jy2J5v7x_t4Qh4qXTFdvx.xlsx','',1518616825,1534772963,1,1,8),(21,22,'account payable detail.xlsx',1,20,'c3_1BK3PaiL1_o6124XvGoxSRa5ZrX7J.xlsx','',1518616968,1534772975,1,1,11),(22,23,'account receivable.xlsx',1,20,'yRAl5HAOpoMSVbTqbBUD0bRO5SZ12LNf.xlsx','-',1518617193,1534773029,1,1,5),(23,24,'account receivable detail.xlsx',1,20,'ob1Tu3YsfT2TLe3viRXiWECBsklybstU.xlsx','-',1518617340,1534773079,1,1,6),(24,2,'account.xlsx',1,5000,'GeIHtbeLzY7HV8bF0r9E4NNv3KVGOO45.xlsx','-',1518617474,1534772627,1,1,6);

/*Table structure for table `tx_lookup` */

DROP TABLE IF EXISTS `tx_lookup`;

CREATE TABLE `tx_lookup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `token` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `category` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sequence` int(11) DEFAULT NULL,
  `editable` tinyint(4) DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `verlock` bigint(20) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `token_UNIQUE` (`token`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `tx_lookup` */

insert  into `tx_lookup`(`id`,`title`,`token`,`category`,`sequence`,`editable`,`description`,`verlock`,`create_time`,`update_time`,`create_by`,`update_by`) values (1,'NA','XNA','NA',0,0,'Not Available',0,NULL,NULL,NULL,NULL),(2,'No','XNO','YesNo',0,0,'-',0,NULL,NULL,NULL,NULL),(3,'Yes','YES','YesNo',1,0,'',0,NULL,NULL,NULL,NULL),(4,'Private','PRI','PrivatePublic',0,0,'-',0,NULL,NULL,NULL,NULL),(5,'Public','PBC','PrivatePublic',1,0,'-',0,NULL,NULL,NULL,NULL),(6,'Draft','DRF','DraftPublish',0,0,'-',0,NULL,NULL,NULL,NULL),(7,'Publish','PBH','DraftPublish',1,0,'-',0,NULL,NULL,NULL,NULL),(8,'Approved','APR','Approval',0,0,'-',0,NULL,NULL,NULL,NULL),(9,'Rejected','REJ','Approval',1,0,'-',0,NULL,NULL,NULL,NULL),(10,'Pending','PEN','Approval',2,0,'-',0,NULL,NULL,NULL,NULL),(11,'Male','MLE','Gender',0,0,'-',0,NULL,NULL,NULL,NULL),(12,'Female','FML','Gender',1,0,'-',0,NULL,NULL,NULL,NULL),(13,'Account Receivable','ARX','Record',0,1,'Record Account Receivable',2,1512658746,1514888879,1,1),(14,'Account Payable','APX','Record',1,1,'Record Account Payable',2,1512658788,1514888885,1,1),(15,'Customer','CST','Counter',0,0,'Counter for customer number ',0,1514534687,1514534687,1,1),(16,'Outlet','OTX','Record',NULL,0,'Record Outlet',0,1514888608,1514888608,1,1),(17,'Billing','BLX','Record',NULL,0,'Record Billing',0,1514888773,1514888773,1,1),(18,'Receivable','RCV','Record',NULL,0,'Record Receivable',0,1514888864,1514888864,1,1),(19,'Service','SRV','Record',NULL,0,'Record Service',0,1514889300,1514889300,1,1),(20,'Pasang Baru','ANW','AssemblyType',0,0,'Assembly - New',1,1514907574,1514997851,1,1),(21,'Pasang Pindah','AMV','AssemblyType',1,0,'Assembly - Moving',0,1514907704,1514907704,1,1),(22,'Hutang','CDT','PaymentStatus',0,0,'Credit',1,1514908319,1514997728,1,1),(23,'Cicilan','INT','PaymentStatus',1,0,'Installment',1,1514908441,1514997661,1,1),(24,'Lunas','PID','PaymentStatus',2,0,'Paid',1,1514908516,1514997667,1,1),(25,'Induk','MND','DeviceType',0,0,'Main Device',1,1514993052,1514997781,1,1),(26,'Paralel','PLD','DeviceType',1,0,'Paralel Device',1,1514993087,1514997787,1,1),(27,'Aktif','ACT','DeviceStatus',0,0,'Active',1,1514993843,1514997793,1,1),(28,'Gratis','FRE','DeviceStatus',1,0,'Free',1,1514993878,1514997797,1,1),(29,'Idle','IDL','DeviceStatus',3,0,'DC Sementara',0,1514994343,1514994343,1,1),(30,'Disconnect','DCN','DeviceStatus',4,0,'DC Permanent',1,1514994382,1514997821,1,1),(31,'Tagihan Pasang','BNW','BillingType',0,0,'Device Assembly / Tagihan Pemasangan',0,1515074673,1515074673,1,1),(32,'Tagihan Iuran','BMH','BillingType',1,0,'Monthly Installment / Iuran Bulanan',0,1515074782,1515074782,1,1),(33,'Enrolment','ERL','Counter',1,0,'Counter for customer enrolment  ',0,1515174046,1515174046,1,1),(34,'Tagihan Pindah','BMV','BillingType',3,0,'Tagihan Pasang Pindah',0,1515682557,1515682557,1,1),(35,'Pasang Paralel','APL','AssemblyType',2,0,'Assembly - Paralel',0,1517497908,1517497908,1,1),(36,'Tagihan Paralel','BPL','BillingType',2,0,'-',0,1517500825,1517500825,1,1),(37,'DC Sementara','SDT','ServiceType',0,0,'-',0,1518073576,1518073576,1,1),(38,'DC Permanen','SDP','ServiceType',1,0,'-',0,1518073645,1518073645,1,1),(39,'Sambung Kembali','SRC','ServiceType',3,0,'-',0,1518073677,1518073677,1,1),(40,'Validity Detail','VDT','Record',0,0,'-',0,1518195392,1518195392,1,1),(41,'Overdue','OVD','TimeAccuracy',0,0,'Overdue Status',0,1526402063,1526402063,1,1),(42,'On Time','OTM','TimeAccuracy',1,0,'On Time Status',0,1526402095,1526402095,1,1);

/*Table structure for table `tx_migration` */

DROP TABLE IF EXISTS `tx_migration`;

CREATE TABLE `tx_migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tx_migration` */

insert  into `tx_migration`(`version`,`apply_time`) values ('m140209_132017_init',1524068528),('m140403_174025_create_account_table',1524068531),('m140504_113157_update_tables',1524068537),('m140504_130429_create_token_table',1524068541),('m140506_102106_rbac_init',1524068617),('m140830_171933_fix_ip_field',1524068618),('m140830_172703_change_account_table_name',1524068619),('m141222_110026_update_ip_field',1524068621),('m141222_135246_alter_username_length',1524068622),('m150614_103145_update_social_account_table',1524068627),('m150623_212711_fix_username_notnull',1524068627),('m151218_234654_add_timezone_to_profile',1524068628),('m160929_103127_add_last_login_at_to_user_table',1524068630),('m170907_052038_rbac_add_index_on_auth_assignment_user_id',1524068630);

/*Table structure for table `tx_network` */

DROP TABLE IF EXISTS `tx_network`;

CREATE TABLE `tx_network` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `description` tinytext,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tx_network` */

/*Table structure for table `tx_note` */

DROP TABLE IF EXISTS `tx_note`;

CREATE TABLE `tx_note` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `note_type_id` int(11) DEFAULT NULL,
  `title` varchar(10) DEFAULT NULL,
  `description` tinytext,
  `date_issued` int(11) DEFAULT NULL,
  `date_expired` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tx_note_note_type` (`note_type_id`),
  CONSTRAINT `FK_tx_note_note_type` FOREIGN KEY (`note_type_id`) REFERENCES `tx_note_type` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `tx_note` */

insert  into `tx_note`(`id`,`note_type_id`,`title`,`description`,`date_issued`,`date_expired`,`create_time`,`update_time`,`create_by`,`update_by`,`verlock`) values (1,1,'00001','-',1512604800,1512604800,1514482094,1514482232,1,1,2);

/*Table structure for table `tx_note_type` */

DROP TABLE IF EXISTS `tx_note_type`;

CREATE TABLE `tx_note_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `description` tinytext,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `tx_note_type` */

insert  into `tx_note_type`(`id`,`title`,`description`,`create_time`,`update_time`,`create_by`,`update_by`,`verlock`) values (1,'Rusak Invoice','-',1514481421,1514481421,1,1,0);

/*Table structure for table `tx_notification` */

DROP TABLE IF EXISTS `tx_notification`;

CREATE TABLE `tx_notification` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `notification_type` int(11) DEFAULT NULL,
  `reference` int(11) DEFAULT NULL,
  `url` varchar(200) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `notify_from` varchar(100) DEFAULT NULL,
  `content` text,
  `description` text,
  `approval_status` int(11) DEFAULT NULL,
  `read_status` tinyint(4) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tx_notification_given_by` (`notify_from`),
  KEY `FK_tx_notification_lookup` (`notification_type`),
  KEY `FK_tx_notification_given_to` (`user_id`),
  KEY `FK_tx_notification_approval` (`approval_status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `tx_notification` */

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
  `google_plus` varchar(100) DEFAULT NULL,
  `instagram` varchar(100) DEFAULT NULL,
  `twitter` varchar(100) DEFAULT NULL,
  `description` tinytext,
  `facebook` varchar(100) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `tx_office` */

insert  into `tx_office`(`id`,`token`,`title`,`phone_number`,`fax_number`,`email`,`web`,`address`,`latitude`,`longitude`,`google_plus`,`instagram`,`twitter`,`description`,`facebook`,`create_time`,`update_time`,`create_by`,`update_by`,`verlock`) values (1,'007','SMAN Modal Bangsa Arun','0645 65 3247,3248,3249','0645 65 3342 ','tatausaha@modalbangsaarun.sch.id','www.modalbangsaarun.sch.id','Jl Bontang Komplek Perumahan PT. Perta Arun Gas','5.186793','97.146416',NULL,NULL,NULL,'-',NULL,1430536627,1518448417,1,1,1);

/*Table structure for table `tx_outlet` */

DROP TABLE IF EXISTS `tx_outlet`;

CREATE TABLE `tx_outlet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `title` varchar(10) DEFAULT NULL,
  `invoice` varchar(12) DEFAULT NULL,
  `date_issued` int(11) DEFAULT NULL,
  `date_assembly` int(11) DEFAULT NULL,
  `billing_status` int(11) DEFAULT NULL,
  `assembly_type` int(11) DEFAULT NULL,
  `month_period` varchar(6) DEFAULT NULL,
  `claim` decimal(18,2) DEFAULT NULL,
  `description` tinytext,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invoice_UNIQUE` (`invoice`),
  KEY `FK_tx_outlet_staff` (`staff_id`),
  KEY `FK_tx_outlet_billing_status` (`billing_status`),
  KEY `FK_tx_outlet_customer` (`customer_id`),
  KEY `FK_tx_outlet_assembly_type` (`assembly_type`),
  CONSTRAINT `FK_tx_outlet_assembly_type` FOREIGN KEY (`assembly_type`) REFERENCES `tx_lookup` (`id`),
  CONSTRAINT `FK_tx_outlet_billing_status` FOREIGN KEY (`billing_status`) REFERENCES `tx_lookup` (`id`),
  CONSTRAINT `FK_tx_outlet_customer` FOREIGN KEY (`customer_id`) REFERENCES `tx_customer` (`id`),
  CONSTRAINT `FK_tx_outlet_staff` FOREIGN KEY (`staff_id`) REFERENCES `tx_staff` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tx_outlet` */

/*Table structure for table `tx_outlet_detail` */

DROP TABLE IF EXISTS `tx_outlet_detail`;

CREATE TABLE `tx_outlet_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `outlet_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `assembly_cost` decimal(18,2) DEFAULT NULL,
  `monthly_bill` decimal(18,2) DEFAULT NULL,
  `device_type` int(11) DEFAULT NULL,
  `device_status` int(11) DEFAULT NULL,
  `description` tinytext,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tx_outlet_detail_outlet` (`outlet_id`),
  KEY `FK_tx_outlet_detail_device_type` (`device_type`),
  KEY `FK_tx_outlet_detail_device_status` (`device_status`),
  KEY `FK_tx_outlet_detail_customer` (`customer_id`),
  CONSTRAINT `FK_tx_outlet_detail_customer` FOREIGN KEY (`customer_id`) REFERENCES `tx_customer` (`id`),
  CONSTRAINT `FK_tx_outlet_detail_device_status` FOREIGN KEY (`device_status`) REFERENCES `tx_lookup` (`id`),
  CONSTRAINT `FK_tx_outlet_detail_device_type` FOREIGN KEY (`device_type`) REFERENCES `tx_lookup` (`id`),
  CONSTRAINT `FK_tx_outlet_detail_outlet` FOREIGN KEY (`outlet_id`) REFERENCES `tx_outlet` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tx_outlet_detail` */

/*Table structure for table `tx_page` */

DROP TABLE IF EXISTS `tx_page`;

CREATE TABLE `tx_page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_type_id` int(11) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `sequence` int(11) DEFAULT NULL,
  `description` tinytext,
  `content` text,
  `view_counter` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
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
  `description` tinytext,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tx_page_type` */

/*Table structure for table `tx_photo` */

DROP TABLE IF EXISTS `tx_photo`;

CREATE TABLE `tx_photo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `album_id` int(11) NOT NULL,
  `title` varchar(200) DEFAULT NULL,
  `file_name` varchar(200) DEFAULT NULL,
  `description` text,
  `url` varchar(500) DEFAULT NULL,
  `thumb` varchar(500) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `mime_type` varchar(20) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tx_photo_album` (`album_id`),
  CONSTRAINT `FK_tx_photo_album` FOREIGN KEY (`album_id`) REFERENCES `tx_album` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `tx_photo` */

/*Table structure for table `tx_product` */

DROP TABLE IF EXISTS `tx_product`;

CREATE TABLE `tx_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_type_id` int(11) DEFAULT NULL,
  `product_unit_id` int(11) DEFAULT NULL,
  `product_name` varchar(100) DEFAULT NULL,
  `content` text,
  `quantity` decimal(18,2) DEFAULT NULL,
  `total` decimal(18,2) DEFAULT NULL,
  `price` decimal(18,2) DEFAULT NULL,
  `description` tinytext,
  `cover_url` varchar(300) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tx_product_type` (`product_type_id`),
  KEY `FK_tx_product_unit` (`product_unit_id`),
  CONSTRAINT `FK_tx_product_type` FOREIGN KEY (`product_type_id`) REFERENCES `tx_product_type` (`id`),
  CONSTRAINT `FK_tx_product_unit` FOREIGN KEY (`product_unit_id`) REFERENCES `tx_product_unit` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `tx_product` */

insert  into `tx_product`(`id`,`product_type_id`,`product_unit_id`,`product_name`,`content`,`quantity`,`total`,`price`,`description`,`cover_url`,`create_time`,`update_time`,`create_by`,`update_by`,`verlock`) values (1,1,1,'Edulitera',NULL,'1.00','0.00','2000000.00','Donec id elit non mi porta gravida at eget metus. Fusce dapibus, justo sit amet risus etiam porta sem.','/uploads/product/img593af47c308ab.jpg',1497033635,1497712482,1,1,0),(2,2,1,'Vulkanisir Manajemen',NULL,'1.00','0.00','4000000.00','Donec id elit non mi porta gravida at eget metus. Fusce dapibus, justo sit amet risus etiam porta sem.',NULL,1497546549,1497546549,1,1,0),(3,1,1,'Event',NULL,'1.00','2000000.00','2000000.00','Donec id elit non mi porta gravida at eget metus. Fusce dapibus, justo sit amet risus etiam porta sem.\r\n','/uploads/product/img5942c5b90849e.jpg',1497547791,1497548223,1,1,0),(4,1,1,'EsCyber',NULL,'1.00','2000000.00','2000000.00','Donec id elit non mi porta gravida at eget metus. Fusce dapibus, justo sit amet risus etiam porta sem.',NULL,1497549274,1497549274,1,1,0);

/*Table structure for table `tx_product_feature` */

DROP TABLE IF EXISTS `tx_product_feature`;

CREATE TABLE `tx_product_feature` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `label` varchar(50) DEFAULT NULL,
  `description` tinytext,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tx_product_feature_index` (`id`),
  KEY `FK_tx_product_feature_product` (`product_id`),
  CONSTRAINT `FK_tx_product_feature_product` FOREIGN KEY (`product_id`) REFERENCES `tx_product` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `tx_product_feature` */

insert  into `tx_product_feature`(`id`,`product_id`,`title`,`icon`,`label`,`description`,`create_time`,`update_time`,`create_by`,`update_by`,`verlock`) values (2,1,'Education','<i class=\"icon-custom icon-sm rounded-x icon-bg-yellow fa fa-thumbs-o-up\"></i>',NULL,'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium',1501166943,1501513248,1,1,0),(3,1,'Hi-Tech','<i class=\"icon-custom icon-sm rounded-x icon-bg-orange fa fa-area-chart\"></i>',NULL,'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium',1501512424,1501513238,1,1,0),(4,1,'Wikipedia','<i class=\"icon-custom icon-sm rounded-x icon-bg-purple fa fa-lightbulb-o\"></i>',NULL,'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium',1501512459,1501513229,1,1,0),(5,1,'Music','<i class=\"icon-custom icon-sm rounded-x icon-bg-aqua icon-line icon-playlist\"></i>',NULL,'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium',1501512487,1501513018,1,1,0);

/*Table structure for table `tx_product_type` */

DROP TABLE IF EXISTS `tx_product_type`;

CREATE TABLE `tx_product_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_type_name` varchar(100) DEFAULT NULL,
  `description` tinytext,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `tx_product_type` */

insert  into `tx_product_type`(`id`,`product_type_name`,`description`,`create_time`,`update_time`,`create_by`,`update_by`,`verlock`) values (1,'Profile','-',1497033612,1497547016,1,1,0),(2,'Administrasi','-',1497546430,1497547042,1,1,0);

/*Table structure for table `tx_product_unit` */

DROP TABLE IF EXISTS `tx_product_unit`;

CREATE TABLE `tx_product_unit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_unit_name` varchar(100) DEFAULT NULL,
  `description` tinytext,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `tx_product_unit` */

insert  into `tx_product_unit`(`id`,`product_unit_name`,`description`,`create_time`,`update_time`,`create_by`,`update_by`,`verlock`) values (1,'Tahun','Tahun',1497033590,1497546701,1,1,0);

/*Table structure for table `tx_profile` */

DROP TABLE IF EXISTS `tx_profile`;

CREATE TABLE `tx_profile` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `public_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gravatar_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gravatar_id` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8_unicode_ci,
  `timezone` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  CONSTRAINT `tx_fk_user_profile` FOREIGN KEY (`user_id`) REFERENCES `tx_user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `tx_profile` */

insert  into `tx_profile`(`user_id`,`name`,`public_email`,`gravatar_email`,`gravatar_id`,`location`,`website`,`bio`,`timezone`,`file_name`) values (1,'Fitri','','',NULL,'','','',NULL,'AbFY42W1jgN1GxoawqSXWW1avOKHVGG_.png');

/*Table structure for table `tx_quote` */

DROP TABLE IF EXISTS `tx_quote`;

CREATE TABLE `tx_quote` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `content` text,
  `source` varchar(100) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

/*Data for the table `tx_quote` */

insert  into `tx_quote`(`id`,`title`,`content`,`source`,`create_time`,`update_time`,`create_by`,`update_by`,`verlock`) values (1,'Pramoedya Ananta Toer','Berterimakasihlah pada segala yang memberi kehidupan.','Bumi Manusia',1402579255,2147483647,NULL,1,1),(2,NULL,'Seorang terpelajar harus sudah berbuat adil sejak dalam pikiran apalagi dalam perbuatan.','Bumi Manusia',1402579302,1402579302,NULL,NULL,0),(3,NULL,'Kalau kemanusiaan tersinggung, semua orang yang berperasaan dan berfikiran waras ikut tersinggung, kecuali orang gila dan orang yang berjiwa kriminal, biarpun dia sarjana.','Bumi Manusia',1402579310,1402579310,NULL,NULL,0),(4,NULL,'Cerita tentang kesenangan selalu tidak menarik. Itu bukan cerita tentang manusia dan kehidupannya, tapi tentang surga, dan jelas tidak terjadi di atas bumi kita ini.','Bumi Manusia',1402579336,1402579336,NULL,NULL,0),(5,NULL,'Orang boleh pandai setinggi langit, tapi selama ia tidak menulis, ia akan hilang di dalam masyarakat dan dari sejarah. Menulis adalah bekerja untuk keabadian.',NULL,1402575977,1402575977,NULL,NULL,0),(6,NULL,'Kehidupan ini seimbang, Tuan. Barangsiapa hanya memandang pada keceriannya saja, dia orang gila. Barangsiapa memandang pada penderitaannya saja, dia sakit.','Anak Semua Bangsa',1402579348,1402579348,NULL,NULL,0),(7,NULL,'Orang bilang ada kekuatan-kekuatan dahsyat yang tak terduga yang bisa timbul pada samudera, pada gunung berapi dan pada pribadi yang tahu benar akan tujuan hidupnya.','Rumah Kaca',1402579354,1402579354,NULL,NULL,0),(8,NULL,'Jarang orang mau mengakui, kesederhanaan adalah kekayaan yang terbesar di dunia ini: suatu karunia alam. Dan yang terpenting diatas segala-galanya ialah keberaniannya. Kesederhaan adalah kejujuran, dan keberanian adalah ketulusan.','Mereka Yang Dilumpuhkan',1402579378,1402579378,NULL,NULL,0),(9,NULL,'Tanpa mempelajari bahasa sendiri pun orang takkan mengenal bangsanya sendiri.',NULL,1402576369,1402576369,NULL,NULL,0),(10,NULL,'Ilmu pengetahuan, Tuan-tuan, betapa pun tingginya, dia tidak berpribadi. Sehebat-hebatnya mesin, dibikin oleh sehebat-hebat manusia dia pun tidak berpribadi. Tetapi sesederhana-sederhana cerita yang ditulis, dia mewakili pribadi individu atau malahan bisa juga bangsanya. Kan begitu Tuan Jenderal?','Jejak Langkah',1402579386,1402579386,NULL,NULL,0);

/*Table structure for table `tx_receivable` */

DROP TABLE IF EXISTS `tx_receivable`;

CREATE TABLE `tx_receivable` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `title` varchar(10) DEFAULT NULL,
  `invoice` varchar(12) DEFAULT NULL,
  `date_issued` int(11) DEFAULT NULL,
  `month_period` varchar(6) DEFAULT NULL,
  `description` tinytext,
  `claim` decimal(18,2) DEFAULT NULL,
  `surcharge` decimal(18,2) DEFAULT NULL,
  `penalty` decimal(18,2) DEFAULT NULL,
  `total` decimal(18,2) DEFAULT NULL,
  `discount` decimal(18,2) DEFAULT NULL,
  `payment` decimal(18,2) DEFAULT NULL,
  `balance` decimal(18,2) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invoice_UNIQUE` (`invoice`),
  KEY `FK_tx_receivable_customer` (`customer_id`),
  KEY `FK_tx_receivable_staff` (`staff_id`),
  CONSTRAINT `FK_tx_receivable_customer` FOREIGN KEY (`customer_id`) REFERENCES `tx_customer` (`id`),
  CONSTRAINT `FK_tx_receivable_staff` FOREIGN KEY (`staff_id`) REFERENCES `tx_staff` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tx_receivable` */

/*Table structure for table `tx_receivable_detail` */

DROP TABLE IF EXISTS `tx_receivable_detail`;

CREATE TABLE `tx_receivable_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `receivable_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `billing_id` int(11) DEFAULT NULL,
  `title` varchar(10) DEFAULT NULL,
  `date_due` int(11) DEFAULT NULL,
  `overdue` int(11) DEFAULT NULL,
  `overdue_status` int(11) DEFAULT NULL COMMENT 'Yes - No Status',
  `penalty` decimal(18,2) DEFAULT NULL,
  `claim` decimal(18,2) DEFAULT NULL,
  `total` decimal(18,2) DEFAULT NULL,
  `payment` decimal(18,2) DEFAULT NULL,
  `balance` decimal(18,2) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tx_receivable_detail_receivable` (`receivable_id`),
  KEY `FK_tx_receivable_detail_billing` (`billing_id`),
  KEY `FK_tx_receivable_detail_overdue_status` (`overdue_status`),
  KEY `FK_tx_receivable_detail_customer` (`customer_id`),
  CONSTRAINT `FK_tx_receivable_detail_billing` FOREIGN KEY (`billing_id`) REFERENCES `tx_billing` (`id`),
  CONSTRAINT `FK_tx_receivable_detail_customer` FOREIGN KEY (`customer_id`) REFERENCES `tx_customer` (`id`),
  CONSTRAINT `FK_tx_receivable_detail_overdue_status` FOREIGN KEY (`overdue_status`) REFERENCES `tx_lookup` (`id`),
  CONSTRAINT `FK_tx_receivable_detail_receivable` FOREIGN KEY (`receivable_id`) REFERENCES `tx_receivable` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tx_receivable_detail` */

/*Table structure for table `tx_service` */

DROP TABLE IF EXISTS `tx_service`;

CREATE TABLE `tx_service` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `title` varchar(10) DEFAULT NULL,
  `invoice` varchar(10) DEFAULT NULL,
  `date_issued` int(11) DEFAULT NULL,
  `date_effective` int(11) DEFAULT NULL,
  `month_period` varchar(6) DEFAULT NULL,
  `description` tinytext,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tx_service_customer` (`customer_id`),
  KEY `FK_tx_service_staff` (`staff_id`),
  CONSTRAINT `FK_tx_service_customer` FOREIGN KEY (`customer_id`) REFERENCES `tx_customer` (`id`),
  CONSTRAINT `FK_tx_service_staff` FOREIGN KEY (`staff_id`) REFERENCES `tx_staff` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tx_service` */

/*Table structure for table `tx_service_detail` */

DROP TABLE IF EXISTS `tx_service_detail`;

CREATE TABLE `tx_service_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `service_id` int(11) DEFAULT NULL,
  `outlet_detail_id` int(11) DEFAULT NULL,
  `service_type_id` int(11) DEFAULT NULL,
  `device_status` int(11) DEFAULT NULL,
  `month_period` varchar(6) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tx_service_detail_service` (`service_id`),
  KEY `FK_tx_service_detail_outlet_detail` (`outlet_detail_id`),
  KEY `FK_tx_service_detail_status` (`device_status`),
  KEY `FK_tx_service_detail_service_type` (`service_type_id`),
  CONSTRAINT `FK_tx_service_detail_outlet_detail` FOREIGN KEY (`outlet_detail_id`) REFERENCES `tx_outlet_detail` (`id`),
  CONSTRAINT `FK_tx_service_detail_service` FOREIGN KEY (`service_id`) REFERENCES `tx_service` (`id`),
  CONSTRAINT `FK_tx_service_detail_service_type` FOREIGN KEY (`service_type_id`) REFERENCES `tx_service_type` (`id`),
  CONSTRAINT `FK_tx_service_detail_status` FOREIGN KEY (`device_status`) REFERENCES `tx_lookup` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tx_service_detail` */

/*Table structure for table `tx_service_type` */

DROP TABLE IF EXISTS `tx_service_type`;

CREATE TABLE `tx_service_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `description` tinytext,
  `create_time` int(11) DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `tx_service_type` */

insert  into `tx_service_type`(`id`,`title`,`description`,`create_time`,`create_by`,`update_time`,`update_by`,`verlock`) values (1,'DC Permanen','-',1518101545,1,1518622243,1,1),(2,'DC Sementara','-',1518622226,1,1518622226,1,0),(3,'Reconnect','Sambung Kembali',1518622277,1,1518622277,1,0),(4,'Gratis','Gratis',1518622402,1,1518622402,1,0);

/*Table structure for table `tx_session` */

DROP TABLE IF EXISTS `tx_session`;

CREATE TABLE `tx_session` (
  `id` char(32) NOT NULL,
  `expire` int(11) DEFAULT NULL,
  `data` longblob,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `tx_session` */

insert  into `tx_session`(`id`,`expire`,`data`) values ('78om842fc15m3i1s15t9resge4',1534266336,'__flash|a:0:{}'),('hu0re4uki1ehc6oppgg1lun0h2',1534266338,'__returnUrl|s:47:\"/application/yii2tvlangsa/backend/web/site/index\";__id|i:1;__flash|a:0:{}'),('skpro882vndhflcoilccr28ao0',1534775532,'__id|i:1;__flash|a:0:{}');

/*Table structure for table `tx_social_account` */

DROP TABLE IF EXISTS `tx_social_account`;

CREATE TABLE `tx_social_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `client_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `code` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tx_account_unique` (`provider`,`client_id`),
  UNIQUE KEY `tx_account_unique_code` (`code`),
  KEY `tx_fk_user_account` (`user_id`),
  CONSTRAINT `tx_fk_user_account` FOREIGN KEY (`user_id`) REFERENCES `tx_user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `tx_social_account` */

/*Table structure for table `tx_staff` */

DROP TABLE IF EXISTS `tx_staff`;

CREATE TABLE `tx_staff` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employment_id` int(11) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `identity_number` varchar(100) DEFAULT NULL,
  `phone_number` varchar(50) DEFAULT NULL,
  `gender_lookup` int(11) DEFAULT NULL,
  `address` tinytext,
  `file_name` varchar(200) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `google_plus` varchar(100) DEFAULT NULL,
  `instagram` varchar(100) DEFAULT NULL,
  `facebook` varchar(100) DEFAULT NULL,
  `twitter` varchar(100) DEFAULT NULL,
  `description` tinytext,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tx_staff_gender` (`gender_lookup`),
  KEY `FK_tx_staff_role` (`employment_id`),
  CONSTRAINT `FK_tx_staff_employment` FOREIGN KEY (`employment_id`) REFERENCES `tx_employment` (`id`),
  CONSTRAINT `FK_tx_staff_gender` FOREIGN KEY (`gender_lookup`) REFERENCES `tx_lookup` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `tx_staff` */

/*Table structure for table `tx_tag` */

DROP TABLE IF EXISTS `tx_tag`;

CREATE TABLE `tx_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag_name` varchar(150) NOT NULL,
  `frequency` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `tx_tag` */

/*Table structure for table `tx_theme` */

DROP TABLE IF EXISTS `tx_theme`;

CREATE TABLE `tx_theme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `description` tinytext,
  `verlock` bigint(20) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title_UNIQUE` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `tx_theme` */

insert  into `tx_theme`(`id`,`title`,`description`,`verlock`,`create_time`,`update_time`,`create_by`,`update_by`) values (1,'Global','Dipakai di semua halaman',0,NULL,NULL,NULL,NULL),(2,'Home14','Style : Unify Home14\r\nStart Code : 100',0,NULL,NULL,NULL,NULL);

/*Table structure for table `tx_token` */

DROP TABLE IF EXISTS `tx_token`;

CREATE TABLE `tx_token` (
  `user_id` int(11) NOT NULL,
  `code` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) NOT NULL,
  `type` smallint(6) NOT NULL,
  UNIQUE KEY `tx_token_unique` (`user_id`,`code`,`type`),
  CONSTRAINT `tx_fk_user_token` FOREIGN KEY (`user_id`) REFERENCES `tx_user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `tx_token` */

insert  into `tx_token`(`user_id`,`code`,`created_at`,`type`) values (1,'1L4EjnL5zntiB1WWtOQm47VsnC5zUtZK',1524234172,0);

/*Table structure for table `tx_user` */

DROP TABLE IF EXISTS `tx_user`;

CREATE TABLE `tx_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `confirmed_at` int(11) DEFAULT NULL,
  `unconfirmed_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `blocked_at` int(11) DEFAULT NULL,
  `registration_ip` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `flags` int(11) NOT NULL DEFAULT '0',
  `last_login_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tx_user_unique_username` (`username`),
  UNIQUE KEY `tx_user_unique_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `tx_user` */

insert  into `tx_user`(`id`,`username`,`email`,`password_hash`,`auth_key`,`confirmed_at`,`unconfirmed_email`,`blocked_at`,`registration_ip`,`created_at`,`updated_at`,`flags`,`last_login_at`) values (1,'admin','ombakrinai@gmail.com','$2y$12$exl6mG/cWOt.DgoW11kiKuRkPKvQ/iYFNj.6FlwHLNtk3IYq8GmoO','JpJ77Y4v9Ffj8zN5lLGb2WN9-sotAgUx',1524236211,NULL,NULL,'::1',1524234171,1524234171,0,1534772548);

/*Table structure for table `tx_validity` */

DROP TABLE IF EXISTS `tx_validity`;

CREATE TABLE `tx_validity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(6) DEFAULT NULL COMMENT 'month_period',
  `counter` int(11) DEFAULT NULL,
  `description` tinytext,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title_UNIQUE` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=latin1;

/*Data for the table `tx_validity` */

insert  into `tx_validity`(`id`,`title`,`counter`,`description`,`create_time`,`update_time`,`create_by`,`update_by`,`verlock`) values (1,'012012',NULL,NULL,1520007612,1520007612,1,1,0),(2,'022012',NULL,'Valid 0',1520007612,1520435673,1,1,2),(3,'032012',NULL,NULL,1520007612,1520007612,1,1,0),(4,'042012',NULL,NULL,1520007612,1520007612,1,1,0),(5,'052012',NULL,NULL,1520007612,1520007612,1,1,0),(6,'062012',NULL,NULL,1520007613,1520007613,1,1,0),(7,'072012',NULL,NULL,1520007613,1520007613,1,1,0),(8,'082012',NULL,NULL,1520007613,1520007613,1,1,0),(9,'092012',NULL,NULL,1520007613,1520007613,1,1,0),(10,'102012',NULL,NULL,1520007613,1520007613,1,1,0),(11,'112012',NULL,NULL,1520007613,1520007613,1,1,0),(12,'122012',NULL,NULL,1520007613,1520007613,1,1,0),(13,'012013',NULL,NULL,1520007613,1520007613,1,1,0),(14,'022013',NULL,NULL,1520007613,1520007613,1,1,0),(15,'032013',NULL,NULL,1520007614,1520007614,1,1,0),(16,'042013',NULL,NULL,1520007614,1520007614,1,1,0),(17,'052013',NULL,NULL,1520007614,1520007614,1,1,0),(18,'062013',NULL,NULL,1520007614,1520007614,1,1,0),(19,'072013',NULL,NULL,1520007614,1520007614,1,1,0),(20,'082013',NULL,NULL,1520007614,1520007614,1,1,0),(21,'092013',NULL,NULL,1520007614,1520007614,1,1,0),(22,'102013',NULL,NULL,1520007614,1520007614,1,1,0),(23,'112013',NULL,NULL,1520007614,1520007614,1,1,0),(24,'122013',NULL,NULL,1520007614,1520007614,1,1,0),(25,'012014',NULL,NULL,1520007615,1520007615,1,1,0),(26,'022014',NULL,NULL,1520007615,1520007615,1,1,0),(27,'032014',NULL,NULL,1520007615,1520007615,1,1,0),(28,'042014',NULL,NULL,1520007615,1520007615,1,1,0),(29,'052014',NULL,NULL,1520007615,1520007615,1,1,0),(30,'062014',NULL,NULL,1520007615,1520007615,1,1,0),(31,'072014',NULL,NULL,1520007615,1520007615,1,1,0),(32,'082014',NULL,NULL,1520007615,1520007615,1,1,0),(33,'092014',NULL,NULL,1520007615,1520007615,1,1,0),(34,'102014',NULL,NULL,1520007615,1520007615,1,1,0),(35,'112014',NULL,NULL,1520007616,1520007616,1,1,0),(36,'122014',NULL,NULL,1520007616,1520007616,1,1,0),(37,'012015',NULL,NULL,1520007616,1520007616,1,1,0),(38,'022015',NULL,NULL,1520007616,1520007616,1,1,0),(39,'032015',NULL,NULL,1520007616,1520007616,1,1,0),(40,'042015',NULL,NULL,1520007616,1520007616,1,1,0),(41,'052015',NULL,NULL,1520007616,1520007616,1,1,0),(42,'062015',NULL,NULL,1520007616,1520007616,1,1,0),(43,'072015',NULL,NULL,1520007616,1520007616,1,1,0),(44,'082015',NULL,NULL,1520007616,1520007616,1,1,0),(45,'092015',NULL,NULL,1520007616,1520007616,1,1,0),(46,'102015',NULL,NULL,1520007616,1520007616,1,1,0),(47,'112015',NULL,NULL,1520007616,1520007616,1,1,0),(48,'122015',NULL,NULL,1520007616,1520007616,1,1,0),(49,'012016',NULL,NULL,1520007617,1520007617,1,1,0),(50,'022016',NULL,NULL,1520007617,1520007617,1,1,0),(51,'032016',NULL,NULL,1520007617,1520007617,1,1,0),(52,'042016',NULL,NULL,1520007617,1520007617,1,1,0),(53,'052016',NULL,NULL,1520007617,1520007617,1,1,0),(54,'062016',NULL,NULL,1520007617,1520007617,1,1,0),(55,'072016',NULL,NULL,1520007617,1520007617,1,1,0),(56,'082016',NULL,NULL,1520007617,1520007617,1,1,0),(57,'092016',NULL,NULL,1520007617,1520007617,1,1,0),(58,'102016',NULL,NULL,1520007617,1520007617,1,1,0),(59,'112016',NULL,NULL,1520007617,1520007617,1,1,0),(60,'122016',NULL,NULL,1520007618,1520007618,1,1,0),(61,'012017',NULL,NULL,1520007618,1520007618,1,1,0),(62,'022017',NULL,NULL,1520007618,1520007618,1,1,0),(63,'032017',NULL,NULL,1520007618,1520007618,1,1,0),(64,'042017',NULL,NULL,1520007618,1520007618,1,1,0),(65,'052017',NULL,NULL,1520007618,1520007618,1,1,0),(66,'062017',NULL,NULL,1520007618,1520007618,1,1,0),(67,'072017',NULL,NULL,1520007618,1520007618,1,1,0),(68,'082017',NULL,NULL,1520007618,1520007618,1,1,0),(69,'092017',NULL,NULL,1520007618,1520007618,1,1,0),(70,'102017',NULL,NULL,1520007618,1520007618,1,1,0),(71,'112017',NULL,NULL,1520007619,1520007619,1,1,0),(72,'122017',NULL,'Valid 0',1520007619,1520649577,1,1,1),(73,'012018',0,'Sisa 2',1520007619,1533124546,1,1,2),(74,'022018',NULL,'Valid 2',1520007619,1520519261,1,1,1),(75,'032018',NULL,'Valid 2747 { Aktif 2472 | Gratis 19 | Idle 256 }',1520007619,1526710630,1,1,9),(76,'042018',NULL,'Valid 2756 { Aktif 2481 | Gratis 19 | Idle 256 }',1520007619,1526710378,1,1,6),(77,'052018',NULL,'Valid 2756 { Aktif 2481 | Gratis 19 | Idle 256 }',1520007619,1526710815,1,1,4),(78,'062018',2,'Total 2 | Saved : 2',1520007619,1533132786,1,1,7),(79,'072018',0,'Sisa 2',1520007619,1533124638,1,1,3),(80,'082018',2,'Pelanggan 2 | Saved : 2',1520007619,1533139463,1,1,3),(81,'092018',2,'Total 2 | Saved : 2',1520007619,1533139089,1,1,2),(82,'102018',2,'Pelanggan 2 | Saved : 2',1520007619,1533139478,1,1,3),(83,'112018',NULL,NULL,1520007619,1520007619,1,1,0),(84,'122018',NULL,NULL,1520007619,1520007619,1,1,0),(85,'012019',NULL,NULL,1520007619,1520007619,1,1,0),(86,'022019',NULL,NULL,1520007619,1520007619,1,1,0),(87,'032019',NULL,NULL,1520007620,1520007620,1,1,0),(88,'042019',NULL,NULL,1520007620,1520007620,1,1,0),(89,'052019',NULL,NULL,1520007620,1520007620,1,1,0),(90,'062019',NULL,NULL,1520007620,1520007620,1,1,0),(91,'072019',NULL,NULL,1520007620,1520007620,1,1,0),(92,'082019',NULL,NULL,1520007620,1520007620,1,1,0),(93,'092019',NULL,NULL,1520007620,1520007620,1,1,0),(94,'102019',NULL,NULL,1520007620,1520007620,1,1,0),(95,'112019',NULL,NULL,1520007620,1520007620,1,1,0),(96,'122019',NULL,NULL,1520007620,1520007620,1,1,0),(97,'012020',NULL,NULL,1520007620,1520007620,1,1,0),(98,'022020',NULL,NULL,1520007620,1520007620,1,1,0),(99,'032020',NULL,NULL,1520007620,1520007620,1,1,0),(100,'042020',NULL,NULL,1520007620,1520007620,1,1,0),(101,'052020',NULL,NULL,1520007620,1520007620,1,1,0),(102,'062020',NULL,NULL,1520007620,1520007620,1,1,0),(103,'072020',NULL,NULL,1520007621,1520007621,1,1,0),(104,'082020',NULL,NULL,1520007621,1520007621,1,1,0),(105,'092020',NULL,NULL,1520007621,1520007621,1,1,0),(106,'102020',NULL,'Valid 0',1520007621,1520436450,1,1,3),(107,'112020',NULL,NULL,1520007621,1520007621,1,1,0),(108,'122020',NULL,NULL,1520007621,1520007621,1,1,0);

/*Table structure for table `tx_validity_detail` */

DROP TABLE IF EXISTS `tx_validity_detail`;

CREATE TABLE `tx_validity_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `validity_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `title` varchar(10) DEFAULT NULL,
  `device_status` int(11) DEFAULT NULL,
  `billing_status` int(11) DEFAULT NULL,
  `date_due` int(11) DEFAULT NULL,
  `amount` decimal(18,2) DEFAULT NULL,
  `month_period` varchar(6) NOT NULL,
  `description` tinytext,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tx_validity_detail_billing_status` (`billing_status`),
  KEY `FK_tx_validity_detail_customer` (`customer_id`),
  KEY `FK_tx_validity_detail_validity` (`validity_id`),
  KEY `FK_tx_validity_detail_device_status` (`device_status`),
  CONSTRAINT `FK_tx_validity_detail_billing_status` FOREIGN KEY (`billing_status`) REFERENCES `tx_lookup` (`id`),
  CONSTRAINT `FK_tx_validity_detail_customer` FOREIGN KEY (`customer_id`) REFERENCES `tx_customer` (`id`),
  CONSTRAINT `FK_tx_validity_detail_device_status` FOREIGN KEY (`device_status`) REFERENCES `tx_lookup` (`id`),
  CONSTRAINT `FK_tx_validity_detail_validity` FOREIGN KEY (`validity_id`) REFERENCES `tx_validity` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tx_validity_detail` */

/*Table structure for table `tx_village` */

DROP TABLE IF EXISTS `tx_village`;

CREATE TABLE `tx_village` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `area_id` int(11) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `description` tinytext,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `verlock` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tx_village_area` (`area_id`),
  CONSTRAINT `FK_tx_village_area` FOREIGN KEY (`area_id`) REFERENCES `tx_area` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tx_village` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
