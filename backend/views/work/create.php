<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\Work $model
 */

$this->title = 'Create Work';
$this->params['breadcrumbs'][] = ['label' => 'Works', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">
            Please fill out the form below
            <div class="pull-right">
                Work            </div>            
        </div>
    </div>
    <div class="panel-body">

        <div class="work-create">

            <?= $this->render('_form', [
                'model' => $model,
                'workTypeList'=>$workTypeList
            ]) 
            ?>

        </div>
        
    </div>
</div>