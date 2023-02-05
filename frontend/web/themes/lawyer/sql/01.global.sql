SET SQL_SAFE_UPDATES = 0;

DELETE FROM tx_theme_detail;
ALTER TABLE tx_theme_detail AUTO_INCREMENT = 0;

DELETE FROM tx_theme;
ALTER TABLE tx_theme AUTO_INCREMENT = 0;

INSERT  INTO `tx_theme`(`id`,`title`,`description`,`verlock`,
`created_at`,`updated_at`,`created_by`,`updated_by`) 
VALUES 
(1,'Global','Dipakai di semua halaman',0,NOW(),NOW(),1,1);

INSERT  INTO `tx_theme_detail`(`theme_id`,`title`,`token`,`content`,`description`,`created_at`,`updated_at`,`created_by`,`updated_by`,`verlock`) VALUES 
(1,'Logo 1','001','b3MYTwJeYCkb4IUmLrPkjcePntzALUBi.png','Logo 1 - Bagian Atas Kiri',NOW(),NOW(),1,1,0),
(1,'Logo 2','002','q8Z7e_TqQrBwU8URdcZ4I7t62u3-EHCm.png','Logo 2 - Bagian Bawah Kiri',NOW(),NOW(),1,1,0),

(1,'Profile','005','/uploads/web/img5985a8c7b0133.jpg','0',NOW(),NOW(),1,1,0),
(1,'Deskripsi Bawah','006','','-',NOW(),NOW(),1,1,0),
(1,'Footer Links','007','<ul>\r\n	<li><a href=\"http://www.escyber.com\">www.escyber.com</a></li>\r\n</ul>\r\n',NULL,1515422835,1515422835,1,1,0),
(1,'TERMS','008','CONTENT OF TERM','DESCRIPTION OF TERM.',NOW(),NOW(),1,1,0),
(1,'ABOUT','009','CONTENT OF ABOUT','DESCRIPTION OF ABOUT.',NOW(),NOW(),1,1,0),

(1,'SEO Description','011',NULL,'SEO Description',NOW(),NOW(),1,1,0),
(1,'SEO Keyword','012',NULL,'SEO Keyword',NOW(),NOW(),1,1,0),

(1,'Logo Report 1','016','b3MYTwJeYCkb4IUmLrPkjcePntzALUBi.png','Logo 1 - Bagian Atas Kiri',NOW(),NOW(),1,1,0),
(1,'Logo Report 2','017','q8Z7e_TqQrBwU8URdcZ4I7t62u3-EHCm.png','NA',NOW(),NOW(),1,1,0),
(1,'Deskripsi Report','018','q8Z7e_TqQrBwU8URdcZ4I7t62u3-EHCm.png','DESKRIPSI',NOW(),NOW(),1,1,0),

(1,'Facebook','021','<i class=\"fa fa-facebook\"></i>',NULL,NOW(),NOW(),1,1,0),
(1,'Skype','022','<i class=\"fa fa-skype\"></i>',NULL,NOW(),NOW(),1,1,0),
(1,'Google Plus','023','<i class=\"fa fa-google-plus\"></i>',NULL,NOW(),NOW(),1,1,0),
(1,'Linkedin','024','<i class=\"fa fa-linkedin\"></i>',NULL,NOW(),NOW(),1,1,0),
(1,'Pinterest','025','<i class=\"fa fa-pinterest\"></i>',NULL,NOW(),NOW(),1,1,0),
(1,'Twitter','026','<i class=\"fa fa-twitter\"></i>',NULL,NOW(),NOW(),1,1,0),
(1,'Dribbble','027','<i class=\"fa fa-dribbble\"></i>',NULL,NOW(),NOW(),1,1,0);
