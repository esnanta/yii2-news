<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\ThemeDetail $model
 */

$this->title = 'Create ThemeDetail';
$this->params['breadcrumbs'][] = ['label' => 'ThemeDetails', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">
            Please fill out the form below
            <div class="pull-right">
                ThemeDetail            </div>            
        </div>
    </div>
    <div class="panel-body">

        <div class="theme-detail-create">

            <?= $this->render('_form', [
                'model' => $model,
                'dataList'=>$dataList,
                'editor'=>$editor,
            ]) 
            ?>

        </div>
        
    </div>
</div>