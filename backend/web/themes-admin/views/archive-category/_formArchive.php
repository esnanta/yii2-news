<div class="form-group" id="add-archive">
<?php
use kartik\grid\GridView;
use kartik\builder\TabularForm;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use yii\widgets\Pjax;

$dataProvider = new ArrayDataProvider([
    'allModels' => $row,
    'pagination' => [
        'pageSize' => -1
    ]
]);
echo TabularForm::widget([
    'dataProvider' => $dataProvider,
    'formName' => 'Archive',
    'checkboxColumn' => false,
    'actionColumn' => false,
    'attributeDefaults' => [
        'type' => TabularForm::INPUT_TEXT,
    ],
    'attributes' => [
        "id" => ['type' => TabularForm::INPUT_HIDDEN, 'columnOptions' => ['hidden'=>true]],
        'is_visible' => ['type' => TabularForm::INPUT_TEXT],
        'archive_type' => ['type' => TabularForm::INPUT_TEXT],
        'title' => ['type' => TabularForm::INPUT_TEXT],
        'date_issued' => ['type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\datecontrol\DateControl::classname(),
            'options' => [
                'type' => \kartik\datecontrol\DateControl::FORMAT_DATE,
                'saveFormat' => 'php:Y-m-d',
                'ajaxConversion' => true,
                'options' => [
                    'pluginOptions' => [
                        'placeholder' => 'Choose Date Issued',
                        'autoclose' => true
                    ]
                ],
            ]
        ],
        'file_name' => ['type' => TabularForm::INPUT_TEXT],
        'archive_url' => ['type' => TabularForm::INPUT_TEXT],
        'size' => ['type' => TabularForm::INPUT_TEXT],
        'mime_type' => ['type' => TabularForm::INPUT_TEXT],
        'view_counter' => ['type' => TabularForm::INPUT_TEXT],
        'download_counter' => ['type' => TabularForm::INPUT_TEXT],
        'description' => ['type' => TabularForm::INPUT_TEXTAREA],
        'is_deleted' => ['type' => TabularForm::INPUT_TEXT],
        "verlock" => ['type' => TabularForm::INPUT_HIDDEN, 'columnOptions' => ['hidden'=>true]],
        'del' => [
            'type' => 'raw',
            'label' => '',
            'value' => function($model, $key) {
                return
                    Html::hiddenInput('Children[' . $key . '][id]', (!empty($model['id'])) ? $model['id'] : "") .
                    Html::a('<i class="glyphicon glyphicon-trash"></i>', '#', ['title' =>  'Delete', 'onClick' => 'delRowArchive(' . $key . '); return false;', 'id' => 'archive-del-btn']);
            },
        ],
    ],
    'gridSettings' => [
        'panel' => [
            'heading' => false,
            'type' => GridView::TYPE_DEFAULT,
            'before' => false,
            'footer' => false,
            'after' => Html::button('<i class="glyphicon glyphicon-plus"></i>' . 'Add Tx Archive', ['type' => 'button', 'class' => 'btn btn-success kv-batch-create', 'onClick' => 'addRowArchive()']),
        ]
    ]
]);
echo  "    </div>\n\n";
?>

