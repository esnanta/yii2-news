<?php
use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\widgets\FileInput;
/**
 * @var yii\web\View $this
 * @var backend\models\Photo $model
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Photos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$create = Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create','id'=>$model->album_id], ['class' => 'pull-right detail-button','style'=>'padding:0 5px']);
?>
<div class="photo-view">

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
                'attribute'=>'album_id', 
                'format'=>'html',
                'value'=>Html::a($model->album->title, $model->album->getUrl()),
                'type'=>DetailView::INPUT_DROPDOWN_LIST, 
                'options' => ['id' => 'album_id', 'prompt' => ''],
                'items' => $dataList,
                'widgetOptions'=>[
                    'data'=>$dataList,
                ]                
            ],             
            [
                'attribute' => 'image',
                'value' => ($model->getImageUrl()),
                'format' => ['image',['width'=>'150','height'=>'100']],

                'type'=>DetailView::INPUT_WIDGET, 
                'widgetOptions'=>[
                    'class'=> FileInput::classname(),
                ]           
            ],
            
            [
                'label'=>'Url', 
                'value' => 'https://'.Yii::$app->getRequest()->serverName.$model->getImageUrl(),
                'format'=>'raw',
                'type'=>DetailView::INPUT_HIDDEN,   
            ],             
             
            'title',
            [
                'attribute'=>'description', 
                'type'=>DetailView::INPUT_TEXTAREA,                    
            ],    
            [
                'attribute'=>'file_name',
                'type'=>DetailView::INPUT_HIDDEN,
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
        'enableEditMode' => Yii::$app->user->can('update-photo'),
    ]) ?>

</div>
