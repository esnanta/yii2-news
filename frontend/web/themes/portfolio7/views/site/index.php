<?php

use backend\models\Blog;
use backend\models\Office;
use backend\models\ThemeDetail;

//GOLOBAL PARAM
$logoTop                = ThemeDetail::getByToken(Yii::$app->params['ContentToken_Logo1']);
$logoDown               = ThemeDetail::getByToken(Yii::$app->params['ContentToken_Logo2']);
$description            = ThemeDetail::getByToken(Yii::$app->params['ContentToken_Description']);
$keyword                = ThemeDetail::getByToken(Yii::$app->params['ContentToken_Keyword']);

//PORTFOLIO7 THEME LAYOUT
$breadcrumb_Header      = ThemeDetail::findOne(['token'=>'505']);
$portfolio7_Header      = ThemeDetail::findOne(['token'=>'506']);
$portfolio7_Title       = ThemeDetail::findOne(['token'=>'507']);
$portfolio7_Caption     = ThemeDetail::findOne(['token'=>'508']);
$blog_Header            = ThemeDetail::findOne(['token'=>'509']);

$office                 = Office::findOne(1);

/**
 * /////////////////////////////////////////////////////////////////////////////
 * B L O G S
 * /////////////////////////////////////////////////////////////////////////////
 */
$blogLatests = Blog::find()->limit(3)
    ->where([
        'publish_status' => Blog::PUBLISH_STATUS_YES
    ])
    ->orderBy(['created_at'=>SORT_DESC])
    ->all();

?>

<?php
/* @var $this yii\web\View */
$this->title = Yii::$app->name;
?>

<!-- Breadcrumbs -->
<section class="g-bg-gray-light-v5 g-py-20">
    <div class="container">
        <div class="d-sm-flex text-center">
            <div class="align-self-center">
                <h2 class="h3 g-font-weight-300 w-100 g-mb-10 g-mb-0--md"><?=$breadcrumb_Header->content;?></h2>
            </div>

            <div class="align-self-center ml-auto">
                <span class="g-color-primary"><?= Yii::$app->formatter->format(date("Y-m-d"), 'date'); ?></span>

            </div>
        </div>
    </div>
</section>
<!-- End Breadcrumbs -->

<!-- Portfolio Single Item -->
<section class="container g-py-20">

    <div class="row g-mb-20">
        <div class="col-md-8 g-mb-30">
            <div class="mb-5">
                <h2 class="g-color-black mb-1"><?=$portfolio7_Header->content;?></h2>
                <span class="d-block lead mb-4"><?=$portfolio7_Title->content;?></span>
                <?=$portfolio7_Caption->content;?>
            </div>
        </div>

        <div class="col-md-4">
            <h1 class="g-font-weight-300 mb-5"><?=$office->title;?></h1>

            <div class="mb-4">
                <h2 class="h5 g-color-gray-dark-v2 g-font-weight-600">Address:</h2>
                <p class="g-color-gray-dark-v4 g-font-size-16">
                    <?=$office->address;?>
                </p>
            </div>

            <div class="mb-4">
                <h2 class="h5 g-color-gray-dark-v2 g-font-weight-600">Email us:</h2>
                <p class="g-color-gray-dark-v4"><?=$office->email;?>
                </p>
            </div>

            <div class="mb-3">
                <h2 class="h5 g-color-gray-dark-v2 g-font-weight-600">Call us:</h2>
                <p class="g-color-gray-dark-v4"><span class="g-color-gray-dark-v2"><?=$office->phone_number;?></span>
                </p>
            </div>

        </div>

    </div>
    <!-- End Pagination -->
</section>
<!-- End Portfolio Single Item -->


<!--
 Cube Portfolio Blocks 
<section class="g-bg-gray-light-v5">
    <div class="container g-py-50">
        <h2 class="g-color-black text-center mb-5"><?php // $blog_Header->content;?></h2>
        <div class="row">
            <?php
//                foreach ($blogLatests as $i => $blogInfoModel) {
//                    $imgCover = str_replace('frontend', 'backend', $blogInfoModel->getCover($blogInfoModel->content));    
            ?>        
                    <div class="col-lg-4 g-mb-30 g-mb-0--lg">
                         Article 
                        <article class="u-shadow-v11 rounded">
                            <div class="g-pa-30">
                                    <?php  
                                        // Html::img($imgCover, ['class' => 'img-fluid g-transform-scale-1_1--parent-hover g-transition-0_5 g-transition--ease-in-out img-thumbnail', 'style' => 'width:290px;height:200px']);
                                    ?>                                 
                                <h3 class="g-font-weight-300 g-mb-15">
                                    <?php // Html::a($blogInfoModel->title, $blogInfoModel->getUrl(), ['class' => 'u-link-v5 g-color-gray-dark-v2 g-color-primary--hover']) ?>                                      
                                </h3>
                                <p><?php // $blogInfoModel->readMore(200);?>  </p>
                            </div>
                        </article>
                         End Article 
                    </div>        
            <?php            
                //}
            ?>        
        </div>
    </div>
</section>
 End Cube Portfolio Blocks -->
