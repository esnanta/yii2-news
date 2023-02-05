<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\PageType $model
 */

$this->title = 'Create Page Type';
$this->params['breadcrumbs'][] = ['label' => 'Page Types', 'url' => ['index']];
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

        <div class="page-type-create">

            <?= $this->render('_form', [
                'model' => $model,
            ]) 
            ?>

        </div>
        
    </div>
</div>