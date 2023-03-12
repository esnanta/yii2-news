<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\SocialMedia $model
 */

$this->title = 'Create Social Media';
$this->params['breadcrumbs'][] = ['label' => 'Social Media', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">
            Please fill out the form below
            <div class="pull-right">
                SocialMedia            </div>            
        </div>
    </div>
    <div class="panel-body">

        <div class="social-media-create">

            <?= $this->render('_form', [
                'model' => $model,
                'socialMediaList' => $socialMediaList,
            ]) 
            ?>

        </div>
        
    </div>
</div>