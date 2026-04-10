<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\models\Staff $model
 * @var yii\bootstrap4\ActiveForm $form
 */
?>

<div class="staff-form">
    <?php $form = ActiveForm::begin(); ?>
        <div class="card">
            <div class="card-body">
                <?php echo $form->errorSummary($model); ?>

                <?php echo $form->field($model, 'office_id')->textInput() ?>
                <?php echo $form->field($model, 'employment_id')->textInput() ?>
                <?php echo $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                <?php echo $form->field($model, 'initial')->textInput(['maxlength' => true]) ?>
                <?php echo $form->field($model, 'identity_number')->textInput(['maxlength' => true]) ?>
                <?php echo $form->field($model, 'phone_number')->textInput(['maxlength' => true]) ?>
                <?php echo $form->field($model, 'gender_status')->textInput() ?>
                <?php echo $form->field($model, 'active_status')->textInput() ?>
                <?php echo $form->field($model, 'address')->textarea(['rows' => 6]) ?>
                <?php echo $form->field($model, 'base_url')->textInput(['maxlength' => true]) ?>
                <?php echo $form->field($model, 'path')->textInput(['maxlength' => true]) ?>
                <?php echo $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                <?php echo $form->field($model, 'type')->textInput(['maxlength' => true]) ?>
                <?php echo $form->field($model, 'size')->textInput() ?>
                <?php echo $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                <?php echo $form->field($model, 'google_plus')->textInput(['maxlength' => true]) ?>
                <?php echo $form->field($model, 'instagram')->textInput(['maxlength' => true]) ?>
                <?php echo $form->field($model, 'facebook')->textInput(['maxlength' => true]) ?>
                <?php echo $form->field($model, 'twitter')->textInput(['maxlength' => true]) ?>
                <?php echo $form->field($model, 'description')->textarea(['rows' => 6]) ?>

            </div>
            <div class="card-footer">
                <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
</div>
