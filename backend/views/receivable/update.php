<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Receivable */

$this->title = 'Update Receivable: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Receivable', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>


<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">
            Please fill out the form below
            <div class="pull-right">
                <?= Html::encode($this->title) ?>            </div>            
        </div>
    </div>
    <div class="panel-body">

        <div class="receivable-update">

            <?= $this->render('_form', [
                'model' => $model,
                'customerList' => $customerList,
                'staffList' => $staffList,
                'receivableDetails'=>$receivableDetails
            ]) ?>

        </div>
        
    </div>
</div>

