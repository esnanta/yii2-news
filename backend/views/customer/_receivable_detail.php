<?php
use yii\helpers\Html;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$countReceivableDetailOnTime    = count($receivableDetailOnTime);
$countReceivableDetailOverdue   = count($receivableDetailOverdue);
$countReceivableDetail          = $countReceivableDetailOnTime + $countReceivableDetailOverdue;
?>

<li>
    <!-- timeline icon -->
    <i class="fa fa-money bg-blue"></i>
    <div class="timeline-item">
        <span class="time">
            <i class="fa fa-info-circle"></i> 
                Data : 
                <?=
                    ($countBillingPaidOff > $countReceivableDetail) ? 
                        Html::a('<i class="glyphicon glyphicon-warning-sign"></i> Perbaiki', ['customer/fix','id'=>$customer->id], ['class' => 'btn btn-block btn-danger btn-sm']) : 
                        '<i class="glyphicon glyphicon-ok"></i> Ok';
                ?>                                                 
                /
                On Time <?= $countReceivableDetailOnTime;?> / 
                Overdue <?= $countReceivableDetailOverdue;?> /
                Total <?= $countReceivableDetail;?>
        </span>
                    
        <h3 class="timeline-header">Penerimaan</h3>

        <div class="timeline-body">
            <dl>
                <dt>On Time</dt>
                <dd><p>
                        <?php
                            $cache              = Yii::$app->cache;
                            $cacheLookup        = Yii::$app->params['Cache_Lookup'];                         
                            $formatter          = Yii::$app->formatter;
                            
                            foreach ($receivableDetailOnTime as $detailModel) {
                                
                                $lookupId = $detailModel->billing->billing_type;
                                $billingType =(!empty($lookupId)) ? 
                                    $cache->getOrSet($cacheLookup.$lookupId, function () use ($lookupId) { 
                                        return backend\models\Lookup::getTitleById($lookupId);
                                }) : '-';                              

                                $link = Html::a('<i class="fa fa-eye"></i>', $detailModel->receivable->getUrl(),['style'=>'color:white']);
                                echo '<span class="label label-success">'
                                .str_replace('Tagihan', '', $billingType).' '.$detailModel->billing->month_period.' '.$link
                                .'</span>- ';                                
                            }
                        ?>
                    </p>
                </dd>
                
                <dt>Ovedue</dt>
                <dd><p>
                        <?php
                            foreach ($receivableDetailOverdue as $detailModel) {
                                $lookupId = $detailModel->billing->billing_type;
                                $billingType =(!empty($lookupId)) ? 
                                    $cache->getOrSet($cacheLookup.$lookupId, function () use ($lookupId) { 
                                        return backend\models\Lookup::getTitleById($lookupId);
                                }) : '-';                                  
                                
                                $link = Html::a('<i class="fa fa-eye"></i>', $detailModel->receivable->getUrl());
                                
                                $penalty = (empty($detailModel->penalty)) ? 0 : $detailModel->penalty;
                                echo '<span class="label label-default">'
                                .str_replace('Tagihan', '', $billingType).' '.$detailModel->billing->month_period.' ('.$detailModel->overdue.' hari) '
                                .'Denda '.$formatter->asDecimal($penalty).' '.$link
                                .'</span>- ';                                
                            }
                        ?>                        
                    </p>
                </dd>                        
            </dl>
        </div>

    </div>
</li>