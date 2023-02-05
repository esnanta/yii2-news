<?php

use yii\helpers\Html;
use yii\widgets\ListView;


/* @var $this yii\web\View */
/* @var $model backend\models\Receivable */

$this->title = 'Penerimaan #'.$model->invoice;
$this->params['breadcrumbs'][] = ['label' => 'Receivable', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$formatter = Yii::$app->formatter;
?>



<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab">Penerimaan Pembayaran
            <?= (!empty($model->invoice)) ? '<span class="label label-primary">' . $model->invoice . '</span>' : ''; ?></a>
        </li>
        <div class="pull pull-right" style="margin-top: 5px">
            <?=             
             Html::a('Invoice', 
                ['invoice', 'id' => $model->id],
                [
                    'class' => 'btn btn-success',
                    'target' => '_blank',
                    'data-toggle' => 'tooltip',
                    'title' => 'Will open the generated PDF file in a new window'
                ]
            )?>            
            <?= Html::a('Create', ['/billing/select','module'=>'receivable'], ['class' => 'btn btn-primary']) ?>
            <?php //Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ])
            ?>            
        </div>
    </ul>
    
    <div class="tab-content">
        <div class="tab-pane active" id="tab_1">
            <div class="row">
                <div class="col-md-12">

                    <div class="row ">
                        <div class="col-sm-4">
                            
                            <table class="table table-striped">
                                <tr>
                                    <td><?=$model->customer->getAttributeLabel('title');?></td>
                                    <td>
                                        <strong>
                                            [ <?=Html::a(
                                                    $enrolment->title,
                                                    Yii::$app->getUrlManager()->createUrl([
                                                        'enrolment/view',
                                                        'id' => $enrolment->id,
                                                        'title' => $model->title])
                                            );
                                            ?> ]
                                            <?=Html::a(
                                                    $model->customer->title . '</span>',
                                                    Yii::$app->getUrlManager()->createUrl([
                                                        'customer/view',
                                                        'id' => $model->customer_id,
                                                        'title' => $model->customer->title])
                                            );
                                            ?>                
                                        </strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?= $model->customer->getAttributeLabel('phone_number'); ?></td>
                                    <td><?= $model->customer->phone_number; ?></td>
                                </tr>
                                <tr>
                                    <td><?=$enrolment->getAttributeLabel('billing_cycle');?></td>
                                    <td>JTO <?= $enrolment->billing_cycle; ?> / bulan</td>
                                </tr>                                
                            </table>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 ">

                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 ">
                            <table class="table table-striped">                               
                                <tr>
                                    <td><?= $model->customer->getAttributeLabel('address'); ?></td>
                                </tr>
                                <tr>
                                    <td><?= $model->customer->address; ?></td>
                                </tr>                                
                            </table>                            
                        </div>
                        <!-- /.col -->
                    </div>                    

                    <br>

                    <table class="table table-striped">

                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Periode</th>
                            <th>Tgl JTO</th>
                            <th>Telat</th>
                            <th>Akurasi</th>
                            <th>Jenis</th>                            
                            <th>Tagihan</th>
                            <th>Denda</th>
                            <th>Total</th>
                        </tr>

                        <?=
                        ListView::widget([
                            'dataProvider' => $providerReceivableDetail,
                            'summary' => '',
                            'itemView' => '_view_grid',
                        ]);
                        ?> 

                    </table>

                    <br>
                    <br>

                    <div class="row">
                        <!-- accepted payments column -->
                        <div class="col-xs-4">
                            
                            <b>Invoice #<?= $model->invoice; ?></b><br>
                            <br>
                            <b>Date:</b> <?= Yii::$app->formatter->format($model->date_issued, 'date'); ?><br>
                            <b>Issued By:</b> <?= $model->staff->title; ?><br>                                
                                
                                <br>
                                <br>
                                
                                <b><?= $model->getAttributeLabel('created_by')?> : </b> <?=\backend\models\User::getName($model->created_by);?><br>
                                <b><?= $model->getAttributeLabel('created_at')?> : </b> <?=Yii::$app->formatter->format($model->created_at,'date');?><br>
                                
                                                            
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-4">
                        </div>
                        <div class="col-xs-4">
                            <p class="lead">Summary</p>

                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <th style="width:50%">Tagihan</th>
                                        <td><?= $formatter->asDecimal($model->claim); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Tambahan</th>
                                        <td><?= $formatter->asDecimal($model->surcharge); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Total:</th>
                                        <td><?= $formatter->asDecimal($model->total); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Diskon</th>
                                        <td><?= $formatter->asDecimal($model->discount); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Bayar</th>
                                        <td><?= $formatter->asDecimal($model->payment); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Balance</th>
                                        <td><?= $formatter->asDecimal($model->balance); ?></td>
                                    </tr>                    
                                </table>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>                 


                </div>
            </div>
        </div>
    </div>
    
    
    
</div>


