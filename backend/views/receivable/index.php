<?php

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ReceivableSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;

$this->title = 'Receivable';
$this->params['breadcrumbs'][] = $this->title;
$search = "$('.search-button').click(function(){
	$('.search-form').toggle(1000);
	return false;
});";
$this->registerJs($search);
?>
<div class="receivable-index">

    <p>
        <?= Html::a('Create Receivable', ['/billing/select','module'=>'receivable'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Advance Search', '#', ['class' => 'btn btn-info search-button']) ?>
    </p>
    <div class="search-form" style="display:none">
        <?=  $this->render('_search', ['model' => $searchModel]); ?>
    </div>
    <?php 
    $gridColumn = [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'class' => 'kartik\grid\ExpandRowColumn',
            'width' => '50px',
            'value' => function ($model, $key, $index, $column) {
                return GridView::ROW_COLLAPSED;
            },
            'detail' => function ($model, $key, $index, $column) {
                return Yii::$app->controller->renderPartial('_expand', ['model' => $model]);
            },
            'headerOptions' => ['class' => 'kartik-sheet-style'],
            'expandOneOnly' => true
        ],
        ['attribute' => 'id', 'visible' => false],

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
                        
//        [
//                'attribute' => 'staff_id',
//                'label' => 'Staff',
//                'format'=>'html',
//                'value' => function($model){
//                    if ($model->staff)
//                    {return Html::a($model->staff->title, $model->staff->getUrl());}
//                    else
//                    {return NULL;}
//                },
//                'filterType' => GridView::FILTER_SELECT2,
//                'filter' => $staffList,
//                'filterWidgetOptions' => [
//                    'pluginOptions' => ['allowClear' => true],
//                ],
//                'filterInputOptions' => ['placeholder' => 'Staff', 'id' => 'grid-outlet-search-staff_id']
//        ],
//        'title',
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
            'attribute' => 'total',
            'format' => ['decimal'],
        ], 
//        [
//            'attribute' => 'payment',
//            'format' => ['decimal'],
//        ], 
//        [
//            'attribute' => 'balance',
//            'format' => ['decimal'],
//        ],                         
        ['attribute' => 'verlock', 'visible' => false],
        [
            'class' => 'common\widgets\ActionColumn',
            'contentOptions' => ['style' => 'white-space:nowrap;'],
            'template'=>'{update} {view}',
            'buttons' => [
                'view' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',
                        Yii::$app->urlManager->createUrl(['receivable/view', 'id' => $model->id, 'title' => $model->invoice]),
                        [
                            'title' => Yii::t('yii', 'Edit'),
                            'class'=>'btn btn-sm btn-primary',
                        ]
                    );
                }
            ],
        ],
    ]; 
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumn,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-receivable']],
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
