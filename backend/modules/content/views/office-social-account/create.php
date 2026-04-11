<?php

/**
 * @var yii\web\View $this
 * @var common\models\OfficeSocialAccount $model
 * @var array $officeOptions
 * @var array $socialPlatformOptions
 */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Office Social Account',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Office Social Accounts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="office-social-account-create">

    <?php echo $this->render('_form', [
        'model' => $model,
        'officeOptions' => $officeOptions,
        'socialPlatformOptions' => $socialPlatformOptions,
    ]) ?>

</div>
