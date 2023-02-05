<div class="form-group" id="add-outlet-detail">
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
    'formName' => 'OutletDetail',
    'checkboxColumn' => false,
    'actionColumn' => false,
    'attributeDefaults' => [
        'type' => TabularForm::INPUT_TEXT,
    ], 
    'attributes' => [
        "id" => ['type' => TabularForm::INPUT_HIDDEN, 'columnOptions' => ['hidden'=>true]],  
        'device_type' => [
            'label' => 'Jenis',
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => backend\models\OutletDetail::getArrayDeviceType(),
                'options' => ['placeholder' => 'Jenis'],
            ],
            'columnOptions' => ['width' => '200px']
        ],

//        'device_status' => [
//            'label' => 'Status',
//            'type' => TabularForm::INPUT_WIDGET,
//            'widgetClass' => \kartik\widgets\Select2::className(),
//            'options' => [
//                'data' => \backend\models\OutletDetail::getArrayDeviceStatus(),
//                'options' => ['placeholder' => 'Choose Status'],
//            ],
//            'columnOptions' => ['width' => '200px']
//        ], 

        'monthly_bill' => ['label' => 'Iuran Bulanan', 'type' => TabularForm::INPUT_TEXT],
        'assembly_cost' => ['label' => 'Biaya Pasang', 'type' => TabularForm::INPUT_TEXT],
        //'description' => ['type' => TabularForm::INPUT_TEXT],
        "verlock" => ['type' => TabularForm::INPUT_HIDDEN, 'columnOptions' => ['hidden'=>true]],
        'del' => [
            'type' => 'raw',
            'label' => '',
            'value' => function($model, $key) {
                return
                    Html::hiddenInput('Children[' . $key . '][id]', (!empty($model['id'])) ? $model['id'] : "") .
                    Html::a('<i class="glyphicon glyphicon-trash"></i>', '#', ['title' =>  'Delete', 'onClick' => 'delRowOutletDetail(' . $key . '); return false;', 'id' => 'outlet-detail-del-btn']);
            },
        ],
    ],
    'gridSettings' => [
        'panel' => [
            'heading' => false,
            'type' => GridView::TYPE_DEFAULT,
            'before' => false,
            'footer' => false,
            'after' => Html::button('<i class="glyphicon glyphicon-plus"></i>' . 'Add Detail', ['type' => 'button', 'class' => 'btn btn-success kv-batch-create', 'onClick' => 'addRowOutletDetail()']),
        ]
    ]
]);
echo  "    </div>\n\n";
?>

