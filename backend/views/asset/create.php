<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\Asset $model
 */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Asset',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Assets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="card border-default mb-3">
    <div class="card-header"> <?=Yii::t('app', 'Please fill out the form below');?>
        <span class="float-right">
            <?= Html::encode($this->title) ?>
        </span>
    </div>
    <div class="card-body text-default">
        <div class="period-create">
            <?= $this->render('_form', [
                'model' => $model,
                'officeList' => $officeList,
                'assetCategoryList'=>$assetCategoryList,
                'isVisibleList' => $isVisibleList,
                'assetTypeList' => $assetTypeList,
            ])
            ?>
        </div>
    </div>
</div>