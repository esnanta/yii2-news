<?php
use yii\helpers\Html;

use backend\models\Billing;
use backend\models\OutletDetail;

$this->title = 'Dashboard';
$this->params['breadcrumbs'][] = $this->title;

$create = Html::a('<i class="glyphicon glyphicon-plus"></i>', ['note/create'], ['class' => 'pull-right detail-button','style'=>'padding:0 5px']);
?>


<div class="row">
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3><?=OutletDetail::countByDeviceStatus(OutletDetail::DEVICE_STATUS_ACTIVE);?></h3>

                <p>Aktif</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <?=
                Html::a('<i class="fa fa-arrow-circle-right"></i> ' . 'Outlet Pelanggan ',
                        ['/outlet-detail/index'],
                        [
                            'class' => 'small-box-footer',
                            'data-toggle' => 'tooltip',
                            'title' => 'More info'
                        ]
                    );
            ?>             
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <h3><?=OutletDetail::countByDeviceStatus(OutletDetail::DEVICE_STATUS_FREE);?></h3>

                <p>Gratis</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <?=
                Html::a('<i class="fa fa-arrow-circle-right"></i> ' . 'Outlet Pelanggan ',
                        ['/outlet-detail/index'],
                        [
                            'class' => 'small-box-footer',
                            'data-toggle' => 'tooltip',
                            'title' => 'More info'
                        ]
                    );
            ?>             
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3><?=OutletDetail::countByDeviceStatus(OutletDetail::DEVICE_STATUS_IDLE);?></h3>

                <p>DC Sementara</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            
            <?=
                Html::a('<i class="fa fa-arrow-circle-right"></i> ' . 'Outlet Pelanggan ',
                        ['/outlet-detail/index'],
                        [
                            'class' => 'small-box-footer',
                            'data-toggle' => 'tooltip',
                            'title' => 'More info'
                        ]
                    );
            ?>            
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <h3><?=Billing::countByPaymentStatus(Billing::PAYMENT_STATUS_CREDIT);?></h3>

                <p>Tagihan</p>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            
            <?=
                Html::a('<i class="fa fa-arrow-circle-right"></i> ' . 'Total Tagihan',
                        ['/billing/index'],
                        [
                            'class' => 'small-box-footer',
                            'data-toggle' => 'tooltip',
                            'title' => 'More info'
                        ]
                    );
            ?>
            
        </div>
    </div>
    <!-- ./col -->
</div>




<?= $this->render('rekap_billing_bulanan') ?>