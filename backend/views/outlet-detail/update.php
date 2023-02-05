<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\OutletDetail $model
 */

$this->title = 'Update Outlet Detail: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Outlet Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>


<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">
            Please fill out the form below
            <div class="pull-right">
                OutletDetail            </div>            
        </div>
    </div>
    <div class="panel-body">

        <div class="outlet-detail-update">

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>

        </div>
        
    </div>
</div>



