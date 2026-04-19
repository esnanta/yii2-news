<?php

use common\grid\EnumColumn;
use common\models\Article;
use common\models\ArticleCategory;
use common\widgets\ActionColumn;
use kartik\date\DatePicker;
use kartik\widgets\Select2;
use rmrevin\yii\fontawesome\FAS;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\modules\content\models\search\ArticleSearch $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var array $authorOptions
 */

$this->title = Yii::t('backend', 'Articles');
$this->params['breadcrumbs'][] = $this->title;

$textWrapStyle = 'white-space: normal; word-break: break-word;';
?>

<div class="card">
    <div class="card-header">
        <?php echo Html::a(FAS::icon('user-plus').' '.Yii::t('backend', 'Add New {modelClass}', [
            'modelClass' => 'Article',
        ]), ['create'], ['class' => 'btn btn-success']); ?>
    </div>

    <div class="card-body p-0">
        <?php echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout' => "{items}\n{pager}",
            'options' => [
                'class' => ['gridview', 'table-responsive'],
            ],
            'tableOptions' => [
                'class' => ['table', 'table-striped', 'table-bordered', 'mb-0', 'table-sm'],
                'style' => 'width: 100%; table-layout: fixed;',
            ],
            'columns' => [
                [
                    'attribute' => 'title',
                    'options' => ['style' => 'width: 24%'],
                    'value' => function ($model) {
                        return Html::a(Html::encode($model->title), ['update', 'id' => $model->id]);
                    },
                    'format' => 'raw',
                    'contentOptions' => ['style' => $textWrapStyle],
                ],
                [
                    'attribute' => 'category_id',
                    'options' => ['style' => 'width: 14%'],
                    'value' => function ($model) {
                        return $model->category ? $model->category->title : null;
                    },
                    'filter' => ArrayHelper::map(ArticleCategory::find()->all(), 'id', 'title'),
                    'contentOptions' => ['style' => $textWrapStyle],
                ],

                [
                    'attribute' => 'author_id',
                    'label' => Yii::t('backend', 'Author'),
                    'options' => ['style' => 'width: 16%'],
                    'value' => function ($model) {
                        if ($model->author_id) {
                            return $model->author->title;
                        }

                        return null;
                    },
                    'filter' => Select2::widget([
                        'model' => $searchModel,
                        'attribute' => 'author_id',
                        'data' => $authorOptions,
                        'options' => ['placeholder' => Yii::t('backend', 'Select author')],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]),
                    'contentOptions' => ['style' => $textWrapStyle],
                ],

                [
                    'class' => EnumColumn::class,
                    'attribute' => 'status',
                    'options' => ['style' => 'width: 9%'],
                    'enum' => Article::statuses(),
                    'filter' => Html::activeDropDownList(
                        $searchModel,
                        'status',
                        [
                            Article::STATUS_PUBLISHED => Yii::t('common', 'Published'),
                            Article::STATUS_DRAFT => Yii::t('common', 'Draft'),
                        ],
                        ['class' => 'form-control', 'prompt' => Yii::t('backend', 'All')]
                    ),
                ],
                [
                    'class' => EnumColumn::class,
                    'attribute' => 'is_pinned',
                    'options' => ['style' => 'width: 8%'],
                    'enum' => Article::pinnedOptions(),
                    'filter' => Html::activeDropDownList(
                        $searchModel,
                        'is_pinned',
                        Article::pinnedOptions(),
                        ['class' => 'form-control', 'prompt' => Yii::t('backend', 'All')]
                    ),
                ],
                [
                    'attribute' => 'published_at',
                    'options' => ['style' => 'width: 12%'],
                    'format' => ['date', 'php:d-m-Y'],
                    'contentOptions' => ['style' => 'white-space: nowrap;'],
                    'filter' => DatePicker::widget([
                        'model' => $searchModel,
                        'attribute' => 'published_at',
                        'type' => DatePicker::TYPE_INPUT,
                        'options' => [
                            'placeholder' => Yii::t('backend', 'Date'),
                        ],
                        'pluginOptions' => [
                            'format' => 'dd-mm-yyyy',
                            'todayHighlight' => true,
                            'autoclose' => true,
                            'endDate' => '0d',
                            'clearBtn' => true,
                        ],
                    ]),
                ],
                [
                    'attribute' => 'created_at',
                    'options' => ['style' => 'width: 12%'],
                    'format' => ['date', 'php:d-m-Y'],
                    'contentOptions' => ['style' => 'white-space: nowrap;'],
                    'filter' => DatePicker::widget([
                        'model' => $searchModel,
                        'attribute' => 'created_at',
                        'type' => DatePicker::TYPE_INPUT,
                        'options' => [
                            'placeholder' => Yii::t('backend', 'Date'),
                        ],
                        'pluginOptions' => [
                            'format' => 'dd-mm-yyyy',
                            'todayHighlight' => true,
                            'autoclose' => true,
                            'endDate' => '0d',
                            'clearBtn' => true,
                        ],
                    ]),
                ],
                [
                    'class' => ActionColumn::class,
                    'options' => ['style' => 'width: 5%'],
                    'template' => '{update} {delete}',
                    'contentOptions' => ['style' => 'white-space: nowrap;'],
                ],
            ],
        ]); ?>
    </div>

    <div class="card-footer">
        <?php echo getDataProviderSummary($dataProvider); ?>
    </div>
</div>


