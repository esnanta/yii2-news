<?php
/**
 * @var common\models\Office $office
 * @var common\models\OfficeMedia $officeMedias
 * @var String $logo1Image
 * @var String $logo2Image
 */

use common\helper\IconHelper;
use yii\helpers\Html;

?>

<!-- Top Bar Start -->
<div class="top-bar">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="tb-contact">
                    <p><i class="fas fa-envelope"></i><?= $office->email; ?></p>
                    <p><i class="fas fa-phone-alt"></i><?= $office->phone_number; ?></p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="tb-menu">
                <?php
                if (Yii::$app->user->getIsGuest()) {
                    echo Yii::$app->user->identity;
                    echo '<li>';
                    echo str_replace('user/user/', '', Html::a(IconHelper::getUser(), ['admin/user/login'], ['class' => 'd-block g-color-secondary-dark-v1 g-color-primary--hover g-text-underline--none--hover g-py-5 g-px-20']));
                    echo '</li>';
                } else {

                    if (Yii::$app->user->identity->isAdmin == true) {
                        echo '<li>';
                        echo Html::a('Admin', ['/backend/web/site/index'], ['class' => 'd-block g-color-secondary-dark-v1 g-color-primary--hover g-text-underline--none--hover g-py-5 g-px-20']);
                        echo '</li>';
                    }

                    echo '<li>';
                    echo Html::a('Sign Out ', ['user/security/logout'], ['data-method' => 'POST', 'class' => 'd-block g-color-secondary-dark-v1 g-color-primary--hover g-text-underline--none--hover g-py-5 g-px-20']);
                    echo '</li>';
                }
                ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Top Bar Start -->

<!-- Brand Start -->
<div class="brand">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-4">
                <div class="b-logo">
                    <?= str_replace('user/', '', Html::a($logo1Image, ['site/index'])); ?>
                </div>
            </div>
            <div class="col-lg-6 col-md-4">
                <div class="b-ads">
                    <?= str_replace('user/', '', Html::a($logo2Image, ['site/index'])); ?>
                </div>
            </div>
            <div class="col-lg-3 col-md-4">
                <div class="b-search">
                    <div class="gcse-search" style="padding:0"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Brand End -->

<!-- Nav Bar Start -->
<div class="nav-bar">
    <div class="container">
        <nav class="navbar navbar-expand-md bg-dark navbar-dark">
            <a href="#" class="navbar-brand">MENU</a>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                <div class="navbar-nav mr-auto">

                    <?= str_replace('user/', '', Html::a(Yii::t('app', 'Home'), ['site/index'], ['id' => 'nav-link--pages', 'class' => 'nav-item nav-link'])) ?>
                    <?= str_replace('user/', '', Html::a(Yii::t('app', 'Article'), ['article/index'], ['id' => 'nav-link--pages', 'class' => 'nav-item nav-link'])) ?>
                    <?= str_replace('user/', '', Html::a(Yii::t('app', 'Download'), ['asset/index'], ['id' => 'nav-link--pages', 'class' => 'nav-item nav-link'])) ?>

                    <?php if(!empty($categories)) : ?>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                            <?=Yii::t('app', 'Category');?>
                        </a>
                        <div class="dropdown-menu">
                            <?php foreach ($categories as $categoryModel) { ?>
                                <?php
                                echo Html::a($categoryModel->title,
                                    ['/article/index', 'cat' => $categoryModel->id, 'title' => $categoryModel->title],
                                    ['class' => 'dropdown-item']);
                                ?>
                            <?php } ?>
                        </div>
                    </div>
                    <?php endif; ?>

                </div>
                <div class="social ml-auto">
                    <?php foreach ($officeMedias as $officeMediaItem) {  ?>
                        <a href="<?= $officeMediaItem->description; ?>">
                            <i class="<?= $officeMediaItem->title; ?>"></i>
                        </a>
                    <?php }; ?>
                </div>
            </div>
        </nav>
    </div>
</div>
<!-- Nav Bar End -->