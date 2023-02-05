<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\WorkType $model
 */

$this->title = 'Update Work Type: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Work Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>


<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">
            Please fill out the form below
            <div class="pull-right">
                WorkType            </div>            
        </div>
    </div>
    <div class="panel-body">

        <div class="work-type-update">

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>

        </div>
        
    </div>
</div>



