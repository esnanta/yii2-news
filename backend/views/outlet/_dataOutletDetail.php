<?php
use kartik\grid\GridView;
use yii\data\ArrayDataProvider;

    $dataProvider = new ArrayDataProvider([
        'allModels' => $model->outletDetails,
        'key' => 'id'
    ]);
    $gridColumns = [
        ['class' => 'yii\grid\SerialColumn'],
        ['attribute' => 'id', 'visible' => false],       
        [
                'attribute' => 'device_type',
                'label' => 'Type',
                'format'=>'html',
                'value'=>function ($model, $key, $index, $widget) { 
        
                    $returnValue =(!empty($model->device_type)) ? 
                        $model->getOneDeviceType($model->device_type) : '-';          
        
                    return (!empty($returnValue)) ? $returnValue:'-';
                },                         
        ],
        [
                'attribute' => 'device_status',
                'label' => 'Status',
                'format'=>'html',
                'value'=>function ($model, $key, $index, $widget) { 
                    
                    $returnValue =(!empty($model->device_status)) ? 
                        $model->getOneDeviceStatus($model->device_status) : '-';                              
                    
                    return (!empty($returnValue)) ? $returnValue:'-';
                },             
        ],
        [
            'attribute' => 'assembly_cost',
            'format' => ['decimal'],
        ], 
        [
            'attribute' => 'monthly_bill',
            'format' => ['decimal'],
        ],         
        ['attribute' => 'verlock', 'visible' => false],
    ];
    
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumns,
        'containerOptions' => ['style' => 'overflow: auto'],
        'pjax' => true,
        'beforeHeader' => [
            [
                'options' => ['class' => 'skip-export']
            ]
        ],
        'export' => [
            'fontAwesome' => true
        ],
        'bordered' => true,
        'striped' => true,
        'condensed' => true,
        'responsive' => true,
        'hover' => true,
        'showPageSummary' => false,
        'persistResize' => false,
    ]);
