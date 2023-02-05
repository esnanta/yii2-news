<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\Counter $model
 */

$this->title = 'Create Counter';
$this->params['breadcrumbs'][] = ['label' => 'Counters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="counter-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
