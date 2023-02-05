<?php

/* @var $this yii\web\View */

$this->title = 'Charts';
use dosamigos\chartjs\ChartJs;
?>

<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">
            Please fill out the form below
            <div class="pull-right">
                Chart Layanan Outlet     
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
        
        <?= ChartJs::widget([
            'type' => 'line',
            'data' => [
                'labels' => $monthList,
                'datasets' => [
                    [
                        'label' => "Grafik Service Active",
                        'backgroundColor' => "rgba(0, 0, 255,0.2)",
                        'borderColor' => "rgba(0, 0, 255,1)",
                        'pointBackgroundColor' => "rgba(0, 0, 255,1)",
                        'pointBorderColor' => "#fff",
                        'pointHoverBackgroundColor' => "#fff",
                        'pointHoverBorderColor' => "rgba(0, 0, 255,1)",
                        'data' => $datasetActive
                    ],

                    [
                        'label' => "Grafik Service Free",
                        'backgroundColor' => "rgba(0, 255, 0, 0.2)",
                        'borderColor' => "rgba(0, 255, 0, 1)",
                        'pointBackgroundColor' => "rgba(0, 255, 0, 1)",
                        'pointBorderColor' => "#fff",
                        'pointHoverBackgroundColor' => "#fff",
                        'pointHoverBorderColor' => "rgba(0, 255, 0, 1)",
                        'data' => $datasetFree
                    ],                       
                    
                    [
                        'label' => "Grafik Service Not Active",
                        'backgroundColor' => "rgba(255, 255, 0, 0.2)",
                        'borderColor' => "rgba(255, 255, 0, 1)",
                        'pointBackgroundColor' => "rgba(255, 255, 0, 1)",
                        'pointBorderColor' => "#fff",
                        'pointHoverBackgroundColor' => "#fff",
                        'pointHoverBorderColor' => "rgba(255, 255, 0, 1)",
                        'data' => $datasetIdle
                    ],                    
                    
                    [
                        'label' => "Grafik Service Disconnect",
                        'backgroundColor' => "rgba(255, 0, 0, 0.2)",
                        'borderColor' => "rgba(255, 0, 0, 1)",
                        'pointBackgroundColor' => "rgba(255, 0, 0, 1)",
                        'pointBorderColor' => "#fff",
                        'pointHoverBackgroundColor' => "#fff",
                        'pointHoverBorderColor' => "rgba(255, 0, 0, 1)",
                        'data' => $datasetDisconnect
                    ],                    
                ]
            ]
        ]);
        ?>         
        
        <hr>
                      
        <div class="row">
            <div class="col-md-12">
                <h3>Tahun <?= $model->option_year;?> 
                </h3>
            </div>
            <div class="col-md-3">
                <table class="table table-hover">
                    <tr>
                        <td>
                            <?php echo DateTime::createFromFormat('!m', 1)->format('F'); // JAN ?>                            
                        </td>
                        <td><span class="label label-primary"><?= $datasetActive[0];?></span></td>
                        <td><span class="label label-success"><?= $datasetFree[0];?></span></td>
                        <td><span class="label label-warning"><?= $datasetIdle[0];?></span></td>
                        <td><span class="label label-danger"><?= $datasetDisconnect[0];?></span></td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo DateTime::createFromFormat('!m', 2)->format('F'); // FEB ?>                            
                        </td>
                        <td><span class="label label-primary"><?= $datasetActive[1];?></span></td>
                        <td><span class="label label-success"><?= $datasetFree[1];?></span></td>
                        <td><span class="label label-warning"><?= $datasetIdle[1];?></span></td>
                        <td><span class="label label-danger"><?= $datasetDisconnect[1];?></span></td>
                    </tr>     
                    <tr>
                        <td>
                            <?php echo DateTime::createFromFormat('!m', 3)->format('F'); // MAR ?>                            
                        </td>
                        <td><span class="label label-primary"><?= $datasetActive[2];?></span></td>
                        <td><span class="label label-success"><?= $datasetFree[2];?></span></td>
                        <td><span class="label label-warning"><?= $datasetIdle[2];?></span></td>
                        <td><span class="label label-danger"><?= $datasetDisconnect[2];?></span></td>
                    </tr>                     
                </table>                
            </div>
            <div class="col-md-3">
                <table class="table table-hover">
                    <tr>
                        <td>
                            <?php echo DateTime::createFromFormat('!m', 4)->format('F'); // APR ?>                            
                        </td>
                        <td><span class="label label-primary"><?= $datasetActive[3];?></span></td>
                        <td><span class="label label-success"><?= $datasetFree[3];?></span></td>
                        <td><span class="label label-warning"><?= $datasetIdle[3];?></span></td>
                        <td><span class="label label-danger"><?= $datasetDisconnect[3];?></span></td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo DateTime::createFromFormat('!m', 5)->format('F'); // MEI ?>                            
                        </td>
                        <td><span class="label label-primary"><?= $datasetActive[4];?></span></td>
                        <td><span class="label label-success"><?= $datasetFree[4];?></span></td>
                        <td><span class="label label-warning"><?= $datasetIdle[4];?></span></td>
                        <td><span class="label label-danger"><?= $datasetDisconnect[4];?></span></td>
                    </tr>     
                    <tr>
                        <td>
                            <?php echo DateTime::createFromFormat('!m', 6)->format('F'); // JUN ?>                            
                        </td>
                        <td><span class="label label-primary"><?= $datasetActive[5];?></span></td>
                        <td><span class="label label-success"><?= $datasetFree[5];?></span></td>
                        <td><span class="label label-warning"><?= $datasetIdle[5];?></span></td>
                        <td><span class="label label-danger"><?= $datasetDisconnect[5];?></span></td>
                    </tr>  
                </table>
            </div>
            <div class="col-md-3">
                <table class="table table-hover">
                    <tr>
                        <td>
                            <?php echo DateTime::createFromFormat('!m', 7)->format('F'); // JUL ?>                            
                        </td>
                        <td><span class="label label-primary"><?= $datasetActive[6];?></span></td>
                        <td><span class="label label-success"><?= $datasetFree[6];?></span></td>
                        <td><span class="label label-warning"><?= $datasetIdle[6];?></span></td>
                        <td><span class="label label-danger"><?= $datasetDisconnect[6];?></span></td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo DateTime::createFromFormat('!m', 8)->format('F'); // AUG ?>                            
                        </td>
                        <td><span class="label label-primary"><?= $datasetActive[7];?></span></td>
                        <td><span class="label label-success"><?= $datasetFree[7];?></span></td>
                        <td><span class="label label-warning"><?= $datasetIdle[7];?></span></td>
                        <td><span class="label label-danger"><?= $datasetDisconnect[7];?></span></td>
                    </tr>     
                    <tr>
                        <td>
                            <?php echo DateTime::createFromFormat('!m', 9)->format('F'); // SEP ?>                            
                        </td>
                        <td><span class="label label-primary"><?= $datasetActive[8];?></span></td>
                        <td><span class="label label-success"><?= $datasetFree[8];?></span></td>
                        <td><span class="label label-warning"><?= $datasetIdle[8];?></span></td>
                        <td><span class="label label-danger"><?= $datasetDisconnect[8];?></span></td>
                    </tr>  
                </table>                
            </div>
            <div class="col-md-3">
                <table class="table table-hover">
                    <tr>
                        <td>
                            <?php echo DateTime::createFromFormat('!m', 10)->format('F'); // OKT ?>                            
                        </td>
                        <td><span class="label label-primary"><?= $datasetActive[9];?></span></td>
                        <td><span class="label label-success"><?= $datasetFree[9];?></span></td>
                        <td><span class="label label-warning"><?= $datasetIdle[9];?></span></td>
                        <td><span class="label label-danger"><?= $datasetDisconnect[9];?></span></td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo DateTime::createFromFormat('!m', 11)->format('F'); // NOV ?>                            
                        </td>
                        <td><span class="label label-primary"><?= $datasetActive[10];?></span></td>
                        <td><span class="label label-success"><?= $datasetFree[10];?></span></td>
                        <td><span class="label label-warning"><?= $datasetIdle[10];?></span></td>
                        <td><span class="label label-danger"><?= $datasetDisconnect[10];?></span></td>
                    </tr>     
                    <tr>
                        <td>
                            <?php echo DateTime::createFromFormat('!m', 12)->format('F'); // DES ?>                            
                        </td>
                        <td><span class="label label-primary"><?= $datasetActive[11];?></span></td>
                        <td><span class="label label-success"><?= $datasetFree[11];?></span></td>
                        <td><span class="label label-warning"><?= $datasetIdle[11];?></span></td>
                        <td><span class="label label-danger"><?= $datasetDisconnect[11];?></span></td>
                    </tr>  
                </table>                
            </div>            
        </div>
        
    </div>
</div>
