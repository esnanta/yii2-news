<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ArchiveSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-archive-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

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

    <?php /* echo $form->field($model, 'date_issued')->widget(\kartik\datecontrol\DateControl::classname(), [
        'type' => \kartik\datecontrol\DateControl::FORMAT_DATE,
        'saveFormat' => 'php:Y-m-d',
        'ajaxConversion' => true,
        'options' => [
            'pluginOptions' => [
                'placeholder' => 'Choose Date Issued',
                'autoclose' => true
            ]
        ],
    ]); */ ?>

    <?php /* echo $form->field($model, 'file_name')->textInput(['maxlength' => true, 'placeholder' => 'File Name']) */ ?>

    <?php /* echo $form->field($model, 'archive_url')->textInput(['maxlength' => true, 'placeholder' => 'Archive Url']) */ ?>

    <?php /* echo $form->field($model, 'size')->textInput(['placeholder' => 'Size']) */ ?>

    <?php /* echo $form->field($model, 'mime_type')->textInput(['maxlength' => true, 'placeholder' => 'Mime Type']) */ ?>

    <?php /* echo $form->field($model, 'view_counter')->textInput(['placeholder' => 'View Counter']) */ ?>

    <?php /* echo $form->field($model, 'download_counter')->textInput(['placeholder' => 'Download Counter']) */ ?>

    <?php /* echo $form->field($model, 'description')->textarea(['rows' => 6]) */ ?>

    <?php /* echo $form->field($model, 'is_deleted')->textInput(['placeholder' => 'Is Deleted']) */ ?>

    <?php /* echo $form->field($model, 'verlock', ['template' => '{input}'])->textInput(['style' => 'display:none']); */ ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
