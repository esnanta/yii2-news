<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\Staff $model
 * @var common\models\Office $officeList
 * @var common\models\Employment $employmentList
 * @var common\models\Staff $genderList
 * @var common\models\Staff $activeStatusList
 */

$this->title = 'Create Staff';
$this->params['breadcrumbs'][] = ['label' => 'Staff', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="card border-default mb-3">
    <div class="card-header"><?=Yii::t('app', 'Please fill out the form below')?>
        <span class="float-right float-end">
            <?= Html::encode($this->title) ?>
        </span>
    </div>
    <div class="card-body text-default">
        <div class="card-text">
            <?= $this->render('_form', [
                'model' => $model,
                'officeList'=>$officeList,
                'employmentList'=>$employmentList,
                'genderList' => $genderList,
                'activeStatusList' => $activeStatusList
            ])
            ?>
        </div>
    </div>
</div>