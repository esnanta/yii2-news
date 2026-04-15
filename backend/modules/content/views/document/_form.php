<?php

use common\models\Document;
use trntv\filekit\widget\Upload;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\web\JsExpression;

/**
 * @var yii\web\View $this
 * @var common\models\Document $model
 * @var array $officeOptions
 * @var array $documentCategoryOptions
 * @var yii\bootstrap4\ActiveForm $form
 */
?>

<div class="document-form">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
        <div class="card">
            <div class="card-body">
                <?php echo $form->errorSummary($model); ?>

                <?php echo $form->field($model, 'office_id')->dropDownList(
                    $officeOptions,
                    ['prompt' => Yii::t('backend', '')]
                ); ?>
                <?php echo $form->field($model, 'is_visible')->dropDownList(
                    Document::visibleOptions(),
                    ['prompt' => Yii::t('backend', '')]
                ); ?>
                <?php echo $form->field($model, 'category_id')->dropDownList(
                    $documentCategoryOptions,
                    ['prompt' => Yii::t('backend', '')]
                ); ?>
                <?php echo $form->field($model, 'document_type')->dropDownList(
                    Document::documentTypeOptions(),
                    ['prompt' => Yii::t('backend', '')]
                ); ?>
                <?php echo $form->field($model, 'title')->textInput(['maxlength' => true]); ?>
                <?php echo $form->field($model, 'date_issued')->input('date'); ?>
                <?php echo $form->field($model, 'documentFile')->widget(Upload::class, [
                    'url' => ['/file/storage/upload'],
                    'uploadPath' => 'document',
                    'maxFileSize' => 5000000,
                    'acceptFileTypes' => new JsExpression(Document::uploadAcceptFileTypesRegex()),
                ]); ?>
                <?php echo $form->field($model, 'description')->textarea(['rows' => 6]); ?>

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
