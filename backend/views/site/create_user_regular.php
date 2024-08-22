<?php

/**
 * @var yii\web\View $this
 * @var common\models\UserDektrium $model
 * @var common\models\Employment $employmentList
 */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Regular',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Staff'), 'url' => ['staff/index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="card border-default mb-3">
    <div class="card-header">
        <?=Yii::t('app', 'Please fill out the form below')?>
        <span class="float-right"><?=$this->title;?></span>
    </div>
    <div class="card-body text-default">
        <div class="fuel-create">
            <?= $this->render('_form_user_regular', [
                'model' => $model,
                'employmentList' => $employmentList,
                'userTypeList' => $userTypeList,
            ]) 
            ?>
        </div>
    </div>
</div>