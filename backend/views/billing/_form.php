<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\widgets\Select2;

/**
 * @var yii\web\View $this
 * @var backend\models\Billing $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="billing-form">

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]); 
    
    echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [
            
            'date_issued' => [
                'type' => Form::INPUT_WIDGET, 
                'widgetClass'=> DateControl::className(),
                'format'=>'date',                          
            ],  
            
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

            'billing_type' => [
                'type' => Form::INPUT_WIDGET, 
                'widgetClass'=> Select2::className(),
                'options' => [
                    'data' => $billingTypeList,
                    'options' => ['placeholder' => 'Choose Device Status', 'disabled'=>true],
                ],                            
                'pluginOptions' => [
                    'allowClear' => true
                ],                            
            ], 

            'payment_status' => [
                'type' => Form::INPUT_WIDGET, 
                'widgetClass'=> Select2::className(),
                'options' => [
                    'data' => $paymentStatusList,
                    'options' => ['placeholder' => 'Choose Billing Status', 'disabled'=>true],
                ],                            
                'pluginOptions' => [
                    'allowClear' => true
                ],                            
            ],   
            
        ]

    ]);

    echo $form->field($model, 'validity_period')->widget(Select2::classname(), [
        'data' => $validityDetailList,
        'maintainOrder' => true,
        'options' => ['placeholder' => 'Gunakan "Ctrl" untuk memilih lebih dari satu data', 'multiple' => true],
        'pluginOptions' => [
            'tags' => true,
            'tokenSeparators' => [',',' '],
            'maximumInputLength' => 12            
        ],
    ]); 
    
    echo Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [
            'description' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => 'Enter Description...','rows' => 2]],
        ]
    ]);         
    
    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );
    ActiveForm::end(); ?>

</div>
