<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ArchiveCategory */

$this->title = 'Update Archive Category: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Archive Category', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="archive-category-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
