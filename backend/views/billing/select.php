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
                    {return Html::a($model->enrolment->title, $model->enrolment->getUrl());}
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
                'attribute' => 'address',
                'label' => 'Alamat',
                'format'=>'html',
                'value' => function($model){
                    if ($model->customer_id)
                    {return $model->customer->address;}
                    else
                    {return NULL;}
                },                
            ],                          
                             
            [
                'attribute' => 'title',
                'label'=>'Invoice',
                'format'=>'html',
                'value' => function($model){
                    if ($model->invoice)
                    {return Html::a($model->invoice, $model->getUrl());}
                    else
                    {return NULL;}
                },                
            ],             
            
            'month_period',     
            [
                'attribute' => 'amount',
                'format' => ['decimal'],
            ], 
            [
                    'attribute' => 'billing_type',
                    'format'=>'html',
                    'value' => function($model){
                        if ($model->billing_type)
                        {return $model->getOneBillingType($model->billing_type);}
                        else
                        {return NULL;}
                    },
                    'filterType' => GridView::FILTER_SELECT2,
                    'filter' => $billingTypeList,
                    'filterWidgetOptions' => [
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    'filterInputOptions' => ['placeholder' => 'Billing', 'id' => 'grid-outlet-search-billing_type']
            ],
            [
                    'attribute' => 'payment_status',
                    'format'=>'html',
                    'value' => function($model){
                        if ($model->payment_status)
                        {return $model->getOnePaymentStatus($model->payment_status);}
                        else
                        {return NULL;}
                    },
                    'filterType' => GridView::FILTER_SELECT2,
                    'filter' => $paymentStatusList,
                    'filterWidgetOptions' => [
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    'filterInputOptions' => ['placeholder' => 'Billing', 'id' => 'grid-outlet-search-payment_status']
            ],                        
      
            [
                'label' => ucfirst($module),
                'vAlign'=>'middle',
                'format' => 'raw',
                'contentOptions' => ['class' => 'text-center'],
                'value'=> function ($model) use ($module)  { 
                    return Html::a('<i class="fa fa-refresh"></i>',
                            Yii::$app->urlManager->createUrl([$module.'/create', 'id' => $model->customer_id]),
                            [
                                'title' => Yii::t('yii', 'Proses'),
                                'class'=>'btn btn-sm btn-info',
                            ]);
                },                
            ], 
        ],
        'responsive' => true,
        'hover' => true,
        'condensed' => true,
        'floatHeader' => true,

        'panel' => [
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> Select '.Html::encode($this->title).' </h3>',
            'type' => 'info',
            //'before' => Html::a('<i class="glyphicon glyphicon-plus"></i> Create', ['review'], ['class' => 'btn btn-success']),
            'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
            'showFooter' => false
        ],
    ]); Pjax::end(); ?>

</div>
