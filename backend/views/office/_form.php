<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var common\models\Office $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="office-form">

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

            'title' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Title...', 'maxlength' => 100]],

            'phone_number' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Phone Number...', 'maxlength' => 100]],

            'fax_number' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Fax Number...', 'maxlength' => 100]],

            'email' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Email...', 'maxlength' => 100]],

            'web' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Web...', 'maxlength' => 100]],

            'address' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Address...', 'maxlength' => 100]],

            'latitude' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Latitude...', 'maxlength' => 100]],

            'longitude' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Longitude...', 'maxlength' => 100]],

            'description' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => 'Enter Description...','rows' => 6]],
        ]

    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );
    ActiveForm::end(); ?>

</div>
