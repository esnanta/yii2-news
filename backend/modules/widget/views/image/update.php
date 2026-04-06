<?php

use common\models\WidgetImage;
use yii\web\View;

/**
 * @var View        $this
 * @var WidgetImage $model
 */
$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'Widget Image',
]).' '.$model->key;

$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Widget Images'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>

<?php echo $this->render('_form', [
    'model' => $model,
]); ?>

