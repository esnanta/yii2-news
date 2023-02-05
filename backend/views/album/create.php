<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\Album $model
 */

$this->title = 'Create Album';
$this->params['breadcrumbs'][] = ['label' => 'Albums', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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

        <div class="album-create">

            <?= $this->render('_form', [
                'model' => $model,
                'dataList'=>$dataList
            ]) 
            ?>

        </div>
        
    </div>
</div>