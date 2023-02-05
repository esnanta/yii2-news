<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\models\BillingSearch $searchModel
 */

$this->title = 'Billings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="billing-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php /* echo Html::a('Create Billing', ['create'], ['class' => 'btn btn-success'])*/  ?>
    </p>

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'customer_title',
                'label' => 'Customer',
                'format'=>'html',
                'value' => function($model){
                    if ($model->customer_id)
                    {return Html::a($model->customer->title, $model->customer->getUrl());}
                    else
                    {return NULL;}
                },                
            ],            
            
            [
                'attribute' => 'customer_number',
                'label' => 'Nomor',
                'format'=>'html',
                'value' => function($model){
                    if ($model->customer_id)
                    {return Html::a($model->enrolment->title, $model->customer->getUrl());}
                    else
                    {return NULL;}
                },                
            ],        
                        
            [
                'attribute' => 'phone_number',
                'label' => 'Telpon',
                'format'=>'html',
                'value' => function($model){
                    if ($model->customer_id)
                    {return $model->customer->phone_number;}
                    else
                    {return NULL;}
                },                
            ],                       
            [
                'attribute' => 'month_period',
                'format'=>'html',
                'value' => function($model){
                    if ($model->month_period)
                    {return $model->month_period;}
                    else
                    {return NULL;}
                },                
            ],                             
            [
                'attribute' => 'amount',
                'format' => ['decimal'],
            ], 
            [
                'attribute'=>'area_id', 
                'format'=>'html',
                'vAlign'=>'middle',
                //'width'=>'180px',
                'value'=>function ($model, $key, $index, $widget) { 
                    return ($model->area_id!=null) ? $model->area->title:'';
                },
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>$areaList, 
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>''],
                'format'=>'raw'
            ],                          
            [
                    'attribute' => 'billing_type',
                    'format'=>'html',
                    //'label' => 'Jenis',
                    'value' => function($model){
                        if ($model->billing_type)
                        {return ($model->billing_type!=null) ? $model->getOneBillingType($model->billing_type):'';}
                        else
                        {return NULL;}
                    },
                    'filterType' => GridView::FILTER_SELECT2,
                    'filter' => $billingTypeList,
                    'filterWidgetOptions' => [
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    'filterInputOptions' => ['placeholder' => 'Tagihan', 'id' => 'grid-outlet-search-billing_type']
            ],
            [
                    'attribute' => 'payment_status',
                    'format'=>'html',
                    'label' => 'Status',
                    'value' => function($model){
                        if ($model->payment_status)
                        {return ($model->payment_status!=null) ? $model->getOnePaymentStatus($model->payment_status):'';}
                        else
                        {return NULL;}
                    },
                    'filterType' => GridView::FILTER_SELECT2,
                    'filter' => $paymentStatusList,
                    'filterWidgetOptions' => [
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    'filterInputOptions' => ['placeholder' => 'Status', 'id' => 'grid-outlet-search-payment_status']
            ],                            
            [
                'attribute' => 'date_due_range',
                'value'=>'date_due',
                'format'=>'date',
                'options' => [
                    'format' => 'd-m-Y',
                ],
                'filterType' => GridView::FILTER_DATE_RANGE,
                'filterWidgetOptions' => ([
                    'attribute' => 'date_due_range',
                    'presetDropdown' => false,
                    'convertFormat' => true,
                    'pluginOptions'=>[
                        'locale'=>['format' => 'd-m-Y'],
                    ]                
                ])
            ],                                  
//            'date_issued', 
//            'date_due', 
//            'month_period',  
//            'description:ntext', 
//            'created_at:datetime', 
//            'updated_at:datetime', 
//            'created_by', 
//            'updated_by', 
//            'verlock', 

            [
                'class' => 'common\widgets\ActionColumn',
                'contentOptions' => ['style' => 'white-space:nowrap;'],
                'template'=>'{update} {view}',                
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                            Yii::$app->urlManager->createUrl(['billing/view', 'id' => $model->id, 'edit' => 't']),
                            [
                                'title' => Yii::t('yii', 'Edit'),
                                'class'=>'btn btn-sm btn-info',
                            ]
                        );
                    }
                ],
            ],
        ],
        'responsive' => true,
        'hover' => true,
        'condensed' => true,
        'floatHeader' => true,

        'panel' => [
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
            'type' => 'info',
            'before' => Html::a('<i class="glyphicon glyphicon-plus"></i> Create', ['/validity/index'], ['class' => 'btn btn-success']),
            'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
            'showFooter' => false
        ],
    ]); Pjax::end(); ?>

</div>
