<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\AccountReceivable */

$this->title = 'Create Account Receivable';
$this->params['breadcrumbs'][] = ['label' => 'Account Receivable', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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

        <div class="account-receivable-create">

            <?= $this->render('_form', [
                'model' => $model,
                'dataList'=>$dataList,
            ]) ?>

        </div>
        
    </div>
</div>

