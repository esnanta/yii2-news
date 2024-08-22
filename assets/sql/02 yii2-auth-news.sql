

delete from tx_auth_assignment;
delete from tx_auth_item_child;
delete from tx_auth_item;

/*Data for the table `tx_auth_item` */
/* TYPE 1 = ROLE */
insert  into `tx_auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values
                                                                                                          ('admin',1,'Admin',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
                                                                                                          ('regular',1,'Reguler',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
                                                                                                          ('guest',1,'Guest',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP());

/*Data for the table `tx_auth_assignment` */
/* ALOKASI ITEM KEPADA USER */
insert  into `tx_auth_assignment`(`item_name`,`user_id`,`created_at`)
values
    ('admin','1',UNIX_TIMESTAMP());

/* TYPE 2 = ITEM */
insert  into `tx_auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`)
values
    ('create-user-owner',2,'Create User Owner',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('create-user-regular',2,'Create User Regular',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP());

insert  into `tx_auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`)
values
    ('index-master',2,'Index Master',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('create-master',2,'Create Master',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('update-master',2,'Update Master',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('view-master',2,'View Master',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('delete-master',2,'Delete Master',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('report-master',2,'Report Master',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP());

insert  into `tx_auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`)
values
    ('index-transaction',2,'Index Transaction',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('create-transaction',2,'Create Transaction',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('update-transaction',2,'Update Transaction',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('view-transaction',2,'View Transaction',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('delete-transaction',2,'Delete Transaction',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('report-transaction',2,'Report Transaction',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP());

insert  into `tx_auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`)
values
    ('index-article',2,'Index Article',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('create-article',2,'Create Article',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('update-article',2,'Update Article',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('view-article',2,'View Article',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('delete-article',2,'Delete Article',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('report-article',2,'Report Article',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP());

insert  into `tx_auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`)
values
    ('index-articlecategory',2,'Index Article Category',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('create-articlecategory',2,'Create Article Category',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('update-articlecategory',2,'Update Archive Category',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('view-articlecategory',2,'View Article Category',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('delete-articlecategory',2,'Delete Article Category',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('report-articlecategory',2,'Report Article Category',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP());

insert  into `tx_auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`)
values
    ('index-asset',2,'Index Asset',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('create-asset',2,'Create Asset',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('update-asset',2,'Update Asset',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('view-asset',2,'View Asset',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('delete-asset',2,'Delete Asset',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('report-asset',2,'Report Asset',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP());

insert  into `tx_auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`)
values
    ('index-assetcategory',2,'Index Asset Category',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('create-assetcategory',2,'Create Asset Category',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('update-assetcategory',2,'Update Asset Category',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('view-assetcategory',2,'View Asset Category',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('delete-assetcategory',2,'Delete Asset Category',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('report-assetcategory',2,'Report Asset Category',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP());

insert  into `tx_auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`)
values
    ('index-author',2,'Index Author',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('create-author',2,'Create Author',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('update-author',2,'Update Author',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('view-author',2,'View Author',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('delete-author',2,'Delete Author',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP());

insert  into `tx_auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`)
values
    ('index-authormedia',2,'Index Author Media',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('create-authormedia',2,'Create Author Media',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('update-authormedia',2,'Update Author Media',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('view-authormedia',2,'View Author Media',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('delete-authormedia',2,'Delete Author Media',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP());

insert  into `tx_auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`)
values
    ('index-employment',2,'Index Employment',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('create-employment',2,'Create Employment',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('update-employment',2,'Update Employment',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('view-employment',2,'View Employment',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('delete-employment',2,'Delete Employment',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP());

insert  into `tx_auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`)
values
    ('index-event',2,'Index Event',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('create-event',2,'Create Event',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('update-event',2,'Update Event',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('view-event',2,'View Event',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('delete-event',2,'Delete Event',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP());

insert  into `tx_auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`)
values
    ('index-office',2,'Index Office',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('create-office',2,'Create Office',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('update-office',2,'Update Office',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('view-office',2,'View Office',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('delete-office',2,'Delete Office',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP());

insert  into `tx_auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`)
values
    ('index-officemedia',2,'Index Office Media',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('create-officemedia',2,'Create Office Media',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('update-officemedia',2,'Update Office Media',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('view-officemedia',2,'View Office Media',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('delete-officemedia',2,'Delete Office Media',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP());

insert  into `tx_auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`)
values
    ('index-profile',2,'Index Profile',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('create-profile',2,'Create Profile',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('update-profile',2,'Update Profile',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('view-profile',2,'View Profile',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('delete-profile',2,'Delete Profile',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP());

insert  into `tx_auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`)
values
    ('index-quote',2,'Index Quote',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('create-quote',2,'Create Quote',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('update-quote',2,'Update Quote',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('view-quote',2,'View Quote',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('delete-quote',2,'Delete Quote',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP());

insert  into `tx_auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`)
values
    ('index-staff',2,'Index Staff',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('create-staff',2,'Create Staff',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('update-staff',2,'Update Staff',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('view-staff',2,'View Staff',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('delete-staff',2,'Delete Staff',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP());

insert  into `tx_auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`)
values
    ('index-staffmedia',2,'Index Staff Media',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('create-staffmedia',2,'Create Staff Media',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('update-staffmedia',2,'Update Staff Media',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('view-staffmedia',2,'View Staff Media',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('delete-staffmedia',2,'Delete Staff Media',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP());

insert  into `tx_auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`)
values
    ('index-page',2,'Index Page',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('create-page',2,'Create Page',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('update-page',2,'Update Page',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('view-page',2,'View Page',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
    ('delete-page',2,'Delete Page',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP());


/*Data for the table `tx_auth_item_child` */

insert  into `tx_auth_item_child`(`parent`,`child`)
values
    ('index-master','index-articlecategory'),
    ('create-master','create-articlecategory'),
    ('update-master','update-articlecategory'),
    ('view-master','view-articlecategory'),
    ('delete-master','delete-articlecategory'),
    ('report-master','report-articlecategory');

insert  into `tx_auth_item_child`(`parent`,`child`)
values
    ('index-master','index-assetcategory'),
    ('create-master','create-assetcategory'),
    ('update-master','update-assetcategory'),
    ('view-master','view-assetcategory'),
    ('delete-master','delete-assetcategory'),
    ('report-master','report-assetcategory');

insert  into `tx_auth_item_child`(`parent`,`child`)
values
    ('index-master','index-author'),
    ('create-master','create-author'),
    ('update-master','update-author'),
    ('view-master','view-author'),
    ('delete-master','delete-author');

insert  into `tx_auth_item_child`(`parent`,`child`)
values
    ('index-master','index-authormedia'),
    ('create-master','create-authormedia'),
    ('update-master','update-authormedia'),
    ('view-master','view-authormedia'),
    ('delete-master','delete-authormedia');

insert  into `tx_auth_item_child`(`parent`,`child`)
values
    ('index-master','index-employment'),
    ('create-master','create-employment'),
    ('update-master','update-employment'),
    ('view-master','view-employment'),
    ('delete-master','delete-employment');

insert  into `tx_auth_item_child`(`parent`,`child`)
values
    ('index-master','index-event'),
    ('create-master','create-event'),
    ('update-master','update-event'),
    ('view-master','view-event'),
    ('delete-master','delete-event');

insert  into `tx_auth_item_child`(`parent`,`child`)
values
    ('index-master','index-office'),
    ('create-master','create-office'),
    ('update-master','update-office'),
    ('view-master','view-office'),
    ('delete-master','delete-office');

insert  into `tx_auth_item_child`(`parent`,`child`)
values
    ('index-master','index-officemedia'),
    ('create-master','create-officemedia'),
    ('update-master','update-officemedia'),
    ('view-master','view-officemedia'),
    ('delete-master','delete-officemedia');

insert  into `tx_auth_item_child`(`parent`,`child`)
values
    ('index-master','index-profile'),
    ('create-master','create-profile'),
    ('update-master','update-profile'),
    ('view-master','view-profile'),
    ('delete-master','delete-profile');

insert  into `tx_auth_item_child`(`parent`,`child`)
values
    ('index-master','index-quote'),
    ('create-master','create-quote'),
    ('update-master','update-quote'),
    ('view-master','view-quote'),
    ('delete-master','delete-quote');

insert  into `tx_auth_item_child`(`parent`,`child`)
values
    ('index-master','index-staff'),
    ('create-master','create-staff'),
    ('update-master','update-staff'),
    ('view-master','view-staff'),
    ('delete-master','delete-staff');

insert  into `tx_auth_item_child`(`parent`,`child`)
values
    ('index-master','index-staffmedia'),
    ('create-master','create-staffmedia'),
    ('update-master','update-staffmedia'),
    ('view-master','view-staffmedia'),
    ('delete-master','delete-staffmedia');

insert  into `tx_auth_item_child`(`parent`,`child`)
values
    ('index-master','index-page'),
    ('create-master','create-page'),
    ('update-master','update-page'),
    ('view-master','view-page'),
    ('delete-master','delete-page');

insert  into `tx_auth_item_child`(`parent`,`child`)
values
    ('index-transaction','index-article'),
    ('create-transaction','create-article'),
    ('update-transaction','update-article'),
    ('view-transaction','view-article'),
    ('delete-transaction','delete-article');

insert  into `tx_auth_item_child`(`parent`,`child`)
values
    ('index-transaction','index-asset'),
    ('create-transaction','create-asset'),
    ('update-transaction','update-asset'),
    ('view-transaction','view-asset'),
    ('delete-transaction','delete-asset');

insert  into `tx_auth_item_child`(`parent`,`child`)
values
    ('index-transaction','create-user-regular');

