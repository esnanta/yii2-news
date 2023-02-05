<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\Content $model
 */

$this->title = 'Create Content';
$this->params['breadcrumbs'][] = ['label' => 'Contents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">
            Please fill out the form below
            <div class="pull-right">
                Content            </div>            
        </div>
    </div>
    <div class="panel-body">

        <div class="content-create">

            <?= $this->render('_form', [
                'model' => $model,
                'dataList'=>$dataList
            ]) 
            ?>

        </div>
        
    </div>
</div>