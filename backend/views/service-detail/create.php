<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\ServiceDetail $model
 */

$this->title = 'Create Service Detail';
$this->params['breadcrumbs'][] = ['label' => 'Service Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="service-detail-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
