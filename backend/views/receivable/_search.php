<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ReceivableSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-receivable-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field($model, 'customer_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\backend\models\Customer::find()->orderBy('id')->asArray()->all(), 'id', 'title'),
        'options' => ['placeholder' => 'Choose Tx customer'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'staff_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\backend\models\Staff::find()->orderBy('id')->asArray()->all(), 'id', 'title'),
        'options' => ['placeholder' => 'Choose Tx staff'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'placeholder' => 'Title']) ?>

    <?= $form->field($model, 'invoice')->textInput(['maxlength' => true, 'placeholder' => 'Invoice']) ?>

    <?php /* echo $form->field($model, 'date_issued')->textInput(['placeholder' => 'Date Issued']) */ ?>

    <?php /* echo $form->field($model, 'month_period')->textInput(['maxlength' => true, 'placeholder' => 'Month Period']) */ ?>

    <?php /* echo $form->field($model, 'description')->textarea(['rows' => 6]) */ ?>

    <?php /* echo $form->field($model, 'claim')->textInput(['maxlength' => true, 'placeholder' => 'Claim']) */ ?>

    <?php /* echo $form->field($model, 'surcharge')->textInput(['maxlength' => true, 'placeholder' => 'Surcharge']) */ ?>

    <?php /* echo $form->field($model, 'penalty')->textInput(['maxlength' => true, 'placeholder' => 'Penalty']) */ ?>

    <?php /* echo $form->field($model, 'total')->textInput(['maxlength' => true, 'placeholder' => 'Total']) */ ?>

    <?php /* echo $form->field($model, 'discount')->textInput(['maxlength' => true, 'placeholder' => 'Discount']) */ ?>

    <?php /* echo $form->field($model, 'payment')->textInput(['maxlength' => true, 'placeholder' => 'Payment']) */ ?>

    <?php /* echo $form->field($model, 'balance')->textInput(['maxlength' => true, 'placeholder' => 'Balance']) */ ?>

    <?php /* echo $form->field($model, 'verlock', ['template' => '{input}'])->textInput(['style' => 'display:none']); */ ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
