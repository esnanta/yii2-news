<?php
use yii\helpers\Html;

$formatter              = Yii::$app->formatter;
?>
<tr>
    <td><?= ($key+1) ?></td>
    <td><?= $model->commentary ?></td>  
    <td><?= $model->getOneDeviceStatus($model->device_status) ?></td>
    <td><?= $formatter->asDecimal($model->monthly_bill);?></td>     
    <td><?= $model->serviceReason->title ?></td>             
</tr>

