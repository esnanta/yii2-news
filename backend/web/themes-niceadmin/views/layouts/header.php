<?php

use common\helper\ImageHelper;
use common\service\CacheService;
use common\models\Staff;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\helpers\Url;

$homeUrl = str_replace('admin/','',Url::to(['/site/index']));
$flushMenuEnabled       = false;
$activityMenuEnabled    = false;
$assetUrl               = ImageHelper::getNotAvailable();
$staffTitle             = 'Guest';

if (!Yii::$app->user->isGuest) {

    $officeId       = CacheService::getInstance()->getOfficeId();
    $staffId        = CacheService::getInstance()->getStaffId();
    $staff          = Staff::find()->where(['id'=>$staffId])->one();
    $authItemName   = CacheService::getInstance()->getAuthItemName();
    $assetUrl       = $staff->assetUrl;
    $staffTitle     = $staff->title;


    $flushMenuEnabled = ($authItemName == Yii::$app->params['userRoleAdmin']) ? true:false;
    
    if($authItemName == Yii::$app->params['userRoleAdmin'] ||
        $authItemName == Yii::$app->params['userRoleOwner']){
        $activityMenuEnabled = true;
    }
}

$signOut = '<i class="bi bi-box-arrow-right"></i><span>Sign Out</span>';
?>

<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="<?= $homeUrl ?>" class="logo d-flex align-items-center">
            <span class="d-none d-lg-block">NiceAdmin</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="search-bar" style="padding-top:15px">
        <div class="pagetitle">
            <?=
            Breadcrumbs::widget([
                'links' => $this->params['breadcrumbs'] ?? [],
            ])
            ?>
        </div>
    </div><!-- End Search Bar -->

    <nav class="header-nav ms-auto">

        <ul class="d-flex align-items-center">

            <li>
                <?= ($flushMenuEnabled==true) ?
                    Html::a(
                        '<i class="fas fa-recycle fa-fw"></i>',
                        ['/site/flush'],
                        [
                            'data-method' => 'post',
                            'data-confirm' => 'Flush now?',
                            'class' => 'nav-link',
                            'role' => 'button',
                            'title'=>'Flush'
                        ]
                    )
                    :'';
                ?>
            </li>
            <li class="nav-item dropdown pe-3">

                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <img src="<?= $assetUrl ;?>" alt="Profile" class="rounded-circle">
                    <span class="d-none d-md-block dropdown-toggle ps-2"><?= $staffTitle;?></span>
                </a><!-- End Profile Iamge Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <?php if (!Yii::$app->user->getIsGuest()) { ?>

                        <li class="dropdown-header">
                            <h6><?= $staff->title;?></h6>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="<?= Url::to(['/staff/view','id'=>$staff->id])?>">
                                <i class="bi bi-person"></i>
                                <span>My Profile</span>
                            </a>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <?= Html::a(
                                $signOut,
                                ['/user/logout'],
                                ['data-method' => 'post',
                                    'data-confirm' => 'Logout now?',
                                    'class' => 'dropdown-item d-flex align-items-center',
                                    'title'=>'Sign Out']
                            ) ?>

                        </li>
                    <?php } else { ?>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="<?= Url::to(['/user/login'])?>">
                                <i class="bi bi-person"></i>
                                <span>Sign in</span>
                            </a>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>
                    <?php } ?>
                </ul><!-- End Profile Dropdown Items -->
            </li><!-- End Profile Nav -->
        </ul>
    </nav><!-- End Icons Navigation -->

</header><!-- End Header -->