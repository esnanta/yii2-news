<?php

use kartik\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\models\BlogSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>


<?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'fieldConfig' => [
            'options' => [
                'class' => 'col-lg-12 col-sm-12 col-xs-12 form-group' ,
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
            'placeholder' => 'Search Blog'
    ]) ?>

<?php ActiveForm::end(); ?>



