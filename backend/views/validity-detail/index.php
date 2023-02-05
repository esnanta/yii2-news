<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\models\ValidityDetailSearch $searchModel
 */

$this->title = 'Validity Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="validity-detail-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php /* echo Html::a('Create Validity Detail', ['create'], ['class' => 'btn btn-success'])*/  ?>
    </p>

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'validity_title',
                'label' => 'Validity',
                'format'=>'html',
                'value' => function($model){
                    if ($model->validity)
                    {return Html::a($model->validity->title, $model->validity->getUrl());}
                    else
                    {return NULL;}
                },
            ],                        
            [
                'attribute' => 'customer_title',
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
                'attribute' => 'enrolment_title',
                'label' => 'Number',
                'format'=>'html',
                'value' => function($model){
                    if ($model->enrolment)
                    {return Html::a($model->enrolment->title, $model->enrolment->getUrl());}
                    else
                    {return NULL;}
                },
            ],               
            //'month_period',
            [
                'attribute' => 'amount',
                'format' => ['decimal'],
            ],                        
            [
                'attribute'=>'device_status', 
                'vAlign'=>'middle',
                'width'=>'180px',
                'value'=>function ($model, $key, $index, $widget) { 
                    return ($model->device_status!=null) ? $model->getOneDeviceStatus($model->device_status):'';
                },
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>$deviceStatusList, 
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>''],
                'format'=>'raw'
            ],                        
            [
                'attribute'=>'billing_status', 
                'vAlign'=>'middle',
                'width'=>'180px',
                'value'=>function ($model, $key, $index, $widget) { 
                    return ($model->billing_status!=null) ? $model->getOneBillingStatus($model->billing_status) : '';
                },
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>$billingStatusList, 
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>''],
                'format'=>'raw'
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
            [
                'class' => 'common\widgets\ActionColumn',
                'contentOptions' => ['style' => 'white-space:nowrap;'],
                'template'=>'{update} {view}',                
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                            Yii::$app->urlManager->createUrl(['validity-detail/view', 'id' => $model->id, 'edit' => 't']),
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
            'before' => Html::a('<i class="glyphicon glyphicon-plus"></i> Add', ['/enrolment/select','module'=>'validity-detail'], ['class' => 'btn btn-success']),
            'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
            'showFooter' => false
        ],
    ]); Pjax::end(); ?>

</div>
