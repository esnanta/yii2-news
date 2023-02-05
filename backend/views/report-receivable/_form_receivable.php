<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\widgets\Select2;
//use kartik\checkbox\CheckboxX;

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
                Export Penerimaan            
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

        echo '<hr>';
        echo '<p class="help-block">Optional</p>';
        echo Form::widget([
    
            'model' => $model,
            'form' => $form,
            'columns' => 1,
            'attributes' => [
    
                'staff_id' => [
                    'type' => Form::INPUT_WIDGET, 
                    'widgetClass'=> Select2::className(),
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

        echo $form->field($model, 'option_detail')->checkbox();
        
        echo Html::submitButton(Yii::t('app', 'Export'),
            ['class' => 'btn btn-success' ]
        );
        ActiveForm::end(); ?>

        
        
    </div>
</div>