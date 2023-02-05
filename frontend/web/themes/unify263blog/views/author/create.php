<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\Author $model
 */

$this->title = 'Create Author';
$this->params['breadcrumbs'][] = ['label' => 'Authors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">
            Please fill out the form below
            <div class="pull-right">
                Author            </div>            
        </div>
    </div>
    <div class="panel-body">

        <div class="author-create">

            <?= $this->render('_form', [
                'model' => $model,
            ]) 
            ?>

        </div>
        
    </div>
</div>