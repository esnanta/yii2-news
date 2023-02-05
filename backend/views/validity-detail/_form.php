<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\widgets\Select2;

/**
 * @var yii\web\View $this
 * @var backend\models\ValidityDetail $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="validity-detail-form">

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]); 
    
    echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [
            
            'customer_id' => [
                'type' => Form::INPUT_WIDGET, 
                'widgetClass'=> Select2::className(),
                'options' => [
                    'data' => $customerList,
                    'options' => ['placeholder' => 'Choose Customer', 'disabled'=>true],
                ],                            
                'pluginOptions' => [
                    'allowClear' => true
                ],                            
            ], 

            'device_status' => [
                'type' => Form::INPUT_WIDGET, 
                'widgetClass'=> Select2::className(),
                'options' => [
                    'data' => $deviceStatusList,
                    'options' => ['placeholder' => 'Choose Device Status', 'disabled'=>true],
                ],                            
                'pluginOptions' => [
                    'allowClear' => true
                ],                            
            ], 

            'billing_status' => [
                'type' => Form::INPUT_WIDGET, 
                'widgetClass'=> Select2::className(),
                'options' => [
                    'data' => $billingStatusList,
                    'options' => ['placeholder' => 'Choose Billing Status', 'disabled'=>true],
                ],                            
                'pluginOptions' => [
                    'allowClear' => true
                ],                            
            ],   
            
            'amount' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Amount...', 'maxlength' => 18]],

        ]

    ]);        
     
    echo '<div class="row">';
        echo '<div class="col-md-2">';
        echo '</div>';
        echo '<div class="col-md-10">';
            echo '<div class="callout callout-danger">';
                echo '<i class="fa fa-info-circle"></i> Bulan validasi yang ditampilkan adalah yang belum disimpan.';
            echo '</div>';
        echo '</div>';
    echo '</div>';
    
    echo $form->field($model, 'validity_period')->widget(Select2::classname(), [
        'data' => $validityList,
        'maintainOrder' => true,
        'options' => ['placeholder' => 'Gunakan "Ctrl" untuk memilih lebih dari satu data', 'multiple' => true],
        'pluginOptions' => [
            'tags' => true,
            'tokenSeparators' => [',',' '],
            'maximumInputLength' => 12            
        ],
    ]);
    
    echo Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [
            'description' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => 'Enter Description...','rows' => 2]],
        ]
    ]);   

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );
    ActiveForm::end(); ?>

</div>

<?php
    $this->registerJsFile(
        '@web/js/validity-detail.js',
        ['depends' => [yii\web\JqueryAsset::className()]]
    );
?>