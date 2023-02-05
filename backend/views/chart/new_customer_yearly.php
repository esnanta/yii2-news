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
                Chart New Customer            
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
                        'label' => "Grafik Pelanggan Baru",
                        'backgroundColor' => "rgba(179,181,198,0.2)",
                        'borderColor' => "rgba(179,181,198,1)",
                        'pointBackgroundColor' => "rgba(179,181,198,1)",
                        'pointBorderColor' => "#fff",
                        'pointHoverBackgroundColor' => "#fff",
                        'pointHoverBorderColor' => "rgba(179,181,198,1)",
                        'data' => $dataset
                    ],
                ]
            ]
        ]);
        ?>         
        
        <hr>
                      
        <div class="row">
            <div class="col-md-12">
                <h3>Tahun <?= $model->option_year;?> 
                    <span class="label label-primary">
                        <?= 
                            $dataset[0]+$dataset[1]+$dataset[2]+
                            $dataset[3]+$dataset[4]+$dataset[5]+
                            $dataset[6]+$dataset[7]+$dataset[8]+
                            $dataset[9]+$dataset[10]+$dataset[11]
                        ?>
                    </span>
                </h3>
            </div>
            <div class="col-md-3">
                <table class="table table-hover">
                    <tr>
                        <td>
                            <?php echo DateTime::createFromFormat('!m', 1)->format('F'); // JAN ?>                            
                        </td>
                        <td><span class="label label-primary"><?= $dataset[0];?></span></td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo DateTime::createFromFormat('!m', 2)->format('F'); // FEB ?>                            
                        </td>
                        <td><span class="label label-primary"><?= $dataset[1];?></span></td>
                    </tr>     
                    <tr>
                        <td>
                            <?php echo DateTime::createFromFormat('!m', 3)->format('F'); // MAR ?>                            
                        </td>
                        <td><span class="label label-primary"><?= $dataset[2];?></span></td>
                    </tr>                     
                </table>                
            </div>
            <div class="col-md-3">
                <table class="table table-hover">
                    <tr>
                        <td>
                            <?php echo DateTime::createFromFormat('!m', 4)->format('F'); // APR ?>                            
                        </td>
                        <td><span class="label label-primary"><?= $dataset[3];?></span></td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo DateTime::createFromFormat('!m', 5)->format('F'); // MEI ?>                            
                        </td>
                        <td><span class="label label-primary"><?= $dataset[4];?></span></td>
                    </tr>     
                    <tr>
                        <td>
                            <?php echo DateTime::createFromFormat('!m', 6)->format('F'); // JUN ?>                            
                        </td>
                        <td><span class="label label-primary"><?= $dataset[5];?></span></td>
                    </tr>  
                </table>
            </div>
            <div class="col-md-3">
                <table class="table table-hover">
                    <tr>
                        <td>
                            <?php echo DateTime::createFromFormat('!m', 7)->format('F'); // JUL ?>                            
                        </td>
                        <td><span class="label label-primary"><?= $dataset[6];?></span></td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo DateTime::createFromFormat('!m', 8)->format('F'); // AUG ?>                            
                        </td>
                        <td><span class="label label-primary"><?= $dataset[7];?></span></td>
                    </tr>     
                    <tr>
                        <td>
                            <?php echo DateTime::createFromFormat('!m', 9)->format('F'); // SEP ?>                            
                        </td>
                        <td><span class="label label-primary"><?= $dataset[8];?></span></td>
                    </tr>  
                </table>                
            </div>
            <div class="col-md-3">
                <table class="table table-hover">
                    <tr>
                        <td>
                            <?php echo DateTime::createFromFormat('!m', 10)->format('F'); // OKT ?>                            
                        </td>
                        <td><span class="label label-primary"><?= $dataset[9];?></span></td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo DateTime::createFromFormat('!m', 11)->format('F'); // NOV ?>                            
                        </td>
                        <td><span class="label label-primary"><?= $dataset[10];?></span></td>
                    </tr>     
                    <tr>
                        <td>
                            <?php echo DateTime::createFromFormat('!m', 12)->format('F'); // DES ?>                            
                        </td>
                        <td><span class="label label-primary"><?= $dataset[11];?></span></td>
                    </tr>  
                </table>                
            </div>            
        </div>
        
    </div>
</div>
