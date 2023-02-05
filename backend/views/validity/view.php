<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\select2\Select2;
use yii\bootstrap\Progress;
/**
 * @var yii\web\View $this
 * @var backend\models\Validity $model
 */

$this->title = 'Validasi '.$model->title;
$this->params['breadcrumbs'][] = ['label' => 'Validities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$reset = Html::a('<i class="glyphicon glyphicon-refresh"></i> Reset', ['reset','id'=>$model->id], ['class' => 'pull-right btn btn-warning','style'=>'padding:0 5px']);
?>
<?php
$total = backend\models\OutletDetail::find()->select('customer_id, device_status')->where([
                            'device_status' => \backend\models\OutletDetail::DEVICE_STATUS_ACTIVE]);
        echo $total->asArray()->distinct()->count();

?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Summary</h3>
        <div class="pull pull-right">
            <?=
                Html::a('<i class="glyphicon glyphicon-list"></i> ' . 'List Validasi ('.$model->title.')',
                    ['/validity-detail/index','validityId'=>$model->id],
                    [
                        'class' => 'btn btn-primary',
                        'data-toggle' => 'tooltip',
                        'title' => 'Index Validity Detail'
                    ]
                );
            ?>
            <?=
                Html::a('<i class="glyphicon glyphicon-trash"></i> ' . 'Delete Validasi ('.$model->title.')',
                    ['delete-batch','id'=>$model->id],
                    [
                        'class' => 'btn btn-primary',
                        'data-toggle' => 'tooltip',
                        'title' => 'Delete Validasi Detail yang Belum Dibuat Tagihan'
                    ]
                );
            ?>
            <?=
                Html::a('<i class="glyphicon glyphicon-hand-up"></i> ' . 'Create Validasi (1)',
                    ['/enrolment/select','module'=>'validity-detail'],
                    [
                        'class' => 'btn btn-primary',
                        'data-toggle' => 'tooltip',
                        'title' => 'Create Validity'
                    ]
                );
            ?>
            <?=
                Html::a('<i class="glyphicon glyphicon-refresh"></i> ' . 'Create Validasi ('.Yii::$app->params['Data_Query_Limit'].')',
                    ['batch','id'=>$model->id],
                    [
                        'class' => 'btn btn-primary',
                        'data-toggle' => 'tooltip',
                        'title' => 'Create Batch Validity ('.Yii::$app->params['Data_Query_Limit'].')'
                    ]
                );
            ?>
        </div>
    </div>

    <div class="box box-body">
        <div class="validity-view">

            <?= DetailView::widget([
                'model' => $model,
                'condensed' => false,
                'hover' => true,
                'mode' => Yii::$app->request->get('edit') == 't' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
                'panel' => [
                    'heading' => $this->title.$reset,
                    'type' => DetailView::TYPE_PRIMARY,
                ],
                'attributes' => [

                    [
                        'attribute'=>'title',
                        'value'=>($model->title!=null) ? $model->title:'',
                        'type'=>DetailView::INPUT_SELECT2,
                        'options' => ['id' => 'title', 'prompt' => '', 'disabled'=>true],
                        'items' => $monthPeriodList,
                        'widgetOptions'=>[
                            'class'=> Select2::className(),
                            'data'=>$monthPeriodList,
                        ]
                    ],
                    'counter',
                    [
                        'attribute'=>'description',
                        'format'=>'html',
                        'type'=>DetailView::INPUT_HIDDEN,
                    ],
                    [
                        'attribute'=>'created_at',
                        'format'=>'date',
                        'type'=>DetailView::INPUT_HIDDEN,
                    ],
                    [
                        'attribute'=>'updated_at',
                        'format'=>'date',
                        'type'=>DetailView::INPUT_HIDDEN,
                    ],
                ],
                'deleteOptions' => [
                    'url' => ['delete', 'id' => $model->id],
                ],
                'buttons1' => '{update}',
                'enableEditMode' => Yii::$app->user->can('update-validity'),
            ]) ?>


            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="panel-title">
                        PROGRESS
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-hover">
                        <tr>
                            <th style="width:20%">Deskripsi</th>
                            <th style="width:50%">Keadaan</th>
                            <th style="width:30%">Status</th>
                        </tr>

                        <!--/////////////////////////////////////////////////////////////-->
                        <!--PERIODE BERJALAN-->

                        <?php
                            if($model->title == $currMonthPeriod){
                        ?>
                            <tr>
                                <td>
                                    Periode Berjalan
                                </td>
                                <td>
                                    <div class="label label-default"><?= $currMonthPeriod ?></div>

                                    <p class="help-block">
                                        Outlet dianggap valid berdasarkan status aktif, gratis,
                                        atau dc sementara per periode berjalan. Pada periode yang lain, jumlah
                                        bisa berbeda.
                                    </p>
                                </td>
                                <td>
                                    <?=
                                        Progress::widget([
                                            'bars' => [
                                                ['percent' => 50, 'label' => ($countOutletActive).' Outlet Aktif', 'options' => ['class' => 'progress-bar-info']],
                                                ['percent' => 50, 'label' => ($countCustomerActive).' Pelanggan Aktif', 'options' => ['class' => 'progress-bar-primary']],
                                            ]
                                        ]);
                                    ?>
                                </td>
                            </tr>
                        <?php
                            }
                        ?>

                        <!--/////////////////////////////////////////////////////////////-->
                        <tr>
                            <td>
                                Telah Divalidasi <span class="label label-default"><?= $countDeviceStatusActive+$countDeviceStatusFree+$countDeviceStatusIdle ?></span>
                            </td>
                            <td>
                                <div class="label label-success">Gratis (<?= $countDeviceStatusFree ?>)</div>
                                <div class="label label-warning">Dc Sementara (<?= $countDeviceStatusIdle ?>)</div>
                                <div class="label label-primary">Aktif (<?= $countDeviceStatusActive?>)</div>
                                <p class="help-block">
                                    Pelanggan dianggap valid jika memiliki sekurang-kurangnya 1 outlet aktif, gratis, ataupun dc sementara.
                                    Jumlah pelanggan dan outlet aktif tidak sama, karena satu pelanggan bisa memiliki lebih dari satu outlet.
                                </p>
                            </td>
                            <td>
                                <p><?= $linkDeviceFree;?> Gratis <span class="label label-success pull-right"><?=$percentDeviceStatusFree;?>%</span></p>
                                <p><?= $linkDeviceIdle;?> Dc Sementara <span class="label label-warning pull-right"><?=$percentDeviceStatusIdle;?>%</span></p>
                                <p><?= $linkDeviceActive;?> Aktif <span class="label label-primary pull-right"><?=$percentDeviceStatusActive;?>%</span></p>
                            </td>
                        </tr>

                        <!--/////////////////////////////////////////////////////////////-->
                        <tr>
                            <td>
                                Status Tagihan <span class="label label-default"><?= $countBillingStatusNo+$countBillingStatusYes ?></span>
                            </td>
                            <td>
                                <div class="label label-danger">Belum (<?= $countBillingStatusNo ?>)</div>
                                <div class="label label-primary">Sudah (<?= $countBillingStatusYes ?>)</div>
                                <p class="help-block">
                                    Status tagihan adalah jumlah tagihan yang telah atau belum dibuat
                                    berdasarkan validasi pelanggan aktif.
                                </p>
                            </td>
                            <td>
                                <p><?= $linkBillingNo;?> Belum Dibuat <span class="label label-danger pull-right"><?=$percentBillingStatusNo;?>%</span></p>
                                <p><?= $linkBillingYes;?> Sudah Dibuat <span class="label label-primary pull-right"><?=$percentBillingStatusYes;?>%</span></p>
                                <p>
                                    <?=Html::a('<i class="glyphicon glyphicon-triangle-right"></i> Buat Tagihan ('.$countBillingStatusNo.')', ['/billing/review','month'=>$model->title], ['class' => ''])?>
                                </p>
                            </td>
                        </tr>


                        <!--/////////////////////////////////////////////////////////////-->
                        <tr>
                            <td>
                                Dispensasi Tagihan <span class="label label-default"><?= $countDeviceStatusFree+$countDeviceStatusIdle ?></span>
                            </td>
                            <td>
                                <div class="label label-success">Gratis (<?= $countDeviceStatusFree ?>)</div>
                               <div class="label label-warning">Dc Sementara (<?= $countDeviceStatusIdle ?>)</div>
                                <p class="help-block">
                                    Status validasi outlet yang tidak dibuat tagihannya (gratis & dc sementara).
                                </p>
                            </td>
                            <td>
                                <p><?= $linkDeviceFree;?> Gratis <span class="label label-success pull-right"><?=$percentBillingDispensationFree;?>%</span></p>
                                <p><?= $linkDeviceIdle;?> Dc Sementara <span class="label label-warning pull-right"><?=$percentBillingDispensationIdle;?>%</span></p>
                            </td>
                        </tr>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>