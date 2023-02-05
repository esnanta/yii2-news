<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\Collector $model
 */

$this->title = 'Update Collector: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Collectors', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>


<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">
            Please fill out the form below
            <div class="pull-right">
                Collector            </div>            
        </div>
    </div>
    <div class="panel-body">

        <div class="collector-update">

            <?= $this->render('_form', [
                'model' => $model,
                'areaList'=>$areaList,
                'staffList'=>$staffList,                     
            ]) ?>

        </div>
        
    </div>
</div>



