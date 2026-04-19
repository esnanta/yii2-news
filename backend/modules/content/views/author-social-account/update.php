<?php

/**
 * @var yii\web\View $this
 * @var common\models\AuthorSocialAccount $model
 * @var array $officeOptions
 * @var array $authorOptions
 * @var array $platformOptions
 */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'Author Social Account',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Author Social Accounts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="author-social-account-update">

    <?php echo $this->render('_form', [
        'model' => $model,
        'officeOptions' => $officeOptions,
        'authorOptions' => $authorOptions,
        'platformOptions' => $platformOptions,
    ]) ?>

</div>
