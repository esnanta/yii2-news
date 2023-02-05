<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\Gmap */

$this->title = $model->customer->title;
$this->params['breadcrumbs'][] = ['label' => 'Gmap', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gmap-view">

    <div class="row">
        <div class="col-sm-8">
            <h2><?= 'Gmap'.' '. Html::encode($this->title) ?></h2>
        </div>
        <div class="col-sm-4" style="margin-top: 15px">
            <?= Html::a('Create', ['/customer/select','module'=>'gmap'], ['class' => 'btn btn-primary']) ?>
            <?=             
             Html::a('<i class="glyphicon glyphicon-hand-up"></i> ' . 'PDF', 
                ['pdf', 'id' => $model->id],
                [
                    'class' => 'btn btn-danger',
                    'target' => '_blank',
                    'data-toggle' => 'tooltip',
                    'title' => 'Will open the generated PDF file in a new window'
                ]
            )?>
            
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ])
            ?>
        </div>
    </div>


    <?= DetailView::widget([
        'model' => $model,
        'condensed' => false,
        'hover' => true,
        'mode' => Yii::$app->request->get('edit') == 't' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
        'panel' => [
            'heading' => $this->title,
            'type' => DetailView::TYPE_INFO,
        ],
        'attributes' => [

            [
                'attribute'=>'customer_id', 
                'value'=>($model->customer_id!=null) ? Html::a($model->customer->title, $model->customer->getUrl()):'',
                'format'=>'html',
                'type'=>DetailView::INPUT_DROPDOWN_LIST, 
                'options' => ['id' => 'customer_id', 'prompt' => ''],
                'items' => $customerList,
                'widgetOptions'=>[
                    'data'=>$customerList,
                ]                
            ],               

            'latitude',
            'longitude',
            'description:ntext',
        ],
        'deleteOptions' => [
            'url' => ['delete', 'id' => $model->id],
        ],
        'enableEditMode' => false,
    ]) ?>    
    
   

    <?php
//        if($providerGmapDetail->totalCount){
//            $gridColumnGmapDetail = [
//                ['class' => 'yii\grid\SerialColumn'],
//                    ['attribute' => 'id', 'visible' => false],
//                                'latitude',
//                    'longitude',
//                    'description:ntext',
//                    ['attribute' => 'verlock', 'visible' => false],
//            ];
//            echo Gridview::widget([
//                'dataProvider' => $providerGmapDetail,
//                'pjax' => true,
//                'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-tx-gmap-detail']],
//                'panel' => [
//                    'type' => GridView::TYPE_PRIMARY,
//                    'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode('Gmap Detail'),
//                ],
//                'columns' => $gridColumnGmapDetail
//            ]);
//        }
    ?>


</div>



<?= $this->render('_map', [
    'model' => $model,
    'office'=>$office
]) ?>