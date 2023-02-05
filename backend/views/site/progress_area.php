<?php

use common\helper\Helper;

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
                <h3 class="box-title">Progress Tagihan Berdasarkan Kolektor</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <?= $this->render('_rekap_billing_by_area') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>