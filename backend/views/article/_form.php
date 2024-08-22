<?php

use common\helper\DateHelper;
use kartik\form\ActiveForm as ActiveFormAlias;
use kartik\widgets\Select2;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;

use kartik\datecontrol\DateControl;
use kartik\editors\Summernote;

/**
 * @var yii\web\View $this
 * @var common\models\Article $model
 * @var common\models\Tag $tagList
 * @var common\models\Author $authorList
 * @var common\models\ArticleCategory $articleCategoryList
 * @var yii\widgets\ActiveForm $form
 */
?>
   
<div class="blog-form">

    <?php $form = ActiveForm::begin(['type' => ActiveFormAlias::TYPE_HORIZONTAL]);
    
    echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [
            'date_issued' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass'=> DateControl::class,
                'format'=> DateHelper::getDateSaveFormat(),
            ],
            'title' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => '', 'maxlength' => 150]],
            
            'author_id' => [
                'type' => Form::INPUT_WIDGET, 
                'widgetClass'=> Select2::class,
                'options' => [
                    'data' => $authorList,
                    'options' => ['placeholder' => '', 'disabled'=>false],
                ],                            
                'pluginOptions' => [
                    'allowClear' => true
                ],                            
            ],             
            
            'article_category_id' => [
                'type' => Form::INPUT_WIDGET, 
                'widgetClass'=> Select2::class,
                'options' => [
                    'data' => $articleCategoryList,
                    'options' => ['placeholder' => '', 'disabled'=>false],
                ],                            
                'pluginOptions' => [
                    'allowClear' => true
                ],                            
            ],                 

        ]

    ]);
  
    echo $form->field($model, 'tags')->widget(Select2::class, [
        'data' => $tagList,
        'maintainOrder' => true,
        'options' => ['placeholder' => 'Use comma as separator', 'multiple' => true],
        'pluginOptions' => [
            'tags' => true,
            'tokenSeparators' => [',',' '],
            'maximumInputLength' => 5
        ],
    ]);

    echo $form->field($model, 'content')->widget(Summernote::class, [
        'options' => ['placeholder' => ''],
    ]);
    
    echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [
            'description' => ['type' => Form::INPUT_TEXTAREA, 'options' => [
                    'placeholder' => '','rows' => 4
            ]],
        ]
    ]);    
    
    
    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );
    ActiveForm::end(); ?>

</div>
