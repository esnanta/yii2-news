<?php

use common\models\Article;
use yii\web\View;

/**
 * @var View    $this
 * @var Article $model
 * @var array   $authorOptions
 * @var array   $categoryOptions
 * @var array   $tagOptions
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
    'tagOptions' => $tagOptions,
]);
