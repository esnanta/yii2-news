<?php

/**
 * @var yii\web\View $this
 * @var common\models\Document $model
 * @var array $officeOptions
 * @var array $documentCategoryOptions
 */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'Document',
]) . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Documents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="document-update">

    <?php echo $this->render('_form', [
        'model' => $model,
        'officeOptions' => $officeOptions,
        'documentCategoryOptions' => $documentCategoryOptions,
    ]) ?>

</div>
