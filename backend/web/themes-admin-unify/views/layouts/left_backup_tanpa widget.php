<?php

use yii\widgets\Menu;
use yii\helpers\Html;
use backend\widgets\LeftMenu as CustomMenu;
use backend\widgets\DmstrMenu;
?>

<?php

function getMenu($_menuName, $_menuIcon='hs-admin-shift-right-alt') {
    $menuLinks = '<span class="d-flex align-self-center g-mr-15 g-mt-minus-1">' .
            '<i class="'.$_menuIcon.'"></i>' .
            '</span>' .
            '<span class="media-body align-self-center">' . $_menuName . '</span>';

    return $menuLinks;
}
?>

<div id="sideNav" class="col-auto u-sidebar-navigation-v1 u-sidebar-navigation--dark">
    <ul id="sideNavMenu" class="u-sidebar-navigation-v1-menu u-side-nav--top-level-menu g-min-height-100vh mb-0">

        <?php if (!Yii::$app->user->isGuest) { ?>
        
        <!-- Dashboard -->
        <li class="u-sidebar-navigation-v1-menu-item u-side-nav--top-level-menu-item">
            <?= Html::a(getMenu('Dashboard'), ['/site/index'], ['class' => 'media u-side-nav--second-level-menu-link g-px-15 g-py-12']) ?>
        </li>
        <!-- End Dashboard -->

        <?= $this->render('left-master',['subMenuSidebar'=>'subMenuMaster']) ?>
        <?= $this->render('left-admin',['subMenuSidebar'=>'subMenuAdmin']) ?>
        <?php } else { ?>
        <!-- Login -->
        <li class="u-sidebar-navigation-v1-menu-item u-side-nav--top-level-menu-item">
            <?= Html::a(getMenu('Login','hs-admin-key'), ['/user/login'], ['class' => 'media u-side-nav--second-level-menu-link g-px-15 g-py-12']) ?>
        </li>
        <!-- End Login -->
        <?php } ?>
    </ul>
</div>