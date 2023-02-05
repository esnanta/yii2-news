<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Receivable */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Outlet', 'url' => ['index']];
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
        <div class="col-sm-4 invoice-col">

        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
            <address>
                <strong>[<?=$enrolment->title;?>] <?=$enrolment->customer->title;?></strong><br>
                <?=$enrolment->customer->address;?><br>
                <?=$enrolment->customer->phone_number;?><br>
                JTO <?=$enrolment->billing_cycle;?> / bulan<br>
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
                        <th>Invoice</th>
                        <th>Pasang</th>
                        <th>Iuran</th>
                        <th>Jenis</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                        $outletDetails = $providerOutletDetail->getModels();

                        foreach($outletDetails as $i=>$outletDetailModel){

                            $deviceStatus  = $outletDetailModel->getOneDeviceStatus($outletDetailModel->device_status);

                    ?>
                            <tr>
                                <td><?= ($i+1);?></td>
                                <td><?= $outletDetailModel->outlet->invoice ?></td>
                                <td><?= $formatter->asDecimal($outletDetailModel->assembly_cost)?></td>
                                <td><?= $formatter->asDecimal($outletDetailModel->monthly_bill);?></td>
                                <td><?= $outletDetailModel->getOneDeviceType($outletDetailModel->device_type)?></td>
                                <td><?= $outletDetailModel->getOneDeviceStatus($outletDetailModel->device_status)?></td>
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
            <br>
            <b>Issued:</b> <?= Yii::$app->formatter->format($model->date_issued, 'date'); ?><br>
            <b>Issued By:</b> <?= $model->staff->title; ?><br>

            <br>
            <br>

            <b><?= $model->getAttributeLabel('created_by')?> : </b> <?=\backend\models\User::getName($model->created_by);?><br>
            <b><?= $model->getAttributeLabel('created_at')?> : </b> <?=Yii::$app->formatter->format($model->created_at,'date');?><br>


        </div>
        <!-- /.col -->
        <div class="col-xs-4">
            <b>Jenis Pasang:</b><br>
            <?= $model->getOneAssemblyType($model->assembly_type); ?> [<?= Yii::$app->formatter->asDate($model->date_assembly, 'dd-MM-yyyy'); ?>] </br>
            <b>Deskripsi:</b><br>
            <?= $model->description; ?>
        </div>
        <div class="col-xs-4">
            <p class="lead">Summary</p>

            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th>Dibuat Tagihan</th>
                        <td><?= $model->getOneBillingStatus($model->billing_status); ?></td>
                    </tr>
                    <tr>
                        <th><?= $model->getAttributeLabel('claim'); ?></th>
                        <td><?= $formatter->asDecimal($model->claim); ?></td>
                    </tr>
                </table>
            </div>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>