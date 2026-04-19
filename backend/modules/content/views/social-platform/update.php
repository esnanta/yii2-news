<?php

/**
 * @var yii\web\View $this
 * @var common\models\SocialPlatform $model
 */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'Social Platform',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Social Platforms'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="social-platform-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
