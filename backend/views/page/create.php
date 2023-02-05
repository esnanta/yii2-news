<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\Page $model
 */

$this->title = 'Create Page';
$this->params['breadcrumbs'][] = ['label' => 'Pages', 'url' => ['index']];
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

        <div class="page-create">

            <?= $this->render('_form', [
                'model' => $model,
                'pageTypeList'=>$pageTypeList
            ]) 
            ?>

        </div>
        
    </div>
</div>