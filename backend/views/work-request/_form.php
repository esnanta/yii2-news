<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\WorkRequest */
/* @var $form yii\widgets\ActiveForm */

\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos'=> \yii\web\View::POS_END,
    'viewParams' => [
        'class' => 'WorkRequestDetail',
        'relID' => 'work-request-detail',
        'value' => \yii\helpers\Json::encode($model->workRequestDetails),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);
?>

<div class="work-request-form">

    <?php $form = ActiveForm::begin([
        'type' => ActiveForm::TYPE_VERTICAL,
        'enableAjaxValidation' => false,
        ]);
    ?>

    <?= $form->errorSummary($model); ?>
    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>
    <?= $form->field($model, 'customer_id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <div class="row">
        <div class="col-md-12">
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
                                'options' => ['placeholder' => 'Choose Staff', 'disabled'=>false],
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ],
                        'invoice' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => '', 'maxlength' => 20]],
                        'date_issued' => [
                            'type' => Form::INPUT_WIDGET,
                            'widgetClass'=> DateControl::className(),
                            'format'=>'date',
                        ],
                        'customer_title' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => '', 'maxlength' => true]],
                        'phone_number' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => '', 'maxlength' => true]],
                        'address' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => '.', 'maxlength' => true]],
                    ]
                ]);
            ?>
        </div>
    </div>


    <?php
    $forms = [
        [
            'label' => '<i class="glyphicon glyphicon-book"></i> ' . Html::encode('WorkRequestDetail'),
            'content' => $this->render('_formWorkRequestDetail', [
                'row' => \yii\helpers\ArrayHelper::toArray($workRequestDetails),
                'customer_id' => $model->customer_id
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

        </div>
        <div class="col-md-5">
            <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
