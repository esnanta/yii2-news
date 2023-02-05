<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\SiteLink $model
 */

$this->title = 'Create Site Link';
$this->params['breadcrumbs'][] = ['label' => 'Site Links', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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

        <div class="site-link-create">

            <?= $this->render('_form', [
                'model' => $model,
            ]) 
            ?>

        </div>
        
    </div>
</div>