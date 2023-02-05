<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\models\CustomerSearch $searchModel
 */

$this->title = 'Customers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php /* echo Html::a('Create Customer', ['create'], ['class' => 'btn btn-success'])*/  ?>
    </p>

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute'=>'area_id',
                'vAlign'=>'middle',
                'width'=>'180px',
                'value'=>function ($model, $key, $index, $widget) {
                    return ($model->area_id!=null) ? $model->area->title:'';
                },
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>$areaList,
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>''],
                'format'=>'raw'
            ],

            'title',
            'phone_number',
            'address:ntext',
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
                'label' => ucfirst($module),
                'vAlign'=>'middle',
                'format' => 'raw',
                'contentOptions' => ['class' => 'text-center'],
                'value'=> function ($model) use ($module)  {
                    return Html::a('<i class="fa fa-refresh"></i>',Yii::$app->urlManager->createUrl([$module.'/create', 'id' => $model->id]),
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
            //'before' => Html::a('<i class="glyphicon glyphicon-plus"></i> Add', ['create'], ['class' => 'btn btn-success']),
            'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
            'showFooter' => false
        ],
    ]); Pjax::end(); ?>

</div>
