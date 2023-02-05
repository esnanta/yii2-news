<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\widgets\Select2;
use kartik\widgets\TouchSpin;
/**
 * @var yii\web\View $this
 * @var backend\models\Network $model
 */

$this->title = 'Export Data';
//$this->params['breadcrumbs'][] = ['label' => 'Networks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">
            Please fill out the form below
            <div class="pull-right">
                Export Billing            
            </div>            
        </div>
    </div>
    <div class="panel-body">

        <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]); 
        echo '<p class="help-block">Required</p>';
        echo Form::widget([

            'model' => $model,
            'form' => $form,
            'columns' => 1,
            'attributes' => [

                'option_date' => [
                    'type' => Form::INPUT_WIDGET, 
                    'widgetClass'=> Select2::className(),
                    'options' => [
                        'data' => $dateAttributeList,
                        'options' => ['placeholder' => 'Choose option', 'disabled'=>false],
                    ],                            
                    'pluginOptions' => [
                        'allowClear' => true
                    ],                            
                ],             

                'date_first' => [
                    'type' => Form::INPUT_WIDGET, 
                    'widgetClass'=> DateControl::className(),
                    'format'=>'date',                          
                ],  
                'date_last' => [
                    'type' => Form::INPUT_WIDGET, 
                    'widgetClass'=> DateControl::className(),
                    'format'=>'date',                          
                ],  
            ]

        ]);




//        echo $form->field($model, 'offset')->widget(TouchSpin::classname(), [
//                'readonly'      => true,
//                'options'       => ['placeholder' => $model->getAttributeLabel('offset')],
//                'pluginOptions' => [
//                        'initval'           => 1,
//                        'min'               => 1,
//                        'step'              => Yii::$app->params['Data_Query_Limit'],
//                        'max'               => 1000,
//                        'buttonup_class'    => 'btn btn-default',
//                        'buttondown_class'  => 'btn btn-default',
//                        'buttonup_txt'      => '<i class="glyphicon glyphicon-plus-sign"></i>',
//                        'buttondown_txt'    => '<i class="glyphicon glyphicon-minus-sign"></i>'
//                ]
//        ]);
 
        echo '<hr>';
        echo '<p class="help-block">Optional</p>';
        
        echo $form->field($model, 'option_detail')->checkbox();
        
        echo Form::widget([
    
            'model' => $model,
            'form' => $form,
            'columns' => 1,
            'attributes' => [
    
                'billing_type' => [
                    'type' => Form::INPUT_WIDGET, 
                    'widgetClass'=> Select2::className(),
                    'options' => [
                        'data' => $billingTypeList,
                        'options' => ['placeholder' => 'Choose Type', 'disabled'=>false],
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
                        'options' => ['placeholder' => 'Choose Status', 'disabled'=>false],
                    ],                            
                    'pluginOptions' => [
                        'allowClear' => true
                    ],                            
                ],                 
            ]
    
        ]);    

        echo Html::submitButton(Yii::t('app', 'Export'),
            ['class' => 'btn btn-success' ]
        );
        ActiveForm::end(); ?>

        
        
    </div>
</div>