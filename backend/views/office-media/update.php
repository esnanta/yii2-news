<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\OfficeMedia $model
 */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Office Media',
]) . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Office Media'),
    'url' => ['office/view','id'=>$model->office_id]];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">
            <?=Yii::t('app', 'Please fill out the form below')?>
            <div class="pull-right">
                <?= Html::encode($this->title) ?>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <div class="office-media-update">
            <?= $this->render('_form', [
                'model' => $model,
                'officeList' => $officeList,
                'mediaTypeList' => $mediaTypeList,
                'iconList' => $iconList
            ]) ?>
        </div>
    </div>
</div>



