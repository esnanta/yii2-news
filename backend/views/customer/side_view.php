<?php

use yii\helpers\Html;
use backend\models\OutletDetail;
use backend\models\Enrolment;

$formatter = \Yii::$app->formatter;
?>

<?php if(!empty($customer)) { ?>
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title"><i class="glyphicon glyphicon-user"></i> Bio Pelanggan</h3>
            <span class="pull pull-right"><?=Html::a('<i class="glyphicon glyphicon-eye-open"></i>', $customer->getUrl());?></span>
        </div>
        <!-- /.box-header -->
        <div class="box-body no-padding">
            <table class="table table-striped">
                <tr>
                    <td><?=$customer->getAttributeLabel('title')?></td>
                    <td>
                        <?=($customer->id!=null) ? $customer->title:'';?>
                    </td>
                </tr>
                <tr>
                    <td><?=$customer->getAttributeLabel('phone_number')?></td>
                    <td>
                        <?=$customer->phone_number;?>
                    </td>
                </tr> 
                <tr>
                    <td><?=$customer->getAttributeLabel('village_id')?></td>
                    <td>
                        <?=($customer->village_id!=null) ? Html::a($customer->village->title, $customer->village->getUrl()):'';?>
                    </td>
                </tr>  
                <tr>
                    <td><?=$customer->getAttributeLabel('address')?></td>
                    <td>
                        <?=$customer->address;?>
                    </td>
                </tr>                                             
            </table>
        </div>
    </div>

<?php } ?>



<?php if(!empty($enrolment)) { 
    $tmpOutletDetailDeviceStatus = OutletDetail::getDeviceByCustomer($enrolment->customer_id);
    $outletDetailDeviceStatus = OutletDetail::getOneDeviceStatus($tmpOutletDetailDeviceStatus);
    
    
    $updateDigital = ($enrolment->enrolment_type==Enrolment::ENROLMENT_TYPE_ANALOG) ?
            Html::a('<i class="fa fa-cloud-upload"></i>',
                    Yii::$app->urlManager->createUrl(['service/create', 
                        'id' => $enrolment->customer_id,
                        'type' => backend\models\Service::SERVICE_TYPE_CHANGE_TO_DIGITAL,
                        'title' => 'Update Digital']),
            [
                'title' => Yii::t('yii', 'Update Digital'),
                'class'=>'label label-success',
            ])

            :

            '';
    
    
?>

    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title"><i class="glyphicon glyphicon-facetime-video"></i> Info Langganan</h3>
            <span class="pull pull-right">
                <?=Html::a('<i class="glyphicon glyphicon-pencil"></i>', Yii::$app->getUrlManager()->createUrl(['enrolment/update','id'=>$enrolment->id,'title'=>$enrolment->customer->title]));?>&nbsp;&nbsp;
                <?=Html::a('<i class="glyphicon glyphicon-eye-open"></i>', $enrolment->getUrl());?>
            </span>
        </div>
        <!-- /.box-header -->
        <div class="box-body no-padding">
            <table class="table table-striped">
                <tr>
                    <td><?= $enrolment->getAttributeLabel('title') ?></td>
                    <td>
                        <?= ($enrolment->title != null) ? $enrolment->title . ' <span class="pull pull-right">' . $outletDetailDeviceStatus.'</span>': ''; ?>
                    </td>
                </tr>
                <tr>
                    <td><?= $enrolment->getAttributeLabel('enrolment_type') ?></td>
                    <td>
                        <?= ($enrolment->enrolment_type != null) ? $enrolment->getOneEnrolmentType($enrolment->enrolment_type) : ''; ?>
                        <?= ($updateDigital!= null) ? '<span class="pull-right">'.$updateDigital.'</span>':''; ?>
                    </td>
                </tr>
                
                <?php if($enrolment->enrolment_type==Enrolment::ENROLMENT_TYPE_DIGITAL){?>
                    <tr>
                        <td><?= $enrolment->getAttributeLabel('date_start') ?></td>
                        <td>
                            <?= date("d-m-Y", $enrolment->date_start); ?> 
                        </td>
                    </tr> 
                    <tr>
                        <td><?= $enrolment->getAttributeLabel('date_end') ?></td>
                        <td>
                            <?= date("d-m-Y", $enrolment->date_end); ?> 
                        </td>
                    </tr> 
                <?php } ?>
                <tr>
                    <td><?= $enrolment->getAttributeLabel('network_id') ?></td>
                    <td>
                        <?= ($enrolment->network_id != null) ? Html::a($enrolment->network->title, $enrolment->network->getUrl()) : ''; ?>
                    </td>
                </tr>   
                <tr>
                    <td>Outlet Aktif</td>
                    <td>
                        <?= $formatter->asDecimal($enrolment->countDeviceActive()); ?>
                    </td>
                </tr>      
                <tr>
                    <td>Iuran Bulanan</td>
                    <td>
                        <?= $formatter->asDecimal($enrolment->customer->sumMonthlyBill()); ?>
                    </td>
                </tr>                 
                <tr>
                    <td><?= $enrolment->getAttributeLabel('billing_cycle') ?></td>
                    <td>
                        <?= $enrolment->billing_cycle . ' / bulan'; ?>
                    </td>
                </tr>  
                <tr>
                    <td><?= $enrolment->getAttributeLabel('date_effective') ?></td>
                    <td>
                        <?= Yii::$app->formatter->format($enrolment->date_effective, 'date'); ?>
                    </td>
                </tr>  
            </table>
        </div>
    </div>

<?php } ?>