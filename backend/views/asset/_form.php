<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\select2\Select2;
use kartik\widgets\FileInput;
/**
 * @var yii\web\View $this
 * @var common\models\Asset $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="asset-form">

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL]); ?>
    <div class="row">
        <div class="col-md-4">
            <?php
                echo $form->field($model, 'asset')->widget(FileInput::class, [
                    'pluginOptions' => ['previewFileType' => 'any','showUpload' => false,]
                ]);
            ?>
        </div>
        <div class="col-md-8">
            <?php 
                echo Form::widget([
                    'model' => $model,
                    'form' => $form,
                    'columns' => 1,
                    'attributes' => [
                        'date_issued' => [
                            'type' => Form::INPUT_WIDGET,
                            'widgetClass' => DateControl::class,
                            'options' => ['type' => DateControl::FORMAT_DATE]],
                        'title' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => '', 'maxlength' => 200]],
                        'asset_category_id' => [
                            'type' => Form::INPUT_WIDGET,
                            'widgetClass' => Select2::class,
                            'options' => [
                                'data' => $assetCategoryList,
                                'options' => ['placeholder' => '', 'disabled' => false],
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ],
                        'asset_type' => [
                            'type' => Form::INPUT_WIDGET,
                            'widgetClass' => Select2::class,
                            'options' => [
                                'data' => $assetTypeList,
                                'options' => ['placeholder' => '', 'disabled' => false],
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ],
                        'is_visible' => [
                            'type' => Form::INPUT_WIDGET,
                            'widgetClass' => Select2::class,
                            'options' => [
                                'data' => $isVisibleList,
                                'options' => ['placeholder' => '', 'disabled' => false],
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ],
                    ]
                ]);

//                echo $form->field($model, 'description')->widget(CKEditor::class, [
//                    'editorOptions' => [
//                        'preset' => 'basic', // basic, standard, full
//                        'inline' => false,
//                    ],
//                ]);
            ?>
        </div>
    </div>

    <?php
        echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
        );
    ?>

    <?php ActiveForm::end(); ?>  

</div>
