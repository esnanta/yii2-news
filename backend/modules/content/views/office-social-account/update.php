<?php

/**
 * @var yii\web\View $this
 * @var common\models\OfficeSocialAccount $model
 * @var array $officeOptions
 * @var array $socialPlatformOptions
 */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'Office Social Account',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Office Social Accounts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="office-social-account-update">

    <?php echo $this->render('_form', [
        'model' => $model,
        'officeOptions' => $officeOptions,
        'socialPlatformOptions' => $socialPlatformOptions,
    ]) ?>

</div>
