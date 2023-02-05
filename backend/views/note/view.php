<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;
use bajadev\ckeditor\CKEditor;

/**
 * @var yii\web\View $this
 * @var backend\models\Note $model
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Notes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$create = Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'], ['class' => 'pull-right detail-button','style'=>'padding:0 5px']);
?>
<div class="note-view">

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
                'attribute'=>'title', 
                //'valueColOptions'=>['style'=>'width:30%']
            ],            
            [
                'columns' => [
                    [
                        'attribute'=>'note_type_id', 
                        'value'=>($model->note_type_id!=null) ? $model->noteType->title:'',
                        'type'=>DetailView::INPUT_DROPDOWN_LIST, 
                        'options' => ['id' => 'note_type_id', 'prompt' => ''],
                        'items' => $noteTypeList,
                        'widgetOptions'=>[
                            'data'=>$noteTypeList,
                        ],
                        'valueColOptions'=>['style'=>'width:30%']
                    ],                 
                    [
                        'attribute'=>'staff_id', 
                        'value'=>($model->staff_id!=null) ? $model->staff->title:'',
                        'type'=>DetailView::INPUT_DROPDOWN_LIST, 
                        'options' => ['id' => 'staff_id', 'prompt' => ''],
                        'items' => $staffList,
                        'widgetOptions'=>[
                            'data'=>$staffList,
                        ],
                        'valueColOptions'=>['style'=>'width:30%']
                    ],    
                ],
            ],  
            [
                'columns' => [
                    [
                        'attribute'=>'date_issued', 
                        'format'=>'date',
                        'type'=>DetailView::INPUT_WIDGET,             
                        'widgetOptions'=>[
                            'class'=>DateControl::classname(),
                            'type'=>DateControl::FORMAT_DATE,                
                        ],   
                        'valueColOptions'=>['style'=>'width:30%']
                    ],  

                    [
                        'attribute'=>'date_due', 
                        'format'=>'date',
                        'type'=>DetailView::INPUT_WIDGET,             
                        'widgetOptions'=>[
                            'class'=>DateControl::classname(),
                            'type'=>DateControl::FORMAT_DATE,  
                        ],   
                        'valueColOptions'=>['style'=>'width:30%']
                    ],   
                ],
            ],  
            
            [
                'attribute'=>'description', 
                'format'=>'html',
                'value'=>$model->description,
                'type'=>DetailView::INPUT_WIDGET, 
                'widgetOptions'=>[
                    'class'=> CKEditor::className(),
                    'editorOptions' => [
                        'preset' => 'full', // basic, standard, full
                        'inline' => false,
                        'filebrowserBrowseUrl' => 'browse-images',
                        'filebrowserUploadUrl' => 'upload-images',
                        'extraPlugins' => 'imageuploader',
                    ],                      
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
        'enableEditMode' => Yii::$app->user->can('update-note'),
    ]) ?>

</div>
