<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\models\DocumentCategory $model
 * @var yii\bootstrap4\ActiveForm $form
 */
?>

<div class="document-category-form">
    <?php $form = ActiveForm::begin(); ?>
        <div class="card">
            <div class="card-body">
                <?php echo $form->errorSummary($model); ?>

                <?php echo $form->field($model, 'office_id')->textInput() ?>
                <?php echo $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                <?php echo $form->field($model, 'sequence')->textInput() ?>
                <?php echo $form->field($model, 'description')->textarea(['rows' => 6]) ?>
                <?php echo $form->field($model, 'created_at')->textInput() ?>
                <?php echo $form->field($model, 'updated_at')->textInput() ?>
                <?php echo $form->field($model, 'created_by')->textInput() ?>
                <?php echo $form->field($model, 'updated_by')->textInput() ?>
                <?php echo $form->field($model, 'is_deleted')->textInput() ?>
                <?php echo $form->field($model, 'deleted_at')->textInput() ?>
                <?php echo $form->field($model, 'deleted_by')->textInput() ?>
                <?php echo $form->field($model, 'verlock')->textInput() ?>
                <?php echo $form->field($model, 'uuid')->textInput(['maxlength' => true]) ?>
                
            </div>
            <div class="card-footer">
                <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
</div>
