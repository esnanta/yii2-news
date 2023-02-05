<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\Page $model
 */

$this->title = 'Update Page: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Pages', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>


<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">
            Please fill out the form below
            <div class="pull-right">
                Page            </div>            
        </div>
    </div>
    <div class="panel-body">

        <div class="page-update">

            <?= $this->render('_form', [
                'model' => $model,
                'pageTypeList'=>$pageTypeList
            ]) ?>

        </div>
        
    </div>
</div>



