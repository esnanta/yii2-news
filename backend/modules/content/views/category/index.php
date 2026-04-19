<?php

use common\grid\EnumColumn;
use common\models\ArticleCategory;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * @var $this         yii\web\View
 * @var $searchModel  backend\modules\content\models\search\ArticleCategorySearch
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $model        ArticleCategory
 * @var $categories   common\models\ArticleCategory[]
 */

$parentFilter = ArrayHelper::map(ArticleCategory::find()->orderBy(['title' => SORT_ASC])->all(), 'id', 'title');

$this->title = Yii::t('backend', 'Article Categories');
$this->params['breadcrumbs'][] = $this->title;
?>


<?php echo $this->render('_form', [
    'model' => $model,
    'categories' => $categories,
]) ?>

<div class="card">
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
                    'attribute' => 'id',
                    'options' => ['style' => 'width: 5%'],
                    'contentOptions' => ['style' => 'white-space: nowrap;'],
                ],
                [
                    'attribute' => 'slug',
                    'options' => ['style' => 'width: 15%'],
                    'contentOptions' => ['style' => 'white-space: nowrap; overflow: hidden; text-overflow: ellipsis;'],
                ],
                [
                    'attribute' => 'title',
                    'value' => function ($model) {
                        return Html::a(Html::encode($model->title), ['update', 'id' => $model->id]);
                    },
                    'format' => 'raw',
                    'contentOptions' => ['style' => 'white-space: normal; word-break: break-word;'],
                ],
                [
                    'attribute' => 'parent_id',
                    'options' => ['style' => 'width: 20%'],
                    'value' => static function (ArticleCategory $model): ?string {
                        return $model->parent ? $model->parent->title : null;
                    },
                    'filter' => $parentFilter,
                    'contentOptions' => ['style' => 'white-space: normal; word-break: break-word;'],
                ],
                [
                    'class' => EnumColumn::class,
                    'attribute' => 'status',
                    'options' => ['style' => 'width: 10%'],
                    'enum' => ArticleCategory::statuses(),
                    'filter' => ArticleCategory::statuses(),
                    'contentOptions' => ['style' => 'white-space: nowrap;'],
                ],
                [
                    'class' => \common\widgets\ActionColumn::class,
                    'options' => ['style' => 'width: 5%'],
                    'template' => '{update} {delete}',
                    'contentOptions' => ['style' => 'white-space: nowrap;'],
                ],
            ],
        ]); ?>
    </div>
    <div class="card-footer">
        <?php echo getDataProviderSummary($dataProvider) ?>
    </div>
</div>

