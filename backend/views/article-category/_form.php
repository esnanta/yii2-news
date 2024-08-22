<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\select2\Select2;
use kartik\detail\DetailView;
/**
 * @var yii\web\View $this
 * @var common\models\ArticleCategory $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

            'title' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => '', 'maxlength' => 100]],
            'sequence' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => '']],
            
            'label' => [
                'type' => Form::INPUT_WIDGET, 
                'widgetClass'=> Select2::class,
                'options' => [
                    'data' => $labelList,
                    'options' => ['id' => 'label', 'placeholder' => '', 'disabled'=>false],
                ],                            
                'pluginOptions' => [
                    'allowClear' => true
                ],                            
            ],                
                     
            'time_line' => [
                'type' => Form::INPUT_WIDGET, 
                'widgetClass'=> Select2::class,
                'options' => [
                    'data' => $dataList,
                    'options' => ['placeholder' => '', 'disabled'=>false],
                ],                            
                'pluginOptions' => [
                    'allowClear' => true
                ],                            
            ],             
            'description' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => '','rows' => 6]],
        ]

    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );
    ActiveForm::end(); ?>

</div>
