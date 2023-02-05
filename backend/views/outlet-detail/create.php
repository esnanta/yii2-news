<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\OutletDetail $model
 */

$this->title = 'Create Outlet Detail';
$this->params['breadcrumbs'][] = ['label' => 'Outlet Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">
            Please fill out the form below
            <div class="pull-right">
                OutletDetail            </div>            
        </div>
    </div>
    <div class="panel-body">

        <div class="outlet-detail-create">

            <?= $this->render('_form', [
                'model' => $model,
            ]) 
            ?>

        </div>
        
    </div>
</div>