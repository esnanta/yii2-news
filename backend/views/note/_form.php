<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use bajadev\ckeditor\CKEditor;
/**
 * @var yii\web\View $this
 * @var backend\models\Note $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="note-form">

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [


            'note_type_id' => ['type' => Form::INPUT_DROPDOWN_LIST, 
                'options' => ['id' => 'note_type_id', 'prompt' => ''],
                'items' => $dataList,
            ],               
            
            'title' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Title...', 'maxlength' => 10]],
           
            'date_issued' => [
                'type' => Form::INPUT_WIDGET, 
                'widgetClass'=> DateControl::className(),
                'format'=>'date',
            ],

            'date_due' => [
                'type' => Form::INPUT_WIDGET, 
                'widgetClass'=> DateControl::className(),
                'format'=>'date',
            ],  

        ]

    ]);

    echo $form->field($model, 'description')->widget(CKEditor::className(), [
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
