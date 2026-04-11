<?php

/**
 * @var yii\web\View $this
 * @var common\models\Employment $model
 * @var array $officeOptions
 */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Employment',
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
