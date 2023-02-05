<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\Village $model
 */

$this->title = 'Update Village: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Villages', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>


<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">
            Please fill out the form below
            <div class="pull-right">
                Village            </div>            
        </div>
    </div>
    <div class="panel-body">

        <div class="village-update">

            <?= $this->render('_form', [
                'model' => $model,
                'areaList'=>$areaList
            ]) ?>

        </div>
        
    </div>
</div>



