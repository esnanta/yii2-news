<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\PageType $model
 */

$this->title = 'Update Page Type: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Page Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>


<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">
            Please fill out the form below
            <div class="pull-right">
                <?= Html::encode($this->title) ?>              <!-- comment --></div>            
        </div>
    </div>
    <div class="panel-body">

        <div class="page-type-update">

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>

        </div>
        
    </div>
</div>



