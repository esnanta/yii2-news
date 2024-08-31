<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\Page $model
 */

$this->title = 'Update Page: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Pages', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';

$view = Html::a('<i class="glyphicon glyphicon-eye-open"></i>', ['view','id'=>$model->id], ['class' => 'pull-right detail-button','style'=>'padding:0 5px']);
?>

<div class="card border-default mb-3">
    <div class="card-header"><?=Yii::t('app', 'Please fill out the form below')?>
        <span class="float-right float-end">
            <?= Html::encode($this->title) ?>
        </span>
    </div>
    <div class="card-body text-secondary">
        <div class="card-text">
            <?= $this->render('_form', [
                'model' => $model,
                'dataList' => $dataList,
                'pageTypeList' => $pageTypeList
            ]) ?>
        </div>
    </div>
</div>