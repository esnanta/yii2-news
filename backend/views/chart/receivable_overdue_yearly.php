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
                Chart Receivable Overdue
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
            $lookupOverdue  = $cacheCloud->getLookupToken(Yii::$app->params['LookupToken_Overdue']);  
            $lookupOnTime   = $cacheCloud->getLookupToken(Yii::$app->params['LookupToken_OnTime']);  
            
            echo '<div class="row">';
                foreach ($monthList as $i=>$monthListData) {

                    $month = $i+1;
                    $monthPeriod = (strlen($month) > 1) ?  $month : '0'.$month;

                    $linkBillingOverdue = Html::a('<i class="fa fa-print"></i>', [
                        'report-receivable/period','month'=>$monthPeriod.$model->option_year,
                        'attribute' => 'overdue_status',
                        'value' => $lookupOverdue
                    ]);

                    $linkBillingOnTime = Html::a('<i class="fa fa-print"></i>', [
                        'report-receivable/period','month'=>$monthPeriod.$model->option_year,
                        'attribute' => 'overdue_status',
                        'value' => $lookupOnTime
                    ]);

                    echo '<div class="col-md-4">';
        ?>

                    <h3><?= ucfirst($monthListData).' '.$model->option_year;?></h3>
                    <table class="table table-hover">
                        <tr>
                            <td>Telat</td>
                            <td><?= $linkBillingOverdue;?> <span class="label label-danger"><?= $datasetOverdue[$i];?></span></td>
                        </tr>
                        <tr>
                            <td>Cermat</td>
                            <td><?= $linkBillingOnTime;?> <span class="label label-primary"><?= $datasetOnTime[$i];?></span></td>
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
                                        'data' => [$datasetOverdue[$i],$datasetOnTime[$i]],
                                        'backgroundColor' => ['red', 'blue'],

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
