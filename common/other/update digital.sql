/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  Nanta Es
 * Created: Feb 9, 2021
 */


/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;

USE `pujt6964_admlsw`; 

/* Foreign Keys must be dropped in the target to ensure that requires changes can be done*/

ALTER TABLE `tx_enrolment` 
	DROP FOREIGN KEY `FK_tx_enrolment_customer`  , 
	DROP FOREIGN KEY `FK_tx_enrolment_network`  ;


/* Alter table in target */
ALTER TABLE `tx_enrolment` 
	ADD COLUMN `enrolment_type` int(11)   NULL after `month_period` , 
	ADD COLUMN `date_start` int(11)   NULL after `enrolment_type` , 
	ADD COLUMN `date_end` int(11)   NULL after `date_start` , 
	CHANGE `description` `description` tinytext  COLLATE latin1_swedish_ci NULL after `date_end` ; 

/* The foreign keys that were dropped are now re-created*/

ALTER TABLE `tx_enrolment` 
	ADD CONSTRAINT `FK_tx_enrolment_customer` 
	FOREIGN KEY (`customer_id`) REFERENCES `tx_customer` (`id`) , 
	ADD CONSTRAINT `FK_tx_enrolment_network` 
	FOREIGN KEY (`network_id`) REFERENCES `tx_network` (`id`) ;


/* Alter table in target */
ALTER TABLE `tx_outlet_detail` 
	ADD COLUMN `enrolment_type` int(11)   NULL after `monthly_bill` ; 

/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;

update tx_enrolment set enrolment_type = 1 where enrolment_type IS null;
update tx_outlet_detail set enrolment_type = 1 where enrolment_type IS null;


ALTER TABLE `tx_service` 
	ADD COLUMN `service_type` int(11)   NULL after `month_period`,
        ADD COLUMN `date_start` int(11)   NULL after `service_type`,
        ADD COLUMN `date_end` int(11)   NULL after `date_start`,
        ADD COLUMN `billing_cycle` int(11)   NULL after `date_end`,
        CHANGE `description` `description` text  COLLATE latin1_swedish_ci NULL after `billing_cycle`; 

ALTER TABLE `tx_service` 
	ADD COLUMN `claim` decimal(18,2)   NULL after `description`,
        ADD COLUMN `surcharge` decimal(18,2)   NULL after `claim`; 

update tx_service set service_type = 1 where service_type IS null;

ALTER TABLE `tx_service_detail` 
	ADD COLUMN `monthly_bill` int(11)   NULL after `month_period`; 

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;

USE `pujt6964_admlsw`;



/* Create table in target */
CREATE TABLE `tx_work_type`(
	`id` int(11) NOT NULL  auto_increment , 
	`title` varchar(200) COLLATE utf8mb4_general_ci NULL  , 
	`sequence` int(11) NULL  , 
	`description` text COLLATE utf8mb4_general_ci NULL  , 
	`created_at` int(11) NULL  , 
	`updated_at` int(11) NULL  , 
	`created_by` int(11) NULL  , 
	`updated_by` int(11) NULL  , 
	`is_deleted` int(11) NULL  , 
	`deleted_at` int(11) NULL  , 
	`deleted_by` int(11) NULL  , 
	`verlock` bigint(20) NULL  , 
	PRIMARY KEY (`id`) 
) ENGINE=InnoDB DEFAULT CHARSET='utf8mb4' COLLATE='utf8mb4_general_ci';

/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;


/* Create table in target */
CREATE TABLE `tx_work`(
	`id` int(11) NOT NULL  auto_increment , 
	`work_type_id` int(11) NULL  , 
	`title` varchar(200) COLLATE utf8mb4_general_ci NULL  , 
	`sequence` int(11) NULL  , 
	`description` text COLLATE utf8mb4_general_ci NULL  , 
	`created_at` int(11) NULL  , 
	`updated_at` int(11) NULL  , 
	`created_by` int(11) NULL  , 
	`updated_by` int(11) NULL  , 
	`is_deleted` int(11) NULL  , 
	`deleted_at` int(11) NULL  , 
	`deleted_by` int(11) NULL  , 
	`verlock` bigint(20) NULL  , 
	PRIMARY KEY (`id`) , 
	KEY `FK_tx_work_type`(`work_type_id`) , 
	CONSTRAINT `FK_tx_work_type` 
	FOREIGN KEY (`work_type_id`) REFERENCES `tx_work_type` (`id`) 
) ENGINE=InnoDB DEFAULT CHARSET='utf8mb4' COLLATE='utf8mb4_general_ci';


/* Create table in target */
CREATE TABLE `tx_work_request`(
	`id` int(11) NOT NULL  auto_increment , 
	`title` varchar(10) COLLATE utf8mb4_general_ci NULL  , 
	`invoice` varchar(20) COLLATE utf8mb4_general_ci NULL  , 
	`customer_id` int(11) NULL  , 
	`staff_id` int(11) NULL  , 
	`date_issued` int(11) NULL  , 
	`month_period` varchar(6) COLLATE utf8mb4_general_ci NULL  , 
	`description` text COLLATE utf8mb4_general_ci NULL  , 
	`created_at` int(11) NULL  , 
	`updated_at` int(11) NULL  , 
	`created_by` int(11) NULL  , 
	`updated_by` int(11) NULL  , 
	`is_deleted` int(11) NULL  , 
	`deleted_at` int(11) NULL  , 
	`deleted_by` int(11) NULL  , 
	`verlock` bigint(20) NULL  , 
	PRIMARY KEY (`id`) , 
	KEY `FK_tx_work_request_customer`(`customer_id`) , 
	KEY `FK_tx_work_request_staff`(`staff_id`) , 
	CONSTRAINT `FK_tx_work_request_customer` 
	FOREIGN KEY (`customer_id`) REFERENCES `tx_customer` (`id`) , 
	CONSTRAINT `FK_tx_work_request_staff` 
	FOREIGN KEY (`staff_id`) REFERENCES `tx_staff` (`id`) 
) ENGINE=InnoDB DEFAULT CHARSET='utf8mb4' COLLATE='utf8mb4_general_ci';


/* Create table in target */
CREATE TABLE `tx_work_request_detail`(
	`id` int(11) NOT NULL  auto_increment , 
	`work_request_id` int(11) NULL  , 
	`customer_id` int(11) NULL  , 
	`work_id` int(11) NULL  , 
	`remark` text COLLATE utf8mb4_general_ci NULL  , 
	`created_at` int(11) NULL  , 
	`created_by` int(11) NULL  , 
	`updated_at` int(11) NULL  , 
	`updated_by` int(11) NULL  , 
	`is_deleted` int(11) NULL  , 
	`deleted_at` int(11) NULL  , 
	`deleted_by` int(11) NULL  , 
	`verlock` bigint(20) NULL  , 
	PRIMARY KEY (`id`) , 
	KEY `FK_tx_work_request_detail_work_request`(`work_request_id`) , 
	KEY `FK_tx_work_request_detail_work`(`work_id`) , 
	KEY `FK_tx_work_request_detail_customer`(`customer_id`) , 
	CONSTRAINT `FK_tx_work_request_detail_customer` 
	FOREIGN KEY (`customer_id`) REFERENCES `tx_customer` (`id`) , 
	CONSTRAINT `FK_tx_work_request_detail_work` 
	FOREIGN KEY (`work_id`) REFERENCES `tx_work` (`id`) , 
	CONSTRAINT `FK_tx_work_request_detail_work_request` 
	FOREIGN KEY (`work_request_id`) REFERENCES `tx_work_request` (`id`) 
) ENGINE=InnoDB DEFAULT CHARSET='utf8mb4' COLLATE='utf8mb4_general_ci';









-- ALTER TABLE `tx_work` 
-- 	ADD CONSTRAINT `FK_tx_work_type` 
--	FOREIGN KEY (`work_type_id`) REFERENCES `tx_work_type` (`id`);

--ALTER TABLE `tx_work_request` 
	--ADD CONSTRAINT `FK_tx_work_request_customer` 
	--FOREIGN KEY (`customer_id`) REFERENCES `tx_customer` (`id`),
	--ADD CONSTRAINT `FK_tx_work_request_staff` 
	--FOREIGN KEY (`staff_id`) REFERENCES `tx_staff` (`id`);

--ALTER TABLE `tx_work_request_detail` 
	--ADD CONSTRAINT `FK_tx_work_request_detail_work_request` 
	--FOREIGN KEY (`work_request_id`) REFERENCES `tx_work_request` (`id`),
	--ADD CONSTRAINT `FK_tx_work_request_detail_customer` 
	--FOREIGN KEY (`customer_id`) REFERENCES `tx_customer` (`id`),
	--ADD CONSTRAINT `FK_tx_work_request_detail_work` 
	--FOREIGN KEY (`work_id`) REFERENCES `tx_work` (`id`);