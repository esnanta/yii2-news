<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var backend\models\SiteLink $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="site-link-form">

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

            'title' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Nama...', 'maxlength' => 100]],
            'sequence' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Sequence...']],
            'url' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Url...', 'maxlength' => 200]],
            'description' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => 'Enter description...','rows' => 6]],

        ]

    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );
    ActiveForm::end(); ?>

</div>
