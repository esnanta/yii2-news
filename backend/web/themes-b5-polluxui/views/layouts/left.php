<?php

use yii\helpers\Html;
?>

<?php

function getMenu($_menuName,$_icon='hs-admin-angle-double-right') {
    $menuLinks = '<span class="d-flex align-self-center g-mr-15 g-mt-minus-1">' .
            '<i class="'.$_icon.'"></i>' .
            '</span>' .
            '<span class="media-body align-self-center">' . $_menuName . '</span>';

    return $menuLinks;
}
?>

<div id="sideNav" class="col-auto u-sidebar-navigation-v1 u-sidebar-navigation--dark">
    <ul id="sideNavMenu" class="u-sidebar-navigation-v1-menu u-side-nav--top-level-menu g-min-height-100vh mb-0">

        <?php if (Yii::$app->user->isGuest){ ?>
        <li class="u-sidebar-navigation-v1-menu-item u-side-nav--top-level-menu-item">
            
            <?= Html::a(getMenu('Sign In','hs-admin-key'), ['/user/login'], ['class' => 'media u-side-nav--second-level-menu-link g-px-15 g-py-12']) ?>
            
        </li>
        <?php } else {?>
        
        <li class="u-sidebar-navigation-v1-menu-item u-side-nav--top-level-menu-item">
            
            <?= Html::a(getMenu('Welcome '.Yii::$app->user->identity->username,'hs-admin-user'), ['/site/index'], ['class' => 'media u-side-nav--second-level-menu-link g-px-15 g-py-12']) ?>
            
        </li>
        
        <li class="u-sidebar-navigation-v1-menu-item u-side-nav--has-sub-menu u-side-nav--top-level-menu-item u-side-nav-opened has-active">
            <a class="media u-side-nav--top-level-menu-link u-side-nav--hide-on-hidden g-px-15 g-py-12" href="#" data-hssm-target="#subMenu1">
                <span class="d-flex align-self-center g-pos-rel g-font-size-18 g-mr-18">
                    <i class="hs-admin-server"></i>
                </span>
                <span class="media-body align-self-center">Dashboards </span>
                <span class="d-flex align-self-center u-side-nav--control-icon">
                    <i class="hs-admin-angle-right"></i>
                </span>
                <span class="u-side-nav--has-sub-menu__indicator"></span>
            </a>

            <!-- Dashboards: Submenu-1 -->
            <ul id="subMenu1" class="u-sidebar-navigation-v1-menu u-side-nav--second-level-menu mb-0" style="display: block;">

                <li class="u-sidebar-navigation-v1-menu-item u-side-nav--second-level-menu-item">
                    <?= Html::a(getMenu('Archive Category'), ['/archive-category/index'], ['class' => 'media u-side-nav--second-level-menu-link g-px-15 g-py-12']) ?>
                    <?= Html::a(getMenu('Archive'), ['/archive/index'], ['class' => 'media u-side-nav--second-level-menu-link g-px-15 g-py-12']) ?>
                </li>

            </ul>
            <!-- End Dashboards: Submenu-1 -->
        </li>
        <!-- End Dashboards -->

        <?= $this->render('left-admin',['subMenuAdmin'=>'subMenuAdmin']) ?>

        <?php } ?>
    </ul>
</div>