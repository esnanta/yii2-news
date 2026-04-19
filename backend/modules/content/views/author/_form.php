<?php

use kartik\widgets\Select2;
use trntv\filekit\widget\Upload;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\web\JsExpression;

/**
 * @var yii\web\View $this
 * @var common\models\Author $model
 * @var array $officeOptions
 * @var yii\bootstrap4\ActiveForm $form
 */
?>

<div class="author-form">
    <?php $form = ActiveForm::begin(); ?>
        <div class="card">
            <div class="card-body">
                <?php echo $form->errorSummary($model); ?>

                <?php echo $form->field($model, 'office_id')->widget(Select2::class, [
                    'data' => $officeOptions,
                    'options' => ['placeholder' => Yii::t('backend', 'Select office')],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ]); ?>
                <?php echo $form->field($model, 'title')->textInput(['maxlength' => true]); ?>
                <?php echo $form->field($model, 'phone_number')->textInput(['maxlength' => true]); ?>
                <?php echo $form->field($model, 'email')->textInput(['maxlength' => true]); ?>
                <?php echo $form->field($model, 'address')->textarea(['rows' => 6]); ?>
                <?php echo $form->field($model, 'description')->textarea(['rows' => 6]); ?>
                <?php echo $form->field($model, 'image')->widget(Upload::class, [
                    'url' => ['/file/storage/upload'],
                    'uploadPath' => 'author',
                    'maxFileSize' => 5000000,
                    'acceptFileTypes' => new JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),
                ]); ?>
            </div>
            <div class="card-footer">
                <?php echo Html::submitButton(
                    $model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'),
                    ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
                ); ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
</div>
