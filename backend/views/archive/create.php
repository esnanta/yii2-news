<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\Archive $model
 */

$this->title = 'Create Archive';
$this->params['breadcrumbs'][] = ['label' => 'Archives', 'url' => ['index']];
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

        <div class="archive-create">

            <?= $this->render('_form', [
                'model' => $model,
                'archiveCategoryList' => $archiveCategoryList,
                'isVisibleList' => $isVisibleList,
            ]) 
            ?>

        </div>
        
    </div>
</div>