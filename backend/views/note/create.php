<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\Note $model
 */

$this->title = 'Create Note';
$this->params['breadcrumbs'][] = ['label' => 'Notes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">
            Please fill out the form below
            <div class="pull-right">
                <?= Html::encode($this->title) ?>              </div>            
        </div>
    </div>
    <div class="panel-body">

        <div class="note-create">

            <?= $this->render('_form', [
                'model' => $model,
                'dataList'=>$dataList
            ]) 
            ?>

        </div>
        
    </div>
</div>