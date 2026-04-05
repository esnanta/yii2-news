<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\Article $model
 */

$this->title = 'Create Blog';
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">
            Please fill out the form below
            <div class="pull-right">
                Blog            </div>            
        </div>
    </div>
    <div class="panel-body">

        <div class="blog-create">

            <?= $this->render('_form', [
                'model' => $model,
                'tagList'=>$tagList,
                'authorList'=>$authorList,
                'categoryList'=>$categoryList,
                'publishList'=>$publishList,
                'approvalList'=>$approvalList,
                'pinnedList'=>$pinnedList,                 
            ]) 
            ?>

        </div>
        
    </div>
</div>