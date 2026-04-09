<?php

/**
 * @var yii\web\View $this
 * @var common\models\SocialPlatform $model
 */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Social Platform',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Social Platforms'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="social-platform-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
