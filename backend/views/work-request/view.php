<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\WorkRequest */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Work Request', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="work-request-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= 'Work Request'.' '. Html::encode($this->title) ?></h2>
        </div>
        <div class="col-sm-3" style="margin-top: 15px">
            
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ])
            ?>
        </div>
    </div>

    <div class="row">
<?php 
    $gridColumn = [
        ['attribute' => 'id', 'visible' => false],
        'title',
        'invoice',
        [
            'attribute' => 'staff.title',
            'label' => 'Staff',
        ],
        [
            'attribute' => 'customer.title',
            'label' => 'Customer',
        ],
        'customer_title',
        'phone_number',
        'address:ntext',
        'date_issued',
        'month_period',
        'description:ntext',
        'is_deleted',
        ['attribute' => 'verlock', 'visible' => false],
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]);
?>
    </div>
    <div class="row">
        <h4>Customer<?= ' '. Html::encode($this->title) ?></h4>
    </div>
    <?php 
    $gridColumnCustomer = [
        ['attribute' => 'id', 'visible' => false],
        'area_id',
        'village_id',
        'customer_number',
        'identity_number',
        'title',
        'gender_status',
        'address:ntext',
        'phone_number',
        'date_issued',
        'description:ntext',
        'is_deleted',
        ['attribute' => 'verlock', 'visible' => false],
    ];
    echo DetailView::widget([
        'model' => $model->customer,
        'attributes' => $gridColumnCustomer    ]);
    ?>
    <div class="row">
        <h4>Staff<?= ' '. Html::encode($this->title) ?></h4>
    </div>
    <?php 
    $gridColumnStaff = [
        ['attribute' => 'id', 'visible' => false],
        'employment_id',
        'title',
        'initial',
        'identity_number',
        'phone_number',
        'gender_status',
        'address:ntext',
        'file_name',
        'email',
        'google_plus',
        'instagram',
        'facebook',
        'twitter',
        'active_status',
        'description:ntext',
        'is_deleted',
        ['attribute' => 'verlock', 'visible' => false],
    ];
    echo DetailView::widget([
        'model' => $model->staff,
        'attributes' => $gridColumnStaff    ]);
    ?>
    
    <div class="row">
<?php
if($providerWorkRequestDetail->totalCount){
    $gridColumnWorkRequestDetail = [
        ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'id', 'visible' => false],
                        [
                'attribute' => 'customer.title',
                'label' => 'Customer'
            ],
            [
                'attribute' => 'work.title',
                'label' => 'Work'
            ],
            'remark:ntext',
            'is_deleted',
            ['attribute' => 'verlock', 'visible' => false],
    ];
    echo Gridview::widget([
        'dataProvider' => $providerWorkRequestDetail,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-tx-work-request-detail']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode('Work Request Detail'),
        ],
        'export' => false,
        'columns' => $gridColumnWorkRequestDetail
    ]);
}
?>

    </div>
</div>
