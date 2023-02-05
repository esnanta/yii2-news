<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;
use kartik\widgets\Select2;
use yii\widgets\ListView;
use backend\models\Enrolment;
/**
 * @var yii\web\View $this
 * @var backend\models\Enrolment $model
 */

$this->title = 'Info Berlangganan '.$model->customer->title.'-'.$model->title;
$this->params['breadcrumbs'][] = ['label' => 'Enrolments', 'url' => ['index','type'=>$model->enrolment_type]];
$this->params['breadcrumbs'][] = $this->title;

//$create = Html::a('<i class="glyphicon glyphicon-plus"></i>', ['/customer/select','module'=>'enrolment'], ['class' => 'pull-right detail-button','style'=>'padding:0 5px']);
$update = Html::a('<i class="glyphicon glyphicon-pencil"></i>', ['update','id'=>$model->id], ['class' => 'pull-right detail-button','style'=>'padding:0 5px']);
$formatter = \Yii::$app->formatter;

$outletInfo     = $outletDetailDeviceStatus;
?>

<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab">Info Berlangganan
                <?= (!empty($model->title)) ? '<span class="label label-primary">' . $model->title . '</span>' : ''; ?></a>
        </li>
        <div style="padding:5px">
            <div class="btn-group pull-right">
                <div class="btn-group">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        Options <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <?=
                            Html::a(
                                    '<span class=""><i class="fa fa-user"></i> ' . $model->customer->title . '</span>',
                                    Yii::$app->getUrlManager()->createUrl([
                                        'customer/view',
                                        'id' => $model->customer_id,
                                        'title' => $model->customer->title]),
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
                                    '<span class=""><i class="fa fa-plus"></i> Billing</span>',
                                    Yii::$app->getUrlManager()->createUrl([
                                        'billing/create',
                                        'id' => $model->customer_id,
                                        'title' => $model->customer->title]),
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
                                        'id' => $model->customer_id,
                                        'title' => $model->customer->title]),
                                    [
                                        'role' => 'menuitem',
                                        'tabindex' => '-1',
                                    ]
                            );
                            ?>
                        </li>

                        <li>
                            <?php
                            if ($model->enrolment_type==\backend\models\Enrolment::ENROLMENT_TYPE_ANALOG){
                                echo Html::a(
                                        '<span class=""><i class="fa fa-plus"></i> Service</span>',
                                        Yii::$app->getUrlManager()->createUrl([
                                            'service/create',
                                            'id' => $model->customer_id,
                                            'type' => backend\models\Service::SERVICE_TYPE_GENERAL,
                                            'title' => $model->customer->title]),
                                        [
                                            'role' => 'menuitem',
                                            'tabindex' => '-1',
                                        ]
                                );
                            }
                            else if($model->enrolment_type==\backend\models\Enrolment::ENROLMENT_TYPE_DIGITAL){
                                echo Html::a(
                                    '<span class=""><i class="fa fa-plus"></i> Service</span>',
                                    Yii::$app->getUrlManager()->createUrl([
                                        'service/create',
                                        'id' => $model->customer_id,
                                        'type' => backend\models\Service::SERVICE_TYPE_EXTEND_DIGITAL,
                                        'title' => $model->customer->title]),
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
                                        'id' => $model->customer_id,
                                        'title' => $model->customer->title]),
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
        </div>
    </ul>


    <div class="tab-content">
        <div class="tab-pane active" id="tab_1">

            <div class="row">
                <div class="col-md-8">
                    <?=
                    DetailView::widget([
                        'model' => $model,
                        'condensed' => false,
                        'hover' => true,
                        'mode' => Yii::$app->request->get('edit') == 't' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
                        'panel' => [
                            'heading' => 'No Pelanggan ' . $model->title . $update,
                            'type' => DetailView::TYPE_PRIMARY,
                        ],
                        'attributes' => [
                            [
                                'columns' => [
                                    [
                                        'attribute' => 'customer_id',
                                        'value' => ($model->customer_id != null) ?
                                                Html::a($model->customer->title, $model->customer->getUrl()).'<span class="pull pull-right">'.$outletInfo.'</span>' : '',
                                        'format' => 'html',
                                        'type' => DetailView::INPUT_HIDDEN,
                                        'options' => ['id' => 'customer_id', 'prompt' => ''],
                                        'items' => $customerList,
                                        'widgetOptions' => [
                                            'data' => $customerList,
                                        ],
                                        'valueColOptions' => ['style' => 'width:30%']
                                    ],
                                    [
                                        'attribute' => 'title',
                                        'type' => DetailView::INPUT_HIDDEN,
                                        'valueColOptions' => ['style' => 'width:30%']
                                    ],
                                ],
                            ],
                            [
                                'columns' => [
                                    [
                                        'label' => 'Alamat',
                                        'value' => ($model->customer_id != null) ? $model->customer->address : '',
                                        'format' => 'html',
                                        'type' => DetailView::INPUT_HIDDEN,
                                        'valueColOptions' => ['style' => 'width:30%']
                                    ],
                                    [
                                        'label' => 'Telpon',
                                        'value' => ($model->customer_id != null) ? $model->customer->phone_number : '',
                                        'format' => 'html',
                                        'type' => DetailView::INPUT_HIDDEN,
                                        'valueColOptions' => ['style' => 'width:30%']
                                    ],
                                ],
                            ],
                            [
                                'columns' => [
                                    [
                                        'attribute' => 'network_id',
                                        'value' => ($model->network_id != null) ? $model->network->title : '',
                                        'type' => DetailView::INPUT_SELECT2,
                                        'options' => ['id' => 'network_id', 'prompt' => '', 'disabled' => false],
                                        'items' => $networkList,
                                        'widgetOptions' => [
                                            'class' => Select2::className(),
                                            'data' => $networkList,
                                        ],
                                        'valueColOptions' => ['style' => 'width:30%']
                                    ],
                                    [
                                        'attribute' => 'date_effective',
                                        'format' => 'date',
                                        'type' => DetailView::INPUT_WIDGET,
                                        'widgetOptions' => [
                                            'class' => DateControl::classname(),
                                            'type' => DateControl::FORMAT_DATE,
                                        ],
                                        'valueColOptions' => ['style' => 'width:30%']
                                    ],
                                ],
                            ],

                            [
                                'group' => true,
                                'label' => '',
                                'rowOptions' => ['class' => 'default']
                            ],

                            [
                                'columns' => [
                                    [
                                        'attribute'=>'enrolment_type',
                                        'format'=>'html',
                                        'value'=>($model->enrolment_type!=null) ? $model->getOneEnrolmentType($model->enrolment_type):'',
                                        'type'=> DetailView::INPUT_SELECT2,
                                        'options' => ['id' => 'enrolment_type', 'prompt' => ''],
                                        'items' => $enrolmentTypeList,
                                        'widgetOptions'=>[
                                            'class'=> Select2::className(),
                                            'data'=>$enrolmentTypeList,
                                        ],
                                        //'valueColOptions'=>['style'=>'width:30%']
                                    ],

                                ],
                            ],

                            [
                                'columns' => [
                                    [
                                        'attribute' => 'date_start',
                                        'format' => 'date',
                                        'type' => DetailView::INPUT_WIDGET,
                                        'widgetOptions' => [
                                            'class' => DateControl::classname(),
                                            'type' => DateControl::FORMAT_DATE,
                                        ],
                                        'valueColOptions' => ['style' => 'width:30%'],
                                        'visible' => ($model->enrolment_type == Enrolment::ENROLMENT_TYPE_DIGITAL) ? true : false
                                    ],
                                    [
                                        'attribute' => 'date_end',
                                        'format' => 'date',
                                        'type' => DetailView::INPUT_WIDGET,
                                        'widgetOptions' => [
                                            'class' => DateControl::classname(),
                                            'type' => DateControl::FORMAT_DATE,
                                        ],
                                        'valueColOptions' => ['style' => 'width:30%'],
                                        'visible' => ($model->enrolment_type == Enrolment::ENROLMENT_TYPE_DIGITAL) ? true : false
                                    ],
                                ],
                            ],
                            [
                                'columns' => [
                                    [
                                        'label' => 'Aktif',
                                        'format' => 'html',
                                        'type' => DetailView::INPUT_HIDDEN,
                                        'value' => $formatter->asDecimal($model->countDeviceActive()) . ' Outlet',
                                        'valueColOptions' => ['style' => 'width:30%']
                                    ],
                                    [
                                        'attribute' => 'billing_cycle',
                                        'value' => ($model->billing_cycle != null) ? $model->billing_cycle : '',
                                        'type' => DetailView::INPUT_SELECT2,
                                        'options' => ['id' => 'billing_cycle', 'prompt' => '', 'disabled' => false],
                                        'items' => $billingCycleList,
                                        'widgetOptions' => [
                                            'class' => Select2::className(),
                                            'data' => $billingCycleList,
                                        ],
                                        'valueColOptions' => ['style' => 'width:30%']
                                    ],
                                ],
                            ],

                            [
                                'group' => true,
                                'label' => '',
                                'rowOptions' => ['class' => 'default']
                            ],

                            [
                                'columns' => [
                                    [
                                        'label' => 'Iuran',
                                        'format' => 'html',
                                        'type' => DetailView::INPUT_HIDDEN,
                                        'value' => $formatter->asDecimal($model->customer->sumMonthlyBill()),
                                        'valueColOptions' => ['style' => 'width:30%']
                                    ],
                                    [
                                        'attribute' => 'description',
                                        'format' => 'html',
                                        'type' => DetailView::INPUT_TEXT,
                                        'valueColOptions' => ['style' => 'width:30%']
                                    ],
                                ],
                            ],
                            [
                                'group' => true,
                                'label' => '',
                                'rowOptions' => ['class' => 'default']
                            ],
                            [
                                'columns' => [
                                    [
                                        'attribute' => 'created_at',
                                        'format' => 'date',
                                        'type' => DetailView::INPUT_HIDDEN,
                                        'valueColOptions' => ['style' => 'width:30%']
                                    ],
                                    [
                                        'attribute' => 'updated_at',
                                        'format' => 'date',
                                        'type' => DetailView::INPUT_HIDDEN,
                                        'valueColOptions' => ['style' => 'width:30%']
                                    ],
                                ],
                            ],
                            [
                                'columns' => [
                                    [
                                        'attribute' => 'created_by',
                                        'value' => ($model->created_by != null) ? \backend\models\User::getName($model->created_by) : '',
                                        'type' => DetailView::INPUT_HIDDEN,
                                        'valueColOptions' => ['style' => 'width:30%']
                                    ],
                                    [
                                        'attribute' => 'updated_by',
                                        'value' => ($model->updated_by != null) ? \backend\models\User::getName($model->updated_by) : '',
                                        'type' => DetailView::INPUT_HIDDEN,
                                        'valueColOptions' => ['style' => 'width:30%']
                                    ],
                                ],
                            ],
                        ],
                        'deleteOptions' => [
                            'url' => ['delete', 'id' => $model->id],
                        ],
                        'enableEditMode' => false,
                    ])
                    ?>
                </div>
                <div class="col-md-4">

                    <?php if (empty($providerOutletDetail->getModels())) { ?>
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <h3 class="panel-title">Data Outlet</h3>
                            </div>
                            <div class="panel-body">
                                <h4 class="box-title">Tidak ada data ... !!</h4>
                                <?= Html::a('Buat Outlet <i class="fa fa-pencil-square"></i>', ['/outlet/create', 'id' => $model->id], ['class' => 'btn btn-primary']); ?>
                            </div>
                        </div>
                        <?php
                    } else { ?>
                        <?=
                        $this->render('/outlet/side_view', [
                            'providerOutletDetail' => $providerOutletDetail,
                            'customer_id' => $model->customer_id,
                        ])
                        ?>
                    <?php } ?>

                    <?php if($model->enrolment_type==\backend\models\Enrolment::ENROLMENT_TYPE_DIGITAL) { ?>
                        <div class="box box-primary">
                            <div class="box-header">
                                <h3 class="box-title">
                                    <i class="glyphicon glyphicon-screenshot"></i>
                                    Info Digital
                                </h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body no-padding">
                                <table class="table table-striped">
                                    <tr>
                                        <td><?=$model->getAttributeLabel('date_start')?></td>
                                        <td>
                                            <?= date("d-m-Y", $model->date_start); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?=$model->getAttributeLabel('date_end')?></td>
                                        <td>
                                            <?= date("d-m-Y", $model->date_end); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?=$model->getAttributeLabel('days_of_valid')?></td>
                                        <td>
                                            <?= $model->getDaysOfValid() .' days'; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?=$model->getAttributeLabel('days_of_expired')?></td>
                                        <td>
                                            <?= $model->getDaysOfExpired() .' days ago'; ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <?php
                                if($model->enrolment_type == Enrolment::ENROLMENT_TYPE_DIGITAL){
                                    echo Html::a(
                                            '<i class="glyphicon glyphicon-plus"></i> Perpanjang 30 hari',
                                            Yii::$app->getUrlManager()->createUrl([
                                                'service/create',
                                                'id' => $model->customer_id,
                                                'type' => backend\models\Service::SERVICE_TYPE_EXTEND_DIGITAL,
                                                'title' => $model->customer->title,
                                                'days' => 30]),
                                            [
                                                'class' => 'btn btn-success btn-sm pull-right',
                                                'style' => 'margin-top:10px'
                                            ]
                                    );
                                }
                            ?>

                        </div>

                    <?php } ?>


                </div>
            </div>

            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title"><i class="glyphicon glyphicon-info-sign"></i> Iuran Bulanan</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                    <table class="table table-striped">

                        <tr>
                            <th style="width: 10px">#</th>
                            <th style="width: 25px">Validasi</th>
                            <th style="width: 30px">Tagihan</th>
                            <th style="width: 30px">Penerimaan</th>
                            <th style="width: 5px">Status</th>
                        </tr>

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
                            'itemView' => '_view_grid',
                        ]);
                        ?>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>