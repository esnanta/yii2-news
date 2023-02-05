<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if ($providerOutletDetail->totalCount) { 
    Pjax::begin(); echo GridView::widget([
        'dataProvider' => $providerOutletDetail,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=>'invoice', 
                'format'=>'html',
                'vAlign'=>'middle',
                'width'=>'180px',
                'value'=>function ($model, $key, $index, $widget) { 
                    return ($model->id!=null) ? Html::a($model->outlet->invoice, $model->outlet->getUrl()):'';
                },
            ],
            [
                'attribute'=>'monthly_bill', 
                'format'=>'decimal',
            ],                         
            [
                'attribute'=>'assembly_cost', 
                'format'=>'decimal',
            ],                                             
            [
                'attribute'=>'device_type', 
                'format'=>'html',
                'vAlign'=>'middle',
                'width'=>'80px',
                'value'=>function ($model, $key, $index, $widget) { 
                    return ($model->device_type!=null) ? $model->getOneDeviceType($model->device_type):'';
                },
            ], 
            [
                'attribute'=>'device_status', 
                'format'=>'html',
                'vAlign'=>'middle',
                'width'=>'80px',
                'value'=>function ($model, $key, $index, $widget) { 
                    return ($model->device_status!=null) ? $model->getOneDeviceStatus($model->device_status):'';
                },
            ],  

            [
                'header'=>'Billed', 
                'format'=>'html',
                'vAlign'=>'middle',
                'width'=>'80px',
                'value'=>function ($model, $key, $index, $widget) { 
                    return (!empty($model->outlet->billing_status)) ? $model->outlet->getOneBillingStatus($model->outlet->billing_status):'';
                },
            ], 
                        
            [
                'header'=>'Description', 
                'format'=>'html',
                'vAlign'=>'middle',
                'value'=>function ($model, $key, $index, $widget) { 
                    return $model->outlet->checkBilling().' | '.$model->outlet->description.' ('.Yii::$app->formatter->asDecimal($model->outlet->claim).')';
                },
            ], 
        ],
        'responsive' => true,
        'hover' => true,
        'condensed' => true,
        'floatHeader' => true,

        'panel' => [
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> Outlet </h3>',
            'type' => 'primary',
            //'before' => Html::a('<i class="glyphicon glyphicon-plus"></i> Add', ['create'], ['class' => 'btn btn-success']),
            //'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
            'showFooter' => false
        ],
    ]); Pjax::end(); 
}

else{

    echo Html::a('<i class="glyphicon glyphicon-plus"></i> ' . 'Create Outlet',  
        ['/outlet/create','id'=>$model->id],
        [
            'class' => 'btn btn-primary',
            'data-toggle' => 'tooltip',
            'title' => 'Create Enrolment'
        ]
    ); 

}
    