<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\Staff $model
 */

$this->title = 'Update Staff: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Staff', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">
            Please fill out the form below
            <div class="pull-right">
                Staff            </div>            
        </div>
    </div>
    <div class="panel-body">

        <div class="staff-update">

            <?= $this->render('_form', [
                'model' => $model,
                'employmentList'=>$employmentList,
                'genderList'=>$genderList
            ]) ?>

        </div>
        
    </div>
</div>


