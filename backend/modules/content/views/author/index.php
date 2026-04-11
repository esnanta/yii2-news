<?php

use common\widgets\ActionColumn;
use kartik\widgets\Select2;
use rmrevin\yii\fontawesome\FAS;
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
            <?php echo Html::a(FAS::icon('user-plus').' '.Yii::t('backend', 'Add New {modelClass}', [
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
                    'class' => ['table', 'table-striped', 'table-bordered', 'mb-0', 'table-sm'],
                    'style' => 'width: 100%; table-layout: fixed;',
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
                        'label' => Yii::t('backend', 'Office'),
                        'options' => ['style' => 'width: 25%'],
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
                            'options' => ['placeholder' => Yii::t('backend', 'Select office')],
                            'pluginOptions' => [
                                'allowClear' => true,
                            ],
                        ]),
                        'contentOptions' => ['style' => 'white-space: normal; word-break: break-word;'],
                    ],
                    [
                        'attribute' => 'title',
                        'options' => ['style' => 'width: 45%'],
                        'contentOptions' => ['style' => 'white-space: normal; word-break: break-word;'],
                    ],
                    [
                        'attribute' => 'phone_number',
                        'options' => ['style' => 'width: 20%'],
                        'contentOptions' => ['style' => 'white-space: nowrap;'],
                    ],
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

                    [
                        'class' => ActionColumn::class,
                        'options' => ['style' => 'width: 5%'],
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
