<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\Gmap */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Gmap', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gmap-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= 'Gmap'.' '. Html::encode($this->title) ?></h2>
        </div>
    </div>

    <div class="row">
<?php 
    $gridColumn = [
        ['attribute' => 'id', 'visible' => false],
        [
                'attribute' => 'customer.title',
                'label' => 'Customer'
            ],
        'latitude',
        'longitude',
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
if($providerGmapDetail->totalCount){
    $gridColumnGmapDetail = [
        ['class' => 'yii\grid\SerialColumn'],
        ['attribute' => 'id', 'visible' => false],
                'latitude',
        'longitude',
        'description:ntext',
        ['attribute' => 'verlock', 'visible' => false],
    ];
    echo Gridview::widget([
        'dataProvider' => $providerGmapDetail,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => Html::encode('Gmap Detail'),
        ],
        'panelHeadingTemplate' => '<h4>{heading}</h4>{summary}',
        'toggleData' => false,
        'columns' => $gridColumnGmapDetail
    ]);
}
?>
    </div>
</div>
