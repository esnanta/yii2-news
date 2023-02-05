<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Receivable */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Service', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$formatter = Yii::$app->formatter;
?>

<style type="text/css" media="print">
@page {
    size: auto;
    /* auto is the initial value */
    margin: 0;
    /* this affects the margin in the printer settings */
}
</style>


<form class="no-print">
    <input type="button" value="Print this page" onClick="window.print()" class="btn btn-success">
</form>

<section class="invoice">
    <!-- title row -->
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header">
                <?= Html::img($logoReport1->getImageUrl(), ['style' => 'width:200px;height:40px'], ['alt' => 'alt image']);?>
            </h2>
        </div>
        <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
            <address>
                <strong><?=$office->title;?></strong><br>
                <?=$office->address;?> <br>
                <?=$office->phone_number;?> <br>
            </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-3 invoice-col">

        </div>
        <!-- /.col -->
        <div class="col-sm-5 invoice-col">
            <address>
                <strong>[<?=$enrolment->title;?>] <?=$enrolment->customer->title;?></strong> <br>
                <?=$enrolment->customer->address;?><br>
                <?=$enrolment->customer->phone_number;?> - JTO <?=$enrolment->billing_cycle;?> / bulan<br>
            </address>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
        <div class="col-xs-12 table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Remark</th>
                        <th>Status</th>
                        <th>Iuran</th>
                        <th>Kategori</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php
                        $serviceDetails = $providerServiceDetail->getModels();

                        foreach($serviceDetails as $i=>$serviceDetailModel){

                            $deviceStatus  = $serviceDetailModel->getOneDeviceStatus($serviceDetailModel->device_status);

                    ?>
                            <tr>
                                <td><?= ($i+1);?></td>
                                <td><?= $serviceDetailModel->commentary;?></td>
                                <td><?= $deviceStatus; ?></td>
                                <td><?= $formatter->asDecimal($serviceDetailModel->monthly_bill);?></td>
                                <td><?=$serviceDetailModel->serviceReason->title;?></td>
                            </tr>
                    <?php
                            
                        }
                    ?>

                </tbody>
            </table>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
        <!-- accepted payments column -->
        <div class="col-xs-4">
            <b>Invoice #<?= $model->invoice; ?></b><br>
            
            <b>Issued:</b> <?= Yii::$app->formatter->format($model->date_issued, 'date'); ?><br>
            <b>Issued By:</b> <?= $model->staff->title; ?><br>                                

            <br>
            <br>

            <b><?= $model->getAttributeLabel('created_by')?> : </b> <?=\backend\models\User::getName($model->created_by);?><br>
            <b><?= $model->getAttributeLabel('created_at')?> : </b> <?=Yii::$app->formatter->format($model->created_at,'date');?><br>


        </div>
        <!-- /.col -->
        <div class="col-xs-4">
            <?php if($model->service_type != backend\models\Service::SERVICE_TYPE_GENERAL){?>
                <b>Jenis:</b> <?= $model->getOneServiceType($model->service_type); ?><br>
                <b>Mulai:</b> <?= Yii::$app->formatter->asDate($model->date_start, 'dd-MM-yyyy'); ?><br>
                <b>Selesai:</b> <?= Yii::$app->formatter->asDate($model->date_end, 'dd-MM-yyyy'); ?><br>
            <?php } ?>
            <b>Berlaku:</b> <?= Yii::$app->formatter->format($model->date_issued, 'date'); ?><br>
            <b>Deskripsi:</b><br>
            <p><?= $model->description; ?><p>
        </div>
        <div class="col-xs-4">
            <p class="lead">Summary</p>

            <div class="table-responsive">
                <table class="table">
                    <?php if($model->service_type != backend\models\Service::SERVICE_TYPE_GENERAL){?>
                        <tr>
                            <th>Tagihan</th>
                            <td><?= $formatter->asDecimal($model->claim); ?></td>
                        </tr> 
                        <tr>
                            <th>Biaya</th>
                            <td><?= $formatter->asDecimal($model->surcharge); ?></td>
                        </tr> 
                        <tr>
                            <th>Total</th>
                            <td><?= $formatter->asDecimal($model->total); ?></td>
                        </tr>   
                    <?php } ?>
                </table>
            </div>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>