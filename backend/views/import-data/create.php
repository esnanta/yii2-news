<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\ImportData */

$this->title = 'Create Import Data';
$this->params['breadcrumbs'][] = ['label' => 'Import Data', 'url' => ['index']];
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




