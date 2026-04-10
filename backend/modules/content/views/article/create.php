<?php

/**
 * @var yii\web\View                    $this
 * @var common\models\Article           $model
 * @var common\models\ArticleCategory[] $categories
 */
$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Article',
]);

$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Articles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<?php echo $this->render('_form', [
    'model' => $model,
    'categories' => $categories,
]);
