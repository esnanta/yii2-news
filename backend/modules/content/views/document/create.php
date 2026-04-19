<?php

/**
 * @var yii\web\View $this
 * @var common\models\Document $model
 * @var array $officeOptions
 * @var array $documentCategoryOptions
 */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Document',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Documents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="document-create">

    <?php echo $this->render('_form', [
        'model' => $model,
        'officeOptions' => $officeOptions,
        'documentCategoryOptions' => $documentCategoryOptions,
    ]) ?>

</div>
