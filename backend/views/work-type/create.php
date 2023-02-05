<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\WorkType $model
 */

$this->title = 'Create Work Type';
$this->params['breadcrumbs'][] = ['label' => 'Work Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">
            Please fill out the form below
            <div class="pull-right">
                WorkType            </div>            
        </div>
    </div>
    <div class="panel-body">

        <div class="work-type-create">

            <?= $this->render('_form', [
                'model' => $model,
            ]) 
            ?>

        </div>
        
    </div>
</div>