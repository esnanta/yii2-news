<?php
use yii\helpers\Html;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>

<li>
    <!-- timeline icon -->
    <i class="fa fa-calendar bg-blue"></i>
    <div class="timeline-item">
        <span class="time">
            <i class="fa fa-calendar-check-o"></i> 
                    Berlaku <?= Yii::$app->formatter->format($enrolment->date_effective, 'date'); ?> / 
                    Siklus <?= $enrolment->billing_cycle; ?> per bulan
        </span>

        <h3 class="timeline-header">Validasi Keaktifan</h3>

        <div class="timeline-body">
            <dl>
                
                <dd>
                    <p>
                        <span class="label label-default">Hijau = Sudah Dibuat Tagihan</span> 
                        <span class="label label-default">Merah = Belum Dibuat Tagihan</span> 
                        <span class="label label-default">Abu-abu = Tidak Perlu Dibuat Tagihan</span> 
                        <span class="label label-default">A = Aktif / F = Gratis / I = DC Sementara / D = DC Permanen</span> 
                    </p>
                    <p>
                        
                        <?php
                            if(empty($validityDetail)){
                                echo 'Tidak Ada';
                            }
                            else{
                                foreach ($validityDetail as $detailModel) {
                                    
                                    $link = Html::a('<i class="fa fa-eye"></i>', 
                                            ['validity-detail/view', 'id' => $detailModel['id'], 'title' => $detailModel['title']],
                                            ['style'=>'color:white']);                                    
                                    
                                    $labelBilling = 'default';
                                    
                                    if($detailModel['billing_status'] == $validityDetailBillingYes){
                                        $labelBilling = 'success';
                                    }
                                    elseif($detailModel['billing_status'] == $validityDetailBillingNo){
                                        $labelBilling = 'danger';
                                    }
                                    
                                    $labelDevice = 'default';
                                    $textDevice = '';
                                    if($detailModel['device_status'] == $validityDetailDeviceStatusActive){
                                        $labelDevice = 'primary';
                                        $textDevice = 'A';
                                    }
                                    elseif($detailModel['device_status'] == $validityDetailDeviceStatusFree){
                                        $labelDevice = 'success';
                                        $textDevice = 'F';
                                    }    
                                    elseif($detailModel['device_status'] == $validityDetailDeviceStatusIdle){
                                        $labelDevice = 'warning';
                                        $textDevice = 'I';
                                    }  
                                    elseif($detailModel['device_status'] == $validityDetailDeviceStatusDisconnect){
                                        $labelDevice = 'danger';
                                        $textDevice = 'D';
                                    }                                      
                                    
                                    echo '<span class="label label-'.$labelBilling.'">'.$detailModel['month_period'].' '.$link.'</span>'
                                            . '<span class="label label-'.$labelDevice.'">'.$textDevice.'</span>- ';
                                }                                                            
                            }
                        ?>                        
                        

                    </p>
                </dd>                
                
            </dl>
        </div>

    </div>
</li>