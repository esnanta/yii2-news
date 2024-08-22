<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\widgets\Select2;

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
            'office_id' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => Select2::class,
                'options' => [
                    'data' => $officeList,
                    'options' => ['placeholder' => 'Choose Office', 'disabled' => (Yii::$app->user->identity->isAdmin) ? false : true],
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ], 
            'title' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Title...', 'maxlength' => 100]],
            'initial' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Initial...', 'maxlength' => 10]],
            
            'gender_status' => [
                'type' => Form::INPUT_WIDGET, 
                'widgetClass'=> Select2::class,
                'options' => [
                    'data' => $genderList,
                    'options' => ['placeholder' => 'Choose Gender', 'disabled'=>false],
                ],                            
                'pluginOptions' => [
                    'allowClear' => true
                ],                            
            ],                  
            
            'employment_id' => [
                'type' => Form::INPUT_WIDGET, 
                'widgetClass'=> Select2::class,
                'options' => [
                    'data' => $employmentList,
                    'options' => ['placeholder' => '', 'disabled'=>false],
                ],                            
                'pluginOptions' => [
                    'allowClear' => true
                ],                            
            ],              
                 
            'phone_number' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Phone Number...', 'maxlength' => 50]],
            'identity_number' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Identity Number...', 'maxlength' => 100]],
            'email' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Email Account...', 'maxlength' => 100]],
            'address' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => 'Enter Address...','rows' => 6]],
            'description' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => 'Enter Description...','rows' => 6]],

        ]

    ]);

    // your fileinput widget for single file upload
//    echo $form->field($model, 'image')->widget(FileInput::class, [
//        'options'=>['accept'=>'image/*'],
//        'pluginOptions'=>['allowedFileExtensions'=>['jpg','gif','png']
//    ]]);            
    
    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );
    ActiveForm::end(); ?>

</div>
