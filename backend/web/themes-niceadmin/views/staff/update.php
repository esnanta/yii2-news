<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\Staff $model
 * @var common\models\Office $officeList
 */

$this->title = 'Update Staff: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Staff', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="card border-default mb-3">
    <div class="card-header"><?=Yii::t('app', 'Please fill out the form below')?>
        <span class="float-right float-end">
            <?= Html::encode($this->title) ?>
        </span>
    </div>
    <div class="card-body text-default">
        <div class="card-text">
            <?= $this->render('_form_avatar', [
                'model' => $model,
                'officeList'=>$officeList
            ]) ?>
        </div>
    </div>
</div>
