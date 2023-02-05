<?php

use common\helper\Helper;
use backend\models\Billing;
use backend\models\ValidityDetail;

$currMonthPeriod    = Helper::getMonthPeriod(time());
$currDate           = date('d',time());
$currMonth          = date('m',time());
$currYear           = date('Y',time());  

$dateNow            = Yii::$app->formatter->format(time(), 'date'); 

?>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Rekap Tagihan Bulanan</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <div class="btn-group">
                        <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-wrench"></i></button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </div>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <?= $this->render('_rekap_billing_chart_line') ?>
                    </div>
                    
                    <!--<div class="col-md-4">-->
                        <?php //$this->render('_rekap_billing_by_area') ?>
                    <!--</div>-->
                    
                </div>
                <!-- /.row -->
            </div>
            <!-- ./box-body -->
            <div class="box-footer">
                <div class="row">
                    <div class="col-sm-6 col-xs-12">
                        <div class="description-block border-right">
                            <span class="description-percentage text-green">01 Jan - <?=$dateNow;?></span>
                            <h5 class="description-header">Rp.<?=Billing::sumAmount(Billing::PAYMENT_STATUS_CREDIT);?></h5>
                            <span class="description-text">Nilai Tagihan</span>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-12">
                        <div class="description-block border-right">
                            <span class="description-percentage text-green">01 Jan - <?=$dateNow;?></span>
                            <h5 class="description-header">Rp.<?=ValidityDetail::sumAmount(ValidityDetail::DEVICE_STATUS_IDLE);?></h5>
                            <span class="description-text">NILAI DC SEMENTARA</span>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.box-footer -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->