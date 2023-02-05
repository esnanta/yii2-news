<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var backend\models\OutletDetail $model
 */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Outlet Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="outlet-detail-view">

    <?= DetailView::widget([
        'model' => $model,
        'condensed' => false,
        'hover' => true,
        'mode' => Yii::$app->request->get('edit') == 't' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
        'panel' => [
            'heading' => $this->title,
            'type' => DetailView::TYPE_INFO,
        ],
        'attributes' => [
            'id',
            'outlet_id',
            'customer_id',
            'assembly_cost',
            'monthly_bill',
            'device_type',
            'device_status',
            'description:ntext',
            'created_at:datetime',
            'updated_at:datetime',
            'created_by',
            'updated_by',
            'verlock',
        ],
        'deleteOptions' => [
            'url' => ['delete', 'id' => $model->id],
        ],
        'enableEditMode' => true,
    ]) ?>

</div>
