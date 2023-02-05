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
use frontend\assets\Portfolio7Asset;

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


Portfolio7Asset::register($this);

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
    
    <!-- Header -->
    <header id="js-header" class="u-header u-header--static">
        <div class="u-header__section u-header__section--light g-bg-white g-transition-0_3 g-py-10">
            <nav class="js-mega-menu navbar navbar-expand-lg">
                <div class="container">
                    <!-- Responsive Toggle Button -->
                    <button
                        class="navbar-toggler navbar-toggler-right btn g-line-height-1 g-brd-none g-pa-0 g-pos-abs g-top-3 g-right-0"
                        type="button" aria-label="Toggle navigation" aria-expanded="false" aria-controls="navBar"
                        data-toggle="collapse" data-target="#navBar">
                        <span class="hamburger hamburger--slider">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </span>
                    </button>
                    <!-- End Responsive Toggle Button -->

                    <!-- Logo -->
                    <?= str_replace('user/', '', Html::a($logo1Image, ['site/index'], ['class' => 'navbar-brand', 'alt'=>'Logo'])); ?>
                    <!-- End Logo -->

                    <!-- Navigation -->
                    <div class="collapse navbar-collapse align-items-center flex-sm-row g-pt-10 g-pt-5--lg g-mr-40--lg"
                        id="navBar">
                        <ul class="navbar-nav text-uppercase g-pos-rel g-font-weight-600 ml-auto">

                            <li class="nav-item  g-mx-10--lg g-mx-15--xl">
                                <?= Html::a('Home', ['site/index'], ['class' => 'nav-link g-py-7 g-px-0']) ?>
                            </li>
                            <!--<li class="nav-item  g-mx-10--lg g-mx-15--xl">-->
                                <?php //Html::a('Blog', ['blog/index'], ['class' => 'nav-link g-py-7 g-px-0']) ?>
                            <!--</li>-->
                            <li class="nav-item  g-mx-10--lg g-mx-15--xl">
                                <?php
                                    echo Html::a('Dashboard', ['/backend/web/site/index'], ['class' => 'nav-link g-py-7 g-px-0']) 
                                ?>
                            </li>
                        </ul>
                    </div>
                    <!-- End Navigation -->

                </div>
            </nav>
        </div>
    </header>
    <!-- End Header -->

    <div class="">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>


    <!-- Footer -->
    <div id="contacts-section" class="g-bg-black-opacity-0_9 g-color-white-opacity-0_8 g-py-60">
        <div class="container">
            <div class="row">
                <!-- Footer Content -->
                <div class="col-lg-3 col-md-6 g-mb-40 g-mb-0--lg">
                    <div class="u-heading-v2-3--bottom g-brd-white-opacity-0_8 g-mb-20">
                        <h2 class="u-heading-v2__title h6 text-uppercase mb-0">About Us</h2>
                    </div>

                    <p><?php echo $office->description;?></p>
                </div>
                <!-- End Footer Content -->

                <!-- Footer Content -->
                <div class="col-lg-3 col-md-6 g-mb-40 g-mb-0--lg">
                    <div class="u-heading-v2-3--bottom g-brd-white-opacity-0_8 g-mb-20">
                        <h2 class="u-heading-v2__title h6 text-uppercase mb-0">Latest Posts</h2>
                    </div>

                    <?php //foreach ($blogLatests as $footerBlogItemData) { ?>
                        <article>
                            <h3 class="h6 g-mb-2">
                                <?php // Html::a($footerBlogItemData->title, $footerBlogItemData->getUrl(), ['class' => 'g-color-white-opacity-0_8 g-color-white--hover']) ?>
                            </h3>
                            <div class="small g-color-white-opacity-0_6">
                                <?php // Yii::$app->formatter->format($footerBlogItemData->created_at, 'date');?>                            
                            </div>
                        </article>                    
                        <hr class="g-brd-white-opacity-0_1 g-my-10">
                    <?php //} ?>                                                                

                </div>
                <!-- End Footer Content -->

                <!-- Footer Content -->
                <div class="col-lg-3 col-md-6 g-mb-40 g-mb-0--lg">
                    <div class="u-heading-v2-3--bottom g-brd-white-opacity-0_8 g-mb-20">
                        <h2 class="u-heading-v2__title h6 text-uppercase mb-0">Useful Links</h2>
                    </div>

                    <nav class="text-uppercase1">
                        <ul class="list-unstyled g-mt-minus-10 mb-0">
                            <li class="g-pos-rel g-brd-bottom g-brd-white-opacity-0_1 g-py-10">
                                <h4 class="h6 g-pr-20 mb-0">
                                    <?= Html::a('About Us', ['site/about'], ['class' => 'g-color-white-opacity-0_8 g-color-white--hover']) ?>
                                    <i class="fa fa-angle-right g-absolute-centered--y g-right-0"></i>
                                </h4>
                            </li>
                            <li class="g-pos-rel g-brd-bottom g-brd-white-opacity-0_1 g-py-10">
                                <h4 class="h6 g-pr-20 mb-0">
                                    <a class="g-color-white-opacity-0_8 g-color-white--hover" href="#">Portfolio</a>
                                    <i class="fa fa-angle-right g-absolute-centered--y g-right-0"></i>
                                </h4>
                            </li>
                            <li class="g-pos-rel g-brd-bottom g-brd-white-opacity-0_1 g-py-10">
                                <h4 class="h6 g-pr-20 mb-0">
                                    <a class="g-color-white-opacity-0_8 g-color-white--hover" href="#">Our Services</a>
                                    <i class="fa fa-angle-right g-absolute-centered--y g-right-0"></i>
                                </h4>
                            </li>
                            <li class="g-pos-rel g-py-10">
                                <h4 class="h6 g-pr-20 mb-0">
                                    <a class="g-color-white-opacity-0_8 g-color-white--hover" href="#">Contact Us</a>
                                    <i class="fa fa-angle-right g-absolute-centered--y g-right-0"></i>
                                </h4>
                            </li>
                        </ul>
                    </nav>
                </div>
                <!-- End Footer Content -->

                <!-- Footer Content -->
                <div class="col-lg-3 col-md-6">
                    <div class="u-heading-v2-3--bottom g-brd-white-opacity-0_8 g-mb-20">
                        <h2 class="u-heading-v2__title h6 text-uppercase mb-0">Our Contacts</h2>
                    </div>

                    <address class="g-bg-no-repeat g-font-size-12 mb-0"
                        style="background-image: url(<?php echo Yii::$app->urlManager->baseUrl .'/themes/home14/img/maps/map2.png'?>)">
                        <!-- Location -->
                        <div class="d-flex g-mb-20">
                            <div class="g-mr-10">
                                <span
                                    class="u-icon-v3 u-icon-size--xs g-bg-white-opacity-0_1 g-color-white-opacity-0_6">
                                    <i class="fa fa-map-marker"></i>
                                </span>
                            </div>
                            <p class="mb-0"><?php echo $office->address;?></p>
                        </div>
                        <!-- End Location -->

                        <!-- Phone -->
                        <div class="d-flex g-mb-20">
                            <div class="g-mr-10">
                                <span
                                    class="u-icon-v3 u-icon-size--xs g-bg-white-opacity-0_1 g-color-white-opacity-0_6">
                                    <i class="fa fa-phone"></i>
                                </span>
                            </div>
                            <p class="mb-0"><?php echo $office->phone_number;?> <br>
                                <?php echo 'Fax '.$office->fax_number;?></p>
                        </div>
                        <!-- End Phone -->

                        <!-- Email and Website -->
                        <div class="d-flex g-mb-20">
                            <div class="g-mr-10">
                                <span
                                    class="u-icon-v3 u-icon-size--xs g-bg-white-opacity-0_1 g-color-white-opacity-0_6">
                                    <i class="fa fa-globe"></i>
                                </span>
                            </div>
                            <p class="mb-0">
                                <a class="g-color-white-opacity-0_8 g-color-white--hover"
                                    href="mailto:info@htmlstream.com"><?php echo $office->email;?></a>
                                <br>
                                <a class="g-color-white-opacity-0_8 g-color-white--hover"
                                    href="#"><?php echo $office->web;?></a>
                            </p>
                        </div>
                        <!-- End Email and Website -->
                    </address>
                </div>
                <!-- End Footer Content -->
            </div>
        </div>
    </div>
    <!-- End Footer -->

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

