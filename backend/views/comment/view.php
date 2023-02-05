<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var backend\models\Comment $model
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-view">

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
            'blog_id',
            'title',
            'email:email',
            'url:url',
            [
                'attribute'=>'content', 
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
                'attribute'=>'publish_status', 
                'format'=>'html',
                'value'=>($model->publish_status!=null) ? $model->publishStatus->getLabel():'',
                'type'=>DetailView::INPUT_DROPDOWN_LIST, 
                'options' => ['id' => 'publish_status', 'prompt' => ''],
                'items' => $publishList,
                'widgetOptions'=>[
                    'data'=>$publishList,
                ]                
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
        'enableEditMode' => Yii::$app->user->can('update-comment'),
    ]) ?>

</div>
