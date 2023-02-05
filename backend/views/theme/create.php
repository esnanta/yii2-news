<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\Theme $model
 */

$this->title = 'Create Theme';
$this->params['breadcrumbs'][] = ['label' => 'Themes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">
            Please fill out the form below
            <div class="pull-right">
                Theme            </div>            
        </div>
    </div>
    <div class="panel-body">

        <div class="theme-create">

            <?= $this->render('_form', [
                'model' => $model,
            ]) 
            ?>

        </div>
        
    </div>
</div>