<?php

/**
 * @var yii\web\View $this
 * @var common\models\StaffSocialAccount $model
 * @var array $officeOptions
 * @var array $staffOptions
 * @var array $platformOptions
 */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'Staff Social Account',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Staff Social Accounts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="staff-social-account-update">

    <?php echo $this->render('_form', [
        'model' => $model,
        'officeOptions' => $officeOptions,
        'staffOptions' => $staffOptions,
        'platformOptions' => $platformOptions,
    ]) ?>

</div>
