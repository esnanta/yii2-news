<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\AccountPayable */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Account Payable', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="account-payable-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= 'Account Payable'.' '. Html::encode($this->title) ?></h2>
        </div>
    </div>

    <div class="row">
<?php 
    $gridColumn = [
        ['attribute' => 'id', 'visible' => false],
        [
                'attribute' => 'staff.title',
                'label' => 'Staff'
            ],
        'title',
        'date_issued',
        'month_period',
        'description:ntext',
        'claim',
        'surcharge',
        'penalty',
        'total',
        'discount',
        'payment',
        'balance',
        ['attribute' => 'verlock', 'visible' => false],
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]); 
?>
    </div>
    
    <div class="row">
<?php
if($providerAccountPayableDetail->totalCount){
    $gridColumnAccountPayableDetail = [
        ['class' => 'yii\grid\SerialColumn'],
        ['attribute' => 'id', 'visible' => false],
                [
                'attribute' => 'account.title',
                'label' => 'Account'
            ],
        'invoice',
        'amount',
        'commentary:ntext',
        ['attribute' => 'verlock', 'visible' => false],
    ];
    echo Gridview::widget([
        'dataProvider' => $providerAccountPayableDetail,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => Html::encode('Account Payable Detail'),
        ],
        'panelHeadingTemplate' => '<h4>{heading}</h4>{summary}',
        'toggleData' => false,
        'columns' => $gridColumnAccountPayableDetail
    ]);
}
?>
    </div>
</div>
