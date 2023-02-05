<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\WorkRequest */

$this->title = 'Create Work Request';
$this->params['breadcrumbs'][] = ['label' => 'Work Request', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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

        <div class="work-request-create">
            
            <?= $this->render('_form', [
                'model' => $model,
                'staffList'=>$staffList,
                'workRequestDetails'=>$model->workRequestDetails
            ]) ?>

        </div>

    </div>
</div>


