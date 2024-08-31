<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\AuthorMedia $model
 */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Author Media',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Author Media'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="card border-default mb-3">
    <div class="card-header">
        <?=Yii::t('app', 'Please fill out the form below')?>
        <span class="float-right float-end">
            <?= Html::encode($this->title) ?>
        </span>
    </div>
    <div class="card-body text-secondary">
        <div class="card-text">
            <?= $this->render('_form', [
                'model' => $model,
                'officeList' => $officeList
            ]) 
            ?>
        </div>
    </div>
</div>