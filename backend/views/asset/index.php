<?php

use common\helper\IconHelper;
use kartik\grid\GridView;
use supplyhog\ClipboardJs\ClipboardJsWidget;
use yii\helpers\Html;
use yii\widgets\Pjax;

/*
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\AssetSearch $searchModel
 * @var common\models\AssetCategory $assetCategoryList
 * @var common\models\Asset $isVisibleList
 *
 */

$this->title = Yii::t('app', 'Assets');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="asset-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]);?>

    <p>
        <?php /* echo Html::a(Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Asset',
]), ['create'], ['class' => 'btn btn-success'])*/ ?>
    </p>

    <?php Pjax::begin();
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'pageSummaryPosition' => GridView::POS_BOTTOM,
        'showPageSummary' => true,
        'toolbar' => [
            [
                'content' => Html::a('<i class="fas fa-plus"></i> Add New', ['create'], ['class' => 'btn btn-success'])
                     .' '
                    .Html::a('<i class="fas fa-redo"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
                'options' => ['class' => 'btn-group-md'],
            ],
            // '{export}',
            // '{toggleData}'
        ],

        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'title',
            [
                'attribute' => 'asset_category_id',
                'vAlign' => 'middle',
                'width' => '180px',
                'value' => function ($model, $key, $index, $widget) {
                    return (null != $model->asset_category_id) ? $model->assetCategory->title : '';
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => $assetCategoryList,
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => ''],
                'format' => 'raw',
            ],
            [
                'attribute' => 'asset_type',
                'vAlign' => 'middle',
                'width' => '180px',
                'value' => function ($model, $key, $index, $widget) {
                    return (null != $model->asset_type) ? $model->getOneAssetType($model->asset_type) : '';
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => $assetTypeList,
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => ''],
                'format' => 'raw',
                    ],
            [
                'attribute' => 'is_visible',
                'vAlign' => 'middle',
                'width' => '120px',
                'value' => function ($model, $key, $index, $widget) {
                    return (null != $model->is_visible) ? $model->getOneIsVisible($model->is_visible) : '';
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => $isVisibleList,
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => ''],
                'format' => 'raw',
                    ],
            // 'description',
            [
                'header' => 'View',
                'format' => ['image', ['width' => '70', 'height' => '50']],
                'vAlign' => 'middle',
                'width' => '50px',
                'value' => function ($model, $key, $index, $widget) {
                    return $model->getAssetUrl();
                },
                    ],
            [
                'class' => 'common\widgets\ActionColumn',
                'contentOptions' => ['style' => 'white-space:nowrap;'],
                'template' => '{copy} {update} {view}',
                'buttons' => [
                    'copy' => function ($url, $model) {
                        return ClipboardJsWidget::widget([
                            'text' => 'https://'.Yii::$app->getRequest()->serverName.$model->getAssetUrl(),
                            'label' => IconHelper::getClipboard(),
                            'htmlOptions' => ['class' => 'btn btn-sm btn-info'],
                            'tag' => 'button',
                        ]);
                    },
                    'update' => function ($url, $model) {
                        return Html::a(
                            '<i class="fas fa-pencil-alt"></i>',
                            Yii::$app->urlManager->createUrl(['asset/view', 'id' => $model->id, 'edit' => 't']),
                            [
                                'title' => Yii::t('yii', 'Edit'),
                                'class' => 'btn btn-sm btn-info',
                            ]
                        );
                    },
                    'view' => function ($url, $model) {
                        return Html::a(
                            '<i class="fas fa-eye"></i>',
                            Yii::$app->urlManager->createUrl(['asset/view', 'id' => $model->id, 'title' => $model->title]),
                            [
                                'title' => Yii::t('yii', 'View'),
                                'class' => 'btn btn-sm btn-info',
                            ]
                        );
                    },
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
                    // 'before' => Html::a('<i class="glyphicon glyphicon-plus"></i> Add', ['create'], ['class' => 'btn btn-success']),
                    // 'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
                    'showFooter' => false,
                ],
        ]);
    Pjax::end(); ?>
</div>
