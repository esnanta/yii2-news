<?php

use yii\helpers\Html;

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\AccountReceivable */
/* @var $form yii\widgets\ActiveForm */

\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos'=> \yii\web\View::POS_END, 
    'viewParams' => [
        'class' => 'AccountReceivableDetail', 
        'relID' => 'account-receivable-detail', 
        'value' => \yii\helpers\Json::encode($model->accountReceivableDetails),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);
?>

<div class="account-receivable-form">

    <?php $form = ActiveForm::begin([
        'type' => ActiveForm::TYPE_VERTICAL,
        'enableAjaxValidation' => false,
        ]); 
    ?>

    <?php
    $forms = [
        [
            'label' => '<i class="glyphicon glyphicon-book"></i> ' . Html::encode('Account Detail'),
            'content' => $this->render('_formAccountReceivableDetail', [
                'row' => \yii\helpers\ArrayHelper::toArray($model->accountReceivableDetails),
            ]),
        ],
    ];
    ?>
    
    <div class="row">
        <div class="col-md-12">
            <?php
                echo Form::widget([
                    'model' => $model,
                    'form' => $form,
                    'columns' => 3,
                    'attributes' => [
                        'date_issued' => [
                            'type' => Form::INPUT_WIDGET, 
                            'widgetClass'=> DateControl::className(),
                            'format'=>'date',
                        ],
                        'staff_id' => [
                            'type' => Form::INPUT_WIDGET, 
                            'widgetClass'=> Select2::className(),
                            'options' => [
                                'data' => $dataList,
                                'options' => ['placeholder' => 'Choose Staff', 'disabled'=>false],
                            ],                            
                            'pluginOptions' => [
                                'allowClear' => true
                            ],                            
                        ],                         
                        'invoice' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Invoice...', 'maxlength' => 20]],                      
                    ]
                ]);      
            ?>            
        </div>
    </div>
    
    <?php
        echo $form->errorSummary($model->accountReceivableDetails);    
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
        <div class="col-md-8">
            <?php
                echo Form::widget([
                    'model' => $model,
                    'form' => $form,
                    'columns' => 1,
                    'attributes' => [  
                        'description' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => 'Enter Description...','rows' => 6]],
                        ''
                    ]
                ]);      
            ?>            
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'claim')->textInput(['maxlength' => true, 'placeholder' => 'Claim']) ?>

            <?= $form->field($model, 'surcharge')->textInput(['maxlength' => true, 'placeholder' => 'Surcharge'])->hiddenInput()->label(false) ?>

            <?= $form->field($model, 'penalty')->textInput(['maxlength' => true, 'placeholder' => 'Penalty'])->hiddenInput()->label(false) ?>

            <?= $form->field($model, 'total')->textInput(['maxlength' => true, 'placeholder' => 'Total'])->hiddenInput()->label(false) ?>

            <?= $form->field($model, 'discount')->textInput(['maxlength' => true, 'placeholder' => 'Discount'])->hiddenInput()->label(false) ?>

            <?= $form->field($model, 'payment')->textInput(['maxlength' => true, 'placeholder' => 'Payment']) ?>

            <?= $form->field($model, 'balance')->textInput(['maxlength' => true, 'placeholder' => 'Balance']) ?>             
        </div>
    </div>
    
   
    
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Cancel'), Yii::$app->request->referrer , ['class'=> 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
    $this->registerJsFile(
        '@web/js/account-receivable.js',
        ['depends' => [yii\web\JqueryAsset::className()]]
    );
?>
