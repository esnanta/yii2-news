
<?php
use backend\models\Area;
use backend\models\Billing;
use backend\models\Collector;

use common\helper\Helper;

$areas              = Area::find()->limit(5)->all();
$currMonthPeriod    = Helper::getMonthPeriod(time());

?>


<p class="text-center">
    <strong>Periode : <?=$currMonthPeriod;?></strong><br>
</p>

<?php
    foreach ($areas as $areaModel) {
        $collectors = Collector::find()->where(['area_id'=>$areaModel->id])->all();
        $countPaid  = $areaModel->countBillingCompletion(Billing::PAYMENT_STATUS_PAID);
        $countAll   = $areaModel->countBillingCompletion();

        $percent    = ($countPaid>0) ? ceil((($countPaid/$countAll)*100)) : 0;

        $percentLabel = 'red';
        $progressStriped = 'progress-bar-striped';
        if($percent > 50){ $percentLabel = 'yellow'; }
        if($percent > 70){ $percentLabel = 'aqua'; }
        if($percent > 85){ $percentLabel = 'primary';}     
        
        if($percent == 100){ 
            $percentLabel = 'green';
            $progressStriped = '';
        }                                

?>
        <div class="progress-group">
            <span class="progress-text">
                <?=$areaModel->title;?>
                <?php
                    foreach ($collectors as $collectorModel) {
                        echo '|'.$collectorModel->staff->initial;
                    }
                ?>
            </span>
            <span class="progress-number"><b><?=$countPaid?></b>/<?=$countAll?></span>

            <div class="progress">
                <div class="progress-bar <?=$progressStriped;?> progress-bar-<?=$percentLabel;?>" style="width: <?=$percent;?>%">
                    <?=ceil($percent);?>%
                </div>
            </div>
        </div>                        
<?php } ?>