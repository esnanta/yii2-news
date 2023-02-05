<?php
use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\widgets\Select2;

/**
 * @var yii\web\View $this
 * @var backend\models\Village $model
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Villages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$create = Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'], ['class' => 'pull-right detail-button','style'=>'padding:0 5px']);

?>
<div class="village-view">

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
            [
                'attribute'=>'area_id', 
                'value'=>($model->area_id!=null) ? $model->area->title:'',
                'type'=>DetailView::INPUT_SELECT2, 
                'options' => ['id' => 'area_id', 'prompt' => '', 'disabled'=>false],
                'items' => $areaList,
                'widgetOptions'=>[
                    'class'=> Select2::className(),
                    'data'=>$areaList,
                ]                
            ],   
            'title',
            'description:ntext',
            [
                'attribute'=>'created_at', 
                'format'=>'date',
                'type'=>DetailView::INPUT_HIDDEN,                    
            ],  
            [
                'attribute'=>'updated_at', 
                'format'=>'date',
                'type'=>DetailView::INPUT_HIDDEN,                    
            ],              
            [
                'attribute'=>'created_by',
                'value'=>($model->created_by!=null) ? \backend\models\User::getName($model->created_by):'',
                'type'=>DetailView::INPUT_HIDDEN,
            ],
            [
                'attribute'=>'updated_by',
                'value'=>($model->updated_by!=null) ? \backend\models\User::getName($model->updated_by):'',
                'type'=>DetailView::INPUT_HIDDEN,
            ],             
        ],
        'deleteOptions' => [
            'url' => ['delete', 'id' => $model->id],
        ],
        'enableEditMode' => Yii::$app->user->can('update-village'),
    ]) ?>

</div>
