<?php

/**
 * @var yii\web\View $this
 * @var common\models\AuthorSocialAccount $model
 * @var array $officeOptions
 * @var array $authorOptions
 * @var array $platformOptions
 */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Author Social Account',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Author Social Accounts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="author-social-account-create">

    <?php echo $this->render('_form', [
        'model' => $model,
        'officeOptions' => $officeOptions,
        'authorOptions' => $authorOptions,
        'platformOptions' => $platformOptions,
    ]) ?>

</div>
