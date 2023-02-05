<?php
use yii\helpers\Html;
use common\helper\Helper;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



?>
<li>
    <!-- timeline icon -->
    <i class="fa fa-pencil bg-blue"></i>
    <div class="timeline-item">
        <span class="time"><i class="fa fa-calculator"></i> Tagihan <?= count($billings);?></span>

        <h3 class="timeline-header">Keadaan Tagihan</h3>

        <div class="timeline-body">
            <dl>
                <!--<dt>Tagihan Hutang / Cicilan</dt>-->
                <dd>
                    <p>
                        <span class="label label-default">Hijau = Lunas</span> 
                        <span class="label label-default">Kuning = Cicilan</span> 
                        <span class="label label-default">Merah = Hutang</span> 
                    </p>                    
                    <p>
                        <?php
                        
                            $cache              = Yii::$app->cache;
                            $cacheLookup        = Yii::$app->params['Cache_Lookup'];                         
                        
                            if(empty($billings)){
                                echo 'Tidak Ada';
                            }
                            else{
                                foreach ($billings as $detailModel) {
                                    $billingType =(!empty($detailModel['billing_type'])) ? 
                                        strip_tags(backend\models\Billing::getOneBillingType($detailModel['billing_type'])) : '-';                                      
                                    
                                    $link = Html::a('<i class="fa fa-eye"></i>', 
                                            ['billing/view', 'id' => $detailModel['id'], 'title' => $detailModel['title']],
                                            ['style'=>'color:white']);
                                    
                                    $overdueCounter = Helper::getOverdue(time(),$detailModel['date_due']);

                                    $label = 'default';
                                    
                                    if($detailModel['payment_status'] == $billingPaymentStatusCredit){
                                        $label = 'danger';
                                    }
                                    elseif($detailModel['payment_status'] == $billingPaymentStatusInstallment){
                                        $label = 'warning';
                                    }     
                                    elseif($detailModel['payment_status'] == $billingPaymentStatusPaid){
                                        $label = 'success';
                                    }        
                                    
                                    if($detailModel['billing_type'] <> $billingTypeMonthly){
                                        $label = 'info';
                                    }                                         

                                    echo '<span class="label label-'.$label.'">'
                                    .str_replace('Tagihan', '', $billingType).' '.$detailModel['month_period'].' '.$link
                                    .'</span>- ';
                                }                                                            
                            }
                        ?>
                    </p>
                </dd>
            </dl>
        </div>

    </div>
</li>