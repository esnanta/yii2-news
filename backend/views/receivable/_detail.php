<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\Receivable */

?>
<div class="receivable-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= Html::encode($model->invoice) ?></h2>
        </div>
    </div>

    <div class="row">
<?php 
    $gridColumn = [
        ['attribute' => 'id', 'visible' => false],

        [
            'attribute' => 'date_issued',
            'format' => 'date',
        ],
        'month_period',
        'description:ntext',
        [
            'attribute' => 'claim',
            'format' => ['decimal'],
        ],
        [
            'attribute' => 'surcharge',
            'format' => ['decimal'],
        ],
        [
            'attribute' => 'penalty',
            'format' => ['decimal'],
        ],
        [
            'attribute' => 'total',
            'format' => ['decimal'],
        ],  
        [
            'attribute' => 'discount',
            'format' => ['decimal'],
        ], 
        [
            'attribute' => 'payment',
            'format' => ['decimal'],
        ], 
        [
            'attribute' => 'balance',
            'format' => ['decimal'],
        ], 
        ['attribute' => 'verlock', 'visible' => false],
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]); 
?>
    </div>
</div>