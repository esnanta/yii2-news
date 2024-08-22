<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var common\models\Profile $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="profile-form">

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

            'name' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Name...', 'maxlength' => 255]],
            'public_email' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Public Email...', 'maxlength' => 255]],
            'location' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Location...', 'maxlength' => 255]],
            'website' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Website...', 'maxlength' => 255]],
            'bio' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => 'Enter Bio...','rows' => 6]],
            
        ]

    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );
    ActiveForm::end(); ?>

</div>
