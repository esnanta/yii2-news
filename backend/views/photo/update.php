<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\Photo $model
 */

$this->title = 'Update Photo: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Photos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
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

        <div class="photo-update">

            <?= $this->render('_form', [
                'model' => $model,
                'dataList'=>$dataList
            ]) ?>

        </div>
        
    </div>
</div>


