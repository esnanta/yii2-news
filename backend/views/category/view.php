<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\select2\Select2;
/**
 * @var yii\web\View $this
 * @var backend\models\Category $model
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$create = Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'], ['class' => 'pull-right detail-button','style'=>'padding:0 5px']);
?>
<div class="category-view">

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
            //'label',
            [
                'attribute'=>'label', 
                'value'=>($model->label!=null) ? $model->label:'',
                'type'=>DetailView::INPUT_SELECT2, 
                'options' => ['id' => 'label', 'prompt' => '', 'disabled'=>false],
                'items' => $labelList,
                'widgetOptions'=>[
                    'class'=> Select2::className(),
                    'data'=>$labelList,
                ],
            ],              
            [
                'attribute'=>'description', 
                'format'=>'html',
                'type'=>DetailView::INPUT_TEXTAREA,                    
            ],     
            
            [
                'attribute'=>'time_line', 
                'format'=>'html',
                'value'=>(!empty($model->time_line)) ? $model->getOneTimeLine($model->time_line):'',
                'type'=>DetailView::INPUT_SELECT2, 
                'options' => ['id' => 'time_line', 'prompt' => '', 'disabled'=>false],
                'items' => $dataList,
                'widgetOptions'=>[
                    'class'=> Select2::className(),
                    'data'=>$dataList,
                ],
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
        'enableEditMode' => Yii::$app->user->can('update-category'),
    ]) ?>

</div>
