<?php
/**
 * @var Office      $office
 * @var OfficeMedia $officeMedias
 * @var string      $logo1Image
 * @var string      $logo2Image
 */

use common\models\Office;
use common\models\OfficeMedia;
use rmrevin\yii\fontawesome\FAS;
use yii\helpers\Html;

$backendBaseUrl = rtrim(Yii::getAlias('@backendUrl'), '/');
$backendLoginUrl = $backendBaseUrl.'/user/sign-in/login';
$backendDashboardUrl = $backendBaseUrl.'/site/index';

?>

<!-- Top Bar Start -->
<div class="top-bar">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="tb-contact">
                    <p><i class="fas fa-envelope"></i><?php echo $office->email; ?></p>
                    <p><i class="fas fa-phone-alt"></i><?php echo $office->phone_number; ?></p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="tb-menu">
                <?php
                if (Yii::$app->user->getIsGuest()) {
                    echo Yii::$app->user->identity;
                    echo '<li>';
                    echo str_replace('user/user/', '', Html::a(FAS::icon('user'), $backendLoginUrl, ['class' => 'd-block g-color-secondary-dark-v1 g-color-primary--hover g-text-underline--none--hover g-py-5 g-px-20']));
                    echo '</li>';
                } else {
                    $signOut = Html::a(FAS::icon('sign-out-alt').' Sign Out', ['user/security/logout'], ['data-method' => 'POST', 'class' => 'g-color-secondary-dark-v1 g-color-primary--hover g-text-underline--none--hover g-py-5 g-px-20']);
                    if (true == Yii::$app->user->identity->isAdmin) {
                        echo '<li>';
                        $admin = Html::a(FAS::icon('user').' Admin', $backendDashboardUrl, ['class' => 'g-color-secondary-dark-v1 g-color-primary--hover g-text-underline--none--hover g-py-5 g-px-20']);
                        echo $admin.' | '.$signOut;
                        echo '</li>';
                    } else {
                        echo '<li>';
                        echo $signOut;
                        echo '</li>';
                    }
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
                    <?php echo str_replace('user/', '', Html::a($logo1Image, ['site/index'])); ?>
                </div>
            </div>
            <div class="col-lg-6 col-md-4">
                <div class="b-ads">
                    <?php echo str_replace('user/', '', Html::a($logo2Image, ['site/index'])); ?>
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

                    <?php echo str_replace('user/', '', Html::a(Yii::t('app', 'Home'), ['site/index'], ['id' => 'nav-link--pages', 'class' => 'nav-item nav-link'])); ?>
                    <?php echo str_replace('user/', '', Html::a(Yii::t('app', 'Article'), ['article/index'], ['id' => 'nav-link--pages', 'class' => 'nav-item nav-link'])); ?>
                    <?php echo str_replace('user/', '', Html::a(Yii::t('app', 'Download'), ['document/index'], ['id' => 'nav-link--pages', 'class' => 'nav-item nav-link'])); ?>
                    <?php echo str_replace('user/', '', Html::a(Yii::t('app', 'Staff'), ['staff/index'], ['id' => 'nav-link--pages', 'class' => 'nav-item nav-link'])); ?>
                    <?php echo str_replace('user/', '', Html::a(Yii::t('app', 'About'), ['page/view', 'slug'=>'about'], ['id' => 'nav-link--pages', 'class' => 'nav-item nav-link'])); ?>


                    <?php if (!empty($categories)) { ?>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                            <?php echo Yii::t('app', 'Category'); ?>
                        </a>
                        <div class="dropdown-menu">
                            <?php foreach ($categories as $categoryModel) { ?>
                                <?php echo Html::a(
                                    $categoryModel->title,
                                    ['/article/index', 'cat' => $categoryModel->id, 'title' => $categoryModel->title],
                                    ['class' => 'dropdown-item']
                                );
                                ?>
                            <?php } ?>
                        </div>
                    </div>
                    <?php } ?>

                </div>
                <div class="social ml-auto">
                    <?php foreach ($officeMedias as $officeMediaItem) {  ?>
                        <a href="<?php echo $officeMediaItem->description; ?>">
                            <i class="<?php echo $officeMediaItem->title; ?>"></i>
                        </a>
                    <?php } ?>
                </div>
            </div>
        </nav>
    </div>
</div>
<!-- Nav Bar End -->