<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\Archive */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Archive', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="archive-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= 'Archive'.' '. Html::encode($this->title) ?></h2>
        </div>
        <div class="col-sm-3" style="margin-top: 15px">
            
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ])
            ?>
        </div>
    </div>

    <div class="row">
<?php 
    $gridColumn = [
        ['attribute' => 'id', 'visible' => false],
        'is_visible',
        'archive_type',
        [
            'attribute' => 'archiveCategory.title',
            'label' => 'Archive Category',
        ],
        'title',
        'date_issued',
        'file_name',
        'archive_url:url',
        'size',
        'mime_type',
        'view_counter',
        'download_counter',
        'description:ntext',
        'is_deleted',
        ['attribute' => 'verlock', 'visible' => false],
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]);
?>
    </div>
    <div class="row">
        <h4>ArchiveCategory<?= ' '. Html::encode($this->title) ?></h4>
    </div>
    <?php 
    $gridColumnArchiveCategory = [
        ['attribute' => 'id', 'visible' => false],
        'title',
        'sequence',
        'description:ntext',
        'is_deleted',
        ['attribute' => 'verlock', 'visible' => false],
    ];
    echo DetailView::widget([
        'model' => $model->archiveCategory,
        'attributes' => $gridColumnArchiveCategory    ]);
    ?>
</div>
