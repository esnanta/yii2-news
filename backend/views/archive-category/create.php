<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\ArchiveCategory $model
 */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Archive Category',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Archive Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="card border-default mb-3">
    <div class="card-header">Please fill out the form below <span class="pull-right">ArchiveCategory</span></div>
    <div class="card-body text-default">
        <!--<h5 class="card-title">Please fill out the form below</h5>-->
        <div class="archive-category-create">

            <?= $this->render('_form', [
                'model' => $model,
            ]) 
            ?>
        </div>

    </div>
</div>