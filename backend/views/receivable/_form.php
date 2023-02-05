<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\Receivable */
/* @var $form yii\widgets\ActiveForm */

\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos'=> \yii\web\View::POS_END, 
    'viewParams' => [
        'class' => 'ReceivableDetail', 
        'relID' => 'receivable-detail', 
        'value' => \yii\helpers\Json::encode($receivableDetails),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);
?>

<div class="receivable-form">

    <?php $form = ActiveForm::begin([
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'enableAjaxValidation' => false,
        ]); 
    ?>

    <?= $form->errorSummary($model); ?>

    <div class="row">
        <div class="col-md-6">
            
            
            <?php
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
                        'staff_id' => [
                            'type' => Form::INPUT_WIDGET, 
                            'widgetClass'=> Select2::className(),
                            'options' => [
                                'data' => $staffList,
                                'options' => ['placeholder' => 'Choose Staff'],
                            ],                            
                            'pluginOptions' => [
                                'allowClear' => true
                            ],                            
                        ],                      
                    ]
                ]);      
            ?>
                      
            
        </div>
        <div class="col-md-6">
            <?php
                echo Form::widget([
                    'model' => $model,
                    'form' => $form,
                    'columns' => 1,
                    'attributes' => [
                        'date_issued' => [
                            'type' => Form::INPUT_WIDGET, 
                            'widgetClass'=> DateControl::className(),
                            'format'=>'date',
                        ],                          
                        'invoice' => ['type' => Form::INPUT_TEXT, 'options' => [
                            'placeholder' => 'Enter Invoice...', 
                            'maxlength' => 8,
                            'disabled'=>$model->isNewRecord ? false : true]
                        ],
                        
                    ]
                ]);      
            ?>               
        </div>        
    </div>
    
    <?php
    $forms = [
        [
            'label' => '<i class="glyphicon glyphicon-book"></i> ' . Html::encode('ReceivableDetail'),
            'content' => $this->render('_formReceivableDetail', [
                'row' => \yii\helpers\ArrayHelper::toArray($receivableDetails),
            ]),
        ],
    ];
    echo kartik\tabs\TabsX::widget([
        'items' => $forms,
        'position' => kartik\tabs\TabsX::POS_ABOVE,
        'encodeLabels' => false,
        'pluginOptions' => [
            'bordered' => true,
            'sideways' => true,
            'enableCache' => false,
        ],
    ]);
    ?>    
    
    <div class="row">
        <div class="col-md-7">

            <?php
                echo Form::widget([
                    'model' => $model,
                    'form' => $form,
                    'columns' => 1,
                    'attributes' => [
                        'description' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => 'Enter Description...','rows' => 6]],                          
                    ]
                ]);      
            ?>             
            
        </div>
        <div class="col-md-5">
            
            <?php
                echo Form::widget([
                    'model' => $model,
                    'form' => $form,
                    'columns' => 1,
                    'attributes' => [
                        'claim' => ['type' => Form::INPUT_HIDDEN, 'options' => ['placeholder' => 'Claim', 'maxlength' => true]],
                        'surcharge' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Surcharge', 'maxlength' => true]],
                        'penalty' => ['type' => Form::INPUT_HIDDEN, 'options' => ['placeholder' => 'Penalty', 'maxlength' => true]],
                        'total' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Total', 'maxlength' => true]],
                        'discount' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Discount', 'maxlength' => true]],
                        'payment' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Payment', 'maxlength' => true]],
                        'balance' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Balance', 'maxlength' => true]],
                    ]
                ]);      
            ?>              
            
        </div>
    </div>
    

    
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Cancel'), Yii::$app->request->referrer , ['class'=> 'btn btn-danger']) ?>
    

    <?php ActiveForm::end(); ?>

</div>

<?php
    $this->registerJsFile(
        '@web/js/receivable.js',
        ['depends' => [yii\web\JqueryAsset::className()]]
    );
?>