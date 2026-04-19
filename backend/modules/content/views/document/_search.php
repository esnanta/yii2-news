<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\models\Document $model
 * @var yii\bootstrap4\ActiveForm $form
 */
?>

<div class="document-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php echo $form->field($model, 'id') ?>
    <?php echo $form->field($model, 'office_id') ?>
    <?php echo $form->field($model, 'is_visible') ?>
    <?php echo $form->field($model, 'category_id') ?>
    <?php echo $form->field($model, 'title') ?>
    <?php // echo $form->field($model, 'date_issued') ?>
    <?php // echo $form->field($model, 'base_url') ?>
    <?php // echo $form->field($model, 'path') ?>
    <?php // echo $form->field($model, 'name') ?>
    <?php // echo $form->field($model, 'type') ?>
    <?php // echo $form->field($model, 'size') ?>
    <?php // echo $form->field($model, 'view_count') ?>
    <?php // echo $form->field($model, 'download_count') ?>
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
