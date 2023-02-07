<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use frontend\assets\Unify263BlogAsset;

use common\widgets\Alert;

use backend\models\Office;
use backend\models\Blog;
use backend\models\ThemeDetail;
use backend\models\Category;
use backend\models\SiteLink;

use kartik\social\TwitterPlugin;
use kartik\social\FacebookPlugin;

$this->registerMetaTag(Yii::$app->params['meta_author'], 'meta_author');
$this->registerMetaTag(Yii::$app->params['meta_description'], 'meta_description');
$this->registerMetaTag(Yii::$app->params['meta_keywords'], 'meta_keywords');

$this->registerMetaTag(Yii::$app->params['og_site_name'], 'og_site_name');
$this->registerMetaTag(Yii::$app->params['og_title'], 'og_title');
$this->registerMetaTag(Yii::$app->params['og_description'], 'og_description');
$this->registerMetaTag(Yii::$app->params['og_type'], 'og_type');
$this->registerMetaTag(Yii::$app->params['og_url'], 'og_url');
$this->registerMetaTag(Yii::$app->params['og_image'], 'og_image');
$this->registerMetaTag(Yii::$app->params['og_width'], 'og_width');
$this->registerMetaTag(Yii::$app->params['og_height'], 'og_height');
$this->registerMetaTag(Yii::$app->params['og_updated_time'], 'og_updated_time');

$this->registerMetaTag(Yii::$app->params['twitter_title'], 'twitter_title');
$this->registerMetaTag(Yii::$app->params['twitter_description'], 'twitter_description');
$this->registerMetaTag(Yii::$app->params['twitter_card'], 'twitter_card');
$this->registerMetaTag(Yii::$app->params['twitter_url'], 'twitter_url');
$this->registerMetaTag(Yii::$app->params['twitter_image'], 'twitter_image');

$this->registerMetaTag(Yii::$app->params['googleplus_name'], 'googleplus_name');
$this->registerMetaTag(Yii::$app->params['googleplus_description'], 'googleplus_description');
$this->registerMetaTag(Yii::$app->params['googleplus_image'], 'googleplus_image');

$office = Office::findOne(1);
$siteLinks = SiteLink::find()->limit(8)->orderBy(['sequence' => SORT_ASC])->all();
$categories = Category::find()->orderBy(['sequence' => SORT_ASC])->all();
$timeLine = Category::find()->where(['time_line' => Category::TIME_LINE_YES])->orderBy(['sequence' => SORT_ASC])->one();

$footerLinks = ThemeDetail::getByToken(Yii::$app->params['ContentToken_Links']);
$description = ThemeDetail::getByToken(Yii::$app->params['ContentToken_Description']);
$keyword = ThemeDetail::getByToken(Yii::$app->params['ContentToken_Keyword']);

$logo1 = ThemeDetail::getByToken(Yii::$app->params['ContentToken_Logo1']);
$logo1Url = str_replace('frontend', 'backend', $logo1->getImageUrl());
$logo1Image = Html::img($logo1Url, ['style' => 'width:200px;height:40px'], ['alt' => 'Logo']);

$logo2 = ThemeDetail::getByToken(Yii::$app->params['ContentToken_Logo2']);
$logo2Url = str_replace('frontend', 'backend', $logo2->getImageUrl());
$logo2Image = Html::img($logo2Url, ['style' => 'width:200px;height:40px'], ['alt' => 'Logo']);

Unify263BlogAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

    <head>
        <meta http-equiv="Content-Type" content="text/html">
        <meta name="robots" content="follow" />
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <?php
            Yii::$app->params['meta_author']['content']         = 'nanta es | www.escyber.com';
            Yii::$app->params['meta_description']['content']    = strip_tags($description->content);
            Yii::$app->params['meta_keywords']['content']       = strip_tags($keyword->content);
            
            Yii::$app->params['og_site_name']['content']        = Yii::$app->name;
        ?>
        
        
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>

    <body>
<?php $this->beginBody() ?>

        <main>

            <!-- Header -->
            <header id="js-header" class="u-header u-header--static u-shadow-v19">
                <!-- Top Bar -->
                <div class="u-header__section g-brd-bottom g-brd-gray-light-v4 g-py-18">
                    <div class="container">
                        <div class="row align-items-center">
                            <!-- Logo -->
                            <div class="col-md-3 g-hidden-md-down">
                                <?= str_replace('user/', '', Html::a($logo1Image, ['site/index'], ['class' => 'navbar-brand'])); ?>
                            </div>
                            <!-- End Logo -->
                            <!-- Subscribe Form -->
                            <div class="col-6 col-md-5">
                                
                                <!-- SMAN MBA SEARCH BOX -->
                                <div class="gcse-search" style="padding:0px"></div>
                                <!-- END SMAN MBA SEARCH BOX -->
                                
<!--                                <form class="input-group rounded">
                                    <input
                                        class="form-control g-brd-secondary-light-v2 g-brd-primary--focus g-color-secondary-dark-v1 g-placeholder-secondary-dark-v1 g-bg-white g-font-weight-400 g-font-size-13 g-px-20 g-py-12"
                                        type="text" placeholder="Search the entire site">
                                    <span class="input-group-append g-brd-none g-py-0 g-pr-0">
                                        <button
                                            class="btn u-btn-white g-color-primary--hover g-bg-secondary g-font-weight-600 g-font-size-13 text-uppercase g-py-12 g-px-20"
                                            type="submit">
                                            <span class="g-hidden-md-down">Search</span>
                                            <i class="g-hidden-lg-up fa fa-search"></i>
                                        </button>
                                    </span>
                                </form>-->


                            </div>
                            <!-- End Subscribe Form -->

                            <!-- KATEGORI -->
                            <div class="col-4 col-lg-2 g-pos-rel g-px-15 ml-auto" style="padding-top:1em">
                                <a id="languages-dropdown-invoker"
                                   class="g-color-secondary-dark-v1 g-color-primary--hover g-text-underline--none--hover"
                                   href="#" aria-controls="languages-dropdown" aria-haspopup="true" aria-expanded="false"
                                   data-dropdown-event="hover" data-dropdown-target="#languages-dropdown"
                                   data-dropdown-type="css-animation" data-dropdown-duration="300"
                                   data-dropdown-hide-on-scroll="false" data-dropdown-animation-in="fadeIn"
                                   data-dropdown-animation-out="fadeOut">
                            <!--<span>Kategori</span> <i class="g-hidden-sm-down fa fa-angle-down g-ml-7"></i>-->
                                </a>

                                <ul id="languages-dropdown"
                                    class="list-unstyled g-width-160 g-brd-around g-brd-secondary-light-v2 g-bg-white rounded g-pos-abs g-py-5 g-mt-32"
                                    aria-labelledby="languages-dropdown-invoker">

                                    <?php //foreach ($categories as $categoryModel) { ?>
                                        <li>
                                            <?php
                                                //echo Html::a($categoryModel->title, ['/blog/index','cat'=>$categoryModel->id,'title'=>$categoryModel->title], ['class' => 'd-block g-color-secondary-dark-v1 g-color-primary--hover g-text-underline--none--hover g-py-5 g-px-20']);
                                            ?>
  
                                            
                                            <?php //str_replace('user/', '', Html::a('Artikel', ['blog/index'], ['id' => 'nav-link--pages', 'class' => 'nav-link text-uppercase g-color-primary--hover g-px-0'])) ?>
                                        </li>
                                    <?php //} ?>

                                </ul>
                            </div>
                            <!-- End KATEGORI -->

                            <!-- Account -->
                            <div class="col-1">
                                <a id="account-dropdown-invoker"
                                   class="media align-items-center float-right g-text-underline--none--hover" href="#"
                                   aria-controls="account-dropdown" aria-haspopup="true" aria-expanded="false"
                                   data-dropdown-event="hover" data-dropdown-target="#account-dropdown"
                                   data-dropdown-type="css-animation" data-dropdown-duration="300"
                                   data-dropdown-hide-on-scroll="false" data-dropdown-animation-in="fadeIn"
                                   data-dropdown-animation-out="fadeOut">
                                    <div class="d-flex g-width-20 g-height-20 mr-2">
                                        <i class='icon-hotel-restaurant-005 u-line-icon-pro'></i>
                                    </div>
                                    <div class="media-body">
                                        <span
                                            class="d-block g-hidden-sm-down g-color-main g-font-weight-600 g-font-size-13">
                                            Dashboard
                                        </span>
                                    </div>
                                </a>

                                <ul id="account-dropdown"
                                    class="list-unstyled text-right g-width-160 g-brd-around g-brd-secondary-light-v2 g-bg-white rounded g-pos-abs g-right-0 g-py-5 g-mt-57"
                                    aria-labelledby="account-dropdown-invoker">


                                    <?php
                                    if (Yii::$app->user->getIsGuest()) {
                                        echo Yii::$app->user->identity;
                                        echo '<li>';
                                        echo str_replace('user/user/', '', Html::a('Login', ['admin/user/login'], ['class' => 'd-block g-color-secondary-dark-v1 g-color-primary--hover g-text-underline--none--hover g-py-5 g-px-20']));
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

                                </ul>
                            </div>
                            <!-- End Account -->

                        </div>
                    </div>
                </div>
                <!-- End Top Bar -->

                <div class="u-header__section u-header__section--light g-bg-white g-transition-0_3 g-py-10">
                    <nav class="js-mega-menu navbar navbar-expand-lg g-px-0">
                        <div class="container g-px-15">
                            <?php 
                                $transitionLogo = Html::img($logo1Url, ['alt' => 'Logo']);
                                echo str_replace('user/', '', Html::a($transitionLogo, 
                                        ['site/index'], 
                                        ['class' => 'navbar-brand g-hidden-lg-up']));
                            ?>
                            <!-- Responsive Toggle Button -->
                            <button
                                class="navbar-toggler navbar-toggler-right btn g-line-height-1 g-brd-none g-pa-0 ml-auto"
                                type="button" aria-label="Toggle navigation" aria-expanded="false" aria-controls="navBar"
                                data-toggle="collapse" data-target="#navBar">
                                <span class="hamburger hamburger--slider g-pa-0">
                                    <span class="hamburger-box">
                                        <span class="hamburger-inner"></span>
                                    </span>
                                </span>
                            </button>
                            <!-- End Responsive Toggle Button -->

                            <!-- Navigation -->
                            <div class="collapse navbar-collapse align-items-center flex-sm-row g-pt-10 g-pt-5--lg"
                                 id="navBar">
                                <ul class="navbar-nav g-font-weight-600 mr-auto">

                                    <!-- HOME -->
                                    <li class="nav-item g-mr-10--lg g-mr-20--xl" style="padding-right:5px">
                                        <?= str_replace('user/', '', Html::a('Beranda', ['site/index'], ['id' => 'nav-link--pages', 'class' => 'nav-link text-uppercase g-color-primary--hover g-px-0'])) ?>
                                    </li>

                                    <li class="nav-item g-mr-10--lg g-mr-20--xl" style="padding-right:5px">
                                        <?= str_replace('user/', '', Html::a('Artikel', ['blog/index'], ['id' => 'nav-link--pages', 'class' => 'nav-link text-uppercase g-color-primary--hover g-px-0'])) ?>
                                    </li>

                                    <?php if ($timeLine != null) { ?>
                                        <li class="nav-item g-mr-10--lg g-mr-20--xl" style="padding-right:5px">
                                        <?= str_replace('user/', '', Html::a($timeLine->title, ['category/time-line'], ['id' => 'nav-link--pages', 'class' => 'nav-link text-uppercase g-color-primary--hover g-px-0'])) ?>
                                        </li>
                                    <?php } ?>

                                    <li class="nav-item g-mr-10--lg g-mr-20--xl" style="padding-right:5px">
                                        <?= str_replace('user/', '', Html::a('Download', ['archive/index'], ['id' => 'nav-link--pages', 'class' => 'nav-link text-uppercase g-color-primary--hover g-px-0'])) ?>
                                    </li>

                                    <!--<li class="nav-item g-mr-10--lg g-mr-20--xl" style="padding-right:5px">-->
                                        <?php //str_replace('user/', '', Html::a('Penulis', ['author/index'], ['id' => 'nav-link--pages', 'class' => 'nav-link text-uppercase g-color-primary--hover g-px-0'])) ?>
                                    <!--</li>-->

                                    <li class="nav-item hs-has-sub-menu g-mr-10--lg g-mr-20--xl">
                                        <a id="nav-link--category" class="nav-link text-uppercase g-color-primary--hover g-px-0"
                                           href="#" aria-haspopup="true" aria-expanded="false"
                                           aria-controls="nav-submenu--category">
                                            Kategori
                                        </a>

                                        <!-- Submenu -->
                                        <ul id="nav-submenu--category"
                                            class="hs-sub-menu list-unstyled u-shadow-v11 g-min-width-220 g-brd-top g-brd-primary g-brd-top-2 g-mt-17"
                                            aria-labelledby="nav-link--category">

                                            <?php foreach ($categories as $categoryModel) { ?>
                                            
                                                <li class="dropdown-item g-bg-secondary--hover">
                                                    <?php
                                                        echo Html::a($categoryModel->title, 
                                                                ['/blog/index','cat'=>$categoryModel->id,'title'=>$categoryModel->title], 
                                                                ['class' => 'nav-link g-color-secondary-dark-v1']);
                                                    ?>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                        <!-- End Submenu -->
                                    </li>

<!--                                    <li class="nav-item hs-has-sub-menu g-mr-10--lg g-mr-20--xl">
                                        <a id="nav-link--home" class="nav-link text-uppercase g-color-primary--hover g-px-0"
                                           href="#" aria-haspopup="true" aria-expanded="false"
                                           aria-controls="nav-submenu--home">
                                            Page
                                        </a>

                                         Submenu 
                                        <ul id="nav-submenu--home"
                                            class="hs-sub-menu list-unstyled u-shadow-v11 g-min-width-220 g-brd-top g-brd-primary g-brd-top-2 g-mt-17"
                                            aria-labelledby="nav-link--home">

                                            <?php
//                                            foreach ($pageTypes as $pageTypeModel) {
//                                                $pages = Page::find()->where(['page_type_id' => $pageTypeModel->id])->orderBy(['sequence' => SORT_ASC])->all();
                                            ?>

                                                <div class="dropright dropdown-item g-bg-secondary--hover">
                                                    <div data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <a class="nav-link g-color-secondary-dark-v1">
                                                            <?php //$pageTypeModel->title ?>
                                                            <span class="pull-right"><i class="fa fa-angle-right"></i></span>
                                                        </a>
                                                    </div>
                                                    <div class="dropdown-menu">
                                                        <?php
//                                                        foreach ($pages as $pageModel) {
//                                                            echo '<li class="dropdown-item g-bg-secondary--hover">' . Html::a($pageModel->title, $pageModel->getUrl(), ['class' => 'nav-link g-color-secondary-dark-v1']) . '</li>';
//                                                        }
                                                        ?>
                                                    </div>
                                                </div>

                                            <?php
                                            //}
                                            ?>

                                        </ul>
                                         End Submenu 
                                    </li>
-->
                                    <!-- End Home - Submenu -->

                                </ul>

                                <ul class="navbar-nav g-font-weight-600">
                                    <li class="nav-item g-mr-10--lg g-mr-20--xl">
                                        <?= str_replace('user/', '', Html::a('Staff', ['staff/index'], ['id' => 'nav-link--pages', 'class' => 'nav-link text-uppercase g-color-primary--hover g-px-0'])) ?>
                                    </li>                                    
                                    <li class="nav-item g-mr-10--lg g-mr-20--xl">
                                        <?= str_replace('user/', '', Html::a('About', ['site/about'], ['id' => 'nav-link--pages', 'class' => 'nav-link text-uppercase g-color-primary--hover g-px-0'])) ?>
                                    </li>
                                </ul>
                            </div>
                            <!-- End Navigation -->
                        </div>
                    </nav>
                </div>
            </header>
            <!-- End Header -->

            <div class="container content" style="padding-top: 10px">
                <?= Alert::widget() ?>
                <?= $content ?>
            </div>


            <!-- Footer -->
            <footer class="g-bg-secondary">
                <!-- Footer - Content -->
                <div class="container">
                    <!-- Footer - Content -->
                    <div class="g-brd-bottom g-brd-secondary-light-v2 g-py-50 g-mb-50">
                        <div class="row">
                            <div class="col-sm-4 col-md-3 g-brd-right--md g-brd-secondary-light-v2 g-mb-30 g-mb-0--md">
                                <h3 class="h6 g-font-primary g-font-weight-700 text-uppercase mb-3">Links</h3>

                                <!-- Arts -->
                                <ul class="list-unstyled mb-0">
                                    <?php
                                        foreach ($siteLinks as $i => $siteLinkItemData) {
                                    ?>
                                        <li class="g-px-0 g-my-8">
                                            <i class="fa fa-angle-right g-color-gray-dark-v5 g-mr-5"></i>
                                            <a class="u-link-v5 g-color-secondary-dark-v1 g-color-primary--hover g-font-size-13 g-pl-0 g-pl-7--hover g-transition-0_3 g-py-7"
                                               href="<?= $siteLinkItemData->url ?>" target="_blank">
                                                <?= $siteLinkItemData->title ?>
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                                <!-- End Arts -->
                            </div>

                            <div class="col-sm-8 col-md-6 g-brd-right--md g-brd-secondary-light-v2 g-mb-30 g-mb-0--md">
                                <div class="g-pl-10--md">
                                    <h3 class="h6 g-font-primary g-font-weight-700 text-uppercase mb-2">Latest</h3>

                                    <!-- Footer - Popular Stories Carousel -->
                                    <div class="js-carousel g-mx-minus-10" data-infinite="true" data-slides-show="1"
                                         data-autoplay="true" data-speed="7000" data-lazy-load="ondemand"
                                         data-arrows-classes="u-arrow-v1 g-pos-abs g-top-minus-35 g-width-30 g-height-30 g-color-secondary-dark-v1 g-color-primary--hover"
                                         data-arrow-left-classes="fa fa-angle-left g-right-30"
                                         data-arrow-right-classes="fa fa-angle-right g-right-0" data-responsive='[{
                                         "breakpoint": 1200,
                                         "settings": {
                                         "slidesToShow": 4
                                         }
                                         }, {
                                         "breakpoint": 992,
                                         "settings": {
                                         "slidesToShow": 3
                                         }
                                         }, {
                                         "breakpoint": 768,
                                         "settings": {
                                         "slidesToShow": 2
                                         }
                                         }, {
                                         "breakpoint": 480,
                                         "settings": {
                                         "slidesToShow": 2
                                         }
                                         }]'>


                                <?php
                                    $footerQuery = Blog::find()->where(['publish_status' => Blog::PUBLISH_STATUS_YES]);

                                    $footerProvider = new ActiveDataProvider([
                                        'query' => $footerQuery,
                                        'pagination' => [
                                            'pageSize' => 4,
                                        ],
                                        'sort' => [
                                            'defaultOrder' => [
                                                'created_at' => SORT_DESC,
                                                'title' => SORT_ASC,
                                            ]
                                        ],
                                            ]);

                                    // returns an array of Blog objects
                                    $footerBlogs = $footerProvider->getModels();
                                ?>
                                        <?php foreach ($footerBlogs as $footerBlogItemData) { ?>
                                            <?php $imgSource = str_replace('frontend', 'backend', $footerBlogItemData->getCover($footerBlogItemData->content)); ?>

                                            <div class="js-slide g-px-10">
                                                <article class="media g-bg-white g-pa-10">
                                                    
                                                    
                                                    <?php if(substr($imgSource, 0, 2)=='//'){ ?>
                                                            <iframe 
                                                                class ="mr-3"
                                                                allowfullscreen="" 
                                                                frameborder="0" 
                                                                width="70"
                                                                height="70" 
                                                                src="<?=$imgSource;?>?controls=0" 
                                                            >
                                                            </iframe>

                                                    <?php } else{ ?>

                                                        <figure class="d-flex g-width-70 g-height-70 mr-3">
                                                            <?= Html::img($imgSource, ['class' => 'img-fluid', 'style' => 'width:70px;height:70px'], ['alt' => 'Image Description']); ?>
                                                        </figure>

                                                    <?php } ?>
                                                    
                                                    


                                                    <div class="media-body">
                                                        <span class="d-block g-color-lightred g-font-weight-700 g-font-size-12 text-uppercase mb-1">
                                                            <?= $footerBlogItemData->category->title; ?>
                                                        </span>
                                                        <h4 class="g-font-size-13 mb-0">
                                                            <?= Html::a($footerBlogItemData->title, $footerBlogItemData->getUrl(), ['class' => 'u-link-v5 g-color-main g-color-primary--hover']) ?>
                                                        </h4>
                                                    </div>
                                                </article>
                                            </div>

                                        <?php } ?>

                                    </div>
                                    <!-- End Footer - Popular Stories Carousel -->
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="g-pl-10--md">
                                    <h3 class="h6 g-font-primary g-font-weight-700 text-uppercase mb-3">Office</h3>

                                    <!-- Subscribe -->
                                    <ul class="list-unstyled mb-0">
                                        <li class="g-px-0 g-my-8">
                                            <i
                                                class="align-middle g-color-primary mr-2 icon-real-estate-044 u-line-icon-pro"></i>

                                            <span class="u-link-v5 g-color-secondary-dark-v1 g-color-primary--hover g-font-size-13 g-pl-0 g-pl-7--hover g-transition-0_3 g-py-7">
                                                <?= $office->title; ?>
                                            </span>
                                        </li>
                                        <li class="g-px-0 g-my-8">
                                            <i class="align-middle g-color-primary mr-2 icon-phone u-line-icon-pro"></i>
                                            <span class="u-link-v5 g-color-secondary-dark-v1 g-color-primary--hover g-font-size-13 g-pl-0 g-pl-7--hover g-transition-0_3 g-py-7">
                                                <?= $office->phone_number; ?>
                                            </span>
                                        </li>
                                        <li class="g-px-0 g-my-8">
                                            <i class="align-middle g-color-primary mr-2 icon-envelope u-line-icon-pro"></i>
                                            <span class="u-link-v5 g-color-secondary-dark-v1 g-color-primary--hover g-font-size-13 g-pl-0 g-pl-7--hover g-transition-0_3 g-py-7">
                                                <?= (strlen($office->email) > 30) ? '<small>' . $office->email . '</small>' : $office->email; ?>
                                            </span>
                                        </li>
                                        <li class="g-px-0 g-my-15">
                                            <i class="align-middle g-color-primary mr-2 icon-location-pin u-line-icon-pro"></i>
                                            <span class="u-link-v5 g-color-secondary-dark-v1 g-color-primary--hover g-font-size-13 g-pl-0 g-pl-7--hover g-transition-0_3 g-py-7">
                                                <?= $office->address; ?>
                                            </span>
                                        </li>
                                        <li class="dropdown-divider g-brd-secondary-light-v2 g-px-0 g-mt-8 g-my-15"></li>
                                        <li class="row g-px-0 g-my-8 g-mx-minus-5">
                                            <div class="col g-px-5 mb-2">
                                                <!-- Button -->
                                                <?php
                                                    if(!empty($office->twitter)){
                                                        echo TwitterPlugin::widget([
                                                            'type' => TwitterPlugin::FOLLOW,
                                                            'screenName' => $office->twitter,
                                                            'settings' => [
                                                                'size' => 'large',
                                                                'data-show-count'=>'false',
                                                                'class'=>'btn btn-block u-btn-black g-brd-primary--hover g-bg-primary--hover text-left g-px-12'
                                                            ]
                                                        ]);
                                                    }
                                                ?>
<!--                                                <button
                                                    class="btn btn-block u-btn-black g-brd-primary--hover g-bg-primary--hover text-left g-px-12"
                                                    type="button">
                                                    <div class="media align-items-center">
                                                        <div class="d-flex mr-3">
                                                            <i class="g-font-size-25 fa fa-android"></i>
                                                        </div>
                                                        <div class="media-body">
                                                            <span class="d-block g-font-size-10">Get it for</span>
                                                            <span class="d-block g-font-size-15">Android</span>
                                                        </div>
                                                    </div>
                                                </button>-->
                                                <!-- End Button -->
                                            </div>

                                            <div class="col g-px-5 mb-2">
<!--                                                 Button 
                                                <button
                                                    class="btn btn-block u-btn-black g-brd-primary--hover g-bg-primary--hover text-left g-px-12"
                                                    type="button">
                                                    <div class="media align-items-center">
                                                        <div class="d-flex mr-3">
                                                            <i class="g-font-size-25 fa fa-apple"></i>
                                                        </div>
                                                        <div class="media-body">
                                                            <span class="d-block g-font-size-10">Get it for</span>
                                                            <span class="d-block g-font-size-15">iOS</span>
                                                        </div>
                                                    </div>
                                                </button>
                                                 End Button -->
                                            </div>
                                        </li>
                                    </ul>
                                    <!-- End Subscribe -->
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- End Footer - Content -->

                    <!-- Footer - Top Section -->
                    <div class="g-brd-bottom g-brd-secondary-light-v2 g-py-10 g-mb-50">
                        <div class="row align-items-center">
                            <div class="col-md-4 g-hidden-sm-down g-mb-30">
                                <!-- Logo -->
                                <?= str_replace('user/', '', Html::a($logo2Image, ['site/index'], ['class' => 'g-width-150'])); ?>
                                <!-- End Logo -->
                            </div>

                            <div class="col-md-4 ml-auto g-mb-30">
                                <!-- Social Icons -->
                                <ul class="list-inline mb-0">
                                    <li class="list-inline-item g-mx-2">
                                        <a class="u-icon-v2 u-icon-size--sm g-brd-secondary-light-v2 g-color-secondary-dark-v2 g-color-white--hover g-bg-primary--hover g-font-size-default rounded"
                                           href="#" data-toggle="tooltip" data-placement="top" title="Like Us on Facebook">
                                            <i class="fa fa-facebook"></i>
                                        </a>
                                    </li>
                                    <li class="list-inline-item g-mx-2">
                                        <a class="u-icon-v2 u-icon-size--sm g-brd-secondary-light-v2 g-color-secondary-dark-v2 g-color-white--hover g-bg-primary--hover g-font-size-default rounded"
                                           href="#" data-toggle="tooltip" data-placement="top"
                                           title="Follow Us on Twitter">
                                            <i class="fa fa-twitter"></i>
                                        </a>
                                    </li>
                                    <li class="list-inline-item g-mx-2">
                                        <a class="u-icon-v2 u-icon-size--sm g-brd-secondary-light-v2 g-color-secondary-dark-v2 g-color-white--hover g-bg-primary--hover g-font-size-default rounded"
                                           href="#" data-toggle="tooltip" data-placement="top"
                                           title="Join Our Cirlce on Google Plus">
                                            <i class="fa fa-google-plus"></i>
                                        </a>
                                    </li>
                                    <li class="list-inline-item g-mx-2">
                                        <a class="u-icon-v2 u-icon-size--sm g-brd-secondary-light-v2 g-color-secondary-dark-v2 g-color-white--hover g-bg-primary--hover g-font-size-default rounded"
                                           href="#" data-toggle="tooltip" data-placement="top"
                                           title="Subscribe to Our YouTube Channel">
                                            <i class="fa fa-youtube"></i>
                                        </a>
                                    </li>
                                    <li class="list-inline-item g-mx-2">
                                        <a class="u-icon-v2 u-icon-size--sm g-brd-secondary-light-v2 g-color-secondary-dark-v2 g-color-white--hover g-bg-primary--hover g-font-size-default rounded"
                                           href="#" data-toggle="tooltip" data-placement="top"
                                           title="Follow Us on Instagram">
                                            <i class="fa fa-instagram"></i>
                                        </a>
                                    </li>
                                    <li class="list-inline-item g-mx-2">
                                        <a class="u-icon-v2 u-icon-size--sm g-brd-secondary-light-v2 g-color-secondary-dark-v2 g-color-white--hover g-bg-primary--hover g-font-size-default rounded"
                                           href="#" data-toggle="tooltip" data-placement="top" title="RSS">
                                            <i class="fa fa-rss"></i>
                                        </a>
                                    </li>
                                </ul>
                                <!-- End Social Icons -->
                            </div>

                            <div class="col-md-4 text-center text-md-right g-mb-30">
                                <!-- Subscribe Form -->
                                <form class="input-group rounded">
                                    <input
                                        class="form-control g-brd-secondary-light-v2 g-color-secondary-dark-v1 g-placeholder-secondary-dark-v1 g-bg-secondary-light-v3 g-font-weight-400 g-font-size-13 g-px-20 g-py-12"
                                        type="email" placeholder="Enter your email address">
                                    <span class="input-group-append g-brd-none g-py-0 g-pr-0">
                                        <button
                                            class="btn u-btn-white g-color-primary--hover g-font-weight-600 g-font-size-13 text-uppercase g-py-12 g-px-20"
                                            type="submit">Subscribe</button>
                                    </span>
                                </form>
                                <!-- End Subscribe Form -->
                            </div>
                        </div>
                    </div>
                    <!-- End Footer - Top Section -->

                    <!-- Footer - Bottom Section -->
                    <div class="row align-items-center">

                        <div class="col-md-4 g-brd-right--md g-brd-secondary-light-v2 g-mb-30">
                            <!-- Copyright -->
                            <p class="g-color-secondary-light-v1 g-font-size-12 mb-0"><?= date('Y') ?> ©
                                <?php echo Yii::$app->params['Copyright']; ?>
                            </p>
                            <!-- End Copyright -->
                        </div>

                        <div class="col-md-6 g-brd-right--md g-brd-secondary-light-v2 g-mb-30">
                            <!-- Links -->
                            <ul class="list-inline mb-0">
                                <li class="list-inline-item g-pl-0 g-pr-10">
                                    <a class="u-link-v5 g-color-secondary-light-v1 g-font-size-12"
                                       href="<?php echo Yii::$app->params['Website']; ?>">
                                        <?php echo Yii::$app->params['Website']; ?>
                                    </a>
                                </li>
                                <li class="list-inline-item g-px-10">
                                    <span class="u-link-v5 g-color-secondary-light-v1 g-font-size-12">All rights
                                        reserved
                                    </span>
                                </li>
                                <li class="list-inline-item g-px-10">
                                    <span class="u-link-v5 g-color-secondary-light-v1 g-font-size-12">Version
                                        <?php echo Yii::$app->params['App Version']; ?>
                                    </span>
                                </li>
                            </ul>
                            <!-- End Links -->
                        </div>

                        <div class="col-md-2 g-mb-30">
                        </div>
                    </div>
                    <!-- End Footer - Bottom Section -->
                </div>
            </footer>
            <!-- End Footer -->

            <!-- Go To -->
            <a class="js-go-to u-go-to-v2" href="#" data-type="fixed" data-position='{
               "bottom": 15,
               "right": 15
               }' data-offset-top="400" data-compensation="#js-header" data-show-effect="zoomIn">
                <i class="hs-icon hs-icon-arrow-top"></i>
            </a>
            <!-- End Go To -->

        </main>
<?php $this->endBody() ?>
    </body>

</html>
<?php $this->endPage() ?>

<script async src="https://cse.google.com/cse.js?cx=fa142c22a7a1bf20b"></script>
