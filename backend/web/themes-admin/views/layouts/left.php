<?php
use yii\widgets\Menu;
use yii\helpers\Html;

use backend\widgets\LeftMenu as CustomMenu;
use backend\widgets\DmstrMenu;

?>
<div id="sideNav" class="col-auto u-sidebar-navigation-v1 u-sidebar-navigation--dark">
    
    
    
    
    <?php
    
    echo CustomMenu::widget([
        'items' => [
            ['label' => 'Home', 'url' => ['/site/index'], 'icon' => 'hs-admin-server'],
            [
                'label' => 'TEST',
                'itemOptions'=>['class'=>'test'],
                'items' => [
                    ['label' => 'Item 1', 'url' => ['/site/index']],
                    ['label' => 'Item 2', 'url' => ['/site/index']],
                ],
            ],
        ],
    ]);

    

?>
    

    <ul id="sideNavMenu" class="u-sidebar-navigation-v1-menu u-side-nav--top-level-menu g-min-height-100vh mb-0">
        
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
                    <a class="media u-side-nav--second-level-menu-link g-px-15 g-py-12" href="dashboards/dashboard-v2.html">
                        <span class="d-flex align-self-center g-mr-15 g-mt-minus-1">
                            <i class="hs-admin-blackboard"></i>
                        </span>
                        <span class="media-body align-self-center">Index</span>
                    </a>
                </li>
                
            </ul>
            <!-- End Dashboards: Submenu-1 -->
        </li>
        <!-- End Dashboards -->

    </ul>
</div>