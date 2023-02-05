<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\WorkRequestDetail */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Work Request Detail', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="work-request-detail-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= 'Work Request Detail'.' '. Html::encode($this->title) ?></h2>
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
        [
            'attribute' => 'workRequest.title',
            'label' => 'Work Request',
        ],
        [
            'attribute' => 'customer.title',
            'label' => 'Customer',
        ],
        [
            'attribute' => 'work.title',
            'label' => 'Work',
        ],
        'remark:ntext',
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
        'address',
        'phone_number',
        'date_issued',
        'description',
        'is_deleted',
        ['attribute' => 'verlock', 'visible' => false],
    ];
    echo DetailView::widget([
        'model' => $model->customer,
        'attributes' => $gridColumnCustomer    ]);
    ?>
    <div class="row">
        <h4>Work<?= ' '. Html::encode($this->title) ?></h4>
    </div>
    <?php 
    $gridColumnWork = [
        ['attribute' => 'id', 'visible' => false],
        'work_type_id',
        'title',
        'sequence',
        'description',
        'is_deleted',
        ['attribute' => 'verlock', 'visible' => false],
    ];
    echo DetailView::widget([
        'model' => $model->work,
        'attributes' => $gridColumnWork    ]);
    ?>
    <div class="row">
        <h4>WorkRequest<?= ' '. Html::encode($this->title) ?></h4>
    </div>
    <?php 
    $gridColumnWorkRequest = [
        ['attribute' => 'id', 'visible' => false],
        'title',
        'invoice',
        [
            'attribute' => 'customer.title',
            'label' => 'Customer',
        ],
        'staff_id',
        'date_issued',
        'month_period',
        'description',
        'is_deleted',
        ['attribute' => 'verlock', 'visible' => false],
    ];
    echo DetailView::widget([
        'model' => $model->workRequest,
        'attributes' => $gridColumnWorkRequest    ]);
    ?>
</div>
