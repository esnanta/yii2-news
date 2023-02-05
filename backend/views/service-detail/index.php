<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\models\ServiceDetailSearch $searchModel
 */

$this->title = 'Service Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="service-detail-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php /* echo Html::a('Create Service Detail', ['create'], ['class' => 'btn btn-success'])*/  ?>
    </p>

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'title',
                'label' => 'Service',
                'format'=>'html',
                'value' => function($model){
                    if ($model->service_id)
                    {return $model->service->title;}
                    else
                    {return NULL;}
                },                
            ],  
                        
            //'outlet_detail_id',
                        
            [
                    'attribute' => 'service_reason_id',
                    'label' => 'Alasan',
                    'format'=>'html',
                    'value' => function($model){
                        if ($model->service_reason_id)
                        {return $model->serviceReason->title;}
                        else
                        {return NULL;}
                    },
                    'filterType' => GridView::FILTER_SELECT2,
                    'filter' => $serviceReasonList,
                    'filterWidgetOptions' => [
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    'filterInputOptions' => ['placeholder' => 'Alasan', 'id' => 'grid-service-search-reason_id']
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
                    'filterInputOptions' => ['placeholder' => 'Jenis', 'id' => 'grid-service-search-device_status']
            ], 
            'commentary:ntext', 
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
            'before' => Html::a('<i class="glyphicon glyphicon-plus"></i> Add', ['/enrolment/select','module'=>'service'], ['class' => 'btn btn-success']),
            'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
            'showFooter' => false
        ],
    ]); Pjax::end(); ?>

</div>
