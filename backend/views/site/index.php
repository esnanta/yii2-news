<?php

use yii\helpers\Html;

use backend\models\Article as Blog;

use dosamigos\chartjs\ChartJs;


$this->title = 'Dashboard';
?>
<!-- Info boxes -->
<div class="row">

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3><?=Article::find()->count();?></h3>

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
                <h3><?=Article::find()->where(['publish_status'=>Article::PUBLISH_STATUS_YES])->count();?></h3>

                <p>Jumlah Dipublish</p>
            </div>
            <div class="icon">
                <i class="ion ion-ios-chatbubble"></i>
            </div>
            <?= Html::a('More info <i class="fa fa-arrow-circle-right"></i>', ['blog/index'],['class'=>'small-box-footer']); ?>
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3><?=Article::find()->where(['pinned_status'=>Article::PINNED_STATUS_YES])->count();?></h3>

                <p>Blog Dipin</p>
            </div>
            <div class="icon">
                <i class="ion ion-ios-folder"></i>
            </div>
            <?= Html::a('More info <i class="fa fa-arrow-circle-right"></i>', ['blog/index'],['class'=>'small-box-footer']); ?>
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <h3><?=Article::find()->where(['publish_status'=>Article::PUBLISH_STATUS_NO])->count();?></h3>

                <p>Blog Draft</p>
            </div>
            <div class="icon">
                <i class="ion ion-ios-person"></i>
            </div>
            <?= Html::a('More info <i class="fa fa-arrow-circle-right"></i>', ['blog/index'],['class'=>'small-box-footer']); ?>
        </div>
    </div>        `

</div>


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
     
        <div class="row">
            <div class="col-md-8">
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
            <div class="col-md-4">
                <table class="table table-condensed">
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td><i class="fa fa-eye"></i></td>
                        </tr>
                        <?php
                            for($i=1;$i<=12;$i++){
                        ?>
                                <tr>
                                    <td>
                                        <?php echo DateTime::createFromFormat('!m', $i)->format('F'); // JAN ?>                            
                                    </td>
                                    <td><span class="label label-primary"><?= $dataset[($i-1)];?></span></td>
                                    <td><span class="label label-danger"><?= $datasetCounter[($i-1)];?></span></td>
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