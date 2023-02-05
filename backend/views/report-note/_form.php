<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;

/**
 * @var yii\web\View $this
 * @var backend\models\Category $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

            'first' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter First...', 'maxlength' => 100]],
            'last' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Last...', 'maxlength' => 100]],

        ]

    ]);

    echo Html::submitButton(Yii::t('app', 'Create'),
        ['class' => 'btn btn-success' ]
    );
    ActiveForm::end(); ?>

</div>
