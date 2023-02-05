<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\Comment $model
 */

$this->title = 'Create Comment';
$this->params['breadcrumbs'][] = ['label' => 'Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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

        <div class="comment-create">

            <?= $this->render('_form', [
                'model' => $model,
                'publishList'=>$publishList
            ]) 
            ?>

        </div>
        
    </div>
</div>