<?php

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OutletSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;

$this->title = 'Outlet';
$this->params['breadcrumbs'][] = $this->title;
$search = "$('.search-button').click(function(){
	$('.search-form').toggle(1000);
	return false;
});";
$this->registerJs($search);
?>
<div class="outlet-index">
    
    <p>
        <?= Html::a('Create Outlet', ['/enrolment/select','module'=>'outlet'], ['class' => 'btn btn-success']) ?>
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
                        
            //'title',
            'invoice',            
//            [
//                'attribute' => 'date_issued_range',
//                'value'=>'date_issued',
//                'format'=>'date',
//                'options' => [
//                    'format' => 'd-m-Y',
//                ],
//                'filterType' => GridView::FILTER_DATE_RANGE,
//                'filterWidgetOptions' => ([
//                    'attribute' => 'date_issued_range',
//                    'presetDropdown' => false,
//                    'convertFormat' => true,
//                    'pluginOptions'=>[
//                        'locale'=>['format' => 'd-m-Y'],
//                    ]                
//                ])
//            ],                        

            [
                'attribute' => 'claim',
                'format' => ['decimal'],
            ], 
            [
                    'attribute' => 'assembly_type',
                    'format'=>'html',
                    'value' => function($model){
                        if ($model->assembly_type)
                        {return $model->getOneAssemblyType($model->assembly_type);}
                        else
                        {return NULL;}
                    },
                    'filterType' => GridView::FILTER_SELECT2,
                    'filter' => $assemblyTypeList,
                    'filterWidgetOptions' => [
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    'filterInputOptions' => ['placeholder' => 'Jenis', 'id' => 'grid-outlet-search-assembly_type']
            ],                         
            [
                    'attribute' => 'billing_status',
                    'format'=>'html',
                    'value' => function($model){
                        if ($model->billing_status)
                        {return $model->getOneBillingStatus($model->billing_status) ;}
                        else
                        {return NULL;}
                    },
                    'filterType' => GridView::FILTER_SELECT2,
                    'filter' => $billingStatusList,
                    'filterWidgetOptions' => [
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    'filterInputOptions' => ['placeholder' => 'Status', 'id' => 'grid-outlet-search-billing_status']
            ],                        
            ['attribute' => 'verlock', 'visible' => false],
            [
                'class' => 'common\widgets\ActionColumn',
                'contentOptions' => ['style' => 'white-space:nowrap;'],
                'template'=>'{update} {view}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',
                            Yii::$app->urlManager->createUrl(['outlet/view', 'id' => $model->id, 'title' => $model->invoice]),
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
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-outlet']],
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
