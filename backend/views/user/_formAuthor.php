<div class="form-group" id="add-author">
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
    'formName' => 'Author',
    'checkboxColumn' => false,
    'actionColumn' => false,
    'attributeDefaults' => [
        'type' => TabularForm::INPUT_TEXT,
    ],
    'attributes' => [
        "id" => ['type' => TabularForm::INPUT_HIDDEN, 'columnOptions' => ['hidden'=>true]],
        'title' => ['type' => TabularForm::INPUT_TEXT],
        'phone_number' => ['type' => TabularForm::INPUT_TEXT],
        'email' => ['type' => TabularForm::INPUT_TEXT],
        'google_plus' => ['type' => TabularForm::INPUT_TEXT],
        'instagram' => ['type' => TabularForm::INPUT_TEXT],
        'facebook' => ['type' => TabularForm::INPUT_TEXT],
        'twitter' => ['type' => TabularForm::INPUT_TEXT],
        'file_name' => ['type' => TabularForm::INPUT_TEXT],
        'address' => ['type' => TabularForm::INPUT_TEXTAREA],
        'description' => ['type' => TabularForm::INPUT_TEXTAREA],
        'is_deleted' => ['type' => TabularForm::INPUT_TEXT],
        "verlock" => ['type' => TabularForm::INPUT_HIDDEN, 'columnOptions' => ['hidden'=>true]],
        'del' => [
            'type' => 'raw',
            'label' => '',
            'value' => function($model, $key) {
                return
                    Html::hiddenInput('Children[' . $key . '][id]', (!empty($model['id'])) ? $model['id'] : "") .
                    Html::a('<i class="glyphicon glyphicon-trash"></i>', '#', ['title' =>  'Delete', 'onClick' => 'delRowAuthor(' . $key . '); return false;', 'id' => 'author-del-btn']);
            },
        ],
    ],
    'gridSettings' => [
        'panel' => [
            'heading' => false,
            'type' => GridView::TYPE_DEFAULT,
            'before' => false,
            'footer' => false,
            'after' => Html::button('<i class="glyphicon glyphicon-plus"></i>' . 'Add Tx Author', ['type' => 'button', 'class' => 'btn btn-success kv-batch-create', 'onClick' => 'addRowAuthor()']),
        ]
    ]
]);
echo  "    </div>\n\n";
?>

