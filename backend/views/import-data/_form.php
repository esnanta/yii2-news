<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\ImportData */
/* @var $form yii\widgets\ActiveForm */

\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos'=> \yii\web\View::POS_END, 
    'viewParams' => [
        'class' => 'ImportAttribute', 
        'relID' => 'import-attribute', 
        'value' => \yii\helpers\Json::encode($model->importAttributes),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);
?>

<div class="import-data-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <div class="row">
        <div class="col-md-6">
            <?= 
            
                $form->field($model, 'modul_type')->widget(Select2::classname(), [
                    'data' => $dataList,
                    'options' => ['placeholder' => 'Select a modul ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);             
            
            ?>

         
            
            <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'placeholder' => 'Title']) ?>

            <?= $form->field($model, 'description')->textarea(['rows' => 2]) ?>
            
            <div class="row">
                <div class="col-md-6"><?= $form->field($model, 'row_start')->textInput(['placeholder' => 'Row Start']) ?></div>
                <div class="col-md-6"><?= $form->field($model, 'row_end')->textInput(['placeholder' => 'Row End']) ?></div>
            </div>            
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'asset')->widget(FileInput::classname())?>  
        </div>
    </div>


        
    
    <?php
    $forms = [
        [
            'label' => '<i class="glyphicon glyphicon-book"></i> ' . Html::encode('ImportAttribute'),
            'content' => $this->render('_formImportAttribute', [
                'row' => \yii\helpers\ArrayHelper::toArray($model->importAttributes),
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
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Cancel'), Yii::$app->request->referrer , ['class'=> 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
