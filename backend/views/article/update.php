<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\Article $model
 */

$this->title = 'Update Article: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">
            <?=Yii::t('app', 'Please fill out the form below')?>
            <div class="pull-right">
                <?= Html::encode($this->title) ?>
            </div>
        </div>
    </div>
    <div class="panel-body">

        <div class="article-update">

            <?= $this->render('_form', [
                'model'         =>$model,
                'tagsFlip'      =>$tagsFlip,
                'tagList'       =>$tagList,
                'authorList'    =>$authorList,
                'articleCategoryList' => $articleCategoryList,
            ]) ?>

        </div>

    </div>
</div>



