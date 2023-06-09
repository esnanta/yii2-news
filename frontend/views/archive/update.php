<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Archive $model */

$this->title = 'Update Archive: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Archives', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="archive-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
