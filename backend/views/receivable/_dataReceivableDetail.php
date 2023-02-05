<?php
use kartik\grid\GridView;
use yii\data\ArrayDataProvider;

    $dataProvider = new ArrayDataProvider([
        'allModels' => $model->receivableDetails,
        'key' => 'id'
    ]);
    $gridColumns = [
        ['class' => 'yii\grid\SerialColumn'],
        ['attribute' => 'id', 'visible' => false],
        [
                'attribute' => 'billing.title',
                'label' => 'Billing'
        ],
        'title',
        [
            'attribute' => 'date_due',
            'format' => 'date',
        ],        
        'overdue',
        [
            'attribute' => 'accuracy_status',
            'format'=>'html', 
            'value'=>function ($model, $key, $index, $widget) { 

                $returnValue =(!empty($model->accuracy_status)) ? 
                        $model->getOneAccuracyStatus($model->accuracy_status) : '-';                         

                return (!empty($returnValue)) ? $returnValue:'-';
            },                                 
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
