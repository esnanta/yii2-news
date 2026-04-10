<?php

use common\models\Article;
use yii\web\View;

/**
 * @var View   $this
 * @var Article $model
 * @var array  $authorOptions
 * @var array  $categoryOptions
 */
$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'Article',
]).' '.$model->title;

$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Articles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');

?>

<?php echo $this->render('_form', [
    'model' => $model,
    'authorOptions' => $authorOptions,
    'categoryOptions' => $categoryOptions,
]);
