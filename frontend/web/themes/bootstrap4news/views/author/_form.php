<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use trntv\filekit\widget\Upload;
use yii\web\JsExpression;

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

            'title' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Title...', 'maxlength' => 100]],
            'description' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => 'Enter Description...','rows' => 6]],

        ]

    ]);

    
    echo $form->field($model, 'image')->widget(
        Upload::class,
        [
            'url' => ['/file/storage/upload'],
            'maxFileSize' => 5000000,
            'acceptFileTypes' => new JsExpression('/(\\.|\\/)(gif|jpe?g|png)$/i'),
        ]
    );
    
    // render a delete image button 
    if (!$model->isNewRecord) { 
        echo Html::a('Delete', ['/photo/delete', 'id'=>$model->id], ['class'=>'btn btn-danger']);
    }    
        
    
    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );
    
    
    
    ActiveForm::end(); ?>

</div>
