<?php
use yii\helpers\Html;

$formatter              = Yii::$app->formatter;
?>
<tr>
    <td><?= ($key+1) ?></td>
    <td><?= $model->outlet->invoice ?></td>
    <td><?= $formatter->asDecimal($model->assembly_cost)?></td>
    <td><?= $formatter->asDecimal($model->monthly_bill);?></td>
    <td><?= $model->getOneDeviceType($model->device_type)?></td>
    <td><?= $model->getOneDeviceStatus($model->device_status)?></td>
</tr>

