<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\StaffSocialAccount $model
 * @var array $officeOptions
 * @var array $staffOptions
 * @var array $platformOptions
 * @var yii\bootstrap4\ActiveForm $form
 */
?>

<div class="staff-social-account-form">
    <?php $form = ActiveForm::begin(); ?>
        <div class="card">
            <div class="card-body">
                <?php echo $form->errorSummary($model); ?>

                <?php echo $form->field($model, 'office_id')->dropDownList(
                    $officeOptions,
                    ['prompt' => Yii::t('backend', 'Select office')]
                ); ?>
                <?php echo $form->field($model, 'staff_id')->dropDownList(
                    $staffOptions,
                    ['prompt' => Yii::t('backend', 'Select staff')]
                ); ?>
                <?php echo $form->field($model, 'platform_id')->dropDownList(
                    $platformOptions,
                    ['prompt' => Yii::t('backend', 'Select platform')]
                ); ?>
                <?php echo $form->field($model, 'username')->textInput(['maxlength' => true]); ?>
                <?php echo $form->field($model, 'profile_url')->textInput(['maxlength' => true]); ?>
                <?php echo $form->field($model, 'is_primary')->dropDownList(
                    $model::primaryOptions(),
                    ['prompt' => Yii::t('backend', '')]
                ); ?>
                <?php echo $form->field($model, 'is_visible')->dropDownList(
                    $model::visibleOptions(),
                    ['prompt' => Yii::t('backend', '')]
                ); ?>
                <?php echo $form->field($model, 'sequence')->textInput(); ?>
                <?php echo $form->field($model, 'description')->textarea(['rows' => 6]); ?>

            </div>
            <div class="card-footer">
                <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']); ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
</div>
