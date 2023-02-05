<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\Service */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Service', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="service-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= 'Service'.' '. Html::encode($this->title) ?></h2>
        </div>
    </div>

    <div class="row">
<?php 
    $gridColumn = [
        ['attribute' => 'id', 'visible' => false],
        'customer_id',
        'staff_id',
        'title',
        'date_issued',
        'date_effective',
        'description:ntext',
        ['attribute' => 'verlock', 'visible' => false],
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]); 
?>
    </div>
    
    <div class="row">
<?php
if($providerServiceDetail->totalCount){
    $gridColumnServiceDetail = [
        ['class' => 'yii\grid\SerialColumn'],
        ['attribute' => 'id', 'visible' => false],
                [
                'attribute' => 'outletDetail.id',
                'label' => 'Outlet Detail'
            ],
        [
                'attribute' => 'serviceReason.title',
                'label' => 'Service Type'
            ],
    ];
    echo Gridview::widget([
        'dataProvider' => $providerServiceDetail,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => Html::encode('Service Detail'),
        ],
        'panelHeadingTemplate' => '<h4>{heading}</h4>{summary}',
        'toggleData' => false,
        'columns' => $gridColumnServiceDetail
    ]);
}
?>
    </div>
</div>
