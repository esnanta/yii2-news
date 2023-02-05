
<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\widgets\Select2;
?>
    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]); ?>

    <?php
        echo Form::widget([

            'model' => $modelReportSummary,
            'form' => $form,
            'columns' => 4,
            'attributes' => [
                
                'option_type' => [
                    'type' => Form::INPUT_WIDGET, 
                    'widgetClass'=> Select2::className(),
                    'options' => [
                        'data' => $typeSummaryList,
                        'options' => ['placeholder' => 'Choose option', 'disabled'=>false],
                    ],                            
                    'pluginOptions' => [
                        'allowClear' => true
                    ],                            
                ],
                
                'option_date' => [
                    'type' => Form::INPUT_WIDGET, 
                    'widgetClass'=> Select2::className(),
                    'options' => [
                        'data' => $dateSummaryList,
                        'options' => ['placeholder' => 'Choose option', 'disabled'=>false],
                    ],                            
                    'pluginOptions' => [
                        'allowClear' => true
                    ],                            
                ], 

                'date_first' => [
                    'type' => Form::INPUT_WIDGET, 
                    'widgetClass'=> DateControl::className(),
                    'format'=>'date',                          
                ],  
                'date_last' => [
                    'type' => Form::INPUT_WIDGET, 
                    'widgetClass'=> DateControl::className(),
                    'format'=>'date',                          
                ],              

            ]

        ]);
    ?>
    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    <?php ActiveForm::end(); ?>