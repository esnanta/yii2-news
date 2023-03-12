<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\ThemeDetail $model
 */

$this->title = 'Update ThemeDetail: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'ThemeDetails', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';

$view = Html::a('<i class="glyphicon glyphicon-eye-open"></i>', ['view','id'=>$model->id], ['class' => 'pull-right detail-button','style'=>'padding:0 5px']);
?>

<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">
            Please fill out the form below
            <div class="pull-right">
                <?=$view;?>            
            </div>            
        </div>
    </div>
    <div class="panel-body">

        <div class="theme-detail-update">

            <?= $this->render($form, [
                'model' => $model,
                'dataList'=>$dataList,
                'editor'=>$editor
            ]) ?>

        </div>
        
    </div>
</div>

