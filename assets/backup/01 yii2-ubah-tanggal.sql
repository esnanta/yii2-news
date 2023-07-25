/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/SQLTemplate.sql to edit this template
 */
/**
 * Author:  Cassiopeia
 * Created: Apr 30, 2023
 */

/**
 * ARCHIVE
 */
ALTER TABLE `tx_archive` CHANGE `date_issued` `date_issued` VARCHAR(20); 
UPDATE `tx_archive` SET `date_issued` = FROM_UNIXTIME(`date_issued`);
ALTER TABLE `tx_archive` CHANGE `date_issued` `date_issued` DATE; 


ALTER TABLE `tx_archive` CHANGE `created_at` `created_at` VARCHAR(20); 
UPDATE `tx_archive` SET `created_at` = FROM_UNIXTIME(`created_at`);
ALTER TABLE `tx_archive` CHANGE `created_at` `created_at` DATETIME; 

ALTER TABLE `tx_archive` CHANGE `updated_at` `updated_at` VARCHAR(20); 
UPDATE `tx_archive` SET `updated_at` = FROM_UNIXTIME(`updated_at`);
ALTER TABLE `tx_archive` CHANGE `updated_at` `updated_at` DATETIME; 

ALTER TABLE `tx_archive` CHANGE `deleted_at` `deleted_at` VARCHAR(20); 
UPDATE `tx_archive` SET `deleted_at` = FROM_UNIXTIME(`deleted_at`);
ALTER TABLE `tx_archive` CHANGE `deleted_at` `deleted_at` DATETIME; 

/**
 * ARCHIVE CATEGORY
 */
ALTER TABLE `tx_archive_category` CHANGE `created_at` `created_at` VARCHAR(20); 
UPDATE `tx_archive_category` SET `created_at` = FROM_UNIXTIME(`created_at`);
ALTER TABLE `tx_archive_category` CHANGE `created_at` `created_at` DATETIME; 

ALTER TABLE `tx_archive_category` CHANGE `updated_at` `updated_at` VARCHAR(20); 
UPDATE `tx_archive_category` SET `updated_at` = FROM_UNIXTIME(`updated_at`);
ALTER TABLE `tx_archive_category` CHANGE `updated_at` `updated_at` DATETIME; 

ALTER TABLE `tx_archive_category` CHANGE `deleted_at` `deleted_at` VARCHAR(20); 
UPDATE `tx_archive_category` SET `deleted_at` = FROM_UNIXTIME(`deleted_at`);
ALTER TABLE `tx_archive_category` CHANGE `deleted_at` `deleted_at` DATETIME; 


/**
 * AUTHOR
 */
ALTER TABLE `tx_author` CHANGE `created_at` `created_at` VARCHAR(20); 
UPDATE `tx_author` SET `created_at` = FROM_UNIXTIME(`created_at`);
ALTER TABLE `tx_author` CHANGE `created_at` `created_at` DATETIME; 

ALTER TABLE `tx_author` CHANGE `updated_at` `updated_at` VARCHAR(20); 
UPDATE `tx_author` SET `updated_at` = FROM_UNIXTIME(`updated_at`);
ALTER TABLE `tx_author` CHANGE `updated_at` `updated_at` DATETIME; 

ALTER TABLE `tx_author` CHANGE `deleted_at` `deleted_at` VARCHAR(20); 
UPDATE `tx_author` SET `deleted_at` = FROM_UNIXTIME(`deleted_at`);
ALTER TABLE `tx_author` CHANGE `deleted_at` `deleted_at` DATETIME; 


/**
 * BLOG
 */
 
ALTER TABLE `tx_blog` CHANGE `date_issued` `date_issued` VARCHAR(20); 
UPDATE `tx_blog` SET `date_issued` = FROM_UNIXTIME(`date_issued`);
ALTER TABLE `tx_blog` CHANGE `date_issued` `date_issued` DATE; 
 
ALTER TABLE `tx_blog` CHANGE `created_at` `created_at` VARCHAR(20); 
UPDATE `tx_blog` SET `created_at` = FROM_UNIXTIME(`created_at`);
ALTER TABLE `tx_blog` CHANGE `created_at` `created_at` DATETIME; 

ALTER TABLE `tx_blog` CHANGE `updated_at` `updated_at` VARCHAR(20); 
UPDATE `tx_blog` SET `updated_at` = FROM_UNIXTIME(`updated_at`);
ALTER TABLE `tx_blog` CHANGE `updated_at` `updated_at` DATETIME; 

ALTER TABLE `tx_blog` CHANGE `deleted_at` `deleted_at` VARCHAR(20); 
UPDATE `tx_blog` SET `deleted_at` = FROM_UNIXTIME(`deleted_at`);
ALTER TABLE `tx_blog` CHANGE `deleted_at` `deleted_at` DATETIME; 

ALTER TABLE `tx_blog` CHANGE category_id blog_category_id INT;



/**
 * CATEGORY
 */
ALTER TABLE `tx_category` CHANGE `created_at` `created_at` VARCHAR(20); 
UPDATE `tx_category` SET `created_at` = FROM_UNIXTIME(`created_at`);
ALTER TABLE `tx_category` CHANGE `created_at` `created_at` DATETIME; 

ALTER TABLE `tx_category` CHANGE `updated_at` `updated_at` VARCHAR(20); 
UPDATE `tx_category` SET `updated_at` = FROM_UNIXTIME(`updated_at`);
ALTER TABLE `tx_category` CHANGE `updated_at` `updated_at` DATETIME; 

ALTER TABLE `tx_category` CHANGE `deleted_at` `deleted_at` VARCHAR(20); 
UPDATE `tx_category` SET `deleted_at` = FROM_UNIXTIME(`deleted_at`);
ALTER TABLE `tx_category` CHANGE `deleted_at` `deleted_at` DATETIME; 

RENAME TABLE `tx_category` TO `tx_blog_category`;


/**
 * COUNTER
 */
ALTER TABLE `tx_counter` CHANGE `created_at` `created_at` VARCHAR(20); 
UPDATE `tx_counter` SET `created_at` = FROM_UNIXTIME(`created_at`);
ALTER TABLE `tx_counter` CHANGE `created_at` `created_at` DATETIME; 

ALTER TABLE `tx_counter` CHANGE `updated_at` `updated_at` VARCHAR(20); 
UPDATE `tx_counter` SET `updated_at` = FROM_UNIXTIME(`updated_at`);
ALTER TABLE `tx_counter` CHANGE `updated_at` `updated_at` DATETIME; 

ALTER TABLE `tx_counter` CHANGE `deleted_at` `deleted_at` VARCHAR(20); 
UPDATE `tx_counter` SET `deleted_at` = FROM_UNIXTIME(`deleted_at`);
ALTER TABLE `tx_counter` CHANGE `deleted_at` `deleted_at` DATETIME;


/**
 * COUNTER
 */
ALTER TABLE `tx_employment` CHANGE `created_at` `created_at` VARCHAR(20); 
UPDATE `tx_employment` SET `created_at` = FROM_UNIXTIME(`created_at`);
ALTER TABLE `tx_employment` CHANGE `created_at` `created_at` DATETIME; 

ALTER TABLE `tx_employment` CHANGE `updated_at` `updated_at` VARCHAR(20); 
UPDATE `tx_employment` SET `updated_at` = FROM_UNIXTIME(`updated_at`);
ALTER TABLE `tx_employment` CHANGE `updated_at` `updated_at` DATETIME; 

ALTER TABLE `tx_employment` CHANGE `deleted_at` `deleted_at` VARCHAR(20); 
UPDATE `tx_employment` SET `deleted_at` = FROM_UNIXTIME(`deleted_at`);
ALTER TABLE `tx_employment` CHANGE `deleted_at` `deleted_at` DATETIME; 


/**
 * EVENT
 */
 
ALTER TABLE `tx_event` CHANGE `date_start` `date_start` VARCHAR(20); 
UPDATE `tx_event` SET `date_start` = FROM_UNIXTIME(`date_start`);
ALTER TABLE `tx_event` CHANGE `date_start` `date_start` DATETIME;

ALTER TABLE `tx_event` CHANGE `date_end` `date_end` VARCHAR(20); 
UPDATE `tx_event` SET `date_end` = FROM_UNIXTIME(`date_end`);
ALTER TABLE `tx_event` CHANGE `date_end` `date_end` DATETIME; 
 
ALTER TABLE `tx_event` CHANGE `created_at` `created_at` VARCHAR(20); 
UPDATE `tx_event` SET `created_at` = FROM_UNIXTIME(`created_at`);
ALTER TABLE `tx_event` CHANGE `created_at` `created_at` DATETIME; 

ALTER TABLE `tx_event` CHANGE `updated_at` `updated_at` VARCHAR(20); 
UPDATE `tx_event` SET `updated_at` = FROM_UNIXTIME(`updated_at`);
ALTER TABLE `tx_event` CHANGE `updated_at` `updated_at` DATETIME; 

ALTER TABLE `tx_event` CHANGE `deleted_at` `deleted_at` VARCHAR(20); 
UPDATE `tx_event` SET `deleted_at` = FROM_UNIXTIME(`deleted_at`);
ALTER TABLE `tx_event` CHANGE `deleted_at` `deleted_at` DATETIME; 



/**
 * OFFICE
 */
ALTER TABLE `tx_office` CHANGE `created_at` `created_at` VARCHAR(20); 
UPDATE `tx_office` SET `created_at` = FROM_UNIXTIME(`created_at`);
ALTER TABLE `tx_office` CHANGE `created_at` `created_at` DATETIME; 

ALTER TABLE `tx_office` CHANGE `updated_at` `updated_at` VARCHAR(20); 
UPDATE `tx_office` SET `updated_at` = FROM_UNIXTIME(`updated_at`);
ALTER TABLE `tx_office` CHANGE `updated_at` `updated_at` DATETIME; 

ALTER TABLE `tx_office` CHANGE `deleted_at` `deleted_at` VARCHAR(20); 
UPDATE `tx_office` SET `deleted_at` = FROM_UNIXTIME(`deleted_at`);
ALTER TABLE `tx_office` CHANGE `deleted_at` `deleted_at` DATETIME; 


/**
 * QUOTE
 */
ALTER TABLE `tx_quote` CHANGE `created_at` `created_at` VARCHAR(20); 
UPDATE `tx_quote` SET `created_at` = FROM_UNIXTIME(`created_at`);
ALTER TABLE `tx_quote` CHANGE `created_at` `created_at` DATETIME; 

ALTER TABLE `tx_quote` CHANGE `updated_at` `updated_at` VARCHAR(20); 
UPDATE `tx_quote` SET `updated_at` = FROM_UNIXTIME(`updated_at`);
ALTER TABLE `tx_quote` CHANGE `updated_at` `updated_at` DATETIME; 

ALTER TABLE `tx_quote` CHANGE `deleted_at` `deleted_at` VARCHAR(20); 
UPDATE `tx_quote` SET `deleted_at` = FROM_UNIXTIME(`deleted_at`);
ALTER TABLE `tx_quote` CHANGE `deleted_at` `deleted_at` DATETIME; 


/**
 * SITE - LINK
 */
ALTER TABLE `tx_quote` CHANGE `created_at` `created_at` VARCHAR(20); 
UPDATE `tx_quote` SET `created_at` = FROM_UNIXTIME(`created_at`);
ALTER TABLE `tx_quote` CHANGE `created_at` `created_at` DATETIME; 

ALTER TABLE `tx_quote` CHANGE `updated_at` `updated_at` VARCHAR(20); 
UPDATE `tx_quote` SET `updated_at` = FROM_UNIXTIME(`updated_at`);
ALTER TABLE `tx_quote` CHANGE `updated_at` `updated_at` DATETIME; 

ALTER TABLE `tx_quote` CHANGE `deleted_at` `deleted_at` VARCHAR(20); 
UPDATE `tx_quote` SET `deleted_at` = FROM_UNIXTIME(`deleted_at`);
ALTER TABLE `tx_quote` CHANGE `deleted_at` `deleted_at` DATETIME; 


/**
 * SOCIAL MEDIA
 */
ALTER TABLE `tx_social_media` CHANGE `created_at` `created_at` VARCHAR(20); 
UPDATE `tx_social_media` SET `created_at` = FROM_UNIXTIME(`created_at`);
ALTER TABLE `tx_social_media` CHANGE `created_at` `created_at` DATETIME; 

ALTER TABLE `tx_social_media` CHANGE `updated_at` `updated_at` VARCHAR(20); 
UPDATE `tx_social_media` SET `updated_at` = FROM_UNIXTIME(`updated_at`);
ALTER TABLE `tx_social_media` CHANGE `updated_at` `updated_at` DATETIME; 

ALTER TABLE `tx_social_media` CHANGE `deleted_at` `deleted_at` VARCHAR(20); 
UPDATE `tx_social_media` SET `deleted_at` = FROM_UNIXTIME(`deleted_at`);
ALTER TABLE `tx_social_media` CHANGE `deleted_at` `deleted_at` DATETIME; 


/**
 * STAFF
 */
ALTER TABLE `tx_staff` CHANGE `created_at` `created_at` VARCHAR(20); 
UPDATE `tx_staff` SET `created_at` = FROM_UNIXTIME(`created_at`);
ALTER TABLE `tx_staff` CHANGE `created_at` `created_at` DATETIME; 

ALTER TABLE `tx_staff` CHANGE `updated_at` `updated_at` VARCHAR(20); 
UPDATE `tx_staff` SET `updated_at` = FROM_UNIXTIME(`updated_at`);
ALTER TABLE `tx_staff` CHANGE `updated_at` `updated_at` DATETIME; 

ALTER TABLE `tx_staff` CHANGE `deleted_at` `deleted_at` VARCHAR(20); 
UPDATE `tx_staff` SET `deleted_at` = FROM_UNIXTIME(`deleted_at`);
ALTER TABLE `tx_staff` CHANGE `deleted_at` `deleted_at` DATETIME; 



/**
 * THEME
 */
ALTER TABLE `tx_theme` CHANGE `created_at` `created_at` VARCHAR(20); 
UPDATE `tx_theme` SET `created_at` = FROM_UNIXTIME(`created_at`);
ALTER TABLE `tx_theme` CHANGE `created_at` `created_at` DATETIME; 

ALTER TABLE `tx_theme` CHANGE `updated_at` `updated_at` VARCHAR(20); 
UPDATE `tx_theme` SET `updated_at` = FROM_UNIXTIME(`updated_at`);
ALTER TABLE `tx_theme` CHANGE `updated_at` `updated_at` DATETIME; 

ALTER TABLE `tx_theme` CHANGE `deleted_at` `deleted_at` VARCHAR(20); 
UPDATE `tx_theme` SET `deleted_at` = FROM_UNIXTIME(`deleted_at`);
ALTER TABLE `tx_theme` CHANGE `deleted_at` `deleted_at` DATETIME; 


/**
 * THEME DETAIL
 */
ALTER TABLE `tx_theme_detail` CHANGE `created_at` `created_at` VARCHAR(20); 
UPDATE `tx_theme_detail` SET `created_at` = FROM_UNIXTIME(`created_at`);
ALTER TABLE `tx_theme_detail` CHANGE `created_at` `created_at` DATETIME; 

ALTER TABLE `tx_theme_detail` CHANGE `updated_at` `updated_at` VARCHAR(20); 
UPDATE `tx_theme_detail` SET `updated_at` = FROM_UNIXTIME(`updated_at`);
ALTER TABLE `tx_theme_detail` CHANGE `updated_at` `updated_at` DATETIME; 

ALTER TABLE `tx_theme_detail` CHANGE `deleted_at` `deleted_at` VARCHAR(20); 
UPDATE `tx_theme_detail` SET `deleted_at` = FROM_UNIXTIME(`deleted_at`);
ALTER TABLE `tx_theme_detail` CHANGE `deleted_at` `deleted_at` DATETIME; 