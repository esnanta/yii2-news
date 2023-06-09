<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Archive */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="archive-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field($model, 'is_visible')->textInput(['placeholder' => 'Is Visible']) ?>

    <?= $form->field($model, 'archive_type')->textInput(['placeholder' => 'Archive Type']) ?>

    <?= $form->field($model, 'archive_category_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\backend\models\ArchiveCategory::find()->orderBy('id')->asArray()->all(), 'id', 'title'),
        'options' => ['placeholder' => 'Choose Tx archive category'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'placeholder' => 'Title']) ?>

    <?= $form->field($model, 'date_issued')->widget(\kartik\datecontrol\DateControl::classname(), [
        'type' => \kartik\datecontrol\DateControl::FORMAT_DATE,
        'saveFormat' => 'php:Y-m-d',
        'ajaxConversion' => true,
        'options' => [
            'pluginOptions' => [
                'placeholder' => 'Choose Date Issued',
                'autoclose' => true
            ]
        ],
    ]); ?>

    <?= $form->field($model, 'file_name')->textInput(['maxlength' => true, 'placeholder' => 'File Name']) ?>

    <?= $form->field($model, 'archive_url')->textInput(['maxlength' => true, 'placeholder' => 'Archive Url']) ?>

    <?= $form->field($model, 'size')->textInput(['placeholder' => 'Size']) ?>

    <?= $form->field($model, 'mime_type')->textInput(['maxlength' => true, 'placeholder' => 'Mime Type']) ?>

    <?= $form->field($model, 'view_counter')->textInput(['placeholder' => 'View Counter']) ?>

    <?= $form->field($model, 'download_counter')->textInput(['placeholder' => 'Download Counter']) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'is_deleted')->textInput(['placeholder' => 'Is Deleted']) ?>

    <?= $form->field($model, 'verlock', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
