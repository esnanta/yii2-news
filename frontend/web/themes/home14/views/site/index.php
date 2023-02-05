<?php
use yii\helpers\Html;
use yii\data\ActiveDataProvider;

use backend\models\Blog;
use backend\models\ThemeDetail;
use backend\models\Product;

//GOLOBAL PARAM
$logoTop                = ThemeDetail::getByToken(Yii::$app->params['ContentToken_Logo1']);
$logoDown               = ThemeDetail::getByToken(Yii::$app->params['ContentToken_Logo2']);
$description            = ThemeDetail::getByToken(Yii::$app->params['ContentToken_Description']);
$keyword                = ThemeDetail::getByToken(Yii::$app->params['ContentToken_Keyword']);

//HOME14 THEME LAYOUT
$slider1_Image          = ThemeDetail::findOne(['token'=>'101']);
$slider1_Header         = ThemeDetail::findOne(['token'=>'102']);
$slider1_Caption        = ThemeDetail::findOne(['token'=>'103']);

$slider2_Image          = ThemeDetail::findOne(['token'=>'104']);
$slider2_Header         = ThemeDetail::findOne(['token'=>'105']);
$slider2_Caption        = ThemeDetail::findOne(['token'=>'106']);

$iconBlock1_Icon        = ThemeDetail::findOne(['token'=>'110']);
$iconBlock1_Header      = ThemeDetail::findOne(['token'=>'111']);
$iconBlock1_Caption     = ThemeDetail::findOne(['token'=>'112']);

$iconBlock2_Icon        = ThemeDetail::findOne(['token'=>'113']);
$iconBlock2_Header      = ThemeDetail::findOne(['token'=>'114']);
$iconBlock2_Caption     = ThemeDetail::findOne(['token'=>'115']);

$iconBlock3_Icon        = ThemeDetail::findOne(['token'=>'116']);
$iconBlock3_Header      = ThemeDetail::findOne(['token'=>'117']);
$iconBlock3_Caption     = ThemeDetail::findOne(['token'=>'118']);

$ourCompany_Header      = ThemeDetail::findOne(['token'=>'120']);
$ourCompany_Caption     = ThemeDetail::findOne(['token'=>'121']);
$ourCompany_Image       = ThemeDetail::findOne(['token'=>'122']);

$ourRecent_Header       = ThemeDetail::findOne(['token'=>'126']);
$ourRecent_Caption      = ThemeDetail::findOne(['token'=>'127']);

$ourLatest_Header       = ThemeDetail::findOne(['token'=>'128']);
$ourLatest_Caption      = ThemeDetail::findOne(['token'=>'129']);

$callToAction_Caption   = ThemeDetail::findOne(['token'=>'131']);
$callToAction_Text      = ThemeDetail::findOne(['token'=>'132']);
$callToAction_Link      = ThemeDetail::findOne(['token'=>'133']);


/**
 * /////////////////////////////////////////////////////////////////////////////
 * P R O D U C T
 * /////////////////////////////////////////////////////////////////////////////
 */
$productQuery = Product::find()->limit(3);

$productProvider = new ActiveDataProvider([
    'query' => $productQuery,
    'pagination' => false,
    'sort' => [
        'defaultOrder' => [
            'create_time' => SORT_DESC,
        ]
    ],
]);

$products = $productProvider->getModels();


/**
 * /////////////////////////////////////////////////////////////////////////////
 * B L O G S
 * /////////////////////////////////////////////////////////////////////////////
 */
$blogQuery = Blog::find()->limit(3);

$blogProvider = new ActiveDataProvider([
    'query' => $blogQuery,
    'pagination' => false,
    'sort' => [
        'defaultOrder' => [
            'create_time' => SORT_DESC,
        ]
    ],
]);

$blogs = $blogProvider->getModels();

?>


<?php

/* @var $this yii\web\View */

$this->title = Yii::$app->name;
?>

    <!-- Revolution Slider -->
    <div class="g-overflow-hidden">
        <div id="rev_slider_26_1_wrapper" class="rev_slider_wrapper fullscreen-container" data-alias="mask-showcase"
            data-source="gallery" style="background:#aaaaaa;padding:0px;">
            <!-- START REVOLUTION SLIDER 5.4.1 fullscreen mode -->
            <div id="rev_slider_26_1" class="rev_slider fullscreenbanner tiny_bullet_slider" style="display:none;"
                data-version="5.4.1">
                <ul>
                    <!-- SLIDE  -->
                    <li data-index="rs-73" data-transition="fade" data-slotamount="default" data-hideafterloop="0"
                        data-hideslideonmobile="off" data-easein="default" data-easeout="default" data-masterspeed="300"
                        data-thumb="http://works.themepunch.com/revolution_5_3/wp-content/" data-rotate="0"
                        data-saveperformance="off" data-title="Slide" data-param1="" data-param2="" data-param3=""
                        data-param4="" data-param5="" data-param6="" data-param7="" data-param8="" data-param9=""
                        data-param10="" data-description="">
                        <!-- MAIN IMAGE -->
                        <img src="../../assets/img/bg/transparent2.png"
                            data-bgcolor='linear-gradient(90deg, rgba(0, 0, 153, 0.5) 0%, rgba(0, 190, 214, 0.6) 100%)'
                            style='background:linear-gradient(90deg, rgba(0, 0, 153, 0.5) 0%, rgba(0, 190, 214, 0.6) 100%)'
                            alt="" data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat"
                            data-bgparallax="off" class="rev-slidebg" data-no-retina>
                        <!-- LAYERS -->


                        <!-- LAYER NR. 2 -->
                        <div class="tp-caption   tp-resizeme rs-parallaxlevel-2" id="slide-73-layer-1"
                            data-x="['center','center','center','center']" data-hoffset="['500','500','390','220']"
                            data-y="['middle','middle','middle','middle']" data-voffset="['0','0','0','0']"
                            data-width="none" data-height="none" data-whitespace="nowrap" data-type="image"
                            data-responsive_offset="on"
                            data-frames='[{"delay":400,"speed":750,"sfxcolor":"#2f3b4a","sfx_effect":"blockfromleft","frame":"0","from":"z:0;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":500,"sfxcolor":"#ffffff","sfx_effect":"blocktoleft","frame":"999","to":"z:0;","ease":"Power4.easeOut"}]'
                            data-textAlign="['inherit','inherit','inherit','inherit']" data-paddingtop="[0,0,0,0]"
                            data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]"
                            style="z-index: 6;">
                            <img src="<?php echo str_replace('frontend', 'backend', $slider1_Image->getImageUrl())  ;?>" alt=""
                                data-ww="['1000px','1000px','800px','500px']" data-hh="['563px','563px','450','281']"
                                width="1200" height="675" data-no-retina>
                        </div>

                        <!-- LAYER NR. 3 -->
                        <div class="tp-caption   tp-resizeme" id="slide-73-layer-3"
                            data-x="['left','left','left','left']" data-hoffset="['150','100','50','20']"
                            data-y="['middle','middle','middle','middle']" data-voffset="['-177','-177','-177','-157']"
                            data-width="none" data-height="none" data-whitespace="normal" data-type="text"
                            data-responsive_offset="on"
                            data-frames='[{"delay":300,"speed":750,"sfxcolor":"#ffff58","sfx_effect":"blockfromleft","frame":"0","from":"z:0;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":500,"sfxcolor":"#ffffff","sfx_effect":"blocktoleft","frame":"999","to":"z:0;","ease":"Power4.easeOut"}]'
                            data-textAlign="['left','left','left','left']" data-paddingtop="[10,10,10,10]"
                            data-paddingright="[20,20,20,20]" data-paddingbottom="[10,10,10,10]"
                            data-paddingleft="[20,20,20,20]"
                            style="z-index: 7; white-space: normal; font-size: 20px; line-height: 20px; font-weight: 400; color: #ffffff; letter-spacing: 10px;">
                            <?= $slider1_Header->content;?>
                        </div>

                        <!-- LAYER NR. 4 -->
                        <div class="tp-caption   tp-resizeme" id="slide-73-layer-2"
                            data-x="['left','left','left','left']" data-hoffset="['150','100','50','20']"
                            data-y="['middle','middle','middle','middle']" data-voffset="['-30','-30','-30','-30']"
                            data-fontsize="['70','70','70','50']" data-lineheight="['70','70','70','50']"
                            data-width="['650','650','620','380']" data-height="none" data-whitespace="normal"
                            data-type="text" data-responsive_offset="on"
                            data-frames='[{"delay":200,"speed":750,"sfxcolor":"#ffff58","sfx_effect":"blockfromleft","frame":"0","from":"z:0;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":500,"sfxcolor":"#ffffff","sfx_effect":"blocktoleft","frame":"999","to":"z:0;","ease":"Power4.easeOut"}]'
                            data-textAlign="['left','left','left','left']" data-paddingtop="[20,20,20,20]"
                            data-paddingright="[20,20,20,20]" data-paddingbottom="[30,30,30,30]"
                            data-paddingleft="[20,20,20,20]"
                            style="z-index: 8; min-width: 650px; max-width: 650px; white-space: normal; font-size: 70px; font-weight: 600; line-height: 70px; color: #ffffff; letter-spacing: -2px;">
                            <?= $slider1_Caption->content;?>
                        </div>
                    </li>
                    <!-- SLIDE  -->
                    <li data-index="rs-74" data-transition="fade" data-slotamount="default" data-hideafterloop="0"
                        data-hideslideonmobile="off" data-easein="default" data-easeout="default" data-masterspeed="300"
                        data-thumb="http://works.themepunch.com/revolution_5_3/wp-content/" data-rotate="0"
                        data-saveperformance="off" data-title="Slide" data-param1="" data-param2="" data-param3=""
                        data-param4="" data-param5="" data-param6="" data-param7="" data-param8="" data-param9=""
                        data-param10="" data-description="">
                        <!-- MAIN IMAGE -->
                        <img src="../../assets/img/bg/transparent2.png"
                            data-bgcolor='linear-gradient(120deg, #b7ebf6 0%, rgba(228, 97, 210, 0.7) 100%)'
                            style='background:linear-gradient(120deg, #b7ebf6 0%, rgba(228, 97, 210, 0.7) 100%)' alt=""
                            data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat"
                            data-bgparallax="off" class="rev-slidebg" data-no-retina>
                        <!-- LAYERS -->

                        <!-- LAYER NR. 5 -->
                        <div class="tp-caption   tp-resizeme rs-parallaxlevel-2" id="slide-74-layer-1"
                            data-x="['center','center','center','center']" data-hoffset="['-500','-500','-390','-220']"
                            data-y="['middle','middle','middle','middle']" data-voffset="['0','0','0','0']"
                            data-width="none" data-height="none" data-whitespace="nowrap" data-type="image"
                            data-responsive_offset="on"
                            data-frames='[{"delay":200,"speed":750,"sfxcolor":"#243949","sfx_effect":"blockfromright","frame":"0","from":"z:0;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":500,"sfxcolor":"#ffffff","sfx_effect":"blocktoright","frame":"999","to":"z:0;","ease":"Power4.easeOut"}]'
                            data-textAlign="['inherit','inherit','inherit','inherit']" data-paddingtop="[0,0,0,0]"
                            data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]"
                            style="z-index: 5;">
                            <img src="<?php echo str_replace('frontend', 'backend', $slider2_Image->getImageUrl())  ;?>" alt=""
                                data-ww="['1000px','1000px','800px','500px']"
                                data-hh="['563px','563px','450px','281px']" width="1200" height="675" data-no-retina>
                        </div>

                        <!-- LAYER NR. 7 -->
                        <div class="tp-caption   tp-resizeme" id="slide-74-layer-3"
                            data-x="['left','left','left','left']" data-hoffset="['820','700','540','270']"
                            data-y="['middle','middle','middle','middle']" data-voffset="['-177','-177','-177','-157']"
                            data-width="none" data-height="none" data-whitespace="normal" data-type="text"
                            data-responsive_offset="on"
                            data-frames='[{"delay":400,"speed":750,"sfxcolor":"#cbbacc","sfx_effect":"blockfromright","frame":"0","from":"z:0;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":500,"sfxcolor":"#ffffff","sfx_effect":"blocktoright","frame":"999","to":"z:0;","ease":"Power4.easeOut"}]'
                            data-textAlign="['left','left','left','left']" data-paddingtop="[10,10,10,10]"
                            data-paddingright="[20,20,20,20]" data-paddingbottom="[10,10,10,10]"
                            data-paddingleft="[20,20,20,20]"
                            style="z-index: 7; white-space: normal; font-size: 20px; line-height: 20px; font-weight: 400; color: #ffffff; letter-spacing: 10px;">
                            <?=$slider2_Header->content;?>
                        </div>

                        <!-- LAYER NR. 8 -->
                        <div class="tp-caption   tp-resizeme" id="slide-74-layer-2"
                            data-x="['left','left','left','left']" data-hoffset="['360','240','110','80']"
                            data-y="['middle','middle','middle','middle']" data-voffset="['-30','-30','-30','-30']"
                            data-fontsize="['70','70','70','50']" data-lineheight="['70','70','70','50']"
                            data-width="['650','650','620','380']" data-height="none" data-whitespace="normal"
                            data-type="text" data-responsive_offset="on"
                            data-frames='[{"delay":300,"speed":750,"sfxcolor":"#cbbacc","sfx_effect":"blockfromright","frame":"0","from":"z:0;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":500,"sfxcolor":"#ffffff","sfx_effect":"blocktoright","frame":"999","to":"z:0;","ease":"Power4.easeOut"}]'
                            data-textAlign="['right','right','right','right']" data-paddingtop="[20,20,20,20]"
                            data-paddingright="[20,20,20,20]" data-paddingbottom="[30,30,30,30]"
                            data-paddingleft="[20,20,20,20]"
                            style="z-index: 8; min-width: 650px; max-width: 650px; white-space: normal; font-size: 70px; font-weight: 600; line-height: 70px; color: #ffffff; letter-spacing: -2px;">
                            <?=$slider2_Caption->content;?>
                        </div>
                    </li>
                </ul>
                <div class="tp-bannertimer" style="height: 10px; background: rgba(0, 0, 0, 0.15);"></div>
            </div>
        </div>
    </div>
    <!-- End Revolution Slider -->





<!-- Icon Blocks -->
<section class="g-py-100">
    <div class="container">
        <div class="row no-gutters">
            <div class="col-lg-4 g-px-40 g-mb-50 g-mb-0--lg">
                <!-- Icon Blocks -->
                <div class="text-center">
                    <span class="d-inline-block u-icon-v3 u-icon-size--xl g-bg-primary g-color-white rounded-circle g-mb-30">
                        <i class="<?= $iconBlock1_Icon->content;?>"></i>
                    </span>
                    <h3 class="h5 g-color-gray-dark-v2 g-font-weight-600 text-uppercase mb-3"><?= $iconBlock1_Header->content;?></h3>
                    <p class="mb-0"><?= $iconBlock1_Caption->content;?></p>
                </div>
                <!-- End Icon Blocks -->
            </div>

            <div class="col-lg-4 g-brd-left--lg g-brd-gray-light-v4 g-px-40 g-mb-50 g-mb-0--lg">
                <!-- Icon Blocks -->
                <div class="text-center">
                    <span class="d-inline-block u-icon-v3 u-icon-size--xl g-bg-primary g-color-white rounded-circle g-mb-30">
                        <?= $iconBlock2_Icon->content;?>
                    </span>
                    <h3 class="h5 g-color-gray-dark-v2 g-font-weight-600 text-uppercase mb-3"><?= $iconBlock2_Header->title;?></h3>
                    <p class="mb-0"><?= $iconBlock2_Caption->content;?></p>
                </div>
                <!-- End Icon Blocks -->
            </div>

            <div class="col-lg-4 g-brd-left--lg g-brd-gray-light-v4 g-px-40">
                <!-- Icon Blocks -->
                <div class="text-center">
                    <span class="d-inline-block u-icon-v3 u-icon-size--xl g-bg-primary g-color-white rounded-circle g-mb-30">
                        <?= $iconBlock3_Icon->content;?>
                    </span>
                    <h3 class="h5 g-color-gray-dark-v2 g-font-weight-600 text-uppercase mb-3"><?= $iconBlock3_Header->title;?></h3>
                    <p class="mb-0"><?= $iconBlock3_Caption->content;?></p>
                </div>
                <!-- End Icon Blocks -->
            </div>
        </div>
    </div>
</section>
<!-- End Icon Blocks -->



<hr class="g-brd-gray-light-v4 my-0">


<!-- About Our Company -->
<section class="1g-bg-secondary g-py-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 align-self-center g-mb-100 g-mb-0--lg">
                <header class="u-heading-v2-3--bottom g-brd-primary g-mb-20">
                    <h2 class="h4 u-heading-v2__title g-color-gray-dark-v2 g-font-weight-600 text-uppercase"><?=$ourCompany_Header->content;?></h2>
                </header>

                <p class="g-font-size-16 g-mb-30"><?=$ourCompany_Header->content;?></p>

                <?=$ourCompany_Caption->content;?>

            </div>
            <div class="col-lg-6 g-bg-img-hero g-pos-rel">
                <div class="g-absolute-centered text-center w-100 g-px-40">
                    <h2 class="h1 g-color-gray-light-v2 g-font-weight-600 g-letter-spacing-0_5">
                    <?php
                        $image = str_replace('frontend', 'backend', $ourCompany_Image->getImageUrl());
                        echo Html::img($image, ['class' => '', 'alt'=>'','style' => 'height:350px']);
                    ?>                        
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End About Our Company -->






<hr class="g-brd-gray-light-v4 my-0">

<!-- Our Recent Projects -->
<section class="g-py-100">
    <div class="container">
        <header class="g-mb-50">
            <div class="u-heading-v2-3--bottom g-brd-primary g-mb-20">
                <h2 class="h4 u-heading-v2__title g-color-gray-dark-v2 g-font-weight-600 text-uppercase"><?=$ourRecent_Header->content;?></h2>
            </div>
            <p class="g-font-size-16"><?=$ourRecent_Caption->content;?></p>
        </header>

        <div class="row">
            
            <?php
                foreach ($products as $i => $productModel) {
            ?>
                    <div class="col-lg-4 col-md-6 g-mb-30 g-mb-0--lg">


                        <article class="u-block-hover u-shadow-v21 rounded">
                            <figure class="u-bg-overlay g-bg-black-opacity-0_4--after">
                                <?php
                                    $prodImg = str_replace('frontend', 'backend', $productModel->getCoverUrl());
                                    echo Html::img($prodImg, ['class' => 'img-fluid w-100 u-block-hover__main--zoom-v1', 'alt'=>'Image description','style' => 'width:400;height:270px']);
                                ?>                                  
                            </figure>

                            <header class="u-bg-overlay__inner g-pos-abs g-top-30 g-right-30 g-left-30 g-color-white">
                                <h3 class="h4">
                                    <?= 
                                            Html::a($productModel->title, 
                                                Yii::$app->getUrlManager()->createUrl(['portfolio/view', 'id'=>$productModel->id,'title'=>$productModel->title]),
                                                ['class'=>'g-color-white']);
                                    ?>                                    
                                </h3>
                                <p><?=$productModel->description;?></p>
                            </header>

                        </article>
                    </div>
            <?php
                }
            ?>            
        </div>
    </div>
</section>
<!-- End Our Recent Projects -->

<hr class="g-brd-gray-light-v4 my-0">

<!-- Latest News -->
<section class="g-py-100">
    <div class="container">
        <header class="g-mb-50">
            <div class="u-heading-v2-3--bottom g-brd-primary g-mb-20">
                <h2 class="h4 u-heading-v2__title g-color-gray-dark-v2 g-font-weight-600 text-uppercase"><?=$ourLatest_Header->content;?></h2>
            </div>
            <p class="g-font-size-16"><?=$ourLatest_Caption->content;?></p>
        </header>

        <div class="row">
            
            <?php
                foreach ($blogs as $i => $blogModel) {
            ?>
                    <div class="col-lg-4 g-mb-30 g-mb-0--lg">
                        <!-- Article -->
                        <article class="u-shadow-v11 rounded">
                            <div class="g-pa-30">
                                <h3 class="g-font-weight-300 g-mb-15">
                                    <?= Html::a($blogModel->title, $blogModel->getUrl(), ['class' => 'u-link-v5 g-color-gray-dark-v2 g-color-primary--hover']) ?>
                                </h3>
                                <p>
                                    <?= $blogModel->readMore(300);?>  
                                </p>
                            </div>

                            <div class="media g-font-size-12 g-brd-top g-brd-gray-light-v4 g-pa-15-30">
                                <?php
                                    $src = str_replace('frontend', 'backend', $blogModel->getCover($blogModel->content));
                                    echo Html::img($src, ['class' => 'd-flex mr-2 rounded-circle g-width-20 g-height-20', 'style' => 'width:482px;height:300px']);
                                ?>

                                <div class="media-body align-self-center">
                                    <?= Html::a($blogModel->author->title, $blogModel->author->getUrl(), ['class' => 'u-link-v5 g-color-gray-dark-v2 g-color-primary--hover']) ?>
                                </div>

                                <div class="align-self-center">
                                    <a class="u-link-v5 g-color-gray-dark-v2 g-color-primary--hover" href="#!">
                                        <i class="icon-eye g-color-gray-dark-v5 g-pos-rel g-top-1 mr-1"></i> <?=$blogModel->view_counter;?>
                                    </a>
                                </div>
                            </div>
                        </article>
                        <!-- End Article -->
                    </div>
            <?php
                }
            ?>
            
            
                    

            
        </div>
    </div>
</section>
<!-- End Latest News -->


<hr class="g-brd-gray-light-v4 my-0">    


<!-- Call To Action -->
<section class="g-bg-primary g-color-white g-pa-30" style="background-image: url(../../assets/img/bg/pattern5.png);">
    <div class="d-md-flex justify-content-md-center text-center">
        <div class="align-self-md-center">
            <p class="lead g-font-weight-400 g-mr-20--md g-mb-15 g-mb-0--md"><?= $callToAction_Caption->content;?></p>
        </div>
        <div class="align-self-md-center">
            <a class="btn btn-lg u-btn-white text-uppercase g-font-weight-600 g-font-size-12" target="_blank" href="<?= $callToAction_Link->content;?>"><?= $callToAction_Text->content;?></a>
        </div>
    </div>
</section>
<!-- End Call To Action -->