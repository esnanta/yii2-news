<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Service */

$this->title = 'Update Service: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Service', 'url' => ['index']];
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

        <div class="service-update">

            <?= $this->render('_form', [
                'model' => $model,
                'customerList'=>$customerList,
                'staffList'=>$staffList, 
                'serviceDetails'=>$serviceDetails,
                'serviceTypeList'=>$serviceTypeList,
                'billingCycleList'=>$billingCycleList
            ]) ?>

        </div>
        
    </div>
</div>