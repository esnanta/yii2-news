<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/**
 * @var yii\web\View $this
 * @var backend\models\Account $model
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Accounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$create = Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'], ['class' => 'pull-right detail-button','style'=>'padding:0 5px']);
//$update = '<button type="button" class="kv-action-btn kv-btn-update pull-right detail-button" title="" data-toggle="tooltip" data-container="body" data-original-title="Update"><i class="glyphicon glyphicon-pencil"></i></button>';
//$view = '<button type="button" class="kv-action-btn kv-btn-view pull-right detail-button" title="" data-toggle="tooltip" data-container="body" data-original-title="View"><i class="glyphicon glyphicon-eye-open"></i></button>';
//$delete = Html::a('<i class="glyphicon glyphicon-trash"></i>', ['delete','id'=>$model->id], ['data-method' => 'POST', 'data-confirm'=>'Are you sure you want to delete this item?','class' => 'pull-right detail-button','style'=>'padding:0 5px']);

?>
<div class="account-view">

    <?= DetailView::widget([
        'model' => $model,
        'condensed' => false,
        'hover' => true,
        'mode' => Yii::$app->request->get('edit') == 't' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
        'panel' => [
            'heading' => $this->title.$create,
            'type' => DetailView::TYPE_INFO,         
        ],
        'attributes' => [
            
            [
                'attribute'=>'account_type_id', 
                'value'=>($model->account_type_id!=null) ? $model->accountType->title:'',
                'type'=>DetailView::INPUT_DROPDOWN_LIST, 
                'options' => ['id' => 'account_type_id', 'prompt' => ''],
                'items' => $dataList,
                'widgetOptions'=>[
                    'data'=>$dataList,
                ]                
            ],             
            
            'title',
            'token',
            [
                'attribute'=>'description', 
                'format'=>'html',
                'type'=>DetailView::INPUT_TEXTAREA,                    
            ],    
            [
                'attribute'=>'created_at', 
                'format'=>'date',
                'type'=>DetailView::INPUT_HIDDEN,                    
            ],  
            [
                'attribute'=>'updated_at', 
                'format'=>'date',
                'type'=>DetailView::INPUT_HIDDEN,                    
            ],              
            [
                'attribute'=>'created_by',
                'value'=>($model->created_by!=null) ? \backend\models\User::getName($model->created_by):'',
                'type'=>DetailView::INPUT_HIDDEN,
            ],
            [
                'attribute'=>'updated_by',
                'value'=>($model->updated_by!=null) ? \backend\models\User::getName($model->updated_by):'',
                'type'=>DetailView::INPUT_HIDDEN,
            ], 
        ],
        'deleteOptions' => [
            'url' => ['delete', 'id' => $model->id],
        ],
        'enableEditMode' => Yii::$app->user->can('update-account'),
    ]) ?>

</div>
