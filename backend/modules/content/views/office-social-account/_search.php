<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\models\OfficeSocialAccount $model
 * @var yii\bootstrap4\ActiveForm $form
 */
?>

<div class="office-social-account-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php echo $form->field($model, 'id') ?>
    <?php echo $form->field($model, 'office_id') ?>
    <?php echo $form->field($model, 'platform_id') ?>
    <?php echo $form->field($model, 'username') ?>
    <?php echo $form->field($model, 'profile_url') ?>
    <?php // echo $form->field($model, 'is_primary') ?>
    <?php // echo $form->field($model, 'is_visible') ?>
    <?php // echo $form->field($model, 'sequence') ?>
    <?php // echo $form->field($model, 'description') ?>
    <?php // echo $form->field($model, 'created_at') ?>
    <?php // echo $form->field($model, 'updated_at') ?>
    <?php // echo $form->field($model, 'created_by') ?>
    <?php // echo $form->field($model, 'updated_by') ?>
    <?php // echo $form->field($model, 'is_deleted') ?>
    <?php // echo $form->field($model, 'deleted_at') ?>
    <?php // echo $form->field($model, 'deleted_by') ?>
    <?php // echo $form->field($model, 'verlock') ?>
    <?php // echo $form->field($model, 'uuid') ?>

    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('backend', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?php echo Html::resetButton(Yii::t('backend', 'Reset'), ['class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
