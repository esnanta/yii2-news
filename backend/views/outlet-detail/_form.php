<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var backend\models\OutletDetail $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="outlet-detail-form">

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

            'device_type' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Jenis...']],

            'assembly_cost' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Biaya Pasang...', 'maxlength' => 18]],

            'monthly_bill' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Iuran...', 'maxlength' => 18]],

            'outlet_id' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Outlet...']],

            'customer_id' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Pelanggan...']],

            'device_status' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Status...']],

            'created_at' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Tgl Simpan...']],

            'updated_at' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Tgl Perbaharui...']],

            'created_by' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Disimpan...']],

            'updated_by' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Diperbaharui...']],

            'verlock' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Verlock...', 'maxlength' => 20]],

            'description' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => 'Enter Deskripsi...','rows' => 6]],

        ]

    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );
    ActiveForm::end(); ?>

</div>
