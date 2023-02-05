<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\widgets\Select2;

/**
 * @var yii\web\View $this
 * @var backend\models\ValidityDetail $model
 * @var yii\widgets\ActiveForm $form
 */

$isDisabled = (Yii::$app->user->identity->isAdmin) ? false:true;

?>

<div class="validity-detail-form">

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]); 
    
    echo Form::widget([

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

            'device_status' => [
                'type' => Form::INPUT_WIDGET, 
                'widgetClass'=> Select2::className(),
                'options' => [
                    'data' => $deviceStatusList,
                    'options' => ['placeholder' => 'Choose Device Status', 'disabled'=>$isDisabled],
                ],                            
                'pluginOptions' => [
                    'allowClear' => true
                ],                            
            ], 

            'billing_status' => [
                'type' => Form::INPUT_WIDGET, 
                'widgetClass'=> Select2::className(),
                'options' => [
                    'data' => $billingStatusList,
                    'options' => ['placeholder' => 'Choose Billing Status', 'disabled'=>$isDisabled],
                ],                            
                'pluginOptions' => [
                    'allowClear' => true
                ],                            
            ],   
            
            'amount' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Amount...', 'maxlength' => 18, 'disabled'=>$isDisabled]],

        ]

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

<?php
    $this->registerJsFile(
        '@web/js/validity-detail.js',
        ['depends' => [yii\web\JqueryAsset::className()]]
    );
?>