<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ImportDataSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-import-data-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field($model, 'modul_type')->textInput(['placeholder' => 'Modul Type']) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'placeholder' => 'Title']) ?>

    <?= $form->field($model, 'row_start')->textInput(['placeholder' => 'Row Start']) ?>

    <?= $form->field($model, 'row_end')->textInput(['placeholder' => 'Row End']) ?>

    <?php /* echo $form->field($model, 'file_name')->textInput(['maxlength' => true, 'placeholder' => 'File Name']) */ ?>

    <?php /* echo $form->field($model, 'description')->textarea(['rows' => 6]) */ ?>

    <?php /* echo $form->field($model, 'verlock')->textInput(['maxlength' => true, 'placeholder' => 'Varlock']) */ ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
