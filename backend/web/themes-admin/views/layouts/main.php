<?php
/** @var \yii\web\View $this */

/** @var string $content */
use backend\assets\AdminAsset;
use common\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AdminAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">




        <link rel="shortcut icon" href="../favicon.ico">
        <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans%3A400%2C300%2C500%2C600%2C700%7CPlayfair+Display%7CRoboto%7CRaleway%7CSpectral%7CRubik">

        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body class="d-flex flex-column h-100">
        <?php $this->beginBody() ?>

        <?=
        $this->render(
                'header.php'
        );
        
        ?>
        <main class="container-fluid px-0 g-pt-65">
            <div class="row no-gutters g-pos-rel g-overflow-x-hidden">
                <!-- Sidebar Nav -->
                <div id="sideNav" class="col-auto u-sidebar-navigation-v1 u-sidebar-navigation--dark">
                    <ul id="sideNavMenu" class="u-sidebar-navigation-v1-menu u-side-nav--top-level-menu g-min-height-100vh mb-0">
                        <!-- Dashboards -->
                        <li class="u-sidebar-navigation-v1-menu-item u-side-nav--has-sub-menu u-side-nav--top-level-menu-item u-side-nav-opened has-active">
                            <a class="media u-side-nav--top-level-menu-link u-side-nav--hide-on-hidden g-px-15 g-py-12" href="#" data-hssm-target="#subMenu1">
                                <span class="d-flex align-self-center g-pos-rel g-font-size-18 g-mr-18">
                                    <i class="hs-admin-server"></i>
                                </span>
                                <span class="media-body align-self-center">Dashboards</span>
                                <span class="d-flex align-self-center u-side-nav--control-icon">
                                    <i class="hs-admin-angle-right"></i>
                                </span>
                                <span class="u-side-nav--has-sub-menu__indicator"></span>
                            </a>

                            <!-- Dashboards: Submenu-1 -->
                            <ul id="subMenu1" class="u-sidebar-navigation-v1-menu u-side-nav--second-level-menu mb-0" style="display: block;">
                                <!-- Dashboards v1 -->
                                <li class="u-sidebar-navigation-v1-menu-item u-side-nav--second-level-menu-item">
                                    <a class="media u-side-nav--second-level-menu-link g-px-15 g-py-12 active" href="dashboards/dashboard-v1.html">
                                        <span class="d-flex align-self-center g-mr-15 g-mt-minus-1">
                                            <i class="hs-admin-infinite"></i>
                                        </span>
                                        <span class="media-body align-self-center">Dashboards v1</span>
                                    </a>
                                </li>
                                <!-- End Dashboards v1 -->

                                <!-- Dashboards v2 -->
                                <li class="u-sidebar-navigation-v1-menu-item u-side-nav--second-level-menu-item">
                                    <a class="media u-side-nav--second-level-menu-link g-px-15 g-py-12" href="dashboards/dashboard-v2.html">
                                        <span class="d-flex align-self-center g-mr-15 g-mt-minus-1">
                                            <i class="hs-admin-blackboard"></i>
                                        </span>
                                        <span class="media-body align-self-center">Dashboards v2</span>
                                    </a>
                                </li>
                                <!-- End Dashboards v2 -->

                                <!-- Dashboards v3 -->
                                <li class="u-sidebar-navigation-v1-menu-item u-side-nav--second-level-menu-item">
                                    <a class="media u-side-nav--second-level-menu-link g-px-15 g-py-12" href="dashboards/dashboard-v3.html">
                                        <span class="d-flex align-self-center g-mr-15 g-mt-minus-1">
                                            <i class="hs-admin-harddrive"></i>
                                        </span>
                                        <span class="media-body align-self-center">Dashboards v3</span>
                                    </a>
                                </li>
                                <!-- End Dashboards v3 -->

                                <!-- Dashboards v4 -->
                                <li class="u-sidebar-navigation-v1-menu-item u-side-nav--second-level-menu-item">
                                    <a class="media u-side-nav--second-level-menu-link g-px-15 g-py-12" href="dashboards/dashboard-v4.html">
                                        <span class="d-flex align-self-center g-mr-15 g-mt-minus-1">
                                            <i class="hs-admin-harddrive"></i>
                                        </span>
                                        <span class="media-body align-self-center">Dashboards v4</span>
                                    </a>
                                </li>
                                <!-- End Dashboards v4 -->
                            </ul>
                            <!-- End Dashboards: Submenu-1 -->
                        </li>
                        <!-- End Dashboards -->

                        <!-- Layouts Settings -->
                        <li class="u-sidebar-navigation-v1-menu-item u-side-nav--has-sub-menu u-side-nav--top-level-menu-item">
                            <a class="media u-side-nav--top-level-menu-link u-side-nav--hide-on-hidden g-px-15 g-py-12" href="#" data-hssm-target="#subMenu2">
                                <span class="d-flex align-self-center g-pos-rel g-font-size-18 g-mr-18">
                                    <i class="hs-admin-settings"></i>
                                </span>
                                <span class="media-body align-self-center">Layouts Settings</span>
                                <span class="d-flex align-self-center u-side-nav--control-icon">
                                    <i class="hs-admin-angle-right"></i>
                                </span>
                                <span class="u-side-nav--has-sub-menu__indicator"></span>
                            </a>

                            <!-- Layouts Settings: Submenu-1 -->
                            <ul id="subMenu2" class="u-sidebar-navigation-v1-menu u-side-nav--second-level-menu mb-0">
                                <!-- Fixed Header & Sidebar -->
                                <li class="u-sidebar-navigation-v1-menu-item u-side-nav--second-level-menu-item">
                                    <a class="media u-side-nav--second-level-menu-link g-px-15 g-py-12" href="layout-settings/fixed-header-sidebar.html">
                                        <span class="d-flex align-self-center g-mr-15 g-mt-minus-1">
                                            <i class="hs-admin-layout-media-center-alt"></i>
                                        </span>
                                        <span class="media-body align-self-center">Fixed Header & Sidebar</span>
                                    </a>
                                </li>
                                <!-- End Fixed Header & Sidebar -->

                                <!-- Fixed Header & Static Sidebar -->
                                <li class="u-sidebar-navigation-v1-menu-item u-side-nav--second-level-menu-item">
                                    <a class="media u-side-nav--second-level-menu-link g-px-15 g-py-12" href="layout-settings/fixed-header-static-sidebar.html">
                                        <span class="d-flex align-self-center g-mr-15 g-mt-minus-1">
                                            <i class="hs-admin-layout-media-center-alt"></i>
                                        </span>
                                        <span class="media-body align-self-center">Fixed Header & Static Sidebar</span>
                                    </a>
                                </li>
                                <!-- End Fixed Header & Static Sidebar -->

                                <!-- Static Header & Sidebar -->
                                <li class="u-sidebar-navigation-v1-menu-item u-side-nav--second-level-menu-item">
                                    <a class="media u-side-nav--second-level-menu-link g-px-15 g-py-12" href="layout-settings/static-header-sidebar.html">
                                        <span class="d-flex align-self-center g-mr-15 g-mt-minus-1">
                                            <i class="hs-admin-layout-media-center-alt"></i>
                                        </span>
                                        <span class="media-body align-self-center">Static Header & Sidebar</span>
                                    </a>
                                </li>
                                <!-- End Static Header & Sidebar -->

                                <!-- Hide Sidebar -->
                                <li class="u-sidebar-navigation-v1-menu-item u-side-nav--second-level-menu-item">
                                    <a class="media u-side-nav--second-level-menu-link g-px-15 g-py-12" href="layout-settings/sidebar-hide.html">
                                        <span class="d-flex align-self-center g-mr-15 g-mt-minus-1">
                                            <i class="hs-admin-layout-media-center-alt"></i>
                                        </span>
                                        <span class="media-body align-self-center">Hide Sidebar</span>
                                    </a>
                                </li>
                                <!-- End Hide Sidebar -->

                                <!-- Light Layout -->
                                <li class="u-sidebar-navigation-v1-menu-item u-side-nav--second-level-menu-item">
                                    <a class="media u-side-nav--second-level-menu-link g-px-15 g-py-12" href="layout-settings/layout-light.html">
                                        <span class="d-flex align-self-center g-mr-15 g-mt-minus-1">
                                            <i class="hs-admin-layout-media-center-alt"></i>
                                        </span>
                                        <span class="media-body align-self-center">Light Layout</span>
                                    </a>
                                </li>
                                <!-- End Light Layout -->

                                <!-- Dark Layout: body v.2 -->
                                <li class="u-sidebar-navigation-v1-menu-item u-side-nav--second-level-menu-item">
                                    <a class="media u-side-nav--second-level-menu-link g-px-15 g-py-12" href="layout-settings/layout-dark-body-v2.html">
                                        <span class="d-flex align-self-center g-mr-15 g-mt-minus-1">
                                            <i class="hs-admin-layout-media-center-alt"></i>
                                        </span>
                                        <span class="media-body align-self-center">Dark Layout: body v.2</span>
                                    </a>
                                </li>
                                <!-- End Dark Layout: body v.2 -->

                                <!-- Light Layout: body v.2 -->
                                <li class="u-sidebar-navigation-v1-menu-item u-side-nav--second-level-menu-item">
                                    <a class="media u-side-nav--second-level-menu-link g-px-15 g-py-12" href="layout-settings/layout-light-body-v2.html">
                                        <span class="d-flex align-self-center g-mr-15 g-mt-minus-1">
                                            <i class="hs-admin-layout-media-center-alt"></i>
                                        </span>
                                        <span class="media-body align-self-center">Light Layout: body v.2</span>
                                    </a>
                                </li>
                                <!-- End Light Layout: body v.2 -->
                            </ul>
                            <!-- End Layouts Settings: Submenu-1 -->
                        </li>
                        <!-- End Layouts Settings -->

                        <!-- App Views -->
                        <li class="u-sidebar-navigation-v1-menu-item u-side-nav--has-sub-menu u-side-nav--top-level-menu-item">
                            <a class="media u-side-nav--top-level-menu-link u-side-nav--hide-on-hidden g-px-15 g-py-12" href="#" data-hssm-target="#subMenu4">
                                <span class="d-flex align-self-center g-pos-rel g-font-size-18 g-mr-18">
                                    <i class="hs-admin-layers"></i>
                                </span>
                                <span class="media-body align-self-center">App Views</span>
                                <span class="d-flex align-self-center u-side-nav--control-icon">
                                    <i class="hs-admin-angle-right"></i>
                                </span>

                                <span class="u-side-nav--has-sub-menu__indicator"></span>
                            </a>

                            <!-- App Views: Submenu-1 -->
                            <ul id="subMenu4" class="u-sidebar-navigation-v1-menu u-side-nav--second-level-menu mb-0">
                                <!-- Profile Pages -->
                                <li class="u-sidebar-navigation-v1-menu-item u-side-nav--has-sub-menu u-side-nav--second-level-menu-item">
                                    <a class="media u-side-nav--second-level-menu-link g-px-15 g-py-12" href="#" data-hssm-target="#subMenu4Profiles">
                                        <span class="d-flex align-self-center g-mr-15 g-mt-minus-1">
                                            <i class="hs-admin-list"></i>
                                        </span>
                                        <span class="media-body align-self-center">Profile Pages</span>
                                        <span class="d-flex align-self-center u-side-nav--control-icon">
                                            <i class="hs-admin-angle-right"></i>
                                        </span>
                                    </a>

                                    <!-- Menu Leveles: Submenu-2 -->
                                    <ul id="subMenu4Profiles" class="u-side-nav--third-level-menu">
                                        <!-- Main -->
                                        <li class="u-side-nav--third-level-menu-item">
                                            <a class="u-side-nav--third-level-menu-link u-side-nav--hide-on-hidden g-pl-8 g-pr-15 g-py-6" href="app-views/app-profile.html">Profile Information</a>
                                        </li>
                                        <!-- End Main -->

                                        <!-- Biography -->
                                        <li class="u-side-nav--third-level-menu-item">
                                            <a class="u-side-nav--third-level-menu-link u-side-nav--hide-on-hidden g-pl-8 g-pr-15 g-py-6" href="app-views/app-profile-biography.html">Biography</a>
                                        </li>
                                        <!-- End Biography -->

                                        <!-- Interests -->
                                        <li class="u-side-nav--third-level-menu-item">
                                            <a class="u-side-nav--third-level-menu-link u-side-nav--hide-on-hidden g-pl-8 g-pr-15 g-py-6" href="app-views/app-profile-interests.html">Interests</a>
                                        </li>
                                        <!-- End Interests -->

                                        <!-- Mobile -->
                                        <li class="u-side-nav--third-level-menu-item">
                                            <a class="u-side-nav--third-level-menu-link u-side-nav--hide-on-hidden g-pl-8 g-pr-15 g-py-6" href="app-views/app-profile-mobile.html">Mobile</a>
                                        </li>
                                        <!-- End Mobile -->

                                        <!-- Photos & Videos -->
                                        <li class="u-side-nav--third-level-menu-item">
                                            <a class="u-side-nav--third-level-menu-link u-side-nav--hide-on-hidden g-pl-8 g-pr-15 g-py-6" href="app-views/app-profile-photos-and-videos.html">Photos &amp; Videos</a>
                                        </li>
                                        <!-- End Photos & Videos -->

                                        <!-- Payment Methods -->
                                        <li class="u-side-nav--third-level-menu-item">
                                            <a class="u-side-nav--third-level-menu-link u-side-nav--hide-on-hidden g-pl-8 g-pr-15 g-py-6" href="app-views/app-profile-payment-methods.html">Payment Methods</a>
                                        </li>
                                        <!-- End Payment Methods -->

                                        <!-- Transactions -->
                                        <li class="u-side-nav--third-level-menu-item">
                                            <a class="u-side-nav--third-level-menu-link u-side-nav--hide-on-hidden g-pl-8 g-pr-15 g-py-6" href="app-views/app-profile-transactions.html">Transactions</a>
                                        </li>
                                        <!-- End Transactions -->

                                        <!-- Security -->
                                        <li class="u-side-nav--third-level-menu-item">
                                            <a class="u-side-nav--third-level-menu-link u-side-nav--hide-on-hidden g-pl-8 g-pr-15 g-py-6" href="app-views/app-profile-security.html">Security</a>
                                        </li>
                                        <!-- End Security -->

                                        <!-- Upgrade My Plan -->
                                        <li class="u-side-nav--third-level-menu-item">
                                            <a class="u-side-nav--third-level-menu-link u-side-nav--hide-on-hidden g-pl-8 g-pr-15 g-py-6" href="app-views/app-profile-upgrade-plan.html">Upgrade My Plan</a>
                                        </li>
                                        <!-- End Upgrade My Plan -->

                                        <!-- Invited Friends -->
                                        <li class="u-side-nav--third-level-menu-item">
                                            <a class="u-side-nav--third-level-menu-link u-side-nav--hide-on-hidden g-pl-8 g-pr-15 g-py-6" href="app-views/app-profile-invite.html">Invited Friends</a>
                                        </li>
                                        <!-- End Invited Friends -->

                                        <!-- Connected Accounts -->
                                        <li class="u-side-nav--third-level-menu-item">
                                            <a class="u-side-nav--third-level-menu-link u-side-nav--hide-on-hidden g-pl-8 g-pr-15 g-py-6" href="app-views/app-profile-connected-accounts.html">Connected Accounts</a>
                                        </li>
                                        <!-- End Connected Accounts -->
                                    </ul>
                                    <!-- End Menu Leveles: Submenu-2 -->
                                </li>
                                <!-- End Profile Pages -->

                                <!-- Projects -->
                                <li class="u-sidebar-navigation-v1-menu-item u-side-nav--second-level-menu-item">
                                    <a class="media u-side-nav--second-level-menu-link g-px-15 g-py-12" href="app-views/app-projects.html">
                                        <span class="d-flex align-self-center g-mr-15 g-mt-minus-1">
                                            <i class="hs-admin-layout-media-left"></i>
                                        </span>
                                        <span class="media-body align-self-center">Projects</span>
                                    </a>
                                </li>
                                <!-- End Projects -->

                                <!-- Chat -->
                                <li class="u-sidebar-navigation-v1-menu-item u-side-nav--second-level-menu-item">
                                    <a class="media u-side-nav--second-level-menu-link g-px-15 g-py-12" href="app-views/app-chat.html">
                                        <span class="d-flex align-self-center g-mr-15 g-mt-minus-1">
                                            <i class="hs-admin-comments"></i>
                                        </span>
                                        <span class="media-body align-self-center">Chat</span>
                                    </a>
                                </li>
                                <!-- End Chat -->

                                <!-- File Manager -->
                                <li class="u-sidebar-navigation-v1-menu-item u-side-nav--second-level-menu-item">
                                    <a class="media u-side-nav--second-level-menu-link g-px-15 g-py-12" href="app-views/app-file-manager.html">
                                        <span class="d-flex align-self-center g-mr-15 g-mt-minus-1">
                                            <i class="hs-admin-folder"></i>
                                        </span>
                                        <span class="media-body align-self-center">File Manager</span>
                                        <span class="d-flex align-self-center">
                                            <span class="d-inline-block text-center g-min-width-35 g-bg-primary g-font-size-12 g-color-white g-rounded-15 g-px-8 g-py-1">10</span>
                                        </span>
                                    </a>
                                </li>
                                <!-- End File Manager -->

                                <!-- User Contacts -->
                                <li class="u-sidebar-navigation-v1-menu-item u-side-nav--second-level-menu-item">
                                    <a class="media u-side-nav--second-level-menu-link g-px-15 g-py-12" href="app-views/app-contacts.html">
                                        <span class="d-flex align-self-center g-mr-15 g-mt-minus-1">
                                            <i class="hs-admin-id-badge"></i>
                                        </span>
                                        <span class="media-body align-self-center">User Contacts</span>
                                    </a>
                                </li>
                                <!-- End User Contacts -->
                            </ul>
                            <!-- End App Views: Submenu-1 -->
                        </li>
                        <!-- End App Views -->

                        <!-- Forms -->
                        <li class="u-sidebar-navigation-v1-menu-item u-side-nav--has-sub-menu u-side-nav--top-level-menu-item">
                            <a class="media u-side-nav--top-level-menu-link u-side-nav--hide-on-hidden g-px-15 g-py-12" href="#" data-hssm-target="#subMenu7">
                                <span class="d-flex align-self-center g-pos-rel g-font-size-18 g-mr-18">
                                    <i class="hs-admin-pencil-alt"></i>
                                </span>
                                <span class="media-body align-self-center">Forms</span>
                                <span class="d-flex align-self-center u-side-nav--control-icon">
                                    <i class="hs-admin-angle-right"></i>
                                </span>

                                <span class="u-side-nav--has-sub-menu__indicator"></span>
                            </a>

                            <!-- Forms: Submenu-1 -->
                            <ul id="subMenu7" class="u-sidebar-navigation-v1-menu u-side-nav--second-level-menu mb-0">
                                <!-- Elements -->
                                <li class="u-sidebar-navigation-v1-menu-item u-side-nav--has-sub-menu u-side-nav--second-level-menu-item">
                                    <a class="media u-side-nav--second-level-menu-link g-px-15 g-py-12" href="#" data-hssm-target="#subMenu7Elements">
                                        <span class="d-flex align-self-center g-mr-15 g-mt-minus-1">
                                            <i class="hs-admin-list"></i>
                                        </span>
                                        <span class="media-body align-self-center">Elements</span>
                                        <span class="d-flex align-self-center u-side-nav--control-icon">
                                            <i class="hs-admin-angle-right"></i>
                                        </span>
                                    </a>

                                    <!-- Menu Leveles: Submenu-2 -->
                                    <ul id="subMenu7Elements" class="u-side-nav--third-level-menu">
                                        <!-- Text Inputs -->
                                        <li class="u-side-nav--third-level-menu-item">
                                            <a class="u-side-nav--third-level-menu-link u-side-nav--hide-on-hidden g-pl-8 g-pr-15 g-py-6" href="forms/forms-elemets-text-inputs.html">Text Inputs</a>
                                        </li>
                                        <!-- End Text Inputs -->

                                        <!-- Textareas -->
                                        <li class="u-side-nav--third-level-menu-item">
                                            <a class="u-side-nav--third-level-menu-link u-side-nav--hide-on-hidden g-pl-8 g-pr-15 g-py-6" href="forms/forms-elemets-textareas.html">Textareas</a>
                                        </li>
                                        <!-- End Textareas -->

                                        <!-- Text Editors -->
                                        <li class="u-side-nav--third-level-menu-item">
                                            <a class="u-side-nav--third-level-menu-link u-side-nav--hide-on-hidden g-pl-8 g-pr-15 g-py-6" href="forms/forms-elemets-text-editors.html">Text Editors</a>
                                        </li>
                                        <!-- End Text Editors -->

                                        <!-- Selects -->
                                        <li class="u-side-nav--third-level-menu-item">
                                            <a class="u-side-nav--third-level-menu-link u-side-nav--hide-on-hidden g-pl-8 g-pr-15 g-py-6" href="forms/forms-elemets-selects.html">Selects</a>
                                        </li>
                                        <!-- End Selects -->

                                        <!-- Advanced Selects -->
                                        <li class="u-side-nav--third-level-menu-item">
                                            <a class="u-side-nav--third-level-menu-link u-side-nav--hide-on-hidden g-pl-8 g-pr-15 g-py-6" href="forms/forms-elemets-advanced-selects.html">Advanced Selects</a>
                                        </li>
                                        <!-- End Advanced Selects -->

                                        <!-- Checkboxes &amp; Radios -->
                                        <li class="u-side-nav--third-level-menu-item">
                                            <a class="u-side-nav--third-level-menu-link u-side-nav--hide-on-hidden g-pl-8 g-pr-15 g-py-6" href="forms/forms-elemets-checkboxes-radios.html">Checkboxes &amp; Radios</a>
                                        </li>
                                        <!-- End Checkboxes &amp; Radios -->

                                        <!-- Toggles -->
                                        <li class="u-side-nav--third-level-menu-item">
                                            <a class="u-side-nav--third-level-menu-link u-side-nav--hide-on-hidden g-pl-8 g-pr-15 g-py-6" href="forms/forms-elemets-toggles.html">Toggles</a>
                                        </li>
                                        <!-- End Toggles -->

                                        <!-- File Inputs -->
                                        <li class="u-side-nav--third-level-menu-item">
                                            <a class="u-side-nav--third-level-menu-link u-side-nav--hide-on-hidden g-pl-8 g-pr-15 g-py-6" href="forms/forms-elemets-file-inputs.html">File Inputs</a>
                                        </li>
                                        <!-- End File Inputs -->

                                        <!-- Sliders -->
                                        <li class="u-side-nav--third-level-menu-item">
                                            <a class="u-side-nav--third-level-menu-link u-side-nav--hide-on-hidden g-pl-8 g-pr-15 g-py-6" href="forms/forms-elemets-sliders.html">Sliders</a>
                                        </li>
                                        <!-- End Sliders -->

                                        <!-- Text Inputs with Tags -->
                                        <li class="u-side-nav--third-level-menu-item">
                                            <a class="u-side-nav--third-level-menu-link u-side-nav--hide-on-hidden g-pl-8 g-pr-15 g-py-6" href="forms/forms-elemets-tags.html">Text Inputs with Tags</a>
                                        </li>
                                        <!-- End Text Inputs with Tags -->

                                        <!-- Ratings -->
                                        <li class="u-side-nav--third-level-menu-item">
                                            <a class="u-side-nav--third-level-menu-link u-side-nav--hide-on-hidden g-pl-8 g-pr-15 g-py-6" href="forms/forms-elemets-ratings.html">Ratings</a>
                                        </li>
                                        <!-- End Ratings -->

                                        <!-- Datepickers -->
                                        <li class="u-side-nav--third-level-menu-item">
                                            <a class="u-side-nav--third-level-menu-link u-side-nav--hide-on-hidden g-pl-8 g-pr-15 g-py-6" href="forms/forms-elemets-datepickers.html">Datepickers</a>
                                        </li>
                                        <!-- End Datepickers -->

                                        <!-- Quantities -->
                                        <li class="u-side-nav--third-level-menu-item">
                                            <a class="u-side-nav--third-level-menu-link u-side-nav--hide-on-hidden g-pl-8 g-pr-15 g-py-6" href="forms/forms-elemets-quantities.html">Quantities</a>
                                        </li>
                                        <!-- End Quantities -->

                                        <!-- Slider Controls -->
                                        <li class="u-side-nav--third-level-menu-item">
                                            <a class="u-side-nav--third-level-menu-link u-side-nav--hide-on-hidden g-pl-8 g-pr-15 g-py-6" href="forms/forms-elemets-slider-controls.html">Slider Controls</a>
                                        </li>
                                        <!-- End Slider Controls -->
                                    </ul>
                                    <!-- End Menu Leveles: Submenu-2 -->
                                </li>
                                <!-- End Elements -->

                                <!-- Validation -->
                                <li class="u-sidebar-navigation-v1-menu-item u-side-nav--has-sub-menu u-side-nav--second-level-menu-item">
                                    <a class="media u-side-nav--second-level-menu-link g-px-15 g-py-12" href="#" data-hssm-target="#subMenu7Validation">
                                        <span class="d-flex align-self-center g-mr-15 g-mt-minus-1">
                                            <i class="hs-admin-list"></i>
                                        </span>
                                        <span class="media-body align-self-center">Validation</span>
                                        <span class="d-flex align-self-center u-side-nav--control-icon">
                                            <i class="hs-admin-angle-right"></i>
                                        </span>
                                    </a>

                                    <!-- Validation: Submneu -->
                                    <ul id="subMenu7Validation" class="u-side-nav--third-level-menu">
                                        <!-- States -->
                                        <li class="u-side-nav--third-level-menu-item">
                                            <a class="u-side-nav--third-level-menu-link u-side-nav--hide-on-hidden g-pl-8 g-pr-15 g-py-6" href="forms/forms-validation-states.html">States</a>
                                        </li>
                                        <!-- End States -->
                                    </ul>
                                    <!-- Validation: Submneu -->
                                </li>
                                <!-- End Validation -->
                            </ul>
                            <!-- End Forms: Submenu-1 -->
                        </li>
                        <!-- End Forms -->

                        <!-- Tables -->
                        <li class="u-sidebar-navigation-v1-menu-item u-side-nav--has-sub-menu u-side-nav--top-level-menu-item">
                            <a class="media u-side-nav--top-level-menu-link u-side-nav--hide-on-hidden g-px-15 g-py-12" href="#" data-hssm-target="#subMenu8">
                                <span class="d-flex align-self-center g-pos-rel g-font-size-18 g-mr-18">
                                    <i class="hs-admin-layout-grid-3"></i>
                                </span>
                                <span class="media-body align-self-center">Tables</span>
                                <span class="d-flex align-self-center u-side-nav--control-icon">
                                    <i class="hs-admin-angle-right"></i>
                                </span>

                                <span class="u-side-nav--has-sub-menu__indicator"></span>
                            </a>

                            <!-- Tables: Submenu-1 -->
                            <ul id="subMenu8" class="u-sidebar-navigation-v1-menu u-side-nav--second-level-menu mb-0">
                                <!-- Basic Tables -->
                                <li class="u-sidebar-navigation-v1-menu-item u-side-nav--second-level-menu-item">
                                    <a class="media u-side-nav--second-level-menu-link g-px-15 g-py-12" href="tables/tables-basic.html">
                                        <span class="d-flex align-self-center g-mr-15 g-mt-minus-1">
                                            <i class="hs-admin-layout-list-thumb"></i>
                                        </span>
                                        <span class="media-body align-self-center">Basic Tables</span>
                                    </a>
                                </li>
                                <!-- End Basic Tables -->

                                <!-- Table Designs -->
                                <li class="u-sidebar-navigation-v1-menu-item u-side-nav--second-level-menu-item">
                                    <a class="media u-side-nav--second-level-menu-link g-px-15 g-py-12" href="tables/tables-complex.html">
                                        <span class="d-flex align-self-center g-mr-15 g-mt-minus-1">
                                            <i class="hs-admin-layout-media-overlay-alt-2"></i>
                                        </span>
                                        <span class="media-body align-self-center">Complex Tables</span>
                                    </a>
                                </li>
                                <!-- End Table Designs -->

                                <!-- Table Modern -->
                                <li class="u-sidebar-navigation-v1-menu-item u-side-nav--second-level-menu-item">
                                    <a class="media u-side-nav--second-level-menu-link g-px-15 g-py-12" href="tables/tables-modern.html">
                                        <span class="d-flex align-self-center g-mr-15 g-mt-minus-1">
                                            <i class="hs-admin-layout-media-overlay-alt-2"></i>
                                        </span>
                                        <span class="media-body align-self-center">Modern Tables</span>
                                    </a>
                                </li>
                                <!-- End Table Modern -->
                            </ul>
                            <!-- End Tables: Submenu-1 -->
                        </li>
                        <!-- End Tables -->

                        <!-- Panels/Cards -->
                        <li class="u-sidebar-navigation-v1-menu-item u-side-nav--has-sub-menu u-side-nav--top-level-menu-item">
                            <a class="media u-side-nav--top-level-menu-link u-side-nav--hide-on-hidden g-px-15 g-py-12" href="#" data-hssm-target="#subMenu6">
                                <span class="d-flex align-self-center g-pos-rel g-font-size-18 g-mr-18">
                                    <i class="hs-admin-layout-media-center-alt"></i>
                                </span>
                                <span class="media-body align-self-center">Panels/Cards</span>
                                <span class="d-flex align-self-center u-side-nav--control-icon">
                                    <i class="hs-admin-angle-right"></i>
                                </span>

                                <span class="u-side-nav--has-sub-menu__indicator"></span>
                            </a>

                            <!-- Panels/Cards: Submenu-1 -->
                            <ul id="subMenu6" class="u-sidebar-navigation-v1-menu u-side-nav--second-level-menu mb-0">
                                <!-- Panel Variations -->
                                <li class="u-sidebar-navigation-v1-menu-item u-side-nav--second-level-menu-item">
                                    <a class="media u-side-nav--second-level-menu-link g-px-15 g-py-12" href="panels/panel-variations.html">
                                        <span class="d-flex align-self-center g-mr-15 g-mt-minus-1">
                                            <i class="hs-admin-layout-cta-btn-left"></i>
                                        </span>
                                        <span class="media-body align-self-center">Panel Variations</span>
                                    </a>
                                </li>
                                <!-- End Panel Variations -->

                                <!-- Panel with Tabs -->
                                <li class="u-sidebar-navigation-v1-menu-item u-side-nav--second-level-menu-item">
                                    <a class="media u-side-nav--second-level-menu-link g-px-15 g-py-12" href="panels/panel-options.html">
                                        <span class="d-flex align-self-center g-mr-15 g-mt-minus-1">
                                            <i class="hs-admin-layout-cta-right"></i>
                                        </span>
                                        <span class="media-body align-self-center">Panel's Options</span>
                                    </a>
                                </li>
                                <!-- End Panel with Tabs -->

                                <!-- Panel Options
                      <li class="u-sidebar-navigation-v1-menu-item u-side-nav--second-level-menu-item">
                        <a class="media u-side-nav--second-level-menu-link g-px-15 g-py-12" href="panels/panel-options.html">
                          <span class="d-flex align-self-center g-mr-15 g-mt-minus-1">
                            <i class="hs-admin-layout-cta-center"></i>
                          </span>
                          <span class="media-body align-self-center">Panel Options</span>
                        </a>
                      </li>
                      End Panel Options -->
                            </ul>
                            <!-- End Panels/Cards: Submenu-1 -->
                        </li>
                        <!-- End Panels/Cards -->

                        <!-- Notifications -->
                        <li class="u-sidebar-navigation-v1-menu-item u-side-nav--has-sub-menu u-side-nav--top-level-menu-item">
                            <a class="media u-side-nav--top-level-menu-link u-side-nav--hide-on-hidden g-px-15 g-py-12" href="#" data-hssm-target="#subMenu9">
                                <span class="d-flex align-self-center g-pos-rel g-font-size-18 g-mr-18">
                                    <i class="hs-admin-layout-list-thumb"></i>
                                </span>
                                <span class="media-body align-self-center">Notifications</span>
                                <span class="d-flex align-self-center u-side-nav--control-icon">
                                    <i class="hs-admin-angle-right"></i>
                                </span>

                                <span class="u-side-nav--has-sub-menu__indicator"></span>
                            </a>

                            <!-- Notifications: Submenu-1 -->
                            <ul id="subMenu9" class="u-sidebar-navigation-v1-menu u-side-nav--second-level-menu mb-0">
                                <!-- Colorful Notifications -->
                                <li class="u-sidebar-navigation-v1-menu-item u-side-nav--second-level-menu-item">
                                    <a class="media u-side-nav--second-level-menu-link g-px-15 g-py-12" href="notifications/notifications-colorful.html">
                                        <span class="d-flex align-self-center g-mr-15 g-mt-minus-1">
                                            <i class="hs-admin-layout-cta-btn-right"></i>
                                        </span>
                                        <span class="media-body align-self-center">Colorful Notifications</span>
                                    </a>
                                </li>
                                <!-- End Colorful Notifications -->

                                <!-- Light Notifications -->
                                <li class="u-sidebar-navigation-v1-menu-item u-side-nav--second-level-menu-item">
                                    <a class="media u-side-nav--second-level-menu-link g-px-15 g-py-12" href="notifications/notifications-light.html">
                                        <span class="d-flex align-self-center g-mr-15 g-mt-minus-1">
                                            <i class="hs-admin-layout-cta-btn-left"></i>
                                        </span>
                                        <span class="media-body align-self-center">Light Notifications</span>
                                    </a>
                                </li>
                                <!-- End Light Notifications -->

                                <!-- Dark Notifications -->
                                <li class="u-sidebar-navigation-v1-menu-item u-side-nav--second-level-menu-item">
                                    <a class="media u-side-nav--second-level-menu-link g-px-15 g-py-12" href="notifications/notifications-dark.html">
                                        <span class="d-flex align-self-center g-mr-15 g-mt-minus-1">
                                            <i class="hs-admin-layout-cta-center"></i>
                                        </span>
                                        <span class="media-body align-self-center">Dark Notifications</span>
                                    </a>
                                </li>
                                <!-- End Dark Notifications -->

                                <!-- Notifications Builder -->
                                <li class="u-sidebar-navigation-v1-menu-item u-side-nav--second-level-menu-item">
                                    <a class="media u-side-nav--second-level-menu-link g-px-15 g-py-12" href="notifications/notifications-builder.html">
                                        <span class="d-flex align-self-center g-mr-15 g-mt-minus-1">
                                            <i class="hs-admin-infinite"></i>
                                        </span>
                                        <span class="media-body align-self-center">Notifications Builder</span>
                                    </a>
                                </li>
                                <!-- End Notifications Builder -->
                            </ul>
                            <!-- Notifications: Submenu-1 -->
                        </li>
                        <!-- End Notifications -->

                        <!-- Metrics -->
                        <li class="u-sidebar-navigation-v1-menu-item u-side-nav--top-level-menu-item">
                            <a class="media u-side-nav--top-level-menu-link u-side-nav--hide-on-hidden g-px-15 g-py-12" href="metrics/metrics.html">
                                <span class="d-flex align-self-center g-pos-rel g-font-size-18 g-mr-18">
                                    <i class="hs-admin-pie-chart"></i>
                                </span>
                                <span class="media-body align-self-center">Metrics</span>
                            </a>
                        </li>
                        <!-- End Metrics -->

                        <!-- UI Components -->
                        <li class="u-sidebar-navigation-v1-menu-item u-side-nav--has-sub-menu u-side-nav--top-level-menu-item">
                            <a class="media u-side-nav--top-level-menu-link u-side-nav--hide-on-hidden g-px-15 g-py-12" href="#" data-hssm-target="#subMenu5">
                                <span class="d-flex align-self-center g-pos-rel g-font-size-18 g-mr-18">
                                    <i class="hs-admin-infinite"></i>
                                </span>
                                <span class="media-body align-self-center">UI Components</span>
                                <span class="d-flex align-self-center u-side-nav--control-icon">
                                    <i class="hs-admin-angle-right"></i>
                                </span>
                                <span class="u-side-nav--has-sub-menu__indicator"></span>
                            </a>

                            <!-- UI Components: Submenu -->
                            <ul id="subMenu5" class="u-sidebar-navigation-v1-menu u-side-nav--second-level-menu mb-0">
                                <!-- Icons -->
                                <li class="u-sidebar-navigation-v1-menu-item u-side-nav--second-level-menu-item">
                                    <a class="media u-side-nav--second-level-menu-link g-px-15 g-py-12" href="ui-components/ui-icons.html">
                                        <span class="d-flex align-self-center g-mr-15 g-mt-minus-1">
                                            <i class="hs-admin-wand"></i>
                                        </span>
                                        <span class="media-body align-self-center">Icons</span>
                                    </a>
                                </li>
                                <!-- End Icons -->
                            </ul>
                            <!-- End UI Components: Submenu -->
                        </li>
                        <!-- End UI Components -->

                        <!-- Timeline History -->
                        <li class="u-sidebar-navigation-v1-menu-item u-side-nav--top-level-menu-item">
                            <a class="media u-side-nav--top-level-menu-link u-side-nav--hide-on-hidden g-px-15 g-py-12" href="pages/pages-timeline.html">
                                <span class="d-flex align-self-center g-pos-rel g-font-size-18 g-mr-18">
                                    <span class="u-badge-v2--xs u-badge--bottom-right g-bg-secondary"></span>
                                    <i class="hs-admin-timer"></i>
                                </span>
                                <span class="media-body align-self-center">Timeline History</span>
                                <span class="d-flex align-self-center">
                                    <span class="d-inline-block text-center g-min-width-35 g-bg-secondary g-font-size-12 g-color-white g-rounded-15 g-px-8 g-py-1">5</span>
                                </span>
                            </a>
                        </li>
                        <!-- End Timeline History -->

                        <!-- Menu Leveles -->
                        <li class="u-sidebar-navigation-v1-menu-item u-side-nav--has-sub-menu u-side-nav--top-level-menu-item">
                            <a class="media u-side-nav--top-level-menu-link u-side-nav--hide-on-hidden g-px-15 g-py-12" href="#" data-hssm-target="#subMenuLevels1">
                                <span class="d-flex align-self-center g-pos-rel g-font-size-18 g-mr-18">
                                    <i class="hs-admin-list-ol"></i>
                                </span>
                                <span class="media-body align-self-center">Menu Levels</span>
                                <span class="d-flex align-self-center u-side-nav--control-icon">
                                    <i class="hs-admin-angle-right"></i>
                                </span>
                                <span class="u-side-nav--has-sub-menu__indicator"></span>
                            </a>

                            <!-- Menu Leveles: Submenu-1 -->
                            <ul id="subMenuLevels1" class="u-sidebar-navigation-v1-menu u-side-nav--second-level-menu mb-0">
                                <!-- Sub Level 2 -->
                                <li class="u-sidebar-navigation-v1-menu-item u-side-nav--second-level-menu-item">
                                    <a class="media u-side-nav--second-level-menu-link g-px-15 g-py-12" href="#">
                                        <span class="d-flex align-self-center g-mr-15 g-mt-minus-1">
                                            <i class="hs-admin-list"></i>
                                        </span>
                                        <span class="media-body align-self-center">Sub Level 2</span>
                                    </a>
                                </li>
                                <!-- End Sub Level 2 -->

                                <!-- Sub Level 2 -->
                                <li class="u-sidebar-navigation-v1-menu-item u-side-nav--has-sub-menu u-side-nav--second-level-menu-item">
                                    <a class="media u-side-nav--second-level-menu-link g-px-15 g-py-12" href="#" data-hssm-target="#subMenuLevels2">
                                        <span class="d-flex align-self-center g-mr-15 g-mt-minus-1">
                                            <i class="hs-admin-list"></i>
                                        </span>
                                        <span class="media-body align-self-center">Sub Level 2</span>
                                        <span class="d-flex align-self-center u-side-nav--control-icon">
                                            <i class="hs-admin-angle-right"></i>
                                        </span>
                                    </a>

                                    <!-- Menu Leveles: Submenu-2 -->
                                    <ul id="subMenuLevels2" class="u-side-nav--third-level-menu">
                                        <!-- Sub Level 3 -->
                                        <li class="u-side-nav--third-level-menu-item u-side-nav--has-sub-menu">
                                            <a class="media d-flex u-side-nav--third-level-menu-link u-side-nav--hide-on-hidden g-pl-8 g-pr-15 g-py-6" href="#" data-hssm-target="#subMenuLevels3">
                                                <span class="media-body align-self-center">Sub Level 3</span>
                                                <span class="d-flex align-self-center u-side-nav--control-icon">
                                                    <i class="hs-admin-angle-right"></i>
                                                </span>
                                            </a>

                                            <!-- Menu Leveles: Submenu-3 -->
                                            <ul id="subMenuLevels3" class="u-side-nav--fourth-level-menu">
                                                <!-- Sub Level 4 -->
                                                <li class="u-side-nav--fourth-level-menu-item">
                                                    <a class="u-side-nav--fourth-level-menu-link g-px-15 g-py-6" href="#">
                                                        <span class="media-body align-self-center">Sub Level 4</span>
                                                    </a>
                                                </li>
                                                <!-- End Sub Level 4 -->

                                                <!-- Sub Level 4 -->
                                                <li class="u-side-nav--fourth-level-menu-item">
                                                    <a class="u-side-nav--fourth-level-menu-link g-px-15 g-py-6" href="#">
                                                        <span class="media-body align-self-center">Sub Level 4</span>
                                                    </a>
                                                </li>
                                                <!-- End Sub Level 4 -->

                                                <!-- Sub Level 4 -->
                                                <li class="u-side-nav--fourth-level-menu-item">
                                                    <a class="u-side-nav--fourth-level-menu-link g-px-15 g-py-6" href="#">
                                                        <span class="media-body align-self-center">Sub Level 4</span>
                                                    </a>
                                                </li>
                                                <!-- End Sub Level 4 -->
                                            </ul>
                                            <!-- End Menu Leveles: Submenu-3 -->
                                        </li>
                                        <!-- End Sub Level 3 -->

                                        <!-- Sub Level 3 -->
                                        <li class="u-side-nav--third-level-menu-item">
                                            <a class="u-side-nav--third-level-menu-link u-side-nav--hide-on-hidden g-pl-8 g-pr-15 g-py-6" href="#">Sub Level 3</a>
                                        </li>
                                        <!-- End Sub Level 3 -->
                                    </ul>
                                    <!-- End Menu Leveles: Submenu-2 -->
                                </li>
                                <!-- End Sub Level 2 -->

                                <!-- Sub Level 2 -->
                                <li class="u-sidebar-navigation-v1-menu-item u-side-nav--second-level-menu-item">
                                    <a class="media u-side-nav--second-level-menu-link g-px-15 g-py-12" href="#">
                                        <span class="d-flex align-self-center g-mr-15 g-mt-minus-1">
                                            <i class="hs-admin-list"></i>
                                        </span>
                                        <span class="media-body align-self-center">Sub Level 2</span>
                                    </a>
                                </li>
                                <!-- End Sub Level 2 -->
                            </ul>
                            <!-- End Menu Leveles: Submenu-1 -->
                        </li>
                        <!-- End Menu Leveles -->

                        <!-- Packages -->
                        <li class="u-sidebar-navigation-v1-menu-item u-side-nav--top-level-menu-item">
                            <a class="media u-side-nav--top-level-menu-link u-side-nav--hide-on-hidden g-px-15 g-py-12" href="packages.html">
                                <span class="d-flex align-self-center g-font-size-18 g-mr-18">
                                    <i class="hs-admin-medall"></i>
                                </span>
                                <span class="media-body align-self-center">Packages</span>
                            </a>
                        </li>
                        <!-- End Packages -->

                    </ul>
                </div>
                <!-- End Sidebar Nav -->


                <div class="col g-ml-45 g-ml-0--lg g-pb-65--md">
                    <div class="g-pa-20">
                        
                            <?=
                            Breadcrumbs::widget([
                                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                            ])
                            ?>
                            <?= Alert::widget() ?>
                            <?= $content ?>
                        
                        
                        
                        <div class="row">
                            
                            
                            
                            
                            <div class="col-sm-6 col-lg-6 col-xl-3 g-mb-30">
                                <!-- Panel -->
                                <div class="card h-100 g-brd-gray-light-v7 g-rounded-3">
                                    <div class="card-block g-font-weight-300 g-pa-20">
                                        <div class="media">
                                            <div class="d-flex g-mr-15">
                                                <div class="u-header-dropdown-icon-v1 g-pos-rel g-width-60 g-height-60 g-bg-lightblue-v3 g-font-size-18 g-font-size-24--md g-color-white rounded-circle">
                                                    <i class="hs-admin-briefcase g-absolute-centered"></i>
                                                </div>
                                            </div>

                                            <div class="media-body align-self-center">
                                                <div class="d-flex align-items-center g-mb-5">
                                                    <span class="g-font-size-24 g-line-height-1 g-color-black">99.9%</span>
                                                    <span class="d-flex align-self-center g-font-size-0 g-ml-5 g-ml-10--md">
                                                        <i class="g-fill-gray-dark-v9">
                                                            <svg width="12px" height="20px" viewbox="0 0 12 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                                            <g transform="translate(-21.000000, -751.000000)">
                                                            <g transform="translate(0.000000, 64.000000)">
                                                            <g transform="translate(20.000000, 619.000000)">
                                                            <g transform="translate(1.000000, 68.000000)">
                                                            <polygon points="6 20 0 13.9709049 0.576828937 13.3911999 5.59205874 18.430615 5.59205874 0 6.40794126 0 6.40794126 18.430615 11.4223552 13.3911999 12 13.9709049"></polygon>
                                                            </g>
                                                            </g>
                                                            </g>
                                                            </g>
                                                            </svg>
                                                        </i>
                                                        <i class="g-fill-lightblue-v3">
                                                            <svg width="12px" height="20px" viewbox="0 0 12 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                                            <g transform="translate(-33.000000, -751.000000)">
                                                            <g transform="translate(0.000000, 64.000000)">
                                                            <g transform="translate(20.000000, 619.000000)">
                                                            <g transform="translate(1.000000, 68.000000)">
                                                            <polygon
                                                                transform="translate(18.000000, 10.000000) scale(1, -1) translate(-18.000000, -10.000000)"
                                                                points="18 20 12 13.9709049 12.5768289 13.3911999 17.5920587 18.430615 17.5920587 0 18.4079413 0 18.4079413 18.430615 23.4223552 13.3911999 24 13.9709049"></polygon>
                                                            </g>
                                                            </g>
                                                            </g>
                                                            </g>
                                                            </svg>
                                                        </i>
                                                    </span>
                                                </div>

                                                <h6 class="g-font-size-16 g-font-weight-300 g-color-gray-dark-v6 mb-0">Projects Done</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Panel -->
                            </div>

                            <div class="col-sm-6 col-lg-6 col-xl-3 g-mb-30">
                                <!-- Panel -->
                                <div class="card h-100 g-brd-gray-light-v7 g-rounded-3">
                                    <div class="card-block g-font-weight-300 g-pa-20">
                                        <div class="media">
                                            <div class="d-flex g-mr-15">
                                                <div class="u-header-dropdown-icon-v1 g-pos-rel g-width-60 g-height-60 g-bg-teal-v2 g-font-size-18 g-font-size-24--md g-color-white rounded-circle">
                                                    <i class="hs-admin-check-box g-absolute-centered"></i>
                                                </div>
                                            </div>

                                            <div class="media-body align-self-center">
                                                <div class="d-flex align-items-center g-mb-5">
                                                    <span class="g-font-size-24 g-line-height-1 g-color-black">324</span>
                                                    <span class="d-flex align-self-center g-font-size-0 g-ml-5 g-ml-10--md">
                                                        <i class="g-fill-gray-dark-v9">
                                                            <svg width="12px" height="20px" viewbox="0 0 12 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                                            <g transform="translate(-21.000000, -751.000000)">
                                                            <g transform="translate(0.000000, 64.000000)">
                                                            <g transform="translate(20.000000, 619.000000)">
                                                            <g transform="translate(1.000000, 68.000000)">
                                                            <polygon points="6 20 0 13.9709049 0.576828937 13.3911999 5.59205874 18.430615 5.59205874 0 6.40794126 0 6.40794126 18.430615 11.4223552 13.3911999 12 13.9709049"></polygon>
                                                            </g>
                                                            </g>
                                                            </g>
                                                            </g>
                                                            </svg>
                                                        </i>
                                                        <i class="g-fill-lightblue-v3">
                                                            <svg width="12px" height="20px" viewbox="0 0 12 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                                            <g transform="translate(-33.000000, -751.000000)">
                                                            <g transform="translate(0.000000, 64.000000)">
                                                            <g transform="translate(20.000000, 619.000000)">
                                                            <g transform="translate(1.000000, 68.000000)">
                                                            <polygon
                                                                transform="translate(18.000000, 10.000000) scale(1, -1) translate(-18.000000, -10.000000)"
                                                                points="18 20 12 13.9709049 12.5768289 13.3911999 17.5920587 18.430615 17.5920587 0 18.4079413 0 18.4079413 18.430615 23.4223552 13.3911999 24 13.9709049"></polygon>
                                                            </g>
                                                            </g>
                                                            </g>
                                                            </g>
                                                            </svg>
                                                        </i>
                                                    </span>
                                                </div>

                                                <h6 class="g-font-size-16 g-font-weight-300 g-color-gray-dark-v6 mb-0">Total Tasks</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Panel -->
                            </div>

                            <div class="col-sm-6 col-lg-6 col-xl-3 g-mb-30">
                                <!-- Panel -->
                                <div class="card h-100 g-brd-gray-light-v7 g-rounded-3">
                                    <div class="card-block g-font-weight-300 g-pa-20">
                                        <div class="media">
                                            <div class="d-flex g-mr-15">
                                                <div class="u-header-dropdown-icon-v1 g-pos-rel g-width-60 g-height-60 g-bg-darkblue-v2 g-font-size-18 g-font-size-24--md g-color-white rounded-circle">
                                                    <i class="hs-admin-wallet g-absolute-centered"></i>
                                                </div>
                                            </div>

                                            <div class="media-body align-self-center">
                                                <div class="d-flex align-items-center g-mb-5">
                                                    <span class="g-font-size-24 g-line-height-1 g-color-black">$124.2</span>
                                                    <span class="d-flex align-self-center g-font-size-0 g-ml-5 g-ml-10--md">
                                                        <i class="g-fill-red">
                                                            <svg width="12px" height="20px" viewbox="0 0 12 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                                            <g transform="translate(-21.000000, -751.000000)">
                                                            <g transform="translate(0.000000, 64.000000)">
                                                            <g transform="translate(20.000000, 619.000000)">
                                                            <g transform="translate(1.000000, 68.000000)">
                                                            <polygon points="6 20 0 13.9709049 0.576828937 13.3911999 5.59205874 18.430615 5.59205874 0 6.40794126 0 6.40794126 18.430615 11.4223552 13.3911999 12 13.9709049"></polygon>
                                                            </g>
                                                            </g>
                                                            </g>
                                                            </g>
                                                            </svg>
                                                        </i>
                                                        <i class="g-fill-gray-dark-v9">
                                                            <svg width="12px" height="20px" viewbox="0 0 12 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                                            <g transform="translate(-33.000000, -751.000000)">
                                                            <g transform="translate(0.000000, 64.000000)">
                                                            <g transform="translate(20.000000, 619.000000)">
                                                            <g transform="translate(1.000000, 68.000000)">
                                                            <polygon
                                                                transform="translate(18.000000, 10.000000) scale(1, -1) translate(-18.000000, -10.000000)"
                                                                points="18 20 12 13.9709049 12.5768289 13.3911999 17.5920587 18.430615 17.5920587 0 18.4079413 0 18.4079413 18.430615 23.4223552 13.3911999 24 13.9709049"></polygon>
                                                            </g>
                                                            </g>
                                                            </g>
                                                            </g>
                                                            </svg>
                                                        </i>
                                                    </span>
                                                </div>

                                                <h6 class="g-font-size-16 g-font-weight-300 g-color-gray-dark-v6 mb-0">Projects Done</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Panel -->
                            </div>

                            <div class="col-sm-6 col-lg-6 col-xl-3 g-mb-30">
                                <!-- Panel -->
                                <div class="card h-100 g-brd-gray-light-v7 g-rounded-3">
                                    <div class="card-block g-font-weight-300 g-pa-20">
                                        <div class="media">
                                            <div class="d-flex g-mr-15">
                                                <div class="u-header-dropdown-icon-v1 g-pos-rel g-width-60 g-height-60 g-bg-lightred-v2 g-font-size-18 g-font-size-24--md g-color-white rounded-circle">
                                                    <i class="hs-admin-user g-absolute-centered"></i>
                                                </div>
                                            </div>

                                            <div class="media-body align-self-center">
                                                <div class="d-flex align-items-center g-mb-5">
                                                    <span class="g-font-size-24 g-line-height-1 g-color-black">148</span>
                                                    <span class="d-flex align-self-center g-font-size-0 g-ml-5 g-ml-10--md">
                                                        <i class="g-fill-gray-dark-v9">
                                                            <svg width="12px" height="20px" viewbox="0 0 12 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                                            <g transform="translate(-21.000000, -751.000000)">
                                                            <g transform="translate(0.000000, 64.000000)">
                                                            <g transform="translate(20.000000, 619.000000)">
                                                            <g transform="translate(1.000000, 68.000000)">
                                                            <polygon points="6 20 0 13.9709049 0.576828937 13.3911999 5.59205874 18.430615 5.59205874 0 6.40794126 0 6.40794126 18.430615 11.4223552 13.3911999 12 13.9709049"></polygon>
                                                            </g>
                                                            </g>
                                                            </g>
                                                            </g>
                                                            </svg>
                                                        </i>
                                                        <i class="g-fill-gray-dark-v9">
                                                            <svg width="12px" height="20px" viewbox="0 0 12 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                                            <g transform="translate(-33.000000, -751.000000)">
                                                            <g transform="translate(0.000000, 64.000000)">
                                                            <g transform="translate(20.000000, 619.000000)">
                                                            <g transform="translate(1.000000, 68.000000)">
                                                            <polygon
                                                                transform="translate(18.000000, 10.000000) scale(1, -1) translate(-18.000000, -10.000000)"
                                                                points="18 20 12 13.9709049 12.5768289 13.3911999 17.5920587 18.430615 17.5920587 0 18.4079413 0 18.4079413 18.430615 23.4223552 13.3911999 24 13.9709049"></polygon>
                                                            </g>
                                                            </g>
                                                            </g>
                                                            </g>
                                                            </svg>
                                                        </i>
                                                    </span>
                                                </div>

                                                <h6 class="g-font-size-16 g-font-weight-300 g-color-gray-dark-v6 mb-0">New Clients</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Panel -->
                            </div>

                            <!-- Statistic Card -->
                            <div class="col-xl-12">
                                <!-- Statistic Card -->
                                <div class="card g-brd-gray-light-v7 g-pa-15 g-pa-25-30--md g-mb-30">
                                    <header class="media g-mb-30">
                                        <h3 class="d-flex align-self-center text-uppercase g-font-size-12 g-font-size-default--md g-color-black mb-0">Project statistics</h3>

                                        <div class="media-body d-flex justify-content-end">
                                            <div id="rangePickerWrapper2" class="d-flex align-items-center u-datepicker-right u-datepicker--v3">
                                                <input id="rangeDatepicker2" class="g-font-size-12 g-font-size-default--md" type="text" data-rp-wrapper="#rangePickerWrapper2" data-rp-type="range" data-rp-date-format="d M Y" data-rp-default-date='["01 Jan 2016", "31 Dec 2017"]'>
                                                <i class="hs-admin-angle-down g-absolute-centered--y g-right-0 g-color-gray-light-v3"></i>
                                            </div>

                                            <a class="d-flex align-items-center hs-admin-panel u-link-v5 g-font-size-20 g-color-gray-light-v3 g-color-secondary--hover g-ml-5 g-ml-30--md" href="#"></a>
                                        </div>
                                    </header>

                                    <section>
                                        <ul class="list-unstyled d-flex g-mb-45">
                                            <li class="media">
                                                <div class="d-flex align-self-center g-mr-8">
                                                    <span class="u-badge-v2--md g-pos-stc g-transform-origin--top-left g-bg-lightblue-v3"></span>
                                                </div>

                                                <div class="media-body align-self-center g-font-size-12 g-font-size-default--md">Total hits</div>
                                            </li>
                                            <li class="media g-ml-5 g-ml-35--md">
                                                <div class="d-flex align-self-center g-mr-8">
                                                    <span class="u-badge-v2--md g-pos-stc g-transform-origin--top-left g-bg-darkblue-v2"></span>
                                                </div>

                                                <div class="media-body align-self-center g-font-size-12 g-font-size-default--md">Unique visits</div>
                                            </li>
                                            <li class="media g-ml-5 g-ml-35--md">
                                                <div class="d-flex align-self-center g-mr-8">
                                                    <span class="u-badge-v2--md g-pos-stc g-transform-origin--top-left g-bg-lightred-v2"></span>
                                                </div>

                                                <div class="media-body align-self-center g-font-size-12 g-font-size-default--md">New orders</div>
                                            </li>
                                        </ul>

                                        <div class="js-area-chart u-area-chart--v1 g-pos-rel g-line-height-0" data-height="300px" data-mobile-height="180px" data-high="5000000" data-low="0" data-offset-x="30" data-offset-y="50" data-postfix=" m" data-is-show-area="true" data-is-show-line="false"
                                             data-is-show-point="true" data-is-full-width="true" data-is-stack-bars="true" data-is-show-axis-x="true" data-is-show-axis-y="true" data-is-show-tooltips="true" data-tooltip-description-position="right" data-tooltip-custom-class="u-tooltip--v2 g-font-weight-300 g-font-size-default g-color-gray-dark-v6"
                                             data-align-text-axis-x="center" data-fill-opacity=".7" data-fill-colors='["#e62154","#3dd1e8","#1d75e5"]' data-stroke-color="#e1eaea" data-stroke-dash-array="0" data-text-size-x="14px" data-text-color-x="#000000" data-text-offset-top-x="10"
                                             data-text-size-y="14px" data-text-color-y="#53585e" data-points-colors='["#e62154","#3dd1e8","#1d75e5"]' data-series='[
                                             [
                                             {"meta": "Orders", "value": 300000},
                                             {"meta": "Orders", "value": 500000},
                                             {"meta": "Orders", "value": 700000},
                                             {"meta": "Orders", "value": 1100000},
                                             {"meta": "Orders", "value": 800000},
                                             {"meta": "Orders", "value": 800000},
                                             {"meta": "Orders", "value": 1000000},
                                             {"meta": "Orders", "value": 2300000},
                                             {"meta": "Orders", "value": 700000},
                                             {"meta": "Orders", "value": 300000},
                                             {"meta": "Orders", "value": 600000},
                                             {"meta": "Orders", "value": 300000}
                                             ],
                                             [
                                             {"meta": "Hits", "value": 300000},
                                             {"meta": "Hits", "value": 300000},
                                             {"meta": "Hits", "value": 300000},
                                             {"meta": "Hits", "value": 300000},
                                             {"meta": "Hits", "value": 300000},
                                             {"meta": "Hits", "value": 3300000},
                                             {"meta": "Hits", "value": 500000},
                                             {"meta": "Hits", "value": 500000},
                                             {"meta": "Hits", "value": 800000},
                                             {"meta": "Hits", "value": 1100000},
                                             {"meta": "Hits", "value": 1500000},
                                             {"meta": "Hits", "value": 300000}
                                             ],
                                             [
                                             {"meta": "Visits", "value": 300000},
                                             {"meta": "Visits", "value": 300000},
                                             {"meta": "Visits", "value": 300000},
                                             {"meta": "Visits", "value": 300000},
                                             {"meta": "Visits", "value": 2300000},
                                             {"meta": "Visits", "value": 1000000},
                                             {"meta": "Visits", "value": 500000},
                                             {"meta": "Visits", "value": 500000},
                                             {"meta": "Visits", "value": 500000},
                                             {"meta": "Visits", "value": 1000000},
                                             {"meta": "Visits", "value": 300000},
                                             {"meta": "Visits", "value": 300000}
                                             ]
                                             ]' data-labels='["Jan", "Feb", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]'></div>
                                    </section>
                                </div>
                                <!-- End Statistic Card -->
                            </div>
                            <!-- End Statistic Card -->

                            <!-- Income Card -->
                            <div class="col-xl-8">

                                <!-- Income Cards -->
                                <div class="card g-brd-gray-light-v7 g-mb-30">
                                    <header class="media g-pa-15 g-pa-25-30-0--md g-mb-20">
                                        <div class="media-body align-self-center">
                                            <h3 class="text-uppercase g-font-size-default g-color-black g-mb-8">Total Income</h3>

                                            <div id="rangePickerWrapper3" class="u-datepicker-left u-datepicker--v3">
                                                <input id="rangeDatepicker3" class="g-font-size-12 g-font-size-default--md" type="text" data-rp-wrapper="#rangePickerWrapper3" data-rp-type="range" data-rp-date-format="d M Y" data-rp-default-date='["01 Jan 2016", "31 Dec 2017"]'>
                                                <i class="hs-admin-angle-down g-absolute-centered--y g-right-0 g-color-gray-light-v3"></i>
                                            </div>
                                        </div>

                                        <div class="d-flex align-self-end align-items-center">
                                            <span class="g-line-height-1 g-font-weight-300 g-font-size-28 g-color-secondary">$48,200</span>
                                            <span class="d-flex align-self-center g-font-size-0 g-ml-10">
                                                <i class="g-fill-gray-dark-v9">
                                                    <svg width="12px" height="20px" viewBox="0 0 12 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                                    <g transform="translate(-21.000000, -751.000000)">
                                                    <g transform="translate(0.000000, 64.000000)">
                                                    <g transform="translate(20.000000, 619.000000)">
                                                    <g transform="translate(1.000000, 68.000000)">
                                                    <polygon points="6 20 0 13.9709049 0.576828937 13.3911999 5.59205874 18.430615 5.59205874 0 6.40794126 0 6.40794126 18.430615 11.4223552 13.3911999 12 13.9709049"></polygon>
                                                    </g>
                                                    </g>
                                                    </g>
                                                    </g>
                                                    </svg>
                                                </i>
                                                <i class="g-fill-lightblue-v3">
                                                    <svg width="12px" height="20px" viewBox="0 0 12 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                                    <g transform="translate(-33.000000, -751.000000)">
                                                    <g transform="translate(0.000000, 64.000000)">
                                                    <g transform="translate(20.000000, 619.000000)">
                                                    <g transform="translate(1.000000, 68.000000)">
                                                    <polygon transform="translate(18.000000, 10.000000) scale(1, -1) translate(-18.000000, -10.000000)" points="18 20 12 13.9709049 12.5768289 13.3911999 17.5920587 18.430615 17.5920587 0 18.4079413 0 18.4079413 18.430615 23.4223552 13.3911999 24 13.9709049"></polygon>
                                                    </g>
                                                    </g>
                                                    </g>
                                                    </g>
                                                    </svg>
                                                </i>
                                            </span>
                                        </div>
                                    </header>

                                    <div class="js-custom-scroll g-height-500 g-pa-15 g-pa-0-30-25--md">
                                        <table class="table table-responsive-sm w-100">
                                            <thead>
                                                <tr>
                                                    <th class="g-font-weight-300 g-color-gray-dark-v6 g-brd-top-none g-pl-20">#</th>
                                                    <th class="g-font-weight-300 g-color-gray-dark-v6 g-brd-top-none">Name</th>
                                                    <th class="g-font-weight-300 g-color-gray-dark-v6 g-brd-top-none">Status</th>
                                                    <th class="g-font-weight-300 g-color-gray-dark-v6 g-brd-top-none">Date</th>
                                                    <th class="text-right g-font-weight-300 g-color-gray-dark-v6 g-brd-top-none">Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="g-font-size-default g-color-black g-valign-middle g-brd-top-none g-brd-bottom g-brd-2 g-brd-gray-light-v4 g-py-10 g-pl-20">1</td>
                                                    <td class="g-font-size-default g-color-black g-valign-middle g-brd-top-none g-brd-bottom g-brd-2 g-brd-gray-light-v4 g-py-10">Business Cards</td>
                                                    <td class="g-font-size-default g-color-black g-valign-middle g-brd-top-none g-brd-bottom g-brd-2 g-brd-gray-light-v4 g-py-10">
                                                        <span class="u-tags-v1 text-center g-width-100 g-brd-around g-brd-lightblue-v3 g-bg-lightblue-v3 g-font-size-default g-color-white g-rounded-50 g-py-4 g-px-15">approved</span>
                                                    </td>
                                                    <td class="g-valign-middle g-brd-top-none g-brd-bottom g-brd-2 g-brd-gray-light-v4 g-py-10">Aug 12, 2016</td>
                                                    <td class="text-right g-font-size-default g-color-black g-valign-middle g-brd-top-none g-brd-bottom g-brd-2 g-brd-gray-light-v4 g-py-10">$2045</td>
                                                </tr>

                                                <tr>
                                                    <td class="g-font-size-default g-color-black g-valign-middle g-brd-top-none g-brd-bottom g-brd-2 g-brd-gray-light-v4 g-py-10 g-pl-20">2</td>
                                                    <td class="g-font-size-default g-color-black g-valign-middle g-brd-top-none g-brd-bottom g-brd-2 g-brd-gray-light-v4 g-py-10">Advertising Outdoors</td>
                                                    <td class="g-font-size-default g-color-black g-valign-middle g-brd-top-none g-brd-bottom g-brd-2 g-brd-gray-light-v4 g-py-10">
                                                        <span class="u-tags-v1 text-center g-width-100 g-brd-around g-brd-lightred-v2 g-bg-lightred-v2 g-font-size-default g-color-white g-rounded-50 g-py-4 g-px-15">pending</span>
                                                    </td>
                                                    <td class="g-valign-middle g-brd-top-none g-brd-bottom g-brd-2 g-brd-gray-light-v4 g-py-10">Jun 6, 2016</td>
                                                    <td class="text-right g-font-size-default g-color-black g-valign-middle g-brd-top-none g-brd-bottom g-brd-2 g-brd-gray-light-v4 g-py-10">$995</td>
                                                </tr>

                                                <tr>
                                                    <td class="g-font-size-default g-color-black g-valign-middle g-brd-top-none g-brd-bottom g-brd-2 g-brd-gray-light-v4 g-py-10 g-pl-20">3</td>
                                                    <td class="g-font-size-default g-color-black g-valign-middle g-brd-top-none g-brd-bottom g-brd-2 g-brd-gray-light-v4 g-py-10">Freelance Design</td>
                                                    <td class="g-font-size-default g-color-black g-valign-middle g-brd-top-none g-brd-bottom g-brd-2 g-brd-gray-light-v4 g-py-10">
                                                        <span class="u-tags-v1 text-center g-width-100 g-brd-around g-brd-teal-v2 g-bg-teal-v2 g-font-size-default g-color-white g-rounded-50 g-py-4 g-px-15">done</span>
                                                    </td>
                                                    <td class="g-valign-middle g-brd-top-none g-brd-bottom g-brd-2 g-brd-gray-light-v4 g-py-10">Sep 8, 2016</td>
                                                    <td class="text-right g-font-size-default g-color-black g-valign-middle g-brd-top-none g-brd-bottom g-brd-2 g-brd-gray-light-v4 g-py-10">$1025</td>
                                                </tr>

                                                <tr>
                                                    <td class="g-font-size-default g-color-black g-valign-middle g-brd-top-none g-brd-bottom g-brd-2 g-brd-gray-light-v4 g-py-10 g-pl-20">4</td>
                                                    <td class="g-font-size-default g-color-black g-valign-middle g-brd-top-none g-brd-bottom g-brd-2 g-brd-gray-light-v4 g-py-10">Music Improvement</td>
                                                    <td class="g-font-size-default g-color-black g-valign-middle g-brd-top-none g-brd-bottom g-brd-2 g-brd-gray-light-v4 g-py-10">
                                                        <span class="u-tags-v1 text-center g-width-100 g-brd-around g-brd-lightblue-v3 g-bg-lightblue-v3 g-font-size-default g-color-white g-rounded-50 g-py-4 g-px-15">approved</span>
                                                    </td>
                                                    <td class="g-valign-middle g-brd-top-none g-brd-bottom g-brd-2 g-brd-gray-light-v4 g-py-10">Dec 20, 2016</td>
                                                    <td class="text-right g-font-size-default g-color-black g-valign-middle g-brd-top-none g-brd-bottom g-brd-2 g-brd-gray-light-v4 g-py-10">$9562</td>
                                                </tr>

                                                <tr>
                                                    <td class="g-font-size-default g-color-black g-valign-middle g-brd-top-none g-brd-bottom--md g-brd-2 g-brd-gray-light-v4 g-py-10 g-pl-20">5</td>
                                                    <td class="g-font-size-default g-color-black g-valign-middle g-brd-top-none g-brd-bottom--md g-brd-2 g-brd-gray-light-v4 g-py-10">Truck Advertising</td>
                                                    <td class="g-font-size-default g-color-black g-valign-middle g-brd-top-none g-brd-bottom--md g-brd-2 g-brd-gray-light-v4 g-py-10">
                                                        <span class="u-tags-v1 text-center g-width-100 g-brd-around g-brd-teal-v2 g-bg-teal-v2 g-font-size-default g-color-white g-rounded-50 g-py-4 g-px-15">done</span>
                                                    </td>
                                                    <td class="g-valign-middle g-brd-top-none g-brd-bottom--md g-brd-2 g-brd-gray-light-v4 g-py-10">Dec 24, 2016</td>
                                                    <td class="text-right g-font-size-default g-color-black g-valign-middle g-brd-top-none g-brd-bottom--md g-brd-2 g-brd-gray-light-v4 g-py-10">$5470</td>
                                                </tr>

                                                <tr>
                                                    <td class="g-font-size-default g-color-black g-valign-middle g-brd-top-none g-brd-bottom g-brd-2 g-brd-gray-light-v4 g-py-10 g-pl-20">6</td>
                                                    <td class="g-font-size-default g-color-black g-valign-middle g-brd-top-none g-brd-bottom g-brd-2 g-brd-gray-light-v4 g-py-10">Business Cards</td>
                                                    <td class="g-font-size-default g-color-black g-valign-middle g-brd-top-none g-brd-bottom g-brd-2 g-brd-gray-light-v4 g-py-10">
                                                        <span class="u-tags-v1 text-center g-width-100 g-brd-around g-brd-lightblue-v3 g-bg-lightblue-v3 g-font-size-default g-color-white g-rounded-50 g-py-4 g-px-15">approved</span>
                                                    </td>
                                                    <td class="g-valign-middle g-brd-top-none g-brd-bottom g-brd-2 g-brd-gray-light-v4 g-py-10">Aug 12, 2016</td>
                                                    <td class="text-right g-font-size-default g-color-black g-valign-middle g-brd-top-none g-brd-bottom g-brd-2 g-brd-gray-light-v4 g-py-10">$2045</td>
                                                </tr>

                                                <tr>
                                                    <td class="g-font-size-default g-color-black g-valign-middle g-brd-top-none g-brd-bottom g-brd-2 g-brd-gray-light-v4 g-py-10 g-pl-20">7</td>
                                                    <td class="g-font-size-default g-color-black g-valign-middle g-brd-top-none g-brd-bottom g-brd-2 g-brd-gray-light-v4 g-py-10">Advertising Outdoors</td>
                                                    <td class="g-font-size-default g-color-black g-valign-middle g-brd-top-none g-brd-bottom g-brd-2 g-brd-gray-light-v4 g-py-10">
                                                        <span class="u-tags-v1 text-center g-width-100 g-brd-around g-brd-lightred-v2 g-bg-lightred-v2 g-font-size-default g-color-white g-rounded-50 g-py-4 g-px-15">pending</span>
                                                    </td>
                                                    <td class="g-valign-middle g-brd-top-none g-brd-bottom g-brd-2 g-brd-gray-light-v4 g-py-10">Jun 6, 2016</td>
                                                    <td class="text-right g-font-size-default g-color-black g-valign-middle g-brd-top-none g-brd-bottom g-brd-2 g-brd-gray-light-v4 g-py-10">$995</td>
                                                </tr>

                                                <tr>
                                                    <td class="g-font-size-default g-color-black g-valign-middle g-brd-top-none g-brd-bottom g-brd-2 g-brd-gray-light-v4 g-py-10 g-pl-20">8</td>
                                                    <td class="g-font-size-default g-color-black g-valign-middle g-brd-top-none g-brd-bottom g-brd-2 g-brd-gray-light-v4 g-py-10">Freelance Design</td>
                                                    <td class="g-font-size-default g-color-black g-valign-middle g-brd-top-none g-brd-bottom g-brd-2 g-brd-gray-light-v4 g-py-10">
                                                        <span class="u-tags-v1 text-center g-width-100 g-brd-around g-brd-teal-v2 g-bg-teal-v2 g-font-size-default g-color-white g-rounded-50 g-py-4 g-px-15">done</span>
                                                    </td>
                                                    <td class="g-valign-middle g-brd-top-none g-brd-bottom g-brd-2 g-brd-gray-light-v4 g-py-10">Sep 8, 2016</td>
                                                    <td class="text-right g-font-size-default g-color-black g-valign-middle g-brd-top-none g-brd-bottom g-brd-2 g-brd-gray-light-v4 g-py-10">$1025</td>
                                                </tr>

                                                <tr>
                                                    <td class="g-font-size-default g-color-black g-valign-middle g-brd-top-none g-brd-bottom g-brd-2 g-brd-gray-light-v4 g-py-10 g-pl-20">9</td>
                                                    <td class="g-font-size-default g-color-black g-valign-middle g-brd-top-none g-brd-bottom g-brd-2 g-brd-gray-light-v4 g-py-10">Music Improvement</td>
                                                    <td class="g-font-size-default g-color-black g-valign-middle g-brd-top-none g-brd-bottom g-brd-2 g-brd-gray-light-v4 g-py-10">
                                                        <span class="u-tags-v1 text-center g-width-100 g-brd-around g-brd-lightblue-v3 g-bg-lightblue-v3 g-font-size-default g-color-white g-rounded-50 g-py-4 g-px-15">approved</span>
                                                    </td>
                                                    <td class="g-valign-middle g-brd-top-none g-brd-bottom g-brd-2 g-brd-gray-light-v4 g-py-10">Dec 20, 2016</td>
                                                    <td class="text-right g-font-size-default g-color-black g-valign-middle g-brd-top-none g-brd-bottom g-brd-2 g-brd-gray-light-v4 g-py-10">$9562</td>
                                                </tr>

                                                <tr>
                                                    <td class="g-font-size-default g-color-black g-valign-middle g-brd-top-none g-brd-bottom--md g-brd-2 g-brd-gray-light-v4 g-py-10 g-pl-20">10</td>
                                                    <td class="g-font-size-default g-color-black g-valign-middle g-brd-top-none g-brd-bottom--md g-brd-2 g-brd-gray-light-v4 g-py-10">Truck Advertising</td>
                                                    <td class="g-font-size-default g-color-black g-valign-middle g-brd-top-none g-brd-bottom--md g-brd-2 g-brd-gray-light-v4 g-py-10">
                                                        <span class="u-tags-v1 text-center g-width-100 g-brd-around g-brd-teal-v2 g-bg-teal-v2 g-font-size-default g-color-white g-rounded-50 g-py-4 g-px-15">done</span>
                                                    </td>
                                                    <td class="g-valign-middle g-brd-top-none g-brd-bottom--md g-brd-2 g-brd-gray-light-v4 g-py-10">Dec 24, 2016</td>
                                                    <td class="text-right g-font-size-default g-color-black g-valign-middle g-brd-top-none g-brd-bottom--md g-brd-2 g-brd-gray-light-v4 g-py-10">$5470</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="js-area-chart u-area-chart--v1 g-pos-rel g-line-height-0" data-height="65px" data-high="2420" data-low="0" data-offset-x="0" data-offset-y="0" data-postfix=" m" data-is-show-area="true" data-is-show-line="false" data-is-show-point="true" data-is-full-width="true"
                                         data-is-stack-bars="true" data-is-show-axis-x="false" data-is-show-axis-y="false" data-is-show-tooltips="true" data-tooltip-description-position="left" data-tooltip-custom-class="u-tooltip--v2 g-font-weight-300 g-font-size-default g-color-gray-dark-v6"
                                         data-align-text-axis-x="center" data-fill-opacity="1" data-fill-colors='["#67c8d8"]' data-stroke-color="#e1eaea" data-stroke-dash-array="0" data-text-size-x="14px" data-text-color-x="#000000" data-text-offset-top-x="0" data-text-size-y="14px"
                                         data-text-color-y="#53585e" data-points-colors='["#1cc9e4"]' data-series='[
                                         [
                                         {"meta": "$", "value": 100},
                                         {"meta": "$", "value": 2100},
                                         {"meta": "$", "value": 350},
                                         {"meta": "$", "value": 2920},
                                         {"meta": "$", "value": 840},
                                         {"meta": "$", "value": 2770}
                                         ]
                                         ]' data-labels='["2013", "2014", "2015", "2016", "2017"]'></div>
                                </div>
                                <!-- End Income Cards -->
                            </div>
                            <!-- End Income Card -->

                            <!-- Calendar Card -->
                            <div class="col-xl-4">

                                <!-- Calendar Card -->
                                <div class="g-mb-30">
                                    <header class="u-bg-overlay g-bg-img-hero g-bg-black-opacity-0_5--after g-rounded-4 g-rounded-0--bottom-left g-rounded-0--bottom-right g-overflow-hidden" style="background-image: url(../assets/img-temp/400x270/img3.jpg);">
                                        <div class="u-bg-overlay__inner g-color-white g-pa-30">
                                            <h3 class="g-font-weight-300 g-font-size-28 g-color-white g-mb-35">
                                                Friday 3rd
                                                <span class="d-block g-font-size-16">January 2017</span>
                                            </h3>
                                            <a class="btn btn-md text-uppercase u-btn-outline-white" href="#">Add event</a>
                                        </div>
                                    </header>

                                    <section class="g-brd-around g-brd-top-none g-brd-gray-light-v7 g-rounded-4 g-rounded-0--top-left g-rounded-0--top-right">
                                        <div class="g-pa-10 g-pa-20--md">
                                            <div id="datepicker" class="u-datepicker--v2"></div>
                                        </div>

                                        <ul class="list-unstyled">
                                            <li class="media g-bg-gray-light-v8 g-brd-left g-brd-2 g-brd-darkblue-v2 g-px-30 g-py-15 g-mb-2 g-ml-minus-1">
                                                <strong class="d-flex align-self-center g-width-80 g-color-black">8:00am</strong>

                                                <div class="media-body g-font-weight-300 g-color-black">Build My Own Website</div>
                                            </li>
                                            <li class="media g-bg-gray-light-v8 g-brd-left g-brd-2 g-brd-secondary g-px-30 g-py-15 g-mb-2 g-ml-minus-1">
                                                <strong class="d-flex align-self-center g-width-80 g-color-black">9:00am</strong>

                                                <div class="media-body g-font-weight-300 g-color-black">Create New Content</div>
                                            </li>
                                            <li class="media g-bg-gray-light-v8 g-brd-left g-brd-2 g-brd-darkblue-v2 g-px-30 g-py-15 g-mb-2 g-ml-minus-1">
                                                <strong class="d-flex align-self-center g-width-80 g-color-black">10:00am</strong>

                                                <div class="media-body g-font-weight-300 g-color-black">Check Unify Profile Updates</div>
                                            </li>
                                        </ul>
                                    </section>
                                </div>
                                <!-- End Calendar Card -->
                            </div>
                            <!-- End Calendar Card -->

                            <!-- Activity Card -->
                            <div class="col-xl-4">

                                <!-- Activity Card -->
                                <div class="card g-brd-gray-light-v7 g-mb-30">
                                    <header class="media g-pa-15 g-pa-25-30-0--md g-mb-16">
                                        <h3 class="d-flex align-self-center text-uppercase g-font-size-12 g-font-size-default--md g-color-black g-mr-20 mb-0">Activity</h3>

                                        <div class="media-body d-flex justify-content-end">
                                            <div id="rangePickerWrapper" class="u-datepicker-right u-datepicker--v3 g-pr-10">
                                                <input id="rangeDatepicker" class="g-font-size-12 g-font-size-default--md" type="text" data-rp-wrapper="#rangePickerWrapper" data-rp-type="range" data-rp-date-format="d M Y" data-rp-default-date='["01 Jan 2016", "31 Dec 2017"]'>
                                                <i class="hs-admin-angle-down g-absolute-centered--y g-right-0 g-color-gray-light-v3"></i>
                                            </div>
                                        </div>
                                    </header>

                                    <div class="js-custom-scroll g-height-400 g-pa-15 g-pl-5--md g-pr-30--md g-py-25--md">
                                        <section class="u-timeline-v2-wrap g-pos-rel g-left-25--before g-mb-20">
                                            <div class="g-orientation-left g-pos-rel g-ml-25--md g-pl-20">
                                                <div class="g-hidden-sm-down u-timeline-v2__icon g-top-35">
                                                    <i class="d-block g-width-16 g-height-16 g-bg-white g-brd-around g-brd-2 g-brd-secondary rounded-circle"></i>
                                                </div>

                                                <div class="media g-mb-16">
                                                    <div class="d-flex align-self-center g-mr-15">
                                                        <img class="g-width-55 g-height-55 rounded-circle" src="../assets/img-temp/100x100/img1.jpg" alt="Image Description">
                                                    </div>

                                                    <div class="media-body align-self-center">
                                                        <h3 class="g-font-weight-300 g-font-size-16 g-mb-3">Htmlstream</h3>
                                                        <em class="g-font-style-normal g-color-secondary">Commented on Project</em>
                                                    </div>
                                                </div>

                                                <p class="g-font-weight-300 g-font-size-default g-mb-16">When you browse through videos at YouTube, which do you usually click first: one with around 10 views or one with around 75,000 views</p>
                                                <em class="d-flex align-self-center align-items-center g-font-style-normal g-color-gray-dark-v6">
                                                    <i class="hs-admin-time g-font-size-default g-font-size-18--md g-color-gray-light-v3"></i>
                                                    <span class="g-font-weight-300 g-font-size-12 g-font-size-default--md g-ml-4 g-ml-8--md">45 Min <span class="g-hidden-md-down">ago</span></span>
                                                </em>
                                            </div>

                                            <hr class="d-flex g-brd-gray-light-v4 g-ml-35--md g-my-20 g-my-30--md">

                                            <div class="g-orientation-left g-pos-rel g-ml-25--md g-pl-20">
                                                <div class="g-hidden-sm-down u-timeline-v2__icon g-top-35">
                                                    <i class="d-block g-width-16 g-height-16 g-bg-white g-brd-around g-brd-2 g-brd-secondary rounded-circle"></i>
                                                </div>

                                                <div class="media g-mb-25">
                                                    <div class="d-flex align-self-center g-mr-15">
                                                        <img class="g-width-55 g-height-55 rounded-circle" src="../assets/img-temp/100x100/img4.jpg" alt="Image Description">
                                                    </div>

                                                    <div class="media-body align-self-center">
                                                        <h3 class="g-font-weight-300 g-font-size-16 g-mb-3">E<span class="g-hidden-md-down">mma&nbsp;</span><span class="g-hidden-md-up">.</span>Watson</h3>
                                                        <em class="g-font-style-normal g-color-secondary">Added New Files</em>
                                                    </div>
                                                </div>

                                                <em class="d-flex align-self-center align-items-center g-font-style-normal g-mb-30">
                                                    <i class="hs-admin-zip g-font-size-24 g-color-secondary"></i>
                                                    <span class="g-font-weight-300 g-font-size-default g-color-gray-dark-v6 g-ml-12">Project Updates.zip</span>
                                                </em>

                                                <em class="d-flex align-self-center align-items-center g-font-style-normal g-color-gray-dark-v6">
                                                    <i class="hs-admin-time g-font-size-default g-font-size-18--md g-color-gray-light-v3"></i>
                                                    <span class="g-font-weight-300 g-font-size-12 g-font-size-default--md g-ml-4 g-ml-8--md">10 Min <span class="g-hidden-md-down">ago</span></span>
                                                </em>
                                            </div>

                                            <hr class="d-flex g-brd-gray-light-v4 g-ml-35--md g-my-20 g-my-30--md">

                                            <div class="g-orientation-left g-pos-rel g-ml-25--md g-pl-20">
                                                <div class="g-hidden-sm-down u-timeline-v2__icon g-top-35">
                                                    <i class="d-block g-width-16 g-height-16 g-bg-white g-brd-around g-brd-2 g-brd-secondary rounded-circle"></i>
                                                </div>

                                                <div class="media g-mb-16">
                                                    <div class="d-flex align-self-center g-mr-15">
                                                        <img class="g-width-55 g-height-55 rounded-circle" src="../assets/img-temp/100x100/img5.jpg" alt="Image Description">
                                                    </div>

                                                    <div class="media-body align-self-center">
                                                        <h3 class="g-font-weight-300 g-font-size-16 g-mb-3">V<span class="g-hidden-md-down">erna&nbsp;</span><span class="g-hidden-md-up">.</span>Swanson</h3>
                                                        <em class="g-font-style-normal g-color-secondary">Commented on Project</em>
                                                    </div>
                                                </div>

                                                <p class="g-font-weight-300 g-font-size-default g-mb-16">The collapse of the online-advertising market in 2001 made marketing on the Internet seem even less compelling. Website usability, press releases, online media buys, podcasts, mobile marketing and more – there’s an entire world</p>
                                                <em class="d-flex align-self-center align-items-center g-font-style-normal g-color-gray-dark-v6">
                                                    <i class="hs-admin-time g-font-size-default g-font-size-18--md g-color-gray-light-v3"></i>
                                                    <span class="g-font-weight-300 g-font-size-12 g-font-size-default--md g-ml-4 g-ml-8--md">10 Min <span class="g-hidden-md-down">ago</span></span>
                                                </em>
                                            </div>

                                            <hr class="d-flex g-brd-gray-light-v4 g-ml-35--md g-my-20 g-my-30--md">

                                            <div class="g-orientation-left g-pos-rel g-ml-25--md g-pl-20">
                                                <div class="g-hidden-sm-down u-timeline-v2__icon g-top-35">
                                                    <i class="d-block g-width-16 g-height-16 g-bg-white g-brd-around g-brd-2 g-brd-secondary rounded-circle"></i>
                                                </div>

                                                <div class="media g-mb-16">
                                                    <div class="d-flex align-self-center g-mr-15">
                                                        <img class="g-width-55 g-height-55 rounded-circle" src="../assets/img-temp/100x100/img7.jpg" alt="Image Description">
                                                    </div>

                                                    <div class="media-body align-self-center">
                                                        <h3 class="g-font-weight-300 g-font-size-16 g-mb-3">J<span class="g-hidden-md-down">ohn&nbsp;</span><span class="g-hidden-md-up">.</span>Doe</h3>
                                                        <em class="g-font-style-normal g-color-secondary">Shared Project with Users</em>
                                                    </div>
                                                </div>

                                                <ul class="list-inline d-flex g-mb-20">
                                                    <li class="list-inline-item g-mb-10 g-mb-0--sm mr-0">
                                                        <img class="g-width-30 g-width-40--md g-height-30 g-height-40--md rounded-circle" src="../assets/img-temp/100x100/img4.jpg" alt="Image Description">
                                                    </li>
                                                    <li class="list-inline-item g-mb-10 g-mb-0--sm g-ml-7 mr-0">
                                                        <img class="g-width-30 g-width-40--md g-height-30 g-height-40--md rounded-circle" src="../assets/img-temp/100x100/img7.jpg" alt="Image Description">
                                                    </li>
                                                    <li class="list-inline-item g-mb-10 g-mb-0--sm g-ml-7 mr-0">
                                                        <img class="g-width-30 g-width-40--md g-height-30 g-height-40--md rounded-circle" src="../assets/img-temp/100x100/img14.jpg" alt="Image Description">
                                                    </li>
                                                    <li class="list-inline-item g-mb-10 g-mb-0--sm g-ml-7 mr-0">
                                                        <img class="g-width-30 g-width-40--md g-height-30 g-height-40--md rounded-circle" src="../assets/img-temp/100x100/img15.jpg" alt="Image Description">
                                                    </li>
                                                    <li class="list-inline-item g-mb-10 g-mb-0--sm g-ml-7 mr-0">
                                                        <div class="d-flex align-items-center justify-content-center g-width-30 g-width-40--md g-height-30 g-height-40--md g-bg-gray-light-v8 g-font-size-14 g-font-size-16--md g-color-secondary rounded-circle">+5</div>
                                                    </li>
                                                </ul>
                                                <em class="d-flex align-self-center align-items-center g-font-style-normal g-color-gray-dark-v6">
                                                    <i class="hs-admin-time g-font-size-default g-font-size-18--md g-color-gray-light-v3"></i>
                                                    <span class="g-font-weight-300 g-font-size-12 g-font-size-default--md g-ml-4 g-ml-8--md">10 Min <span class="g-hidden-md-down">ago</span></span>
                                                </em>
                                            </div>

                                            <hr class="d-flex g-brd-gray-light-v4 g-ml-35--md g-my-20 g-my-30--md">
                                        </section>

                                        <a class="d-flex align-items-center text-uppercase u-link-v5 g-font-style-normal g-color-secondary g-ml-25--md" href="#">
                                            <i class="hs-admin-reload g-font-size-20"></i>
                                            <span class="g-font-size-12 g-font-size-default--md g-ml-10 g-ml-25--md">Load more</span>
                                        </a>
                                    </div>
                                </div>
                                <!-- End Activity Card -->

                            </div>
                            <!-- End Activity Card -->

                            <!-- Tickets Card -->
                            <div class="col-xl-4">
                                <!-- Tickets Cards -->
                                <div class="card g-brd-gray-light-v7 g-mb-30">
                                    <header class="media g-pa-15 g-pa-25-30-0--md g-mb-20">
                                        <h3 class="text-uppercase g-font-size-12 g-font-size-default--md g-color-black mb-0">Tickets</h3>
                                    </header>

                                    <div class="js-custom-scroll g-height-400 g-pa-15 g-pa-0-30-25--md">
                                        <section>
                                            <div class="media">
                                                <div class="media-body g-mb-15">
                                                    <h3 class="g-font-weight-300 g-font-size-16 g-color-black g-mb-5">Freelance Design</h3>
                                                    <p class="g-font-weight-300 g-color-gray-dark-v6 mb-0">15 Tips To Increase Your Adwords</p>
                                                </div>

                                                <div class="d-flex">
                                                    <a class="u-link-v5 g-font-size-16 g-color-secondary" href="#">#001-3456</a>
                                                </div>
                                            </div>

                                            <div class="media">
                                                <div class="media-body align-self-center" href="#">
                                                    <span class="u-tags-v1 text-center g-width-140 g-bg-lightblue-v3 g-color-white g-brd-around g-brd-lightblue-v3 g-rounded-50 g-py-4 g-px-15">In Progress</span>
                                                </div>

                                                <em class="d-flex align-self-center align-items-center g-font-style-normal">
                                                    <i class="hs-admin-time g-font-size-default g-font-size-18--md g-color-gray-light-v3"></i>
                                                    <span class="g-font-weight-300 g-font-size-12 g-font-size-default--md g-color-gray-dark-v6 g-ml-4 g-ml-8--md">45 Min <span class="g-hidden-md-down">ago</span></span>
                                                </em>
                                            </div>
                                        </section>

                                        <hr class="d-flex g-brd-gray-light-v4 g-my-25">

                                        <section>
                                            <div class="media">
                                                <div class="media-body g-mb-15">
                                                    <h3 class="g-font-weight-300 g-font-size-16 g-color-black g-mb-5">The Flash Tutorial</h3>
                                                    <p class="g-font-weight-300 g-color-gray-dark-v6 mb-0">Las Vegas How To Have Non Gambling</p>
                                                </div>

                                                <div class="d-flex">
                                                    <a class="u-link-v5 g-font-size-16 g-color-secondary" href="#">#001-3458</a>
                                                </div>
                                            </div>

                                            <div class="media">
                                                <div class="media-body align-self-center" href="#">
                                                    <span class="u-tags-v1 text-center g-width-140 g-bg-teal-v2 g-color-white g-brd-around g-brd-teal-v2 g-rounded-50 g-py-4 g-px-15">Done</span>
                                                </div>

                                                <em class="d-flex align-self-center align-items-center g-font-style-normal">
                                                    <i class="hs-admin-time g-font-size-default g-font-size-18--md g-color-gray-light-v3"></i>
                                                    <span class="g-font-weight-300 g-font-size-12 g-font-size-default--md g-color-gray-dark-v6 g-ml-4 g-ml-8--md">15 Min <span class="g-hidden-md-down">ago</span></span>
                                                </em>
                                            </div>
                                        </section>

                                        <hr class="d-flex g-brd-gray-light-v4 g-my-25">

                                        <section>
                                            <div class="media">
                                                <div class="media-body g-mb-15">
                                                    <h3 class="g-font-weight-300 g-font-size-16 g-color-black g-mb-5">Free Advertising</h3>
                                                    <p class="g-font-weight-300 g-color-gray-dark-v6 mb-0">How Does An Lcd Screen Work</p>
                                                </div>

                                                <div class="d-flex">
                                                    <a class="u-link-v5 g-font-size-16 g-color-secondary" href="#">#001-3454</a>
                                                </div>
                                            </div>

                                            <div class="media">
                                                <div class="media-body align-self-center" href="#">
                                                    <span class="u-tags-v1 text-center g-width-140 g-bg-primary g-color-white g-brd-around g-brd-primary g-rounded-50 g-py-4 g-px-15">To Do</span>
                                                </div>

                                                <em class="d-flex align-self-center align-items-center g-font-style-normal">
                                                    <i class="hs-admin-time g-font-size-default g-font-size-18--md g-color-gray-light-v3"></i>
                                                    <span class="g-font-weight-300 g-font-size-12 g-font-size-default--md g-color-gray-dark-v6 g-ml-4 g-ml-8--md">10 Min <span class="g-hidden-md-down">ago</span></span>
                                                </em>
                                            </div>
                                        </section>
                                    </div>
                                </div>
                                <!-- End Tickets Cards -->
                            </div>
                            <!-- End Tickets Card -->

                            <!-- Comments Card -->
                            <div class="col-xl-4">
                                <!-- Comments Card-->
                                <div class="card g-brd-gray-light-v7 g-mb-30">
                                    <header class="media g-pa-15 g-pa-25-30-0--md g-mb-20">
                                        <h3 class="text-uppercase g-font-size-12 g-font-size-default--md g-color-black mb-0">Recent comments</h3>
                                    </header>

                                    <div class="js-custom-scroll g-height-400 g-pa-15 g-pa-0-30-25--md">
                                        <section class="media">
                                            <div class="d-flex g-mr-12">
                                                <img class="g-width-40 g-width-48--md g-height-40 g-height-48--md rounded-circle" src="../assets/img-temp/100x100/img5.jpg" alt="Image Description">
                                            </div>

                                            <div class="media-body">
                                                <h3 class="g-font-weight-300 g-font-size-16 g-color-black g-mb-5">V<span class="g-hidden-md-down">erna&nbsp;</span><span class="g-hidden-md-up">.</span>Swanson</h3>
                                                <p class="g-font-weight-300 g-color-gray-dark-v6 g-mb-15">15 Tips To Increase Your Adwords</p>

                                                <div class="media">
                                                    <div class="media-body align-self-center mr-3" href="#">
                                                        <span class="u-tags-v1 text-center g-width-140--md g-bg-gray-light-v8 g-font-size-12 g-font-size-default--md g-color-darkblue-v2 g-brd-around g-brd-gray-light-v8 g-rounded-50 g-py-4 g-px-15">Dropbox
                                                            <span class="g-hidden-sm-down">Project</span>
                                                        </span>
                                                    </div>

                                                    <em class="d-flex align-self-center align-items-center g-font-style-normal">
                                                        <i class="hs-admin-time g-font-size-default g-font-size-18--md g-color-gray-light-v3"></i>
                                                        <span class="g-font-weight-300 g-font-size-12 g-font-size-default--md g-color-gray-dark-v6 g-ml-4 g-ml-8--md">45 Min <span class="g-hidden-md-down">ago</span></span>
                                                    </em>
                                                </div>
                                            </div>
                                        </section>

                                        <hr class="d-flex g-brd-gray-light-v4 g-my-25">

                                        <section class="media">
                                            <div class="d-flex g-mr-12">
                                                <img class="g-width-40 g-width-48--md g-height-40 g-height-48--md rounded-circle" src="../assets/img-temp/100x100/img14.jpg" alt="Image Description">
                                            </div>

                                            <div class="media-body">
                                                <h3 class="g-font-weight-300 g-font-size-16 g-color-black g-mb-5">E<span class="g-hidden-md-down">ddie&nbsp;</span><span class="g-hidden-md-up">.</span>Hayes</h3>
                                                <p class="g-font-weight-300 g-color-gray-dark-v6 g-mb-15">Las Vegas How To Have Non Gambling</p>

                                                <div class="media">
                                                    <div class="media-body align-self-center mr-3" href="#">
                                                        <span class="u-tags-v1 text-center g-width-140--md g-bg-gray-light-v8 g-font-size-12 g-font-size-default--md g-color-darkblue-v2 g-brd-around g-brd-gray-light-v8 g-rounded-50 g-py-4 g-px-15">Sketch
                                                            <span class="g-hidden-sm-down">Project</span>
                                                        </span>
                                                    </div>

                                                    <em class="d-flex align-self-center align-items-center g-font-style-normal">
                                                        <i class="hs-admin-time g-font-size-default g-font-size-18--md g-color-gray-light-v3"></i>
                                                        <span class="g-font-weight-300 g-font-size-12 g-font-size-default--md g-color-gray-dark-v6 g-ml-4 g-ml-8--md">15 Min <span class="g-hidden-md-down">ago</span></span>
                                                    </em>
                                                </div>
                                            </div>
                                        </section>

                                        <hr class="d-flex g-brd-gray-light-v4 g-my-25">

                                        <section class="media">
                                            <div class="d-flex g-mr-12">
                                                <img class="g-width-40 g-width-48--md g-height-40 g-height-48--md rounded-circle" src="../assets/img-temp/100x100/img7.jpg" alt="Image Description">
                                            </div>

                                            <div class="media-body">
                                                <h3 class="g-font-weight-300 g-font-size-16 g-color-black g-mb-5">H<span class="g-hidden-md-down">erbert&nbsp;</span><span class="g-hidden-md-up">.</span>Castro</h3>
                                                <p class="g-font-weight-300 g-color-gray-dark-v6 g-mb-15">But today, the use and influence of is growing right along illustration</p>

                                                <div class="media">
                                                    <div class="media-body align-self-center mr-3" href="#">
                                                        <span class="u-tags-v1 text-center g-width-140--md g-bg-gray-light-v8 g-font-size-12 g-font-size-default--md g-color-darkblue-v2 g-brd-around g-brd-gray-light-v8 g-rounded-50 g-py-4 g-px-15">Unify
                                                            <span class="g-hidden-sm-down">Project</span>
                                                        </span>
                                                    </div>

                                                    <em class="d-flex align-self-center align-items-center g-font-style-normal">
                                                        <i class="hs-admin-time g-font-size-default g-font-size-18--md g-color-gray-light-v3"></i>
                                                        <span class="g-font-weight-300 g-font-size-12 g-font-size-default--md g-color-gray-dark-v6 g-ml-4 g-ml-8--md">10 Min <span class="g-hidden-md-down">ago</span></span>
                                                    </em>
                                                </div>
                                            </div>
                                        </section>

                                        <hr class="d-flex g-brd-gray-light-v4 g-my-25">

                                        <section class="media">
                                            <div class="d-flex g-mr-12">
                                                <img class="g-width-40 g-width-48--md g-height-40 g-height-48--md rounded-circle" src="../assets/img-temp/100x100/img7.jpg" alt="Image Description">
                                            </div>

                                            <div class="media-body">
                                                <h3 class="g-font-weight-300 g-font-size-16 g-color-black g-mb-5">H<span class="g-hidden-md-down">erbert&nbsp;</span><span class="g-hidden-md-up">.</span>Castro</h3>
                                                <p class="g-font-weight-300 g-color-gray-dark-v6 g-mb-15">How Does An Lcd Screen Work</p>

                                                <div class="media">
                                                    <div class="media-body align-self-center mr-3" href="#">
                                                        <span class="u-tags-v1 text-center g-width-140--md g-bg-gray-light-v8 g-font-size-12 g-font-size-default--md g-color-darkblue-v2 g-brd-around g-brd-gray-light-v8 g-rounded-50 g-py-4 g-px-15">Unify
                                                            <span class="g-hidden-sm-down">Project</span>
                                                        </span>
                                                    </div>

                                                    <em class="d-flex align-self-center align-items-center g-font-style-normal">
                                                        <i class="hs-admin-time g-font-size-default g-font-size-18--md g-color-gray-light-v3"></i>
                                                        <span class="g-font-weight-300 g-font-size-12 g-font-size-default--md g-color-gray-dark-v6 g-ml-4 g-ml-8--md">12 Min <span class="g-hidden-md-down">ago</span></span>
                                                    </em>
                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                </div>
                                <!-- Comments Card-->
                            </div>
                            <!-- End Comments Card -->
                        </div>
                    </div>

                    <!-- Footer -->
                    <footer id="footer" class="u-footer--bottom-sticky g-bg-white g-color-gray-dark-v6 g-brd-top g-brd-gray-light-v7 g-pa-20">
                        <div class="row align-items-center">
                            <!-- Footer Nav -->
                            <div class="col-md-4 g-mb-10 g-mb-0--md">
                                <ul class="list-inline text-center text-md-left mb-0">
                                    <li class="list-inline-item">
                                        <a class="g-color-gray-dark-v6 g-color-secondary--hover" href="#">FAQ</a>
                                    </li>
                                    <li class="list-inline-item">
                                        <span class="g-color-gray-dark-v6">|</span>
                                    </li>
                                    <li class="list-inline-item">
                                        <a class="g-color-gray-dark-v6 g-color-secondary--hover" href="#">Support</a>
                                    </li>
                                    <li class="list-inline-item">
                                        <span class="g-color-gray-dark-v6">|</span>
                                    </li>
                                    <li class="list-inline-item">
                                        <a class="g-color-gray-dark-v6 g-color-secondary--hover" href="#">Contact Us</a>
                                    </li>
                                </ul>
                            </div>
                            <!-- End Footer Nav -->

                            <!-- Footer Socials -->
                            <div class="col-md-4 g-mb-10 g-mb-0--md">
                                <ul class="list-inline g-font-size-16 text-center mb-0">
                                    <li class="list-inline-item g-mx-10">
                                        <a href="#" class="g-color-facebook g-color-secondary--hover">
                                            <i class="fa fa-facebook-square"></i>
                                        </a>
                                    </li>
                                    <li class="list-inline-item g-mx-10">
                                        <a href="#" class="g-color-google-plus g-color-secondary--hover">
                                            <i class="fa fa-google-plus"></i>
                                        </a>
                                    </li>
                                    <li class="list-inline-item g-mx-10">
                                        <a href="#" class="g-color-black g-color-secondary--hover">
                                            <i class="fa fa-github"></i>
                                        </a>
                                    </li>
                                    <li class="list-inline-item g-mx-10">
                                        <a href="#" class="g-color-twitter g-color-secondary--hover">
                                            <i class="fa fa-twitter"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <!-- End Footer Socials -->

                            <!-- Footer Copyrights -->
                            <div class="col-md-4 text-center text-md-right">
                                <small class="d-block g-font-size-default">&copy; 2020 Htmlstream. All Rights Reserved.</small>
                            </div>
                            <!-- End Footer Copyrights -->
                        </div>
                    </footer>
                    <!-- End Footer -->
                </div>
            </div>
        </main>

    <?php $this->endBody() ?>
        
        
    <!-- JS Plugins Init. -->
    <script>
      $(document).on('ready', function () {
        // initialization of custom select
        $('.js-select').selectpicker();

        // initialization of hamburger
        $.HSCore.helpers.HSHamburgers.init('.hamburger');

        // initialization of charts
        $.HSCore.components.HSAreaChart.init('.js-area-chart');
        $.HSCore.components.HSDonutChart.init('.js-donut-chart');
        $.HSCore.components.HSBarChart.init('.js-bar-chart');

        // initialization of sidebar navigation component
        $.HSCore.components.HSSideNav.init('.js-side-nav', {
          afterOpen: function() {
            setTimeout(function() {
              $.HSCore.components.HSAreaChart.init('.js-area-chart');
              $.HSCore.components.HSDonutChart.init('.js-donut-chart');
              $.HSCore.components.HSBarChart.init('.js-bar-chart');
            }, 400);
          },
          afterClose: function() {
            setTimeout(function() {
              $.HSCore.components.HSAreaChart.init('.js-area-chart');
              $.HSCore.components.HSDonutChart.init('.js-donut-chart');
              $.HSCore.components.HSBarChart.init('.js-bar-chart');
            }, 400);
          }
        });

        // initialization of range datepicker
        $.HSCore.components.HSRangeDatepicker.init('#rangeDatepicker, #rangeDatepicker2, #rangeDatepicker3');

        // initialization of datepicker
        $.HSCore.components.HSDatepicker.init('#datepicker', {
          dayNamesMin: [
            'SU',
            'MO',
            'TU',
            'WE',
            'TH',
            'FR',
            'SA'
          ]
        });

        // initialization of HSDropdown component
        $.HSCore.components.HSDropdown.init($('[data-dropdown-target]'), {dropdownHideOnScroll: false});

        // initialization of custom scrollbar
        $.HSCore.components.HSScrollBar.init($('.js-custom-scroll'));

        // initialization of popups
        $.HSCore.components.HSPopup.init('.js-fancybox', {
          btnTpl: {
            smallBtn: '<button data-fancybox-close class="btn g-pos-abs g-top-25 g-right-30 g-line-height-1 g-bg-transparent g-font-size-16 g-color-gray-light-v3 g-brd-none p-0" title=""><i class="hs-admin-close"></i></button>'
          }
        });
      });
    </script>
    </body>
</html>
<?php
$this->endPage();
