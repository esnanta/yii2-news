<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if ($providerAccountPayableDetail->totalCount) {
    Pjax::begin(); echo GridView::widget([
        'dataProvider' => $providerAccountPayableDetail,
        'toolbar'=>[],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
 
            [
                'attribute' => 'staff_id',
                'format'=>'html',
                'value' => function($model){
                    if ($model->accountPayable->staff_id)
                    {return $model->accountPayable->getStaffTitle();}
                    else
                    {return NULL;}
                },
            ], 
                        
            [
                'attribute' => 'account_id',
                'format'=>'html',
                'value' => function($model){
                    if ($model->account->title)
                    {return Html::a($model->account->title, $model->account->getUrl());}
                    else
                    {return NULL;}
                },
            ],                        

            [
                'attribute' => 'commentary',
                'format'=>'html',
                'value' => function($model){
                    if ($model->commentary)
                    {return $model->commentary;}
                    else
                    {return $model->accountPayable->description;}
                },
            ],                          
   
            [
                'attribute' => 'accountPayable.date_issued',
                'format'=>'date',   
                'value' => function($model){
                    if ($model->accountPayable->date_issued)
                    {return $model->accountPayable->date_issued;}
                    else
                    {return NULL;}
                },                
            ],                          
            [
                'attribute' => 'amount',
                'format' => ['decimal'],
            ],                           

        ],
        'responsive' => true,
        'hover' => true,
        'condensed' => true,
        'floatHeader' => true,

        'panel' => [
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.'Akun Pengeluaran'.' </h3>',
            'type' => 'info',
            'showFooter' => false
        ],
    ]); Pjax::end();     
}
     