<?php

/**
 * @var yii\web\View $this
 * @var common\models\Office $model
 */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Office',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Offices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="office-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
