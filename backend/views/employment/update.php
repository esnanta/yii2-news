<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\Employment $model
 */

$this->title = 'Update Employment: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Employments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">
            Please fill out the form below
            <div class="pull-right">
                <?= Html::encode($this->title) ?>            
            </div>            
        </div>
    </div>
    <div class="panel-body">

        <div class="employment-update">

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>

        </div>
        
    </div>
</div>


