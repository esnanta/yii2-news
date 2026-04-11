<?php

use common\models\SocialPlatform;
use common\widgets\ActionColumn;
use rmrevin\yii\fontawesome\FAS;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\search\SocialPlatformSearch $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 */

$this->title = Yii::t('backend', 'Social Platforms');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="social-platform-index">
    <div class="card">
        <div class="card-header">
            <?php echo Html::a(FAS::icon('user-plus').' '.Yii::t('backend', 'Add New {modelClass}', [
                'modelClass' => 'Social Platform',
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
                        'attribute' => 'code',
                        'options' => ['style' => 'width: 12%'],
                        'contentOptions' => ['style' => 'white-space: nowrap;'],
                    ],
                    [
                        'attribute' => 'name',
                        'options' => ['style' => 'width: 20%'],
                        'contentOptions' => ['style' => 'white-space: normal; word-break: break-word;'],
                    ],
                    [
                        'attribute' => 'base_url',
                        'format' => 'url',
                        'contentOptions' => ['style' => 'white-space: normal; word-break: break-word;'],
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
