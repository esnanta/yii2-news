

delete from tx_auth_assignment;
delete from tx_auth_item_child;
delete from tx_auth_item;

/*Data for the table `tx_auth_item` */
/* TYPE 1 = ROLE */
insert  into `tx_auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values 
('admin',1,'Admin',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
('reguler',1,'Reguler',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
('guest',1,'Guest',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP());

/* TYPE 2 = ITEM */
insert  into `tx_auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values 

('index-master',2,'Index Master',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
('create-master',2,'Create Master',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
('update-master',2,'Update Master',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
('view-master',2,'View Master',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
('delete-master',2,'Delete Master',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
('report-master',2,'Report Master',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP());

insert  into `tx_auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values
('index-transaction',2,'Index Transaction',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
('create-transaction',2,'Create Transaction',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
('update-transaction',2,'Update Transaction',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
('view-transaction',2,'View Transaction',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
('delete-transaction',2,'Delete Transaction',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
('report-transaction',2,'Report Transaction',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP());


insert  into `tx_auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values
('index-archive',2,'Index Archive',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
('create-archive',2,'Create Archive',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
('update-archive',2,'Update Archive',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
('view-archive',2,'View Archive',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
('delete-archive',2,'Delete Archive',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
('report-archive',2,'Report Archive',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP());

insert  into `tx_auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values
('index-author',2,'Index Author',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
('create-author',2,'Create Author',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
('update-author',2,'Update Author',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
('view-author',2,'View Author',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
('delete-author',2,'Delete Author',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP());

insert  into `tx_auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values
('index-blog',2,'Index Blog',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
('create-blog',2,'Create Blog',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
('update-blog',2,'Update Blog',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
('view-blog',2,'View Blog',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
('delete-blog',2,'Delete Blog',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP());

insert  into `tx_auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values
('index-category',2,'Index Category',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
('create-category',2,'Create Category',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
('update-category',2,'Update Category',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
('view-category',2,'View Category',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
('delete-category',2,'Delete Category',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP());

insert  into `tx_auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values
('index-employment',2,'Index Employment',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
('create-employment',2,'Create Employment',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
('update-employment',2,'Update Employment',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
('view-employment',2,'View Employment',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
('delete-employment',2,'Delete Employment',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP());

insert  into `tx_auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values
('index-event',2,'Index Event',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
('create-event',2,'Create Event',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
('update-event',2,'Update Event',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
('view-event',2,'View Event',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
('delete-event',2,'Delete Event',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP());

insert  into `tx_auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values
('index-office',2,'Index Office',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
('create-office',2,'Create Office',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
('update-office',2,'Update Office',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
('view-office',2,'View Office',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
('delete-office',2,'Delete Office',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP());

insert  into `tx_auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values
('index-profile',2,'Index Profile',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
('create-profile',2,'Create Profile',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
('update-profile',2,'Update Profile',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
('view-profile',2,'View Profile',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
('delete-profile',2,'Delete Profile',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP());

insert  into `tx_auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values
('index-quote',2,'Index Quote',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
('create-quote',2,'Create Quote',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
('update-quote',2,'Update Quote',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
('view-quote',2,'View Quote',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
('delete-quote',2,'Delete Quote',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP());

insert  into `tx_auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values
('index-staff',2,'Index Staff',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
('create-staff',2,'Create Staff',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
('update-staff',2,'Update Staff',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
('view-staff',2,'View Staff',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
('delete-staff',2,'Delete Staff',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP());

insert  into `tx_auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values
('index-theme',2,'Index Theme',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
('create-theme',2,'Create Theme',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
('update-theme',2,'Update Theme',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
('view-theme',2,'View Theme',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP()),
('delete-theme',2,'Delete Theme',NULL,NULL,UNIX_TIMESTAMP(),UNIX_TIMESTAMP());





/*Data for the table `tx_auth_item_child` */


insert  into `tx_auth_item_child`(`parent`,`child`) values
('index-master','index-author'),
('create-master','create-author'),
('update-master','update-author'),
('view-master','view-author'),
('delete-master','delete-author');

insert  into `tx_auth_item_child`(`parent`,`child`) values
('index-master','index-category'),
('create-master','create-category'),
('update-master','update-category'),
('view-master','view-category'),
('delete-master','delete-category');

insert  into `tx_auth_item_child`(`parent`,`child`) values
('index-master','index-employment'),
('create-master','create-employment'),
('update-master','update-employment'),
('view-master','view-employment'),
('delete-master','delete-employment');

insert  into `tx_auth_item_child`(`parent`,`child`) values
('index-master','index-event'),
('create-master','create-event'),
('update-master','update-event'),
('view-master','view-event'),
('delete-master','delete-event');

insert  into `tx_auth_item_child`(`parent`,`child`) values
('index-master','index-office'),
('create-master','create-office'),
('update-master','update-office'),
('view-master','view-office'),
('delete-master','delete-office');

insert  into `tx_auth_item_child`(`parent`,`child`) values
('index-master','index-profile'),
('create-master','create-profile'),
('update-master','update-profile'),
('view-master','view-profile'),
('delete-master','delete-profile');

insert  into `tx_auth_item_child`(`parent`,`child`) values
('index-master','index-quote'),
('create-master','create-quote'),
('update-master','update-quote'),
('view-master','view-quote'),
('delete-master','delete-quote');

insert  into `tx_auth_item_child`(`parent`,`child`) values
('index-master','index-staff'),
('create-master','create-staff'),
('update-master','update-staff'),
('view-master','view-staff'),
('delete-master','delete-staff');

insert  into `tx_auth_item_child`(`parent`,`child`) values
('index-master','index-theme'),
('create-master','create-theme'),
('update-master','update-theme'),
('view-master','view-theme'),
('delete-master','delete-theme');

insert  into `tx_auth_item_child`(`parent`,`child`) values
('index-transaction','index-archive'),
('create-transaction','create-archive'),
('update-transaction','update-archive'),
('view-transaction','view-archive'),
('delete-transaction','delete-archive'),
('report-transaction','report-archive');

insert  into `tx_auth_item_child`(`parent`,`child`) values
('index-transaction','index-blog'),
('create-transaction','create-blog'),
('update-transaction','update-blog'),
('view-transaction','view-blog'),
('delete-transaction','delete-blog');

/*Data for the table `tx_auth_assignment` */
/* ALOKASI ITEM KEPADA USER */
insert  into `tx_auth_assignment`(`item_name`,`user_id`,`created_at`) values 
('admin','1',UNIX_TIMESTAMP());