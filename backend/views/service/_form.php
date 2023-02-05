<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\Service */
/* @var $form yii\widgets\ActiveForm */

\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos'=> \yii\web\View::POS_END,
    'viewParams' => [
        'class' => 'ServiceDetail',
        'relID' => 'service-detail',
        'value' => \yii\helpers\Json::encode($serviceDetails),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);
?>

<div class="service-form">

    <?php $form = ActiveForm::begin([
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'enableAjaxValidation' => true,
        ]);
    ?>

    <?= $form->errorSummary($model); ?>


    <?php
        echo Form::widget([
            'model' => $model,
            'form' => $form,
            'columns' => 2,
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
                'date_issued' => [
                    'type' => Form::INPUT_WIDGET,
                    'widgetClass'=> DateControl::className(),
                    'format'=>'date',
                ],
                'staff_id' => [
                    'type' => Form::INPUT_WIDGET,
                    'widgetClass'=> Select2::className(),
                    'options' => [
                        'data' => $staffList,
                        'options' => ['placeholder' => 'Choose Staff', 'disabled'=>false],
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ],
                'date_effective' => [
                    'type' => Form::INPUT_WIDGET,
                    'widgetClass'=> DateControl::className(),
                    'format'=>'date',
                ],
            ]
        ]);
    ?>

    <br>

    <?php
    $forms = [
        [
            'label' => '<i class="glyphicon glyphicon-book"></i> ' . Html::encode('ServiceDetail'),
            'content' => $this->render('_formServiceDetail', [
                'row' => \yii\helpers\ArrayHelper::toArray($serviceDetails),
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
        <div class="col-md-12">
            <div class="col-md-6">
                <?php
                    echo Form::widget([
                        'model' => $model,
                        'form' => $form,
                        'columns' => 1,
                        'attributes' => [
                            'invoice' => ['type' => Form::INPUT_TEXT, 'options' => [
                                'placeholder' => 'Enter Invoice...',
                                'maxlength' => 8,
                                'disabled'=>$model->isNewRecord ? false : true]
                            ],
                            'description' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => 'Enter Description...','rows' => 6]],
                        ]
                    ]);
                ?>
            </div>
            <div class="col-md-6">
                <?php
                    if($type==backend\models\Service::SERVICE_TYPE_CHANGE_TO_DIGITAL){
                        
                        echo '<div class="well well-sm">';
                            echo Form::widget([
                                'model' => $model,
                                'form' => $form,
                                'columns' => 1,
                                'attributes' => [
                                    'service_type' => [
                                        'type' => Form::INPUT_WIDGET,
                                        'widgetClass'=> Select2::className(),
                                        'options' => [
                                            'data' => $serviceTypeList,
                                            'options' => ['placeholder' => '', 'disabled'=>true],
                                        ],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ],
                                    'billing_cycle' => [
                                        'type' => Form::INPUT_HIDDEN, 
                                        'widgetClass'=> Select2::className(),
                                        'options' => [
                                            'data' => $billingCycleList,
                                            'options' => ['placeholder' => 'Choose Cycle', 'disabled'=>false],
                                        ],                            
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],                            
                                    ],  
                                    'date_start' => [
                                        'type' => Form::INPUT_WIDGET,
                                        'widgetClass'=> DateControl::className(),
                                        'format'=>'date',
                                    ],
                                    'date_end' => [
                                        'type' => Form::INPUT_WIDGET,
                                        'widgetClass'=> DateControl::className(),
                                        'format'=>'date',
                                    ],
                                    'claim' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => '', 'maxlength' => true, 'disabled'=>false]],
                                    'surcharge' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => '', 'maxlength' => true, 'disabled'=>false]],
                                    'total' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => '', 'maxlength' => true, 'disabled'=>false]],
                                ]
                            ]);
                        echo '</div>';
                    }
                    else if($type==backend\models\Service::SERVICE_TYPE_EXTEND_DIGITAL ){
                        echo '<div class="well well-sm">';
                            echo Form::widget([
                                'model' => $model,
                                'form' => $form,
                                'columns' => 1,
                                'attributes' => [
                                    'service_type' => [
                                        'type' => Form::INPUT_WIDGET,
                                        'widgetClass'=> Select2::className(),
                                        'options' => [
                                            'data' => $serviceTypeList,
                                            'options' => ['placeholder' => '', 'disabled'=>true],
                                        ],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ],
                                    'billing_cycle' => [
                                        'type' => Form::INPUT_HIDDEN, 
                                        'widgetClass'=> Select2::className(),
                                        'options' => [
                                            'data' => $billingCycleList,
                                            'options' => ['placeholder' => 'Choose Cycle', 'disabled'=>false],
                                        ],                            
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],                            
                                    ],  
                                    'date_start' => [
                                        'type' => Form::INPUT_WIDGET,
                                        'widgetClass'=> DateControl::className(),
                                        'format'=>'date',
                                    ],
                                    'date_end' => [
                                        'type' => Form::INPUT_WIDGET,
                                        'widgetClass'=> DateControl::className(),
                                        'format'=>'date',
                                    ],
                                    'claim' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => '', 'maxlength' => true, 'disabled'=>true]],
                                    'surcharge' => ['type' => Form::INPUT_HIDDEN, 'options' => ['placeholder' => '', 'maxlength' => true, 'disabled'=>false]],
                                    'total' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => '', 'maxlength' => true, 'disabled'=>false]],
                                ]
                            ]);
                        echo '</div>';
                    }
                    else{
                        echo Form::widget([
                            'model' => $model,
                            'form' => $form,
                            'columns' => 1,
                            'attributes' => [
                                'claim' => ['type' => Form::INPUT_HIDDEN, 'options' => ['placeholder' => '', 'maxlength' => true, 'disabled'=>true]],
                                'surcharge' => ['type' => Form::INPUT_HIDDEN, 'options' => ['placeholder' => '', 'maxlength' => true, 'disabled'=>true]],
                                'total' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => '', 'maxlength' => true, 'disabled'=>true]],
                            ]
                        ]);
                    }
                ?>
            </div>

            <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>
            <?= $form->field($model, 'verlock', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

        </div>
        <div class="col-md-6">

        </div>
    </div>

    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    <?= Html::a(Yii::t('app', 'Cancel'), Yii::$app->request->referrer , ['class'=> 'btn btn-danger']) ?>

    <?php ActiveForm::end(); ?>

</div>

<?php
if($type==backend\models\Service::SERVICE_TYPE_CHANGE_TO_DIGITAL ||
    $type==backend\models\Service::SERVICE_TYPE_EXTEND_DIGITAL){
    
        $this->registerJsFile(
            '@web/js/service-digital.js',
            ['depends' => [yii\web\JqueryAsset::className()]]
        );
}
else{
        $this->registerJsFile(
            '@web/js/service.js',
            ['depends' => [yii\web\JqueryAsset::className()]]
        );
}
?>