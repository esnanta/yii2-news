<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\models\ArticleSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>


    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'category_id') ?>

    <?= $form->field($model, 'author_id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'cover') ?>

    <?php // echo $form->field($model, 'url') ?>

    <?php // echo $form->field($model, 'content') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'tags') ?>

    <?php // echo $form->field($model, 'publish_status') ?>

    <?php // echo $form->field($model, 'pinned_status') ?>

    <?php // echo $form->field($model, 'view_counter') ?>

    <?php // echo $form->field($model, 'rating') ?>


    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

