<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\Outlet */
/* @var $form yii\widgets\ActiveForm */

\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos'=> \yii\web\View::POS_END, 
    'viewParams' => [
        'class' => 'OutletDetail', 
        'relID' => 'outlet-detail', 
        'value' => \yii\helpers\Json::encode($outletDetails),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);
?>

<div class="outlet-form">

    <?php $form = ActiveForm::begin([
        'type' => ActiveForm::TYPE_VERTICAL,
        'enableAjaxValidation' => FALSE,
        ]); 
    ?>

    <?= $form->errorSummary($model); ?>
    
    
        <div class="row">
            <div class="col-md-12">
                <?php
                
                    if($model->isNewRecord && empty($checkEnrolment)){
                        echo '<div class="well well-sm">';
                            echo '<p class="help-block"> Nomor Berlangganan : <span class="label label-danger">' .$nextNumber.'</span></p>';
                            echo Form::widget([

                                'model' => $model,
                                'form' => $form,
                                'columns' => 3,
                                'attributes' => [
                                    'enrolment_type' => [
                                        'type' => Form::INPUT_WIDGET, 
                                        'widgetClass'=> Select2::className(),
                                        'options' => [
                                            'data' => $enrolmentTypeList,
                                            'options' => ['placeholder' => '', 'disabled'=>false],
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
                                ]

                            ]);
                            echo Form::widget([

                                'model' => $model,
                                'form' => $form,
                                'columns' => 3,
                                'attributes' => [

                                    'date_effective' => [
                                        'type' => Form::INPUT_WIDGET, 
                                        'widgetClass'=> DateControl::className(),
                                        'format'=>'date',
                                    ], 
                                    
                                    'billing_cycle' => [
                                        'type' => Form::INPUT_WIDGET, 
                                        'widgetClass'=> Select2::className(),
                                        'options' => [
                                            'data' => $billingCycleList,
                                            'options' => ['placeholder' => 'Choose Cycle', 'disabled'=>false],
                                        ],                            
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],                            
                                    ], 
                                    
                                    'network_tags_title' => [
                                        'type' => Form::INPUT_WIDGET, 
                                        'widgetClass'=> Select2::className(),
                                        'options' => [
                                            'data' => $networkTitleList,
                                            'maintainOrder' => true,                                            
                                            'options' => ['placeholder' => '', 'multiple' => false],
                                            'pluginOptions' => [
                                                'tags' => true,
                                                'tokenSeparators' => [',',' '],
                                                'maximumInputLength' => 10  
                                            ],                                              
                                        ],                                                      
                                    ],   
 
                                ]

                            ]);

                        echo '</div>';
                    }                  

                    echo Form::widget([
                        'model' => $model,
                        'form' => $form,
                        'columns' => 3,
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
                            'invoice' => ['type' => Form::INPUT_TEXT, 'options' => [
                                'placeholder' => 'Enter Invoice...', 
                                'maxlength' => 8,
                                'disabled'=>$model->isNewRecord ? false : true]
                            ],
                            'date_issued' => [
                                'type' => Form::INPUT_WIDGET, 
                                'widgetClass'=> DateControl::className(),
                                'format'=>'date',
                            ],
                        ]
                    ]);      
                ?>              
                <?php
                    echo Form::widget([
                        'model' => $model,
                        'form' => $form,
                        'columns' => 3,
                        'attributes' => [
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
                            'assembly_type' => [
                                'type' => Form::INPUT_WIDGET, 
                                'widgetClass'=> Select2::className(),
                                'options' => [
                                    'data' => $assemblyTypeList,
                                    'options' => ['placeholder' => 'Choose Pemasangan'],
                                ],                            
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],                            
                            ], 
                            'date_assembly' => [
                                'type' => Form::INPUT_WIDGET, 
                                'widgetClass'=> DateControl::className(),
                                'format'=>'date',
                            ], 
                        ]
                    ]);      
                ?>                 
            </div>
        </div>

    <?php
    $forms = [
        [
            'label' => '<i class="glyphicon glyphicon-book"></i> ' . Html::encode('OutletDetail'),
            'content' => $this->render('_formOutletDetail', [
                'row' => \yii\helpers\ArrayHelper::toArray($outletDetails),
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
            
            <?= $form->field($model, 'claim')->textInput(['maxlength' => true, 'placeholder' => 'Claim']) ?>
            
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
            '@web/js/outlet.js',
            ['depends' => [yii\web\JqueryAsset::className()]]
        );
?>