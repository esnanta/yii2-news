<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\Billing $model
 */

$this->title = 'Update Billing: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Billings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>


<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">
            Please fill out the form below
            <div class="pull-right">
                Billing            </div>            
        </div>
    </div>
    <div class="panel-body">

        <div class="billing-update">

            <?= $this->render('_form', [
                'model' => $model,
                'billingTypeList'=>$billingTypeList,
                'paymentStatusList'=>$paymentStatusList                
            ]) ?>

        </div>
        
    </div>
</div>



