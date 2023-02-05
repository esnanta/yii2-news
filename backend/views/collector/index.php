<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\models\CollectorSearch $searchModel
 */

$this->title = 'Collectors';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="collector-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php /* echo Html::a('Create Collector', ['create'], ['class' => 'btn btn-success'])*/  ?>
    </p>

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'title',
            [
                    'attribute' => 'area_id',
                    'label' => 'Area',
                    'format'=>'html',
                    'value' => function($model){
                        if ($model->area_id)
                        {return Html::a($model->area->title, $model->area->getUrl());}
                        else
                        {return NULL;}
                    },
                    'filterType' => GridView::FILTER_SELECT2,
                    'filter' => $areaList,
                    'filterWidgetOptions' => [
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    'filterInputOptions' => ['placeholder' => 'Area', 'id' => 'grid-outlet-search-area_id']
            ],            
            
            [
                    'attribute' => 'staff_id',
                    'label' => 'Staff',
                    'format'=>'html',
                    'value' => function($model){
                        if ($model->area_id)
                        {return Html::a($model->staff->title, $model->staff->getUrl());}
                        else
                        {return NULL;}
                    },
                    'filterType' => GridView::FILTER_SELECT2,
                    'filter' => $staffList,
                    'filterWidgetOptions' => [
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    'filterInputOptions' => ['placeholder' => 'Staff', 'id' => 'grid-outlet-search-staff_id']
            ],       

            'description',
//            'created_at:datetime', 
//            'created_by', 
//            'updated_at:datetime', 
//            'updated_by', 
//            'verlock', 

            [
                'class' => 'common\widgets\ActionColumn',
                'contentOptions' => ['style' => 'white-space:nowrap;'],
                'template'=>'{update} {view}',                
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                            Yii::$app->urlManager->createUrl(['collector/view', 'id' => $model->id, 'edit' => 't']),
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
            'before' => Html::a('<i class="glyphicon glyphicon-plus"></i> Add', ['create'], ['class' => 'btn btn-success']),
            'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
            'showFooter' => false
        ],
    ]); Pjax::end(); ?>

</div>
