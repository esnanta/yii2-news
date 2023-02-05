<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Outlet */

$this->title = 'Update Outlet: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Outlet', 'url' => ['index']];
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

        <div class="outlet-update">

            <?= $this->render('_form', [
                'model' => $model,
                'customerList'=>$customerList,
                'staffList'=>$staffList,
                'billingStatusList'=>$billingStatusList,
                'assemblyTypeList'=>$assemblyTypeList,
                'outletDetails'=>$outletDetails
            ]) ?>

        </div>
        
    </div>
</div>


