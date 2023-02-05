<?php

use yii\helpers\Html;
use yii\widgets\ListView;

use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;
use kartik\widgets\Select2;

use backend\models\Enrolment;
use backend\models\ReceivableDetail;

/**
 * @var yii\web\View $this
 * @var backend\models\Customer $model
 */

$this->title = 'Customer '.$model->title;
$this->params['breadcrumbs'][] = ['label' => 'Customers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$create = Html::a('<i class="glyphicon glyphicon-plus"></i>', ['/site/new-customer'], ['class' => 'pull-right detail-button','style'=>'padding:0 5px']);

$formatter              = Yii::$app->formatter;
?>
<div class="customer-view">

    <!-- Custom Tabs -->
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_1" data-toggle="tab">Customer
                    <?= (!empty($model->title)) ? '<span class="label label-primary">'.$model->title.'</span>':'';?></a>
            </li>
            <div style="padding:5px">
                <?php if(!empty($enrolment)){ ?>
                    
                    <div class="btn-group pull-right">
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                Options <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <?php if($enrolment->enrolment_type==Enrolment::ENROLMENT_TYPE_ANALOG){ ?>
                                    <li>
                                        <?php
                                        echo Html::a(
                                                '<span class=""><i class="fa fa-plus"></i> Validasi</span>',
                                                Yii::$app->getUrlManager()->createUrl([
                                                    'validity-detail/create',
                                                    'id' => $model->id,
                                                    'title' => $model->title]),
                                                [
                                                    'role' => 'menuitem',
                                                    'tabindex' => '-1',
                                                ]
                                        );
                                        ?>
                                    </li>
                                <?php } ?>
                                
                                <li>
                                    <?=
                                    Html::a(
                                            '<span class=""><i class="fa fa-plus"></i> Billing</span>',
                                            Yii::$app->getUrlManager()->createUrl([
                                                'billing/create',
                                                'id' => $model->id,
                                                'title' => $model->title]),
                                            [
                                                'role' => 'menuitem',
                                                'tabindex' => '-1',
                                            ]
                                    );
                                    ?>
                                </li>
                                <li class="divider"></li>

                                <li>
                                    <?=
                                    Html::a(
                                            '<span class=""><i class="fa fa-plus"></i> Outlet</span>',
                                            Yii::$app->getUrlManager()->createUrl([
                                                'outlet/create',
                                                'id' => $model->id,
                                                'title' => $model->title]),
                                            [
                                                'role' => 'menuitem',
                                                'tabindex' => '-1',
                                            ]
                                    );
                                    ?>
                                </li>

                                <li>
                                    <?php
                                    if ($enrolment->enrolment_type==\backend\models\Enrolment::ENROLMENT_TYPE_ANALOG){
                                        echo Html::a(
                                                '<span class=""><i class="fa fa-plus"></i> Service</span>',
                                                Yii::$app->getUrlManager()->createUrl([
                                                    'service/create',
                                                    'id' => $enrolment->customer_id,
                                                    'type' => backend\models\Service::SERVICE_TYPE_GENERAL,
                                                    'title' => $enrolment->title]),
                                                [
                                                    'role' => 'menuitem',
                                                    'tabindex' => '-1',
                                                ]
                                        );
                                    }
                                    else if($enrolment->enrolment_type==\backend\models\Enrolment::ENROLMENT_TYPE_DIGITAL){
                                        echo Html::a(
                                            '<span class=""><i class="fa fa-plus"></i> Service</span>',
                                            Yii::$app->getUrlManager()->createUrl([
                                                'service/create',
                                                'id' => $enrolment->customer_id,
                                                'type' => backend\models\Service::SERVICE_TYPE_EXTEND_DIGITAL,
                                                'title' => $enrolment->title]),
                                            [
                                                'role' => 'menuitem',
                                                'tabindex' => '-1',
                                            ]
                                        );
                                    }
                                    ?>
                                </li>

                                <li>
                                    <?=
                                    Html::a(
                                            '<span class=""><i class="fa fa-plus"></i> Pembayaran</span>',
                                            Yii::$app->getUrlManager()->createUrl([
                                                'receivable/create',
                                                'id' => $model->id,
                                                'title' => $model->title]),
                                            [
                                                'role' => 'menuitem',
                                                'tabindex' => '-1',
                                            ]
                                    );
                                    ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                
                <?php }
                else{
                    echo '<span class="label label-warning pull-right"><i class="fa fa-warning"></i> Belum Berlangganan</span>';       
                }
            ?>
            </div>
        </ul>
        <div class="tab-content">

            <!-- /////////////////////////////////////////////////////////// -->
            <!-- /////////////////////////////////////////////////////////// -->
            <!-- /////////////////////////////////////////////////////////// -->

            <div class="tab-pane active" id="tab_1">

                <div class="row">
                    <div class="col-md-8">
                        <?= DetailView::widget([
                            'model' => $model,
                            'condensed' => false,
                            'hover' => true,
                            'mode' => Yii::$app->request->get('edit') == 't' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
                            'panel' => [
                                'heading' => '<i class="glyphicon glyphicon-user"></i> Biodata '.$create,
                                'type' => DetailView::TYPE_PRIMARY,
                            ],
                    
                            'attributes' => [
                                [
                                    'group'=>true,
                                    'label'=>'',
                                    'rowOptions'=>['class'=>'default']
                                ],                        
                                
                                [
                                    'columns' => [
                                        [
                                            'attribute'=>'title', 
                                            'value'=>($model->title!=null) ? $model->title:'',
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
                                    'attribute'=>'gender_status', 
                                    'value'=>($model->gender_status!=null) ? $model->getOneModule($model->gender_status):'',
                                    'format'=>'html',
                                    'type'=>DetailView::INPUT_SELECT2, 
                                    'options' => ['id' => 'gender_status', 'prompt' => '', 'disabled'=>false],
                                    'items' => $genderList,
                                    'widgetOptions'=>[
                                        'class'=> Select2::className(),
                                        'data'=>$genderList,
                                    ],
                                    'valueColOptions'=>['style'=>'width:100%']
                                ],  
                                [
                                    'attribute'=>'identity_number', 
                                    'value'=>($model->identity_number!=null) ? $model->identity_number:'',
                                    'valueColOptions'=>['style'=>'width:30%']
                                ],     
                                [
                                    'attribute'=>'phone_number', 
                                    'value'=>($model->phone_number!=null) ? $model->phone_number:'',
                                    'valueColOptions'=>['style'=>'width:30%']
                                ],              
                                [
                                    'attribute'=>'address', 
                                    'type'=>DetailView::INPUT_TEXTAREA,  
                                    'value'=>($model->address!=null) ? $model->address:'',
                                    'valueColOptions'=>['style'=>'width:100%']
                                ], 
                                [
                                    'attribute'=>'area_id', 
                                    'value'=>($model->area_id!=null) ? $model->area->title:'',
                                    'type'=>DetailView::INPUT_SELECT2,   
                                    'options' => ['id' => 'area_id', 'prompt' => '', 'disabled'=>false],
                                    'items' => $areaList,
                                    'widgetOptions'=>[
                                        'class'=> Select2::className(),
                                        'data'=>$areaList,
                                    ],
                                    'valueColOptions'=>['style'=>'width:100%']
                                ],  
                                [
                                    'attribute'=>'village_id', 
                                    'value'=>($model->village_id!=null) ? $model->village->title:'',
                                    'type'=>DetailView::INPUT_SELECT2, 
                                    'options' => ['id' => 'village_id', 'prompt' => '', 'disabled'=>false],
                                    'items' => $villageList,
                                    'widgetOptions'=>[
                                        'class'=> Select2::className(),
                                        'data'=>$villageList,
                                    ],
                                    'valueColOptions'=>['style'=>'width:100%']
                                ],
                                [
                                    'attribute'=>'description', 
                                    'type'=>DetailView::INPUT_TEXTAREA,  
                                    'value'=>($model->description!=null) ? $model->description:'',
                                    'valueColOptions'=>['style'=>'width:100%']
                                ],                                                         
                
                                [
                                    'group'=>true,
                                    'label'=>'',
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
                            'enableEditMode' => Yii::$app->user->can('update-customer'),
                        ]) ?>
                    </div>
                    <div class="col-md-4">

                        <?php if(empty($enrolment)){ ;?>
                            <div class="panel panel-danger">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Pelanggan Tv</h3>
                                </div>
                                <div class="panel-body">
                                    <h4 class="box-title">Belum Terdaftar ... !!</h4>
                                    <?= Html::a('Berlanggan <i class="fa fa-pencil-square"></i>', ['/enrolment/create','id'=>$model->id], ['class' => 'btn btn-primary']);?>
                                </div>
                            </div>
                        <?php 
                        } 
                        else { 
                        ;?>
                            <?=$this->render('/customer/side_view',[
                                'customer'=>null,
                                'enrolment'=>$enrolment,
                            ])
                            ?>

                            <?=$this->render('/outlet/side_view',[
                                'providerOutletDetail'=>$providerOutletDetail,
                                'customer_id'=>$model->id,
                            ])
                            ?>
                        <?php };?>
                    </div>
                </div>
            </div>
            <!-- /.tab-pane -->

            <!-- /////////////////////////////////////////////////////////// -->
            <!-- /////////////////////////////////////////////////////////// -->
            <!-- /////////////////////////////////////////////////////////// -->




            <!-- /.tab-pane -->
        </div>
        <!-- /.tab-content -->
    </div>
    <!-- nav-tabs-custom -->

    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title"><i class="glyphicon glyphicon-info-sign"></i> Iuran Bulanan</h3>
            <span class="pull-right">
                <?=Html::a('Export', ['report-customer/history','id'=>$enrolment->id],['class'=>'btn btn-primary']);?>
            </span>
        </div>
        <!-- /.box-header -->
        <div class="box-body no-padding">
            <table class="table table-striped">

                <tr>
                    <th style="width: 10px">#</th>
                    <th style="width: 25px">Validasi</th>
                    <th style="width: 30px">Tagihan</th>
                    <th style="width: 30px">Penerimaan</th>
                    <th style="width: 30px">Denda</th>
                    <th style="width: 5px">Status</th>
                </tr>
                
                <?php
                    foreach ($billingAssemblys->all() as $key=>$billingAssemblyModel){
                        $receivableDetail   = ReceivableDetail::find()->where(['billing_id'=>$billingAssemblyModel->id])->one();
                ?>
                
                        <tr>
                            <td><?=($key+1);?></td>
                            <td><?=$billingAssemblyModel->description;?></td>
                            <td>
                                <?php
                                    $billingMonthlyAmount   = Html::a($formatter->asDecimal($billingAssemblyModel->amount), $billingAssemblyModel->getUrl());
                                    $billingMonthlyType     = $billingAssemblyModel->getOneBillingType($billingAssemblyModel->billing_type);
                                    $billingMonthlyStatus   = $billingAssemblyModel->getOnePaymentStatus($billingAssemblyModel->payment_status);
                                    echo $billingMonthlyAmount.' '.$billingMonthlyType.' '.$billingMonthlyStatus;
                                ?>
                            </td>
                            <td>
                                <?php
                                    if(!empty($receivableDetail)){
                                        $overdueLabel           = ($receivableDetail->overdue > 0) ? 'red':'green';
                                        $receivableInvoice      = Html::a($receivableDetail->receivable->invoice, $receivableDetail->receivable->getUrl());
                                        $payment                = $formatter->asDecimal($receivableDetail->receivable->payment);
                                        $accuracyStatus         = $receivableDetail->getOneAccuracyStatus($receivableDetail->accuracy_status);
                                        $overdue                = '<span class="badge bg-'.$overdueLabel.'">'.$receivableDetail->overdue.'</span>';
                                        echo $receivableInvoice.' '.$payment.' '.$accuracyStatus.' '.$overdue; 
                                    }
                                    else{
                                        echo Html::a(
                                            '<i class="glyphicon glyphicon-plus"></i> Bayar', 
                                            Yii::$app->getUrlManager()->createUrl([
                                                'receivable/create', 
                                                'id' => $model->id, 
                                                'title' => $model->title]),
                                            ['class' => 'btn btn-default btn-xs']    
                                        ); 
                                    }
                                        
                                ?>
                            </td>
                            <td><?= (!empty($receivableDetail)) ? $formatter->asDecimal($receivableDetail->penalty):'-';?></td>
                            <td>
                                <?php
                                    $checkLabel = '<span class="badge bg-red"><i class="fa fa-exclamation"></i></span>';
                                    if($billingAssemblyModel->payment_status==\backend\models\Billing::PAYMENT_STATUS_PAID){
                                        $checkLabel = '<span class="badge bg-green"><i class="fa fa-check"></i></span>';
                                    }
                                    echo $checkLabel;
                                ?>
                            </td>
                        </tr>
                
                
                <?php
                    }
                ?>
                

                
                <?=
                ListView::widget([
                    'dataProvider' => $providerValidityDetail,
                    'summary' => '',
                    //        'options' => [
                    //             'tag' => 'div',
                    //             'class' => 'masonry-box margin-bottom-50', //Masonry Box
                    //             'id' => '',//list-wrapper
                    //         ],
                    // 'itemOptions' => [
                    //     'tag' => 'div',
                    //     'class' => '', //Blog Grid
                    // ],
                    // 'pager' => [
                    //     'firstPageLabel' => '<span aria-hidden="true"> First </span><span class="sr-only">First</span>',
                    //     'lastPageLabel' => '<span aria-hidden="true"> Last </span><span class="sr-only">Last</span>',
                    //     'prevPageLabel' => '<span aria-hidden="true"> <i class="fa fa-angle-left"></i></span><span class="sr-only">Previous</span>',
                    //     'nextPageLabel' => '<span aria-hidden="true"> <i class="fa fa-angle-right"></i></span><span class="sr-only">Next</span>',
                    //     'maxButtonCount' => 10,
                    //     // Customzing options for pager container tag
                    //     'options' =>[
                    //         'tag' => 'ul',
                    //         'class' => 'list-inline',
                    //         'id'=>'myLink',
                    //     ],
                    //     'linkContainerOptions'=>[
                    //         'tag' => 'li'        ,
                    //         'class' => 'list-inline-item g-hidden-sm-down',
                    //     ],
                    //     // Customzing CSS class for pager link
                    //     //'linkOptions' => ['class' => ''],
                    //     'pageCssClass'=>['u-pagination-v1__item g-rounded-50 g-pa-4-13 u-pagination-v1-3 u-pagination-v1-3'],
                    //     'activePageCssClass' => 'u-pagination-v1__item g-rounded-50 g-pa-4-13 u-pagination-v1-3--active',
                    //     'disabledPageCssClass' => '',
                    //     // Customzing CSS class for navigating link
                    //     'prevPageCssClass' => '',
                    //     'nextPageCssClass' => '',
                    //     'firstPageCssClass' => '',
                    //     'lastPageCssClass' => '',
                    // ],
                    'viewParams' => [
                        'counter' => $billingAssemblys->count()
                    ],
                    'itemView' => '_validity_detail_grid',
                ]);
                ?>

            </table>
        </div>
    </div>
</div>