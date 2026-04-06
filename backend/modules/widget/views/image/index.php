<?php

use common\widgets\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;

/*
 * @var yii\web\View $this
 * @var backend\modules\widget\models\search\ImageSearch $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\WidgetImage $model
 */

$this->title = Yii::t('backend', 'Widget Images');
$this->params['breadcrumbs'][] = $this->title;
?>

<?php echo $this->render('_form', [
    'model' => $model,
]); ?>

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
                'class' => ['table', 'text-nowrap', 'table-striped', 'table-bordered', 'mb-0'],
            ],
            'columns' => [
                [
                    'attribute' => 'id',
                    'options' => ['style' => 'width: 5%'],
                ],
                [
                    'attribute' => 'key',
                    'options' => ['style' => 'width: 20%'],
                ],
                [
                    'attribute' => 'title',
                    'value' => function ($model) {
                        $label = $model->title ?: $model->key;

                        return Html::a($label, ['update', 'id' => $model->id]);
                    },
                    'format' => 'raw',
                ],
                [
                    'attribute' => 'mime_type',
                    'options' => ['style' => 'width: 12%'],
                ],
                [
                    'attribute' => 'sequence',
                    'options' => ['style' => 'width: 8%'],
                ],
                [
                    'class' => ActionColumn::class,
                    'options' => ['style' => 'width: 5%'],
                    'template' => '{update} {delete}',
                ],
            ],
        ]); ?>
    </div>
    <div class="card-footer">
        <?php echo getDataProviderSummary($dataProvider); ?>
    </div>
</div>

