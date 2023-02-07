/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  Nanta Es
 * Created: Aug 29, 2021
 */


insert  into `tx_auth_item_child`(`parent`,`child`) values
('admin','index-master'),
('admin','create-master'),
('admin','update-master'),
('admin','view-master'),
('admin','delete-master'),
('admin','report-master');

insert  into `tx_auth_item_child`(`parent`,`child`) values
('admin','index-transaction'),
('admin','create-transaction'),
('admin','update-transaction'),
('admin','view-transaction'),
('admin','delete-transaction'),
('admin','report-transaction');

insert  into `tx_auth_item_child`(`parent`,`child`) values
('reguler','index-transaction'),
('reguler','create-transaction'),
('reguler','update-transaction'),
('reguler','view-transaction'),
('reguler','delete-transaction'),
('reguler','report-transaction');

insert  into `tx_auth_item_child`(`parent`,`child`) values
('reguler','update-profile'),
('reguler','view-profile');

insert  into `tx_auth_item_child`(`parent`,`child`) values
('guest','index-archive'),
('guest','view-archive');

