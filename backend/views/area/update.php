<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\Area $model
 */

$this->title = 'Update Area: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Areas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>


<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">
            Please fill out the form below
            <div class="pull-right">
                Area            </div>            
        </div>
    </div>
    <div class="panel-body">

        <div class="area-update">

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>

        </div>
        
    </div>
</div>



