<?php
use yii\helpers\Html;
use kartik\detail\DetailView;
use bajadev\ckeditor\CKEditor;
use kartik\widgets\FileInput;
use yii\data\ActiveDataProvider;

use backend\models\Blog as Blog;
use backend\models\ThemeDetail as ThemeDetail;
use backend\models\Product as Product;

/**
 * @var yii\web\View $this
 * @var backend\models\ThemeDetail $model
 */

$this->title = 'test';
$this->params['breadcrumbs'][] = ['label' => 'ThemeDetails', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

//GOLOBAL PARAM
$logoTop            = ThemeDetail::getByToken(Yii::$app->params['ThemeDetailToken_Logo1']);
$logoDown           = ThemeDetail::getByToken(Yii::$app->params['ThemeDetailToken_Logo2']);
$description        = ThemeDetail::getByToken(Yii::$app->params['ThemeDetailToken_Description']);
$keyword            = ThemeDetail::getByToken(Yii::$app->params['ThemeDetailToken_Keyword']);

//LOCAL PARAM
$layerNR1           = ThemeDetail::findOne(['token'=>'101']);
$layerNR2           = ThemeDetail::findOne(['token'=>'102']);
$layerNR3           = ThemeDetail::findOne(['token'=>'103']);
$layerNR4           = ThemeDetail::findOne(['token'=>'104']);
$layerNR5           = ThemeDetail::findOne(['token'=>'105']);
$layerNR6           = ThemeDetail::findOne(['token'=>'106']);
$layerNR7           = ThemeDetail::findOne(['token'=>'107']);
$layerNR8           = ThemeDetail::findOne(['token'=>'108']);

$iconBlock1         = ThemeDetail::findOne(['token'=>'115']);
$iconBlock2         = ThemeDetail::findOne(['token'=>'116']);
$iconBlock3         = ThemeDetail::findOne(['token'=>'117']);

$aboutOurCompany    = ThemeDetail::findOne(['token'=>'109']);
$ourRecentProject   = ThemeDetail::findOne(['token'=>'110']);
$ourLatestNews      = ThemeDetail::findOne(['token'=>'111']);

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
$blogQuery = Blog::find()->limit(3);

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
<div class="theme-detail-view">

    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">H O M E</h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="box-header with-border">
                        <h3 class="box-title">Logo Atas</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <ul class="list-unstyled">
                            <li class="list-group-item">
                                <?=Html::a('<i class="fa fa-pencil"></i>', ['/theme-detail/update','id'=>$logoTop->id],['class'=>'pull-right']);?>
                                <?= Html::img($logoTop->getImageUrl(), ['style'=>'width:200px;height:40px'],['alt' => 'alt image']);;?>
                            </li>
                        </ul>
                    </div>

                </div>
                <div class="col-md-4">
                    <div class="box-header with-border">
                        <h3 class="box-title">Description</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <ul class="list-unstyled">
                            <li class="list-group-item">
                                <?=Html::a('<i class="fa fa-pencil"></i>', ['/theme-detail/update','id'=>$description->id],['class'=>'pull-right']);?>
                                <?= $description->theme-detail;?>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="box-header with-border">
                        <h3 class="box-title">Keyword</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <ul class="list-unstyled">
                            <li class="list-group-item">
                                <?=Html::a('<i class="fa fa-pencil"></i>', ['/theme-detail/update','id'=>$keyword->id],['class'=>'pull-right']);?>
                                <?= $keyword->theme-detail;?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <hr>

            <!-- /////////////////////////////////////////////////// -->
            <!-- /////////////////////////////////////////////////// -->
            <!-- /////////////////////////////////////////////////// -->
            <!-- REVOLUTION SLIDER -->

            <div class="row">
                <div class="col-md-6">
                    <div class="box-header with-border">
                        <h3 class="box-title">Revolution Slider 1</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <ul class="list-unstyled">
                            <li class="list-group-item">
                                <?=Html::a('<i class="fa fa-pencil"></i>', ['/theme-detail/update','id'=>$layerNR1->id],['class'=>'pull-right']);?>
                                <?= $layerNR1->theme-detail;?>
                            </li>
                            <li class="list-group-item">
                                <?=Html::a('<i class="fa fa-pencil"></i>', ['/theme-detail/update','id'=>$layerNR2->id],['class'=>'pull-right']);?>
                                <?= Html::img($layerNR2->getImageUrl(), ['style'=>'width:200px;height:40px'],['alt' => 'alt image']);;?>
                            </li>
                            <li class="list-group-item">
                                <?=Html::a('<i class="fa fa-pencil"></i>', ['/theme-detail/update','id'=>$layerNR3->id],['class'=>'pull-right']);?>
                                <?= $layerNR3->theme-detail;?>
                            </li>
                            <li class="list-group-item">
                                <?=Html::a('<i class="fa fa-pencil"></i>', ['/theme-detail/update','id'=>$layerNR4->id],['class'=>'pull-right']);?>
                                <?= $layerNR4->theme-detail;?>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="box-header with-border">
                        <h3 class="box-title">Revolution Slider 1</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <ul class="list-unstyled">
                            <li class="list-group-item">
                                <?=Html::a('<i class="fa fa-pencil"></i>', ['/theme-detail/update','id'=>$layerNR5->id],['class'=>'pull-right']);?>
                                <?= $layerNR5->theme-detail;?>
                            </li>
                            <li class="list-group-item">
                                <?=Html::a('<i class="fa fa-pencil"></i>', ['/theme-detail/update','id'=>$layerNR6->id],['class'=>'pull-right']);?>
                                <?= Html::img($layerNR6->getImageUrl(), ['style'=>'width:200px;height:40px'],['alt' => 'alt image']);;?>
                            </li>
                            <li class="list-group-item">
                                <?=Html::a('<i class="fa fa-pencil"></i>', ['/theme-detail/update','id'=>$layerNR7->id],['class'=>'pull-right']);?>
                                <?= $layerNR7->theme-detail;?>
                            </li>
                            <li class="list-group-item">
                                <?=Html::a('<i class="fa fa-pencil"></i>', ['/theme-detail/update','id'=>$layerNR8->id],['class'=>'pull-right']);?>
                                <?= $layerNR8->theme-detail;?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <hr>

            <!-- /////////////////////////////////////////////////// -->
            <!-- /////////////////////////////////////////////////// -->
            <!-- /////////////////////////////////////////////////// -->
            <!-- ICON BLOCK -->

            <div class="row">
                <div class="col-md-4">
                    <div class="box-header with-border">
                        <h3 class="box-title">Icon Block 1</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <ul class="list-unstyled">
                            <li class="list-group-item">
                                <?=Html::a('<i class="fa fa-pencil"></i>', ['/theme-detail/update','id'=>$iconBlock1->id],['class'=>'pull-right']);?>
                                <?= htmlspecialchars($iconBlock1->icon);?>
                                <?= $iconBlock1->title;?>
                                <?= $iconBlock1->theme-detail;?>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="box-header with-border">
                        <h3 class="box-title">Icon Block 2</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <ul class="list-unstyled">
                            <li class="list-group-item">
                                <?=Html::a('<i class="fa fa-pencil"></i>', ['/theme-detail/update','id'=>$iconBlock2->id],['class'=>'pull-right']);?>
                                <?= htmlspecialchars($iconBlock2->icon);?>
                                <?= $iconBlock2->title;?>
                                <?= $iconBlock2->theme-detail;?>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="box-header with-border">
                        <h3 class="box-title">Icon Block 3</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <ul class="list-unstyled">
                            <li class="list-group-item">
                                <?=Html::a('<i class="fa fa-pencil"></i>', ['/theme-detail/update','id'=>$iconBlock3->id],['class'=>'pull-right']);?>
                                <?= htmlspecialchars($iconBlock3->icon);?>
                                <?= $iconBlock3->title;?>
                                <?= $iconBlock3->theme-detail;?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <hr>

            <!-- /////////////////////////////////////////////////// -->
            <!-- /////////////////////////////////////////////////// -->
            <!-- /////////////////////////////////////////////////// -->
            <!-- ABOUT COMPANY -->

            <div class="row">
                <div class="col-md-6">

                    <div class="box-header with-border">
                        <h3 class="box-title">About Company</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <ul class="list-unstyled">
                            <li class="list-group-item">
                                <?=Html::a('<i class="fa fa-pencil"></i>', ['/theme-detail/update','id'=>$aboutOurCompany->id],['class'=>'pull-right']);?>
                                <?=$aboutOurCompany->description;?>
                                <?=$aboutOurCompany->theme-detail;?>
                            </li>
                        </ul>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="box-header with-border">
                        <h3 class="box-title">Image</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <ul class="list-unstyled">
                            <li class="list-group-item">
                                <?=Html::a('<i class="fa fa-pencil"></i>', ['/theme-detail/update','id'=>$aboutOurCompany->id],['class'=>'pull-right']);?>
                                <?= Html::img($aboutOurCompany->getImageUrl(), ['style'=>'width:200px;height:40px'],['alt' => 'alt image']);;?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- /////////////////////////////////////////////////// -->
            <!-- /////////////////////////////////////////////////// -->
            <!-- /////////////////////////////////////////////////// -->
            <!-- RECENT PROJECT -->

            <hr>

            <div class="row">
                <div class="col-md-12">
                    <div class="box-header with-border">
                        <h3 class="box-title">RECENT PROJECT</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <ul class="list-unstyled">
                            <li class="list-group-item">
                                <?=Html::a('<i class="fa fa-pencil"></i>', ['/theme-detail/update','id'=>$ourRecentProject->id],['class'=>'pull-right']);?>
                                <?=$ourRecentProject->theme-detail;?>
                            </li>
                        </ul>
                    </div>
                </div>

                <?php
                    foreach ($products as $i => $productModel) {
                ?>
                        <div class="col-md-3">
                            <?=Html::img($productModel->getCoverUrl(), ['class' => 'img-responsive', 'alt'=>'Image description']);?>
                            <?=$productModel->title;?>
                            <?=$productModel->description;?>
                        </div>
                <?php
                    }
                ?>


            </div>

            <!-- /////////////////////////////////////////////////// -->
            <!-- /////////////////////////////////////////////////// -->
            <!-- /////////////////////////////////////////////////// -->
            <!-- LATEST NEWS -->

            <hr>

            <div class="row">
                <div class="col-md-12">
                    <div class="box-header with-border">
                        <h3 class="box-title">LATEST NEWS</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <ul class="list-unstyled">
                            <li class="list-group-item">
                                <?=Html::a('<i class="fa fa-pencil"></i>', ['/theme-detail/update','id'=>$ourLatestNews->id],['class'=>'pull-right']);?>
                                <?=$ourLatestNews->theme-detail;?>
                            </li>
                        </ul>
                    </div>
                </div>


                <?php
                    foreach ($blogs as $i => $blogModel) {
                ?>
                        <div class="col-md-4">
                            <div class="box-body">
                                <?=Html::img($blogModel->getCover($blogModel->theme-detail), ['class' => 'img-responsive', 'alt'=>'Image description']);?>
                                <?= Html::a($blogModel->title, $blogModel->getUrl()) ?>
                                <?=$blogModel->readMore(100);?>
                            </div>
                        </div>
                <?php
                    }
                ?>


            </div>


            <!-- /////////////////////////////////////////////////// -->
            <!-- /////////////////////////////////////////////////// -->
            <!-- /////////////////////////////////////////////////// -->
            <!-- CALL TO ACTION -->

            <hr>

            <div class="row">
                <div class="col-md-6">

                    <div class="box-header with-border">
                        <h3 class="box-title">CALL TO ACTION</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <ul class="list-unstyled">
                            <li class="list-group-item">
                                Text
                            </li>                                                      
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">

                    <div class="box-header with-border">
                        <h3 class="box-title">BUTTON</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <ul class="list-unstyled">
                            <li class="list-group-item">
                                Button caption
                            </li>
                            <li class="list-group-item">
                                Link
                            </li>                                                        
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>