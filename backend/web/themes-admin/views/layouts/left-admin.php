<?php
    use yii\helpers\Html;
?>


<li class="u-sidebar-navigation-v1-menu-item u-side-nav--has-sub-menu u-side-nav--top-level-menu-item">
    <a class="media u-side-nav--top-level-menu-link u-side-nav--hide-on-hidden g-px-15 g-py-12" href="#" data-hssm-target="#<?= $subMenuAdmin ?>">
        <span class="d-flex align-self-center g-pos-rel g-font-size-18 g-mr-18">
            <i class="hs-admin-settings"></i>
        </span>
        <span class="media-body align-self-center">Administrator</span>
        <span class="d-flex align-self-center u-side-nav--control-icon">
            <i class="hs-admin-angle-right"></i>
        </span>
        <span class="u-side-nav--has-sub-menu__indicator"></span>
    </a>
    

    <!-- Dashboards: Submenu-1 -->
    <ul id="<?= $subMenuAdmin ?>" class="u-sidebar-navigation-v1-menu u-side-nav--second-level-menu mb-0" style="display: block;">

        <li class="u-sidebar-navigation-v1-menu-item u-side-nav--second-level-menu-item">

            <?= Html::a(getMenu('User'), ['/user/admin/index'], ['class' => 'media u-side-nav--second-level-menu-link g-px-15 g-py-12']) ?>
            <?= Html::a(getMenu('Gii'), ['/gii'], ['class' => 'media u-side-nav--second-level-menu-link g-px-15 g-py-12']) ?>

        </li>

    </ul>
    <!-- End Dashboards: Submenu-1 -->
</li>
<!-- End Dashboards -->



