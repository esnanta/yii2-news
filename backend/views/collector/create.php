<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\Collector $model
 */

$this->title = 'Create Collector';
$this->params['breadcrumbs'][] = ['label' => 'Collectors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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

        <div class="collector-create">

            <?= $this->render('_form', [
                'model' => $model,
                'areaList'=>$areaList,
                'staffList'=>$staffList,                     
            ]) 
            ?>

        </div>
        
    </div>
</div>