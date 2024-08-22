<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\widgets\Select2;

/**
 * @var yii\web\View $this
 * @var common\models\Network $model
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
                    'widgetClass'=> Select2::class,
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
                    'widgetClass'=> DateControl::class,
                    'format'=>'date',                          
                ],  
                'date_last' => [
                    'type' => Form::INPUT_WIDGET, 
                    'widgetClass'=> DateControl::class,
                    'format'=>'date',                          
                ],                
            ]

        ]);

        echo '<hr>';
        echo '<p class="help-block">Optional</p>';
        echo Form::widget([
    
            'model' => $model,
            'form' => $form,
            'columns' => 1,
            'attributes' => [
    
                'customer_id' => [
                    'type' => Form::INPUT_WIDGET, 
                    'widgetClass'=> Select2::class,
                    'options' => [
                        'data' => $customerList,
                        'options' => ['placeholder' => 'Choose Staff', 'disabled'=>false],
                    ],                            
                    'pluginOptions' => [
                        'allowClear' => true
                    ],                            
                ],         
                
                'staff_id' => [
                    'type' => Form::INPUT_WIDGET, 
                    'widgetClass'=> Select2::class,
                    'options' => [
                        'data' => $staffList,
                        'options' => ['placeholder' => 'Choose Staff', 'disabled'=>false],
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