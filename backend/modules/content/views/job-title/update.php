<?php

/**
 * @var yii\web\View $this
 * @var common\models\JobTitle $model
 * @var array $officeOptions
 */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'JobTitle',
]) . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Employments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="employment-update">

    <?php echo $this->render('_form', [
        'model' => $model,
        'officeOptions' => $officeOptions,
    ]) ?>

</div>
