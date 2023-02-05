<?php

/* @var $this yii\web\View */

$this->title = 'Charts';
use dosamigos\chartjs\ChartJs;
use backend\models\Billing;

$datasetCredit      = [];
$datasetPaid        = [];

$paymentStatusCredit        = Billing::PAYMENT_STATUS_CREDIT;
$paymentStatusPaid          = Billing::PAYMENT_STATUS_PAID;

$currYear   = date('Y',time());

for($i=1;$i<=12;$i++){
    $datasetCredit[]        = Billing::countPaymentStatusYearly($currYear, $i,$paymentStatusCredit);
    $datasetPaid[]          = Billing::countPaymentStatusYearly($currYear, $i,$paymentStatusPaid);
}
?>

<div class="row">
    <div class="col-md-8">
        <p class="text-center">
            <strong>Tahun <?=$currYear;?></strong>
        </p>

        <div class="chart">
            <?= 
                ChartJs::widget([
                    'type' => 'line',
                    'data' => [
                        'labels' => [
                                        'januari','februari','maret',
                                        'april','mei','juni',
                                        'juli','agustus','september',
                                        'oktober','november', 'desember',
                                    ],
                        'datasets' => [
                            [
                                'label' => "Grafik Lunas",
                                'backgroundColor' => "rgba(0, 0, 255,0.2)",
                                'borderColor' => "rgba(0, 0, 255,1)",
                                'pointBackgroundColor' => "rgba(0, 0, 255,1)",
                                'pointBorderColor' => "#fff",
                                'pointHoverBackgroundColor' => "#fff",
                                'pointHoverBorderColor' => "rgba(0, 0, 255,1)",
                                'data' => $datasetPaid
                            ],

                            [
                                'label' => "Grafik Hutang",
                                'backgroundColor' => "rgba(255, 0, 0, 0.2)",
                                'borderColor' => "rgba(255, 0, 0, 1)",
                                'pointBackgroundColor' => "rgba(255, 0, 0, 1)",
                                'pointBorderColor' => "#fff",
                                'pointHoverBackgroundColor' => "#fff",
                                'pointHoverBorderColor' => "rgba(255, 0, 0, 1)",
                                'data' => $datasetCredit
                            ],                    
                        ]
                    ]
                ]);
            ?>    
        </div>
    </div>
    <div class="col-md-4">
<!--        <p class="text-center">
            <strong>Detail Tagihan</strong>
        </p>        -->
        <table class="table table-condensed">
            <tbody>
                <?php
                    for($i=1;$i<=12;$i++){
                ?>
                        <tr>
                            <td>
                                <?php echo DateTime::createFromFormat('!m', $i)->format('F'); // JAN ?>                            
                            </td>
                            <td><span class="label label-primary"><?= $datasetPaid[($i-1)];?></span></td>
                            <td><span class="label label-danger"><?= $datasetCredit[($i-1)];?></span></td>
                        </tr>                
                <?php
                    }
                ?>        
            </tbody>
        </table>
    </div>
</div>
        



