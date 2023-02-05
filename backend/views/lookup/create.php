<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\Lookup $model
 */

$this->title = 'Create Lookup';
$this->params['breadcrumbs'][] = ['label' => 'Lookups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">
            Please fill out the form below
            <div class="pull-right">
                Lookup            </div>            
        </div>
    </div>
    <div class="panel-body">

        <div class="lookup-create">

            <?= $this->render('_form', [
                'model' => $model,
                'yesNoList'=>$yesNoList
            ]) 
            ?>

        </div>
        
    </div>
</div>