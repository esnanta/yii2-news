<div class="form-group" id="add-service-detail">

<p class="help-block">
        <span class="label label-danger">
        <i class="fa fa-exclamation-circle"></i> Hapus outlet yang tidak perlu.
        </span>
    </p>

<?php
use kartik\grid\GridView;
use kartik\builder\TabularForm;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;

$dataProvider = new ArrayDataProvider([
    'allModels' => $row,
    'pagination' => [
        'pageSize' => -1
    ]
]);
echo TabularForm::widget([
    'dataProvider' => $dataProvider,
    'formName' => 'ServiceDetail',
    'checkboxColumn' => false,
    'actionColumn' => false,
    'attributeDefaults' => [
        'type' => TabularForm::INPUT_TEXT,
    ],
    'attributes' => [
        "id" => ['type' => TabularForm::INPUT_HIDDEN, 'columnOptions' => ['hidden'=>true]],
        'service_id' => ['type' => TabularForm::INPUT_HIDDEN, 'columnOptions' => ['hidden'=>true]],
        'outlet_detail_id' => ['type' => TabularForm::INPUT_HIDDEN, 'columnOptions' => ['hidden'=>true]],
        'commentary' => ['type' => TabularForm::INPUT_HIDDEN, 'columnOptions' => ['hidden'=>true]],
            
        'description'=>[
            'type'=>TabularForm::INPUT_STATIC,
            'label'=>'Outlet',
            'columnOptions'=>['hAlign'=>GridView::ALIGN_LEFT, 'width'=>'30%']
        ],

        'device_status' => [
            'label' => 'Status Baru',
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => backend\models\ServiceDetail::getArrayDeviceStatus(),
                'options' => ['placeholder' => 'Jenis'],
            ],
            'columnOptions' => ['width' => '20%']
        ],
        
        'monthly_bill' => ['label' => 'Iuran Baru','type' => TabularForm::INPUT_TEXT],
                
        'service_reason_id' => [
            'label' => 'Kategori',
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\ServiceReason::find()->asArray()->all(), 'id', 'title'),
                'options' => ['placeholder' => 'Kategori'],
            ],
            'columnOptions' => ['width' => '20%']
        ],
        
        'claim' => ['label' => '', 'type' => TabularForm::INPUT_HIDDEN],
        
        'del' => [
            'type' => 'raw',
            'label' => '',
            'value' => function($model, $key) {
                return
                    Html::hiddenInput('Children[' . $key . '][id]', (!empty($model['id'])) ? $model['id'] : "") .
                    Html::a('<i class="glyphicon glyphicon-trash"></i>', '#', ['title' =>  'Delete', 'onClick' => 'delRowServiceDetail(' . $key . '); return false;', 'id' => 'service-detail-del-btn']);
            },
        ],
    ],
    'gridSettings' => [
        'panel' => [
            'heading' => false,
            'type' => GridView::TYPE_DEFAULT,
            'before' => false,
            'footer' => false,
            //'after' => Html::button('<i class="glyphicon glyphicon-plus"></i>' . 'Add Detail', ['type' => 'button', 'class' => 'btn btn-success kv-batch-create', 'onClick' => 'addRowServiceDetail()']),
        ]
    ]
]);
echo  "    </div>\n\n";
?>

