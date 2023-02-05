<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\Outlet */

?>
<div class="outlet-view">

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
        [
            'attribute' => 'date_assembly',
            'format' => 'date',
        ],        
        [
            'attribute' => 'claim',
            'format' => ['decimal'],
        ],
//        [
//            'attribute' => 'assembly_type',
//            'format'=>'html',
//            'value'=>(!empty($model->assembly_type)) ? 
//                        $model->getOneAssemblyType($model->assembly_type):'-', 
//        ],           
//        [
//            'attribute' => 'billing_status',
//            'format'=>'html',
//            'value'=>(!empty($model->billing_status)) ? 
//                        $model->getOneBillingStatus($model->billing_status):'-',              
//            
//        ],        
        'description:ntext',
        ['attribute' => 'verlock', 'visible' => false],
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]); 
?>
    </div>
</div>