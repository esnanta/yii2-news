<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\Customer $model
 */

$this->title = 'Update Customer: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Customers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>


<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">
            Please fill out the form below
            <div class="pull-right">
                Customer            </div>            
        </div>
    </div>
    <div class="panel-body">

        <div class="customer-update">

            <?= $this->render('_form', [
                'model' => $model,
                'areaList'=>$areaList, 
                'genderList'=>$genderList,
                'villageList'=>$villageList,
            ]) ?>

        </div>
        
    </div>
</div>



