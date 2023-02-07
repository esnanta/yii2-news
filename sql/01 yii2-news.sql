/*
SQLyog Ultimate v12.5.1 (64 bit)
MySQL - 10.4.22-MariaDB : Database - yii2-news
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`yii2-news` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `yii2-news`;

/*Table structure for table `tx_archive` */

DROP TABLE IF EXISTS `tx_archive`;

CREATE TABLE `tx_archive` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `is_visible` INT(11) DEFAULT NULL,
  `archive_type` INT(11) DEFAULT NULL,
  `archive_category_id` INT(11) DEFAULT NULL,
  `title` VARCHAR(200) DEFAULT NULL,
  `date_issued` INT(11) DEFAULT NULL,
  `file_name` VARCHAR(200) DEFAULT NULL,
  `archive_url` VARCHAR(500) DEFAULT NULL,
  `size` INT(11) DEFAULT NULL,
  `mime_type` VARCHAR(100) DEFAULT NULL,
  `view_counter` INT(11) DEFAULT NULL,
  `download_counter` INT(11) DEFAULT NULL,
  `description` TEXT DEFAULT NULL,
  `created_at` INT(11) DEFAULT NULL,
  `updated_at` INT(11) DEFAULT NULL,
  `created_by` INT(11) DEFAULT NULL,
  `updated_by` INT(11) DEFAULT NULL,
  `is_deleted` INT(11) DEFAULT NULL,
  `deleted_at` INT(11) DEFAULT NULL,
  `deleted_by` INT(11) DEFAULT NULL,
  `verlock` BIGINT(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tx_archive_category` (`archive_category_id`),
  CONSTRAINT `FK_tx_archive_category` FOREIGN KEY (`archive_category_id`) REFERENCES `tx_archive_category` (`id`)
) ENGINE=INNODB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Table structure for table `tx_archive_category` */

DROP TABLE IF EXISTS `tx_archive_category`;

CREATE TABLE `tx_archive_category` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(200) DEFAULT NULL,
  `sequence` INT(11) DEFAULT NULL,
  `description` TEXT DEFAULT NULL,
  `created_at` INT(11) DEFAULT NULL,
  `updated_at` INT(11) DEFAULT NULL,
  `created_by` INT(11) DEFAULT NULL,
  `updated_by` INT(11) DEFAULT NULL,
  `is_deleted` INT(11) DEFAULT NULL,
  `deleted_at` INT(11) DEFAULT NULL,
  `deleted_by` INT(11) DEFAULT NULL,
  `verlock` BIGINT(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=INNODB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tx_archive_category` */

INSERT  INTO `tx_archive_category`(`id`,`title`,`sequence`,`description`,`created_at`,`updated_at`,`created_by`,`updated_by`,`is_deleted`,`deleted_at`,`deleted_by`,`verlock`) VALUES 
(1,'Umum',NULL,'-',UNIX_TIMESTAMP(),UNIX_TIMESTAMP(),1,1,NULL,NULL,NULL,0);

/*Table structure for table `tx_auth_assignment` */

DROP TABLE IF EXISTS `tx_auth_assignment`;

CREATE TABLE `tx_auth_assignment` (
  `item_name` VARCHAR(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` VARCHAR(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` INT(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `auth_assignment_user_id_idx` (`user_id`),
  CONSTRAINT `tx_auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `tx_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `tx_auth_assignment` */

INSERT  INTO `tx_auth_assignment`(`item_name`,`user_id`,`created_at`) VALUES 
('admin','1',UNIX_TIMESTAMP());

/*Table structure for table `tx_auth_item` */

DROP TABLE IF EXISTS `tx_auth_item`;

CREATE TABLE `tx_auth_item` (
  `name` VARCHAR(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` SMALLINT(6) NOT NULL,
  `description` TEXT COLLATE utf8_unicode_ci DEFAULT NULL,
  `rule_name` VARCHAR(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` BLOB DEFAULT NULL,
  `created_at` INT(11) DEFAULT NULL,
  `updated_at` INT(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `tx_auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `tx_auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `tx_auth_item_child` */

DROP TABLE IF EXISTS `tx_auth_item_child`;

CREATE TABLE `tx_auth_item_child` (
  `parent` VARCHAR(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` VARCHAR(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `tx_auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `tx_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tx_auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `tx_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `tx_auth_item_child` */



/*Table structure for table `tx_auth_rule` */

DROP TABLE IF EXISTS `tx_auth_rule`;

CREATE TABLE `tx_auth_rule` (
  `name` VARCHAR(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` BLOB DEFAULT NULL,
  `created_at` INT(11) DEFAULT NULL,
  `updated_at` INT(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `tx_auth_rule` */

/*Table structure for table `tx_author` */

DROP TABLE IF EXISTS `tx_author`;

CREATE TABLE `tx_author` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) DEFAULT NULL,
  `title` VARCHAR(100) DEFAULT NULL,
  `phone_number` VARCHAR(50) DEFAULT NULL,
  `email` VARCHAR(100) DEFAULT NULL,
  `google_plus` VARCHAR(100) DEFAULT NULL,
  `instagram` VARCHAR(100) DEFAULT NULL,
  `facebook` VARCHAR(100) DEFAULT NULL,
  `twitter` VARCHAR(100) DEFAULT NULL,
  `file_name` VARCHAR(100) DEFAULT NULL,
  `address` TINYTEXT DEFAULT NULL,
  `description` TEXT DEFAULT NULL,
  `created_at` INT(11) DEFAULT NULL,
  `updated_at` INT(11) DEFAULT NULL,
  `created_by` INT(11) DEFAULT NULL,
  `updated_by` INT(11) DEFAULT NULL,
  `is_deleted` INT(11) DEFAULT NULL,
  `deleted_at` INT(11) DEFAULT NULL,
  `deleted_by` INT(11) DEFAULT NULL,
  `verlock` BIGINT(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tx_author_user` (`user_id`),
  CONSTRAINT `FK_tx_author_user` FOREIGN KEY (`user_id`) REFERENCES `tx_user` (`id`)
) ENGINE=INNODB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `tx_author` */

INSERT  INTO `tx_author`(`id`,`user_id`,`title`,`phone_number`,`email`,`google_plus`,`instagram`,`facebook`,`twitter`,`file_name`,`address`,`description`,`created_at`,`updated_at`,`created_by`,`updated_by`,`is_deleted`,`deleted_at`,`deleted_by`,`verlock`) VALUES 
(1,NULL,'Admin','','ombakrinai@gmail.com','','','','','','','',UNIX_TIMESTAMP(),UNIX_TIMESTAMP(),1,1,NULL,NULL,NULL,3);


/*Table structure for table `tx_blog` */

DROP TABLE IF EXISTS `tx_blog`;

CREATE TABLE `tx_blog` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `category_id` INT(11) NOT NULL,
  `author_id` INT(11) DEFAULT NULL,
  `title` VARCHAR(150) NOT NULL,
  `cover` VARCHAR(300) DEFAULT NULL,
  `url` VARCHAR(300) DEFAULT NULL,
  `content` LONGTEXT NOT NULL,
  `description` LONGTEXT DEFAULT NULL,
  `tags` TEXT DEFAULT NULL,
  `month_period` VARCHAR(6) DEFAULT NULL,
  `publish_status` INT(11) NOT NULL,
  `pinned_status` INT(11) DEFAULT NULL,
  `view_counter` INT(11) DEFAULT NULL,
  `rating` FLOAT DEFAULT NULL,
  `date_issued` INT(11) DEFAULT NULL,
  `created_at` INT(11) DEFAULT NULL,
  `updated_at` INT(11) DEFAULT NULL,
  `created_by` INT(11) DEFAULT NULL,
  `updated_by` INT(11) DEFAULT NULL,
  `is_deleted` INT(11) DEFAULT NULL,
  `deleted_at` INT(11) DEFAULT NULL,
  `deleted_by` INT(11) DEFAULT NULL,
  `verlock` BIGINT(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tx_blog_author` (`author_id`),
  KEY `FK_tx_blog_category` (`category_id`),
  KEY `FK_tx_blog_publish` (`publish_status`),
  KEY `FK_tx_blog_pinned` (`pinned_status`),
  CONSTRAINT `FK_tx_blog_author` FOREIGN KEY (`author_id`) REFERENCES `tx_author` (`id`),
  CONSTRAINT `FK_tx_blog_category` FOREIGN KEY (`category_id`) REFERENCES `tx_category` (`id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Data for the table `tx_blog` */

/*Table structure for table `tx_category` */

DROP TABLE IF EXISTS `tx_category`;

CREATE TABLE `tx_category` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(100) DEFAULT NULL,
  `label` VARCHAR(20) DEFAULT NULL,
  `sequence` INT(11) DEFAULT NULL,
  `description` TEXT DEFAULT NULL,
  `time_line` INT(11) DEFAULT NULL,
  `created_at` INT(11) DEFAULT NULL,
  `updated_at` INT(11) DEFAULT NULL,
  `created_by` INT(11) DEFAULT NULL,
  `updated_by` INT(11) DEFAULT NULL,
  `is_deleted` INT(11) DEFAULT NULL,
  `deleted_at` INT(11) DEFAULT NULL,
  `deleted_by` INT(11) DEFAULT NULL,
  `verlock` BIGINT(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `category_name_UNIQUE` (`title`),
  KEY `FK_tx_category_time_line` (`time_line`)
) ENGINE=INNODB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

/*Data for the table `tx_category` */

INSERT  INTO `tx_category`(`id`,`title`,`label`,`sequence`,`description`,`time_line`,`created_at`,`updated_at`,`created_by`,`updated_by`,`is_deleted`,`deleted_at`,`deleted_by`,`verlock`) VALUES 
(1,'Berita','darkred',1,'Berita',1,UNIX_TIMESTAMP(),UNIX_TIMESTAMP(),1,1,0,NULL,NULL,10);
/*Table structure for table `tx_counter` */

DROP TABLE IF EXISTS `tx_counter`;

CREATE TABLE `tx_counter` (
  `id` VARCHAR(8) NOT NULL,
  `counter` INT(11) DEFAULT NULL,
  `created_at` INT(11) DEFAULT NULL,
  `updated_at` INT(11) DEFAULT NULL,
  `created_by` INT(11) DEFAULT NULL,
  `updated_by` INT(11) DEFAULT NULL,
  `is_deleted` INT(11) DEFAULT NULL,
  `deleted_at` INT(11) DEFAULT NULL,
  `deleted_by` INT(11) DEFAULT NULL,
  `verlock` BIGINT(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Data for the table `tx_counter` */

INSERT  INTO `tx_counter`(`id`,`counter`,`created_at`,`updated_at`,`created_by`,`updated_by`,`is_deleted`,`deleted_at`,`deleted_by`,`verlock`) VALUES 
('MBA16',7,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),
('MBA17',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),
('REG16',9,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0);

/*Table structure for table `tx_dashblock` */

DROP TABLE IF EXISTS `tx_dashblock`;

CREATE TABLE `tx_dashblock` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL DEFAULT '',
  `actions` TEXT DEFAULT NULL,
  `weight` INT(11) UNSIGNED NOT NULL DEFAULT 0,
  `status` TINYINT(4) UNSIGNED NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Data for the table `tx_dashblock` */

/*Table structure for table `tx_employment` */

DROP TABLE IF EXISTS `tx_employment`;

CREATE TABLE `tx_employment` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(100) DEFAULT NULL,
  `description` TEXT DEFAULT NULL,
  `sequence` TINYINT(4) DEFAULT NULL,
  `created_at` INT(11) DEFAULT NULL,
  `updated_at` INT(11) DEFAULT NULL,
  `created_by` INT(11) DEFAULT NULL,
  `updated_by` INT(11) DEFAULT NULL,
  `is_deleted` INT(11) DEFAULT NULL,
  `deleted_at` INT(11) DEFAULT NULL,
  `deleted_by` INT(11) DEFAULT NULL,
  `verlock` BIGINT(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `job_title_name_UNIQUE` (`title`)
) ENGINE=INNODB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `tx_employment` */

INSERT  INTO `tx_employment`(`id`,`title`,`description`,`sequence`,`created_at`,`updated_at`,`created_by`,`updated_by`,`is_deleted`,`deleted_at`,`deleted_by`,`verlock`) VALUES 
(1,'Developer','',1,UNIX_TIMESTAMP(),UNIX_TIMESTAMP(),1,1,NULL,NULL,NULL,4);

/*Table structure for table `tx_event` */

DROP TABLE IF EXISTS `tx_event`;

CREATE TABLE `tx_event` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(200) DEFAULT NULL,
  `date_start` INT(11) DEFAULT NULL,
  `date_end` INT(11) DEFAULT NULL,
  `location` TINYTEXT DEFAULT NULL,
  `content` TEXT DEFAULT NULL,
  `view_counter` INT(11) DEFAULT NULL,
  `description` TEXT DEFAULT NULL,
  `created_at` INT(11) DEFAULT NULL,
  `updated_at` INT(11) DEFAULT NULL,
  `created_by` INT(11) DEFAULT NULL,
  `updated_by` INT(11) DEFAULT NULL,
  `is_deleted` INT(11) DEFAULT NULL,
  `deleted_at` INT(11) DEFAULT NULL,
  `deleted_by` INT(11) DEFAULT NULL,
  `verlock` BIGINT(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Data for the table `tx_event` */

/*Table structure for table `tx_migration` */

DROP TABLE IF EXISTS `tx_migration`;

CREATE TABLE `tx_migration` (
  `version` VARCHAR(180) NOT NULL,
  `apply_time` INT(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=INNODB DEFAULT CHARSET=latin1;

/*Data for the table `tx_migration` */

INSERT  INTO `tx_migration`(`version`,`apply_time`) VALUES 
('Da\\User\\Migration\\m000000_000001_create_user_table',1507740966),
('Da\\User\\Migration\\m000000_000002_create_profile_table',1507740968),
('Da\\User\\Migration\\m000000_000003_create_social_account_table',1507740970),
('Da\\User\\Migration\\m000000_000004_create_token_table',1507740972),
('Da\\User\\Migration\\m000000_000005_add_last_login_at',1507740973),
('Da\\User\\Migration\\m000000_000006_add_two_factor_fields',1514392155),
('m140506_102106_rbac_init',1507741269),
('m170907_052038_rbac_add_index_on_auth_assignment_user_id',1514392156);

/*Table structure for table `tx_office` */

DROP TABLE IF EXISTS `tx_office`;

CREATE TABLE `tx_office` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `token` VARCHAR(5) DEFAULT NULL,
  `title` VARCHAR(100) DEFAULT NULL,
  `phone_number` VARCHAR(100) DEFAULT NULL,
  `fax_number` VARCHAR(100) DEFAULT NULL,
  `email` VARCHAR(100) DEFAULT NULL,
  `web` VARCHAR(100) DEFAULT NULL,
  `address` VARCHAR(100) DEFAULT NULL,
  `latitude` VARCHAR(100) DEFAULT NULL,
  `longitude` VARCHAR(100) DEFAULT NULL,
  `facebook` VARCHAR(100) DEFAULT NULL,
  `google_plus` VARCHAR(100) DEFAULT NULL,
  `instagram` VARCHAR(100) DEFAULT NULL,
  `twitter` VARCHAR(100) DEFAULT NULL,
  `description` TINYTEXT DEFAULT NULL,
  `created_at` INT(11) DEFAULT NULL,
  `updated_at` INT(11) DEFAULT NULL,
  `created_by` INT(11) DEFAULT NULL,
  `updated_by` INT(11) DEFAULT NULL,
  `is_deleted` INT(11) DEFAULT NULL,
  `deleted_at` INT(11) DEFAULT NULL,
  `deleted_by` INT(11) DEFAULT NULL,
  `verlock` BIGINT(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=INNODB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `tx_office` */

INSERT  INTO `tx_office`(`id`,`token`,`title`,`phone_number`,`fax_number`,`email`,`web`,`address`,`latitude`,`longitude`,`facebook`,`google_plus`,`instagram`,`twitter`,`description`,`created_at`,`updated_at`,`created_by`,`updated_by`,`is_deleted`,`deleted_at`,`deleted_by`,`verlock`) VALUES 
(1,'3456','Nama Perusahaan','-','-','-','-','-','','',NULL,NULL,NULL,NULL,'-',UNIX_TIMESTAMP(),UNIX_TIMESTAMP(),1,1,0,NULL,NULL,11);


/*Table structure for table `tx_profile` */

DROP TABLE IF EXISTS `tx_profile`;

CREATE TABLE `tx_profile` (
  `user_id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `public_email` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gravatar_email` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gravatar_id` VARCHAR(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `location` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `timezone` VARCHAR(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bio` TEXT COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_name` VARCHAR(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  CONSTRAINT `fk_profile_user` FOREIGN KEY (`user_id`) REFERENCES `tx_user` (`id`) ON DELETE CASCADE
) ENGINE=INNODB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `tx_profile` */

INSERT  INTO `tx_profile`(`user_id`,`name`,`public_email`,`gravatar_email`,`gravatar_id`,`location`,`website`,`timezone`,`bio`,`file_name`) VALUES 
(1,'Nanta Es','ombakrinai@gmail.com','','d41d8cd98f00b204e9800998ecf8427e','Lhokseumawe','https://esnanta.my.id/',NULL,'-','');

/*Table structure for table `tx_quote` */

DROP TABLE IF EXISTS `tx_quote`;

CREATE TABLE `tx_quote` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(100) DEFAULT NULL,
  `content` TEXT DEFAULT NULL,
  `source` VARCHAR(100) DEFAULT NULL,
  `file_name` VARCHAR(200) DEFAULT NULL,
  `description` TEXT DEFAULT NULL,
  `created_at` INT(11) DEFAULT NULL,
  `updated_at` INT(11) DEFAULT NULL,
  `created_by` INT(11) DEFAULT NULL,
  `updated_by` INT(11) DEFAULT NULL,
  `is_deleted` INT(11) DEFAULT NULL,
  `deleted_at` INT(11) DEFAULT NULL,
  `deleted_by` INT(11) DEFAULT NULL,
  `verlock` BIGINT(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Data for the table `tx_quote` */

/*Table structure for table `tx_session` */

DROP TABLE IF EXISTS `tx_session`;

CREATE TABLE `tx_session` (
  `id` CHAR(32) NOT NULL,
  `expire` INT(11) DEFAULT NULL,
  `data` LONGBLOB DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Data for the table `tx_session` */

INSERT  INTO `tx_session`(`id`,`expire`,`data`) VALUES 
('3t1tf58u3lunutsj7qgc3r5bi0',1548695669,'__flash|a:0:{}__returnUrl|s:12:\"/main/admin/\";'),
('7cpci685marr7lrd1n3s7tnfn5',1548647964,'__flash|a:0:{}__returnUrl|s:55:\"/main/uploads/content//uploads/web/img5985a8c7b0133.jpg\";'),
('irjmnn0m1t54h1ibarj6ndpfa4',1548771355,'__flash|a:0:{}__returnUrl|s:12:\"/main/admin/\";'),
('jf0bbc1i9pbgaeifpcjchp8uu0',1548697141,'__flash|a:0:{}__returnUrl|s:12:\"/main/admin/\";'),
('nf0uo3mprh87tkjo8akn57dl31',1548516734,'__flash|a:0:{}__returnUrl|s:12:\"/main/admin/\";'),
('o50mk6fuk8lvq65ihefl1baqu1',1548432564,'__flash|a:0:{}__returnUrl|s:12:\"/main/admin/\";');

/*Table structure for table `tx_site_link` */

DROP TABLE IF EXISTS `tx_site_link`;

CREATE TABLE `tx_site_link` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(100) DEFAULT NULL,
  `url` VARCHAR(200) DEFAULT NULL,
  `sequence` INT(11) DEFAULT NULL,
  `description` TINYTEXT DEFAULT NULL,
  `created_at` INT(11) DEFAULT NULL,
  `created_by` INT(11) DEFAULT NULL,
  `updated_at` INT(11) DEFAULT NULL,
  `updated_by` INT(11) DEFAULT NULL,
  `is_deleted` INT(11) DEFAULT NULL,
  `deleted_at` INT(11) DEFAULT NULL,
  `deleted_by` INT(11) DEFAULT NULL,
  `verlock` BIGINT(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=INNODB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

/*Data for the table `tx_site_link` */

INSERT  INTO `tx_site_link`(`id`,`title`,`url`,`sequence`,`description`,`created_at`,`created_by`,`updated_at`,`updated_by`,`is_deleted`,`deleted_at`,`deleted_by`,`verlock`) VALUES 
(1,'Kementerian Luar Negeri Republik Indonesia','https://kemlu.go.id/portal/id',1,'-',UNIX_TIMESTAMP(),1,UNIX_TIMESTAMP(),1,NULL,NULL,NULL,1);

/*Table structure for table `tx_social_account` */

DROP TABLE IF EXISTS `tx_social_account`;

CREATE TABLE `tx_social_account` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) DEFAULT NULL,
  `provider` VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL,
  `client_id` VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` VARCHAR(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` TEXT COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` INT(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_social_account_provider_client_id` (`provider`,`client_id`),
  UNIQUE KEY `idx_social_account_code` (`code`),
  KEY `fk_social_account_user` (`user_id`),
  CONSTRAINT `fk_social_account_user` FOREIGN KEY (`user_id`) REFERENCES `tx_user` (`id`) ON DELETE CASCADE
) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `tx_social_account` */

/*Table structure for table `tx_staff` */

DROP TABLE IF EXISTS `tx_staff`;

CREATE TABLE `tx_staff` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `employment_id` INT(11) DEFAULT NULL,
  `title` VARCHAR(100) DEFAULT NULL,
  `initial` VARCHAR(10) NOT NULL,
  `identity_number` VARCHAR(100) DEFAULT NULL,
  `phone_number` VARCHAR(50) DEFAULT NULL,
  `gender_status` INT(11) DEFAULT NULL,
  `active_status` INT(11) DEFAULT NULL,
  `address` TINYTEXT DEFAULT NULL,
  `file_name` VARCHAR(200) DEFAULT NULL,
  `email` VARCHAR(100) DEFAULT NULL,
  `google_plus` VARCHAR(100) DEFAULT NULL,
  `instagram` VARCHAR(100) DEFAULT NULL,
  `facebook` VARCHAR(100) DEFAULT NULL,
  `twitter` VARCHAR(100) DEFAULT NULL,
  `description` TINYTEXT DEFAULT NULL,
  `created_at` INT(11) DEFAULT NULL,
  `updated_at` INT(11) DEFAULT NULL,
  `created_by` INT(11) DEFAULT NULL,
  `updated_by` INT(11) DEFAULT NULL,
  `is_deleted` INT(11) DEFAULT NULL,
  `deleted_at` INT(11) DEFAULT NULL,
  `deleted_by` INT(11) DEFAULT NULL,
  `verlock` BIGINT(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tx_staff_gender` (`gender_status`),
  KEY `FK_tx_staff_role` (`employment_id`),
  CONSTRAINT `FK_tx_staff_employment` FOREIGN KEY (`employment_id`) REFERENCES `tx_employment` (`id`)
) ENGINE=INNODB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `tx_staff` */

INSERT  INTO `tx_staff`(`id`,`employment_id`,`title`,`initial`,`identity_number`,`phone_number`,`gender_status`,`active_status`,`address`,`file_name`,`email`,`google_plus`,`instagram`,`facebook`,`twitter`,`description`,`created_at`,`updated_at`,`created_by`,`updated_by`,`is_deleted`,`deleted_at`,`deleted_by`,`verlock`) VALUES 
(1,2,'Nanta Es','Es','','',1,1,'','','esnanta.my.id','','','','','',UNIX_TIMESTAMP(),UNIX_TIMESTAMP(),1,1,0,NULL,NULL,8);

/*Table structure for table `tx_tag` */

DROP TABLE IF EXISTS `tx_tag`;

CREATE TABLE `tx_tag` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `tag_name` VARCHAR(150) NOT NULL,
  `frequency` INT(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Data for the table `tx_tag` */

/*Table structure for table `tx_theme` */

DROP TABLE IF EXISTS `tx_theme`;

CREATE TABLE `tx_theme` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(100) DEFAULT NULL,
  `description` TINYTEXT DEFAULT NULL,
  `verlock` BIGINT(20) DEFAULT NULL,
  `created_at` INT(11) DEFAULT NULL,
  `updated_at` INT(11) DEFAULT NULL,
  `created_by` INT(11) DEFAULT NULL,
  `updated_by` INT(11) DEFAULT NULL,
  `is_deleted` INT(11) DEFAULT NULL,
  `deleted_at` INT(11) DEFAULT NULL,
  `deleted_by` INT(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title_UNIQUE` (`title`)
) ENGINE=INNODB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `tx_theme` */

INSERT  INTO `tx_theme`(`id`,`title`,`description`,`verlock`,`created_at`,`updated_at`,`created_by`,`updated_by`,`is_deleted`,`deleted_at`,`deleted_by`) VALUES 
(1,'Global','Dipakai di semua halaman',0,1512226913,1512226962,1,1,NULL,NULL,NULL),
(3,'Blog19','Unify V 1.9.6\r\nStart Code 200',1,1512226913,1512226962,1,1,NULL,NULL,NULL);

/*Table structure for table `tx_theme_detail` */

DROP TABLE IF EXISTS `tx_theme_detail`;

CREATE TABLE `tx_theme_detail` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `theme_id` INT(11) DEFAULT NULL,
  `title` VARCHAR(100) DEFAULT NULL,
  `token` VARCHAR(5) DEFAULT NULL,
  `content` TEXT DEFAULT NULL,
  `file_name` VARCHAR(200) DEFAULT NULL,
  `description` TINYTEXT DEFAULT NULL,
  `created_at` INT(11) DEFAULT NULL,
  `updated_at` INT(11) DEFAULT NULL,
  `created_by` INT(11) DEFAULT NULL,
  `updated_by` INT(11) DEFAULT NULL,
  `is_deleted` INT(11) DEFAULT NULL,
  `deleted_at` INT(11) DEFAULT NULL,
  `deleted_by` INT(11) DEFAULT NULL,
  `verlock` BIGINT(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `layout_code_UNIQUE` (`token`),
  KEY `FK_tx_content_theme` (`theme_id`),
  CONSTRAINT `FK_tx_theme_detail_theme` FOREIGN KEY (`theme_id`) REFERENCES `tx_theme` (`id`)
) ENGINE=INNODB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

/*Data for the table `tx_theme_detail` */

INSERT  INTO `tx_theme_detail`(`id`,`theme_id`,`title`,`token`,`content`,`file_name`,`description`,`created_at`,`updated_at`,`created_by`,`updated_by`,`is_deleted`,`deleted_at`,`deleted_by`,`verlock`) VALUES 
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
  `user_id` INT(11) DEFAULT NULL,
  `code` VARCHAR(32) COLLATE utf8_unicode_ci NOT NULL,
  `type` SMALLINT(6) NOT NULL,
  `created_at` INT(11) NOT NULL,
  UNIQUE KEY `idx_token_user_id_code_type` (`user_id`,`code`,`type`),
  CONSTRAINT `fk_token_user` FOREIGN KEY (`user_id`) REFERENCES `tx_user` (`id`) ON DELETE CASCADE
) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `tx_token` */

INSERT  INTO `tx_token`(`user_id`,`code`,`type`,`created_at`) VALUES 
(1,'XxnfcSJhSl93g2OskP24qV-XBKvNS9bj',0,UNIX_TIMESTAMP());

/*Table structure for table `tx_user` */

DROP TABLE IF EXISTS `tx_user`;

CREATE TABLE `tx_user` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` VARCHAR(60) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` VARCHAR(32) COLLATE utf8_unicode_ci NOT NULL,
  `unconfirmed_email` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `registration_ip` VARCHAR(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `flags` INT(11) NOT NULL DEFAULT 0,
  `confirmed_at` INT(11) DEFAULT NULL,
  `blocked_at` INT(11) DEFAULT NULL,
  `updated_at` INT(11) NOT NULL,
  `created_at` INT(11) NOT NULL,
  `last_login_at` INT(11) DEFAULT NULL,
  `auth_tf_key` VARCHAR(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `auth_tf_enabled` TINYINT(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_user_username` (`username`),
  UNIQUE KEY `idx_user_email` (`email`)
) ENGINE=INNODB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `tx_user` */

INSERT  INTO `tx_user`(`id`,`username`,`email`,`password_hash`,`auth_key`,`unconfirmed_email`,`registration_ip`,`flags`,`confirmed_at`,`blocked_at`,`updated_at`,`created_at`,`last_login_at`,`auth_tf_key`,`auth_tf_enabled`) VALUES 
(1,'admin','ombakrinai@gmail.com','$2y$10$oD129/e5PjrTkIV1yiR3AuOc2/XAOXLWgKPfb8svo8BdBA4PUsw3G','e0ee8dwDplLVaGlKGZteMSqPp1ikJFQm',NULL,'::1',0,UNIX_TIMESTAMP(),NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP(),UNIX_TIMESTAMP(),NULL,0);
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
