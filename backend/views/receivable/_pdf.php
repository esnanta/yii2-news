<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\Receivable */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Receivable', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="receivable-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= 'Receivable'.' '. Html::encode($this->title) ?></h2>
        </div>
    </div>

    <div class="row">
<?php 
    $gridColumn = [
        ['attribute' => 'id', 'visible' => false],
            [
                'attribute'=>'customer_id', 
                'value'=>($model->customer_id!=null) ? Html::a($model->customer->title, $model->customer->getUrl()):'',
                'format'=>'html',               
            ],
            [
                'attribute'=>'staff_id', 
                'value'=>($model->staff_id!=null) ? Html::a($model->staff->title, $model->staff->getUrl()):'',
                'format'=>'html',               
            ],             

            'title',
            [
                'attribute'=>'invoice', 
                'format'=>'raw',                  
            ],              
            'month_period',
            [
                'attribute'=>'date_issued', 
                'format'=>'date',           
            ], 
    
            [
                'attribute'=>'description', 
                'format'=>'html',              
            ],          
            [
                'attribute' => 'total',
                'format' => ['decimal'],
            ],       
            [
                'attribute' => 'payment',
                'format' => ['decimal'],
            ],      
            [
                'attribute' => 'balance',
                'format' => ['decimal'],
            ],
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
if($providerReceivableDetail->totalCount){
    $gridColumnReceivableDetail = [
        ['class' => 'yii\grid\SerialColumn'],
        ['attribute' => 'id', 'visible' => false],
                [
                    'attribute' => 'billing_id',
                    'format' => ['html'],
                    'value' => function ($model){
                        return Html::a($model->billing->invoice, $model->billing->getUrl());
                    }
                ],            
            
                'title',
                [
                    'attribute' => 'date_due',
                    'format' => ['date'],
                ],         
                'overdue',
                [
                    'attribute' => 'accuracy_status',
                    'format' => ['html'],
                    'value' => function ($model){
                        return $model->overdueStatus->getLabel();
                    }
                ],
                [
                    'attribute' => 'claim',
                    'format' => ['decimal'],
                ],              
                [
                    'attribute' => 'penalty',
                    'format' => ['decimal'],
                ],  
                [
                    'attribute' => 'total',
                    'format' => ['decimal'],
                ], 
    ];
    echo Gridview::widget([
        'dataProvider' => $providerReceivableDetail,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => Html::encode('Receivable Detail'),
        ],
        'panelHeadingTemplate' => '<h4>{heading}</h4>{summary}',
        'toggleData' => false,
        'columns' => $gridColumnReceivableDetail
    ]);
}
?>
    </div>
</div>
