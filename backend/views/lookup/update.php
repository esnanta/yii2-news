<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\Lookup $model
 */

$this->title = 'Update Lookup: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Lookups', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>


<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">
            Please fill out the form below
            <div class="pull-right">
                Lookup            </div>            
        </div>
    </div>
    <div class="panel-body">

        <div class="lookup-update">

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>

        </div>
        
    </div>
</div>



