<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var backend\models\Comment $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="comment-form">

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

            'blog_id' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Blog ID...']],

            'publish_status' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Publish Status...']],            
            
            'title' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Title...', 'maxlength' => 100]],

            'email' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Email...', 'maxlength' => 100]],

            'url' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Url...', 'maxlength' => 100]],

            'content' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => 'Enter Content...','rows' => 6]],
            
        ]

    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );
    ActiveForm::end(); ?>

</div>
