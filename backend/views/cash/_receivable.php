<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use backend\models\Lookup;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if ($providerReceivableDetail->totalCount) {
    Pjax::begin(); echo GridView::widget([
        'dataProvider' => $providerReceivableDetail,
        'toolbar'=>[],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'invoice',
                'format'=>'html',
                'value' => function($model){
                    if ($model->invoice)
                    {return Html::a($model->invoice, $model->getUrl());}
                    else
                    {return NULL;}
                },
            ],
             
            [
                'attribute' => 'staff_id',
                'format'=>'html',
                'value' => function($model){
                    if ($model->staff_id)
                    {return Html::a($model->staff->title, $model->staff->getUrl());}
                    else
                    {return NULL;}
                },
            ],
                        
            'month_period',
                        
            [
                'attribute' => 'date_issued',
                'format'=>'date',                
            ],   
            [
                'attribute' => 'payment',
                'format' => ['decimal'],
            ],                         
        ],
        'responsive' => true,
        'hover' => true,
        'condensed' => true,
        'floatHeader' => true,

        'panel' => [
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.'Penerimaan'.' </h3>',
            'type' => 'info',
            'showFooter' => false
        ],
    ]); Pjax::end();     
}
     