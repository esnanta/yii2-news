<?php

/**
 * @var yii\web\View          $this
 * @var common\models\Article $model
 * @var array                  $authorOptions
 * @var array                  $categoryOptions
 */
$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Article',
]);

$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Articles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<?php echo $this->render('_form', [
    'model' => $model,
    'authorOptions' => $authorOptions,
    'categoryOptions' => $categoryOptions,
]);
