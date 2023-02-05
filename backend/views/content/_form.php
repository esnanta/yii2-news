<?php

use yii\helpers\Html;
use bajadev\ckeditor\CKEditor;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\widgets\FileInput;
use kartik\select2\Select2;
/**
 * @var yii\web\View $this
 * @var backend\models\Content $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="content-form">

    <?php $form = ActiveForm::begin([
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'options'=>['enctype'=>'multipart/form-data'] 
    ]); 
    
    
    echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

            'theme_id' => [
                'type' => Form::INPUT_WIDGET, 
                'widgetClass'=> Select2::className(),
                'options' => [
                    'data' => $dataList,
                    'options' => ['placeholder' => 'Choose Theme', 'disabled'=>false],
                ],                            
                'pluginOptions' => [
                    'allowClear' => true
                ],                            
            ],   
            
            'title' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Title...', 'maxlength' => 100]],
            'token' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Token...', 'maxlength' => 5]],
            'icon' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Icon...', 'maxlength' => 50]],
            'label' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Label...', 'maxlength' => 50]],            
            
            'description' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => 'Enter Description...','rows' => 6]],           

        ]

    ]);

    echo $form->field($model, 'content')->widget(CKEditor::className(), [
        'editorOptions' => [
            'preset' => 'full', // basic, standard, full
            'inline' => false,
            'filebrowserBrowseUrl' => 'browse-images',
            'filebrowserUploadUrl' => 'upload-images',
            'extraPlugins' => 'imageuploader',
        ],
    ]);     
    
    // your fileinput widget for single file upload
    echo $form->field($model, 'image')->widget(FileInput::classname(), [
        'options'=>['accept'=>'image/*'],
        'pluginOptions'=>['allowedFileExtensions'=>['jpg','gif','png']
    ]]);        
    
    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );
    ActiveForm::end(); ?>

</div>
