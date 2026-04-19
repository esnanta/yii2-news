<?php

use yii\helpers\Html;
use yii\grid\GridView;
use rmrevin\yii\fontawesome\FAS;

/**
 * @var yii\web\View $this
 * @var common\models\search\AuthorSocialAccountSearch $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var array $officeOptions
 * @var array $authorOptions
 * @var array $platformOptions
 */

$this->title = Yii::t('backend', 'Author Social Accounts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="author-social-account-index">
    <div class="card">
        <div class="card-header">
            <?php echo Html::a(FAS::icon('user-plus').' '.Yii::t('backend', 'Add New {modelClass}', [
                'modelClass' => 'Author Social Account',
            ]), ['create'], ['class' => 'btn btn-success']); ?>
        </div>

        <div class="card-body p-0">
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
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
                        'attribute' => 'author_id',
                        'filter' => $authorOptions,
                        'value' => static fn ($model): string => $authorOptions[$model->author_id] ?? '-',
                        'options' => ['style' => 'width: 12%'],
                        'contentOptions' => ['style' => 'white-space: nowrap;'],
                    ],
                    [
                        'attribute' => 'platform_id',
                        'filter' => $platformOptions,
                        'value' => static fn ($model): string => $platformOptions[$model->platform_id] ?? '-',
                        'options' => ['style' => 'width: 12%'],
                        'contentOptions' => ['style' => 'white-space: nowrap;'],
                    ],
                    [
                        'attribute' => 'username',
                        'contentOptions' => ['style' => 'white-space: normal; word-break: break-word;'],
                    ],
                    // 'profile_url:url',
                    // 'is_primary',
                    // 'is_visible',
                    // 'sequence',
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
                        'class' => \common\widgets\ActionColumn::class,
                        'options' => ['style' => 'width: 8%'],
                        'contentOptions' => ['style' => 'white-space: nowrap;'],
                    ],
                ],
            ]); ?>
    
        </div>
        <div class="card-footer">
            <?php echo getDataProviderSummary($dataProvider) ?>
        </div>
    </div>

</div>
