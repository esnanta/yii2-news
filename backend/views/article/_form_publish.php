<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\select2\Select2;
use bajadev\ckeditor\CKEditor;

use kartik\detail\DetailView;


/**
 * @var yii\web\View $this
 * @var common\models\Article $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="blog-form">

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]); 

    echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

            'publish_status' => [
                'type' => Form::INPUT_WIDGET, 
                'label'=>'Status',
                'widgetClass' => \kartik\widgets\SwitchInput::class,
                
                'pluginOptions' => [
                    'onText' => 'Yes',
                    'offText' => 'No',
                ],            
                
                'pluginEvents' => [
                    'change' => 'function() { log("change"); }',
                    'open' => 'function() { log("open"); }',
                ],
                
                'format'=>'raw',
                
            ],             
                   
        ]

    ]);
  
    
    ActiveForm::end(); ?>

</div>
