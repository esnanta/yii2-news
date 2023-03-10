<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\select2\Select2;

/**
 * @var yii\web\View $this
 * @var backend\models\SocialMedia $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="social-media-form">

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

            'title' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Title...', 'maxlength' => 100]],

            'icon' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => Select2::className(),
                'options' => [
                    'data' => $socialMediaList,
                    'options' => ['placeholder' => 'Choose Social Media', 'disabled' => false],
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ],
            'url' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Url...', 'maxlength' => 100]],
            'description' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => 'Enter Description...','rows' => 6]],
        ]

    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );
    ActiveForm::end(); ?>

</div>
