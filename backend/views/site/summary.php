<?php
use dosamigos\chartjs\ChartJs;

$this->title = 'Dashboard';
?>

<?php if(Yii::$app->params['Feat-Mailing']==true){?>
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-teal"><i class="ion ion-email-unread"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Surat Masuk</span>
                    <span class="info-box-number">
                        <?= date('y',time()).' : '.\backend\models\MailIncoming::countByYears();?>
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        
        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>
        
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-grey"><i class="ion ion-filing"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Tidak Disposisi</span>
                    <span class="info-box-number">
                        <?= date('y',time()).' : '.\backend\models\MailIncoming::countByYearsNoDisposition();?>
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
        </div>
        
        <div class="clearfix visible-sm-block"></div>
        
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-purple"><i class="ion ion-ios-shuffle-strong"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Surat Disposisi</span>
                    <span class="info-box-number">
                        <?= date('y',time()).' : '.\backend\models\MailDisposition::countByYears();?>
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>
        
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-navy"><i class="ion ion-forward"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Surat Keluar</span>
                    <span class="info-box-number">
                        <?= date('y',time()).' : '.\backend\models\MailOutgoing::countByYears();?>
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
    </div>



    <div class="panel panel-info">
        <div class="panel-heading">
            <div class="panel-title">
                Please fill out the form below
                <div class="pull-right">
                    Mail Chart 
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

            <div class="row">
                <div class="col-md-8">
                    <!-- https://www.flatuicolorpicker.com/-->
                    <?= ChartJs::widget([
                        'type' => 'line',
                        'data' => [
                            'labels' => $monthList,
                            'datasets' => [
                                [
                                    'label' => "Surat Masuk",
                                    'backgroundColor' => "rgba(137, 196, 244, 1)",//jordy blue
                                    'borderColor' => "rgba(44, 130, 201, 1)",//mariner
                                    'pointBackgroundColor' => "rgba(30, 139, 195, 1)",
                                    'pointBorderColor' => "#fff",
                                    'pointHoverBackgroundColor' => "#fff",
                                    'pointHoverBorderColor' => "rgba(30, 139, 195, 1)",
                                    'data' => $dataset1
                                ],
                                
                                [
                                    'label' => "Surat Disposisi",
                                    'backgroundColor' => "rgba(240, 240, 214, 1)",//Orchid White
                                    'borderColor' => "rgba(233, 212, 96, 1)",//Confetti
                                    'pointBackgroundColor' => "rgba(233, 212, 96, 1)",
                                    'pointBorderColor' => "#fff",
                                    'pointHoverBackgroundColor' => "#fff",
                                    'pointHoverBorderColor' => "rgba(233, 212, 96, 1)",
                                    'data' => $dataset2
                                ],
                                
                                [
                                    'label' => "Surat Keluar",
                                    'backgroundColor' => "rgba(226, 106, 106, 1)",//Sunglo
                                    'borderColor' => "rgba(240, 52, 52, 1)", //Pomegranate
                                    'pointBackgroundColor' => "rgba(240, 52, 52, 1)",
                                    'pointBorderColor' => "#fff",
                                    'pointHoverBackgroundColor' => "#fff",
                                    'pointHoverBorderColor' => "rgba(240, 52, 52, 1)",
                                    'data' => $dataset3
                                ],
                            ]
                        ]
                    ]);
                    ?>
                </div>
                <div class="col-md-4">
                    <table class="table table-condensed">
                        <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <?php
                                for($i=1;$i<=12;$i++){
                            ?>
                                    <tr>
                                        <td>
                                            <?php echo DateTime::createFromFormat('!m', $i)->format('F'); // JAN ?>                            
                                        </td>
                                        <td><span class="label label-primary"><?= $dataset1[($i-1)];?></span></td>
                                        <td><span class="label label-warning"><?= $dataset2[($i-1)];?></span></td>
                                        <td><span class="label label-danger"><?= $dataset3[($i-1)];?></span></td>                                        
                                    </tr>                
                            <?php
                                }
                            ?>        
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<?php } ?>


