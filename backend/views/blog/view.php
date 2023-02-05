<?php
use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\select2\Select2;
use kartik\datecontrol\DateControl;
use bajadev\ckeditor\CKEditor;
/**
 * @var yii\web\View $this
 * @var backend\models\Blog $model
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Blogs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$create = Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'], ['class' => 'pull-right detail-button','style'=>'padding:0 5px']);
$counter = '<span class="label label-success"><i class="fa fa-eye"></i> : '.$model->view_counter.'</span>';

?>
<?php
$dom = new DOMDocument();
if(!empty($model->content)){
    libxml_use_internal_errors(true);
    $dom->loadHTML($model->content);
    $xpath = new DOMXPath($dom);

    foreach ($xpath->query("//img") as $node) {
        $node->setAttribute("class", "img-responsive");
    }

    $model->content = str_replace('%09', '', $dom->saveHtml());
}
?>
   

<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">Option</h3>
        <div class="pull-right" style="margin-right: 5px">
        <?= 
            $model->setPinUrl();
        ?>              
        </div>
        <div class="pull-right" style="margin-right: 5px">
        <?= 
            $model->setPublishUrl();
        ?>             
        </div>
    </div>
</div>

<div class="blog-view">

    <?= DetailView::widget([
        'model' => $model,
        'condensed' => false,
        'hover' => true,
        'mode' => Yii::$app->request->get('edit') == 't' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
        'panel' => [
            'heading' => $this->title.$create.' '.$counter,
            'type' => DetailView::TYPE_INFO,
        ],
        
        'attributes' => [
  
            [
                'columns' => [
                    [
                        'attribute'=>'title', 
                        'format'=>'html',
                        'valueColOptions'=>['style'=>'width:30%']
                    ],                              
                    [
                        'attribute'=>'author_id', 
                        'value'=>($model->author_id!=null) ? $model->author->title:'',
                        'type'=>DetailView::INPUT_SELECT2, 
                        'options' => ['id' => 'author_id', 'prompt' => '', 'disabled'=>false],
                        'items' => $authorList,
                        'widgetOptions'=>[
                            'class'=> Select2::className(),
                            'data'=>$authorList,
                        ],
                        'valueColOptions'=>['style'=>'width:30%']
                    ],   
                ],
            ], 
            
            [
                'columns' => [
                    [
                        'attribute'=>'category_id', 
                        'value'=>($model->category_id!=null) ? $model->category->title:'',
                        'type'=>DetailView::INPUT_SELECT2, 
                        'options' => ['id' => 'category_id', 'prompt' => '', 'disabled'=>false],
                        'items' => $categoryList,
                        'widgetOptions'=>[
                            'class'=> Select2::className(),
                            'data'=>$categoryList,
                        ],
                        'valueColOptions'=>['style'=>'width:30%']
                    ],                              
                    [
                        'attribute'=>'publish_status', 
                        'format'=>'html',
                        'value'=>($model->publish_status!=null) ? $model->getOnePublishStatus($model->publish_status):'',
                        'type'=>DetailView::INPUT_SELECT2, 
                        'options' => ['id' => 'publish_status', 'prompt' => '', 'disabled'=>false],
                        'items' => $publishList,
                        'widgetOptions'=>[
                            'class'=> Select2::className(),
                            'data'=>$publishList,
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
                    ],                                  
                    [
                        'attribute'=>'pinned_status', 
                        'format'=>'html',
                        'value'=>($model->pinned_status!=null) ? $model->getOnePinnedStatus($model->pinned_status):'',
                        'type'=>DetailView::INPUT_SELECT2, 
                        'options' => ['id' => 'pinned_status', 'prompt' => '', 'disabled'=>false],
                        'items' => $pinnedList,
                        'widgetOptions'=>[
                            'class'=> Select2::className(),
                            'data'=>$pinnedList,
                        ],
                        'valueColOptions'=>['style'=>'width:30%']
                    ], 
                ],
            ],            
               
            
            [
                'columns' => [
                    [
                        'attribute'=>'description', 
                        'format'=>'html',
                        'type'=>DetailView::INPUT_TEXTAREA,                    
                    ],                      
                    [
                        'attribute'=>'tags', 
                        'valueColOptions'=>['style'=>'width:30%']
                    ],                                
                ],
            ],              
            
            'cover',
//            [
//                'attribute'=>'tags', 
//                'value'=> Yii::$app->request->get('edit') == 't' ? $tagsFlip : $model->tags,
//                'type'=>DetailView::INPUT_SELECT2, 
//                'widgetOptions'=>[
//                    'class'=> Select2::className(),
//                    'data' => $tagList,
//                    'maintainOrder' => true,
//                    'options' => [
//                        'multiple' => true,
//                        'value' => $tagList,
//                    ],
//                    'pluginOptions' => [
//                        'tags' => true,
//                        'tokenSeparators' => [',',' '],
//                        'maximumInputLength' => 5,
//                    ],                    
//                ],              
//            ],            
  
            [
                'group'=>true,
                'rowOptions'=>['class'=>'default']
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
                        'extraPlugins' => 'imageuploader,youtube',
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
        'enableEditMode' => Yii::$app->user->can('update-blog'),
    ]) ?>

</div>
