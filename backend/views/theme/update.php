<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\Theme $model
 */

$this->title = 'Update Theme: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Themes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
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

        <div class="theme-update">

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>

        </div>
        
    </div>
</div>


