<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\Account $model
 */

$this->title = 'Create Account';
$this->params['breadcrumbs'][] = ['label' => 'Accounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">
            Please fill out the form below
            <div class="pull-right">
                Account            </div>            
        </div>
    </div>
    <div class="panel-body">

        <div class="account-create">

            <?= $this->render('_form', [
                'model' => $model,
                'dataList'=>$dataList
            ]) 
            ?>

        </div>
        
    </div>
</div>