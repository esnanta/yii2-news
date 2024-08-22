<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\Page $model
 */

$this->title = 'Create Page';
$this->params['breadcrumbs'][] = ['label' => 'Pages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="card border-default mb-3">
    <div class="card-header"><?=Yii::t('app', 'Please fill out the form below')?>
        <span class="pull-right">
            <?= Html::encode($this->title) ?>
        </span>
    </div>
    <div class="card-body text-default">
        <div class="page-create">
            <?= $this->render('_form', [
                'model' => $model,
                'dataList' => $dataList,
                'pageTypeList' => $pageTypeList
            ])
            ?>
        </div>
    </div>
</div>