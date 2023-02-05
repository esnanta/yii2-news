<?php
use yii\helpers\Html;

use backend\models\Office;
use backend\models\ThemeDetail;

/**
 * @var yii\web\View $this
 * @var backend\models\ThemeDetail $model
 */

$this->title = 'HOME LAYOUT';
$this->params['breadcrumbs'][] = ['label' => 'ThemeDetails', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


//PORTFOLIO7 REPORT
$logoReport1        = ThemeDetail::getByToken(Yii::$app->params['ContentToken_LogoReport_1']);
$logoReport2        = ThemeDetail::getByToken(Yii::$app->params['ContentToken_LogoReport_2']);
$descReport         = ThemeDetail::getByToken(Yii::$app->params['ContentToken_DescReport']);

$office             = Office::findOne(1);

?>



<div class="theme-detail-view">

    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">R E P O R T</h3>
        </div>
        <div class="panel-body">

            <div class="row">
                <div class="col-md-4">
                    <div class="box-header with-border">
                        <h3 class="box-title">Logo Report 1</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <ul class="list-unstyled">
                            <li class="list-group-item">
                                <?= Html::a('<i class="fa fa-eye"></i>', ['/theme-detail/view', 'id' => $logoReport1->id], ['class' => 'pull-right']); ?>
                                <?= Html::img($logoReport1->getImageUrl(), ['style' => 'width:200px;height:40px'], ['alt' => 'alt image']);?>
                            </li>
                        </ul>
                    </div>

                    <div class="box-header with-border">
                        <h3 class="box-title">Report Deskripsi</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <ul class="list-unstyled">
                            <li class="list-group-item">
                                <?= Html::a('<i class="fa fa-eye"></i>', ['/theme-detail/view', 'id' => $descReport->id], ['class' => 'pull-right']); ?>
                                <?= (empty($descReport->content)) ? 'NA' : $descReport->content; ?>
                            </li>
                        </ul>
                    </div>                    
                    
                </div>
                <div class="col-md-8">
                    <div class="box-header with-border">
                        <h3 class="box-title">Info Office</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <ul class="list-unstyled">
                            <li class="list-group-item">
                                <?= Html::a('<i class="fa fa-eye"></i>', ['/office/view', 'id' => $office->id], ['class' => 'pull-right']); ?>
                                <?= (empty($office->title)) ? 'NA' : $office->title; ?>
                            </li>
                            <li class="list-group-item">
                                <?= (empty($office->address)) ? 'NA' : $office->address; ?>
                            </li>   
                            <li class="list-group-item">
                                <?= (empty($office->phone_number)) ? 'NA' : '<i class="fa fa-phone"></i> '.$office->phone_number; ?>
                                <?= (empty($office->web)) ? 'NA' : '<i class="fa fa-globe"></i> '.$office->web; ?>
                            </li>                             
                        </ul>
                    </div>
                </div>
 
            </div>
  
            <hr>
            
        </div>
    </div>

</div>