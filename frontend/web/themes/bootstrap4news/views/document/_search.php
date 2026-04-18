<?php

use kartik\widgets\ActiveForm;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\search\DocumentSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="document-search mb-4">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php echo $form->field($model, 'title', [
        'inputOptions' => [
            'class' => 'form-control document-search-input',
            'placeholder' => Yii::t('frontend', 'Search for documents...'),
        ],
        'addon' => [
            'append' => [
                'content' => Html::submitButton('<i class="fa fa-search"></i>', [
                    'class' => 'btn btn-primary document-search-submit',
                    'aria-label' => Yii::t('frontend', 'Search'),
                ]),
                'asButton' => true,
            ],
        ],
    ])->label(false); ?>

    <?php ActiveForm::end(); ?>
</div>
