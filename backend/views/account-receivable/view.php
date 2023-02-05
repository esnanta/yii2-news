<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\AccountReceivable */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Account Receivable', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="account-receivable-view">

    <div class="row">
        <div class="col-sm-8">
            <h2><?= 'Account Receivable' ?></h2>
        </div>
        <div class="col-sm-4" style="margin-top: 15px">
            <?= Html::a('Create', ['create'], ['class' => 'btn btn-primary']) ?>
            <?=             
             Html::a('<i class="glyphicon glyphicon-hand-up"></i> ' . 'PDF', 
                ['pdf', 'id' => $model->id],
                [
                    'class' => 'btn btn-danger',
                    'target' => '_blank',
                    'data-toggle' => 'tooltip',
                    'title' => 'Will open the generated PDF file in a new window'
                ]
            )?>
            
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ])
            ?>
        </div>
    </div>
 
    <?= DetailView::widget([
        'model' => $model,
        'condensed' => false,
        'hover' => true,
        'mode' => Yii::$app->request->get('edit') == 't' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
        'panel' => [
            'heading' => $this->title,
            'type' => DetailView::TYPE_INFO,
        ],
        'attributes' => [
            [
                'columns' => [                   
                    [
                        'attribute'=>'title', 
                        'type'=>DetailView::INPUT_HIDDEN,     
                        'valueColOptions'=>['style'=>'width:30%']
                    ], 
                    [
                        'attribute'=>'staff_id', 
                        'value'=>($model->staff_id!=null) ? $model->staff->title:'',
                        'type'=>DetailView::INPUT_DROPDOWN_LIST, 
                        'options' => ['id' => 'staff_id', 'prompt' => ''],
                        'items' => $dataList,
                        'widgetOptions'=>[
                            'data'=>$dataList,
                        ]                
                    ],                                                        
                ],
            ],   
            
            [
                'columns' => [      
                    [
                        'attribute'=>'invoice', 
                        'type'=>DetailView::INPUT_TEXT,     
                        'valueColOptions'=>['style'=>'width:30%']
                    ],                          
                    [
                        'attribute'=>'date_issued', 
                        'format'=>'date',
                        'type'=>DetailView::INPUT_WIDGET,             
                        'widgetOptions'=>[
                            'class'=>DateControl::classname(),
                            'type'=>DateControl::FORMAT_DATE,  
                        ],     
                        'valueColOptions'=>['style'=>'width:30%']
                    ],                                        
                ],
            ],             
                      
            
            [
                'columns' => [    
                    [
                        'attribute'=>'description', 
                        'format'=>'html',
                        'type'=>DetailView::INPUT_TEXTAREA,
                        'valueColOptions'=>['style'=>'width:30%']
                    ],                     
                    [
                        'attribute'=>'month_period', 
                        'type'=>DetailView::INPUT_HIDDEN,     
                        'valueColOptions'=>['style'=>'width:30%']
                    ],                        
                ],
            ],
            
            [
                'attribute' => 'claim',
                'format' => ['decimal'],
            ],   
            [
                'attribute' => 'payment',
                'format' => ['decimal'],
            ],   
            [
                'attribute' => 'balance',
                'format' => ['decimal'],
            ],               
        ],
        'deleteOptions' => [
            'url' => ['delete', 'id' => $model->id],
        ],
        'enableEditMode' => false,
    ]) ?>        
        


    
    
    <?php
        if($providerAccountReceivableDetail->totalCount){
            $gridColumnAccountReceivableDetail = [
                ['class' => 'yii\grid\SerialColumn'],
                    ['attribute' => 'id', 'visible' => false],
                    [
                        'attribute' => 'account.title',
                        'label' => 'Account'
                    ],
                    //'invoice',
                    [
                        'attribute' => 'amount',
                        'format' => ['decimal'],
                    ],                 
                    'commentary:ntext',
            ];
            echo Gridview::widget([
                'dataProvider' => $providerAccountReceivableDetail,
                'pjax' => true,
                'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-tx-account-receivable-detail']],
                'panel' => [
                    'type' => GridView::TYPE_PRIMARY,
                    'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode('Account Receivable Detail'),
                ],
                'columns' => $gridColumnAccountReceivableDetail
            ]);
        }
    ?>

 
</div>
