<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\widgets\Select2;
use bajadev\ckeditor\CKEditor;
/**
 * @var yii\web\View $this
 * @var backend\models\Product $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [
            'title' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Title...', 'maxlength' => 100]],
            
            'product_type_id' => [
                'type' => Form::INPUT_WIDGET, 
                'widgetClass'=> Select2::className(),
                'options' => [
                    'data' => $productTypeList,
                    'options' => ['placeholder' => 'Choose Type', 'disabled'=>false],
                ],                            
                'pluginOptions' => [
                    'allowClear' => true
                ],                            
            ], 
            
            'measure_id' => [
                'type' => Form::INPUT_WIDGET, 
                'widgetClass'=> Select2::className(),
                'options' => [
                    'data' => $measureList,
                    'options' => ['placeholder' => 'Choose Measure', 'disabled'=>false],
                ],                            
                'pluginOptions' => [
                    'allowClear' => true
                ],                            
            ], 

            'price' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Price...', 'maxlength' => 18]],
            'cover_url' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Cover Url...', 'maxlength' => 300]],
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
    
    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );
    ActiveForm::end(); ?>

</div>
