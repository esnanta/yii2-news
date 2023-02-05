<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/**
 * @var yii\web\View $this
 * @var backend\models\Billing $model
 */

$this->title = 'Create Billing';
$this->params['breadcrumbs'][] = ['label' => 'Billings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Belum Dibuat <span class="label label-default"><?=$month;?></span>
            <span class="label label-primary"> <?= 'Data '.($outletProvider->getTotalCount()+$validityDetailProvider->getTotalCount());?></span>
            <span class="label label-danger"> <?= 'Nilai '.$totalClaim ?></span>
        </h3>
        <div class="pull pull-right">
                <?=
                    Html::a('<i class="glyphicon glyphicon-list"></i> ' . 'List Tagihan', 
                        ['/billing/index'],
                        [
                            'class' => 'btn btn-primary',
                            'data-toggle' => 'tooltip',
                            'title' => 'Index Validity Detail'
                        ]
                    ); 
                ?>               
            <?=             
                Html::a('<i class="glyphicon glyphicon-hand-up"></i> ' . 'Create Tagihan (1)', 
                    ['/enrolment/select','module'=>'billing'],
                    [
                        'class' => 'btn btn-primary',
                        'data-toggle' => 'tooltip',
                        'title' => 'Execute batch data'
                    ]
            )?>                 

            <?=             
                Html::a('<i class="glyphicon glyphicon-refresh"></i> ' . 'Create Tagihan ('.Yii::$app->params['Data_Query_Limit'].')', 
                    ['batch','month'=>$month],
                    [
                        'class' => 'btn btn-primary',
                        'data-toggle' => 'tooltip',
                        'title' => 'Execute batch data'
                    ]
            )?> 
        </div>        
        
    </div>
    <!--/////////////////////////////////////////////////////////////////////-->
    <!--/////////////////////////////////////////////////////////////////////-->
    <!--/////////////////////////////////////////////////////////////////////-->
    <div class="box box-body">
        <?php Pjax::begin(); echo GridView::widget([
            'dataProvider' => $outletProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                        'attribute' => 'title',
                        'label' => 'Title',
                        'format'=>'html',
                        'value' => function($model){
                            if ($model->title)
                            {return Html::a($model->title, $model->getUrl());}
                            else
                            {return NULL;}
                        },      
                ],  
                                
                'invoice',
                                
                [
                        'attribute' => 'customer_id',
                        'label' => 'Customer',
                        'format'=>'html',
                        'value' => function($model){
                            if ($model->customer)
                            {return Html::a($model->customer->title, $model->customer->getUrl());}
                            else
                            {return NULL;}
                        },      
                ],  
                [
                    'attribute' => 'date_issued',
                    'format'=>'date',
                    'options' => [
                        'format' => 'd-m-Y',
                    ],
                ],                                                                                                                                                 
                [
                    'attribute' => 'claim',
                    'format' => ['decimal'],
                ],  
                [
                        'attribute' => 'assembly_type',
                        'label'=>'Assembly',
                        'format'=>'html',
                        'value' => function($model){
                            if ($model->assembly_type)
                            {return $model->getOneAssemblyType($model->assembly_type);}
                            else
                            {return NULL;}
                        },      
                ],                                                 
                [
                        'attribute' => 'billing_status',
                        'label'=>'Billing',
                        'format'=>'html',
                        'value' => function($model){
                            if ($model->billing_status)
                            {return $model->getOneBillingStatus($model->billing_status);}
                            else
                            {return NULL;}
                        },      
                ],  


            ],
            'responsive' => true,
            'hover' => true,
            'condensed' => true,
            'floatHeader' => true,

            'panel' => [
                'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.'Tagihan Outlet ('. $outletProvider->getTotalCount().') </h3>',
                'type' => 'default',
                'showFooter' => false
            ],
        ]); Pjax::end(); ?>        
    </div>
    <!--/////////////////////////////////////////////////////////////////////-->
    <!--/////////////////////////////////////////////////////////////////////-->
    <!--/////////////////////////////////////////////////////////////////////-->
    <div class="box box-body">
        <?php Pjax::begin(); echo GridView::widget([
            'dataProvider' => $validityDetailProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],                
                [
                    'attribute'=>'validity_id', 
                    'value'=>function ($model, $key, $index, $widget) { 
                        return (!empty($model->validity_id)) ? Html::a($model->validity->title, $model->getUrl()):'';
                    },
                    'format'=>'html'
                ],                          
                [
                    'attribute'=>'customer_id', 
                    'label' => 'Customer',
                    'value'=>function ($model, $key, $index, $widget) { 
                        return (!empty($model->customer_id)) ? Html::a($model->customer->title, $model->customer->getUrl()):'';
                    },
                    'format'=>'html'
                ],                             
                [
                    'attribute' => 'date_due',
                    'format'=>'date',
                    'options' => [
                        'format' => 'd-m-Y',
                    ],
                ],
                [
                    'attribute'=>'description', 
                    'value'=>function ($model, $key, $index, $widget) { 
                        return (!empty($model->description)) ? $model->description : '';
                    },
                    'format'=>'html'
                ],                               
                [
                    'attribute' => 'amount',
                    'format' => ['decimal'],
                ],
                [
                    'attribute'=>'device_status', 
                    'label'=>'Device',
                    'value'=>function ($model, $key, $index, $widget) { 
                        return (!empty($model->device_status)) ? $model->getOneDeviceStatus($model->device_status):'';
                    },
                    'format'=>'html'
                ],                             
                [
                    'attribute'=>'billing_status', 
                    'label'=>'Billing',
                    'value'=>function ($model, $key, $index, $widget) { 
                        return (!empty($model->billing_status)) ? $model->getOneBillingStatus($model->billing_status):'';
                    },
                    'format'=>'html'
                ], 
            ],
            'responsive' => true,
            'hover' => true,
            'condensed' => true,
            'floatHeader' => true,

            'panel' => [
                'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.'Tagihan Iuran : ('.$validityDetailProvider->getTotalCount().') </h3>',
                'type' => 'default',
                'showFooter' => false
            ],
        ]); Pjax::end(); ?>        
    </div>
</div>













