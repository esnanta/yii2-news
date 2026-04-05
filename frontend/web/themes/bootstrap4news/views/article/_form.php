<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\select2\Select2;
use bajadev\ckeditor\CKEditor;
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

            'title' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Title...', 'maxlength' => 150]],
            
            'author_id' => ['type' => Form::INPUT_DROPDOWN_LIST, 
                'options' => ['id' => 'author_id', 'prompt' => ''],
                'items' => $authorList,
            ],             
            
            'category_id' => ['type' => Form::INPUT_DROPDOWN_LIST, 
                'options' => ['id' => 'category_id', 'prompt' => ''],
                'items' => $categoryList,
            ],            

            'publish_status' => ['type' => Form::INPUT_DROPDOWN_LIST, 
                'options' => ['id' => 'lookup_id', 'prompt' => ''],
                'items' => $publishList,
            ],            
            
            'approval_status' => ['type' => Form::INPUT_DROPDOWN_LIST, 
                'options' => ['id' => 'lookup_id', 'prompt' => ''],
                'items' => $approvalList,
            ],
            
            'pinned_status' => ['type' => Form::INPUT_DROPDOWN_LIST, 
                'options' => ['id' => 'lookup_id', 'prompt' => ''],
                'items' => $pinnedList,
            ],

            'description' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => 'Enter Description...','rows' => 6]],

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
            'extraPlugins' => 'imageuploader',
        ],
    ]); 
    
    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );
    ActiveForm::end(); ?>

</div>
