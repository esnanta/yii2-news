<?php
use kartik\grid\GridView;
use yii\data\ArrayDataProvider;

    $dataProvider = new ArrayDataProvider([
        'allModels' => $model->serviceDetails,
        'key' => 'id'
    ]);
    $gridColumns = [
        ['class' => 'yii\grid\SerialColumn'],
        ['attribute' => 'id', 'visible' => false],
        [
                'attribute' => 'outletDetail.id',
                'label' => 'Outlet Detail'
        ],
        [
                'attribute' => 'service_reason_id',
                'value'=>function ($model, $key, $index, $widget) { 
                    
                    $returnValue =(!empty($model->service_reason_id)) ? 
                        $model->serviceReason->title : '-';                         
                    
                    return (!empty($returnValue)) ? $returnValue:'-';
                },              
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'controller' => 'service-detail'
        ],
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
