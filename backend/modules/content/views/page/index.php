<?php

use common\grid\EnumColumn;
use common\models\Page;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * @var $this         yii\web\View
 * @var $searchModel  \backend\models\search\PageSearch
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $model        common\models\Page
 */

$this->title = Yii::t('backend', 'Pages');

$this->params['breadcrumbs'][] = $this->title;

?>

<div class="box box-success collapsed-box">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo Yii::t('backend', 'Create {modelClass}', ['modelClass' => 'Page']) ?></h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
        </div>
    </div>
    <div class="box-body">
        <?php echo $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>

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
                    'options' => ['style' => 'width: 8%'],
                    'contentOptions' => ['style' => 'white-space: nowrap;'],
                ],
                [
                    'attribute' => 'slug',
                    'options' => ['style' => 'width: 20%'],
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
                    'class' => EnumColumn::class,
                    'attribute' => 'status',
                    'options' => ['style' => 'width: 12%'],
                    'enum' => Page::statuses(),
                    'filter' => Page::statuses(),
                    'contentOptions' => ['style' => 'white-space: nowrap;'],
                ],
                [
                    'class' => \common\widgets\ActionColumn::class,
                    'options' => ['style' => 'width: 8%'],
                    'template' => '{delete}',
                    'contentOptions' => ['style' => 'white-space: nowrap;'],
                ],
            ],
        ]); ?>
    </div>
    <div class="card-footer">
        <?php echo getDataProviderSummary($dataProvider); ?>
    </div>
</div>
