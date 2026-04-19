<?php

/**
 * @var yii\web\View $this
 * @var common\models\Author $model
 * @var array $officeOptions
 */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Author',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Authors'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="author-create">

    <?php echo $this->render('_form', [
        'model' => $model,
        'officeOptions' => $officeOptions,
    ]) ?>

</div>
