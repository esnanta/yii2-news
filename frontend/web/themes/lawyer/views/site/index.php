<?php
use yii\helpers\Html;

use backend\models\Blog;
use backend\models\Office;
use backend\models\ThemeDetail;


$office                 = Office::findOne(1);
$blogLatests            = Blog::find()->limit(3)
                            ->where([
                                'publish_status' => Blog::PUBLISH_STATUS_YES
                            ])
                            ->orderBy(['created_at'=>SORT_DESC])
                            ->all();


//THEME LAYOUT
$logoTop                = ThemeDetail::getByToken(Yii::$app->params['ContentToken_Logo1']);
$logoDown               = ThemeDetail::getByToken(Yii::$app->params['ContentToken_Logo2']);
$description            = ThemeDetail::getByToken(Yii::$app->params['ContentToken_Description']);
$keyword                = ThemeDetail::getByToken(Yii::$app->params['ContentToken_Keyword']);

$mainImage              = ThemeDetail::findOne(['token'=>'201']);
$mainImageUrl           = str_replace('frontend', 'backend', $mainImage->getImageUrl());

$promoText1             = ThemeDetail::findOne(['token'=>'202']);
$promoText2             = ThemeDetail::findOne(['token'=>'203']);
$aboutText1             = ThemeDetail::findOne(['token'=>'204']);
$aboutText2             = ThemeDetail::findOne(['token'=>'205']);
$aboutText3             = ThemeDetail::findOne(['token'=>'206']);

$teamHeader             = ThemeDetail::findOne(['token'=>'207']);
$teamProfile1           = ThemeDetail::findOne(['token'=>'208']);
$teamProfile2           = ThemeDetail::findOne(['token'=>'209']);
$teamProfile3           = ThemeDetail::findOne(['token'=>'210']);
?>

<?php
/* @var $this yii\web\View */
$this->title = Yii::$app->name;
?>




<!-- Section Content -->
<section class="rev_slider_wrapper fullwidthbanner-container"
         data-alias="image-hero20">
    <!-- START REVOLUTION SLIDER 5.0.7 fullwidth mode -->
    <div id="promoSlider" class="rev_slider fullwidthabanner" style="display: none;"
         data-version="5.0.7">
        <ul>
            <!-- SLIDE  -->
            <li style="text-align: center;" data-index="rs-68"
                data-transition="zoomout"
                data-slotamount="default"
                data-easein="Power4.easeInOut"
                data-easeout="Power4.easeInOut"
                data-masterspeed="2000"
                data-thumb= "assets/img-temp/promo/img1.jpg"
                data-rotate="0"
                data-saveperformance="off"
                data-title="Intro">
                <img src="<?=$mainImageUrl;?>" alt="Image description"
                     data-bgposition="50% 10%"
                     data-bgfit="cover"
                     data-bgrepeat="no-repeat"
                     data-bgparallax="10"
                     class="rev-slidebg"
                     data-no-retina>

                <!-- LAYERS -->
                <!-- LAYER NR. 1 -->
                <div id="promoSliderLayer10" class="tp-caption tp-shape tp-shapewrapper rs-parallaxlevel-0" style="z-index: 5; background-color: rgba(78, 67, 83, .4); border-color: rgba(78, 67, 83, .5);"
                     data-x="['center','center','center','center']"
                     data-y="['middle','middle','middle','middle']"
                     data-hoffset="['0','0','0','0']"
                     data-voffset="['0','0','0','0']"
                     data-width="full"
                     data-height="full"
                     data-whitespace="nowrap"
                     data-transform_idle="o:1;"
                     data-transform_in="opacity:0;s:1500;e:Power3.easeInOut;"
                     data-transform_out="s:300;s:300;"
                     data-start="750"
                     data-basealign="slide"
                     data-responsive_offset="on"
                     data-responsive="off"></div>

                <!-- LAYER NR. 3 -->
                <div id="promoSliderLayer1" class="tp-caption NotGeneric-Title tp-resizeme rs-parallaxlevel-0" style="z-index: 7; white-space: nowrap; text-align: center; text-transform: uppercase;"
                     data-x="['center','center','center','center']"
                     data-y="['middle','middle','middle','middle']"
                     data-hoffset="['0','0','0','0']"
                     data-voffset="['-60','-60','-22','-29']"
                     data-fontsize="['60','60','60','40']"
                     data-lineheight="['64','64','64','44']"
                     data-width="none"
                     data-height="none"
                     data-whitespace="nowrap"
                     data-transform_idle="o:1;"
                     data-transform_in="z:0;rX:0deg;rY:0;rZ:0;sX:1.5;sY:1.5;skX:0;skY:0;opacity:0;s:1500;e:Power3.easeInOut;"
                     data-transform_out="y:[100%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;"
                     data-mask_in="x:0px;y:0px;"
                     data-mask_out="x:inherit;y:inherit;"
                     data-start="1000"
                     data-splitin="none"
                     data-splitout="none"
                     data-responsive_offset="on">
                    
                    <?=$promoText1->content;?>
                    
                </div>

                <!-- LAYER NR. 4 -->
                <div id="promoSliderLayer4" class="tp-caption NotGeneric-SubTitle tp-resizeme rs-parallaxlevel-0" style="z-index: 8; white-space: nowrap; text-align: center; text-transform: uppercase;"
                     data-x="['center','center','center','center']"
                     data-hoffset="['0','0','0','0']"
                     data-y="['middle','middle','middle','middle']"
                     data-voffset="['52','52','28','13']"
                     data-visibility="['on','off']"
                     data-width="none"
                     data-height="none"
                     data-whitespace="nowrap"
                     data-transform_idle="o:1;"
                     data-transform_in="y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;s:1500;e:Power4.easeInOut;"
                     data-transform_out="y:[100%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;"
                     data-mask_in="x:0px;y:[100%];s:inherit;e:inherit;"
                     data-mask_out="x:inherit;y:inherit;s:inherit;e:inherit;"
                     data-start="1000"
                     data-splitin="none"
                     data-splitout="none"
                     data-responsive_offset="on">
                    
                    <?=$promoText2->content;?>
                    
                </div>

                <!-- LAYER NR. 5 -->
                <div id="promoSliderLayer7" class="tp-caption NotGeneric-CallToAction rev-btn rs-parallaxlevel-0" style="z-index: 9; font-weight: bold; white-space: nowrap; outline: none; box-shadow: none; box-sizing: border-box; text-transform: uppercase; border-width: 2px;"
                     data-x="['center','center','center','center']"
                     data-y="['middle','middle','middle','middle']"
                     data-hoffset="['0','0','0','0']"
                     data-voffset="['134','134','80','65']"
                     data-width="none"
                     data-height="none"
                     data-whitespace="nowrap"
                     data-transform_idle="o:1;"
                     data-transform_hover="o:1;rX:0;rY:0;rZ:0;z:0;s:300;e:Power1.easeInOut;"
                     data-style_hover="c:rgba(255, 255, 255, 1.00);bc:rgba(255, 255, 255, 1.00);cursor:pointer;"
                     data-transform_in="y:50px;opacity:0;s:1500;e:Power4.easeInOut;"
                     data-transform_out="y:[175%];s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;"
                     data-mask_out="x:inherit;y:inherit;s:inherit;e:inherit;"
                     data-start="1250"
                     data-splitin="none"
                     data-splitout="none"
                     data-actions='[
                     {"event":"click","action":"scrollbelow","offset":"0px"}
                     ]'
                     data-responsive_offset="on"
                     data-responsive="off">
                    Tentang Puja Tv
                </div>
            </li>
        </ul>

        <div class="tp-static-layers"></div>

        <div class="tp-bannertimer tp-bottom" style="visibility: hidden !important;"></div>
    </div>
</section><!-- END REVOLUTION SLIDER -->
<!-- End Section Content -->

<section id="puja">
    <div class="container-fluid px-0">
        <!-- Info Blocks -->
        <div class="row align-items-stretch no-gutters">
            <div class="col-md-4 g-parent g-bg-white">
                <!-- Article -->
                <article class="d-flex flex-wrap text-center g-color-gray-dark-v3">
                    <div class="order-2 w-100">
                        <?=Html::img($aboutText1->getImageUrl(), ['class'=>'w-100'],['style'=>'width:1200px;height:800px'],['alt' => 'alt image']);?>
                    </div>

                    <div class="order-1 w-100 u-ns-bg-v1-bottom g-z-index-1 g-py-50 g-py-100--md g-px-15 g-px-50--md">
                        <h3 class="text-uppercase g-line-height-1_1 g-font-weight-800 g-font-size-25 g-font-size-30--md g-mb-20">
                            <?=$aboutText1->title;?>
                        </h3>
                        <p class="mb-0">
                            <?=$aboutText1->content;?>
                        </p>
                    </div>
                </article>
                <!-- End Article -->
            </div>

            <div class="col-md-4 g-parent g-theme-bg-gray-dark-v1">
                <!-- Article -->
                <article class="d-flex flex-wrap text-center g-color-white">
                    <div class="order-1 w-100">
                        <?=Html::img($aboutText2->getImageUrl(), ['class'=>'w-100'],['style'=>'width:1200px;height:800px'],['alt' => 'alt image']);?>
                    </div>

                    <div class="order-2 w-100 u-ns-bg-v1-top g-z-index-1 g-py-50 g-py-100--md g-px-15 g-px-50--md">
                        <h3 class="text-uppercase g-line-height-1_1 g-font-weight-800 g-font-size-25 g-font-size-30--md g-color-white g-mb-20">
                            <?=$aboutText2->title;?>
                        </h3>
                        <p class="g-color-gray-light-v4 mb-0">
                            <?=$aboutText2->content;?>
                        </p>
                    </div>
                </article>
                <!-- End Article -->
            </div>

            <div class="col-md-4 g-parent g-bg-white">
                <!-- Article -->
                <article class="d-flex flex-wrap text-center g-color-gray-dark-v3">
                    <div class="order-2 w-100">
                        <?=Html::img($aboutText3->getImageUrl(), ['class'=>'w-100'],['style'=>'width:1200px;height:800px'],['alt' => 'alt image']);?>
                    </div>

                    <div class="order-1 w-100 u-ns-bg-v1-bottom g-z-index-1 g-py-50 g-py-100--md g-px-15 g-px-50--md">
                        <h3 class="text-uppercase g-line-height-1_1 g-font-weight-800 g-font-size-25 g-font-size-30--md g-mb-20">
                            <?=$aboutText3->title;?>
                        </h3>
                        <p class="mb-0">
                            <?=$aboutText3->content;?>
                        </p>
                    </div>
                </article>
                <!-- End Article -->
            </div>
        </div>
        <!-- End Info Blocks -->
    </div>
</section>


<!-- Section Content -->
<section id="team" class="g-py-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 g-mb-40 g-mb-0--lg">
                <div class="u-heading-v2-2--bottom g-brd-primary g-mb-30">
                    <h2 class="text-uppercase u-heading-v2__title g-font-weight-800 g-font-size-25 g-font-size-25--md g-line-height-1_3 mb-0">
                        <?=$teamHeader->title;?>
                    </h2>
                </div>

                <?= str_replace('<p>','<p class ="g-font-size-default g-mb-30">',$teamHeader->content);?>
                <a class="btn btn-md text-uppercase u-btn-primary g-font-weight-700 g-font-size-12 g-font-secondary g-brd-none rounded-0 g-py-10 g-px-25" href="#">Contact us</a>
            </div>

            <div class="col-lg-9">
                <div class="row">
                    <div class="col-md-4 g-mb-30 g-mb-0--md">
                        <!-- Figure -->
                        <figure class="g-color-gray-dark-v2">
                            <!-- Figure Image -->
                            <?=Html::img($teamProfile1->getImageUrl(), ['class'=>'w-100 g-mb-35'],['style'=>'width:600px;height:996px'],['alt' => 'alt image']);?>
                            <!-- End Figure Image -->

                            <!-- Figure Info -->
                            <em class="d-block text-uppercase g-font-size-11 g-font-weight-700 g-font-style-normal g-color-primary g-mb-10">Sales</em>
                            <h4 class="text-uppercase g-font-weight-800 g-font-size-18 g-mb-10">
                                <?=$teamProfile1->title;?>
                            </h4>
                            
                            <!-- End Info -->

                            <hr class="g-brd-gray-light-v4 g-my-15">

                            <!-- Contact Info -->
                            <ul class="list-unstyled g-font-size-default g-color-gray-dark-v2 mb-0">
                                <li>
                                    <i class="fa fa-phone-square g-mr-5"></i> <?=strip_tags($teamProfile1->content);?>
                                </li>
                            </ul>
                            <!-- End Contact Info -->
                        </figure>
                        <!-- End Figure -->
                    </div>

                    <div class="col-md-4 g-mb-30 g-mb-0--md">
                        <!-- Figure -->
                        <figure class="g-color-gray-dark-v2">
                            <!-- Figure Image -->
                            <?=Html::img($teamProfile2->getImageUrl(), ['class'=>'w-100 g-mb-35'],['style'=>'width:600px;height:996px'],['alt' => 'alt image']);?>
                            <!-- End Figure Image -->

                            <!-- Figure Info -->
                            <em class="d-block text-uppercase g-font-size-11 g-font-weight-700 g-font-style-normal g-color-primary g-mb-10">Sales</em>
                            <h4 class="text-uppercase g-font-weight-800 g-font-size-18 g-mb-10"><?=$teamProfile2->title;?></h4>
                            <!-- End Info -->

                            <hr class="g-brd-gray-light-v4 g-my-15">

                            <!-- Contact Info -->
                            <ul class="list-unstyled g-font-size-default g-color-gray-dark-v2 mb-0">
                                <li>
                                    <i class="fa fa-phone-square g-mr-5"></i> <?=strip_tags($teamProfile2->content);?>
                                </li>
                            </ul>
                            <!-- End Contact Info -->
                        </figure>
                        <!-- End Figure -->
                    </div>

                    <div class="col-md-4">
                        <!-- Figure -->
                        <figure class="g-color-gray-dark-v2">
                            <!-- Figure Image -->
                            <?=Html::img($teamProfile3->getImageUrl(), ['class'=>'w-100 g-mb-35'],['style'=>'width:600px;height:996px'],['alt' => 'alt image']);?>
                            <!-- End Figure Image -->

                            <!-- Figure Info -->
                            <em class="d-block text-uppercase g-font-size-11 g-font-weight-700 g-font-style-normal g-color-primary g-mb-10">Teknisi</em>
                            <h4 class="text-uppercase g-font-weight-800 g-font-size-18 g-mb-10"><?=$teamProfile3->title;?></h4>
                            <!-- End Info -->

                            <hr class="g-brd-gray-light-v4 g-my-15">

                            <!-- Contact Info -->
                            <ul class="list-unstyled g-font-size-default g-color-gray-dark-v2 mb-0">
                                <li>
                                    <i class="fa fa-phone-square g-mr-5"></i> <?=strip_tags($teamProfile3->content);?>
                                </li>
                            </ul>
                            <!-- End Contact Info -->
                        </figure>
                        <!-- End Figure -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Section Content -->