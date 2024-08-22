<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\widgets\Select2;

/**
 * @var yii\web\View $this
 * @var common\models\Fuel $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="fuel-form">

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [
            'user_type' => [
                'type' => Form::INPUT_WIDGET, 
                'widgetClass'=> Select2::class,
                'options' => [
                    'data' => $userTypeList,
                    'options' => ['placeholder' => '', 'disabled'=>false],
                ],                            
                'pluginOptions' => [
                    'allowClear' => true
                ],                            
            ],  
            
            'employment_id' => [
                'label' => 'Jabatan',
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
            
            'staff_title' => [
                'label' => 'Nama',
                'type' => Form::INPUT_TEXT, 
                'options' => ['placeholder' => '', 'maxlength' => 100]
            ],
            
            'email' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => '', 'maxlength' => 100]],
            'username' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => '', 'maxlength' => 100]],
            'password' => ['type' => Form::INPUT_PASSWORD, 'options' => ['placeholder' => '', 'maxlength' => 100]],
        ]

    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );
    ActiveForm::end(); ?>

</div>
