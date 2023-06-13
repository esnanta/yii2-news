<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var backend\models\Archive $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Archives', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="archive-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'is_visible',
            'archive_type',
            'archive_category_id',
            'title',
            'date_issued',
            'file_name',
            'archive_url:url',
            'size',
            'mime_type',
            'view_counter',
            'download_counter',
            'description:ntext',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
            'is_deleted',
            'deleted_at',
            'deleted_by',
            'verlock',
        ],
    ]) ?>

</div>
