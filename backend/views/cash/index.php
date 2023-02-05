<?php

$this->title = 'Dashboard';
?>

<!-- Info boxes -->
<div class="row">
    
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3><?=$totalBillingCost?></h3>

                <p>Nilai Outlet</p>
            </div>
            <div class="icon">
                <i class="ion ion-ios-list"></i>
            </div>
            <div class="small-box-footer">
                <?=$countOutlet.' records'?>
            </div>
        </div>
    </div>    
    
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <h3><?=$totalIncome?></h3>

                <p>Total Income</p>
            </div>
            <div class="icon">
                <i class="ion ion-ios-chatbubble"></i>
            </div>
            <div class="small-box-footer">
                <?=$countIncome.' records'?>
            </div>
        </div>
    </div>    

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <h3><?=$totalOutcome?></h3>

                <p>Total Outcome</p>
            </div>
            <div class="icon">
                <i class="ion ion-ios-folder"></i>
            </div>
            <div class="small-box-footer">
                <?=$countOutcome.' records'?>
            </div>
           
        </div>
    </div>    
    
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-primary">
            <div class="inner">
                <h3><?= $totalSummary;?></h3>

                <p>Summary</p>
            </div>
            <div class="icon">
                <i class="ion ion-ios-person"></i>
            </div>
            <div class="small-box-footer">
                <?='Grand Total = (Income-Outcome)'?>
            </div>
        </div>
    </div>        `    
    
    
    
</div>
<!-- /.row -->

<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab">Summary</a></li>
        <li ><a href="#tab_2" data-toggle="tab">Outlet <span class = "label label-default"><?=$totalBillingCost?></span></a></li>
        <li ><a href="#tab_3" data-toggle="tab">Income <span class = "label label-default"><?=$totalIncome?></span></a></li>
        <li ><a href="#tab_4" data-toggle="tab">Outcome <span class = "label label-default"><?=$totalOutcome?></span></a></li>
    </ul>
    
    <div class="tab-content">
        <div class="tab-pane active" id="tab_1">
            <!-- /.box-header -->
            <div class="box-body">
                <table class="table table-hover">
                    <tr>
                        <td>Tanggal Pilihan</td>
                        <td><?= $dateFirst.' - '.$dateLast;?></td>
                    </tr>
                    
                    <tr>
                        <td>Income (Outlet + Penerimaan Pembayaran + Akun Penerimaan)</td>
                        <td><?=$totalIncome;?></td>
                    </tr>                    
                    <tr>
                        <td>Outcome (Akun Pengeluaran)</td>
                        <td><?=$totalOutcome;?></td>
                    </tr>                     
                    <tr>
                        <td>Total (Income-Outcome)</td>
                        <td><?= $totalSummary;?></td>
                    </tr>            
                </table>
                <br>
                <?=                
                    $this->render('form/_form_summary', [
                        'modelReportSummary'=>$modelReportSummary,
                        'dateSummaryList'=>$dateSummaryList,
                        'typeSummaryList'=>$typeSummaryList,
                    ]);                        
                ?>
            </div>    
        </div>
        
        <div class="tab-pane" id="tab_2">
            <div class="box-body">
                
                <table class="table table-hover">
                    <tr>
                        <td>Jumlah</td>
                        <td><?=$countOutlet?></td>
                    </tr>
                    <tr>
                        <td>Total</td>
                        <td><?=$totalBillingCost?></td>
                    </tr>            
                </table>                
                
                <?=                    
                    $this->render('_outlet', [
                        'providerOutletDetail'=>$providerOutletDetail,
                    ]);                        
                ?> 
            </div>            
        </div>
        
        <div class="tab-pane" id="tab_3">
            <div class="box-body">
                
                <table class="table table-hover">
                    <tr>
                        <td>Jumlah</td>
                        <td><?=$countIncome?></td>
                    </tr>
                    <tr>
                        <td>Total</td>
                        <td><?=$totalIncome?></td>
                    </tr>            
                </table>                  
                
                <?=                    
                    $this->render('_receivable', [
                        'providerReceivableDetail'=>$providerReceivableDetail,
                    ]);                        
                ?>

                <?=                    
                    $this->render('_account_receivable', [
                        'providerAccountReceivableDetail'=>$providerAccountReceivableDetail,
                    ]);                        
                ?>  
            </div>            
        </div>   
        
        <div class="tab-pane" id="tab_4">
            <div class="box-body">
                
                <table class="table table-hover">
                    <tr>
                        <td>Jumlah</td>
                        <td><?=$countOutcome?></td>
                    </tr>
                    <tr>
                        <td>Total</td>
                        <td><?=$totalOutcome?></td>
                    </tr>            
                </table>                  
                
                <?=                    
                    $this->render('_account_payable', [
                        'providerAccountPayableDetail'=>$providerAccountPayableDetail,
                    ]);                        
                ?>   
            </div>            
        </div>        
    </div>
</div>