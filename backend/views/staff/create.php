<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\Staff $model
 */

$this->title = 'Create Staff';
$this->params['breadcrumbs'][] = ['label' => 'Staff', 'url' => ['index']];
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

        <div class="staff-create">

            <?= $this->render('_form', [
                'model' => $model,
                'employmentList'=>$employmentList,
                'genderStatusList'=>$genderStatusList
            ]) 
            ?>

        </div>
        
    </div>
</div>