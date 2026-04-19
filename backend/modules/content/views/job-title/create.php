<?php

/**
 * @var yii\web\View $this
 * @var common\models\JobTitle $model
 * @var array $officeOptions
 */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'JobTitle',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Employments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employment-create">

    <?php echo $this->render('_form', [
        'model' => $model,
        'officeOptions' => $officeOptions,
    ]) ?>

</div>
