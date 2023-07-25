<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\models\ArchiveSearch $searchModel
 */

$this->title = Yii::t('app', 'Archives');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="archive-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php /* echo Html::a(Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Archive',
]), ['create'], ['class' => 'btn btn-success'])*/  ?>
    </p>

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        
        'toolbar' => [
            [
                'content'=>
                    Html::a('<i class="fas fa-plus"></i> Add New', ['create'], ['class' => 'btn btn-success'])
                     . ' '.
                    Html::a('<i class="fas fa-redo"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
                'options' => ['class' => 'btn-group-sm']
            ],
            //'{export}',
            //'{toggleData}'
        ],
        
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'title',
            [
                'attribute'=>'archive_category_id', 
                'vAlign'=>'middle',
                'width'=>'180px',
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
                'attribute' => 'created_at',
                'value'=>'created_at',
                'enableSorting' => true,
                'format'=>'date',
                'options' => [
                    'format' => Yii::$app->params['dateDisplayFormat'],
                ],
                'filterType' => GridView::FILTER_DATE_RANGE,
                'filterWidgetOptions' => ([
                    'attribute' => 'date_range',
                    'presetDropdown' => false,
                    'convertFormat' => true,
                    'pluginOptions'=>[
                        'locale'=>['format' => Yii::$app->params['dateDisplayFormat']],
                    ]                
                ])
            ],
                        
            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                            Yii::$app->urlManager->createUrl(['archive/view', 'id' => $model->id, 'edit' => 't']),
                            ['title' => Yii::t('yii', 'Edit'),]
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
            'type' => 'default',
            //'before' => Html::a('<i class="glyphicon glyphicon-plus"></i> Add', ['create'], ['class' => 'btn btn-success']),
            //'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
            'showFooter' => false
        ],
    ]); Pjax::end(); ?>
    

</div>
