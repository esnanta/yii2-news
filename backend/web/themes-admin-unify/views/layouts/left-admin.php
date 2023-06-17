<?php
    use yii\helpers\Html;
?>

<li class="u-sidebar-navigation-v1-menu-item u-side-nav--has-sub-menu u-side-nav--top-level-menu-item u-side-nav-opened has-active">
    <a class="media u-side-nav--top-level-menu-link u-side-nav--hide-on-hidden g-px-15 g-py-12" href="#" data-hssm-target="#<?= $subMenuAdmin ?>">
        <span class="d-flex align-self-center g-pos-rel g-font-size-18 g-mr-18">
            <i class="hs-admin-layout-media-center-alt"></i>
        </span>
        <span class="media-body align-self-center">Administrator</span>
        <span class="d-flex align-self-center u-side-nav--control-icon">
            <i class="hs-admin-angle-right"></i>
        </span>

        <span class="u-side-nav--has-sub-menu__indicator"></span>
    </a>

    <ul id="<?= $subMenuAdmin ?>" class="u-sidebar-navigation-v1-menu u-side-nav--second-level-menu mb-0">
        <li class="u-sidebar-navigation-v1-menu-item u-side-nav--second-level-menu-item">
            <?= Html::a(getMenu('User'), ['/user/admin/index'], ['class' => 'media u-side-nav--second-level-menu-link g-px-15 g-py-12']) ?>
        </li>
        <li class="u-sidebar-navigation-v1-menu-item u-side-nav--second-level-menu-item">
            <?= Html::a(getMenu('Gii'), ['/gii'], ['class' => 'media u-side-nav--second-level-menu-link g-px-15 g-py-12']) ?>
        </li>
    </ul>
</li>


