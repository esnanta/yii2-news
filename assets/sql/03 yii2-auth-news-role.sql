/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  Nanta Es
 * Created: Aug 29, 2021
 */

insert  into `tx_auth_item_child`(`parent`,`child`)
values
    ('admin','create-user-owner');

insert  into `tx_auth_item_child`(`parent`,`child`)
values
    ('admin','index-master'),
    ('admin','create-master'),
    ('admin','update-master'),
    ('admin','view-master'),
    ('admin','delete-master'),
    ('admin','report-master');

insert  into `tx_auth_item_child`(`parent`,`child`)
values
    ('admin','index-transaction'),
    ('admin','create-transaction'),
    ('admin','update-transaction'),
    ('admin','view-transaction'),
    ('admin','delete-transaction'),
    ('admin','report-transaction');

insert  into `tx_auth_item_child`(`parent`,`child`)
values
    ('regular','index-transaction'),
    ('regular','create-transaction'),
    ('regular','update-transaction'),
    ('regular','view-transaction'),
    ('regular','delete-transaction'),
    ('regular','report-transaction');

insert  into `tx_auth_item_child`(`parent`,`child`)
values
    ('regular','update-profile'),
    ('regular','view-profile');

insert  into `tx_auth_item_child`(`parent`,`child`)
values
    ('guest','index-asset'),
    ('guest','view-asset');

insert  into `tx_auth_item_child`(`parent`,`child`)
values
    ('guest','index-article'),
    ('guest','view-article');
