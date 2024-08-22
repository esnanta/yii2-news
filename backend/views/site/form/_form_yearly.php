
<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\widgets\Select2;
?>


        <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL]); ?>

        <?php
            echo Form::widget([

                'model' => $model,
                'form' => $form,
                'columns' => 4,
                'attributes' => [

                    'option_year' => [
                        'type' => Form::INPUT_WIDGET, 
                        'widgetClass'=> Select2::class,
                        'options' => [
                            'data' => $yearList,
                            'options' => ['placeholder' => 'Choose option', 'disabled'=>false],
                        ],                            
                        'pluginOptions' => [
                            'allowClear' => true
                        ],                            
                    ],
                ]

            ]);
        ?>
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        <?php ActiveForm::end(); ?>

        
