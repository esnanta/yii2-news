<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use bajadev\ckeditor\CKEditor;

/**
 * @var yii\web\View $this
 * @var backend\models\Page $model
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Pages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$create = Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'], ['class' => 'pull-right detail-button','style'=>'padding:0 5px']);
?>
<div class="page-view">

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
                'attribute'=>'page_type_id', 
                'value'=>($model->page_type_id!=null) ? $model->pageType->title:'',
                'type'=>DetailView::INPUT_DROPDOWN_LIST, 
                'options' => ['id' => 'page_type_id', 'prompt' => ''],
                'items' => $pageTypeList,
                'widgetOptions'=>[
                    'data'=>$pageTypeList,
                ]                
            ], 
            'title',
            'sequence',
            [
                'attribute'=>'description', 
                'format'=>'html',
                'type'=>DetailView::INPUT_TEXTAREA,                    
            ],  
            [
                'attribute'=>'content', 
                'format'=>'html',
                'value'=>$model->content,
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
                'attribute'=>'view_counter', 
                'type'=>DetailView::INPUT_HIDDEN,                    
            ],
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
                'type'=>DetailView::INPUT_HIDDEN,
            ],
            [
                'attribute'=>'updated_by',
                'type'=>DetailView::INPUT_HIDDEN,
            ], 
        ],
        'deleteOptions' => [
            'url' => ['delete', 'id' => $model->id],
        ],
        'enableEditMode' => Yii::$app->user->can('update-page'),
    ]) ?>

</div>
