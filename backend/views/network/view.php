<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;
use kartik\grid\GridView;
/**
 * @var yii\web\View $this
 * @var backend\models\Network $model
 */

$this->title = 'Network '.$model->title;
$this->params['breadcrumbs'][] = ['label' => 'Networks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$create = Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'], ['class' => 'pull-right detail-button','style'=>'padding:0 5px']);
?>
<div class="network-view">

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
            'title',
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
        'enableEditMode' => Yii::$app->user->can('update-network'),
    ]) ?>

    
<?php
    if ($providerEnrolment->totalCount) {
        Pjax::begin(); echo GridView::widget([
            'dataProvider' => $providerEnrolment,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'title',
                [
                    'attribute'=>'customer_id', 
                    'format'=>'html',
                    'vAlign'=>'middle',
                    'value'=>function ($model, $key, $index, $widget) { 
                        return ($model->customer_id!=null) ? Html::a($model->customer->title, $model->customer->getUrl()):'';
                    },
                ],            

                [
                    'attribute'=>'billing_cycle', 
                    'format'=>'html',
                    'vAlign'=>'middle',
                    'value'=>function ($model, $key, $index, $widget) { 
                        return ($model->billing_cycle!=null) ? $model->billing_cycle:'';
                    },
                ],                                 
                                                

            ],
            'responsive' => true,
            'hover' => true,
            'condensed' => true,
            'floatHeader' => true,

            'panel' => [
                'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> Pelanggan Tv </h3>',
                'type' => 'info',
                //'before' => Html::a('<i class="glyphicon glyphicon-plus"></i> Add', ['create'], ['class' => 'btn btn-success']),
                //'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
                'showFooter' => false
            ],
        ]); Pjax::end();       
    }   
        
?>    
    
</div>
