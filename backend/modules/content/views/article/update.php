<?php

use common\models\Article;
use yii\web\View;

/**
 * @var View   $this
 * @var Article $model
 * @var array  $authorOptions
 * @var array  $categoryOptions
 * @var array  $tagOptions
 * @var array  $statusOptions
 * @var array  $pinnedOptions
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
    'tagOptions' => $tagOptions,
    'statusOptions' => $statusOptions,
    'pinnedOptions' => $pinnedOptions,
]);
