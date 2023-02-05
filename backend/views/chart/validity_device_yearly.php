<?php
use yii\helpers\Html;
use backend\models\Lookup;
use dosamigos\chartjs\ChartJs;
/* @var $this yii\web\View */

$this->title = 'Charts';

?>

<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">
            Chart
            <div class="pull-right">
                Chart Validity Device    
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
            echo '<div class="row">';
                foreach ($monthList as $i=>$monthListData) {
                    $month = $i+1;
                    $monthPeriod = (strlen($month) > 1) ?  $month : '0'.$month;       

                    $linkDeviceActive = Html::a('<i class="fa fa-print"></i>', [
                        'report-validity/period','month'=>$monthPeriod.$model->option_year,
                        'attribute' => 'device_status',
                        'value' => Lookup::getId(Yii::$app->params['LookupToken_DeviceStatusActive'])
                    ]);           
                    
                    $linkDeviceFree = Html::a('<i class="fa fa-print"></i>', [
                        'report-validity/period','month'=>$monthPeriod.$model->option_year,
                        'attribute' => 'device_status',
                        'value' => Lookup::getId(Yii::$app->params['LookupToken_DeviceStatusFree'])
                    ]);  
                    
                    $linkDeviceIdle = Html::a('<i class="fa fa-print"></i>', [
                        'report-validity/period','month'=>$monthPeriod.$model->option_year,
                        'attribute' => 'device_status',
                        'value' => Lookup::getId(Yii::$app->params['LookupToken_DeviceStatusIdle'])
                    ]);                          
                    
                    $linkDeviceDisconnect = Html::a('<i class="fa fa-print"></i>', [
                        'report-validity/period','month'=>$monthPeriod.$model->option_year,
                        'attribute' => 'device_status',
                        'value' => Lookup::getId(Yii::$app->params['LookupToken_DeviceStatusDisconnect'])
                    ]);  
                    
                    echo '<div class="col-md-4">';
        ?>                    
                    
                    <h3><?= ucfirst($monthListData).' '.$model->option_year;?></h3>
                    <table class="table table-hover">
                        <tr>
                            <td><strong>Aktif</strong></td>
                            <td><?= $linkDeviceActive ?> <span class="label label-primary"><?= $datasetDeviceActive[$i];?></span></td>
                        </tr>
                        <tr>
                            <td><strong>Gratis</strong></td>
                            <td><?= $linkDeviceFree ?> <span class="label label-success"><?= $datasetDeviceFree[$i];?></span></td>
                        </tr>     
                        <tr>
                            <td><strong>DC Sementara</strong></td>
                            <td><?= $linkDeviceIdle ?> <span class="label label-warning"><?= $datasetDeviceIdle[$i];?></span></td>
                        </tr>      
                         
                    </table>  
                <?php            
                    
                        echo ChartJs::widget([
                            'type' => 'pie',
                            'data' => [
                                //'labels' => ['Aktif','Gratis','DC Sementara'],
                                'datasets' => [
                                    [
                                        'label' => 'level',
                                        'data' => [$datasetDeviceActive[$i],$datasetDeviceFree[$i],$datasetDeviceIdle[$i]],
                                        'backgroundColor' => ['blue', 'green', 'yellow'],

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
