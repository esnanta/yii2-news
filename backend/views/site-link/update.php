<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\SiteLink $model
 */

$this->title = 'Update Site Link: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Site Links', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>


<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">
            Please fill out the form below
            <div class="pull-right">
                SiteLink            </div>            
        </div>
    </div>
    <div class="panel-body">

        <div class="site-link-update">

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>

        </div>
        
    </div>
</div>



