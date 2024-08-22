<?php
use yii\helpers\Html;
use kartik\detail\DetailView;
use yii\data\ActiveDataProvider;

use backend\models\Office;
use backend\models\Lookup;
use backend\models\Article;
use backend\models\Page;

/**
 * @var yii\web\View $this
 * @var common\models\Page $model
 */

$this->title = 'HOME LAYOUT';
$this->params['breadcrumbs'][] = ['label' => 'Pages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

//GOLOBAL PARAM
$logoTop                = Page::getByToken(Yii::$app->params['ContentToken_Logo1']);
$logoDown               = Page::getByToken(Yii::$app->params['ContentToken_Logo2']);
$description            = Page::getByToken(Yii::$app->params['ContentToken_Description']);
$keyword                = Page::getByToken(Yii::$app->params['ContentToken_Keyword']);

//PORTFOLIO7 THEME LAYOUT
$breadcrumb_Header      = Page::findOne(['token'=>'505']);
$portfolio7_Header      = Page::findOne(['token'=>'506']);
$portfolio7_Title       = Page::findOne(['token'=>'507']);
$portfolio7_Caption     = Page::findOne(['token'=>'508']);
$blog_Header            = Page::findOne(['token'=>'509']);

$office                 = Office::findOne(1);
/**
 * /////////////////////////////////////////////////////////////////////////////
 * B L O G S
 * /////////////////////////////////////////////////////////////////////////////
 */
$blogs = Article::find()->limit(3)
    ->where([
        'publish_status' => Article::PUBLISH_STATUS_YES
    ])
    ->orderBy(['created_at'=>SORT_DESC])
    ->all();
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
            <!-- BREADCRUMB -->
            
            <hr>
            
            <?= $this->render('_home_breadcrumb', [
                'breadcrumb_Header'       => $breadcrumb_Header,
            ]) ?>                
            
            <!-- /////////////////////////////////////////////////// -->
            <!-- /////////////////////////////////////////////////// -->
            <!-- /////////////////////////////////////////////////// -->
            <!-- PORTFOLIO SINGLE -->
            
            <hr>
            

            <?= $this->render('_home_portfolio_single', [
                'portfolio7_Header'     => $portfolio7_Header,
                'portfolio7_Title'      => $portfolio7_Title,
                'portfolio7_Caption'    => $portfolio7_Caption,
                'office'                => $office,
            ]) ?>             
            
            <!-- /////////////////////////////////////////////////// -->
            <!-- /////////////////////////////////////////////////// -->
            <!-- /////////////////////////////////////////////////// -->
            <!-- LATEST NEWS -->

            <hr>

            <?= $this->render('_home_latest_news', [
                'ourLatest_Header'      => $blog_Header,
                'blogs'                 => $blogs
            ]) ?> 

        </div>
    </div>

</div>