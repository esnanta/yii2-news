<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\Profile $model
 */

$this->title = 'Update Profile: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Profiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->user_id]];
$this->params['breadcrumbs'][] = 'Update';
?>


<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">
            Please fill out the form below
            <div class="pull-right">
                Profile            </div>            
        </div>
    </div>
    <div class="panel-body">

        <div class="profile-update">

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>

        </div>
        
    </div>
</div>



