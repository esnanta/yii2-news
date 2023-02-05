<?php

use yii\helpers\Html;
/**
 * @var yii\web\View $this
 * @var backend\models\Customer $model
 */

$this->title = 'Create Customer';
$this->params['breadcrumbs'][] = ['label' => 'Customers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">
            Please fill out the form below
            <div class="pull-right">
                Customer            </div>            
        </div>
    </div>
    <div class="panel-body">

        <div class="customer-create">

            <?= $this->render('_form', [
                'model' => $model,
                'areaList'=>$areaList,   
                'genderList'=>$genderList,
                'villageList'=>$villageList,
            ]) 
            ?>

        </div>
        
    </div>
</div>