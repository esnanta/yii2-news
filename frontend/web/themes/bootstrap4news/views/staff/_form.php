<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use trntv\filekit\widget\Upload;
use yii\web\JsExpression;

/**
 * @var yii\web\View $this
 * @var common\models\Staff $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="staff-form">

    <?php $form = ActiveForm::begin([
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'options'=>['enctype'=>'multipart/form-data'] 
    ]); 
    
    echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

            'title' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Title...', 'maxlength' => 100]],
            
            'gender_lookup' => ['type' => Form::INPUT_DROPDOWN_LIST, 
                'options' => ['id' => 'lookup_id', 'prompt' => 'Select Gender...'],
                'items' => $genderList,
            ],            
            
            'employment_id' => ['type' => Form::INPUT_DROPDOWN_LIST, 
                'options' => ['id' => 'employment_id', 'prompt' => 'Select JobTitle...'],
                'items' => $employmentList,
            ],                 
            
            'phone_number' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Phone Number...', 'maxlength' => 50]],

            'identity_number' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Identity Number...', 'maxlength' => 100]],
            
            'address' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => 'Enter Address...','rows' => 6]],
            
            'description' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => 'Enter Description...','rows' => 6]],

        ]

    ]);

    echo $form->field($model, 'image')->widget(
        Upload::class,
        [
            'url' => ['/file/storage/upload'],
            'maxFileSize' => 5000000,
            'acceptFileTypes' => new JsExpression('/(\\.|\\/)(gif|jpe?g|png)$/i'),
        ]
    );

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );
    ActiveForm::end(); ?>

</div>
