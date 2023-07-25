<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var backend\models\ArchiveSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="archive-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'is_visible') ?>

    <?= $form->field($model, 'archive_type') ?>

    <?= $form->field($model, 'archive_category_id') ?>

    <?= $form->field($model, 'title') ?>

    <?php // echo $form->field($model, 'date_issued') ?>

    <?php // echo $form->field($model, 'file_name') ?>

    <?php // echo $form->field($model, 'archive_url') ?>

    <?php // echo $form->field($model, 'size') ?>

    <?php // echo $form->field($model, 'mime_type') ?>

    <?php // echo $form->field($model, 'view_counter') ?>

    <?php // echo $form->field($model, 'download_counter') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'is_deleted') ?>

    <?php // echo $form->field($model, 'deleted_at') ?>

    <?php // echo $form->field($model, 'deleted_by') ?>

    <?php // echo $form->field($model, 'verlock') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
