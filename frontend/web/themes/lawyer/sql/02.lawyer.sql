SET SQL_SAFE_UPDATES = 0;

insert  into `tx_theme`(`id`,`title`,`description`,`verlock`,
`created_at`,`updated_at`,`created_by`,`updated_by`) 
values 
(2,'Lawyer','Unify263 Lawyer One Page',1,
NOW(),NOW(),1,0);


INSERT  INTO `tx_theme_detail`
(`theme_id`,`title`,`token`,`content`,`description`,
`created_at`,`updated_at`,`created_by`,`updated_by`,`verlock`) 
VALUES 
(2,'Image Main','201','IMG',
'IMAGE Ukuran 1600x1066',
NOW(),NOW(),1,1,0);

INSERT  INTO `tx_theme_detail`
(`theme_id`,`title`,`token`,`content`,`description`,
`created_at`,`updated_at`,`created_by`,`updated_by`,`verlock`) 
VALUES 
(2,'Promo Text 1','202','Tajaga <br> Asoe Nanggroe',
'PROMO 1 - HEADER',
NOW(),NOW(),1,1,0);

INSERT  INTO `tx_theme_detail`
(`theme_id`,`title`,`token`,`content`,`description`,
`created_at`,`updated_at`,`created_by`,`updated_by`,`verlock`) 
VALUES 
(2,'Promo Text 2','203',
            'Donec erat urna, tincidunt at leo non, blandit finibus ante.
            <br> Nunc venenatis risus in finibus dapibus. Ut ac massa sodales,
            <br> mattis enim id, efficitur tortor. Nullam',
'PROMO 2 - DESKRIPSI',
NOW(),NOW(),1,1,0);

INSERT  INTO `tx_theme_detail`
(`theme_id`,`title`,`token`,`content`,`description`,
`created_at`,`updated_at`,`created_by`,`updated_by`,`verlock`) 
VALUES 
(2,'We know our job','204',
            'Sed feugiat porttitor nunc, non dignissim ipsum vestibulum in. 
            Donec in blandit dolor. Vivamus a fringilla lorem, vel faucibus ante. 
            Nunc ullamcorper, justo a iaculis elementum, enim orci viverra eros, 
            fringilla porttitor lorem eros vel odio. In rutrum tellus vitae blandit lacinia.',
'ABOUT 1 / Image 1200x800',
NOW(),NOW(),1,1,0);

INSERT  INTO `tx_theme_detail`
(`theme_id`,`title`,`token`,`content`,`description`,
`created_at`,`updated_at`,`created_by`,`updated_by`,`verlock`) 
VALUES 
(2,'We are the best','205',
            'Sed feugiat porttitor nunc, non dignissim ipsum vestibulum in. 
            Donec in blandit dolor. Vivamus a fringilla lorem, vel faucibus ante. 
            Nunc ullamcorper, justo a iaculis elementum, enim orci viverra eros, 
            fringilla porttitor lorem eros vel odio. In rutrum tellus vitae blandit lacinia.',
'ABOUT 2 / Image 1200x800',
NOW(),NOW(),1,1,0);

INSERT  INTO `tx_theme_detail`
(`theme_id`,`title`,`token`,`content`,`description`,
`created_at`,`updated_at`,`created_by`,`updated_by`,`verlock`) 
VALUES 
(2,'We are winners','206',
            'Sed feugiat porttitor nunc, non dignissim ipsum vestibulum in. 
            Donec in blandit dolor. Vivamus a fringilla lorem, vel faucibus ante. 
            Nunc ullamcorper, justo a iaculis elementum, enim orci viverra eros, 
            fringilla porttitor lorem eros vel odio. In rutrum tellus vitae blandit lacinia.',
'ABOUT 3 / Image 1200x800',
NOW(),NOW(),1,1,0);

INSERT  INTO `tx_theme_detail`
(`theme_id`,`title`,`token`,`content`,`description`,
`created_at`,`updated_at`,`created_by`,`updated_by`,`verlock`) 
VALUES 
(2,'Berlangganan Hubungi','207',
            '<p>Proin dignissim eget enim id aliquam. Proin ornare dictum leo, non elementum tellus molestie et. Vivamus sit amet scelerisque leo. In eu commodo est. Sed bibendum a metus ac sollicitudin.</p>
            <p>Curabitur elementum placerat elit vel accumsan. Quisque fermentum libero sit amet condimentum tincidunt. Proin hendrerit nec turpis sit amet aliquet. Integer libero velit, molestie et sagittis non, maximus nec turpis.</p>',
            
'TEAM - Header dan Deskripsi',
NOW(),NOW(),1,1,0);

INSERT  INTO `tx_theme_detail`
(`theme_id`,`title`,`token`,`content`,`description`,
`created_at`,`updated_at`,`created_by`,`updated_by`,`verlock`) 
VALUES 
(2,'Sara Lisbon','208', '+48 555 2566 112',
'TEAM 1 - PROFILE dan NO Telpon / Image 600 x 996',
NOW(),NOW(),1,1,0);

INSERT  INTO `tx_theme_detail`
(`theme_id`,`title`,`token`,`content`,`description`,
`created_at`,`updated_at`,`created_by`,`updated_by`,`verlock`) 
VALUES 
(2,'SAM KING','209', '+48 555 2566 112',
'TEAM 2 - PROFILE dan NO Telpon / Image 600 x 996',
NOW(),NOW(),1,1,0);

INSERT  INTO `tx_theme_detail`
(`theme_id`,`title`,`token`,`content`,`description`,
`created_at`,`updated_at`,`created_by`,`updated_by`,`verlock`) 
VALUES 
(2,'TOMAS KLEPTON','210', '+48 555 2566 112',
'TEAM 3 - PROFILE dan NO Telpon / Image 600 x 996',
NOW(),NOW(),1,1,0);
