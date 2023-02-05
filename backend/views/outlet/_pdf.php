<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\Outlet */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Outlet', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="outlet-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= 'Outlet'.' '. Html::encode($this->title) ?></h2>
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
        [
                'attribute' => 'staff.title',
                'label' => 'Staff'
            ],
        'title',
        'invoice',
        [
            'attribute' => 'date_issued',
            'format' => ['date'],
        ],
        [
            'attribute' => 'date_assembly',
            'format' => ['date'],
        ],        
        [
                'attribute' => 'billingStatus.title',
                'label' => 'Billing Status'
            ],
        [
            'attribute' => 'claim',
            'format' => ['decimal'],
        ],         
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
if($providerOutletDetail->totalCount){
    $gridColumnOutletDetail = [
        ['class' => 'yii\grid\SerialColumn'],
        ['attribute' => 'id', 'visible' => false],                
        [
                'attribute' => 'deviceType.title',
                'label' => 'Device Type'
        ],
        [
                'attribute' => 'deviceStatus.title',
                'label' => 'Device Status'
        ],
        [
            'attribute' => 'monthly_bill',
            'format' => ['decimal'],
        ],  
        [
            'attribute' => 'assembly_cost',
            'format' => ['decimal'],
        ],  
        ['attribute' => 'verlock', 'visible' => false],
    ];
    echo Gridview::widget([
        'dataProvider' => $providerOutletDetail,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => Html::encode('Outlet Detail'),
        ],
        'panelHeadingTemplate' => '<h4>{heading}</h4>{summary}',
        'toggleData' => false,
        'columns' => $gridColumnOutletDetail
    ]);
}
?>
    </div>
</div>
