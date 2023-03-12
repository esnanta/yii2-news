<?php
use yii\helpers\Html;

use backend\models\Office;
use backend\models\SiteLink;
use backend\models\SocialMedia;
use backend\models\ThemeDetail;

/**
 * @var yii\web\View $this
 * @var backend\models\ThemeDetail $model
 */

$this->title = 'HOME LAYOUT';
$this->params['breadcrumbs'][] = ['label' => 'ThemeDetails', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

//GOLOBAL PARAM
$logoTop                = ThemeDetail::getByToken(Yii::$app->params['ContentToken_Logo1']);
$logoDown               = ThemeDetail::getByToken(Yii::$app->params['ContentToken_Logo2']);
$description            = ThemeDetail::getByToken(Yii::$app->params['ContentToken_Description']);
$keyword                = ThemeDetail::getByToken(Yii::$app->params['ContentToken_Keyword']);

$office                 = Office::findOne(1);
$siteLinks              = SiteLink::find()->orderBy(['sequence'=>SORT_ASC])->all();
$socialMedias           = SocialMedia::find()->orderBy(['title'=>SORT_ASC])->all();
?>

<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Home Layout</h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-4">
                <?= $logoTop->description;?> / <?= Html::a('<i class="fa fa-pencil"></i> Update', ['theme-detail/update-image','id'=>$logoTop->id,'title'=>$logoTop->title]);?>
                <br>
                <?= Html::img($logoTop->getImageUrl(), ['class' => 'img-responsive'], ['alt' => 'Logo']);?>
            </div>
            <div class="col-md-4">
                <center>S E A R C H</center> 
            </div>
            <div class="col-md-4">
                <center>D A S H B O A R D / A D M I N</center>
            </div>
        </div>
        
        <hr>
        
        <div class="row">
            <div class="col-md-12">
                <center>B L O G S / P O S T I N G S</center>
            </div>
        </div>
        
        <hr>
        
        <div class="row">
            <div class="col-md-4">
                Links / <?= Html::a('Index', ['site-link/index']);?> <br>
                <?php
                    foreach ($siteLinks as $model) {
                        $edit = Html::a('<i class="fa fa-pencil"></i>', ['site-link/update','id'=>$model->id,'title'=>$model->title]);
                        echo $edit.' '.Html::a($model->title, $model->url).'<br>';
                    }
                ?>
            </div>
            <div class="col-md-4">
                <center>B L O G S / P O S T I N G S</center>
            </div>
            <div class="col-md-4">
                O F F I C E / <?= Html::a('<i class="fa fa-pencil"></i> Update', ['office/update','id'=>$office->id,'title'=>$office->title]);?><br> 
                <?=$office->title;?><br>
                <?=$office->phone_number;?><br>
                <?=$office->email;?><br>
                <?=$office->address;?><br>
            </div>
        </div>
        
        <hr>
        
        <div class="row">
            <div class="col-md-4">
                <?= $logoDown->description;?> / <?= Html::a('<i class="fa fa-pencil"></i> Update', ['theme-detail/update-image','id'=>$logoDown->id,'title'=>$logoDown->title]);?>
                <br>
                <?= Html::img($logoDown->getImageUrl(), ['class' => 'img-responsive'], ['alt' => 'Logo']);?>
            </div>
            <div class="col-md-8">
                <center>Social Media</center> 
                <?php 
                    foreach ($socialMedias as $socialMediaModel) {
                ?>
                    <center>
                        <?=Html::a('<i class="fa fa-pencil"></i> ', 
                            ['social-media/update','id'=>$socialMediaModel->id,'title'=>$socialMediaModel->title])
                            . $socialMediaModel->title;?>
                    </center> 
                <?php
                    }
                ?>
                
            </div>
        </div>
        
    </div>
</div>



