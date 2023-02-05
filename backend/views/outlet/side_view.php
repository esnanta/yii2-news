<?php
use yii\helpers\Html;
use kartik\grid\GridView;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 //$customer_id PARSED FROM RANDERING VIEW
$create = Html::a('<i class="glyphicon glyphicon-plus"></i>', ['/outlet/create','id'=>$customer_id], ['class' => 'pull-right detail-button','style'=>'padding:0 5px']);


?>
<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title"><i class="glyphicon glyphicon-blackboard"></i> Data Outlet</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body no-padding">
        <?php

            if ($providerOutletDetail->totalCount) { 
                echo GridView::widget([
                    'dataProvider' => $providerOutletDetail,
                    //'summary' => '',
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute'=>'monthly_bill', 
                            'format'=>'html',
                            'vAlign'=>'middle',
                            'value'=>function ($model, $key, $index, $widget) { 
                                return ($model->id!=null) ? Yii::$app->formatter->asDecimal($model->monthly_bill):'';
                            },
                        ],
                        [
                            'attribute'=>'device_type', 
                            'format'=>'html',
                            'vAlign'=>'middle',
                            'width'=>'80px',
                            'value'=>function ($model, $key, $index, $widget) { 
                                return ($model->device_type!=null) ? $model->getOneDeviceType($model->device_type):'';
                            },
                        ], 
                        [
                            'attribute'=>'device_status', 
                            'format'=>'html',
                            'vAlign'=>'middle',
                            'width'=>'80px',
                            'value'=>function ($model, $key, $index, $widget) { 
                                return ($model->device_status!=null) ? $model->getOneDeviceStatus($model->device_status):'';
                            },
                        ],   
                        [
                            'attribute'=>'enrolment_type', 
                            'format'=>'html',
                            'vAlign'=>'middle',
                            'width'=>'80px',
                            'value'=>function ($model, $key, $index, $widget) { 
                                return ($model->enrolment_type!=null) ? $model->getOneEnrolmentType($model->enrolment_type):'';
                            },
                        ], 
                        [
                            'label'=>'', 
                            'format'=>'html',
                            'vAlign'=>'middle',
                            'width'=>'80px',
                            'value'=>function ($model, $key, $index, $widget) { 
                                return '<span class="pull pull-right">'.Html::a('<i class="glyphicon glyphicon-eye-open"></i>', $model->outlet->getUrl()).'</span>';
                            },
                        ], 
                    ]
                ]);
            }

            else{

                // echo Html::a('<i class="glyphicon glyphicon-plus"></i> ' . 'Create Outlet',  
                //     ['/outlet/create','id'=>$model->id],
                //     [
                //         'class' => 'btn btn-primary',
                //         'data-toggle' => 'tooltip',
                //         'title' => 'Create Outlet'
                //     ]
                // ); 

            }
        ?>
    </div>
</div>
