<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\Comment $model
 */

$this->title = 'Update Comment: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>


<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">
            Please fill out the form below
            <div class="pull-right">
                Comment            </div>            
        </div>
    </div>
    <div class="panel-body">

        <div class="comment-update">

            <?= $this->render('_form', [
                'model' => $model,
                'publishList'=>$publishList
            ]) ?>

        </div>
        
    </div>
</div>



