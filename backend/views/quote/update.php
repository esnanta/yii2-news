<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\Quote $model
 */

$this->title = 'Update Quote: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Quotes', 'url' => ['index']];
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

        <div class="quote-update">

            <?= $this->render('_form_avatar', [
                'model' => $model,
            ]) ?>

        </div>
        
    </div>
</div>



