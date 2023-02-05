<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var backend\models\ServiceDetail $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="service-detail-form">

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

            'service_reason_id' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Alasan...']],

            'device_status' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Status...']],

            'claim' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Tagihan...', 'maxlength' => 18]],

            'service_id' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Layanan...']],

            'outlet_detail_id' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Outlet...']],

            'created_at' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Tgl Simpan...']],

            'updated_at' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Tgl Perbaharui...']],

            'created_by' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Disimpan...']],

            'updated_by' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Diperbaharui...']],

            'verlock' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Verlock...']],

            'month_period' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Periode...', 'maxlength' => 6]],

            'commentary' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => 'Enter Deskripsi...','rows' => 6]],

        ]

    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );
    ActiveForm::end(); ?>

</div>
