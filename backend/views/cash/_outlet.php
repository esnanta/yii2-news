<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if ($providerOutletDetail->totalCount) {
    Pjax::begin(); echo GridView::widget([
        'dataProvider' => $providerOutletDetail,
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
                'attribute' => 'customer_id',
                'format'=>'html',
                'value' => function($model){
                    if ($model->customer)
                    {return Html::a('['.$model->enrolment->title.'] '.$model->customer->title, $model->customer->getUrl());}
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
                'attribute' => 'claim',
                'format' => ['decimal'],
            ], 
        ],
        'responsive' => true,
        'hover' => true,
        'condensed' => true,
        'floatHeader' => true,
              
        'panel' => [
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.'Outlet Detail'.' </h3>',
            'type' => 'info',
            'after'=>'',
            'showFooter' => false
        ],
    ]); Pjax::end();     
}
     