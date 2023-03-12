<?php
    use backend\models\Profile;

    $profile = Profile::find()->where(['user_id' => Yii::$app->user->id])->one();

    $profileId = (!empty($profile) ? $profile->user_id : '#' );
    $profileName = (!empty($profile) ? $profile->name : 'Guest' );
    $profileImage = (!empty($profile) ? $profile->getImageUrl() : Yii::$app->urlManager->baseUrl.'/images/no_image.jpg' );


?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $profileImage ?>" class="img-circle" style="width:70px;height:70px" alt="<?=$profileName;?>"/>
            </div>
            <div class="pull-left info">
                <p><?= $profileName ?></p>

                <a href="#"><i class="circle text-success"></i> Online</a>
            </div>
        </div>

    </section>

</aside>



<?php if (!empty($profile)){ ?>
    <aside class="main-sidebar">

        <section class="sidebar">

            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="<?= $profileImage ?>" class="img-circle" style="width:50px;height:50px" alt="<?=$profileName;?>"/>
                </div>
                <div class="pull-left info">
                    <p><?php echo $profileName ?></p>

                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>

            <?= dmstr\widgets\Menu::widget(
                [
                    'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                    'items' => [
                        //['label' => 'Dashboard', 'icon' => 'dashboard', 'url' => ['/site/index'],],
                        
                        [
                            'label' => 'Dashboard',
                            'icon' => 'dashboard',
                            'url' => ['#'],
                            'items' => [
                                ['label' => 'Index', 'icon' => 'angle-right', 'url' => ['/site/index'],],                               
                                [
                                    'label' => 'Profile',
                                    'icon' => 'caret-right',
                                    'url' => ['#'],
                                    'items' => [
                                        ['label' => $profileName, 'icon' => 'angle-right', 'url' => ['/profile/view','id'=>$profileId]],
                                        ['label' => 'Password', 'icon' => 'angle-right', 'url' => ['/admin/update','id'=>Yii::$app->user->id]],
                                    ]
                                ],  
                            ]
                        ],   
                        [
                            'label' => 'Office',
                            'icon' => 'university',
                            'url' => ['#'],
                            'items' => [
                                ['label' => 'Profile', 'icon' => 'angle-right', 'url' => ['/office/index'],],
                                ['label' => 'Jabatan', 'icon' => 'angle-right', 'url' => ['/employment/index'],],
                                ['label' => 'Staff', 'icon' => 'angle-right', 'url' => ['/staff/index'],],
                            ]
                        ],

                        [
                            'label' => 'Blog',
                            'icon' => 'newspaper-o',
                            'url' => ['#'],
                            'items' => [
                                ['label' => 'Penulis', 'icon' => 'angle-right', 'url' => ['/author/index'],],
                                ['label' => 'Kategori', 'icon' => 'angle-right', 'url' => ['/category/index'],],
                                ['label' => 'Blog', 'icon' => 'angle-right', 'url' => ['/blog/index'],],
                                [
                                    'label' => 'Page',
                                    'icon' => 'caret-right',
                                    'url' => ['#'],
                                    'visible' => Yii::$app->params['Feat-Page'],
                                    'items' => [
                                        ['label' => 'Jenis', 'icon' => 'angle-right', 'url' => ['/page-type/index'],],
                                        ['label' => 'Page', 'icon' => 'angle-right', 'url' => ['/page/index'],],
                                    ]
                                ],
                            ]
                        ], 
                        [
                            'label' => 'Portfolio',
                            'icon' => 'suitcase',
                            'url' => ['#'],
                            'visible' => Yii::$app->params['Feat-Portfolio'],
                            'items' => [
                                ['label' => 'Satuan', 'icon' => 'angle-right', 'url' => ['/measure/index'],],
                                ['label' => 'Jenis', 'icon' => 'angle-right', 'url' => ['/product-type/index'],],
                                ['label' => 'Feature', 'icon' => 'angle-right', 'url' => ['/feature/index'],],
                                ['label' => 'Produk', 'icon' => 'angle-right', 'url' => ['/product/index'],],
                                ['label' => 'Pricing', 'icon' => 'angle-right', 'url' => ['/pricing/index'],],
                            ]
                        ],
                                                 
                        [
                            'label' => 'Master',
                            'icon' => 'cloud',
                            'url' => ['#'],
                            'items' => [
                                [
                                    'label' => 'Dokumen',
                                    'icon' => 'caret-right',
                                    'url' => ['#'],
                                    'visible' => Yii::$app->params['Feat-Archive'],
                                    'items' => [
                                        ['label' => 'Kategori', 'icon' => 'angle-right', 'url' => ['/archive-category/index'],],
                                        ['label' => 'Arsip', 'icon' => 'angle-right', 'url' => ['/archive/index'],],
                                    ]
                                ],
                                ['label' => 'Album', 'visible' => Yii::$app->params['Feat-Album'], 'icon' => 'angle-right', 'url' => ['/album/index'],],
                                ['label' => 'Photo', 'visible' => Yii::$app->params['Feat-Album'], 'icon' => 'angle-right', 'url' => ['/photo/index'],],
                                ['label' => 'Event', 'visible' => Yii::$app->params['Feat-Event'], 'icon' => 'angle-right', 'url' => ['/event/index'],],
                                ['label' => 'Quote', 'visible' => Yii::$app->params['Feat-Quote'], 'icon' => 'angle-right', 'url' => ['/quote/index'],],
                                ['label' => 'Subscriber', 'visible' => Yii::$app->params['Feat-Subscriber'], 'icon' => 'angle-right', 'url' => ['/subscriber/index'],],
                            ]
                        ],

                        [
                            'label' => 'Layout',
                            'icon' => 'laptop',
                            'url' => ['#'],
                            'items' => [
                                //['label' => 'Theme', 'icon' => 'angle-right', 'url' => ['/theme/index'],],
                                ['label' => 'Index', 'icon' => 'angle-right', 'url' => ['/theme-detail/index'],],
                                ['label' => 'Links', 'icon' => 'angle-right', 'url' => ['/site-link/index'],],
                                ['label' => 'Social', 'icon' => 'angle-right', 'url' => ['/social-media/index'],],
                            ],
                            'visible' => Yii::$app->user->identity->isAdmin
                        ],

                        [
                            'label' => 'Admin',
                            'icon' => 'database',
                            'url' => ['#'],
                            'items' => [
                                ['label' => 'User', 'icon' => 'angle-right', 'url' => ['/user/admin/index'],],
                                ['label' => 'Gii', 'icon' => 'angle-right', 'url' => ['/gii']],
                            ],
                            'visible' => Yii::$app->user->identity->isAdmin
                        ],

                        ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],

                    ],
                ]
            ) ?>

        </section>

    </aside>
<?php } ?>
