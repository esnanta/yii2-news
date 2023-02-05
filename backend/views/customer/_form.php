<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\widgets\Select2;

/**
 * @var yii\web\View $this
 * @var backend\models\Customer $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="customer-form">

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [
            
            'date_issued' => [
                'type' => Form::INPUT_WIDGET, 
                'widgetClass'=> DateControl::className(),
                'format'=>'date',
            ],     
            
            'area_id' => [
                'type' => Form::INPUT_HIDDEN, 
                'widgetClass'=> Select2::className(),
                'options' => [
                    'data' => $areaList,
                    'options' => ['placeholder' => 'Choose Area', 'disabled'=>false],
                ],                            
                'pluginOptions' => [
                    'allowClear' => true
                ],                            
            ],  
            
            'village_id' => [
                'type' => Form::INPUT_WIDGET, 
                'widgetClass'=> Select2::className(),
                'options' => [
                    'data' => $villageList,
                    'options' => ['placeholder' => 'Choose Village', 'disabled'=>false],
                ],                            
                'pluginOptions' => [
                    'allowClear' => true
                ],                            
            ],             
            
            'gender_status' => [
                'type' => Form::INPUT_WIDGET, 
                'widgetClass'=> Select2::className(),
                'options' => [
                    'data' => $genderList,
                    'options' => ['placeholder' => 'Choose Gender', 'disabled'=>false],
                ],                            
                'pluginOptions' => [
                    'allowClear' => true
                ],                            
            ],              
              
            'title' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Title...', 'maxlength' => 50]],
            'identity_number' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Identity Number...', 'maxlength' => 50]],
            'phone_number' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Phone...', 'maxlength' => 50]],       
            
            'address' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => 'Enter Address...','rows' => 6]],
            'description' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => 'Enter Description...','rows' => 6]],

        ]

    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );
    ActiveForm::end(); ?>

</div>
