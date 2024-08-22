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
            Chart Penerimaan Tagihan            
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
        
            $cacheCloud         = new CacheUseCase();
            $lookupCredit       = $cacheCloud->getLookupToken(Yii::$app->params['LookupToken_PaymentStatusCredit']);  
            $lookupInstallment  = $cacheCloud->getLookupToken(Yii::$app->params['LookupToken_PaymentStatusInstallment']);  
            $lookupPaidOff      = $cacheCloud->getLookupToken(Yii::$app->params['LookupToken_PaymentStatusPaidOff']);  
              
            
            echo '<div class="row">';
                foreach ($monthList as $i=>$monthListData) {
                    
                    $month = $i+1;
                    $monthPeriod = (strlen($month) > 1) ?  $month : '0'.$month;       

                    $linkCredit = Html::a('<i class="fa fa-print"></i>', [
                        'report-billing/period','month'=>$monthPeriod.$model->option_year,
                        'attribute' => 'payment_status',
                        'value' => $lookupCredit
                    ]);
                    
                    $linkInstallment = Html::a('<i class="fa fa-print"></i>', [
                        'report-billing/period','month'=>$monthPeriod.$model->option_year,
                        'attribute' => 'payment_status',
                        'value' => $lookupInstallment
                    ]);                    
                    
                    $linkPaidOff = Html::a('<i class="fa fa-print"></i>', [
                        'report-billing/period','month'=>$monthPeriod.$model->option_year,
                        'attribute' => 'payment_status',
                        'value' => $lookupPaidOff
                    ]);                      
                    
                    echo '<div class="col-md-4">';
        ?>                    
                    
                    <h3><?= ucfirst($monthListData).' '.$model->option_year;?></h3>
                    <table class="table table-hover">
                        <tr>
                            <td><strong>Hutang</strong></td>
                            <td><?= $linkCredit;?> <span class="label label-danger"><?= $datasetCredit[$i];?></span></td>
                        </tr>
                        <tr>
                            <td><strong>Cicilan</strong></td>
                            <td><?= $linkInstallment;?> <span class="label label-warning"><?= $datasetInstallment[$i];?></span></td>
                        </tr>     
                        <tr>
                            <td><strong>Lunas</strong></td>
                            <td><?= $linkPaidOff;?> <span class="label label-primary"><?= $datasetPaidOff[$i];?></span></td>
                        </tr>                     
                    </table>  
        <?php            
                    
                        echo ChartJs::widget([
                            'type' => 'pie',
                            'data' => [
                                //'labels' => ['Hutang','Cicilan','Lunas'],
                                'datasets' => [
                                    [
                                        'label' => 'level',
                                        'data' => [$datasetCredit[$i],$datasetInstallment[$i],$datasetPaidOff[$i]],
                                        'backgroundColor' => ['red', 'yellow', 'blue'],

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
