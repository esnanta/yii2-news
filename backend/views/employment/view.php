<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var backend\models\Employment $model
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Employments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$create = Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'], ['class' => 'pull-right detail-button','style'=>'padding:0 5px']);
?>
<div class="employment-view">

    <?= DetailView::widget([
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
            'sequence',
            [
                'attribute'=>'description', 
                'format'=>'html',
                'type'=>DetailView::INPUT_TEXTAREA,                    
            ], 
            [
                'group'=>true,
                'rowOptions'=>['class'=>'default']
            ],              
            [
                'columns' => [
                    [
                        'attribute'=>'created_at', 
                        'format'=>'date',
                        'type'=>DetailView::INPUT_HIDDEN,      
                        'valueColOptions'=>['style'=>'width:30%']
                    ],  
                    [
                        'attribute'=>'updated_at', 
                        'format'=>'date',
                        'type'=>DetailView::INPUT_HIDDEN, 
                        'valueColOptions'=>['style'=>'width:30%']
                    ],                                
                ],
            ],
            [
                'columns' => [
                    [
                        'attribute'=>'created_by',
                        'value'=>($model->created_by!=null) ? \backend\models\User::getName($model->created_by):'',
                        'type'=>DetailView::INPUT_HIDDEN,
                        'valueColOptions'=>['style'=>'width:30%']
                    ],
                    [
                        'attribute'=>'updated_by',
                        'value'=>($model->updated_by!=null) ? \backend\models\User::getName($model->updated_by):'',
                        'type'=>DetailView::INPUT_HIDDEN,
                        'valueColOptions'=>['style'=>'width:30%']
                    ],                                
                ],
            ],  
        ],
        'deleteOptions' => [
            'url' => ['delete', 'id' => $model->id],
        ],
        'enableEditMode' => Yii::$app->user->can('update-employment'),
    ]) ?>

</div>
