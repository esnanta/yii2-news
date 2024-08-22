<?php
use yii\helpers\Html;
use common\helper\CacheUseCase;
use dosamigos\chartjs\ChartJs;
/* @var $this yii\web\View */

$this->title = 'Charts';
?>

<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">
            Chart
            <div class="pull-right">
                Chart Validity Billing
            </div>
        </div>
    </div>
    <div class="panel-body">

        <?=
            $this->render('form/_form_yearly', [
                'model'=>$model,
                'yearList'=>$yearList,
            ]);
        ?>

        <hr>


        <?php
            
            $cacheCloud     = new CacheUseCase();
            $lookupYes      = $cacheCloud->getLookupToken(Yii::$app->params['LookupToken_YES']);  
            $lookupNo       = $cacheCloud->getLookupToken(Yii::$app->params['LookupToken_NO']);      
            
            echo '<div class="row">';
                foreach ($monthList as $i=>$monthListData) {

                    $month = $i+1;
                    $monthPeriod = (strlen($month) > 1) ?  $month : '0'.$month;

                    $linkBillingYes = Html::a('<i class="fa fa-print"></i>', [
                        'report-validity/period','month'=>$monthPeriod.$model->option_year,
                        'attribute' => 'billing_status',
                        'value' => $lookupYes
                    ]);

                    $linkBillingNo = Html::a('<i class="fa fa-print"></i>', [
                        'report-validity/period','month'=>$monthPeriod.$model->option_year,
                        'attribute' => 'billing_status',
                        'value' => $lookupNo
                    ]);

                    echo '<div class="col-md-4">';
        ?>

                    <h3><?= ucfirst($monthListData).' '.$model->option_year;?></h3>
                    <table class="table table-hover">
                        <tr>
                            <td>Sudah Dibuat</td>
                            <td><?= $linkBillingYes;?> <span class="label label-primary"><?= $datasetYes[$i];?></span></td>
                        </tr>
                        <tr>
                            <td>Belum Dibuat</td>
                            <td><?= $linkBillingNo;?> <span class="label label-danger"><?= $datasetNo[$i];?></span></td>
                        </tr>
                    </table>
                    <?php
                        echo ChartJs::widget([
                            'type' => 'pie',
                            'data' => [
                                //'labels' => ['Sudah','Belum'],
                                'datasets' => [
                                    [
                                        'label' => 'level',
                                        'data' => [$datasetYes[$i],$datasetNo[$i]],
                                        'backgroundColor' => ['blue', 'red'],

                                    ],
                                ],
                            ],
                        ]);
                    echo '</div>';
                }
            echo '</div>';

        ?>

        <hr>

    </div>
</div>
