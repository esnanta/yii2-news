<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\widgets\Select2;
use kartik\datecontrol\DateControl;
/**
 * @var yii\web\View $this
 * @var backend\models\Enrolment $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="enrolment-form">

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [
            'customer_id' => [
                'type' => Form::INPUT_WIDGET, 
                'widgetClass'=> Select2::className(),
                'options' => [
                    'data' => $customerList,
                    'options' => ['placeholder' => 'Choose Customer', 'disabled'=>true],
                ],                            
                'pluginOptions' => [
                    'allowClear' => true
                ],                            
            ], 
            
            'enrolment_type' => [
                'type' => Form::INPUT_WIDGET, 
                'widgetClass'=> Select2::className(),
                'options' => [
                    'data' => $enrolmentTypeList,
                    'options' => ['placeholder' => '', 'disabled'=>true],
                ],                            
                'pluginOptions' => [
                    'allowClear' => true
                ],                            
            ],   
            
            'billing_cycle' => [
                'type' => Form::INPUT_WIDGET, 
                'widgetClass'=> Select2::className(),
                'options' => [
                    'data' => $billingCycleList,
                    'options' => ['placeholder' => 'Choose Cycle', 'disabled'=>false],
                ],                            
                'pluginOptions' => [
                    'allowClear' => true
                ],                            
            ],             
            
            'date_start' => [
                'type' => ($model->enrolment_type==backend\models\Enrolment::ENROLMENT_TYPE_ANALOG) ? Form::INPUT_HIDDEN : Form::INPUT_WIDGET, 
                'widgetClass'=> DateControl::className(),
                'format'=>'date',
            ],   
            
            'date_end' => [
                'type' => ($model->enrolment_type==backend\models\Enrolment::ENROLMENT_TYPE_ANALOG) ? Form::INPUT_HIDDEN : Form::INPUT_WIDGET, 
                'widgetClass'=> DateControl::className(),
                'format'=>'date',   
            ],   
            
            'network_tags_title' => [
                'type' => Form::INPUT_WIDGET, 
                'widgetClass'=> Select2::className(),
                'options' => [
                    'data' => $networkTitleList,
                    'maintainOrder' => true,                                            
                    'options' => ['placeholder' => 'Type or Choose Network Location', 'multiple' => false],
                    'pluginOptions' => [
                        'tags' => true,
                        'tokenSeparators' => [',',' '],
                        'maximumInputLength' => 10  
                    ],                                              
                ],                                                      
            ],             
            
            
            'date_effective' => [
                'type' => Form::INPUT_WIDGET, 
                'widgetClass'=> DateControl::className(),
                'format'=>'date',
            ],              
            
            'description' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => 'Enter Description...','rows' => 6]],
                                 
        ]

    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );
    ActiveForm::end(); ?>

</div>
