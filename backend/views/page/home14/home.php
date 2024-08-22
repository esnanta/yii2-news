<?php
use yii\helpers\Html;
use kartik\detail\DetailView;
use yii\data\ActiveDataProvider;

use backend\models\Article as Blog;
use backend\models\Page as Page;
use backend\models\Product as Product;

/**
 * @var yii\web\View $this
 * @var common\models\Page $model
 */

$this->title = 'test';
$this->params['breadcrumbs'][] = ['label' => 'Pages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

//GOLOBAL PARAM
$logoTop                = Page::getByToken(Yii::$app->params['ContentToken_Logo1']);
$logoDown               = Page::getByToken(Yii::$app->params['ContentToken_Logo2']);
$description            = Page::getByToken(Yii::$app->params['ContentToken_Description']);
$keyword                = Page::getByToken(Yii::$app->params['ContentToken_Keyword']);

//HOME14 THEME LAYOUT
$slider1_Image          = Page::findOne(['token'=>'101']);
$slider1_Header         = Page::findOne(['token'=>'102']);
$slider1_Caption        = Page::findOne(['token'=>'103']);

$slider2_Image          = Page::findOne(['token'=>'104']);
$slider2_Header         = Page::findOne(['token'=>'105']);
$slider2_Caption        = Page::findOne(['token'=>'106']);

$iconBlock1_Icon        = Page::findOne(['token'=>'110']);
$iconBlock1_Header      = Page::findOne(['token'=>'111']);
$iconBlock1_Caption     = Page::findOne(['token'=>'112']);

$iconBlock2_Icon        = Page::findOne(['token'=>'113']);
$iconBlock2_Header      = Page::findOne(['token'=>'114']);
$iconBlock2_Caption     = Page::findOne(['token'=>'115']);

$iconBlock3_Icon        = Page::findOne(['token'=>'116']);
$iconBlock3_Header      = Page::findOne(['token'=>'117']);
$iconBlock3_Caption     = Page::findOne(['token'=>'118']);

$ourCompany_Header      = Page::findOne(['token'=>'120']);
$ourCompany_Caption     = Page::findOne(['token'=>'121']);
$ourCompany_Image       = Page::findOne(['token'=>'122']);

$ourRecent_Header       = Page::findOne(['token'=>'126']);
$ourRecent_Caption      = Page::findOne(['token'=>'127']);

$ourLatest_Header       = Page::findOne(['token'=>'128']);
$ourLatest_Caption      = Page::findOne(['token'=>'129']);

$callToAction_Caption   = Page::findOne(['token'=>'131']);
$callToAction_Text      = Page::findOne(['token'=>'132']);
$callToAction_Link      = Page::findOne(['token'=>'133']);

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
            'created_at' => SORT_DESC,
        ]
    ],
]);

$products = $productProvider->getModels();


/**
 * /////////////////////////////////////////////////////////////////////////////
 * B L O G S
 * /////////////////////////////////////////////////////////////////////////////
 */
$blogQuery = Article::find()->limit(3);

$blogProvider = new ActiveDataProvider([
    'query' => $blogQuery,
    'pagination' => false,
    'sort' => [
        'defaultOrder' => [
            'created_at' => SORT_DESC,
        ]
    ],
]);

$blogs = $blogProvider->getModels();

?>
<div class="page-view">

    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">H O M E</h3>
        </div>
        <div class="panel-body">

            <!-- /////////////////////////////////////////////////// -->
            <!-- /////////////////////////////////////////////////// -->
            <!-- /////////////////////////////////////////////////// -->
            <!-- GLOBAL -->

            <?= $this->render('_home_home_global', [
                'logoTop'       => $logoTop,
                'logoDown'      => $logoDown,
                'description'   => $description,
                'keyword'       => $keyword,
            ]) ?>            

            <!-- /////////////////////////////////////////////////// -->
            <!-- /////////////////////////////////////////////////// -->
            <!-- /////////////////////////////////////////////////// -->
            <!-- REVOLUTION SLIDER -->

            <hr>

            <?= $this->render('_home_slider', [
                'slider1_Image' => $slider1_Image,
                'slider1_Header'=>$slider1_Header,
                'slider1_Caption'=>$slider1_Caption,
                'slider2_Image' => $slider2_Image,
                'slider2_Header'=>$slider2_Header,
                'slider2_Caption'=>$slider2_Caption,

            ]) ?>

            <!-- /////////////////////////////////////////////////// -->
            <!-- /////////////////////////////////////////////////// -->
            <!-- /////////////////////////////////////////////////// -->
            <!-- ICON BLOCK -->

            <hr>

            <?= $this->render('_home_icon_block', [
                'iconBlock1_Icon'       => $iconBlock1_Icon,
                'iconBlock1_Header'     => $iconBlock1_Header,
                'iconBlock1_Caption'    => $iconBlock1_Caption,
                'iconBlock2_Icon'       => $iconBlock2_Icon,
                'iconBlock2_Header'     => $iconBlock2_Header,
                'iconBlock2_Caption'    => $iconBlock2_Caption,
                'iconBlock3_Icon'       => $iconBlock3_Icon,
                'iconBlock3_Header'     => $iconBlock3_Header,
                'iconBlock3_Caption'    => $iconBlock3_Caption,
            ]) ?>            

            <!-- /////////////////////////////////////////////////// -->
            <!-- /////////////////////////////////////////////////// -->
            <!-- /////////////////////////////////////////////////// -->
            <!-- ABOUT COMPANY -->

            <hr>

            <?= $this->render('_home_about_company', [
                'ourCompany_Header'   => $ourCompany_Header,
                'ourCompany_Caption'  => $ourCompany_Caption,
                'ourCompany_Image'    => $ourCompany_Image,
            ]) ?>      

            <!-- /////////////////////////////////////////////////// -->
            <!-- /////////////////////////////////////////////////// -->
            <!-- /////////////////////////////////////////////////// -->
            <!-- RECENT PROJECT -->

            <hr>

            <?= $this->render('_home_recent_project', [
                'ourRecent_Header'      => $ourRecent_Header,
                'ourRecent_Caption'     => $ourRecent_Caption,
                'products'              => $products
            ]) ?>      

            <!-- /////////////////////////////////////////////////// -->
            <!-- /////////////////////////////////////////////////// -->
            <!-- /////////////////////////////////////////////////// -->
            <!-- LATEST NEWS -->

            <hr>

            <?= $this->render('_home_latest_news', [
                'ourLatest_Header'      => $ourLatest_Header,
                'ourLatest_Caption'     => $ourLatest_Caption,
                'blogs'                 => $blogs
            ]) ?>   

            <!-- /////////////////////////////////////////////////// -->
            <!-- /////////////////////////////////////////////////// -->
            <!-- /////////////////////////////////////////////////// -->
            <!-- CALL TO ACTION -->

            <hr>


            <?= $this->render('_home_call_to_action', [
                'callToAction_Caption'  => $callToAction_Caption,
                'callToAction_Text'     => $callToAction_Text,
                'callToAction_Link'     => $callToAction_Link
            ]) ?>   

        </div>
    </div>

</div>