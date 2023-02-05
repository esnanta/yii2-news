<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

use common\widgets\Alert;
use backend\models\Office;
use backend\models\Blog;
use backend\models\Lookup;
use backend\models\ThemeDetail;
use frontend\assets\LawyerAsset;

$footerLinks    = ThemeDetail::getByToken(Yii::$app->params['ContentToken_Links']);
$description    = ThemeDetail::getByToken(Yii::$app->params['ContentToken_Description']);
$keyword        = ThemeDetail::getByToken(Yii::$app->params['ContentToken_Keyword']);

$logo1          = ThemeDetail::getByToken(Yii::$app->params['ContentToken_Logo1']);
$logo1Url       = str_replace('frontend', 'backend', $logo1->getImageUrl());
$logo1Image     = Html::img($logo1Url, ['style'=>'width:105px;height:40px'],['alt' => 'alt image']);

$office         = Office::findOne(1);
$blogLatests    = Blog::find()->limit(3)
                    ->where([
                        'publish_status' => Lookup::getId(Yii::$app->params['LookupToken_Publish'])
                    ])
                    ->orderBy(['created_at'=>SORT_DESC])
                    ->all();


LawyerAsset::register($this);

?>

<?php $this->beginPage() ?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <meta name="description" content="<?=$description->content?>">
    <meta name="keywords" content="<?=$keyword->content?>">
    <meta name="author" content="nanta es | www.escyber.com" />

    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body>
    <?php $this->beginBody() ?>
    <main class="g-pt-65 g-pt-90--md">
        <!-- Header -->
        <header id="js-header" class="u-header u-header--sticky-top u-header--change-appearance g-z-index-9999"
                data-header-fix-moment="100">
            <div class="u-header__section g-bg-white g-transition-0_3 g-py-6 g-py-18--md"
                 data-header-fix-moment-exclude="g-py-18--md"
                 data-header-fix-moment-classes="u-shadow-v18 g-py-13--md">
                <nav class="navbar navbar-expand-lg g-py-0">
                    <div class="container g-pos-rel">
                        <!-- Logo -->
                        <a href="#" class="js-go-to navbar-brand u-header__logo"
                           data-type="static">
                            <?= str_replace('user/', '', Html::a($logo1Image, ['site/index'], 
                                    ['class' => 'u-header__logo-img u-header__logo-img--main g-width-110', 'alt'=>'Logo'],
                                    ['style' => 'height:40px;width:105px'])); ?>
                            
                        </a>
                        <!-- End Logo -->

                        <!-- Navigation -->
                        <div class="collapse navbar-collapse align-items-center flex-sm-row" id="navBar" data-mobile-scroll-hide="true">
                            <ul id="js-scroll-nav" class="navbar-nav text-uppercase g-font-weight-700 g-font-size-11 g-pt-20 g-pt-5--lg ml-auto">
                                <li class="nav-item g-mr-15--lg g-mb-7 g-mb-0--lg">
                                    <a href="#puja" class="nav-link p-0">Puja Tv</a>
                                </li>
                                <li class="nav-item g-mx-15--lg g-mb-7 g-mb-0--lg">
                                    <a href="#team" class="nav-link p-0">Team</a>
                                </li>
                                <li class="nav-item g-ml-15--lg">
                                    <a href="#about" class="nav-link p-0">About</a>
                                </li>                                
                                <li class="nav-item g-ml-15--lg">
                                    <?=
                                        Html::a('Dashboard', ['/backend/web/site/index'], ['class' => 'nav-link p-0']) 
                                    ?>
                                </li>
                            </ul>
                        </div>
                        <!-- End Navigation -->

                        <!-- Responsive Toggle Button -->
                        <button class="navbar-toggler btn g-line-height-1 g-brd-none g-pa-0 g-pos-abs g-top-20 g-right-0" type="button"
                                aria-label="Toggle navigation"
                                aria-expanded="false"
                                aria-controls="navBar"
                                data-toggle="collapse"
                                data-target="#navBar">
                            <span class="hamburger hamburger--slider">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                            </span>
                        </button>
                        <!-- End Responsive Toggle Button -->
                    </div>
                </nav>
            </div>
        </header>
        <!-- End Header -->        
    </main>
    


    <div class="">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>


    <section id="about" class="container-fluid g-color-white">
        
    
    <!-- Footer -->
    <footer>
        <div class="g-color-gray-dark-v3 g-py-60">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-lg-4 g-mb-30 g-mb-0--lg">
                        <h2 class="text-uppercase g-font-weight-800 g-font-size-default g-mb-20">
                            Tentang Kami
                        </h2>
                        <p class="g-font-size-default g-mb-20">
                            <?php echo $office->description;?>
                        </p>
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item g-mr-10">
                                <a class="u-icon-v3 g-width-35 g-height-35 g-font-size-default g-color-white g-theme-bg-gray-dark-v1 g-bg-primary--hover g-transition-0_2 g-transition--ease-in" href="#"><i class="fa fa-twitter"></i></a>
                            </li>
                            <li class="list-inline-item g-mr-10">
                                <a class="u-icon-v3 g-width-35 g-height-35 g-font-size-default g-color-white g-theme-bg-gray-dark-v1 g-bg-primary--hover g-transition-0_2 g-transition--ease-in" href="#"><i class="fa fa-pinterest"></i></a>
                            </li>
                            <li class="list-inline-item g-mr-10">
                                <a class="u-icon-v3 g-width-35 g-height-35 g-font-size-default g-color-white g-theme-bg-gray-dark-v1 g-bg-primary--hover g-transition-0_2 g-transition--ease-in" href="#"><i class="fa fa-facebook"></i></a>
                            </li>
                            <li class="list-inline-item">
                                <a class="u-icon-v3 g-width-35 g-height-35 g-font-size-default g-color-white g-theme-bg-gray-dark-v1 g-bg-primary--hover g-transition-0_2 g-transition--ease-in" href="#"><i class="fa fa-linkedin"></i></a>
                            </li>
                        </ul>
                    </div>

                    <div class="col-md-6 col-lg-4 g-mb-30 g-mb-0--lg">
                        <h2 class="text-uppercase g-font-weight-800 g-font-size-default g-mb-20">Alamat</h2>

                        <address class="g-bg-no-repeat g-font-size-12 mb-0"
                            style="background-image: url(<?php //echo Yii::$app->urlManager->baseUrl .'/themes/lawyer/img/maps/map2.png'?>)">
                            <!-- Location -->
                            <div class="d-flex g-mb-10">
                                <div class="g-mr-10">
                                    <span class="u-icon-v3 u-icon-size--xs">
                                        <i class="fa fa-map-marker"></i>
                                    </span>
                                </div>
                                <p class="g-font-size-default g-mb-20"><?php echo $office->address;?></p>
                            </div>
                            <!-- End Location -->

                            <!-- Phone -->
                            <div class="d-flex g-mb-10">
                                <div class="g-mr-10">
                                    <span class="u-icon-v3 u-icon-size--xs">
                                        <i class="fa fa-phone"></i>
                                    </span>
                                </div>
                                <p class="g-font-size-default g-mb-20"><?php echo $office->phone_number;?> </p>
                            </div>
                            <!-- End Phone -->

                            <!-- Email and Website -->
                            <div class="d-flex g-mb-10">
                                <div class="g-mr-10">
                                    <span class="u-icon-v3 u-icon-size--xs">
                                        <i class="fa fa-globe"></i>
                                    </span>
                                </div>
                                <p class="g-font-size-default g-mb-20">
                                    <a class="g-color-white-opacity-0_8 g-color-white--hover"
                                        href="mailto:info@htmlstream.com"><?php echo $office->email;?></a>
                                    
                                    <a href="#"><?php echo $office->web;?></a>
                                </p>
                            </div>
                            <!-- End Email and Website -->
                        </address>                        
                    </div>

                    <div class="col-md-12 col-lg-4">
                        <h2 class="text-uppercase g-font-weight-800 g-font-size-default g-mb-20">
                            Email Us
                        </h2>

                        <form>
                            <div class="form-group g-mb-20">
                                <input id="inputGroup1_1" class="form-control h-100 g-font-size-default g-color-gray-light-v4 g-theme-bg-gray-dark-v1 g-brd-none g-rounded-1 g-px-10 g-py-15" type="text" placeholder="Your name">
                            </div>

                            <div class="form-group g-mb-20">
                                <input id="inputGroup1_2" class="form-control h-100 g-font-size-default g-color-gray-light-v4 g-theme-bg-gray-dark-v1 g-brd-none g-rounded-1 g-px-10 g-py-15" type="email" placeholder="Your email">
                            </div>

                            <button class="btn btn-md text-uppercase u-btn-primary g-font-weight-700 g-font-size-12 g-font-secondary g-brd-none rounded-0 g-py-10 g-px-25" type="submit" role="button">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- End Footer -->    
    </section>

    <!-- Copyright Footer -->
    <footer class="g-bg-gray-dark-v1 g-color-white-opacity-0_8 g-py-20">
        <div class="container">
            <div class="row">
                <div class="col-md-8 text-center text-md-left g-mb-10 g-mb-0--md">
                    <div class="d-lg-flex">
                        <small class="d-block g-font-size-default g-mr-10 g-mb-10 g-mb-0--md"><?= date('Y') ?> ©
                            <?php echo Yii::$app->params['Copyright']; ?>.</small>
                        <ul class="u-list-inline">
                            <li class="list-inline-item">
                                <a class="g-color-white-opacity-0_8 g-color-white--hover" href="#">Privacy Policy</a>
                            </li>
                            <li class="list-inline-item">
                                <span>|</span>
                            </li>
                            <li class="list-inline-item">
                                <?= Html::a('Terms of Use', ['site/terms'], ['class' => 'g-color-white-opacity-0_8 g-color-white--hover']) ?>
                            </li>
                            <li class="list-inline-item">
                                <span>|</span>
                            </li>
                            <li class="list-inline-item">
                                <a class="g-color-white-opacity-0_8 g-color-white--hover" href="#">License</a>
                            </li>
                            <li class="list-inline-item">
                                <span>|</span>
                            </li>
                            <li class="list-inline-item">
                                <a class="g-color-white-opacity-0_8 g-color-white--hover" href="#">Support</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-4 align-self-center">
                    <ul class="list-inline text-center text-md-right mb-0">
                        <li class="list-inline-item g-mx-10" data-toggle="tooltip" data-placement="top"
                            title="Facebook">
                            <a href="#" class="g-color-white-opacity-0_5 g-color-white--hover">
                                <i class="fa fa-facebook"></i>
                            </a>
                        </li>
                        <li class="list-inline-item g-mx-10" data-toggle="tooltip" data-placement="top" title="Skype">
                            <a href="#" class="g-color-white-opacity-0_5 g-color-white--hover">
                                <i class="fa fa-skype"></i>
                            </a>
                        </li>
                        <li class="list-inline-item g-mx-10" data-toggle="tooltip" data-placement="top"
                            title="Linkedin">
                            <a href="#" class="g-color-white-opacity-0_5 g-color-white--hover">
                                <i class="fa fa-linkedin"></i>
                            </a>
                        </li>
                        <li class="list-inline-item g-mx-10" data-toggle="tooltip" data-placement="top"
                            title="Pinterest">
                            <a href="#" class="g-color-white-opacity-0_5 g-color-white--hover">
                                <i class="fa fa-pinterest"></i>
                            </a>
                        </li>
                        <li class="list-inline-item g-mx-10" data-toggle="tooltip" data-placement="top" title="Twitter">
                            <a href="#" class="g-color-white-opacity-0_5 g-color-white--hover">
                                <i class="fa fa-twitter"></i>
                            </a>
                        </li>
                        <li class="list-inline-item g-mx-10" data-toggle="tooltip" data-placement="top"
                            title="Dribbble">
                            <a href="#" class="g-color-white-opacity-0_5 g-color-white--hover">
                                <i class="fa fa-dribbble"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <!-- End Copyright Footer -->

    <a class="js-go-to u-go-to-v1" href="#" data-type="fixed" data-position='{
       "bottom": 15,
       "right": 15
       }' data-offset-top="400" data-compensation="#js-header" data-show-effect="zoomIn">
        <i class="hs-icon hs-icon-arrow-top"></i>
    </a>

    <div class="u-outer-spaces-helper"></div>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>

