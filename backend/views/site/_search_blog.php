<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var backend\models\BlogSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="blog-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'title')->label(false)->textInput(['placeholder' => 'Search Title']) ?>
   
    <?php ActiveForm::end(); ?>

</div>
