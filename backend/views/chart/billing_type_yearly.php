<?php
use yii\helpers\Html;
use common\helper\CacheCloud;
use dosamigos\chartjs\ChartJs;
/* @var $this yii\web\View */

$this->title = 'Charts';

?>

<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">
            Chart Jenis Tagihan            
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
        
            $cacheCloud     = new CacheCloud();
            $lookupNew      = $cacheCloud->getLookupToken(Yii::$app->params['LookupToken_BillingTypeNew']);  
            $lookupParalel  = $cacheCloud->getLookupToken(Yii::$app->params['LookupToken_BillingTypeParalel']);  
            $lookupMoving   = $cacheCloud->getLookupToken(Yii::$app->params['LookupToken_BillingTypeMoving']);  
            $lookupMonthly  = $cacheCloud->getLookupToken(Yii::$app->params['LookupToken_BillingTypeMonthly']);  
            
            echo '<div class="row">';
                foreach ($monthList as $i=>$monthListData) {
                    $month = $i+1;
                    $monthPeriod = (strlen($month) > 1) ?  $month : '0'.$month;       

                    $linkBillingNew = Html::a('<i class="fa fa-print"></i>', [
                        'report-billing/period','month'=>$monthPeriod.$model->option_year,
                        'attribute' => 'billing_type',
                        'value' => $lookupNew
                    ]);
                    
                    $linkBillingParalel = Html::a('<i class="fa fa-print"></i>', [
                        'report-billing/period','month'=>$monthPeriod.$model->option_year,
                        'attribute' => 'billing_type',
                        'value' => $lookupParalel
                    ]);                    
                    
                    $linkBillingMoving = Html::a('<i class="fa fa-print"></i>', [
                        'report-billing/period','month'=>$monthPeriod.$model->option_year,
                        'attribute' => 'billing_type',
                        'value' => $lookupMoving
                    ]);   
                    
                    
                    $linkBillingMonthly = Html::a('<i class="fa fa-print"></i>', [
                        'report-billing/period','month'=>$monthPeriod.$model->option_year,
                        'attribute' => 'billing_type',
                        'value' => $lookupMonthly
                    ]);                     
                    
                    echo '<div class="col-md-4">';
        ?>                    
                    
                    <h3><?= ucfirst($monthListData).' '.$model->option_year;?></h3>
                    <table class="table table-hover">
                        <tr>
                            <td><strong>Pasang Baru</strong></td>
                            <td><?= $linkBillingNew?> <span class="label label-danger"><?= $datasetBillingTypeNew[$i];?></span></td>
                        </tr>
                        <tr>
                            <td><strong>Pasang Paralel</strong></td>
                            <td><?= $linkBillingParalel?> <span class="label label-warning"><?= $datasetBillingTypeParalel[$i];?></span></td>
                        </tr>     
                        <tr>
                            <td><strong>Pasang Pindah</strong></td>
                            <td><?= $linkBillingMoving?> <span class="label label-success"><?= $datasetBillingTypeMoving[$i];?></span></td>
                        </tr>    
                        <tr>
                            <td><strong>Iuran Bulanan</strong></td>
                            <td><?= $linkBillingMonthly?> <span class="label label-primary"><?= $datasetBillingTypeMonthly[$i];?></span></td>
                        </tr>                         
                    </table>  
        <?php            
                    
                        echo ChartJs::widget([
                            'type' => 'pie',
                            'data' => [
                                //'labels' => ['Pasang Baru '.$datasetBillingTypeNew[$i],'Pasang Paralel','Pasang Pindah','Iuran Bulanan'],
                                'datasets' => [
                                    [
                                        'label' => 'level',
                                        'data' => [$datasetBillingTypeNew[$i],$datasetBillingTypeParalel[$i],$datasetBillingTypeMoving[$i],$datasetBillingTypeMonthly[$i]],
                                        'backgroundColor' => ['red', 'yellow','green', 'blue'],

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
