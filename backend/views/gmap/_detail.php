<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use backend\models\Office;

/* @var $this yii\web\View */
/* @var $model backend\models\Gmap */

$office             = Office::find()->where(['id'=>1])->one();
?>
<div class="gmap-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= Html::encode($model->customer->title) ?></h2>
        </div>
    </div>

    <div class="row">   
        <?php 
            $gridColumn = [
                ['attribute' => 'id', 'visible' => false],
//                [
//                    'attribute' => 'customer.title',
//                    'label' => 'Customer',
//                ],
//                'latitude',
//                'longitude',
                'description:ntext',
                ['attribute' => 'verlock', 'visible' => false],
            ];
            echo DetailView::widget([
                'model' => $model,
                'attributes' => $gridColumn
            ]); 
        ?>
    </div>
    
    <div class="row">
        <?= 
            $this->render('_map', [
            'model' => $model,
            'office'=>$office
        ]) ?>        
    </div>
    
</div>