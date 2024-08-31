<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\StaffMedia $model
 */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Staff Media',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Staff Media'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="card border-default mb-3">
    <div class="card-header"><?=Yii::t('app', 'Please fill out the form below')?>
        <span class="pull-right">
            <?= Html::encode($this->title) ?>
        </span>
    </div>
    <div class="card-body text-secondary">
        <div class="card-text">
            <?= $this->render('_form', [
                'model' => $model,
                'officeList' => $officeList,
            ]) 
            ?>
        </div>
    </div>
</div>