<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\Archive $model
 */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Archive',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Archives'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="card border-default mb-3">
    <div class="card-header">Please fill out the form below <span class="pull-right">Archive</span></div>
    <div class="card-body text-default">
        <div class="archive-create">
            <?= $this->render('_form', [
                'model' => $model,
                'archiveCategoryList'=>$archiveCategoryList,
                'isVisibleList' => $isVisibleList,
            ]) 
            ?>
        </div>

    </div>
</div>