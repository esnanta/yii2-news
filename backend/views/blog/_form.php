<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\select2\Select2;
use kartik\datecontrol\DateControl;
use bajadev\ckeditor\CKEditor;
/**
 * @var yii\web\View $this
 * @var backend\models\Blog $model
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
            'date_issued' => [
                'type' => Form::INPUT_WIDGET, 
                'widgetClass'=> DateControl::className(),
                'format'=>'date',
            ],
            'title' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Title...', 'maxlength' => 150]],
            
            'author_id' => [
                'type' => Form::INPUT_WIDGET, 
                'widgetClass'=> Select2::className(),
                'options' => [
                    'data' => $authorList,
                    'options' => ['placeholder' => 'Choose Author', 'disabled'=>false],
                ],                            
                'pluginOptions' => [
                    'allowClear' => true
                ],                            
            ],             
            
            'category_id' => [
                'type' => Form::INPUT_WIDGET, 
                'widgetClass'=> Select2::className(),
                'options' => [
                    'data' => $categoryList,
                    'options' => ['placeholder' => 'Choose Category', 'disabled'=>false],
                ],                            
                'pluginOptions' => [
                    'allowClear' => true
                ],                            
            ],                 

        ]

    ]);
  
    echo $form->field($model, 'tags')->widget(Select2::classname(), [
        'data' => $tagList,
        'maintainOrder' => true,
        'options' => ['placeholder' => 'Use comma as separator', 'multiple' => true],
        'pluginOptions' => [
            'tags' => true,
            'tokenSeparators' => [',',' '],
            'maximumInputLength' => 5            
        ],
    ]);        
    
    echo $form->field($model, 'content')->widget(CKEditor::className(), [
        'editorOptions' => [
            'preset' => 'full', // basic, standard, full
            'inline' => false,
            'filebrowserBrowseUrl' => 'browse-images',
            'filebrowserUploadUrl' => 'upload-images',
            'extraPlugins' => 'imageuploader,youtube',
        ],
    ]); 
    
    echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [
            'description' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => 'Enter Description...','rows' => 6]],
        ]
    ]);    
    
    
    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );
    ActiveForm::end(); ?>

</div>
