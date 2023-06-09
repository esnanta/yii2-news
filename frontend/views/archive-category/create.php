<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Archive $model */

$this->title = 'Create Archive';
$this->params['breadcrumbs'][] = ['label' => 'Archives', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="archive-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
