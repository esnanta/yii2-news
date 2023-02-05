<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\select2\Select2;

/**
 * @var yii\web\View $this
 * @var backend\models\Album $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="album-form">
    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

            'album_type' => [
                'type' => Form::INPUT_WIDGET, 
                'widgetClass'=> Select2::className(),
                'options' => [
                    'data' => $dataList,
                    'options' => ['placeholder' => 'Choose Type', 'disabled'=>false],
                ],                            
                'pluginOptions' => [
                    'allowClear' => true
                ],                            
            ],            
            
            'title' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Title...', 'maxlength' => 200]],

            'description' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => 'Enter Description...','rows' => 6]],

            'cover' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Cover...', 'maxlength' => 500]],

        ]

    ]);
    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );
    ActiveForm::end(); ?>
    
</div>
