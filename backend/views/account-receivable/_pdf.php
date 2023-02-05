<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\AccountReceivable */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Account Receivable', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="account-receivable-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= 'Account Receivable'.' '. Html::encode($this->title) ?></h2>
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
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]); 
?>
    </div>
    
    <div class="row">
<?php
if($providerAccountReceivableDetail->totalCount){
    $gridColumnAccountReceivableDetail = [
        ['class' => 'yii\grid\SerialColumn'],
        ['attribute' => 'id', 'visible' => false],
                [
                'attribute' => 'account.title',
                'label' => 'Account'
            ],
        'invoice',
        'amount',
        'commentary:ntext',
    ];
    echo Gridview::widget([
        'dataProvider' => $providerAccountReceivableDetail,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => Html::encode('Account Receivable Detail'),
        ],
        'panelHeadingTemplate' => '<h4>{heading}</h4>{summary}',
        'toggleData' => false,
        'columns' => $gridColumnAccountReceivableDetail
    ]);
}
?>
    </div>
</div>
