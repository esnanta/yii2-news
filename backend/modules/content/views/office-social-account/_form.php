<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\models\OfficeSocialAccount $model
 * @var yii\bootstrap4\ActiveForm $form
 */
?>

<div class="office-social-account-form">
    <?php $form = ActiveForm::begin(); ?>
        <div class="card">
            <div class="card-body">
                <?php echo $form->errorSummary($model); ?>

                <?php echo $form->field($model, 'office_id')->textInput() ?>
                <?php echo $form->field($model, 'platform_id')->textInput() ?>
                <?php echo $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
                <?php echo $form->field($model, 'profile_url')->textInput(['maxlength' => true]) ?>
                <?php echo $form->field($model, 'is_primary')->textInput() ?>
                <?php echo $form->field($model, 'is_visible')->textInput() ?>
                <?php echo $form->field($model, 'sequence')->textInput() ?>
                <?php echo $form->field($model, 'description')->textarea(['rows' => 6]) ?>

            </div>
            <div class="card-footer">
                <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
</div>
