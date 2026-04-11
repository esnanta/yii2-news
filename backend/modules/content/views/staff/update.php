<?php

/**
 * @var yii\web\View $this
 * @var common\models\Staff $model
 * @var array $officeOptions
 * @var array $employmentOptions
 */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'Staff',
]) . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Staff'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="staff-update">

    <?php echo $this->render('_form', [
        'model' => $model,
        'officeOptions' => $officeOptions,
        'employmentOptions' => $employmentOptions,
    ]) ?>

</div>
