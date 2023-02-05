<?php
use yii\helpers\Html;

use backend\models\Billing;
use backend\models\ReceivableDetail;
use backend\models\ValidityDetail;

$formatter              = \Yii::$app->formatter;

$validityDetailIcon     = '';
//$validityDetailIcon     = '<span class="badge bg-yellow"><i class="fa fa-exclamation"></i></span>';
$billingIcon            = '<span class="badge bg-yellow"><i class="fa fa-exclamation"></i></span>';
$checkLabel             = '<span class="badge bg-red"><i class="fa fa-exclamation"></i></span>';

$billingMonthly         = null;
$receivableDetail       = null;

$validityDetailLabel    = Html::a($model->month_period, $model->getUrl()).' '.$model->getOneDeviceStatus($model->device_status);
$billingMonthlyLabel    = null;
$receivableDetailLabel  = null;

?>


<tr>
    <td><?= ($key+$counter+1) ?></td>
    
    <!-- VALIDASI -->
    <td><?= $validityDetailLabel ?></td>
    
    <!-- TAGIHAN -->
    <td>
        
        <?php
            if($model->device_status == ValidityDetail::DEVICE_STATUS_ACTIVE){
                $billingMonthly = Billing::find()->where(['invoice'=>$model->title])->one();
                if(!empty($billingMonthly)){
                    $receivableDetail       = ReceivableDetail::find()->where(['billing_id'=>$billingMonthly->id])->one();
                    
                    $billingMonthlyPeriod   = Html::a($billingMonthly->month_period, $billingMonthly->getUrl());
                    $billingMonthlyType     = $billingMonthly->getOneBillingType($billingMonthly->billing_type);
                    $billingMonthlyStatus   = $billingMonthly->getOnePaymentStatus($billingMonthly->payment_status);
                    
                    echo $billingMonthlyPeriod.' '.$formatter->asDecimal($billingMonthly->amount).' '.$billingMonthlyType.' '.$billingMonthlyStatus;

                }       
                else{
                    echo Html::a(
                            '<i class="glyphicon glyphicon-plus"></i> Tagihan', 
                            Yii::$app->getUrlManager()->createUrl([
                                'billing/create', 
                                'id' => $model->customer_id, 
                                'title' => $model->customer->title]),
                            [
                                'class' => 'btn btn-default btn-xs'
                            ]
                    );                    
                }
            }
            else{
                echo $model->getOneBillingStatus($model->billing_status);
            }
        ?>
        
    </td>
    
    <!-- PENERIMAAN -->
    <td>
        <?php
            if($model->device_status == ValidityDetail::DEVICE_STATUS_ACTIVE){

                if(empty($billingMonthly)){
                    echo $checkLabel;
                }
                else{
                    if(!empty($receivableDetail)){
                        $overdueLabel           = ($receivableDetail->overdue > 0) ? 'red':'green';
                        $receivableInvoice      = Html::a($receivableDetail->receivable->invoice, $receivableDetail->receivable->getUrl());
                        $payment                = $formatter->asDecimal($receivableDetail->receivable->payment);
                        $accuracyStatus         = $receivableDetail->getOneAccuracyStatus($receivableDetail->accuracy_status);
                        $overdue                = '<span class="badge bg-'.$overdueLabel.'">'.$receivableDetail->overdue.'</span>';
                        $checkLabel             = '<span class="badge bg-green"><i class="fa fa-check"></i></span>';

                        echo $receivableInvoice.' '.$payment.' '.$accuracyStatus.' '.$overdue; 
                    }       
                    else{
                        echo Html::a(
                            '<i class="glyphicon glyphicon-plus"></i> Bayar', 
                            Yii::$app->getUrlManager()->createUrl([
                                'receivable/create', 
                                'id' => $model->customer_id, 
                                'title' => $model->customer->title]),
                            ['class' => 'btn btn-default btn-xs']    
                        );      
                    }                    
                }
            }
            else{
                echo $model->getOneBillingStatus($model->billing_status);
                $checkLabel = '<span class="badge bg-grey"><i class="fa fa-check"></i></span>';
            }
        ?>    
    </td>

    
    <!-- DENDA -->
    <td>
        <?php
            if($model->device_status == ValidityDetail::DEVICE_STATUS_ACTIVE){

                if(empty($billingMonthly)){
                    echo '-';
                }
                else{
                    if(!empty($receivableDetail)){
                        $overdueLabel           = ($receivableDetail->overdue > 0) ? 'red':'green';
                        $checkLabel             = '<span class="badge bg-green"><i class="fa fa-check"></i></span>';

                        echo $formatter->asDecimal($receivableDetail->penalty); 
                    }       
                    else{
                        echo '-';
                    }                    
                }
            }
            else{
                echo $model->getOneBillingStatus($model->billing_status);
                $checkLabel = '<span class="badge bg-grey"><i class="fa fa-check"></i></span>';
            }
        ?>
    </td>
    
    <!-- STATUS -->
    <td>
        <?= $checkLabel; ?>
    </td>
</tr>

