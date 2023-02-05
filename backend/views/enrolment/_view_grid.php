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


//if($model->device_status == ValidityDetail::DEVICE_STATUS_ACTIVE){
//    $billingMonthly         = Billing::find()->where(['invoice'=>$model->title])->one();
//    
//    if(!empty($billingMonthly)){
//        $receivableDetail       = ReceivableDetail::find()->where(['billing_id'=>$billingMonthly->id])->one();
//
//        $billingMonthlyType     = $billingMonthly->getOneBillingType($billingMonthly->billing_type);
//        $billingMonthlyAmount   = Html::a($formatter->asDecimal($billingMonthly->amount), $billingMonthly->getUrl());
//        $billingMonthlyLabel     = $billingMonthlyType.' '.$billingMonthlyAmount;
//
//    }
//    
//    if(!empty($receivableDetail)){
//        $overdue                = 'Overdue '.$receivableDetail->overdue;
//
//        $receivableInvoice      = Html::a($receivableDetail->receivable->invoice, $receivableDetail->receivable->getUrl());
//        $accuracyStatus         = $receivableDetail->getOneAccuracyStatus($receivableDetail->accuracy_status);
//        $receivableDetailLabel   = $accuracyStatus.' '.$receivableInvoice.' '.$overdue;   
//
//        $billingIcon = '';
//    }
//    else{
//        $billingIcon = '<span class="badge bg-red"><i class="fa fa-question"></i></span>';
//    }    
//    
//}
//else{
//    $billingMonthlyLabel = $model->getOneBillingStatus($model->billing_status);
//}

?>


<tr>
    <td><?= ($key+1) ?></td>
    <td><?= $validityDetailLabel ?></td>
    <td>
        
        <?php
            if($model->device_status == ValidityDetail::DEVICE_STATUS_ACTIVE){
                $billingMonthly = Billing::find()->where(['invoice'=>$model->title])->one();
                if(!empty($billingMonthly)){
                    $receivableDetail       = ReceivableDetail::find()->where(['billing_id'=>$billingMonthly->id])->one();
                    $billingMonthlyType     = $billingMonthly->getOneBillingType($billingMonthly->billing_type);
                    $billingMonthlyStatus   = $billingMonthly->getOnePaymentStatus($billingMonthly->payment_status);
                    $billingMonthlyAmount   = Html::a($formatter->asDecimal($billingMonthly->amount), $billingMonthly->getUrl());
                    
                    echo $billingMonthlyAmount.' '.$billingMonthlyType.' '.$billingMonthlyStatus;

                }       
                else{
                    echo Html::a(
                            '<i class="glyphicon glyphicon-plus"></i> Buat', 
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
    <td>
        <?php
            if($model->device_status == ValidityDetail::DEVICE_STATUS_ACTIVE){
                
                if(empty($billingMonthly)){
                    echo '-';
                }
                else{
                    if(!empty($receivableDetail)){
                        $overdueLabel           = ($receivableDetail->overdue > 0) ? 'red':'green';
                        $overdue                = '<span class="badge bg-'.$overdueLabel.'">Ovd '.$receivableDetail->overdue.'</span>';
                        $receivableInvoice      = Html::a($receivableDetail->receivable->invoice, $receivableDetail->receivable->getUrl());
                        $accuracyStatus         = $receivableDetail->getOneAccuracyStatus($receivableDetail->accuracy_status);
                        $checkLabel             = '<span class="badge bg-green"><i class="fa fa-check"></i></span>';
                        echo $receivableInvoice.' '.$accuracyStatus.' '.$overdue;   

                    }       
                    else{
                        echo Html::a(
                            '<i class="glyphicon glyphicon-plus"></i> Buat', 
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
    <td>
        <?= $checkLabel; ?>
    </td>
</tr>

