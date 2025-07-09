<?php

use kartik\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\models\AssetSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'fieldConfig' => [
            'options' => [
                'class' => 'col-md-12 col-xs-12 form-group' ,
                'tag' => 'div',
            ],
        ],
        'formConfig' => [
            'showLabels' => false ,
            'formConfig' => [ 'deviceSize' => ActiveForm::SIZE_LARGE ],
        ],
        'options' => [
            'class' => 'input-group rounded',
        ],    
    ]); ?>

    <?= $form->field($model, 'title')->label(false)->textInput([
            'class'=>'form-control g-brd-secondary-light-v2 g-brd-primary--focus g-color-secondary-dark-v1 g-placeholder-secondary-dark-v1 g-bg-white g-font-weight-400 g-font-size-13 g-px-20 g-py-12',
            'placeholder' => 'Search Asset'
    ]) ?>

<?php ActiveForm::end(); ?>

