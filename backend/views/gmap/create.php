<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Gmap */

$this->title = 'Create Gmap';
$this->params['breadcrumbs'][] = ['label' => 'Gmap', 'url' => ['index']];
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

        <div class="gmap-create">
            <?= $this->render('_form', [
                'model' => $model,
                'customerList'=>$customerList
            ]) ?>

        </div>
        
    </div>
</div>


