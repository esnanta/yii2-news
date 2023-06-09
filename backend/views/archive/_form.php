<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var backend\models\Archive $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="archive-form">

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

            'is_visible' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Is Visible...']],

            'archive_type' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Archive Type...']],

            'archive_category_id' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Archive Category ID...']],

            'size' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Size...']],

            'view_counter' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter View Counter...']],

            'download_counter' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Download Counter...']],

            'created_by' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter created_by...']],

            'updated_by' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter updated_by...']],

            'is_deleted' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Is Deleted...']],

            'deleted_by' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter deleted_by...']],

            'verlock' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Verlock...']],

            'date_issued' => ['type' => Form::INPUT_WIDGET, 'widgetClass' => DateControl::classname(),'options' => ['type' => DateControl::FORMAT_DATE]],

            'created_at' => ['type' => Form::INPUT_WIDGET, 'widgetClass' => DateControl::classname(),'options' => ['type' => DateControl::FORMAT_DATETIME]],

            'updated_at' => ['type' => Form::INPUT_WIDGET, 'widgetClass' => DateControl::classname(),'options' => ['type' => DateControl::FORMAT_DATETIME]],

            'deleted_at' => ['type' => Form::INPUT_WIDGET, 'widgetClass' => DateControl::classname(),'options' => ['type' => DateControl::FORMAT_DATETIME]],

            'description' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => 'Enter Description...','rows' => 6]],

            'title' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Title...', 'maxlength' => 200]],

            'file_name' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter File Name...', 'maxlength' => 200]],

            'archive_url' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Archive Url...', 'maxlength' => 500]],

            'mime_type' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Mime Type...', 'maxlength' => 100]],

        ]

    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );
    ActiveForm::end(); ?>

</div>
