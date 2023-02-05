<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\models\EnrolmentSearch $searchModel
 */

$this->title = 'Enrolments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="enrolment-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php /* echo Html::a('Create Enrolment', ['create'], ['class' => 'btn btn-success'])*/  ?>
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
//            [
//                'attribute' => 'customer_number',
//                'label' => 'Nomor',
//                'format'=>'html',
//                'value' => function($model){
//                    if ($model->customer_id)
//                    {return Html::a($model->enrolment->title, $model->enrolment->getUrl());}
//                    else
//                    {return NULL;}
//                },                
//            ],             
            [
                'attribute'=>'network_id', 
                'vAlign'=>'middle',
                'width'=>'180px',
                'value'=>function ($model, $key, $index, $widget) { 
                    return ($model->network_id!=null) ? $model->network->title:'';
                },
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>$networkList, 
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>''],
                'format'=>'raw'
            ],                             
            'title',
            [
                'attribute'=>'billing_cycle', 
                'vAlign'=>'middle',
                'width'=>'180px',
                'value'=>function ($model, $key, $index, $widget) { 
                    return ($model->billing_cycle!=null) ? $model->billing_cycle:'';
                },
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>$billingCycleList, 
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>''],
                'format'=>'raw'
            ], 

            [
                
                'label' => ucfirst($module),
                'vAlign'=>'middle',
                'format' => 'raw',
                'contentOptions' => ['class' => 'text-center'],
                'value'=> function ($model) use ($module)  { 
                    return Html::a('<i class="fa fa-refresh"></i>',Yii::$app->urlManager->createUrl([$module.'/create', 'id' => $model->customer_id]),
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
            //'before' => Html::a('<i class="glyphicon glyphicon-plus"></i> Add', ['/customer/select','module'=>'enrolment'], ['class' => 'btn btn-success']),
            'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
            'showFooter' => false
        ],
    ]); Pjax::end(); ?>

</div>
