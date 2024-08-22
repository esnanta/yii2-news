<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\Profile $model
 */

$this->title = 'Create Profile';
$this->params['breadcrumbs'][] = ['label' => 'Profiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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

        <div class="profile-create">

            <?= $this->render('_form', [
                'model' => $model,
            ]) 
            ?>

        </div>
        
    </div>
</div>