<?php

use yii\helpers\Html;
use kartik\detail\DetailView;


/**
 * @var yii\web\View $this
 * @var backend\models\ServiceReason $model
 */
$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Service Reasons', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$create = Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'], ['class' => 'pull-right detail-button','style'=>'padding:0 5px']);
?>
<div class="service-type-view">

    <?=
    DetailView::widget([
        'model' => $model,
        'condensed' => false,
        'hover' => true,
        'mode' => Yii::$app->request->get('edit') == 't' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
        'panel' => [
            'heading' => $this->title.$create,
            'type' => DetailView::TYPE_INFO,
        ],
        'attributes' => [
            'title',
            [
                'attribute' => 'description',
                'format' => 'html',
                'type' => DetailView::INPUT_TEXTAREA,
            ],
            [
                'attribute' => 'created_at',
                'format' => 'date',
                'type' => DetailView::INPUT_HIDDEN,
            ],
            [
                'attribute' => 'updated_at',
                'format' => 'date',
                'type' => DetailView::INPUT_HIDDEN,
            ],
            [
                'attribute' => 'created_by',
                'type' => DetailView::INPUT_HIDDEN,
            ],
            [
                'attribute' => 'updated_by',
                'type' => DetailView::INPUT_HIDDEN,
            ],
        ],
        'deleteOptions' => [
            'url' => ['delete', 'id' => $model->id],
        ],
        'enableEditMode' => Yii::$app->user->can('update-reason-type'),
    ])
    ?>

</div>
