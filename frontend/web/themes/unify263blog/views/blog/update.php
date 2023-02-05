<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\Blog $model
 */

$this->title = 'Update Blog: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Blogs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->blog_id]];
$this->params['breadcrumbs'][] = 'Update';
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

        <div class="blog-update">

            <?= $this->render('_form', [
                'model' => $model,
                'tagList'=>$tagList,
                'authorList'=>$authorList,
                'categoryList'=>$categoryList,
                'publishList'=>$publishList,
                'approvalList'=>$approvalList,
                'pinnedList'=>$pinnedList,         
            ]) ?>

        </div>
        
    </div>
</div>



