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
                Export Customer            
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

                'data_first' => [
                    'type' => Form::INPUT_WIDGET, 
                    'widgetClass'=> Select2::class,
                    'options' => [
                        'data' => $dataListAsc,
                        'options' => ['placeholder' => 'Choose Data', 'disabled'=>false],
                    ],                            
                    'pluginOptions' => [
                        'allowClear' => true
                    ],                            
                ], 

                'data_last' => [
                    'type' => Form::INPUT_WIDGET, 
                    'widgetClass'=> Select2::class,
                    'options' => [
                        'data' => $dataListDesc,
                        'options' => ['placeholder' => 'Choose Data', 'disabled'=>false],
                    ],                            
                    'pluginOptions' => [
                        'allowClear' => true
                    ],                            
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
    
                'final_status' => [
                    'type' => Form::INPUT_WIDGET, 
                    'widgetClass'=> Select2::class,
                    'options' => [
                        'data' => $finalStatusList,
                        'options' => ['placeholder' => 'Finalisasi', 'disabled'=>false],
                    ],                            
                    'pluginOptions' => [
                        'allowClear' => true
                    ],                            
                ],              
                'approval_status' => [
                    'type' => Form::INPUT_WIDGET, 
                    'widgetClass'=> Select2::class,
                    'options' => [
                        'data' => $approvalStatusList,
                        'options' => ['placeholder' => 'Approval', 'disabled'=>false],
                    ],                            
                    'pluginOptions' => [
                        'allowClear' => true
                    ],                            
                ],    
                'gender_status' => [
                    'type' => Form::INPUT_WIDGET, 
                    'widgetClass'=> Select2::class,
                    'options' => [
                        'data' => $genderStatusList,
                        'options' => ['placeholder' => 'Jenis Kelamin', 'disabled'=>false],
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

