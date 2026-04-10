<?php

use common\widgets\ActionColumn;
use kartik\widgets\Select2;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\search\AuthorSearch $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var array $officeOptions
 */

$this->title = Yii::t('backend', 'Authors');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="author-index">
    <div class="card">
        <div class="card-header">
            <?php echo Html::a(Yii::t('backend', 'Create {modelClass}', [
                'modelClass' => 'Author',
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
                    'class' => ['table', 'text-nowrap', 'table-striped', 'table-bordered', 'mb-0'],
                ],
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'id',
                    [
                        'attribute' => 'office_id',
                        'label' => Yii::t('backend', 'Office'),
                        'value' => function ($model) {
                            if ($model->office_id) {
                                return $model->office->title;
                            }

                            return null;
                        },
                        'filter' => Select2::widget([
                            'model' => $searchModel,
                            'attribute' => 'office_id',
                            'data' => $officeOptions,
                            'options' => ['placeholder' => Yii::t('backend', '')],
                            'pluginOptions' => [
                                'allowClear' => true,
                            ],
                        ]),
                        'contentOptions' => ['style' => 'white-space: normal; word-break: break-word;'],
                    ],
                    'title',
                    'phone_number',
                    // 'email:email',
                    // 'base_url:url',
                    // 'path',
                    // 'name',
                    // 'type',
                    // 'size',
                    // 'address:ntext',
                    // 'description:ntext',
                    // 'created_at',
                    // 'updated_at',
                    // 'created_by',
                    // 'updated_by',
                    // 'is_deleted',
                    // 'deleted_at',
                    // 'deleted_by',
                    // 'verlock',
                    // 'uuid',

                    ['class' => ActionColumn::class],
                ],
            ]); ?>
    
        </div>
        <div class="card-footer">
            <?php echo getDataProviderSummary($dataProvider); ?>
        </div>
    </div>

</div>
