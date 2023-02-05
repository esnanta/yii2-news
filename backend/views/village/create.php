<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\Village $model
 */

$this->title = 'Create Village';
$this->params['breadcrumbs'][] = ['label' => 'Villages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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

        <div class="village-create">

            <?= $this->render('_form', [
                'model' => $model,
                'areaList'=>$areaList
            ]) 
            ?>

        </div>
        
    </div>
</div>