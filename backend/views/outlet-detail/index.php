<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\models\OutletDetailSearch $searchModel
 */

$this->title = 'Outlet Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="outlet-detail-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php /* echo Html::a('Create Outlet Detail', ['create'], ['class' => 'btn btn-success'])*/  ?>
    </p>

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'id',
            [
                'attribute' => 'invoice',
                'label' => 'Invoice',
                'format'=>'html',
                'value' => function($model){
                    if ($model->outlet_id)
                    {return $model->outlet->invoice;}
                    else
                    {return NULL;}
                },                
            ],   
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
                'attribute' => 'assembly_cost',
                'format' => ['decimal'],
            ], 
            [
                'attribute' => 'monthly_bill',
                'format' => ['decimal'],
            ],                         
            [
                    'attribute' => 'device_type',
                    'format'=>'html',
                    'value' => function($model){
                        if ($model->device_type)
                        {return $model->getOneDeviceType($model->device_type);}
                        else
                        {return NULL;}
                    },
                    'filterType' => GridView::FILTER_SELECT2,
                    'filter' => $deviceTypeList,
                    'filterWidgetOptions' => [
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    'filterInputOptions' => ['placeholder' => 'Jenis', 'id' => 'grid-outlet-search-device_type']
            ], 
            [
                    'attribute' => 'device_status',
                    'format'=>'html',
                    'value' => function($model){
                        if ($model->device_status)
                        {return $model->getOneDeviceStatus($model->device_status);}
                        else
                        {return NULL;}
                    },
                    'filterType' => GridView::FILTER_SELECT2,
                    'filter' => $deviceStatusList,
                    'filterWidgetOptions' => [
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    'filterInputOptions' => ['placeholder' => 'Jenis', 'id' => 'grid-outlet-search-device_status']
            ],                             

            [
                'class' => 'common\widgets\ActionColumn',
                'contentOptions' => ['style' => 'white-space:nowrap;'],
                'template'=>'{view}',
            ],
        ],
        'responsive' => true,
        'hover' => true,
        'condensed' => true,
        'floatHeader' => true,

        'panel' => [
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
            'type' => 'info',
            'before' => Html::a('<i class="glyphicon glyphicon-plus"></i> Add', ['create'], ['class' => 'btn btn-success']),
            'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
            'showFooter' => false
        ],
    ]); Pjax::end(); ?>

</div>
