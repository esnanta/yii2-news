<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var backend\models\Lookup $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="lookup-form">

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

            'title' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Title...', 'maxlength' => 50]],

            'token' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Token...', 'maxlength' => 5]],

            'category' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Category...', 'maxlength' => 30]],

            'sequence' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Sequence...']],

            'editable' => ['type' => Form::INPUT_DROPDOWN_LIST, 
                'options' => ['id' => 'id', 'prompt' => ''],
                'items' => $yesNoList,
            ],            
            
            'description' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => 'Enter Description...','rows' => 6]],
        ]

    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );
    ActiveForm::end(); ?>

</div>
