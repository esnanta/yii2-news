<?php

use kartik\widgets\SideNav;
// OR if this package is installed separately, you can use
// use kartik\sidenav\SideNav;

?>
<?php $this->registerCsrfMetaTags() ?>


<div id="sideNav" class="col-auto u-sidebar-navigation-v1 u-sidebar-navigation--dark">

<?php
if (!Yii::$app->user->isGuest) {
    echo SideNav::widget([
        'type' => SideNav::TYPE_DEFAULT,
        'encodeLabels' => false,
        
        'items' => [
            ['label' => 'Home', 'icon' => 'home', 'url' => ['/site/index']],
            ['label' => 'Archive', 'icon' => 'book', 'items' => [
                ['label' => 'Archive Category', 'url' => ['/archive-category/index']],
                ['label' => 'Archive', 'url' => ['/archive/index']],
            ]],
            
            ['label' => 'Logout', 'icon' => 'sign-out-alt', 
                'url' => ['/user/logout'],
                'template'=>'<a href="{url}" data-method="post" data-confirm="Logout now?" class="nav-link text-secondary nav-link">{icon}{label}</a>',
            ],
            
            ['label' => 'Admin', 'icon' => 'wrench', 'items' => [
                ['label' => 'Users', 'url' => ['/user/admin/index']],
                ['label' => 'Gii', 'url' => ['/gii']],
            ], 'visible' => Yii::$app->user->identity->isAdmin],
            
        ],
    ]);  
}
else{
    echo SideNav::widget([
        'type' => SideNav::TYPE_SECONDARY,
        'encodeLabels' => false,
        'heading' => '<i class="fas fa-user-shield"></i> Credentials',
        'items' => [
            ['label' => 'Login', 'icon' => 'lock', 'url' => ['/user/login']],
        ],
    ]);  
}
?>
</div>