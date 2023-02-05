<?php

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ServiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;

$this->title = 'Service';
$this->params['breadcrumbs'][] = $this->title;
$search = "$('.search-button').click(function(){
	$('.search-form').toggle(1000);
	return false;
});";
$this->registerJs($search);
?>
<div class="service-index">


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Service', ['/enrolment/select','module'=>'service'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Advance Search', '#', ['class' => 'btn btn-info search-button']) ?>
    </p>
    <div class="search-form" style="display:none">
        <?=  $this->render('_search', ['model' => $searchModel]); ?>
    </div>
    <?php
    $gridColumn = [
        ['class' => 'yii\grid\SerialColumn'],
        ['attribute' => 'id', 'visible' => false],
        'title',
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
                {return Html::a($model->enrolment->title, $model->customer->getUrl());}
                else
                {return NULL;}
            },
        ],

        [
            'attribute' => 'staff_title',
            'label' => 'Staff',
            'format'=>'html',
            'value' => function($model){
                if ($model->staff)
                {return Html::a($model->staff->title, $model->staff->getUrl());}
                else
                {return NULL;}
            },
        ],

        'invoice',

        [
            'attribute' => 'date_issued_range',
            'value'=>'date_issued',
            'format'=>'date',
            'options' => [
                'format' => 'd-m-Y',
            ],
            'filterType' => GridView::FILTER_DATE_RANGE,
            'filterWidgetOptions' => ([
                'attribute' => 'date_issued_range',
                'presetDropdown' => false,
                'convertFormat' => true,
                'pluginOptions'=>[
                    'locale'=>['format' => 'd-m-Y'],
                ]
            ])
        ],
                    
        [
                'attribute' => 'service_type',
                'format'=>'html',
                'value' => function($model){
                    if ($model->service_type)
                    {return $model->getOneServiceType($model->service_type);}
                    else
                    {return NULL;}
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => $serviceTypeList,
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Jenis', 'id' => 'grid-service-search-service_type']
        ],   
                    
        //'description:ntext',
                    
        ['attribute' => 'verlock', 'visible' => false],
        [
            'class' => 'common\widgets\ActionColumn',
            'contentOptions' => ['style' => 'white-space:nowrap;'],
            'template'=>'{update} {view}',
        ],
    ];
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumn,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-service']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
        ],
        // your toolbar can include the additional full export menu
        'toolbar' => [
            '{export}',
            ExportMenu::widget([
                'dataProvider' => $dataProvider,
                'columns' => $gridColumn,
                'target' => ExportMenu::TARGET_BLANK,
                'fontAwesome' => true,
                'dropdownOptions' => [
                    'label' => 'Full',
                    'class' => 'btn btn-default',
                    'itemsBefore' => [
                        '<li class="dropdown-header">Export All Data</li>',
                    ],
                ],
            ]) ,
        ],
    ]); ?>

</div>
