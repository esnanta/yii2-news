<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\models\Document $model
 * @var yii\bootstrap4\ActiveForm $form
 */
?>

<div class="document-form">
    <?php $form = ActiveForm::begin(); ?>
        <div class="card">
            <div class="card-body">
                <?php echo $form->errorSummary($model); ?>

                <?php echo $form->field($model, 'office_id')->textInput() ?>
                <?php echo $form->field($model, 'is_visible')->textInput() ?>
                <?php echo $form->field($model, 'category_id')->textInput() ?>
                <?php echo $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                <?php echo $form->field($model, 'date_issued')->textInput() ?>
                <?php echo $form->field($model, 'base_url')->textInput(['maxlength' => true]) ?>
                <?php echo $form->field($model, 'path')->textInput(['maxlength' => true]) ?>
                <?php echo $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                <?php echo $form->field($model, 'type')->textInput(['maxlength' => true]) ?>
                <?php echo $form->field($model, 'size')->textInput() ?>
                <?php echo $form->field($model, 'view_count')->textInput() ?>
                <?php echo $form->field($model, 'download_count')->textInput() ?>
                <?php echo $form->field($model, 'description')->textarea(['rows' => 6]) ?>

            </div>
            <div class="card-footer">
                <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
</div>
