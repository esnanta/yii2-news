<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Profile */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="user-form">

    <?= $form->field($Profile, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Name']) ?>

    <?= $form->field($Profile, 'public_email')->textInput(['maxlength' => true, 'placeholder' => 'Public Email']) ?>

    <?= $form->field($Profile, 'gravatar_email')->textInput(['maxlength' => true, 'placeholder' => 'Gravatar Email']) ?>

    <?= $form->field($Profile, 'gravatar_id')->textInput(['maxlength' => true, 'placeholder' => 'Gravatar']) ?>

    <?= $form->field($Profile, 'location')->textInput(['maxlength' => true, 'placeholder' => 'Location']) ?>

    <?= $form->field($Profile, 'website')->textInput(['maxlength' => true, 'placeholder' => 'Website']) ?>

    <?= $form->field($Profile, 'timezone')->textInput(['maxlength' => true, 'placeholder' => 'Timezone']) ?>

    <?= $form->field($Profile, 'bio')->textarea(['rows' => 6]) ?>

    <?= $form->field($Profile, 'file_name')->textInput(['maxlength' => true, 'placeholder' => 'File Name']) ?>

</div>
