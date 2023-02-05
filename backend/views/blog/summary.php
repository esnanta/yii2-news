<?php

use yii\helpers\Html;

use backend\models\Blog as Blog;
use backend\models\Comment as Comment;
use backend\models\Archive as Archive;
use backend\models\Staff as Staff;

use dosamigos\chartjs\ChartJs;

$this->title = 'Dashboard';
?>
<!-- Info boxes -->
<div class="row">
    
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3><?=Blog::find()->count();?></h3>

                <p>Jumlah Blog</p>
            </div>
            <div class="icon">
                <i class="ion ion-ios-list"></i>
            </div>
            <?= Html::a('More info <i class="fa fa-arrow-circle-right"></i>', ['blog/index'],['class'=>'small-box-footer']); ?>
        </div>
    </div>    
    
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <h3><?=Comment::find()->count();?></h3>

                <p>Jumlah Komentar</p>
            </div>
            <div class="icon">
                <i class="ion ion-ios-chatbubble"></i>
            </div>
            <?= Html::a('More info <i class="fa fa-arrow-circle-right"></i>', ['comment/index'],['class'=>'small-box-footer']); ?>
        </div>
    </div>    

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3><?=Archive::find()->count();?></h3>

                <p>Jumlah Arsip</p>
            </div>
            <div class="icon">
                <i class="ion ion-ios-folder"></i>
            </div>
            <?= Html::a('More info <i class="fa fa-arrow-circle-right"></i>', ['archive/index'],['class'=>'small-box-footer']); ?>
        </div>
    </div>    
    
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <h3><?=Staff::find()->count();?></h3>

                <p>Jumlah Staff</p>
            </div>
            <div class="icon">
                <i class="ion ion-ios-person"></i>
            </div>
            <?= Html::a('More info <i class="fa fa-arrow-circle-right"></i>', ['staff/index'],['class'=>'small-box-footer']); ?>
        </div>
    </div>        `    
    
    
    
</div>
<!-- /.row -->

<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">
            Please fill out the form below
            <div class="pull-right">
                Blog Chart 
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
                        <td>
                            <span class="label label-primary"><?= $dataset[0];?></span>
                            <span class="label label-success"><i class="fa fa-eye"></i> <?= $datasetCounter[0];?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo DateTime::createFromFormat('!m', 2)->format('F'); // FEB ?>                            
                        </td>
                        <td>
                            <span class="label label-primary"><?= $dataset[1];?></span>
                            <span class="label label-success"><i class="fa fa-eye"></i> <?= $datasetCounter[1];?></span>                            
                        </td>
                    </tr>     
                    <tr>
                        <td>
                            <?php echo DateTime::createFromFormat('!m', 3)->format('F'); // MAR ?>                            
                        </td>
                        <td>
                            <span class="label label-primary"><?= $dataset[2];?></span>
                            <span class="label label-success"><i class="fa fa-eye"></i> <?= $datasetCounter[2];?></span>                            
                        </td>
                    </tr>                     
                </table>                
            </div>
            <div class="col-md-3">
                <table class="table table-hover">
                    <tr>
                        <td>
                            <?php echo DateTime::createFromFormat('!m', 4)->format('F'); // APR ?>                            
                        </td>
                        <td>
                            <span class="label label-primary"><?= $dataset[3];?></span>
                            <span class="label label-success"><i class="fa fa-eye"></i> <?= $datasetCounter[3];?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo DateTime::createFromFormat('!m', 5)->format('F'); // MEI ?>                            
                        </td>
                        <td>
                            <span class="label label-primary"><?= $dataset[4];?></span>
                            <span class="label label-success"><i class="fa fa-eye"></i> <?= $datasetCounter[4];?></span>
                        </td>
                    </tr>     
                    <tr>
                        <td>
                            <?php echo DateTime::createFromFormat('!m', 6)->format('F'); // JUN ?>                            
                        </td>
                        <td>
                            <span class="label label-primary"><?= $dataset[5];?></span>
                            <span class="label label-success"><i class="fa fa-eye"></i> <?= $datasetCounter[5];?></span>
                        </td>
                    </tr>  
                </table>
            </div>
            <div class="col-md-3">
                <table class="table table-hover">
                    <tr>
                        <td>
                            <?php echo DateTime::createFromFormat('!m', 7)->format('F'); // JUL ?>                            
                        </td>
                        <td>
                            <span class="label label-primary"><?= $dataset[6];?></span>
                            <span class="label label-success"><i class="fa fa-eye"></i> <?= $datasetCounter[6];?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo DateTime::createFromFormat('!m', 8)->format('F'); // AUG ?>                            
                        </td>
                        <td>
                            <span class="label label-primary"><?= $dataset[7];?></span>
                            <span class="label label-success"><i class="fa fa-eye"></i> <?= $datasetCounter[7];?></span>
                        </td>
                    </tr>     
                    <tr>
                        <td>
                            <?php echo DateTime::createFromFormat('!m', 9)->format('F'); // SEP ?>                            
                        </td>
                        <td>
                            <span class="label label-primary"><?= $dataset[8];?></span>
                            <span class="label label-success"><i class="fa fa-eye"></i> <?= $datasetCounter[8];?></span>
                        </td>
                    </tr>  
                </table>                
            </div>
            <div class="col-md-3">
                <table class="table table-hover">
                    <tr>
                        <td>
                            <?php echo DateTime::createFromFormat('!m', 10)->format('F'); // OKT ?>                            
                        </td>
                        <td>
                            <span class="label label-primary"><?= $dataset[9];?></span>
                            <span class="label label-success"><i class="fa fa-eye"></i> <?= $datasetCounter[9];?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo DateTime::createFromFormat('!m', 11)->format('F'); // NOV ?>                            
                        </td>
                        <td>
                            <span class="label label-primary"><?= $dataset[10];?></span>
                            <span class="label label-success"><i class="fa fa-eye"></i> <?= $datasetCounter[10];?></span>
                        </td>
                    </tr>     
                    <tr>
                        <td>
                            <?php echo DateTime::createFromFormat('!m', 12)->format('F'); // DES ?>                            
                        </td>
                        <td>
                            <span class="label label-primary"><?= $dataset[11];?></span>
                            <span class="label label-success"><i class="fa fa-eye"></i> <?= $datasetCounter[11];?></span>
                        </td>
                    </tr>  
                </table>                
            </div>            
        </div>
        
        <hr>
        
        <?= ChartJs::widget([
            'type' => 'line',
            'data' => [
                'labels' => $monthList,
                'datasets' => [
                    [
                        'label' => "Grafik Blog",
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
        
    </div>
</div>