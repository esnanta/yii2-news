<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\models\Office $model
 * @var yii\bootstrap4\ActiveForm $form
 */
?>

<div class="office-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php echo $form->field($model, 'id') ?>
    <?php echo $form->field($model, 'unique_id') ?>
    <?php echo $form->field($model, 'title') ?>
    <?php echo $form->field($model, 'phone_number') ?>
    <?php echo $form->field($model, 'fax_number') ?>
    <?php // echo $form->field($model, 'email') ?>
    <?php // echo $form->field($model, 'web') ?>
    <?php // echo $form->field($model, 'address') ?>
    <?php // echo $form->field($model, 'latitude') ?>
    <?php // echo $form->field($model, 'longitude') ?>
    <?php // echo $form->field($model, 'description') ?>
    <?php // echo $form->field($model, 'created_at') ?>
    <?php // echo $form->field($model, 'updated_at') ?>
    <?php // echo $form->field($model, 'created_by') ?>
    <?php // echo $form->field($model, 'updated_by') ?>
    <?php // echo $form->field($model, 'is_deleted') ?>
    <?php // echo $form->field($model, 'deleted_at') ?>
    <?php // echo $form->field($model, 'deleted_by') ?>
    <?php // echo $form->field($model, 'verlock') ?>
    <?php // echo $form->field($model, 'uuid') ?>

    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('backend', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?php echo Html::resetButton(Yii::t('backend', 'Reset'), ['class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
