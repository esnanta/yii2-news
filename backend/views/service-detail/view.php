<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var backend\models\ServiceDetail $model
 */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Service Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="service-detail-view">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>


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
            'service_id',
            'outlet_detail_id',
            'service_reason_id',
            'device_status',
            'month_period',
            'commentary:ntext',
            'claim',
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
