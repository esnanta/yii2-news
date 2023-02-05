<?php
use kartik\grid\GridView;
use yii\data\ArrayDataProvider;

    $dataProvider = new ArrayDataProvider([
        'allModels' => $model->accountPayableDetails,
        'key' => 'id'
    ]);
    $gridColumns = [
        ['class' => 'yii\grid\SerialColumn'],
        ['attribute' => 'id', 'visible' => false],
        [
            'attribute' => 'account_id',
            'value'=>function ($model, $key, $index, $widget) { 

                $returnValue =(!empty($model->account_id)) ? 
                    Yii::$app->cache->getOrSet(Yii::$app->params['Cache_Account'].$model->account_id, function () use ($model) { 
                        return $model->account->title;
                }) : '-';                         

                return (!empty($returnValue)) ? $returnValue:'-';
            },              
        ],        
        //'invoice',
        [
            'attribute' => 'amount',
            'format' => ['decimal'],
        ],   
        'commentary:ntext',
        ['attribute' => 'verlock', 'visible' => false],
//        [
//            'class' => 'yii\grid\ActionColumn',
//            'controller' => 'account-payable-detail'
//        ],
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
