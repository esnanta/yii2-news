<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\Category $model
 */

$this->title = 'Create Category';
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
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

        <div class="category-create">

            <?= $this->render('_form', [
                'model' => $model,
                'dataList'=>$dataList,
                'labelList'=>$labelList
            ]) 
            ?>

        </div>
        
    </div>
</div>