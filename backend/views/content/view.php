<?php
use yii\helpers\Html;
use kartik\detail\DetailView;
use bajadev\ckeditor\CKEditor;
use kartik\widgets\FileInput;
/**
 * @var yii\web\View $this
 * @var backend\models\Content $model
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Contents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$create = Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'], ['class' => 'pull-right detail-button','style'=>'padding:0 5px']);
?>
<div class="content-view">

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
                'attribute' => 'image',
                'value' => ($model->getImageUrl()),
                'format' => ['image',['width'=>'150','height'=>'100']],

                'type'=>DetailView::INPUT_WIDGET, 
                'widgetOptions'=>[
                    'class'=> FileInput::classname(),
                ]           
            ],            
            
            [
                'attribute'=>'theme_id', 
                'value'=>$model->theme->title,
                'type'=>DetailView::INPUT_DROPDOWN_LIST, 
                'options' => ['id' => 'theme_id', 'prompt' => ''],
                'items' => $dataList,
                'widgetOptions'=>[
                    'data'=>$dataList,
                ]                
            ], 
            [
                'attribute'=>'title', 
                'type'=>DetailView::INPUT_TEXT,                    
            ],             
            //'title',
            'token',
            'icon',
            'label',
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
            
        ],
        'deleteOptions' => [
            'url' => ['delete', 'id' => $model->id],
        ],
        'enableEditMode' => Yii::$app->user->can('update-content'),
    ]) ?>

</div>
