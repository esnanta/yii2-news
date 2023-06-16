<?php

use backend\models\Archive;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var backend\models\ArchiveSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Archives';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="archive-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Archive', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'is_visible',
            'archive_type',
            'archive_category_id',
            'title',
            //'date_issued',
            //'file_name',
            //'archive_url:url',
            //'size',
            //'mime_type',
            //'view_counter',
            //'download_counter',
            //'description:ntext',
            //'created_at',
            //'updated_at',
            //'created_by',
            //'updated_by',
            //'is_deleted',
            //'deleted_at',
            //'deleted_by',
            //'verlock',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Archive $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
