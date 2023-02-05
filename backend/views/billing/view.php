<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;
use kartik\select2\Select2;
use yii\widgets\ListView;

/**
 * @var yii\web\View $this
 * @var backend\models\Billing $model
 */

$this->title = 'Tagihan '.$model->title;
$this->params['breadcrumbs'][] = ['label' => 'Billings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$create = Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create','id'=>$model->customer_id], ['class' => 'pull-right detail-button','style'=>'padding:0 5px']);

$formatter = Yii::$app->formatter;

?>


<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab">Invoice Tagihan
            <?= (!empty($model->title)) ? '<span class="label label-primary">' . $model->title . '</span>' : ''; ?></a>
        </li>
    </ul>
    
    <div class="tab-content">
        <div class="tab-pane active" id="tab_1">
            <div class="row">
                <div class="col-md-8">
                    <?= DetailView::widget([
                        'model' => $model,
                        'condensed' => false,
                        'hover' => true,
                        'mode' => Yii::$app->request->get('edit') == 't' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
                        'panel' => [
                            'heading' => '<i class="glyphicon glyphicon-info-sign"></i> Billing',
                            'type' => DetailView::TYPE_PRIMARY,
                        ],
                        'attributes' => [
                            [
                                'columns' => [
                                    [
                                        'attribute'=>'customer_id', 
                                        'value'=>($model->customer_id!=null) ? Html::a($model->customer->title, $model->customer->getUrl()):'',
                                        'format'=>'html',
                                        'type'=>DetailView::INPUT_HIDDEN,  
                                        'valueColOptions'=>['style'=>'width:30%']
                                    ],                              
                                    [
                                        'attribute'=>'billing_type', 
                                        'format'=>'html',
                                        'value'=>($model->billing_type!=null) ? $model->getOneBillingType($model->billing_type):'',
                                        'type'=> (Yii::$app->user->identity->isAdmin) ? DetailView::INPUT_SELECT2 : DetailView::INPUT_HIDDEN, 
                                        'options' => ['id' => 'billing_type', 'prompt' => ''],
                                        'items' => $billingTypeList,
                                        'widgetOptions'=>[
                                            'class'=> Select2::className(),
                                            'data'=>$billingTypeList,
                                        ], 
                                        'valueColOptions'=>['style'=>'width:30%']                               
                                    ], 
                                ],
                            ],                      
                            [
                                'columns' => [
                                    [
                                        'attribute'=>'area_id', 
                                        'format'=>'html',
                                        'value'=>($model->area_id!=null) ? $model->area->title:'',
                                        'type'=> (Yii::$app->user->identity->isAdmin) ? DetailView::INPUT_SELECT2 : DetailView::INPUT_HIDDEN, 
                                        'options' => ['id' => 'area_id', 'prompt' => ''],
                                        'items' => $areaList,
                                        'widgetOptions'=>[
                                            'class'=> Select2::className(),
                                            'data'=>$areaList,
                                        ], 
                                        'valueColOptions'=>['style'=>'width:30%']                               
                                    ],                                                        
                                    [
                                        'attribute'=>'payment_status', 
                                        'format'=>'html',
                                        'value'=>($model->payment_status!=null) ? $model->getOnePaymentStatus($model->payment_status) : '',
                                        'type'=> (Yii::$app->user->identity->isAdmin) ? DetailView::INPUT_SELECT2 : DetailView::INPUT_HIDDEN, 
                                        'options' => ['id' => 'payment_status', 'prompt' => ''],
                                        'items' => $paymentStatusList,
                                        'widgetOptions'=>[
                                            'class'=> Select2::className(),
                                            'data'=>$paymentStatusList,
                                        ], 
                                        'valueColOptions'=>['style'=>'width:30%']                                 
                                    ],                             
                                ],
                            ],

                            [
                                'columns' => [   
                                    [
                                        'attribute'=>'invoice', 
                                        'title'=>'Validasi',
                                        'value'=>($model->invoice!=null) ? Html::a($model->invoice, $model->getInvoiceUrl()):'',
                                        'format'=>'html',
                                        'type'=>DetailView::INPUT_TEXT, 
                                        'valueColOptions'=>['style'=>'width:30%'],
                                        'displayOnly'=>true
                                    ],                               
        //                            [
        //                                'attribute'=>'title', 
        //                                'format'=>'html',
        //                                'type'=>DetailView::INPUT_TEXT,    
        //                                'valueColOptions'=>['style'=>'width:30%'],
        //                                'displayOnly'=>true
        //                            ],  
                                    [
                                        'attribute'=>'month_period', 
                                        'format'=>'html',
                                        'type'=>DetailView::INPUT_TEXT, 
                                        'valueColOptions'=>['style'=>'width:30%;'],
                                        'displayOnly'=>true
                                    ],  
                                ],
                            ], 

                            [
                                'columns' => [
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
                                    [
                                        'attribute'=>'date_due', 
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
                                        'attribute' => 'amount',
                                        'format' => ['decimal'],  
                                        'type'=>DetailView::INPUT_TEXT, 
                                        'valueColOptions'=>['style'=>'width:30%'],
                                        'displayOnly'=>(Yii::$app->user->identity->isAdmin) ? false:true,
                                    ],                                                      
                                ],
                            ],                     


                            [
                                'group'=>true,
                                'rowOptions'=>['class'=>'default']
                            ],  


                            [
                                'columns' => [
                                    [
                                        'attribute'=>'created_at', 
                                        'format'=>'date',
                                        'type'=>DetailView::INPUT_HIDDEN,      
                                        'valueColOptions'=>['style'=>'width:30%']
                                    ],  
                                    [
                                        'attribute'=>'updated_at', 
                                        'format'=>'date',
                                        'type'=>DetailView::INPUT_HIDDEN, 
                                        'valueColOptions'=>['style'=>'width:30%']
                                    ],                                
                                ],
                            ],
                            [
                                'columns' => [
                                    [
                                        'attribute'=>'created_by',
                                        'value'=>($model->created_by!=null) ? \backend\models\User::getName($model->created_by):'',
                                        'type'=>DetailView::INPUT_HIDDEN,
                                        'valueColOptions'=>['style'=>'width:30%']
                                    ],
                                    [
                                        'attribute'=>'updated_by',
                                        'value'=>($model->updated_by!=null) ? \backend\models\User::getName($model->updated_by):'',
                                        'type'=>DetailView::INPUT_HIDDEN,
                                        'valueColOptions'=>['style'=>'width:30%']
                                    ],                                
                                ],
                            ],                    
                        ],
                        'deleteOptions' => [
                            'url' => ['delete', 'id' => $model->id],
                        ],
                        'enableEditMode' => Yii::$app->user->can('update-billing'),
                    ]) ?>                        
                </div>
                <div class="col-md-4">
                    <?=$this->render('/customer/side_view',[
                        'customer'=>null,
                        'enrolment'=>$enrolment,
                    ])
                    ?>                         
                </div>
            </div>
            
            
            <?php if(!empty($receivable)){ ?>
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title"><i class="glyphicon glyphicon-info-sign"></i> Info Pembayaran</h3>
                        <span class="pull pull-right"><b>Invoice <?= Html::a($receivable->invoice, $receivable->getUrl()); ?></b></span>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">

                        <div class="row ">
                            <div class="col-sm-4">
                                <table class="table table-striped">
                                    <tr>
                                        <td><?=$model->customer->getAttributeLabel('title');?></td>
                                        <td><strong>[<?= $enrolment->title; ?>] <?= $model->customer->title; ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td><?= $model->customer->getAttributeLabel('phone_number'); ?></td>
                                        <td><?= $model->customer->phone_number; ?></td>
                                    </tr>
                                    <tr>
                                        <td><?=$enrolment->getAttributeLabel('billing_cycle');?></td>
                                        <td>JTO <?= $enrolment->billing_cycle; ?> / bulan</td>
                                    </tr>                                
                                </table>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 ">

                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 ">
                                <table class="table table-striped">                               
                                    <tr>
                                        <td><?= $model->customer->getAttributeLabel('address'); ?></td>
                                    </tr>
                                    <tr>
                                        <td><?= $model->customer->address; ?></td>
                                    </tr>                                
                                </table>                            
                            </div>
                        </div>                    

                        <br>

                        <table class="table table-striped">

                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Periode</th>
                                <th>Tgl JTO</th>
                                <th>Telat</th>
                                <th>Akurasi</th>
                                <th>Jenis</th>                            
                                <th>Tagihan</th>
                                <th>Denda</th>
                                <th>Total</th>
                            </tr>

                            <?=
                            ListView::widget([
                                'dataProvider' => $providerReceivableDetail,
                                'summary' => '',
                                'itemView' => '_view_grid',
                            ]);
                            ?> 

                        </table>

                        <br>
                        <br>

                        <div class="row">
                            <!-- accepted payments column -->
                            <div class="col-xs-8">
                                <b>Invoice #<?= $receivable->invoice; ?></b><br>
                                <br>
                                <b>Date:</b> <?= Yii::$app->formatter->format($receivable->date_issued, 'date'); ?><br>
                                <b>Issued By:</b> <?= $receivable->staff->title; ?><br>
                                
                                <br>
                                <br>
                                
                                <b><?= $receivable->getAttributeLabel('created_by')?> : </b> <?=\backend\models\User::getName($receivable->created_by);?><br>
                                <b><?= $receivable->getAttributeLabel('created_at')?> : </b> <?=Yii::$app->formatter->format($receivable->created_at,'date');?><br>
                                
                                
                            </div>
                            <!-- /.col -->
                            <div class="col-xs-4">
                                <p class="lead">Summary</p>

                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <th style="width:50%">Tagihan</th>
                                            <td><?= $formatter->asDecimal($receivable->claim); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Tambahan</th>
                                            <td><?= $formatter->asDecimal($receivable->surcharge); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Total:</th>
                                            <td><?= $formatter->asDecimal($receivable->total); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Diskon</th>
                                            <td><?= $formatter->asDecimal($receivable->discount); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Bayar</th>
                                            <td><?= $formatter->asDecimal($receivable->payment); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Balance</th>
                                            <td><?= $formatter->asDecimal($receivable->balance); ?></td>
                                        </tr>                    
                                    </table>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>                    

                    </div>
                </div>            
            <?php 
            }else{
                echo Html::a('<i class="glyphicon glyphicon-shopping-cart"></i> ' . 'Proses Bayar',
                    ['/receivable/create','id'=>$model->customer_id],
                    [
                        'class' => 'btn btn-primary pull-right',
                        'data-toggle' => 'tooltip',
                        'title' => 'Proses Bayar'
                    ]
                );                
            }
            ;?>
        </div>
    </div>
</div>
