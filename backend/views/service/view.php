<?php

use yii\helpers\Html;
use yii\widgets\ListView;


/* @var $this yii\web\View */
/* @var $model backend\models\Service */

$this->title = 'Service #'.$model->invoice;
$this->params['breadcrumbs'][] = ['label' => 'Service', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$formatter = Yii::$app->formatter;
?>

<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab">Service
            <?= (!empty($model->invoice)) ? '<span class="label label-primary">' . $model->invoice . '</span>' : ''; ?></a>
        </li>
        <div class="pull pull-right" style="margin-top: 5px">
            <?= 
                Html::a('Pembayaran', 
                    ['/receivable/create','id'=>$model->customer_id,'title'=>$model->customer->title], 
                    ['class' => 'btn btn-warning']) 
            ?>
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
            <?= Html::a('Create', ['/enrolment/select','module'=>'service'], ['class' => 'btn btn-primary']) ?>
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
                                            [ <?=Html::a($enrolment->title, $enrolment->getUrl());?> ]
                                            <?=Html::a($model->customer->title . '</span>', $model->customer->getUrl()); ?>
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
                                    <td>Jenis <span class="pull pull-right"><?= $model->getOneServiceType($model->service_type); ?></span></td>
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
                            <th>Remark</th>
                            <th>Status</th>
                            <th>Iuran</th>
                            <th>Kategori</th>
                        </tr>

                        <?=
                        ListView::widget([
                            'dataProvider' => $providerServiceDetail,
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

                            <b>Issued:</b> <?= Yii::$app->formatter->format($model->date_issued, 'date'); ?><br>
                            <b>Issued By:</b> <?= $model->staff->title; ?><br>

                            <br>
                            <br>

                            <b><?= $model->getAttributeLabel('created_by')?> : </b> <?=\backend\models\User::getName($model->created_by);?><br>
                            <b><?= $model->getAttributeLabel('created_at')?> : </b> <?=Yii::$app->formatter->format($model->created_at,'date');?><br>


                        </div>
                        <!-- /.col -->
                        <div class="col-xs-4">
                            <?php if($model->service_type != backend\models\Service::SERVICE_TYPE_GENERAL){?>
                                <b>Jenis:</b> <?= $model->getOneServiceType($model->service_type); ?><br>
                                <b>Mulai:</b> <?= Yii::$app->formatter->asDate($model->date_start, 'dd-MM-yyyy'); ?><br>
                                <b>Selesai:</b> <?= Yii::$app->formatter->asDate($model->date_end, 'dd-MM-yyyy'); ?><br>
                            <?php } ?>
                            <b>Berlaku:</b> <?= Yii::$app->formatter->format($model->date_issued, 'date'); ?><br>
                            <b>Deskripsi:</b><br>
                            <?= $model->description; ?>
                        </div>
                        <div class="col-xs-4">
                            <p class="lead">Summary</p>

                            <div class="table-responsive">
                                <table class="table">
                                    <?php if($model->service_type != backend\models\Service::SERVICE_TYPE_GENERAL){?>
                                        <tr>
                                            <th>Tagihan</th>
                                            <td><?= $formatter->asDecimal($model->claim); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Biaya</th>
                                            <td><?= $formatter->asDecimal($model->surcharge); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Total</th>
                                            <td><?= $formatter->asDecimal($model->total); ?></td>
                                        </tr>
                                    <?php } ?>
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


