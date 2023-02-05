<?php

/* @var $this yii\web\View */
/* @var $searchModel backend\models\GmapSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;

$this->title = 'Gmap';
$this->params['breadcrumbs'][] = $this->title;
$search = "$('.search-button').click(function(){
	$('.search-form').toggle(1000);
	return false;
});";
$this->registerJs($search);
?>
<div class="gmap-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Gmap', ['/customer/select','module'=>'gmap'], ['class' => 'btn btn-success']) ?>
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
            'attribute' => 'enrolment_title',
            'label' => 'Nomor',
            'format'=>'html',
            'value' => function($model){
                if ($model->enrolment)
                {return $model->enrolment->title;}
                else
                {return NULL;}
            },      
            'filterInputOptions' => ['placeholder' => 'Nomor', 'class' => 'form-control']
        ],        
        [
            'attribute' => 'phone_number',
            'label' => 'Telpon',
            'format'=>'html',
            'value' => function($model){
                if ($model->customer)
                {return $model->customer->phone_number;}
                else
                {return NULL;}
            },     
            'filterInputOptions' => ['placeholder' => 'Telpon', 'class' => 'form-control']
        ], 
        [
            'attribute' => 'address',
            'label' => 'Alamat',
            'format'=>'html',
            'value' => function($model){
                if ($model->customer)
                {return $model->customer->address;}
                else
                {return NULL;}
            },     
            'filterInputOptions' => ['placeholder' => 'Alamat', 'class' => 'form-control']
        ],                     
        'latitude',
        'longitude',
//        'description:ntext',
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
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-gmap']],
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
