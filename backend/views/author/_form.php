<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\widgets\FileInput;
use bajadev\ckeditor\CKEditor;
/**
 * @var yii\web\View $this
 * @var common\models\Author $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="author-form">

    <?php $form = ActiveForm::begin([
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'options'=>['enctype'=>'multipart/form-data'] 
    ]); 
    
    
    echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [
            'title' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => '', 'maxlength' => 100]],
            'phone_number' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => '', 'maxlength' => 50]],
            'email' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => '', 'maxlength' => 100]],
        ]

    ]);

    echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [
            'address' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => '','rows' => 6]],
        ]

    ]);    
    
    
    echo $form->field($model, 'description')->widget(CKEditor::class, [
        'editorOptions' => [
            'preset' => 'basic', // basic, standard, full
            'inline' => false,
        ],
    ]); 
        
        
    
    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );
    
    
    
    ActiveForm::end(); ?>

</div>
