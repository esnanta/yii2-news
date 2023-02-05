<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\Counter $model
 */

$this->title = 'Update Counter: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Counters', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="counter-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
