<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\ArticleCategory $model
 */

$this->title = Yii::t('app', 'Create Article Category') ;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Article Categories'), 'url' => ['index']];
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
        <div class="article-category-create">
            <?= $this->render('_form', [
                'model' => $model,
                'officeList' => $officeList,
                'dataList'=>$dataList,
                'labelList'=>$labelList
            ])
            ?>
        </div>
    </div>
</div>