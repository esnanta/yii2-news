<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\WorkRequestDetail */

$this->title = 'Create Work Request Detail';
$this->params['breadcrumbs'][] = ['label' => 'Work Request Detail', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="work-request-detail-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
