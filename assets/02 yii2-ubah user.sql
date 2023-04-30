/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/SQLTemplate.sql to edit this template
 */
/**
 * Author:  Cassiopeia
 * Created: Apr 30, 2023
 */

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;

USE `yii2-news-update`;

/* Alter table in target */
ALTER TABLE `tx_user` 
	CHANGE `auth_key` `auth_key` varchar(32)  COLLATE utf8_unicode_ci NOT NULL after `username` , 
	CHANGE `password_hash` `password_hash` varchar(255)  COLLATE utf8_unicode_ci NOT NULL after `auth_key` , 
	ADD COLUMN `password_reset_token` varchar(255)  COLLATE utf8_unicode_ci NULL after `password_hash` , 
	CHANGE `email` `email` varchar(255)  COLLATE utf8_unicode_ci NOT NULL after `password_reset_token` , 
	ADD COLUMN `status` smallint(6)   NOT NULL DEFAULT 1 after `email` , 
	CHANGE `created_at` `created_at` int(11)   NOT NULL after `status` , 
	CHANGE `updated_at` `updated_at` int(11)   NOT NULL after `created_at` , 
	ADD COLUMN `last_login` int(11)   NULL after `updated_at` , 
	DROP COLUMN `registration_ip` , 
	DROP COLUMN `confirmed_at` , 
	DROP COLUMN `flags` , 
	DROP COLUMN `unconfirmed_email` , 
	DROP COLUMN `blocked_at` , 
	DROP COLUMN `last_login_at` , 
	DROP COLUMN `auth_tf_key` , 
	DROP COLUMN `auth_tf_enabled` , 
	ADD UNIQUE KEY `email`(`email`) , 
	DROP KEY `idx_user_email` , 
	DROP KEY `idx_user_username` , 
	ADD UNIQUE KEY `password_reset_token`(`password_reset_token`) , 
	ADD UNIQUE KEY `username`(`username`) ;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;

drop table tx_token