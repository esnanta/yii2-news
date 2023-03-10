<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\ArchiveCategory $model
 */

$this->title = 'Update Archive Category: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Archive Categories', 'url' => ['index']];
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

        <div class="archive-category-update">

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>

        </div>
        
    </div>
</div>



