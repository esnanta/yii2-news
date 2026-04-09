<?php

/**
 * @var yii\web\View $this
 * @var common\models\DocumentCategory $model
 */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Document Category',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Document Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="document-category-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
