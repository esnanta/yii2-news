<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\Article $model
 */

$this->title = 'Create Article';
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="card border-default mb-3">
    <div class="card-header">
        <?=Yii::t('app', 'Please fill out the form below')?>
        <span class="pull-right">
            <?= Html::encode($this->title) ?>
        </span>
    </div>
    <div class="card-body text-default">
        <div class="article-category">
            <?= $this->render('_form', [
                'model' => $model,
                'tagList'=>$tagList,
                'authorList'=>$authorList,
                'articleCategoryList' => $articleCategoryList,
            ])
            ?>
        </div>
    </div>
</div>
