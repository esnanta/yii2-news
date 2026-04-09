<?php

/**
 * @var yii\web\View $this
 * @var common\models\StaffSocialAccount $model
 */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Staff Social Account',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Staff Social Accounts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="staff-social-account-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
