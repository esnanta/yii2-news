<div class="form-group" id="add-account-receivable-detail">
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
    'formName' => 'AccountReceivableDetail',
    'checkboxColumn' => false,
    'actionColumn' => false,
    'attributeDefaults' => [
        'type' => TabularForm::INPUT_TEXT,
    ],
    'attributes' => [
        "id" => ['type' => TabularForm::INPUT_HIDDEN, 'columnOptions' => ['hidden'=>true]],
        'account_id' => [
            'label' => 'Account',
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(\backend\models\Account::find()->orderBy('title')->asArray()->all(), 'id', 'title'),
                'options' => ['placeholder' => 'Choose Account'],
            ],
            'columnOptions' => ['width' => '200px']
        ],
        
        //'invoice' => ['type' => TabularForm::INPUT_TEXT],
        
        'amount' => ['type' => TabularForm::INPUT_TEXT],
        'commentary' => ['type' => TabularForm::INPUT_TEXT],
        'del' => [
            'type' => 'raw',
            'label' => '',
            'value' => function($model, $key) {
                return
                    Html::hiddenInput('Children[' . $key . '][id]', (!empty($model['id'])) ? $model['id'] : "") .
                    Html::a('<i class="glyphicon glyphicon-trash"></i>', '#', ['title' =>  'Delete', 'onClick' => 'delRowAccountReceivableDetail(' . $key . '); return false;', 'id' => 'account-receivable-detail-del-btn']);
            },
        ],
    ],
    'gridSettings' => [
        'panel' => [
            'heading' => false,
            'type' => GridView::TYPE_DEFAULT,
            'before' => false,
            'footer' => false,
            'after' => Html::button('<i class="glyphicon glyphicon-plus"></i>' . 'Add', ['type' => 'button', 'class' => 'btn btn-success kv-batch-create', 'onClick' => 'addRowAccountReceivableDetail()']),
        ]
    ]
]);
echo  "    </div>\n\n";
?>
