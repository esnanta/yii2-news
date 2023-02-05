<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var backend\models\Customer $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="customer-form">

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]);

    echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 2,
        'attributes' => [
            'title' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Title...', 'maxlength' => 50]],
            'date_issued' => [
                'type' => Form::INPUT_WIDGET, 
                'widgetClass'=> DateControl::className(),
                'format'=>'date',                          
            ], 
            'identity_number' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Identity Number...', 'maxlength' => 50]],
            'phone' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Phone...', 'maxlength' => 50]],

        ]

    ]);

    echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 2,
        'attributes' => [

            'latitude' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Latitude...', 'maxlength' => 30]],
            'longitude' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Longitude...', 'maxlength' => 30]],

        ]

    ]);

    echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 2,
        'attributes' => [

            'address' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => 'Enter Address...','rows' => 6]],
            'description' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => 'Enter Description...','rows' => 6]],

        ]

    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );
    ActiveForm::end(); ?>

</div>
