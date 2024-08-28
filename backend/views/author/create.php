<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\Author $model
 */

$this->title = 'Create Author';
$this->params['breadcrumbs'][] = ['label' => 'Authors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="card border-default mb-3">
    <div class="card-header"><?=Yii::t('app', 'Please fill out the form below')?>
        <span class="float-right float-end">
            <?= Html::encode($this->title) ?>
        </span>
    </div>
    <div class="card-body text-default">
        <div class="author-create">
            <?= $this->render('_form', [
                'model' => $model,
                'officeList' => $officeList,
            ])
            ?>
        </div>
    </div>
</div>