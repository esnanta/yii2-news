<?php

use common\models\Staff;
use common\widgets\ActionColumn;
use rmrevin\yii\fontawesome\FAS;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\search\StaffSearch $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var array $officeOptions
 * @var array $jobTitleOptions
 */

$this->title = Yii::t('backend', 'Staff');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="staff-index">
    <div class="card">
        <div class="card-header">
            <?php echo Html::a(FAS::icon('user-plus').' '.Yii::t('backend', 'Add New {modelClass}', [
                'modelClass' => 'Staff',
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
                        'filter' => $officeOptions,
                        'value' => static fn ($model): string => $officeOptions[$model->office_id] ?? '-',
                        'options' => ['style' => 'width: 12%'],
                        'contentOptions' => ['style' => 'white-space: nowrap;'],
                    ],
                    [
                        'attribute' => 'job_title_id',
                        'filter' => $jobTitleOptions,
                        'value' => static fn ($model): string => $jobTitleOptions[$model->job_title_id] ?? '-',
                        'options' => ['style' => 'width: 12%'],
                        'contentOptions' => ['style' => 'white-space: nowrap;'],
                    ],
                    [
                        'attribute' => 'title',
                        'contentOptions' => ['style' => 'white-space: normal; word-break: break-word;'],
                    ],
                    'initial',
                    [
                        'attribute' => 'gender',
                        'value' => function ($model) {
                            return $model->genders()[$model->gender] ?? '';
                        },
                        'filter' => Staff::genders(),
                    ],
                    [
                        'attribute' => 'status',
                        'value' => function ($model) {
                            return $model->statuses()[$model->status] ?? '';
                        },
                        'filter' => Staff::statuses(),
                    ],
                    [
                        'class' => ActionColumn::class,
                        'options' => ['style' => 'width: 8%'],
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
