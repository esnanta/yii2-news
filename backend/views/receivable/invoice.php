<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Receivable */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Receivable', 'url' => ['index']];
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
                <strong>[<?=$enrolment->title;?>] <?=$enrolment->customer->title;?></strong><br>
                <?=$enrolment->customer->address;?><br>
                <?=$enrolment->customer->phone_number;?><br>
                JTO <?=$enrolment->billing_cycle;?> / bulan<br>
            </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">

        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
            <b>Invoice #<?=$model->invoice;?></b><br>
            <br>
            <b>Date:</b> <?= Yii::$app->formatter->format($model->date_issued, 'date'); ?><br>
            <b>Issued By:</b> <?=$model->staff->title;?><br>
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
                        <th>Deskripsi</th>
                        <th>Status</th>
                        <th>Iuran</th>
                        <th>Alasan</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php
                        $receivableDetails = $providerReceivableDetail->getModels();

                        foreach($receivableDetails as $receivableDetailModel){
                            
                            $billingStatus  = $receivableDetailModel->billing->getOneBillingType($receivableDetailModel->billing->billing_type);
                            $overdueStatus  = $receivableDetailModel->getOneAccuracyStatus($receivableDetailModel->accuracy_status);
                            $overdueDays    = ($receivableDetailModel->overdue>1) ? $receivableDetailModel->overdue.' ('.$overdueStatus.')':$overdueStatus;
                            
                    ?>
                            <tr>
                                <td><?=$billingStatus;?></td>
                                <td><?=$receivableDetailModel->billing->month_period;?></td>
                                <td><?= Yii::$app->formatter->format($receivableDetailModel->date_due, 'date'); ?></td>
                                <td><?= $overdueDays;?></td>
                                <td><?=$formatter->asDecimal($receivableDetailModel->claim);?></td>
                                <td><?=$formatter->asDecimal($receivableDetailModel->penalty);?></td>
                                <td><?=$formatter->asDecimal($receivableDetailModel->total);?></td>
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
        <div class="col-xs-8">
            <p class="lead">Desc</p>
            <p>
                <?= $model->description;?>
            </p>
            <hr>
            <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                <?= $descReport->content;?>
            </p>
            <div class="row">
                <div class="col-xs-2"></div>
                <div class="col-xs-8" style="text-align: justify">
                    dto
                    <br>
                    <br>
                    <br>
                    <br>
                    ( <?=$model->staff->title;?> )                    
                </div>
            </div>

        </div>
        <!-- /.col -->
        <div class="col-xs-4">
            <p class="lead">Summary</p>

            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th style="width:50%">Tagihan</th>
                        <td><?=$formatter->asDecimal($model->claim);?></td>
                    </tr>
                    <tr>
                        <th>Tambahan</th>
                        <td><?=$formatter->asDecimal($model->surcharge);?></td>
                    </tr>
                    <tr>
                        <th>Total:</th>
                        <td><?=$formatter->asDecimal($model->total);?></td>
                    </tr>
                    <tr>
                        <th>Diskon</th>
                        <td><?=$formatter->asDecimal($model->discount);?></td>
                    </tr>
                    <tr>
                        <th>Bayar</th>
                        <td><?=$formatter->asDecimal($model->payment);?></td>
                    </tr>
                    <tr>
                        <th>Balance</th>
                        <td><?=$formatter->asDecimal($model->balance);?></td>
                    </tr>                    
                </table>
            </div>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>