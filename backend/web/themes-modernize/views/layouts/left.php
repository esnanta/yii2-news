<?php

use yii\helpers\Html;
use kartik\widgets\SideNav;
?>

<?php
$module = Yii::$app->getModule('user');

function getMenu($_menuName, $_classIcon) {
    $menuLinks = '<span>' .
            '<i class="' . $_classIcon . '"></i>' .
            '</span>' .
            '<span class="hide-menu">' . $_menuName . '</span>';

    return $menuLinks;
}
?>




<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="./index.html" class="text-nowrap logo-img">
                <img src="../assets/images/logos/dark-logo.svg" width="180" alt="" />
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-8"></i>
            </div>
        </div>

        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav">

                <?php if (!Yii::$app->user->isGuest) { ?>

                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Home</span>
                    </li>
                    <li class="sidebar-item">
                        <?= Html::a(getMenu('Dashboard', 'fa fa-dashboard'), ['/site/index'], ['class' => 'sidebar-link']) ?>
                    </li>
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Master</span>
                    </li>
                    <li class="sidebar-item">
                        <?= Html::a(getMenu('Archive Category', 'fa fa-angle-right'), ['/archive-category/index'], ['class' => 'sidebar-link']) ?>
                    </li>
                    <li class="sidebar-item">
                        <?= Html::a(getMenu('Archive', 'fa fa-angle-right'), ['/archive/index'], ['class' => 'sidebar-link']) ?>
                    </li>

                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">EXTRA</span>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="./icon-tabler.html" aria-expanded="false">
                            <span>
                                <i class="ti ti-mood-happy"></i>
                            </span>
                            <span class="hide-menu">Icons</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="./sample-page.html" aria-expanded="false">
                            <span>
                                <i class="ti ti-aperture"></i>
                            </span>
                            <span class="hide-menu">Sample Page</span>
                        </a>
                    </li>

                    <?php if (Yii::$app->user->identity->isAdmin): ?>
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">ADMIN</span>
                        </li>

                        <li class="sidebar-item">
                            <?= Html::a(getMenu('User', 'fa fa-angle-right'), ['/user/admin/index'], ['class' => 'sidebar-link']) ?>
                        </li>
                        <li class="sidebar-item">
                            <?= Html::a(getMenu('Gii', 'fa fa-angle-right'), ['/gii'], ['class' => 'sidebar-link']) ?>
                        </li>
                    <?php endif ?>

                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">AUTH</span>
                    </li>
                    <li class="sidebar-item">

                        <?=
                        Html::a(getMenu('Logout', 'fa fa-sign-out'),
                                ['/user/logout'],
                                ['data-method' => 'POST', 'data-confirm' => "Logout?", 'class' => 'sidebar-link'])
                        ?>
                    </li>
                <?php } else { ?>
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">AUTH</span>
                    </li>
                    <li class="sidebar-item">
                    <?= Html::a(getMenu('Login', 'fa fa-sign-in'), ['/user/login'], ['class' => 'sidebar-link']) ?>
                    </li>

                <?php } ?>

<?php if ($module->enableRegistration): ?>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="./authentication-register.html" aria-expanded="false">
                            <span>
                                <i class="ti ti-user-plus"></i>
                            </span>
                            <span class="hide-menu">Register</span>
                        </a>
                    </li>
<?php endif ?>          
            </ul>


            <!--            <div class="unlimited-access hide-menu bg-light-primary position-relative mb-7 mt-5 rounded">
                            <div class="d-flex">
                                <div class="unlimited-access-title me-3">
                                    <h6 class="fw-semibold fs-4 mb-6 text-dark w-85">Upgrade to pro</h6>
                                    <a href="https://adminmart.com/product/modernize-bootstrap-5-admin-template/" target="_blank" class="btn btn-primary fs-2 fw-semibold lh-sm">Buy Pro</a>
                                </div>
                                <div class="unlimited-access-img">
                                    <img src="../assets/images/backgrounds/rocket.png" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>-->
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>


