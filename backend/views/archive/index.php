<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\models\ArchiveSearch $searchModel
 */

$this->title = 'Archives';
$this->params['breadcrumbs'][] = $this->title;

$create = Html::a('<i class="glyphicon glyphicon-plus"></i> Add', ['create'], ['class' => 'btn btn-success']);
$report = Html::a('<i class="glyphicon glyphicon-list-alt"></i> Report', ['report'], ['class' => 'btn btn-primary']);
?>
<div class="archive-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php /* echo Html::a('Create Archive', ['create'], ['class' => 'btn btn-success'])*/  ?>
    </p>

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'title',
            [
                'attribute' => 'date_issued_range',
                'header' => 'Issued',
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
                'attribute'=>'archive_category_id',
                'vAlign'=>'middle',
                'width'=>'120px',
                'value'=>function ($model, $key, $index, $widget) {
                    return ($model->archive_category_id!=null) ? $model->archiveCategory->title:'';
                },
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>$archiveCategoryList,
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>''],
                'format'=>'raw'
            ],
            [
                'attribute'=>'is_visible',
                'vAlign'=>'middle',
                'width'=>'120px',
                'value'=>function ($model, $key, $index, $widget) {
                    return ($model->is_visible!=null) ? $model->getOneIsVisible($model->is_visible):'';
                },
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>$isVisibleList,
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>''],
                'format'=>'raw'
            ],
            [
                'attribute'=>'description',
                'format'=>'html',
            ],
            [
                'class' => 'common\widgets\ActionColumn',
                'contentOptions' => ['style' => 'white-space:nowrap;'],
                'template'=>'{update} {view}',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                            Yii::$app->urlManager->createUrl(['archive/view', 'id' => $model->id, 'edit' => 't']),
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
        'floatHeader' => false,
                        
        'bordered' => true,
        'striped' => false,
        'responsiveWrap' => false,

        'panel' => [
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
            'type' => 'info',
            'before' => $create.' '.$report,
            'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
            'showFooter' => false
        ],
    ]); Pjax::end(); ?>

</div>
