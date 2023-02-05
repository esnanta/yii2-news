<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\widgets\FileInput;
use kartik\select2\Select2;


/**
 * @var yii\web\View $this
 * @var backend\models\Photo $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="photo-form">

    <?php $form = ActiveForm::begin([
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'options'=>['enctype'=>'multipart/form-data'] 
    ]); 
    
    echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [
          
            'album_id' => [
                'type' => Form::INPUT_WIDGET, 
                'widgetClass'=> Select2::className(),
                'options' => [
                    'data' => $dataList,
                    'options' => ['placeholder' => 'Choose Album', 'disabled'=>true],
                ],                            
                'pluginOptions' => [
                    'allowClear' => true
                ],                            
            ],
            
            'title' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Title...', 'maxlength' => 200]],
             
            // display the image uploaded or show a placeholder
            // you can also use this code below in your `view.php` file
            
            'description' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => 'Enter Description...','rows' => 6]],

        ]

    ]);

    // your fileinput widget for single file upload
    echo $form->field($model, 'image')->widget(FileInput::classname(), [
        'options'=>['accept'=>'image/*'],
        'pluginOptions'=>[
            'allowedFileExtensions'=>['jpg','jpeg','gif','png'],
            'previewFileType' => 'any',
            'showUpload' => false,
        ]
    ]);    
        
    // render a delete image button 
    if (!$model->isNewRecord) { 
        echo Html::a('Delete', ['/photo/delete', 'id'=>$model->id], ['class'=>'btn btn-danger']);
    }    
        
    
    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );
    
    ActiveForm::end(); ?>

</div>
