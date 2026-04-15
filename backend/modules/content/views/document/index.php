<?php

use common\widgets\ActionColumn;
use rmrevin\yii\fontawesome\FAS;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\search\DocumentSearch $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var array $officeOptions
 * @var array $documentCategoryOptions
 * @var array $visibleOptions
 * @var array $documentTypeOptions
 */

$this->title = Yii::t('backend', 'Documents');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="document-index">
    <div class="card">
        <div class="card-header">
            <?php echo Html::a(FAS::icon('user-plus').' '.Yii::t('backend', 'Add New {modelClass}', [
                'modelClass' => 'Document',
            ]), ['create'], ['class' => 'btn btn-success']); ?>
        </div>

        <div class="card-body p-0">
            <?php // echo $this->render('_search', ['model' => $searchModel]);?>
    
            <?php echo GridView::widget([
                'layout' => "{items}\n{pager}",
                'options' => [
                    'class' => ['gridview', 'table-responsive'],
                ],
                'tableOptions' => [
                    'class' => ['table', 'table-striped', 'table-bordered', 'mb-0', 'table-sm'],
                    'style' => 'width: 100%;',
                ],
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'options' => ['style' => 'width: 5%'],
                        'contentOptions' => ['style' => 'white-space: nowrap;'],
                    ],
                    [
                        'attribute' => 'office_id',
                        'filter' => $officeOptions,
                        'value' => static fn ($model): string => $officeOptions[$model->office_id] ?? '-',
                        'options' => ['style' => 'min-width: 120px;'],
                    ],
                    [
                        'attribute' => 'category_id',
                        'filter' => $documentCategoryOptions,
                        'value' => static fn ($model): string => $documentCategoryOptions[$model->category_id] ?? '-',
                        'options' => ['style' => 'min-width: 120px;'],
                    ],
                    [
                        'attribute' => 'title',
                        'contentOptions' => ['style' => 'white-space: normal; word-break: break-word;'],
                    ],
                    [
                        'attribute' => 'document_type',
                        'filter' => $documentTypeOptions,
                        'value' => static fn ($model): string => $documentTypeOptions[$model->document_type] ?? '-',
                        'options' => ['style' => 'min-width: 100px;'],
                    ],
                    [
                        'attribute' => 'is_visible',
                        'filter' => $visibleOptions,
                        'value' => static fn ($model): string => $visibleOptions[$model->is_visible] ?? '-',
                        'options' => ['style' => 'min-width: 100px;'],
                    ],
                    [
                        'class' => ActionColumn::class,
                        'template' => '{download} {view} {update} {delete}',
                        'buttons' => [
                            'download' => static function ($url, $model): string {
                                return Html::a(
                                    FAS::icon('download', ['aria' => ['hidden' => true], 'class' => ['fa-fw']]),
                                    ['download', 'id' => $model->id],
                                    [
                                        'class' => ['btn', 'btn-secondary', 'btn-xs'],
                                        'title' => Yii::t('backend', 'Download'),
                                        'aria-label' => Yii::t('backend', 'Download'),
                                        'data-pjax' => '0',
                                    ]
                                );
                            },
                        ],
                        'visibleButtons' => [
                            'download' => static fn ($model): bool => !empty($model->path),
                        ],
                        'options' => ['style' => 'min-width: 100px;'],
                        'contentOptions' => ['style' => 'white-space: nowrap;'],
                    ],
                ],
            ]); ?>
    
        </div>
        <div class="card-footer">
            <?php echo getDataProviderSummary($dataProvider); ?>
        </div>
    </div>

</div>
