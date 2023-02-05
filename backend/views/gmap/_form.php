<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\Gmap */
/* @var $form yii\widgets\ActiveForm */

\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos'=> \yii\web\View::POS_END, 
    'viewParams' => [
        'class' => 'GmapDetail', 
        'relID' => 'gmap-detail', 
        'value' => \yii\helpers\Json::encode($model->gmapDetails),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);
?>

<div class="gmap-form">

    <?php $form = ActiveForm::begin([
        'type' => ActiveForm::TYPE_VERTICAL,
        'enableAjaxValidation' => true,
        ]); 
    ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>


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
                'latitude' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Latitude...', 'maxlength' => 30]],
                'longitude' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Longitude...', 'maxlength' => 30]],
                'description' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => 'Enter Description...','rows' => 6]],
            ]
        ]);      
    ?>             
    
    <?php
//    $forms = [
//        [
//            'label' => '<i class="glyphicon glyphicon-book"></i> ' . Html::encode('GmapDetail'),
//            'content' => $this->render('_formGmapDetail', [
//                'row' => \yii\helpers\ArrayHelper::toArray($model->gmapDetails),
//            ]),
//        ],
//    ];
//    echo kartik\tabs\TabsX::widget([
//        'items' => $forms,
//        'position' => kartik\tabs\TabsX::POS_ABOVE,
//        'encodeLabels' => false,
//        'pluginOptions' => [
//            'bordered' => true,
//            'sideways' => true,
//            'enableCache' => false,
//        ],
//    ]);
    ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Cancel'), Yii::$app->request->referrer , ['class'=> 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
