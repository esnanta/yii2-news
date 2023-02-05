<?php
use yii\helpers\Html;

$formatter              = Yii::$app->formatter;
?>
<tr>
    <td><?= ($key+1) ?></td>
    <td><?= Html::a($model->billing->month_period, $model->billing->getUrl()); ?></td>                           
    <td><?= $formatter->format($model->date_due, 'date') ?></td>            
    <td><?= $model->overdue ?></td>                                         
    <td><?= $model->getOneAccuracyStatus($model->accuracy_status) ?></td>   
    <td><?= $model->billing->getOneBillingType($model->billing->billing_type) ?></td>
    <td><?= $formatter->asDecimal($model->claim);?></td>                    
    <td><?= $formatter->asDecimal($model->penalty);?></td>                  
    <td><?= $formatter->asDecimal($model->total);?></td>                    
</tr>

