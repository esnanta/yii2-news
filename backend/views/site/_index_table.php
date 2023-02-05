<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use yii\helpers\Html;
?>
<tr>
    <td>
        <?= Html::a($model->title, ['blog/view','id'=>$model->id],array('class'=>''));?>        
    </td>
    <td><?=(empty($model->author_id)) ? '-': $model->author->title?></td>
    <td><?=$model->getLabelPublish()?></td>
    <td><?=$model->getLabelPinned()?></td>
    <td><?=$model->view_counter?></td>
</tr>