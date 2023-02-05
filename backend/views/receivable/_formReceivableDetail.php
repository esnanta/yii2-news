<div class="form-group" id="add-receivable-detail">
    
    <p class="help-block">
        <span class="label label-danger">
        <i class="fa fa-exclamation-circle"></i> Hapus tagihan yang tidak perlu.
        </span>
    </p>
    
<?php
use kartik\grid\GridView;
use kartik\builder\TabularForm;
use kartik\datecontrol\DateControl;
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
    'formName' => 'ReceivableDetail',
    'checkboxColumn' => false,
    'actionColumn' => false,
    'attributeDefaults' => [
        'type' => TabularForm::INPUT_TEXT,
    ],
    'attributes' => [
        "id" => ['type' => TabularForm::INPUT_HIDDEN, 'columnOptions' => ['hidden'=>true]],
        'billing_id' => ['type' => TabularForm::INPUT_HIDDEN, 'columnOptions' => ['hidden'=>true]],
        
//        'billing_id' => [
//            'label' => 'Tx billing',
//            'type' => TabularForm::INPUT_WIDGET,
//            'widgetClass' => \kartik\widgets\Select2::className(),
//            'options' => [
//                'data' => \yii\helpers\ArrayHelper::map(\backend\models\Billing::find()->orderBy('title')->asArray()->all(), 'id', 'title'),
//                'options' => ['placeholder' => 'Choose Billing', 'disabled'=>false],
//            ],
//            'columnOptions' => ['width' => '200px']
//        ],
            
        
        'description'=>[
            'type'=>TabularForm::INPUT_STATIC, 
            'label'=>'Tagihan',
            'columnOptions'=>['hAlign'=>GridView::ALIGN_LEFT, 'width'=>'150px']
        ],                    
                    
        'date_due' => [
            'type' => TabularForm::INPUT_WIDGET, 
            'widgetClass'=> DateControl::className(),
            'format'=>'date',
            'options' => [
                'disabled'=>true
            ]
        ],        
        //'overdue' => ['type' => TabularForm::INPUT_TEXT],
        'claim' => ['type' => TabularForm::INPUT_TEXT],
        'penalty' => ['type' => TabularForm::INPUT_TEXT],
        'total' => [
            'type' => TabularForm::INPUT_TEXT,
            'label'=>'Total',
        ],
        'del' => [
            'type' => 'raw',
            'label' => '',
            'value' => function($model, $key) {
                return
                    Html::hiddenInput('Children[' . $key . '][id]', (!empty($model['id'])) ? $model['id'] : "") .
                    Html::a('<i class="glyphicon glyphicon-trash"></i>', '#', ['title' =>  'Delete', 'onClick' => 'delRowReceivableDetail(' . $key . '); return false;', 'id' => 'receivable-detail-del-btn']);
            },
        ],
    ],
    'gridSettings' => [
        'panel' => [
            'heading' => false,
            'type' => GridView::TYPE_DEFAULT,
            'before' => false,
            'footer' => false,
            //'after' => Html::button('<i class="glyphicon glyphicon-plus"></i>' . 'Add Tx Receivable Detail', ['type' => 'button', 'class' => 'btn btn-success kv-batch-create', 'onClick' => 'addRowReceivableDetail()']),
        ]
    ]
]);
echo  "    </div>\n\n";
?>

