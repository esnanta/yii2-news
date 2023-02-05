<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\Content $model
 */

$this->title = 'Update Content: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Contents', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
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

        <div class="content-update">

            <?= $this->render('_form', [
                'model' => $model,
                'dataList'=>$dataList
            ]) ?>

        </div>
        
    </div>
</div>

